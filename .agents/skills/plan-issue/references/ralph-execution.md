# Executar pelo ralph.sh

O pacote `plan-issue` distribui um único executor Bash, [ralph.sh](../ralph.sh). `plan-issue` prepara o plano; a skill `ralph` inicia e acompanha esse arquivo. O script não depende de PHP ou Python. Exige Bash 3.2+, Git, utilitários usuais de shell e Codex CLI ou OpenCode autenticado. Isso não impõe linguagem ou framework ao projeto de destino.

Na raiz Git do projeto, use caminhos reais e argumentos entre aspas:

```bash
bash "/caminho/das/skills/plan-issue/ralph.sh" execute "/projeto/tasks/dev-123-exemplo/planning.md" --backend codex --test-command 'COMANDO_REVISADO_NO_PLANO' --test-shell bash
```

Substitua o comando pelos verificadores obrigatórios reais, propagando qualquer falha intermediária. `--backend opencode` usa OpenCode. `--test-shell` também aceita `pwsh`, `powershell` ou `cmd`; a disponibilidade depende do ambiente. Consulte `--help` para opções e limites. Use `--dry-run` para conferir a entrada sem chamar agentes, testar ou commitar; isso não demonstra que a implementação passou.

O plano continua Markdown livre. Passe os verificadores explicitamente quando sua estrutura variar. Como conveniência, sem `--test-command`, o script lê um único bloco de código sob um título `Baseline` e reconhece seu shell. Blocos ausentes, múltiplos ou ambíguos interrompem a execução, sem inventar testes. Agrupe todos os verificadores obrigatórios nesse comando; ele roda em cada fase.

## Responsabilidades durante a execução

Dev preserva Unicode de ponta a ponta: prefere edição direta e, quando usa comandos, confere entrada, transporte e gravação em UTF-8 para arquivos UTF-8. No Windows PowerShell, a codificação do pipe para um programa nativo pode ser ASCII mesmo com console UTF-8; qualquer ajuste deve ficar no processo, sem alterar configuração global. Preserve outra codificação quando documentada pelo projeto. Releia os textos gravados e o diff, incluindo mensagens e rótulos de acessibilidade, antes de concluir a alteração.

Validação confere esses textos contra o conteúdo esperado. UTF-8 válido não detecta uma letra já substituída por `?`, e exibição incorreta no terminal não comprova corrupção do arquivo. Não faça substituições globais de sinais legítimos nem conversões em massa. Corrupção comprovada volta ao Dev como ação requerida; recuperar letras perdidas exige restaurar o texto esperado, não apenas mudar a codificação.

O script chama um processo novo para Dev e outro para Validação. No Dev, Codex preserva a configuração do próprio CLI (`--codex-sandbox configured`, padrão), sem forçar `workspace-write`. Isso não herda automaticamente permissões da conversa. Uma escolha já autorizada pode ser passada com `--codex-sandbox workspace-write` ou `--codex-sandbox danger-full-access`; o executor nunca amplia acesso automaticamente após uma falha, não desativa aprovações e não modifica configuração global. O revisor Codex usa sempre `read-only`. OpenCode usa seus agentes `build` e `plan`, respeitando permissões configuradas.

Antes da primeira edição, o Dev faz uma conferência enxuta no próprio processo com o menor comando previsto que exercite a capacidade necessária (incluindo build quando aplicável). O agregado de qualidade e a suíte completa pertencem ao gate Testes, após implementação e revisão; não viram condição para começar o Dev. Se o plano indicar somente um agregado, inspecione seus passos para identificar a menor verificação aplicável já prevista. Bloqueio real dessa capacidade interrompe com comando e erro observados; falha funcional dentro do escopo é trabalho do Dev. Um baseline obtido em outro contexto de permissões não comprova compatibilidade dentro do executor.

