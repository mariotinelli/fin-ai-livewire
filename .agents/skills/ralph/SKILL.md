---
name: ralph
description: Orquestre o ralph.sh para executar uma filha DEV por Dev, Validação, Testes e Commit. Use para iniciar e acompanhar um planning.md revisado com Codex CLI ou OpenCode.
---

# Ralph

Leia [comunicação](references/user-communication.md) uma vez por conversa. Responda em pt-BR. Esta skill prepara, inicia e acompanha o executor; os processos chamados pelo script implementam e revisam as fases.

## 1. Preparar

Receba o ID DEV e localize task.md, requisito pai e planning.md. Confira instruções do projeto, Git e alterações existentes, preservando trabalho alheio. ID ausente/ambíguo ou filha QA/Study impede execução. Não altere Redmine.

Sem plano, siga [novo planejamento](references/new-planning.md); para mudança material, siga [substituição](references/replace-planning.md). Apresente o plano para revisão e reutilize autorizações já dadas ao mesmo conteúdo. Solicitar a execução do plano revisado autoriza os commits das fases, respeitadas instruções explícitas do projeto, sem novas perguntas por gate e sem push. Aprovar apenas o conteúdo não inicia execução.

**Concluído quando:** DEV e plano revisado identificados, execução autorizada e trabalho existente conhecido.

## 2. Iniciar o executor

Leia [execução](../plan-issue/references/ralph-execution.md). Localize `ralph.sh` no pacote `plan-issue` instalado ao lado desta skill. Use Codex CLI por padrão ou OpenCode conforme a escolha do usuário. Preserve o modelo e as permissões configurados no CLI. As permissões desta conversa não são automaticamente herdadas por outro processo; escolha explícita de sandbox deve estar dentro da autorização conhecida. Uma falha não autoriza ampliar acesso, ignorar aprovações ou modificar configuração global. O ambiente precisa de Bash, Git e do CLI selecionado; no Windows, use Git Bash ou WSL com as ferramentas no mesmo ambiente.

Na raiz do projeto, inicie uma única execução com o caminho real do plano e os comandos obrigatórios já revisados. Reaproveite o shell desses comandos. O executor faz somente Dev → Validação → Testes → Commit: uma sessão implementa, outra revisa, e o script executa os testes e cria o commit. Host, diagnóstico e investigação pertencem ao gate que precisar deles.

Antes da chamada, avise no chat qual DEV e backend vai executar. Ao receber `RALPH_STARTED`, confirme claramente **Ralph iniciado — DEV <ID> · <backend> · Fase 1 · Dev** e os próximos gates. O Dev confere os verificadores críticos do plano no próprio processo antes da primeira edição, para identificar impedimentos de execução no início; isso não cria gate nem substitui os testes da implementação.

A skill não implementa a fase em paralelo nem substitui o script por uma sequência manual. Uma indisponibilidade do executor permanece como impedimento concreto.

**Concluído quando:** processo iniciado uma vez, com backend, permissões, plano e verificadores conhecidos, e início comunicado ao usuário.

## 3. Acompanhar

Acompanhe a saída do mesmo processo por leituras incrementais, com esperas de até 60 segundos. Use `RALPH_PROGRESS` para fase/gate e `RALPH_ACTIVITY` para resumir o progresso concreto: o que foi constatado ou concluído e o trabalho atual. Por exemplo, quando observado: **Ralph em execução — Fase 1 · Dev. Tema e marca ajustados; agora está adaptando o dashboard.** Informe commits somente após `RALPH_COMMIT`.

`RALPH_HEARTBEAT` confirma atividade e carrega o último resumo observado; não demonstra um avanço novo. Não substitua o resumo por “ainda não há resultado dessa etapa”, não invente percentual nem repita mensagens como se fossem novidades. Quando o host exigir atualização sem novidade, ancore-a no último progresso concreto e na etapa que continua em execução. Um período sem saída pede consultar o mesmo processo, sem iniciar outra cópia. Consulte logs somente para investigar um impedimento ou esclarecer ausência inesperada de atividade; não faça varreduras repetidas dos logs para montar o acompanhamento normal.

Reprovação em Validação ou Testes volta para Dev e repete a revisão e os testes. Outro processo realiza a revisão, sem editar a implementação. Evidência funcional ou visual necessária e indisponível impede aprovação. Os testes usam o comando aprovado, sem aceitar um comando substituto inventado pelo executor.

Em falha, consulte somente os relatórios relevantes e informe causa e próximo passo, sem expor segredos. Respeite hooks e preserve trabalho existente. Se o processo interromper, confira Git, código e plano antes de nova execução; não prometa retomada automática. Mudanças não commitadas preexistentes são protegidas pelo script e podem exigir separar o trabalho antes de continuar. Não apague estado, locks ou arquivos para forçar avanço.

**Concluído quando:** execução acompanhada até encerramento ou impedimento identificado, sem execução duplicada ou gate declarado por suposição.

## 4. Encerrar

Confira `RALPH_FINISHED`, resultado do processo, commits e resumo consolidado por fase no próprio planning.md. Anuncie **Ralph concluído** ou **Ralph interrompido**, identificando o gate, causa observada, trabalho preservado e gates não executados. Informe mudanças, verificações, commits e limitações. Código de saída diferente de zero deixa o fluxo pendente; revisão do código não substitui testes não executados. Uma correção na implementação volta para Dev, Validação e Testes antes do Commit. Erros como `EPERM` não comprovam sozinhos a causa: diferencie mensagem observada de hipótese sobre permissões, dependências ou shell.

**Concluído quando:** entregas e commits conferidos ou impedimento exposto com o trabalho preservado.
