---
name: ralph
description: Orquestre o ralph.sh para executar uma filha DEV por Dev, Validação, Testes e Commit. Use para iniciar e acompanhar um planning.md revisado com Codex CLI ou OpenCode.
---

# Ralph

Leia [comunicação](references/user-communication.md) uma vez por conversa. Responda em pt-BR. Esta skill prepara, inicia e acompanha o executor; os processos chamados pelo script implementam e revisam as fases.

## 1. Preparar

Receba o ID DEV e localize task.md, requisito pai e planning.md. Confira instruções do projeto, Git e alterações existentes, preservando trabalho alheio. ID ausente/ambíguo ou filha QA/Study impede execução. Não altere Redmine.

Sem plano, siga [novo planejamento](references/new-planning.md); para mudança material, siga [substituição](references/replace-planning.md). Para plano novo ou alterado materialmente, apresente a proposta na conversa antes de pedir aprovação, conforme [apresentação e decisão](../plan-issue/references/planning-contract.md#apresentar-o-plano-e-receber-a-decisão). Um link ou anúncio de planning.md criado não substitui essa apresentação.

No fluxo de execução pelo Ralph, a aprovação do plano apresentado permite iniciar o executor e os commits das fases, respeitadas instruções explícitas do projeto e sem push. Responda com o próximo passo e prossiga; não peça confirmação adicional nem exija “execute o Ralph”. Reutilize autorizações válidas para o mesmo conteúdo. Se o usuário pediu apenas planejamento/análise ou para aguardar, preserve esse limite.

**Concluído quando:** DEV e plano revisado identificados, execução autorizada e trabalho existente conhecido.

## 2. Iniciar o executor

Leia [execução](../plan-issue/references/ralph-execution.md). Localize `ralph.sh` no pacote `plan-issue` instalado ao lado desta skill. Use Codex CLI por padrão ou OpenCode conforme a escolha do usuário. Preserve o modelo e as permissões configurados no CLI. As permissões desta conversa não são automaticamente herdadas por outro processo; escolha explícita de sandbox deve estar dentro da autorização conhecida. Uma falha não autoriza ampliar acesso, ignorar aprovações ou modificar configuração global. O ambiente precisa de Bash, Git e do CLI selecionado; no Windows, use Git Bash ou WSL com as ferramentas no mesmo ambiente.

Na raiz do projeto, inicie uma única execução com o caminho real do plano e os comandos obrigatórios já revisados. Reaproveite o shell desses comandos. O executor faz somente Dev → Validação → Testes → Commit: uma sessão implementa, outra revisa, e o script executa os testes e cria o commit. Host, diagnóstico e investigação pertencem ao gate que precisar deles.

Antes de iniciar, confira os problemas operacionais já observados no plano conforme [tratamento de falhas](../plan-issue/references/technical-inspection.md#tratar-falhas-durante-o-fluxo). Resolva a invocação/contexto dentro da autorização existente e registre o ajuste reproduzível, preservando verificadores, aceite e aprovação válida; um ajuste operacional sem mudança de escopo não exige outra aprovação. Não inicie uma nova rodada nas mesmas condições conhecidamente problemáticas sem uma ação fundamentada. Prazos internos e externos precisam ser finitos e compatíveis.

Antes da chamada, avise no chat qual DEV e backend vai executar. Ao receber `RALPH_STARTED`, confirme claramente **Ralph iniciado — DEV <ID> · <backend> · Fase 1 · Dev** e os próximos gates. Antes de editar, o Dev faz somente a menor conferência de execução aplicável já prevista no plano. O agregado de qualidade e a suíte completa ficam no gate Testes, após implementação e revisão; não são condição para começar o Dev.

A skill não implementa a fase em paralelo nem substitui o script por uma sequência manual. Uma indisponibilidade do executor permanece como impedimento concreto.

**Concluído quando:** processo iniciado uma vez, com backend, permissões, plano e verificadores conhecidos, e início comunicado ao usuário.

## 3. Acompanhar

Acompanhe a saída do mesmo processo por leituras incrementais, com esperas de até 60 segundos. Use `RALPH_PROGRESS` para fase/gate e `RALPH_ACTIVITY` para resumir o progresso concreto: o que foi constatado ou concluído e o trabalho atual. Informe commits somente após `RALPH_COMMIT`.

Enquanto a execução estiver ativa, **cada mensagem de acompanhamento** começa com o prefixo inteiro em negrito: **Ralph iniciado — DEV <ID> · <backend> · Fase <n> · <gate>**. Apresente o backend como Codex ou OpenCode e atualize fase/gate conforme observado. Mantenha todos os identificadores em cada mensagem, inclusive quando continua no mesmo gate; não alterne para aberturas como “Ralph segue”, “O Dev continua” ou frases sem o prefixo. Na linha abaixo, escreva o resumo concreto fora do negrito. Exemplo de formato, somente com fatos observados:

**Ralph iniciado — DEV 123 · Codex · Fase 1 · Dev**

Tema e marca ajustados; agora está adaptando o dashboard e conferindo a acessibilidade.

`RALPH_HEARTBEAT` confirma atividade e carrega o último resumo observado; não demonstra um avanço novo. Não substitua o resumo por “ainda não há resultado dessa etapa”, não invente percentual nem repita mensagens como se fossem novidades. Quando o host exigir atualização sem novidade, ancore-a no último progresso concreto e na etapa que continua em execução. Um período sem saída pede consultar o mesmo processo, sem iniciar outra cópia. Consulte logs somente para investigar um impedimento ou esclarecer ausência inesperada de atividade; não faça varreduras repetidas dos logs para montar o acompanhamento normal.

Reprovação em Validação ou Testes volta para Dev na mesma execução e repete a revisão e os testes. Outro processo realiza a revisão, sem editar a implementação. Defeitos e evidências coletáveis pelo Dev são ações requeridas (`rejected`); a restrição somente leitura do revisor não os transforma em bloqueio externo. `blocked` exige dependência externa impeditiva demonstrada. Um relatório contraditório recebe uma tentativa de reparo dentro da Validação, sem editar a entrega; persistindo, encerra como falha de protocolo. Os testes usam o comando aprovado, sem aceitar um comando substituto inventado pelo executor.

Em falha, consulte somente os relatórios relevantes e aplique [investigação proporcional](../plan-issue/references/technical-inspection.md#tratar-falhas-durante-o-fluxo) antes de concluir que existe impedimento. Resolva problemas operacionais locais já autorizados; defeitos da entrega voltam ao Dev e dependências externas reais são explicitadas com causa observada, tentativas e próximo passo específico, sem expor segredos. Respeite hooks e preserve trabalho existente. Se o processo interromper, confira Git, código e plano antes de nova execução; não prometa retomada automática. Mudanças não commitadas preexistentes são protegidas pelo script e podem exigir separar o trabalho antes de continuar. Não apague estado, locks ou arquivos para forçar avanço.

**Concluído quando:** execução acompanhada até encerramento ou impedimento identificado, sem execução duplicada ou gate declarado por suposição.

## 4. Encerrar

Confira `RALPH_FINISHED`, resultado do processo, commits e resumo consolidado por fase no próprio planning.md. No prefixo em negrito do encerramento, troque “iniciado” por “concluído” ou “interrompido”, preservando DEV, backend, fase e gate. Informe causa observada, trabalho preservado, gates não executados, mudanças, verificações, commits e limitações. Código de saída diferente de zero deixa o fluxo pendente; revisão do código não substitui testes não executados. Uma correção na implementação volta para Dev, Validação e Testes antes do Commit. Erros como `EPERM` não comprovam sozinhos a causa: diferencie mensagem observada de hipótese sobre permissões, dependências ou shell.

**Concluído quando:** entregas e commits conferidos ou impedimento exposto com o trabalho preservado.