Em qualquer atividade, aplique [tratamento de falhas](technical-inspection.md#tratar-falhas-durante-o-fluxo): diferencie defeito da entrega, problema operacional/resultado inconclusivo e impedimento real; investigue e resolva dentro do papel e da autorização existentes antes de interromper. O prazo externo do Ralph e os limites internos das ferramentas são configurações distintas e precisam ser compatíveis. Os testes completos continuam obrigatórios antes do Commit, com resultado concluído.

O revisor confere o código, critérios de aceite, evidências necessárias e a alegação de última fase. O script confere que arquivos não mudaram entre Validação, Testes e Commit. Essa correspondência técnica é responsabilidade do executor; o modelo não precisa transcrever hashes internos no relatório. Uma aprovação textual não comprova, sozinha, qualidade funcional ou visual.

O relatório de revisão usa `required_action` repetível para correções/evidências coletáveis e `external_dependency` somente para dependência realmente impeditiva, com observação, investigação e condição necessária. `approved` não admite nenhum desses campos; `rejected` exige ações e ausência de dependência impeditiva; `blocked` exige dependência e pode conter ações concomitantes. Findings indicam critério, esperado, observado e evidência, sem inventar requisitos. A revisão pode rejeitar a alegação de conclusão total do Dev; `finished=no` em uma fase intermediária não significa rejeição por si só.

Inconsistências reparáveis recebem uma única nova chamada de Validação sobre o mesmo conteúdo, para corrigir o relatório e sua classificação. Não se decide por palavras do resumo nem se converte bloqueio em aprovação. Falha de identidade/versão, alteração indevida ou relatório de outra chamada interrompe imediatamente. Relatório ainda inválido após reparo encerra como erro de protocolo, preservando trabalho. Rejeição válida devolve todas as ações ao Dev na mesma execução, mantendo os arquivos cumulativos da fase; coleta de evidência não exige mudança artificial na fonte. Toda correção passa por nova revisão e testes antes do commit.

O relatório do backend é texto delimitado, interpretado como dados, nunca executado. Testes e commit são comandos do script. Reprovação volta para Dev com os achados; o limite de tentativas vale apenas para esta execução. Não há gates separados de host ou diagnóstico, manifesto de aprovação ou máquina de estados para retomada.

O executor protege arquivos com alterações anteriores, confere os caminhos declarados pelo Dev e monta um índice separado para commitar somente a fase e seu resumo no plano. Preserva mudanças staged alheias, respeita hooks e não faz push. Não separa automaticamente hunks antigos de mudanças novas no mesmo arquivo; esse conflito precisa ser resolvido antes da execução.

`RALPH_STARTED` anuncia tarefa, backend e escolha de sandbox. `RALPH_PROGRESS` informa o gate; `RALPH_ACTIVITY` traz resumos concretos publicados pelo backend durante o trabalho; `RALPH_HEARTBEAT` indica processo ativo com o último resumo observado, sem alegar novidade. `RALPH_COMMIT` informa um commit criado e `RALPH_FINISHED` encerra com código de saída, fase e gate. O orquestrador apresenta início, avanços e encerramento claramente no chat, sem depender de ler os logs para acompanhar o trabalho.

Os processos recebem a instrução de emitir comentários de progresso com prefixo `RALPH_UPDATE`, identificador desta chamada e resumo em uma linha. O script extrai somente esse prefixo da saída corrente, remove segredos reconhecidos e repetições e o publica como `RALPH_ACTIVITY`. Esses relatos são informação de andamento, nunca aprovação de gate nem comandos executáveis. A resposta final continua no bloco delimitado próprio. Nenhum agente adicional ou arquivo de estado é necessário.

Logs privados ficam no diretório Git indicado por `RALPH_LOGS`, fora do pacote e dos documentos do projeto. Compartilhe apenas os trechos necessários, com segredos removidos. São diagnósticos da execução, sem protocolo de recuperação. A interrupção tenta encerrar os processos iniciados; processos nativos ou destacados podem exigir conferência antes de executar novamente.

Uma falha preserva o trabalho e exige inspecionar Git, plano e causa. Não execute duas cópias sobre a mesma árvore. Falha de hook mantém Commit pendente; alterar a implementação exige nova revisão e testes. Não apague mudanças para reiniciar. Uma entrega já concluída pode ser verificada sem criar commit vazio.

**Concluído quando:** execução encerrou, commits e verificações foram conferidos, ou o gate pendente está identificado com seu impedimento.
