# Contrato de planning.md

Um único plano ao lado de task.md liga planejamento e execução. Escreva em pt-BR, com estrutura proporcional ao trabalho:

- Identidade e fontes: filha/pai, task.md e requisito.
- Objetivo, estado atual inspecionado, escopo e limites.
- Arquitetura, estratégia e riscos fundamentados no repositório.
- Baseline observado: verificadores, comandos reproduzíveis, shell/runtime e resultados reais.
- Fases com dependências, objetivo, mudança esperada, arquivos prováveis e critérios de aceite.

O baseline é observado uma vez no planejamento; não é um gate extra nem autorização para aceitar falhas. Comandos devem propagar falhas intermediárias e usar modo de checagem quando disponível. O plano não exige headings ou fences exatos: o handoff passa os verificadores explicitamente ao executor, conforme [execução](ralph-execution.md).

Registre o contexto em que o baseline foi obtido. Um resultado fora do processo executor não comprova compatibilidade de permissões dentro dele. Identifique a menor conferência de execução aplicável ao Dev, entre os comandos já previstos, separando-a do agregado e da suíte completa obrigatórios no gate Testes. Não exija uma suíte completa verde antes da implementação nem crie fase ou gate adicional. Trate falhas observadas conforme [investigação proporcional](technical-inspection.md#tratar-falhas-durante-o-fluxo), registrando correções de invocação e impedimentos reais. Não deixe o executor repetir condições já problemáticas sem uma ação fundamentada. Teste interrompido continua sem resultado, sem ser declarado aprovado.

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

### Apresentar o plano e receber a decisão

Apresente a proposta na própria conversa, em linguagem direta, antes de pedir aprovação. Cubra objetivo e limites, fases e mudanças previstas, critérios de aceite, como serão validados/testados e dependências ou impedimentos relevantes. A apresentação deve permitir avaliar o plano sem abrir o arquivo. Inclua o link de planning.md para os detalhes técnicos; caminho, anúncio de arquivo criado, lista de gates ou relatório de baseline sozinhos não apresentam o plano.

Comece pela proposta. Depois, resuma as verificações observadas separando sucesso, falha e não execução, com o impacto real para o próximo passo. Um timeout não comprova defeito funcional. Termine com uma pergunta clara sobre a proposta apresentada, indicando se a aprovação dará início ao Ralph no contexto do pedido atual. Criar o arquivo ou enviar seu caminho não demonstra revisão/aprovação pelo usuário. Se outro processo preparou o arquivo, o agente principal é responsável por apresentar a proposta e receber a decisão.

Interprete aprovação conforme o pedido já feito: no fluxo de execução de uma DEV pelo Ralph, “aprovado o plano”, “pode seguir” ou equivalente após a apresentação autorizam iniciar o executor e os commits das fases, respeitadas instruções explícitas do projeto, sem push. Não exija uma segunda confirmação nem uma frase específica como “execute o Ralph”. Se o usuário pediu somente planejamento, análise ou para aguardar, mantenha esse limite; a aprovação nesse contexto não inicia implementação. Reutilize autorizações válidas para o mesmo conteúdo; mudança material precisa ser apresentada para nova decisão.

Depois da aprovação no fluxo de execução, confirme o próximo passo com ação: por exemplo, “Plano aprovado. Vou iniciar o Ralph com Codex na DEV 123.” Inicie o processo e confirme seu início quando observado. Evite encerrar com uma exigência de comando adicional ou uma explicação burocrática das regras da skill.

`plan-issue` prepara e apresenta o plano, sem implementar nem criar commits. Quando chamado pelo Ralph, devolve o resultado ao orquestrador, que continua o pedido de execução após a decisão do usuário.

O Ralph consolida o resultado no próprio plano uma vez antes do commit: entrega, verificações realizadas e revisor/resultado. Impedimento material pode ser registrado quando interromper o trabalho. Não exigir hash do próprio commit, tabela de microtransições ou arquivo operacional.

Planos antigos continuam legíveis sem conversão automática. Verificações antigas de host/diagnóstico são realizadas no gate pertinente, mantendo aceite e evidências; mudança material de escopo exige nova revisão.

**Concluído quando:** todas as fases têm entrega e aceite verificáveis, pontos de revisão por outro agente e comandos de teste conhecidos; a proposta foi apresentada na conversa, a decisão é conhecida e impedimentos reais estão visíveis.
