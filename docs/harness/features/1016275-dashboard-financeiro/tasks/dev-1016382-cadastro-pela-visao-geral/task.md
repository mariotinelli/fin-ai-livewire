# [DEV] [WEB] [USUARIO] Dashboard financeiro - Cadastro pela Visão geral

## Identidade e fontes

- Filha: [#1016382](https://redmine.remsoft.com.br/issues/1016382); papel: DEV; status remoto conferido: New.
- Pai: [#1016275](https://redmine.remsoft.com.br/issues/1016275); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **27**; pai espelha 23.
- Estimativa: **1h**, proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[QA] [WEB] [USUARIO] Gestão de transações — #1016356](https://redmine.remsoft.com.br/issues/1016356).
- Condições: [CT-001–CT-019, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016275 - Condições de testes.docx>), [anexo #3366 da QA #1016385](https://redmine.remsoft.com.br/attachments/download/3366/1016275%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Permitir iniciar uma transação manual na Visão geral pelo formulário real de F04 e reconhecer seu efeito financeiro nos componentes do dashboard após salvamento bem-sucedido.

## Escopo e limites

A entrega é a jornada de cadastro iniciada neste contexto, com resposta observável após salvar. Não criar outro cadastro, validação ou fluxo financeiro. Cada indicador continua responsável por recalcular seu próprio resultado.

## Critérios de aceite

- Nova transação e a orientação de primeiro registro abrem o cadastro real F04, preservando campos, regras e titularidade, sem valores demonstrativos.
- Depois do sucesso, atualizar saldo, totais/contagens, comparação/resultado e recentes disponíveis na mesma sessão, sem exigir novo login.
- Registro no mês escolhido altera seus dados mensais; registro de outro mês altera saldo e seu próprio período sem contaminar o recorte atual, respeitando a ordem de recentes.
- Cancelar, fechar sem salvar ou falhar não grava, altera números ou anuncia sucesso falso. Usar os estados verdadeiros do formulário F04.
- Exigir titular autenticado/confirmado e preservar isolamento, inclusive em referências diretas/troca de conta.
- Comparar #new-transaction, vazio inicial e formulário com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, incluindo processamento/validação/falha/sucesso/cancelamento. Manter dados, foco/teclado e ações legíveis/alcançáveis sem controles encobertos ou rolagem horizontal.

## Dependências

O início depende de [[QA] [WEB] [USUARIO] Gestão de transações](https://redmine.remsoft.com.br/issues/1016356), que fornece o cadastro. Para concluir a resposta completa no dashboard, integrar Saldo acumulado real, Totais e contagens mensais, Comparação e resultado mensal e Recentes e detalhes reais. Essas integrações não criam bloqueio artificial para iniciar a jornada sobre a rota já existente.

## Referências

[Pai #1016275](https://redmine.remsoft.com.br/issues/1016275); R1/R7–R10; CA06/CA07/CA09–CA11; CT-001/CT-003/CT-007/CT-011–CT-013/CT-016/CT-018/CT-019.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #new-transaction, #transaction-dialog e orientações de primeiro registro; regras e formulário permanecem F04.

Intenção estável de criação: `docs/harness/features/1016275-dashboard-financeiro/slices/slices.md#D05-r001`.
