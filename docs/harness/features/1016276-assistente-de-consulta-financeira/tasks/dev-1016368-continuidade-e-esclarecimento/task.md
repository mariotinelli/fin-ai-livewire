# [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Continuidade e esclarecimento

## Identidade e fontes

- Filha: [#1016368](https://redmine.remsoft.com.br/issues/1016368); papel: DEV; status remoto conferido: New.
- Pai: [Assistente de consulta financeira — #1016276](https://redmine.remsoft.com.br/issues/1016276); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **21**; pai espelha 17.
- Estimativa: **3,5h**. Estimativa proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Assistente de consulta financeira - Totais mensais por tipo e categoria — #1016365](https://redmine.remsoft.com.br/issues/1016365).
- Condições da Feature: [CT-001–CT-024, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016276 - Condições de testes.docx>), [anexo #3365 da QA #1016369](https://redmine.remsoft.com.br/attachments/download/3365/1016276%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação, execução de QA e chamada de IA não realizadas neste fluxo.

## Entrega

Permitir continuar uma consulta em linguagem natural sem repetir o assunto inteiro e completar uma pergunta pendente ao responder ao esclarecimento, mantendo apenas contexto claro da própria conta e consultando novamente os registros atuais.

## Escopo e limites

Continuação e esclarecimento completam o mesmo diálogo de interpretação: o usuário fornece o que muda ou falta na consulta. Cada consulta anterior já deve recusar interpretação insegura e falhas com honestidade. Esta tarefa acrescenta a resolução da referência e da resposta curta, sem assumir a integridade ou autorização que pertencem a todos os canais.

## Critérios de aceite

- Após consultar despesas de uma categoria no mês corrente, “e no mês passado?” mantém assunto, tipo e categoria claros e muda o período solicitado, declarando os filtros aplicados.
- Interpretar continuações compreensíveis das consultas mensais, de dia/intervalo e recentes quando a referência tiver correspondência segura, usando a conversa da própria conta, inclusive após retomá-la em outro navegador.
- Não tratar assunto antigo, troca de assunto ou referência com múltiplos sentidos como certeza; pedir esclarecimento antes de apresentar número.
- Tipo, categoria, período, intervalo invertido ou referência inseguros geram pergunta clara sobre a informação faltante. A resposta seguinte completa a consulta pendente com o recorte confirmado, sem exigir repetir toda a pergunta.
- Categoria inexistente ou incompatível não é criada nem convertida silenciosamente para outra; esclarecer a classificação no catálogo comum de F04.
- Cada continuação/esclarecimento concluído consulta os registros persistidos atuais, incluindo alterações/exclusões manuais; números mencionados e respostas antigas não viram fonte financeira.
- Preservar mensagens e respostas históricas com autoria, ordem e data/hora; não reescrevê-las ao corrigir recorte ou alterar transações.
- O resultado conserva as informações de sua consulta: saldo geral/acumulado; totais com tipo/período/categoria quando houver, soma/contagem; ou até cinco recentes com dados e ordem de F04.
- Restringir histórico e contexto ao titular confirmado, inclusive contra instruções para ignorar acesso, referência direta a conversa alheia e troca de conta. Pedidos não suportados ou de gravação seguem a orientação manual existente sem modificar finanças.
- Ausência real não é confundida com falha de IA/dados. Falha de interpretação, salvamento ou resposta permite retomada coerente, sem inventar resultado, duplicar mensagem confirmada ou descartar o estado de persistência já conhecido.
- Comparar perguntas de esclarecimento, continuações e respostas longas nos estados de processamento, ausência, erro e retomada com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, com transições 767/768px e 1024/1025px. Manter autoria, momento, foco, teclado, texto e controles legíveis/alcançáveis, sem sobreposição ou rolagem horizontal da página.

## Dependências

O início depende de Assistente de consulta financeira - Totais mensais por tipo e categoria, que já usa o chat persistido e permite demonstrar a continuação mensal com filtros. Para concluir a cobertura contextual completa, integrar também Assistente de consulta financeira - Totais por dia e intervalo e Assistente de consulta financeira - Cinco últimas movimentações. Essas integrações de conclusão não bloqueiam o início da continuação mensal.

## Referências

[Pai #1016276](https://redmine.remsoft.com.br/issues/1016276); R1/R3–R8/R10–R12 na continuidade; CA01/CA05/CA06/CA08–CA12/CA14 nas parcelas contextuais; CT-005, CT-008/CT-009, CT-012–CT-015, CT-018–CT-024.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #assistant, #messages, .message, #chat-input e #chat-form. A continuidade persistida e o esclarecimento aprovados substituem a interpretação demonstrativa, sem nova conversa ou controles fora do escopo.

Intenção estável de criação: `docs/harness/features/1016276-assistente-de-consulta-financeira/slices/slices.md#D05-r001`.
