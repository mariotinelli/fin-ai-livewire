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

Leia [execução](../plan-issue/references/ralph-execution.md). Localize `ralph.sh` no pacote `plan-issue` instalado ao lado desta skill. Use Codex CLI por padrão ou OpenCode conforme a escolha do usuário. Preserve o modelo configurado, salvo escolha explícita. O ambiente precisa de Bash, Git e do CLI selecionado; no Windows, use Git Bash ou WSL com as ferramentas no mesmo ambiente.

Na raiz do projeto, inicie uma única execução com o caminho real do plano e os comandos obrigatórios já revisados. Reaproveite o shell desses comandos. O executor faz somente Dev → Validação → Testes → Commit: uma sessão implementa, outra revisa, e o script executa os testes e cria o commit. Host, diagnóstico e investigação pertencem ao gate que precisar deles.

A skill não implementa a fase em paralelo nem substitui o script por uma sequência manual. Uma indisponibilidade do executor permanece como impedimento concreto.

**Concluído quando:** processo iniciado uma vez, com backend, plano, verificadores e identificador da execução conhecidos.

## 3. Acompanhar

Acompanhe o mesmo processo por leituras incrementais, com esperas de até 60 segundos. Use `RALPH_PROGRESS` para comunicar fase e gate atuais; informe commits somente após `RALPH_COMMIT`. Um período sem saída pede consultar o processo, sem iniciar outra cópia.

Reprovação em Validação ou Testes volta para Dev e repete a revisão e os testes. Outro processo realiza a revisão, sem editar a implementação. Evidência funcional ou visual necessária e indisponível impede aprovação. Os testes usam o comando aprovado, sem aceitar um comando substituto inventado pelo executor.

Em falha, consulte somente os relatórios relevantes e informe causa e próximo passo, sem expor segredos. Respeite hooks e preserve trabalho existente. Se o processo interromper, confira Git, código e plano antes de nova execução; não prometa retomada automática. Mudanças não commitadas preexistentes são protegidas pelo script e podem exigir separar o trabalho antes de continuar. Não apague estado, locks ou arquivos para forçar avanço.

**Concluído quando:** execução acompanhada até encerramento ou impedimento identificado, sem execução duplicada ou gate declarado por suposição.

## 4. Encerrar

Confira resultado do processo, commits e resumo consolidado por fase no próprio planning.md. Informe mudanças, verificações, commits e limitações. Código de saída diferente de zero deixa o fluxo pendente; revisão do código não substitui testes não executados. Uma correção na implementação volta para Dev, Validação e Testes antes do Commit.

**Concluído quando:** entregas e commits conferidos ou impedimento exposto com o trabalho preservado.
