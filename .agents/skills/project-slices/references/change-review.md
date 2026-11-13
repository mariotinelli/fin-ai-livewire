# Revisar requisito, condições ou filhas

Leia requisito aprovado, slices.md, condições, task.md e estado remoto atual de todas as filhas/relações afetadas. Compare significado, não bytes: mudança editorial não altera comportamento; funcional altera escopo/regra/aceite. Divergência remota não vira decisão automaticamente; apresente original, remoto e correção proposta.

Aplique [mudanças semânticas](../../vertical-slicing/references/semantic-changes.md) e [representação por estado](../../vertical-slicing/references/revision-application.md). Mostre antes/depois, critérios e CTs afetados, tarefas ainda válidas, estimativas, anexos, dependências e Sequencing. Preserve IDs das condições e histórico das revisões. Decisão de produto pertence ao responsável; atualizar requisito/pai exige a autorização correspondente, não apenas aprovação do slicing.

## Aplicar delta

Para não iniciadas, mostre atualização localizada. Iniciadas exigem discussão explícita do impacto e representação compatível; concluídas permanecem históricas, com nova tarefa de diferença quando necessária. Não reescreva aceite antigo como se a mudança sempre tivesse existido. Não afete tarefas fora do impacto.

Uma revisão só de condições/Word também apresenta o delta e destino QA; incorpore edição Word na fonte e gere nova revisão. Mudança editorial pode preservar anexo anterior mediante revisão semântica explícita, sem fingir documento novo. Mudança funcional exige condições/documento alinhados.

Após autorização do delta completo, use MCP e [publicação](publication.md), com conferência e reconciliação de operações incertas. Numeração e relações externas seguem suas referências próprias. Atualize task.md somente após readback, preservando IDs/caminhos, histórico e conteúdo não afetado.

**Concluído quando:** delta autorizado está conferido no remoto, condições/anexos estão alinhados e preservação das tarefas iniciadas/concluídas/alheias é demonstrável.
