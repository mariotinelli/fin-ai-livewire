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

Um resultado inicial incompleto ou uma falha operacional pede a investigação proporcional abaixo. Corrigir a invocação e repetir somente a verificação afetada não cria outro baseline ou gate. Registre o comando reproduzível, seu contexto e o que permanece sem conclusão; não transfira ao executor a repetição de condições que já falharam sem uma ação fundamentada.

**Concluído quando:** o plano identifica comandos reais, resultados iniciais e impedimentos relevantes, sem acrescentar gates de host ou diagnóstico.

## Tratar falhas durante o fluxo

Esta regra vale para planejamento e para atividades dos quatro gates, em qualquer linguagem ou ferramenta. Antes de concluir que o trabalho está impedido, identifique o comando/ação que falhou, o contexto e a evidência disponível. Diferencie:

- **Defeito da entrega:** o comportamento ou aceite falhou. Corrija no Dev e repita Validação e Testes; preserve expectativas e verificadores obrigatórios.
- **Problema operacional ou resultado inconclusivo:** investigue com a menor verificação útil. Confira a invocação, diretório, shell, ferramenta/dependências disponíveis, configuração efetiva, permissões e limites somente na medida que a evidência exigir. Resolva escolhas técnicas locais dentro da autorização existente e confira o resultado; não devolva automaticamente ao usuário problemas que o agente pode resolver. Uma correção de invocação sem mudança de escopo não pede nova aprovação do plano. Limites de processos devem continuar finitos e compatíveis com o trabalho.
- **Impedimento real:** a solução depende de decisão ausente, acesso não autorizado, recurso indisponível ou mudança fora do escopo. Depois da investigação proporcional, pare a atividade dependente com causa observada, impacto, trabalho preservado, tentativas relevantes e o próximo passo específico.

Respeite o papel atual: Validação permanece somente leitura; correções voltam para o responsável no Dev ou para o orquestrador quando forem da invocação. Não amplie permissões, altere configuração global, instale ferramentas implicitamente, enfraqueça o aceite ou remova verificadores para forçar avanço. Uma mensagem de erro sozinha não prova sua causa. Ausência de resultado nunca equivale a sucesso.

Repetição só faz sentido após uma correção, evidência nova ou hipótese verificável; não rode novamente as mesmas condições conhecidamente problemáticas para então declarar o mesmo impedimento. Mantenha investigação e correção dentro da atividade que falhou, sem gate de host, checklist universal, estado paralelo ou simulação obrigatória de erros.

**Concluído quando:** a atividade teve resultado conferido após a correção, ou o impedimento específico foi demonstrado sem interromper prematuramente o restante do trabalho independente.
