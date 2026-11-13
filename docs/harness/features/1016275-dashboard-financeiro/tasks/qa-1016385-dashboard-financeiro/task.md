# [QA] [WEB] [USUARIO] Dashboard financeiro

## Identidade e fontes

- Filha: [#1016385](https://redmine.remsoft.com.br/issues/1016385); papel: QA; status remoto conferido: New.
- Pai: [#1016275](https://redmine.remsoft.com.br/issues/1016275); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **30**; pai espelha 23.
- Estimativa: **3,5h**, proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Dashboard financeiro - Saldo acumulado real — #1016378](https://redmine.remsoft.com.br/issues/1016378); [[DEV] [WEB] [USUARIO] Dashboard financeiro - Totais e contagens mensais — #1016379](https://redmine.remsoft.com.br/issues/1016379); [[DEV] [WEB] [USUARIO] Dashboard financeiro - Comparação e resultado mensal — #1016380](https://redmine.remsoft.com.br/issues/1016380); [[DEV] [WEB] [USUARIO] Dashboard financeiro - Recentes e detalhes reais — #1016381](https://redmine.remsoft.com.br/issues/1016381); [[DEV] [WEB] [USUARIO] Dashboard financeiro - Cadastro pela Visão geral — #1016382](https://redmine.remsoft.com.br/issues/1016382); [[DEV] [WEB] [USUARIO] Dashboard financeiro - Histórico completo a partir da Visão geral — #1016383](https://redmine.remsoft.com.br/issues/1016383); [[DEV] [WEB] [USUARIO] Dashboard financeiro - Convite para o assistente real — #1016384](https://redmine.remsoft.com.br/issues/1016384).
- Condições: [CT-001–CT-019, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016275 - Condições de testes.docx>), [anexo #3366 da QA #1016385](https://redmine.remsoft.com.br/attachments/download/3366/1016275%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Verificar o Dashboard financeiro completo pelas jornadas reais, com indicadores próprios atuais, recortes mensais, recentes, cadastro/manutenção/histórico F04 e convite para F06, cobrindo CT-001–CT-019 r001.

## Escopo e limites

Executar uma única QA da Feature, incluindo preparo de dados/contas, relógio e falhas reversíveis, evidências e reteste focalizado. Reutilizar fornecedores já verificados, sem repetir integralmente suas campanhas ou substituir comparação visual por testes internos. F07 não é condição de encerramento.

## Critérios de aceite

- Executar CT-001–CT-019 com resultado/evidência por condição, cobrindo R1–R10 e CA01–CA12; pendências/defeitos não executados ficam explícitos.
- Conferir saldo acumulado sobre todo o histórico próprio, incluindo zero/negativo, sem saldo inicial e sem registros excluídos/alheios.
- Conferir mês/ano inicial em America/Sao_Paulo, totais/contagens pela data financeira e independência do saldo/recentes em relação ao seletor/filtros do histórico.
- Conferir comparação e resultado pelos mesmos totais, incluindo igualdade, zero, negativo, apenas um tipo e mês vazio.
- Conferir até cinco recentes na ordem de F04, campos integrais nos detalhes e manutenção real com atualização dos consumidores sem novo login.
- Cadastrar pela Visão geral em mês atual e anterior, comparar sucesso/cancelamento/fechamento/falha e verificar os efeitos em cada componente.
- Abrir Ver todas após filtros restritivos e reconhecer todo o histórico próprio com descrição/tipo/categoria/mês removidos.
- Abrir o chat real pelo convite F06 e conferir seu estado verdadeiro, sem simulação ou destino futuro.
- Provocar falha inicial e ao trocar mês, sem zero/vazio enganoso ou números do recorte anterior atribuídos ao novo.
- Conferir confirmação de e-mail, duas contas, troca de conta e referências diretas sem visão financeira de terceiros.
- Comparar a Visão geral completa e seus estados com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, com dados extensos, foco/teclado, hierarquia e controles alcançáveis, sem sobreposição ou rolagem horizontal da página.

## Dependências

Executar após Dashboard financeiro - Saldo acumulado real; Totais e contagens mensais; Comparação e resultado mensal; Recentes e detalhes reais; Cadastro pela Visão geral; Histórico completo a partir da Visão geral; e Convite para o assistente real.

F04 e F06 precisam estar implementadas/verificadas, consumindo F01/F02 disponíveis. Não aguardar registro por IA F07 para concluir o dashboard.

## Referências

[Pai #1016275](https://redmine.remsoft.com.br/issues/1016275); R1–R10, CA01–CA12; CT-001–CT-019 r001; anexo previsto `1016275 - Condições de testes.docx`.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #overview, cartões, #month, #graph/#month-result, #recent, Nova transação, Ver todas e .assistant-teaser/#open-chat.

Intenção estável de criação: `docs/harness/features/1016275-dashboard-financeiro/slices/slices.md#QA-r001`.
