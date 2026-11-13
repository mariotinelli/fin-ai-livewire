# [DEV] [WEB] [USUARIO] Dashboard financeiro - Saldo acumulado real

## Identidade e fontes

- Filha: [#1016378](https://redmine.remsoft.com.br/issues/1016378); papel: DEV; status remoto conferido: New.
- Pai: [#1016275](https://redmine.remsoft.com.br/issues/1016275); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **23**; pai espelha 23.
- Estimativa: **2h**, proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[QA] [WEB] [USUARIO] Gestão de transações — #1016356](https://redmine.remsoft.com.br/issues/1016356).
- Condições: [CT-001–CT-019, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016275 - Condições de testes.docx>), [anexo #3366 da QA #1016385](https://redmine.remsoft.com.br/attachments/download/3366/1016275%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Apresentar na Visão geral o saldo próprio acumulado, calculado sobre todas as receitas e despesas reais disponíveis do titular, preservando acesso, moeda e estados verdadeiros.

## Escopo e limites

A Visão geral e sua rota já existem. Integrar o primeiro conteúdo financeiro sobre F01, contando aqui o preparo comum de leitura/atualização, sem criar uma tarefa técnica separada. Os cartões mensais, comparação, recentes e jornadas de continuidade têm entregas próprias; não apresentar valores demonstrativos ou controles futuros para aparentar conclusão.

## Critérios de aceite

- Titular autenticado com e-mail confirmado abre a Visão geral real; visitante e conta pendente não consultam finanças, inclusive por acesso direto. Administração/suporte não recebem visão financeira de terceiros.
- Calcular saldo pela soma de receitas menos despesas de todo o histórico próprio, sem saldo inicial separado; registros excluídos e de outras contas ficam fora.
- Apresentar BRL com centavos exatos, inclusive zero real e saldo negativo com sinal e identificação compreensível, sem limitar a zero.
- Mês escolhido no dashboard e filtros do histórico não mudam o significado acumulado do saldo. Integrar essa preservação quando o seletor mensal estiver disponível.
- Após criação, edição ou exclusão manual bem-sucedida pelas ações disponíveis, recalcular o saldo na mesma sessão sem novo login, inclusive quando a transação estiver fora do mês selecionado. Cancelamento/falha não altera o saldo.
- Distinguir carregamento, zero real e falha, com indisponibilidade/nova tentativa sem fabricar valores. Troca de conta não reutiliza resultados da anterior.
- Comparar cabeçalho aplicável e cartão #balance com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, nos estados de normal, foco, carregamento, zero, negativo e erro/retomada. Preservar hierarquia, tipografia, espaços e superfícies, valores extensos legíveis e ações/foco alcançáveis, sem sobreposição ou rolagem horizontal da página.
- Não transportar textos de armazenamento local ou simulação para a apresentação financeira.

## Dependências

O início depende de [[QA] [WEB] [USUARIO] Gestão de transações](https://redmine.remsoft.com.br/issues/1016356), que fornece transações e acesso pessoal sobre F01/F02 verificadas. Publicação em New não comprova implementação. Integrar seletor e ações de cadastro/detalhes ao resultado quando suas entregas estiverem disponíveis, sem reconstruir F04.

## Referências

[Pai #1016275](https://redmine.remsoft.com.br/issues/1016275); R1/R2/R5/R8–R10 nas parcelas do saldo; CA01/CA06–CA11; CT-001–CT-005, CT-007, CT-011–CT-016, CT-018/CT-019.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #overview, .stats, .stat-card.balance e #balance. A base visual pertence a F01; saldo próprio real substitui dados locais do protótipo.

Intenção estável de criação: `docs/harness/features/1016275-dashboard-financeiro/slices/slices.md#D01-r001`.
