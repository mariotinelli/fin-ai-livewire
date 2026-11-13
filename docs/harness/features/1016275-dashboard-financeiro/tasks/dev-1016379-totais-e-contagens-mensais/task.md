# [DEV] [WEB] [USUARIO] Dashboard financeiro - Totais e contagens mensais

## Identidade e fontes

- Filha: [#1016379](https://redmine.remsoft.com.br/issues/1016379); papel: DEV; status remoto conferido: New.
- Pai: [#1016275](https://redmine.remsoft.com.br/issues/1016275); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **24**; pai espelha 23.
- Estimativa: **2h**, proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[QA] [WEB] [USUARIO] Gestão de transações — #1016356](https://redmine.remsoft.com.br/issues/1016356).
- Condições: [CT-001–CT-019, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016275 - Condições de testes.docx>), [anexo #3366 da QA #1016385](https://redmine.remsoft.com.br/attachments/download/3366/1016275%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Permitir selecionar mês/ano na Visão geral e reconhecer os totais e quantidades de receitas e despesas desse período, calculados pela data financeira dos registros próprios.

## Escopo e limites

Totais, contagens e seletor formam a mesma consulta mensal: o recorte precisa estar identificado para que os números tenham sentido. Comparação e resultado visual mensal são outra entrega. Não reconstruir classificação, cadastro ou regras financeiras de F04.

## Critérios de aceite

- Inicializar no mês corrente em America/Sao_Paulo e identificar claramente mês/ano. Referências próximas da virada de dia/mês seguem esse fuso.
- Somar separadamente receitas/despesas e contar seus registros pelo mês/ano da data financeira, sem usar criação/edição como substituto. Considerar só dados atuais próprios disponíveis, excluindo alheios e excluídos.
- Apresentar totais em reais (BRL) com centavos exatos e contagens como quantidade de registros, sem confundir as duas informações.
- Mudar mês/ano atualiza totais e contagens desse recorte; não mudar o significado de saldo geral ou recentes acumulados nem herdar filtros de descrição/tipo/categoria/mês de F04.
- Sem registros no mês, apresentar totais/contagens zero reais; um tipo ausente não elimina os valores do outro. Selecionar mês vazio não cria nem prevê movimentações.
- Após criação, edição ou exclusão manual bem-sucedida, atualizar os cartões na mesma sessão sem novo login. Registro fora do recorte não altera seus valores; ao selecionar o mês daquele registro, mostrar o resultado atual. Cancelamento/falha mantém os dados anteriores.
- Identificar carregamento e falha com nova tentativa. Se o mês novo falhar, não apresentar números do mês anterior como se fossem do recorte solicitado nem substituir indisponibilidade por zero.
- Restringir a titular confirmado, inclusive em acesso direto/troca de conta; visitantes, pendentes e privilégios administrativos/de suporte não ampliam acesso financeiro.
- Comparar #month-wrap/#month, #income/#expense e suas contagens com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, incluindo zero, dados extensos, carregamento e erro/retomada. Manter rótulos, contagens, foco e teclado legíveis/alcançáveis, sem sobreposição ou rolagem horizontal.

## Dependências

O início depende de [[QA] [WEB] [USUARIO] Gestão de transações](https://redmine.remsoft.com.br/issues/1016356). A rota da Visão geral já existe, portanto não criar bloqueio de início por compartilhar a tela com Saldo acumulado real. Para concluir a composição/integração, manter saldo e recentes acumulados quando esses consumidores estiverem disponíveis. O preparo comum da leitura/atualização fica no primeiro consumidor, sem duplicação.

## Referências

[Pai #1016275](https://redmine.remsoft.com.br/issues/1016275); R1/R3/R5/R8–R10; CA02/CA06–CA11; CT-001/CT-004/CT-005/CT-007, CT-011–CT-016, CT-018/CT-019.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #month-wrap, #month, #income, #expense, #income-count e #expense-count.

Intenção estável de criação: `docs/harness/features/1016275-dashboard-financeiro/slices/slices.md#D02-r001`.
