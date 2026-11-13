# [DEV] [WEB] [USUARIO] Dashboard financeiro - Histórico completo a partir da Visão geral

## Identidade e fontes

- Filha: [#1016383](https://redmine.remsoft.com.br/issues/1016383); papel: DEV; status remoto conferido: New.
- Pai: [#1016275](https://redmine.remsoft.com.br/issues/1016275); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **28**; pai espelha 23.
- Estimativa: **0,5h**, proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[QA] [WEB] [USUARIO] Gestão de transações — #1016356](https://redmine.remsoft.com.br/issues/1016356).
- Condições: [CT-001–CT-019, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016275 - Condições de testes.docx>), [anexo #3366 da QA #1016385](https://redmine.remsoft.com.br/attachments/download/3366/1016275%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Permitir sair da Visão geral para consultar todo o histórico próprio, mesmo depois de ter usado filtros restritivos em F04.

## Escopo e limites

O resultado é a consulta completa no destino real, com recortes anteriores removidos; não se limita a desenhar ou ligar o controle Ver todas. Não alterar a pesquisa ou paginação fornecidas por F04.

## Critérios de aceite

- Acionar Ver todas abre o histórico real F04 com descrição, tipo, categoria e mês anteriores removidos.
- O destino consulta todo o histórico próprio, sem limitar ao mês escolhido no dashboard ou aos cinco recentes; conjuntos extensos continuam acessíveis pela contagem/paginação existentes.
- Preservar acesso do titular confirmado e não reutilizar dados/filtros de outra conta; não criar tela demonstrativa ou destino futuro.
- Comparar o controle e sua posição no painel de recentes com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, mantendo rótulo, foco/teclado, legibilidade e ação alcançável sem sobreposição.

## Dependências

O início depende de [[QA] [WEB] [USUARIO] Gestão de transações](https://redmine.remsoft.com.br/issues/1016356). Para concluir a composição da origem, integrar Recentes e detalhes reais, que fornece o painel de onde o titular amplia a consulta. Compartilhar o painel não exige aguardar seus dados para iniciar a transição/reset de filtros no destino já disponível.

## Referências

[Pai #1016275](https://redmine.remsoft.com.br/issues/1016275); R1/R5/R7/R10; CA05/CA09/CA11; CT-001/CT-010/CT-016/CT-018/CT-019.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, ordem final das regras e `DESIGN-HANDOFF.md`. Locador: link Ver todas no painel de últimas movimentações e destino #transactions, adaptado à navegação real F04 com filtros removidos.

Intenção estável de criação: `docs/harness/features/1016275-dashboard-financeiro/slices/slices.md#D06-r001`.
