# Inspeção técnica proporcional à tarefa

## Entender a mudança

Leia instruções, tarefa, requisito, domínio e decisões pertinentes. Inspecione implementação, configuração e testes relacionados; siga o caminho até o comportamento observável. Fundamente afirmações decisivas em arquivos/símbolos ou resultados executados, distinguindo evidência de hipótese.

Antes de propor alteração global ou em componente compartilhado, confira consumidores e efeitos fora da tarefa. Preserve seu comportamento; impacto que amplia escopo volta ao responsável. Escolhas técnicas dentro do escopo pertencem à implementação.

**Concluído quando:** o estado atual e o alcance da solução têm evidência suficiente para planejar a entrega, sem transformar hipóteses em fatos.

## Identificar a validação aplicável

Para UI, leia a referência e compare a implementação existente. Identifique telas/estados, adaptações aprovadas e o que o outro agente deverá conferir na Validação. Use capacidades já disponíveis; investigue um impedimento de ferramenta quando ele ocorrer, sem exigir uma etapa prévia de diagnóstico do host.

A fundação visual compartilhada pertence à Feature fornecedora, cuja capacidade implementada precede o trabalho de negócio dependente. Preserve o inventário de telas existentes e seu comportamento; não invente páginas futuras para demonstrar navegação. Ausência de um mockup individual não exclui tela existente do alinhamento aprovado.

**Concluído quando:** critérios funcionais/visuais e dependências têm uma forma de conferência identificada, ou a evidência/decisão que falta está explícita.

## Identificar testes e observar baseline

Inspecione scripts e configuração para descobrir os verificadores obrigatórios do projeto, incluindo os passos reais de comandos agregados. Confira comandos, runtime e pré-requisitos necessários para executá-los; se houver variante de checagem, use-a para preservar fontes.

Observe o baseline uma vez e registre o que passou, falhou ou não foi executado. Identifique saídas/temporários apenas na medida necessária para executar com segurança e preservar arquivos alheios. Não exigir inventário de toda saída possível, reprodução artificial de falhas ou prova de execução em vários hosts para concluir planejamento comum.

**Concluído quando:** o plano identifica comandos reais, resultados iniciais e impedimentos relevantes, sem acrescentar gates de host ou diagnóstico.
