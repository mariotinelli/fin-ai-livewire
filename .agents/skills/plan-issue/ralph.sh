#!/usr/bin/env bash
# Standalone executor. Requires Bash 3.2+, Git, awk, sed and an agent CLI.
set -eo pipefail
umask 077

usage() {
  cat <<'USAGE'
Uso: bash ralph.sh execute <planning.md> [opções]
  --backend codex|opencode     Padrão: codex
  --test-command COMANDO      Comando já aprovado no plano
  --test-shell bash|pwsh|powershell|cmd
  --model MODELO              Opcional; preserva o modelo configurado por padrão
  --codex-sandbox MODO        configured (padrão), workspace-write ou danger-full-access
  --max-attempts N            Tentativas por fase nesta execução (padrão: 6)
  --timeout-seconds N         Limite por processo (padrão: 1800)
  --dry-run                   Confere entrada e comando, sem chamar agentes
Não há push, gates de host/diagnóstico, Python ou executor PHP.
USAGE
}
die() { printf 'RALPH_ERROR: %s\n' "$*" | redact >&2; exit 1; }
contains() {
  wanted=$1; shift
  for candidate in "$@"; do [ "$candidate" != "$wanted" ] || return 0; done
  return 1
}
redact() {
  sed -E 's/([Aa]uthorization:[[:space:]]*([Bb]earer|[Bb]asic)[[:space:]]+)[^[:space:]"]+/\1[REDACTED]/g; s/(([Aa][Pp][Ii][_ -]?[Kk][Ee][Yy]|[Pp]assword|[Aa]ccess[_ -]?[Tt]oken|[Xx]-[Rr]edmine-[Aa]pi-[Kk]ey)["'\'']?[[:space:]]*[:=][[:space:]]*["'\'']?)[^[:space:],"'\''}]+/\1[REDACTED]/g'
}
progress() {
  printf 'RALPH_PROGRESS: fase=%s gate=%s status=%s\n' "$phase_number" "$1" "$2"
  case "$2" in
    running) status_text='em andamento' ;;
    ready) status_text='pronto para revisão' ;;
    approved) status_text='aprovada' ;;
    passed) status_text='verificadores passaram' ;;
    completed) status_text='concluído' ;;
    rejected) status_text='ajustes solicitados' ;;
    failed) status_text='falhou' ;;
    done|nothing-to-commit) status_text='sem nova mudança para commit' ;;
    *) status_text=$2 ;;
  esac
  printf 'Ralph — %s · Fase %s · %s: %s\n' "$task_label" "$phase_number" "$1" "$status_text"
}
current_pid=''
plan_temporary=''
stop_child() {
  if [ -n "$current_pid" ]; then
    kill -TERM -- "-$current_pid" 2>/dev/null || kill -TERM "$current_pid" 2>/dev/null || true
    sleep 0.2
    kill -KILL -- "-$current_pid" 2>/dev/null || kill -KILL "$current_pid" 2>/dev/null || true
    wait "$current_pid" 2>/dev/null || true
    current_pid=''
  fi
}
cleanup() {
  exit_code=$?
  stop_child
  if [ -n "$plan_temporary" ] && [ -f "$plan_temporary" ]; then rm -f -- "$plan_temporary"; fi
  if [ -n "${runtime:-}" ]; then
    for temporary_log in "$runtime"/*.raw "$runtime"/*-final.txt "$runtime"/report.txt; do
      if [ -f "$temporary_log" ] && [ ! -L "$temporary_log" ]; then
        redact < "$temporary_log" > "$temporary_log.sanitized"
        mv -f -- "$temporary_log.sanitized" "$temporary_log"
      fi
    done
  fi
  if [ "${execution_started:-no}" = yes ]; then
    printf 'RALPH_FINISHED: exit_code=%s fase=%s gate=%s\n' "$exit_code" "$phase_number" "$gate"
    if [ "$exit_code" -eq 0 ]; then
      printf 'Ralph encerrado com sucesso — %s.\n' "$task_label"
    else
      printf 'Ralph interrompido — %s · Fase %s · %s. Trabalho preservado.\n' "$task_label" "$phase_number" "$gate"
    fi
  fi
}
trap cleanup EXIT
trap 'printf "RALPH_ERROR: execução interrompida; trabalho preservado\n" >&2; exit 130' INT TERM

if [ "${1:-}" = '--help' ] || [ "${1:-}" = '-h' ]; then usage; exit 0; fi
[ "${1:-}" = execute ] && [ $# -ge 2 ] || { usage >&2; exit 64; }
plan_input=$2
shift 2
backend=codex
test_command=''
test_shell=bash
explicit_shell=no
max_attempts=6
timeout_seconds=1800
model=''
codex_sandbox=configured
dry_run=no
while [ $# -gt 0 ]; do
  case "$1" in
    --dry-run) dry_run=yes; shift ;;
    --backend|--test-command|--test-shell|--model|--codex-sandbox|--max-attempts|--timeout-seconds)
      [ $# -ge 2 ] || die "Opção sem valor: $1"
      case "$1" in
        --backend) backend=$2 ;;
        --test-command) test_command=$2 ;;
        --test-shell) test_shell=$2; explicit_shell=yes ;;
        --model) model=$2 ;;
        --codex-sandbox) codex_sandbox=$2 ;;
        --max-attempts) max_attempts=$2 ;;
        --timeout-seconds) timeout_seconds=$2 ;;
      esac
      shift 2 ;;
    *) die "Opção desconhecida: $1" ;;
  esac
done
case "$backend" in codex|opencode) ;; *) die 'Backend não suportado.' ;; esac
case "$codex_sandbox" in configured|workspace-write|danger-full-access) ;; *) die 'Sandbox Dev não suportado.' ;; esac
[ "$backend" = codex ] || [ "$codex_sandbox" = configured ] || die '--codex-sandbox só se aplica ao Codex.'
case "$test_shell" in bash|pwsh|powershell|cmd) ;; *) die 'Shell de testes não suportado.' ;; esac
case "$max_attempts" in ''|*[!0-9]*) die 'As tentativas devem ser um inteiro positivo.' ;; esac
case "$timeout_seconds" in ''|*[!0-9]*) die 'O prazo deve ser um inteiro positivo.' ;; esac
[ "$max_attempts" -gt 0 ] && [ "$timeout_seconds" -gt 0 ] || die 'Os limites devem ser positivos.'
for tool in git awk sed sort cmp mktemp; do command -v "$tool" >/dev/null 2>&1 || die "Executável indisponível: $tool"; done
if command -v cygpath >/dev/null 2>&1; then plan_input=$(cygpath -u "$plan_input"); fi
[ -f "$plan_input" ] && [ ! -L "$plan_input" ] || die 'planning.md não encontrado ou é um link simbólico.'
plan=$(cd -P -- "$(dirname -- "$plan_input")" && printf '%s/%s' "$PWD" "$(basename -- "$plan_input")")
root=$(git rev-parse --show-toplevel) || die 'Execute dentro do repositório da tarefa.'
root=$(cd -P -- "$root" && pwd)
case "$plan" in "$root/"*"/planning.md") ;; *) die 'O planning.md deve pertencer ao repositório atual.' ;; esac
[ -f "$(dirname -- "$plan")/task.md" ] || die 'task.md deve existir ao lado do plano.'
cd -- "$root"
plan_relative=${plan#"$root/"}
if [ -z "$test_command" ]; then
  baseline=$(awk '
    /^#+[[:space:]]+[Bb]aseline([[:space:]]|$)/ { section=1; next }
    section && /^#+[[:space:]]/ { exit }
    section && /^[[:space:]]*\140\140\140/ {
      if (!fence) {
        fence=1; count++; lang=$0; sub(/^[[:space:]]*\140\140\140/, "", lang);
        if (count==1) print lang;
      } else { fence=0 }
      next
    }
    section && fence && count==1 { print }
    END { if (count!=1 || fence) exit 1 }
  ' "$plan") || die 'Baseline ambíguo; informe --test-command conforme o plano aprovado.'
  language=$(printf '%s\n' "$baseline" | sed -n '1p' | tr -d '\r')
  test_command=$(printf '%s\n' "$baseline" | sed '1d')
  if [ "$explicit_shell" = no ]; then
    case "$language" in
      ''|bash|sh|shell) test_shell=bash ;;
      pwsh|powershell) test_shell=$language ;;
      cmd|bat) test_shell=cmd ;;
      *) die 'Shell do baseline desconhecido; informe --test-command e --test-shell.' ;;
    esac
  fi
fi
[ -n "$(printf '%s' "$test_command" | tr -d '[:space:]')" ] || die 'Informe um comando de testes aprovado com --test-command.'
head_before=$(git rev-parse HEAD) || die 'O repositório precisa de um commit inicial.'
index_before=$(git write-tree) || die 'O índice Git precisa estar sem conflitos.'
if [ "$dry_run" = yes ]; then
  printf 'RALPH_DRY_RUN: backend=%s plan=%s shell=%s\n' "$backend" "$plan_relative" "$test_shell"
  exit 0
fi
case "$backend" in
  codex) agent_bin=${RALPH_CODEX_BIN:-codex} ;;
  opencode) agent_bin=${RALPH_OPENCODE_BIN:-opencode} ;;
esac
command -v "$agent_bin" >/dev/null 2>&1 || die "CLI indisponível: $backend"
task_label=$(basename -- "$(dirname -- "$plan")")
phase_number=1
gate=Dev
execution_started=yes
printf 'RALPH_STARTED: tarefa=%s backend=%s codex_sandbox=%s\n' "$task_label" "$backend" "$codex_sandbox"
printf 'Ralph iniciado — %s · %s. Fase 1 · Dev: conferindo o repositório.\n' "$task_label" "$backend"
git_directory=$(git rev-parse --absolute-git-dir)
[ ! -L "$git_directory/remsoft-ralph" ] || die 'Diretório de execução inseguro.'
mkdir -p -- "$git_directory/remsoft-ralph"
runtime=$(mktemp -d "$git_directory/remsoft-ralph/run.XXXXXXXX")
printf 'RALPH_LOGS: %s\n' "$runtime"
invocation=0
phase_number=1
stdin_path=/dev/null

file_hash() {
  if [ -L "$1" ]; then
    printf 'link:'; readlink -- "$1" | git hash-object --stdin
  elif [ -f "$1" ]; then
    git hash-object --no-filters -- "$1"
  else
    printf 'missing\n'
  fi
}
snapshot() {
  skip_plan=${2:-no}
  while IFS= read -r -d '' file; do
    if [ "$skip_plan" = yes ] && [ "$file" = "$plan_relative" ]; then continue; fi
    printf '%s %q\n' "$(file_hash "$file")" "$file"
  done < <(git ls-files --cached --others --exclude-standard -z) | LC_ALL=C sort > "$1"
}
protected_paths=()
protected_hashes=()
while IFS= read -r -d '' file; do
  if [ "$file" = "$plan_relative" ] || contains "$file" "${protected_paths[@]}"; then continue; fi
  protected_paths+=("$file")
  protected_hashes+=("$(file_hash "$file")")
done < <(git diff --name-only -z HEAD; git ls-files --others --exclude-standard -z)
plan_hash=$(file_hash "$plan_relative")
guard() {
  [ "$(git rev-parse HEAD)" = "$head_before" ] && [ "$(git write-tree)" = "$index_before" ] || die 'HEAD ou índice alterado fora do gate Commit; trabalho preservado.'
  [ "$(file_hash "$plan_relative")" = "$plan_hash" ] || die 'O plano foi alterado durante a execução; revise antes de continuar.'
  p=0
  while [ "$p" -lt "${#protected_paths[@]}" ]; do
    [ "$(file_hash "${protected_paths[$p]}")" = "${protected_hashes[$p]}" ] || die "Trabalho preexistente alterado: ${protected_paths[$p]}"
    p=$((p + 1))
  done
}
owned_changes() {
  owned=()
  while IFS= read -r -d '' file; do
    if ! contains "$file" "${protected_paths[@]}" && ! contains "$file" "${owned[@]}"; then owned+=("$file"); fi
  done < <(git diff --name-only -z HEAD; git ls-files --others --exclude-standard -z)
}
poll_activity() {
  for activity_stream in "$stdout_file.raw" "$stderr_file.raw"; do
    activity_summary=$(awk -v prefix="RALPH_UPDATE $token " '
      { gsub(/\033\[[0-9;]*[[:alpha:]]/, ""); sub(/\r$/, "") }
      index($0, prefix)==1 { summary=substr($0, length(prefix)+1) }
      END { if (summary!="") { gsub(/[[:cntrl:]]/, " ", summary); print summary } }
    ' "$activity_stream" | redact | awk '{ print substr($0, 1, 600) }')
    [ -n "$activity_summary" ] || continue
    if [ "$activity_stream" = "$stdout_file.raw" ]; then
      [ "$activity_summary" != "$stdout_activity" ] || continue
      stdout_activity=$activity_summary
    else
      [ "$activity_summary" != "$stderr_activity" ] || continue
      stderr_activity=$activity_summary
    fi
    [ "$activity_summary" != "$last_activity" ] || continue
    last_activity=$activity_summary
    printf 'RALPH_ACTIVITY: fase=%s gate=%s resumo=%s\n' "$phase_number" "$gate" "$last_activity"
  done
}
run_command() {
  label=$1; shift
  stdout_file="$runtime/$label.out"
  stderr_file="$runtime/$label.err"
  # Monitor a process group where Bash provides one; do not change agent permissions.
  set -m
  "$@" < "$stdin_path" > "$stdout_file.raw" 2> "$stderr_file.raw" &
  current_pid=$!
  set +m
  started=$(date +%s)
  heartbeat=$started
  polled=$started
  stdout_activity=''; stderr_activity=''; last_activity=''
  while kill -0 "$current_pid" 2>/dev/null; do
    now=$(date +%s)
    if [ "$monitor_activity" = yes ] && [ $((now - polled)) -ge 2 ]; then
      poll_activity
      polled=$now
    fi
    if [ $((now - started)) -ge "$timeout_seconds" ]; then
      stop_child
      redact < "$stdout_file.raw" > "$stdout_file"
      redact < "$stderr_file.raw" > "$stderr_file"
      rm -f -- "$stdout_file.raw" "$stderr_file.raw"
      die 'Tempo limite atingido; código e relatórios preservados.'
    fi
    if [ $((now - heartbeat)) -ge 30 ]; then
      printf 'RALPH_HEARTBEAT: fase=%s gate=%s ultimo_resumo=%s\n' "$phase_number" "$gate" "$last_activity"
      heartbeat=$now
    fi
    sleep 0.2
  done
  if wait "$current_pid"; then command_code=0; else command_code=$?; fi
  current_pid=''
  if [ "$monitor_activity" = yes ]; then poll_activity; fi
  redact < "$stdout_file.raw" > "$stdout_file"
  redact < "$stderr_file.raw" > "$stderr_file"
  # Keep raw stdout only until the backend's final protocol has been read.
  rm -f -- "$stderr_file.raw"
}
parse_report() {
  awk -v begin="RALPH_BEGIN $token" -v end="RALPH_END $token" '
    { sub(/\r$/, "") }
    $0==begin { active=1; finished=0; block=""; next }
    active && $0==end { active=0; finished=1; next }
    active { block=block $0 "\n" }
    END { if (active || !finished) exit 1; printf "%s", block }
  ' "$1" > "$runtime/report.txt" || die 'O backend não produziu um relatório final completo.'
  result_status=''; result_phase=''; result_summary=''; result_finished=''; result_message=''; result_revision=''
  reported=()
  seen='|'
  while IFS= read -r line || [ -n "$line" ]; do
    [ -n "$line" ] || continue
    case "$line" in *=*) ;; *) die 'Linha inválida no relatório do backend.' ;; esac
    key=${line%%=*}; value=${line#*=}
    if [ "$key" != file ]; then
      case "$seen" in *"|$key|"*) die 'Campo duplicado no relatório do backend.' ;; esac
      seen="$seen$key|"
    fi
    case "$key" in
      status) result_status=$value ;;
      phase) result_phase=$value ;;
      summary) result_summary=$value ;;
      finished) result_finished=$value ;;
      commit_message) result_message=$value ;;
      revision) result_revision=$value ;;
      file)
        case "$value" in ''|/*|[A-Za-z]:*|*\\*|*$'\t'*|*$'\r'*|.|..) die 'Caminho inválido no relatório Dev.' ;; esac
        case "/$value/" in */../*|*/./*) die 'Caminho fora do escopo.' ;; esac
        contains "$value" "${protected_paths[@]}" && die 'A DEV declarou um arquivo protegido.'
        [ "$value" != "$plan_relative" ] || die 'A DEV não deve editar o plano.'
        reported+=("$value") ;;
      *) die 'Campo desconhecido no relatório do backend.' ;;
    esac
  done < "$runtime/report.txt"
  [ -n "$result_phase" ] && [ -n "$result_summary" ] || die 'Relatório sem fase ou resultado.'
  case "$result_finished" in yes|no) ;; *) die 'Conclusão da fase não informada.' ;; esac
  if [ "$gate" = Dev ]; then
    case "$result_status" in ready|done|blocked) ;; *) die 'Resultado Dev inválido.' ;; esac
    [ -n "$result_message" ] || die 'Mensagem de commit ausente.'
  else
    case "$result_status" in approved|rejected|blocked) ;; *) die 'Resultado de Validação inválido.' ;; esac
    [ "$result_phase" = "$development_phase" ] && [ "$result_finished" = "$development_finished" ] || die 'Validação de outra fase.'
    [ -z "$result_revision" ] || [ "$result_revision" = "$revision" ] || die 'Validação de outra versão.'
  fi
}
call_agent() {
  invocation=$((invocation + 1))
  token="$(basename -- "$runtime")-$invocation"
  prompt="$runtime/$invocation-prompt.md"
  final="$runtime/$invocation-final.txt"
  {
    printf 'RALPH_GATE=%s\nRALPH_TOKEN=%s\nRALPH_RUN_PHASE=%s\nRALPH_PLAN=%s\nRALPH_REVISION=%s\n' "$gate" "$token" "$phase_number" "$plan" "${revision:-none}"
    printf 'Você é um processo interno do executor. Não invoque a skill ralph, ralph.sh ou outro orquestrador. Leia instruções do projeto, task.md, requisito pai e o plano. Use somente o escopo aprovado. Não use MCP/trackers, não leia credenciais e não faça stage, commit, reset, push ou mudanças na configuração Git. Não edite planning.md; o script consolida o resultado. Preserve estes arquivos preexistentes:\n'
    printf '%q\n' "${protected_paths[@]}"
    printf 'Durante o trabalho, publique comentários de progresso em uma linha começando por RALPH_UPDATE %s seguida de um espaço e um resumo concreto em pt-BR: o que constatou/concluiu e o que está fazendo. Informe início, avanços relevantes e impedimentos, sem percentual inventado, comandos brutos, credenciais ou repetir que ainda não há resultado. Use esse prefixo SOMENTE nos comentários de progresso; na resposta final use apenas o bloco de conclusão abaixo.\n' "$token"
    if [ -s "$runtime/feedback.txt" ]; then cat "$runtime/feedback.txt"; fi
    if [ "$gate" = Dev ]; then
      if [ "$attempt" -eq 1 ]; then
        printf 'ANTES de editar arquivos nesta fase, faça somente uma conferência ENXUTA de execução no próprio processo, com o menor comando já previsto no plano. Agregado de qualidade e suíte completa pertencem ao gate Testes após a revisão, sem virar condição para começar o Dev ou gate de baseline verde. Se o plano só indicar um agregado, inspecione seus passos e use a menor verificação aplicável já prevista. Informe a conferência nos comentários de progresso antes e depois de executá-la.\n'
      fi
      printf 'Shell dos verificadores aprovados: %s\nComando obrigatório do gate Testes APÓS implementação e revisão (referência, não pré-requisito integral do Dev; respeite o shell):\n%s\n' "$test_shell" "$test_command"
      printf 'Implemente apenas a próxima fase ainda necessária. Considere código e commits, sem assumir que mudanças preexistentes não commitadas são entregas. Corrija falhas dentro do escopo, sem enfraquecer testes/aceite. Ao terminar, status ready e finished yes apenas se esta for a última fase necessária. Use status done e nenhum file apenas se TODO o plano já estiver entregue em commits e não houver mudança. Impedimento externo ou decisão de produto usa blocked. Liste todos os arquivos da fase alterados nesta execução, inclusive correções anteriores; nenhum planning.md. Não se autoaprove.\n'
    else
      printf 'Você é OUTRO agente revisor SOMENTE LEITURA. Não edite arquivos nem execute comandos mutantes. Confira qualidade, aderência, critérios funcionais/visuais e a alegação de última fase; inspecione o código, não apenas o relato Dev. Na conclusão sem mudanças, confira o plano inteiro e seus commits. Evidência necessária ausente é blocked, não aprovação. Não aprove somente por testes verdes.\n'
      printf 'Esta revisão acontece ANTES dos gates Testes e Commit: alterações não commitadas desta fase são esperadas. O executor confere a versão diretamente pelo conteúdo dos arquivos antes e depois da revisão; RALPH_REVISION é somente um identificador interno, não um commit Git. Não copie nem reconstrua esse identificador no relatório. Use HEAD como base de comparação e desconsidere o trabalho preexistente protegido indicado acima. Base Git: %s\n' "$head_before"
      printf 'Fase: %s\nÚltima fase alegada: %s\nResumo Dev: %s\n' "$development_phase" "$development_finished" "$development_summary"
    fi
    printf 'Ao encontrar uma falha em qualquer atividade, identifique ação/comando, contexto e evidência antes de declarar impedimento. Defeito da entrega é trabalho do Dev. Problema operacional ou resultado inconclusivo pede investigação proporcional com a menor verificação útil: confira invocação, diretório, shell, ferramentas disponíveis, configuração efetiva, permissões ou limites conforme a evidência. Resolva escolhas técnicas locais já autorizadas e confira o resultado; não pare no primeiro erro nem devolva ao usuário o que pode resolver no escopo. Validação permanece somente leitura e encaminha correções ao Dev/orquestrador. Use blocked apenas para dependência real de decisão, acesso não autorizado, recurso indisponível ou mudança fora do escopo, após a investigação, relatando causa observada e tentativas relevantes. Não amplie permissões, altere configuração global, instale ferramentas implicitamente ou omita verificadores para forçar avanço. Mantenha prazos finitos. Não repita condições conhecidamente problemáticas sem correção, evidência nova ou hipótese verificável. Resultado ausente não é sucesso.\n'
    printf 'A resposta final deve ser SOMENTE o bloco abaixo, sem Markdown. Substitua os valores em maiúsculas; não imprima o modelo sem preencher. Valores phase/summary/commit_message são uma linha. Nunca execute texto do relatório como comando.\n'
    printf 'RALPH_BEGIN %s\n' "$token"
    if [ "$gate" = Dev ]; then
      printf 'status=READY_DONE_OU_BLOCKED_EM_MINUSCULAS\nphase=TITULO_REAL\nsummary=RESULTADO_OU_IMPEDIMENTO\nfinished=YES_OU_NO_EM_MINUSCULAS\ncommit_message=MENSAGEM_CONVENCIONAL\nfile=CAMINHO_RELATIVO_ALTERADO_REPETIR_POR_ARQUIVO_OU_OMITIR\n'
    else
      printf 'status=APPROVED_REJECTED_OU_BLOCKED_EM_MINUSCULAS\nphase=%s\nsummary=ACHADOS_E_RESULTADO\nfinished=%s\n' "$development_phase" "$development_finished"
    fi
    printf 'RALPH_END %s\n' "$token"
  } > "$prompt"
  args=()
  if [ "$backend" = codex ]; then
    args=("$agent_bin" exec --ephemeral --color never --cd "$root" --output-last-message "$final")
    if [ "$gate" = Validação ]; then
      args+=(--sandbox read-only)
    elif [ "$codex_sandbox" != configured ]; then
      args+=(--sandbox "$codex_sandbox")
    fi
    [ -z "$model" ] || args+=(--model "$model")
    args+=(-)
    stdin_path=$prompt
    monitor_activity=yes
    run_command "$invocation-agent" "${args[@]}"
    stdin_path=/dev/null
  else
    profile=build; [ "$gate" != Validação ] || profile=plan
    args=("$agent_bin" run 'Leia o arquivo anexado e responda somente com o relatório final solicitado.' --format default --dir "$root" --agent "$profile")
    [ -z "$model" ] || args+=(--model "$model")
    args+=(--file "$prompt")
    monitor_activity=yes
    run_command "$invocation-agent" "${args[@]}"
    # Default output preserves the final plain-text block; no JSON parser is required.
    sed $'s/\033\\[[0-9;]*[[:alpha:]]//g' "$stdout_file.raw" > "$final"
  fi
  monitor_activity=no
  rm -f -- "$stdout_file.raw"
  [ "$command_code" -eq 0 ] || die 'Backend encerrou com falha; consulte os logs privados.'
  [ -f "$final" ] && [ ! -L "$final" ] || die 'Backend sem resposta final válida.'
  parse_report "$final"
  redact < "$final" > "$runtime/$invocation-result.log"
  rm -f -- "$final"
}
record_result() {
  plan_temporary=$(mktemp "$(dirname -- "$plan")/.ralph.XXXXXXXX")
  cat "$plan" > "$plan_temporary"
  {
    printf '\n\n### Resultado Ralph — %s\n\n' "$development_phase"
    printf -- '- Entrega: %s\n' "$development_summary"
    printf -- '- Validação: outro processo %s, revisão %s, aprovada para a versão testada.\n' "$backend" "$invocation"
    printf -- '- Testes: verificadores aprovados; relatórios privados da execução, fase %s.\n' "$phase_number"
  } | redact >> "$plan_temporary"
  mv -f -- "$plan_temporary" "$plan"
  plan_temporary=''
  plan_hash=$(file_hash "$plan_relative")
}
touch "$runtime/feedback.txt"
while [ "$phase_number" -le 100 ]; do
  attempt=1
  : > "$runtime/feedback.txt"
  while [ "$attempt" -le "$max_attempts" ]; do
    guard
    snapshot "$runtime/before-dev"
    gate=Dev; progress "$gate" running
    call_agent
    guard
    snapshot "$runtime/after-dev"
    owned_changes
    development_status=$result_status
    development_phase=$result_phase
    development_summary=$result_summary
    development_finished=$result_finished
    development_message=$result_message
    development_files=("${reported[@]}")
    [ "$development_status" != blocked ] || die "Dev impedido: $development_summary"
    progress "$gate" "$development_status"
    if [ "$development_status" = done ]; then
      [ "$development_finished" = yes ] && [ "${#owned[@]}" -eq 0 ] && cmp -s "$runtime/before-dev" "$runtime/after-dev" || die 'Conclusão Dev incompatível com mudanças sem commit.'
    else
      : > "$runtime/changed-paths"
      for file in "${owned[@]}"; do [ "$file" = "$plan_relative" ] || printf '%q\n' "$file" >> "$runtime/changed-paths"; done
      [ -s "$runtime/changed-paths" ] || die 'Nenhuma mudança nova de implementação; não assumir trabalho preexistente.'
      : > "$runtime/reported-paths"
      for file in "${development_files[@]}"; do printf '%q\n' "$file" >> "$runtime/reported-paths"; done
      LC_ALL=C sort "$runtime/changed-paths" > "$runtime/changed-sorted"
      LC_ALL=C sort "$runtime/reported-paths" > "$runtime/reported-sorted"
      cmp -s "$runtime/changed-sorted" "$runtime/reported-sorted" || die 'Arquivos declarados não correspondem às mudanças da fase.'
    fi
    revision=$(git hash-object --stdin < "$runtime/after-dev")
    gate=Validação; progress "$gate" running
    call_agent
    guard
    snapshot "$runtime/after-review"
    cmp -s "$runtime/after-dev" "$runtime/after-review" || die 'Validação alterou arquivos; nenhum commit foi autorizado.'
    [ "$result_status" != blocked ] || die "Validação independente impedida: $result_summary"
    if [ "$result_status" = rejected ]; then
      printf 'Validação rejeitada. Corrija o escopo desta fase: %s\n' "$result_summary" | redact > "$runtime/feedback.txt"
      progress "$gate" rejected
      attempt=$((attempt + 1)); continue
    fi
    progress "$gate" approved
    gate=Testes; progress "$gate" running
    case "$test_shell" in
      bash) run_command "tests-$invocation" bash -c "$test_command" ;;
      pwsh|powershell) run_command "tests-$invocation" "$test_shell" -NoProfile -NonInteractive -Command "$test_command" ;;
      cmd) run_command "tests-$invocation" cmd.exe /d /s /c "$test_command" ;;
    esac
    rm -f -- "$stdout_file.raw"
    guard
    snapshot "$runtime/after-tests"
    cmp -s "$runtime/after-dev" "$runtime/after-tests" || die 'Os testes alteraram fontes/documentos; não haverá commit.'
    if [ "$command_code" -ne 0 ]; then
      { printf 'Testes falharam. Corrija a implementação sem enfraquecer o verificador. Diagnóstico:\n'; tail -c 12000 "$stdout_file" "$stderr_file"; } | redact > "$runtime/feedback.txt"
      progress "$gate" failed
      attempt=$((attempt + 1)); continue
    fi
    progress "$gate" passed
    gate=Commit; progress "$gate" running
    if [ "$development_status" = done ]; then progress "$gate" nothing-to-commit; exit 0; fi
    snapshot "$runtime/tested-source" yes
    record_result
    guard
    snapshot "$runtime/source-before-commit" yes
    cmp -s "$runtime/tested-source" "$runtime/source-before-commit" || die 'Fonte mudou depois dos testes.'
    commit_index="$runtime/commit-index"
    GIT_INDEX_FILE="$commit_index" git read-tree HEAD
    for file in "${development_files[@]}" "$plan_relative"; do GIT_INDEX_FILE="$commit_index" git --literal-pathspecs add -A -- "$file"; done
    expected_tree=$(GIT_INDEX_FILE="$commit_index" git write-tree)
    snapshot "$runtime/validated-commit"
    run_command "commit-$invocation" env "GIT_INDEX_FILE=$commit_index" git commit -m "$development_message"
    rm -f -- "$stdout_file.raw"
    [ "$command_code" -eq 0 ] || die 'Commit pendente: Git/hook recusou a operação. Código, índice original e resumo preservados.'
    [ "$(git rev-parse 'HEAD^{tree}')" = "$expected_tree" ] || die 'Hook alterou a árvore do commit; pare para revisão, sem rollback automático.'
    snapshot "$runtime/after-commit"
    cmp -s "$runtime/validated-commit" "$runtime/after-commit" || die 'Hook alterou fontes; não prossiga sem revisar e testar.'
    for file in "${development_files[@]}" "$plan_relative"; do git --literal-pathspecs reset -q HEAD -- "$file"; done
    head_before=$(git rev-parse HEAD)
    index_before=$(git write-tree)
    rm -f -- "$commit_index"
    progress "$gate" completed
    printf 'RALPH_COMMIT: %s\n' "$head_before"
    if [ "$development_finished" = yes ]; then exit 0; fi
    phase_number=$((phase_number + 1))
    break
  done
  [ "$attempt" -le "$max_attempts" ] || die 'Limite de tentativas atingido; trabalho e relatórios preservados.'
done
die 'Limite de fases atingido; confira o plano e os relatórios.'
