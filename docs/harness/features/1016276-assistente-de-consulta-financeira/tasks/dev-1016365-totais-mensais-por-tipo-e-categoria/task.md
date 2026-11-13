# [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Totais mensais por tipo e categoria

## Identidade e fontes

- Filha: [#1016365](https://redmine.remsoft.com.br/issues/1016365); papel: DEV; status remoto conferido: New.
- Pai: [Assistente de consulta financeira — #1016276](https://redmine.remsoft.com.br/issues/1016276); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **18**; pai espelha 17.
- Estimativa: **2,5h**. Estimativa proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Assistente de consulta financeira - Saldo geral em conversa salva — #1016364](https://redmine.remsoft.com.br/issues/1016364).
- Condições da Feature: [CT-001–CT-024, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016276 - Condições de testes.docx>), [anexo #3365 da QA #1016369](https://redmine.remsoft.com.br/attachments/download/3365/1016276%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação, execução de QA e chamada de IA não realizadas neste fluxo.

## Entrega

Permitir perguntar sobre receitas e despesas de um mês, com categoria opcional, e receber soma e quantidade de registros reais com o tipo, o mês e os filtros utilizados declarados na resposta.

## Escopo e limites

Mês corrente, anterior e explícito são variantes da mesma consulta mensal; receitas/despesas e categoria não viram tarefas por campo. Totais por dia e intervalo têm consulta e aceite próprios. Usar o chat persistido já funcional, sem refazer envio, memória, autorização ou aparência compartilhada.

## Critérios de aceite

- Interpretar por IA real perguntas compreensíveis de receitas, despesas ou ambos em este mês, mês passado e mês explícito; consultar somente os registros atuais próprios.
- Apresentar em pt-BR e BRL com centavos a soma e a quantidade separadas de cada tipo solicitado, declarando mês e categoria quando houver.
- Sem período explícito e sem contexto claro aplicável, usar e declarar o mês corrente em America/Sao_Paulo, inclusive quando UTC estiver em outro dia/mês.
- Reconhecer o catálogo comum de F04: Salário, Freelance, Rendimentos, Outras receitas, Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras e Outras despesas; aplicar somente categoria compatível compreendida com segurança.
- Categoria inexistente, incerta ou incompatível, tipo materialmente ambíguo ou período inseguro gera pedido de esclarecimento antes de número, sem inventar classificação. Completar a consulta pendente pela resposta curta é ampliado por Continuidade e esclarecimento.
- Mês/categoria válidos sem registros produzem soma e quantidade zero com ausência explícita; falha de IA ou dados informa problema e permite retomada, sem zero ou ausência falsa.
- Cada pergunta usa os dados atuais após criação, edição ou exclusão manual; valores mencionados na conversa não se tornam registros e respostas históricas não são reescritas.
- Histórico, contexto, consulta e resposta permanecem próprios, inclusive em referências diretas e pedidos para ignorar limites. Visitante e conta pendente não acessam o chat; mensagens não alteram finanças.
- A sugestão “Quanto gastei este mês?” executa a consulta real pela mesma composição, com processamento verdadeiro, persistência e recuperação coerentes, sem duplicar mensagens já salvas.
- Comparar sugestão mensal e respostas de totais nos estados de resultado, ausência, esclarecimento e falha com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, com transições 767/768px e 1024/1025px. Soma, quantidade, período, categoria e autoria permanecem legíveis, com foco/controles alcançáveis, sem sobreposição ou rolagem horizontal da página.

## Dependências

O início depende de Assistente de consulta financeira - Saldo geral em conversa salva, que fornece chat, navegação, identidade e persistência reais sobre F04 verificada. Não depende de consultas por dia/intervalo ou de recentes.

## Referências

[Pai #1016276](https://redmine.remsoft.com.br/issues/1016276); R2–R8/R10–R12 nas consultas mensais; CA02/CA03/CA05/CA06/CA08–CA12/CA14 nas parcelas mensais; CT-002, CT-008, CT-011/CT-012, CT-015, CT-017, CT-020/CT-021, CT-023/CT-024.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #assistant, #messages, .suggestions e sugestão mensal. As respostas transparentes de soma/contagem seguem o requisito, sem reproduzir as limitações de interpretação por regras do protótipo.

Intenção estável de criação: `docs/harness/features/1016276-assistente-de-consulta-financeira/slices/slices.md#D02-r001`.
