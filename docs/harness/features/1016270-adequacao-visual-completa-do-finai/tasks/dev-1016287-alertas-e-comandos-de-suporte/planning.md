# Plano — DEV 1016287: alertas e comandos de suporte

## Identidade e decisão

- DEV [#1016287](https://redmine.remsoft.com.br/issues/1016287), pai [#1016270](https://redmine.remsoft.com.br/issues/1016270).
- Fontes: [task.md](task.md), [requisito](../../feature.md), [CT-014 a CT-016](../../slices/condicoes-teste-r002.md).
- Preparado em 20/11/2026 no pedido `$ralph 1016287`. Proposta apresentada na conversa e aprovada pelo usuário com “aprovado”. Execução Ralph com Codex e commits da fase autorizados, sem push e sem alteração de Redmine.

## Objetivo e limites

Adequar lista e detalhe de alertas, executor, sugestões, histórico e console de comandos à identidade FinAI. Preservar informações, filtros, busca, ordenação, paginação, estados, reconhecimento/resolução de alertas, execução/reexecução e proteções existentes por tipo, permissão e IP. Não criar operações, confirmações, páginas financeiras, dados demonstrativos de produção, temas adicionais ou integrações de IA. Aplicar confirmações e cancelamentos somente onde já existem.

## Estado inspecionado e estratégia

HEAD inicial `baa57e1`, árvore limpa. As fornecedoras 1016281–1016283 e 1016286 estão integradas: tema semântico `remsoft`, marca FinAI, estrutura responsiva, tabelas, filtros e modais compartilhados. Reutilizar essa base; não reconstruir navegação nem reformular gestão/perfil.

Quatro componentes class-based em `app/Livewire/Support/{SystemErrorAlerts/{Index,Show},ArtisanCommands/{Index,History}}.php` possuem views correspondentes e testes dedicados sob `tests/Feature/Livewire/Support`. `routes/support.php` mantém middleware de área de suporte, autorização por policy e restrição IP no executor. Manter rotas e regras de negócio.

As listas usam `x-ui.table draft-filters`, com `filterDraft` separado dos filtros aplicados, validação, limpeza e descarte no fechamento. Alertas mostram exceção/mensagem truncadas, severidade, status e acesso ao detalhe. O detalhe reúne resumo técnico em duas colunas, mensagem, contexto JSON e trace com rolagem. A mensagem atual preserva espaços sem garantir quebra de sequências extensas. Recompor hierarquia e distribuição dos dados, mantendo todos os campos, conteúdo técnico integral e ações condicionais de reconhecer/resolver.

O executor usa `x-ui.input.commands.autocomplete`, eventos Alpine existentes e execução por `$wire.executeCommand(commandInput)`. O autocomplete contém utilitário antigo `ring-opacity-5` e botão de execução somente com ícone; conferir nome acessível e foco na adaptação. Preservar busca/seleção de sugestões, setas, Enter, Escape, limpeza após envio e feedback isolado. O histórico permite abrir saída e reexecutar pela linha ou modal; preservar metadados, filtros, status e estados vazios. Melhorar composição e contraste do console e tratamento de comandos/saídas longas, com rolagem interna e controles sempre alcançáveis.

Arquivos prováveis: os quatro templates em `resources/views/livewire/support/{system-error-alerts,artisan-commands}`, `resources/views/components/ui/input/commands/autocomplete.blade.php` e, somente se necessário, componentes comuns consumidos nessas telas. `x-ui.details.card` já usa `min-w-0` e `break-all`; não alterar componente adequado sem necessidade demonstrada. Antes de alterar compartilhados, conferir consumidores e regressões em gestão, perfil e notificações. Não modificar classes PHP por conveniência visual. Se surgir mudança comportamental indispensável, justificar dentro do escopo e adicionar cobertura significativa no teste dedicado do responsável; estilo/layout não exigem testes novos. Não criar suíte permanente de browser.

## Referência visual e riscos

V01: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, inspecionada no planejamento. Aplicar linguagem comum às telas sem mockup próprio: fundo #F5F7F8, superfície branca, texto #172622, secundário #52615C, verde #145C46, borda #D6DFDB, destaque #E4F0E9, positivo #146345 e negativo #A12B36; Georgia nos títulos de destaque e system-ui no corpo; controles com raio 8px, painéis 16px e ritmo 4/8/16/24/32px. Usar tokens semânticos existentes e Tailwind 4; conferir contratos reais de `x-ui.*` na implementação local.

Riscos: mensagens, caminhos, URLs e linhas de saída sem espaços alargarem página/modal; truncamento impedir consulta completa; contraste insuficiente no console; sugestões encobertas; foco e botões finais sob navegação; alteração compartilhada afetar outras telas. Preservar UTF-8, nomes acessíveis, rótulos, foco visível e feedbacks atuais. A composição precisa corresponder ao design, além de cores.

## Baseline e verificadores

Contexto: raiz desta worktree, PowerShell, PHP 8.4.28 e Node 26.1.0, fora do executor. `composer show --direct` confirmou Laravel 13.40.0, Livewire 4.4.8, Pest 5.3.5, Agent 5.0.0 e Browser 5.2.0. package.json declara Tailwind 4, DaisyUI 5 e Playwright; Vite executado 8.3.6. Git Bash e Codex disponíveis. Lidas skills Livewire, Tailwind, componentes UI, Pest Agent e práticas de testes; consultada documentação versionada via Boost.

Baseline `composer quality:check` em PowerShell em 20/11/2026, encerrado com código 0: build e Prettier CSS aprovados; 1.905 testes PHP, 6.717 asserções, TIA fresh graph, 214.522ms; 271 testes JavaScript aprovados; auditorias Composer/npm sem vulnerabilidades; Pint aprovado; PHPStan sem erros; Rector dry-run sem alterações ou erros. O baseline usou TEMP/TMP herdados e passou; para a execução, manter o diretório específico abaixo, prevenindo colisões já observadas nas fornecedoras. Nenhum impedimento atual demonstrado. Não houve captura visual/interativa no planejamento; essa evidência pertence ao Dev e à Validação.

Comando obrigatório do gate Testes, preservando integralmente o agregado e propagando falha:

```powershell
$ErrorActionPreference = 'Stop'
$taskTempDirectory = Join-Path $env:LOCALAPPDATA 'Temp/finai-1016287-quality'
New-Item -ItemType Directory -Path $taskTempDirectory -Force | Out-Null
$env:TEMP = $taskTempDirectory
$env:TMP = $taskTempDirectory
composer quality:check
exit $LASTEXITCODE
```

O agregado inclui build, Prettier CSS, Pest paralelo com `--tia` e `phpunit-ci.xml`, testes JavaScript, auditorias Composer/npm, Pint em checagem, PHPStan e Rector dry-run. Todos são obrigatórios. Distinguir resultados executados e reaproveitados pelo TIA. Antes da primeira edição no Dev executar apenas `npm run build`, menor conferência aplicável já prevista; agregado e suíte completa ficam em Testes após revisão. Se editar PHP, rodar `vendor/bin/pint --dirty --format agent` e testes afetados com `--tia`.

Aprendizados operacionais das fornecedoras: TEMP/TMP próprios evitam colisão de stubs entre worktrees, sem apagar caches. Pint paralelo pode atingir limite interno de 120s; investigar proporcionalmente, sem remover o verificador. No script instalado existem dois `tail -c 12000` que podem cortar Unicode nos diagnósticos: preparar cópia no diretório Git, substituir somente ambos por `tail -n 80` e conferir diff antes da execução. Não alterar gates, guardas, hooks, permissões ou comandos aprovados.

Nas evidências de browser, `public/hot` já apontou para assets que não inicializam Alpine na aplicação de teste: se ocorrer, usar configuração Vite local ao processo de teste para consumir o build, preservando arquivo hot e servidor. Usar pt-BR no teste e transporte de argumentos que preserve aspas e UTF-8. Esperar assertivamente modal/conteúdo antes de capturar ou fechar. Capturas podem ser limpas pela chamada seguinte: preservar evidências úteis após cada chamada em diretório ignorado, por exemplo `storage/framework/testing/finai-1016287-evidence`, conferindo `git check-ignore`. Referenciá-las no resumo, nunca no campo `file=` do executor, que aceita somente fontes/testes alterados não ignorados, sem o próprio plano. Não repetir situações já falhas sem ajuste fundamentado.

## Fase 1 — Identidade FinAI no suporte

### Dev

1. Conferir instruções, Git e consumidores no próprio processo, executar build mínimo e preservar alterações anteriores.
2. Recompor lista/detalhe de alertas e resumo técnico; manter busca, filtros, ordenação, paginação, estados vazios/inválidos e ações condicionais de reconhecer/resolver. Mensagem, JSON, trace e metadados extensos continuam completos e consultáveis.
3. Adequar executor/autocomplete, histórico e modal de saída ao design, incluindo feedbacks, validação, status, processamento e ações de execução/reexecução já existentes. Manter eventos, bindings, regras e políticas, sem executar comandos perigosos.
4. Conferir todos os estados aplicáveis normal, hover, foco, ativo, desabilitado e carregamento; rótulos, nomes acessíveis, teclado, foco do modal e fechamento/cancelamento existentes.
5. Coletar evidências visuais/interativas com Pest Agent/Browser instalados, factories isoladas, fakes e comandos de teste já autorizados. Não criar usuários no banco da aplicação, instalar dependências implicitamente ou iniciar servidor. A aplicação é servida pelo Herd; respeitar mecanismos de teste existentes. Conferir a matriz e preservar evidências ignoradas.

### Validação — outro processo, somente leitura

- Conferir todos os critérios de task.md, R1/R2/R7/R8 e CA01/CA02/CA06/CA08/CA09 no suporte, CT-014 a CT-016. Comparar com V01 hierarquia, geometria, proporções, superfícies, paleta, tipografia, espaços, bordas, raios, sombras e estados.
- Conferir lista/detalhe de alertas, executor/histórico, sugestões, filtros e modal de saída em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080. Conferir transições 767/768 e 1024/1025 e lateral recolhida. Não pode haver rolagem horizontal da página nem controles encobertos; tabelas e blocos técnicos podem rolar internamente.
- Exercitar registros vazios, listas extensas, busca sem resultado, limpeza, rascunho/aplicação/descarte de filtros, paginação e ordenação. Conferir alertas abertos/reconhecidos/resolvidos, severidades, reconhecimento/resolução e feedbacks, sem criar confirmação ausente.
- Conferir sugestões por mouse/teclado, nenhuma sugestão, entrada vazia/inválida, envio permitido e processamento com fakes, histórico nos estados existentes, saída vazia/longa, metadados, abertura/fechamento e reexecução pela linha/modal. Conferir resultados/cancelamentos já existentes, sem comandos destrutivos.
- Conferir acesso permitido e negado por tipo, policy e IP através das fronteiras existentes; a apresentação não pode ampliar privilégios. Preservar sanitização, restrição de comandos/argumentos e dados sensíveis fora do histórico.
- Conferir rótulos, nomes acessíveis, foco visível/contido/restaurado, Escape, carregamento isolado e alcance dos controles após rolar. Mensagens, caminhos, URLs, JSON, trace e saída extensa devem permanecer legíveis e completos, incluindo sequências sem espaços. Conferir Unicode no arquivo/diff e no navegador, sem confundir exibição do terminal com corrupção.
- Se houver mudança compartilhada, conferir consumidores afetados de gestão, perfil e notificações. Não aceitar novas operações, destinos financeiros, dados fictícios de produto ou rótulos de armazenamento local/assistente simulado.
- Defeitos e evidências coletáveis pelo Dev recebem `rejected` com ação concreta; `blocked` exige dependência externa impeditiva demonstrada. O revisor não edita a entrega.

### Testes

Após Validação aprovada, executar integralmente o comando obrigatório e exigir encerramento com código 0. Preservar testes existentes e usar os quatro arquivos dedicados de suporte, policies, middleware de IP e executor como cobertura de regressão aplicável. Mudança comportamental exige cobertura significativa na fronteira responsável e execução afetada; não adicionar testes de classes CSS. Correção na implementação volta a Dev, Validação e Testes antes de Commit. Investigar falhas operacionais dentro da autorização e com limites finitos compatíveis, sem enfraquecer verificadores.

### Commit

Entrega coerente: `feat: adequa alertas e comandos de suporte à identidade FinAI (#1016287)`. Após revisão independente e verificadores aprovados, incluir somente fontes/testes da fase e resumo consolidado neste plano com entrega, evidências, verificações e resultado da revisão. Sem temporários, capturas ou trabalho alheio; sem push e sem alteração de Redmine.

## Execução após aprovação

Uma única execução do ralph.sh, com ajuste local de diagnóstico Unicode descrito, backend Codex e configuração de modelo/sandbox do CLI preservada; revisor somente leitura. Git Bash sem login, raiz desta worktree, caminho real deste plano, bloco completo em `--test-command`, `--test-shell powershell --timeout-seconds 3600`. Prazos internos também finitos e compatíveis; baseline externo não demonstra compatibilidade dentro do executor. Não ampliar acesso ou modificar configuração global após falha. Acompanhar o mesmo processo até encerramento e conferir `RALPH_FINISHED`, Git, commits e resumo consolidado.

## Recuperação operacional — 20/11/2026

A execução `run.Aipt6oL1` encerrou com código 1 no Dev antes de produzir resposta ou editar fontes: o CLI registrou falha de resolução de github.com, falha de transporte MCP e `workspace routing discovery failed` após cinco reconexões. Git permaneceu somente com este plano não rastreado; Validação, Testes e Commit não executados. O processo do executor encerrou e não houve commit.

Na investigação subsequente, DNS de github.com e chatgpt.com resolveu e consultas HTTPS voltaram a responder, inclusive GitHub pelo mesmo Git Bash. Essa nova evidência permite uma tentativa posterior após a falha transitória, mantendo invocação, modelo, permissões, verificadores e aprovação, sem alterar rede/configuração global. Persistência do erro de roteamento exige investigar especificamente o CLI/conectividade antes de outra tentativa; não repetir indefinidamente.


### Resultado Ralph — Identidade FinAI no suporte

- Entrega: Escape descarta a sugestão destacada. No navegador, Enter preservou “abo” com a lista fechada e aceitou “php artisan about” com a lista aberta. Em 360×800, o teclado alcançou os marcadores finais do contexto, do trace e da saída após sequências sem espaços, mantendo a largura da página em 360 px. As ações Reconhecer, Resolver, Fechar e Reexecutar ficaram alcançáveis após a rolagem. Escape devolveu o foco a Ver console. Dez capturas CT-014 a CT-016 e as medições estão em storage/framework/testing/finai-1016287-evidence/teclado-360.jsonl e no mesmo diretório. Build, Pint, 38 asserções no navegador e 67 testes de suporte com 299 asserções passaram.
- Validação: outro processo codex, revisão 5, aprovada para a versão testada.
- Testes: verificadores aprovados; relatórios privados da execução, fase 1.
