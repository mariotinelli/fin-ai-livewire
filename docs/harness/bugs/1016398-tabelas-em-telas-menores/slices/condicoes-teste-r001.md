# Condições de teste

Pai: [#1016398 — Corrigir tabelas em telas menores](https://redmine.remsoft.com.br/issues/1016398).

Revisão: r001 — proposta para revisão; ainda não executada.

## Contexto

Conferir os quatro consumidores existentes: Usuários, Perfis de acesso, Alertas de erros e Histórico de comandos Artisan. Usar os atores já autorizados e dados de homologação com textos longos, mais de uma página, listas sem registros e consultas sem resultado. Erro de filtros só nas telas que já possuem esse estado. Comparar com E02–E04, anexos 3374–3376 no Bug, mantendo a adaptação aprovada de tabela com rolagem interna, sem cartões. Matriz: 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768; transições 767/768 e 1024/1025px. Conferir com e sem envbar nas condições atuais. Não há teste executado neste documento.

## CT-001 — Percorrer todas as colunas

Verificação: Em cada consumidor com dados e textos longos, rolar a região das colunas até ambos os extremos nas larguras estreitas.

Resultado esperado: Todos os cabeçalhos, células e ações são alcançáveis; a rolagem é interna e cabeçalhos e dados continuam alinhados.

Origem no requisito: CC01, CC05.

## CT-002 — Usar ações à direita

Verificação: Rolar até a coluna de ações, abrir seus menus e executar ações permitidas e suas confirmações conforme cada tela.

Resultado esperado: Menus e controles não ficam cortados pela região rolável; permissões, efeitos e confirmações existentes são preservados.

Origem no requisito: CC04, CC05.

## CT-003 — Buscar dentro da largura disponível

Verificação: Nas quatro listagens, preencher a busca existente e consultar os resultados, mantendo a região das colunas em posições horizontais diferentes.

Resultado esperado: A busca fica visível e utilizável, não acompanha o deslocamento das colunas e mantém os resultados e regras atuais.

Origem no requisito: CC02, CC05.

## CT-004 — Aplicar e limpar filtros

Verificação: Nas telas com filtros, abrir o painel, alterar e aplicar os critérios e depois limpar conforme o fluxo existente.

Resultado esperado: Painel e ações ficam utilizáveis sem cortes na largura visível; contadores e efeitos de filtro são preservados.

Origem no requisito: CC02, CC04, CC05.

## CT-005 — Percorrer páginas e mudar quantidade

Verificação: Com mais de uma página de dados, usar os controles de paginação e a seleção de itens por página.

Resultado esperado: Controles e contador cabem na largura visível, não acompanham a rolagem horizontal das colunas e preservam a consulta atual.

Origem no requisito: CC02, CC05.

## CT-006 — Ler lista sem registros

Verificação: Abrir cada listagem sem registros no estado existente correspondente.

Resultado esperado: Título e descrição do estado vazio ficam integralmente legíveis na largura visível, sem rolagem horizontal para ler a mensagem.

Origem no requisito: CC03, CC05.

## CT-007 — Ler nenhum resultado e recuperar consulta

Verificação: Usar busca e filtros que não encontrem dados e acionar as ações de recuperação existentes.

Resultado esperado: Texto completo e ações de nenhum resultado cabem na largura visível; é possível recuperar a consulta conforme o comportamento atual.

Origem no requisito: CC03, CC05.

## CT-008 — Ler consulta não executada

Verificação: Nas telas aplicáveis, usar o cenário de filtros inválidos que já bloqueia a consulta.

Resultado esperado: Mensagem e orientações permanecem legíveis dentro da largura visível, sem alterar a validação existente.

Origem no requisito: CC03, CC05.

## CT-009 — Comparar larguras e transições

Verificação: Percorrer a matriz e as transições, com dados e sem dados, comparando o enquadramento às falhas E02–E04.

Resultado esperado: Quando as colunas couberem, a leitura habitual é preservada; quando excederem, rolam internamente; controles e mensagens continuam enquadrados.

Origem no requisito: CC06.

## CT-010 — Conferir integração com a página

Verificação: Nos quatro consumidores, rolar até o fim, com e sem envbar onde permitido, e conferir navegação principal e ações.

Resultado esperado: A tabela não provoca rolagem horizontal global da página nem torna conteúdo e ações inacessíveis junto à navegação.

Origem no requisito: CC07.
