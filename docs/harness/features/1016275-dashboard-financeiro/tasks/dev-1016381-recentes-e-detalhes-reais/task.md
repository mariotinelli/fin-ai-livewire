# [DEV] [WEB] [USUARIO] Dashboard financeiro - Recentes e detalhes reais

## Identidade e fontes

- Filha: [#1016381](https://redmine.remsoft.com.br/issues/1016381); papel: DEV; status remoto conferido: New.
- Pai: [#1016275](https://redmine.remsoft.com.br/issues/1016275); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **26**; pai espelha 23.
- Estimativa: **2h**, proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[QA] [WEB] [USUARIO] Gestão de transações — #1016356](https://redmine.remsoft.com.br/issues/1016356).
- Condições: [CT-001–CT-019, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016275 - Condições de testes.docx>), [anexo #3366 da QA #1016385](https://redmine.remsoft.com.br/attachments/download/3366/1016275%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Apresentar até cinco movimentações recentes de todo o histórico próprio na Visão geral, permitindo abrir seus dados integrais pelos detalhes reais de F04.

## Escopo e limites

Detalhes completam a leitura dos campos resumidos/ocultos na linha móvel e por isso acompanham a consulta de recentes. Editar/excluir são operações já fornecidas por F04: preservar essas ações e integrar seus efeitos, sem reconstruir manutenção. A transição para todo o histórico tem entrega própria e não é absorvida pela conferência dos cinco registros.

## Critérios de aceite

- Mostrar até cinco registros atuais próprios de todo o histórico, excluindo removidos e alheios, sem filtrar pelo mês escolhido no dashboard ou por filtros anteriores F04.
- Ordenar por data financeira decrescente, criação mais recente primeiro na mesma data e desempate estável de F04. Com menos de cinco, não completar com exemplos.
- Exibir dados aplicáveis, BRL/centavos, sinal e identificação textual do tipo além de cor; abrir detalhes integrais de tipo, valor, descrição, categoria e data, inclusive no celular.
- Preservar edição/exclusão e confirmações/cancelamentos reais dos detalhes F04. Depois do sucesso, recompor recentes e integrar a atualização dos indicadores disponíveis sem novo login; cancelar/falhar não muda o conjunto financeiro.
- Criar registro pelas ações disponíveis recompõe recentes segundo a ordem real; a data do registro, não o mês selecionado, define se entra nos cinco.
- Ausência real é distinguida de carregamento/erro de leitura, com orientação e nova tentativa sem registros fictícios. Referência indisponível ou alheia não revela dados de terceiro.
- Manter acesso apenas ao titular confirmado, inclusive por referência direta e troca de conta.
- Comparar #recent e detalhes F04 com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, usando textos/valores longos e estados normal/foco/vazio/processamento/erro. Campos resumidos continuam acessíveis nos detalhes; ações, foco e teclado permanecem alcançáveis sem sobreposição ou rolagem horizontal.

## Dependências

O início depende de [[QA] [WEB] [USUARIO] Gestão de transações](https://redmine.remsoft.com.br/issues/1016356), fornecedora de leitura, ordem, detalhes e manutenção. A Visão geral já existe e não exige bloqueio de início por outro cartão. Para concluir, integrar os efeitos da manutenção aos consumidores Saldo acumulado real, Totais e contagens mensais e Comparação e resultado mensal, sem duplicar o trabalho de seus cálculos.

## Referências

[Pai #1016275](https://redmine.remsoft.com.br/issues/1016275); R1/R5–R10; CA04/CA06–CA11; CT-001/CT-005/CT-007–CT-009, CT-011–CT-014/CT-016/CT-018/CT-019.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #recent, linhas de movimentação e #detail-dialog da referência; a leitura integral mobile justifica os detalhes na mesma entrega.

Intenção estável de criação: `docs/harness/features/1016275-dashboard-financeiro/slices/slices.md#D04-r001`.
