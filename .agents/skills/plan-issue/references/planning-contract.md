# Contrato de planning.md

Um único plano ao lado de task.md liga planejamento e execução. Escreva em pt-BR, com estrutura proporcional ao trabalho:

- Identidade e fontes: filha/pai, task.md e requisito.
- Objetivo, estado atual inspecionado, escopo e limites.
- Arquitetura, estratégia e riscos fundamentados no repositório.
- Baseline observado: verificadores, comandos reproduzíveis, shell/runtime e resultados reais.
- Fases com dependências, objetivo, mudança esperada, arquivos prováveis e critérios de aceite.

O baseline é observado uma vez no planejamento; não é um gate extra nem autorização para aceitar falhas. Comandos devem propagar falhas intermediárias e usar modo de checagem quando disponível. O plano não exige headings ou fences exatos: o handoff passa os verificadores explicitamente ao executor, conforme [execução](ralph-execution.md).

## Preparar os quatro gates por fase

Cada fase fornece o necessário para o Ralph seguir Dev → Validação → Testes → Commit:

| Gate | Conteúdo necessário no plano |
| --- | --- |
| Dev | Mudança esperada, limites, comportamento a preservar e critérios de aceite. |
| Validação | O que outro agente deve conferir na qualidade e na aderência, incluindo referências e critérios visuais quando aplicáveis. |
| Testes | Comandos e resultados esperados dos verificadores obrigatórios reais do projeto. |
| Commit | Entrega coerente que pode ser registrada depois de Validação e Testes aprovados. |

Cada comportamento de task.md tem fase e evidência de aceite. Use testes existentes quando adequados; não invente comandos nem cobertura. Caminhos prováveis não obrigam editar todos os arquivos.

Reprovação em Validação ou Testes volta para Dev; uma correção passa novamente por Validação e Testes. Host, diagnóstico, investigação e captura são atividades quando necessárias dentro desses gates. Não planeje etapas obrigatórias separadas para elas, nem exija simular toda falha de ferramenta antes de escrever o plano.

## UI e dificuldades de execução

Quando o aceite envolver UI, identifique fonte visual, telas/estados, adaptações aprovadas e comparação esperada na Validação. Use ferramentas disponíveis; não imponha biblioteca, comando de captura ou matriz maior que a entrega exige. Screenshot sozinho não prova fidelidade.

Verificação necessária sem ferramenta/evidência disponível permanece pendente no gate correspondente. Diferencie falha da aplicação de impedimento de ambiente; não enfraqueça o aceite. Preserve fontes, baselines e evidências úteis; use temporários adequados e feche somente processos que iniciou.

## Revisão, resultado e planos existentes

O desenvolvedor revisa o plano; plan-issue não implementa nem cria commits. Solicitar a execução ao Ralph autoriza os commits das fases, respeitadas instruções explícitas do projeto, sem autorizar push.

O Ralph consolida o resultado no próprio plano uma vez antes do commit: entrega, verificações realizadas e revisor/resultado. Impedimento material pode ser registrado quando interromper o trabalho. Não exigir hash do próprio commit, tabela de microtransições ou arquivo operacional.

Planos antigos continuam legíveis sem conversão automática. Verificações antigas de host/diagnóstico são realizadas no gate pertinente, mantendo aceite e evidências; mudança material de escopo exige nova revisão.

**Concluído quando:** todas as fases têm entrega e aceite verificáveis, pontos de revisão por outro agente e comandos de teste conhecidos; o conteúdo foi revisado e impedimentos reais estão visíveis.
