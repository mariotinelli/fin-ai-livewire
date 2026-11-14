# Fatiamento de [WEB] [USUÁRIO] Corrigir tabelas em telas menores

## Identidade

Pai: [#1016398](https://redmine.remsoft.com.br/issues/1016398); [requisito aprovado](../bug.md).

Projeto FinAi (65224), versão Livewire (20359). Revisão r001 aprovada por Mário, publicada e conferida. Filhas, relações, Sequencing e DOCX confirmados; pais mantidos em New. Nenhuma implementação ou execução QA realizada.

## Inspeção e fronteiras

`resources/views/components/ui/table.blade.php` já possui overflow-x-auto, margem negativa no celular e busca com min-w-64 parcialmente adaptada por draftFilters; a paginação fica fora das colunas. `resources/views/components/ui/pagination.blade.php` possui controles responsivos existentes. `resources/views/components/ui/table/td.blade.php` aplica whitespace-nowrap; os consumidores colocam os estados vazios em colspan. `resources/views/components/ui/empty-state.blade.php` tem a mensagem compartilhada. Quatro consumidores encontrados: `resources/views/livewire/admin/management/users/index.blade.php`, `roles/index.blade.php`, `resources/views/livewire/support/system-error-alerts/index.blade.php` e `support/artisan-commands/history.blade.php`. Há testes de cada listagem, `tests/Unit/Traits/Components/WithTableTest.php` e `tests/JavaScript/components/TableTooltipsTest.mjs`; sustentam contratos a preservar, sem comprovar a matriz visual.

Classificação: adaptação da apresentação existente com o comportamento aprovado. Nenhum critério foi classificado como integralmente existente para omitir DEV. Testes e código foram lidos, não executados; as evidências de leitura não comprovam conformidade em navegador. Não há necessidade de Study identificada.

## Prévia numerada

| Entrega | Título completo | Horas | Sequencing |
| --- | --- | ---: | ---: |
| D01 | [DEV] [WEB] [USUÁRIO] Corrigir tabelas em telas menores - Colunas e ações com rolagem interna | 2 | 40 |
| D02 | [DEV] [WEB] [USUÁRIO] Corrigir tabelas em telas menores - Buscar e filtrar no espaço disponível | 1 | 41 |
| D03 | [DEV] [WEB] [USUÁRIO] Corrigir tabelas em telas menores - Paginar no espaço disponível | 1 | 42 |
| D04 | [DEV] [WEB] [USUÁRIO] Corrigir tabelas em telas menores - Mensagens sem registros na largura visível | 1 | 43 |
| Q01 | [QA] [WEB] [USUÁRIO] Corrigir tabelas em telas menores | 2 | 44 |

Total: 7h. Todos os valores são esforço ativo, incluem verificação DEV e preparação/execução/registro/reteste dirigido QA nas respectivas tarefas; excluem espera por ambiente ou aprovação.

Relações nativas propostas: D01 → Q01 (`blocks`); D02 → Q01 (`blocks`); D03 → Q01 (`blocks`); D04 → Q01 (`blocks`). Sem bloqueio externo novo. As relações `relates` dos pais com #1016270 serão preservadas; a ordem de catálogo não cria bloqueios entre os três pais.

## Estimativas e revisão independente

Fronteiras revisadas antes das horas: separar consulta de colunas/ações, busca/filtros, paginação e mensagens. Busca e filtros permanecem juntos como composição da consulta pelo cabeçalho; paginação é um resultado próprio. Avaliações independentes A/B: colunas 2,5h/2h; busca/filtros 1h/1,5h; paginação 0,75h/1h; mensagens 1,5h/1,5h; QA 3,5h/3,5h. Proposta inicial do agente: 2,5h, 1,5h, 1h, 1,5h e 3,5h, considerando integração de menus, variantes de cabeçalho e rodapé dos quatro consumidores. A seleção final é responsabilidade do agente condutor, não média automática.

Duas avaliações independentes por entrega, uma focada em resultado/trabalho restante e outra em reaproveitamento/sobreposição/testes. Referência humana local: #1016270, com 1,5h para identidade no dashboard, 2h para cada jornada/layout e QA integral de 4h, conforme seu slices.md. Os valores não foram copiados: esta proposta considera novas interações e o reaproveitamento observado. Suposições: equipe familiarizada com o projeto e ambiente de homologação disponível com dados/atores a preparar; não há medição de tempo real nem redução presumida por uso de IA.

Correção explícita de Mário nesta conversa: D01 2h, D02 1h, D03 1h, D04 1h e Q01 2h, total 7h. Estes são os valores vigentes, preservando escopo e cobertura; a proposta inicial de 10h e as avaliações independentes acima são mantidas como histórico. Trata-se de calibração do responsável, não medição ou nova estimativa independente.

## Cobertura

| Regra ou critério | Dono da entrega | Condições QA |
| --- | --- | --- |
| CC01 | D01 — Colunas/ações | CT-001 |
| CC02 — Busca e filtros | D02 | CT-003–CT-004 |
| CC02 — Paginação/quantidade/contadores | D03 | CT-005 |
| CC03 | D04 — Estados sem registros | CT-006–CT-008 |
| CC04 — Ações das linhas | D01 | CT-002 |
| CC04 — Painel de filtros | D02 | CT-004 |
| CC05–CC07 — Colunas/ações | D01 | CT-001–CT-002, CT-009–CT-010 |
| CC05–CC07 — Busca/filtros | D02 | CT-003–CT-004, CT-009–CT-010 |
| CC05–CC07 — Rodapé | D03 | CT-005, CT-009–CT-010 |
| CC05–CC07 — Mensagens | D04 | CT-006–CT-010 |

Critérios transversais são particionados por região/canal/interação, sem recriar o mesmo comportamento em várias tarefas. QA cobre o pai integralmente; nenhum critério foi excluído.

## Condições de teste

Fonte: [condicoes-teste-r001.md](condicoes-teste-r001.md). Documento Word: [1016398 - Condições de testes.docx](<r001/1016398 - Condições de testes.docx>).

Pai: [#1016398 — Corrigir tabelas em telas menores](https://redmine.remsoft.com.br/issues/1016398).

Revisão: r001 — proposta para revisão; ainda não executada.

### Contexto

Conferir os quatro consumidores existentes: Usuários, Perfis de acesso, Alertas de erros e Histórico de comandos Artisan. Usar os atores já autorizados e dados de homologação com textos longos, mais de uma página, listas sem registros e consultas sem resultado. Erro de filtros só nas telas que já possuem esse estado. Comparar com E02–E04, anexos 3374–3376 no Bug, mantendo a adaptação aprovada de tabela com rolagem interna, sem cartões. Matriz: 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768; transições 767/768 e 1024/1025px. Conferir com e sem envbar nas condições atuais. Não há teste executado neste documento.

### CT-001 — Percorrer todas as colunas

Verificação: Em cada consumidor com dados e textos longos, rolar a região das colunas até ambos os extremos nas larguras estreitas.

Resultado esperado: Todos os cabeçalhos, células e ações são alcançáveis; a rolagem é interna e cabeçalhos e dados continuam alinhados.

Origem no requisito: CC01, CC05.

### CT-002 — Usar ações à direita

Verificação: Rolar até a coluna de ações, abrir seus menus e executar ações permitidas e suas confirmações conforme cada tela.

Resultado esperado: Menus e controles não ficam cortados pela região rolável; permissões, efeitos e confirmações existentes são preservados.

Origem no requisito: CC04, CC05.

### CT-003 — Buscar dentro da largura disponível

Verificação: Nas quatro listagens, preencher a busca existente e consultar os resultados, mantendo a região das colunas em posições horizontais diferentes.

Resultado esperado: A busca fica visível e utilizável, não acompanha o deslocamento das colunas e mantém os resultados e regras atuais.

Origem no requisito: CC02, CC05.

### CT-004 — Aplicar e limpar filtros

Verificação: Nas telas com filtros, abrir o painel, alterar e aplicar os critérios e depois limpar conforme o fluxo existente.

Resultado esperado: Painel e ações ficam utilizáveis sem cortes na largura visível; contadores e efeitos de filtro são preservados.

Origem no requisito: CC02, CC04, CC05.

### CT-005 — Percorrer páginas e mudar quantidade

Verificação: Com mais de uma página de dados, usar os controles de paginação e a seleção de itens por página.

Resultado esperado: Controles e contador cabem na largura visível, não acompanham a rolagem horizontal das colunas e preservam a consulta atual.

Origem no requisito: CC02, CC05.

### CT-006 — Ler lista sem registros

Verificação: Abrir cada listagem sem registros no estado existente correspondente.

Resultado esperado: Título e descrição do estado vazio ficam integralmente legíveis na largura visível, sem rolagem horizontal para ler a mensagem.

Origem no requisito: CC03, CC05.

### CT-007 — Ler nenhum resultado e recuperar consulta

Verificação: Usar busca e filtros que não encontrem dados e acionar as ações de recuperação existentes.

Resultado esperado: Texto completo e ações de nenhum resultado cabem na largura visível; é possível recuperar a consulta conforme o comportamento atual.

Origem no requisito: CC03, CC05.

### CT-008 — Ler consulta não executada

Verificação: Nas telas aplicáveis, usar o cenário de filtros inválidos que já bloqueia a consulta.

Resultado esperado: Mensagem e orientações permanecem legíveis dentro da largura visível, sem alterar a validação existente.

Origem no requisito: CC03, CC05.

### CT-009 — Comparar larguras e transições

Verificação: Percorrer a matriz e as transições, com dados e sem dados, comparando o enquadramento às falhas E02–E04.

Resultado esperado: Quando as colunas couberem, a leitura habitual é preservada; quando excederem, rolam internamente; controles e mensagens continuam enquadrados.

Origem no requisito: CC06.

### CT-010 — Conferir integração com a página

Verificação: Nos quatro consumidores, rolar até o fim, com e sem envbar onde permitido, e conferir navegação principal e ações.

Resultado esperado: A tabela não provoca rolagem horizontal global da página nem torna conteúdo e ações inacessíveis junto à navegação.

Origem no requisito: CC07.


## Descrições completas

### 1. [DEV] [WEB] [USUÁRIO] Corrigir tabelas em telas menores - Colunas e ações com rolagem interna

Papel: DEV. Estimativa: 2h. Sequencing: 40. Filha: [#1016403](https://redmine.remsoft.com.br/issues/1016403).

#### Entrega

A tabela já possui uma região rolável, mas as evidências mostram conteúdo cortado em telas menores. Ajustar o enquadramento dessa região para consultar todas as colunas e alcançar as ações à direita, mantendo cabeçalhos e células alinhados.

#### Escopo e limites

Incluir o enquadramento externo mínimo necessário à região das colunas. Acesso às ações e abertura de seus menus são a resposta necessária à consulta da última coluna. Busca/filtros, paginação e mensagens sem registros têm entregas próprias; cada região deve integrar-se ao contêiner sem alargá-lo.

#### Critérios de aceite

- Nas listagens Usuários, Perfis de acesso, Alertas de erros e Histórico de comandos Artisan, com dados e textos longos, rolar internamente até ambos os extremos permite alcançar todos os cabeçalhos, células e ações, sem deslocar a própria região para fora da largura disponível.
- Cabeçalhos e células continuam alinhados durante a rolagem; a apresentação permanece tabular e as ações ficam na coluna à direita, sem exigir colunas fixas.
- Ao alcançar as ações, abrir menus e executar ações já permitidas não deixa controles cortados pela região rolável; efeitos, confirmações e permissões atuais permanecem.
- Conferir a região das colunas em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, incluindo 767/768px e 1024/1025px: quando couber, manter leitura habitual; quando exceder, usar rolagem interna.
- Conferir a região com e sem envbar onde permitido e preservar acesso junto à navegação principal. A ausência de overflow global do conjunto será validada na integração com as outras regiões da tabela.
- Comparar com E02–E04: corrigir os cortes da região de dados sem converter registros em cartões ou alterar consultas.

#### Dependências

Não há bloqueios de início. Integrar o enquadramento com “Buscar e filtrar no espaço disponível”, “Paginar no espaço disponível” e “Mensagens sem registros na largura visível” antes do aceite integral do Bug.

#### Referências

[Pai #1016398](https://redmine.remsoft.com.br/issues/1016398). [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); identidade e componentes aplicáveis às telas existentes. Evidências do defeito: [E02 — Tabela de Usuários em tela menor; captura original de 14/11/2026 às 10:27:32.](https://redmine.remsoft.com.br/attachments/download/3374/e02-tabela-usuarios-tela-menor.png); [E03 — Tabela de Usuários em largura maior para comparação; captura original de 14/11/2026 às 10:27:15.](https://redmine.remsoft.com.br/attachments/download/3375/e03-tabela-usuarios-comparacao.png); [E04 — Tabela de Usuários com conteúdo cortado; captura original de 14/11/2026 às 10:26:44.](https://redmine.remsoft.com.br/attachments/download/3376/e04-tabela-usuarios-conteudo-cortado.png).

Cobertura: CC01, CC04; CC05–CC07 na região de colunas/ações. Condições: CT-001, CT-002, CT-009, CT-010, na revisão r001 do DOCX do pai 1016398. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem: project-slices:1016398:r001:D01.

### 2. [DEV] [WEB] [USUÁRIO] Corrigir tabelas em telas menores - Buscar e filtrar no espaço disponível

Papel: DEV. Estimativa: 1h. Sequencing: 41. Filha: [#1016404](https://redmine.remsoft.com.br/issues/1016404).

#### Entrega

A busca e os filtros já funcionam, mas sua composição pode exceder a largura disponível. Tornar a consulta por busca e filtros utilizável no cabeçalho da tabela em telas menores, preservando as regras e os resultados atuais.

#### Escopo e limites

Busca e filtros compõem a mesma consulta pelo cabeçalho, com confirmação e limpeza existentes. A navegação entre páginas e a região das colunas permanecem nas tarefas próprias.

#### Critérios de aceite

- Nas telas Usuários, Perfis de acesso, Alertas de erros e Histórico de comandos Artisan, a busca existente fica visível e utilizável na largura disponível, independentemente da posição horizontal das colunas.
- Nas telas com filtros, abrir, preencher, aplicar e limpar o painel mantém campos, botões e contadores alcançáveis, sem corte pelo contêiner rolável.
- Resultados da busca, critérios aplicados, contadores e regras de autorização/validação continuam equivalentes aos atuais; não consultar por mudanças de apresentação.
- Conferir cabeçalho e painel em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, incluindo 767/768px e 1024/1025px, com e sem envbar onde permitido: a região de consulta não alarga a página nem encobre navegação/ações.
- Manter campos e contadores externos à rolagem das colunas, preservando a linguagem visual das listagens.

#### Dependências

Não há bloqueios de início. Integrar o cabeçalho com as regiões de colunas, paginação e mensagens entregues pelas outras tarefas do Bug para a QA integral.

#### Referências

[Pai #1016398](https://redmine.remsoft.com.br/issues/1016398). [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); identidade e componentes aplicáveis às telas existentes. Evidências do defeito: [E02 — Tabela de Usuários em tela menor; captura original de 14/11/2026 às 10:27:32.](https://redmine.remsoft.com.br/attachments/download/3374/e02-tabela-usuarios-tela-menor.png); [E03 — Tabela de Usuários em largura maior para comparação; captura original de 14/11/2026 às 10:27:15.](https://redmine.remsoft.com.br/attachments/download/3375/e03-tabela-usuarios-comparacao.png); [E04 — Tabela de Usuários com conteúdo cortado; captura original de 14/11/2026 às 10:26:44.](https://redmine.remsoft.com.br/attachments/download/3376/e04-tabela-usuarios-conteudo-cortado.png).

Cobertura: CC02 na busca/filtros; CC04 nos filtros; CC05–CC07 nessa região. Condições: CT-003, CT-004, CT-009, CT-010, na revisão r001 do DOCX do pai 1016398. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem: project-slices:1016398:r001:D02.

### 3. [DEV] [WEB] [USUÁRIO] Corrigir tabelas em telas menores - Paginar no espaço disponível

Papel: DEV. Estimativa: 1h. Sequencing: 42. Filha: [#1016405](https://redmine.remsoft.com.br/issues/1016405).

#### Entrega

A paginação e a quantidade por página já existem. Ajustar seu enquadramento em telas menores para percorrer páginas e consultar os contadores sem deslocamento horizontal da região das colunas.

#### Escopo e limites

Abrange rodapé, seleção de quantidade e contadores. Preservar as consultas, buscas e filtros já aplicados; não recriar mecanismos de paginação.

#### Critérios de aceite

- Com mais de uma página em Usuários, Perfis de acesso, Alertas de erros e Histórico de comandos Artisan, os controles de página, quantidade e contadores permanecem visíveis e utilizáveis na largura disponível.
- Rolar horizontalmente as colunas não desloca o rodapé. Mudar página e quantidade preserva os efeitos e restrições existentes, inclusive manutenção dos critérios da consulta.
- Conferir o rodapé em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, incluindo 767/768px e 1024/1025px, com e sem envbar onde permitido; ele não alarga a página nem perde acesso ao alcançar o fim da listagem.
- Manter a aparência dos contadores e controles coerente com a listagem existente, sem omitir informações para fazê-los caber.

#### Dependências

Não há bloqueios de início. Integrar o rodapé às demais regiões da tabela antes da QA integral.

#### Referências

[Pai #1016398](https://redmine.remsoft.com.br/issues/1016398). [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); identidade e componentes aplicáveis às telas existentes. Evidências do defeito: [E02 — Tabela de Usuários em tela menor; captura original de 14/11/2026 às 10:27:32.](https://redmine.remsoft.com.br/attachments/download/3374/e02-tabela-usuarios-tela-menor.png); [E03 — Tabela de Usuários em largura maior para comparação; captura original de 14/11/2026 às 10:27:15.](https://redmine.remsoft.com.br/attachments/download/3375/e03-tabela-usuarios-comparacao.png); [E04 — Tabela de Usuários com conteúdo cortado; captura original de 14/11/2026 às 10:26:44.](https://redmine.remsoft.com.br/attachments/download/3376/e04-tabela-usuarios-conteudo-cortado.png).

Cobertura: CC02 na paginação; CC05–CC07 no rodapé. Condições: CT-005, CT-009, CT-010, na revisão r001 do DOCX do pai 1016398. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem: project-slices:1016398:r001:D03.

### 4. [DEV] [WEB] [USUÁRIO] Corrigir tabelas em telas menores - Mensagens sem registros na largura visível

Papel: DEV. Estimativa: 1h. Sequencing: 43. Filha: [#1016406](https://redmine.remsoft.com.br/issues/1016406).

#### Entrega

As mensagens sem registros são renderizadas dentro da tabela e aparecem cortadas nas evidências. Tornar legíveis, sem rolagem horizontal, os estados de lista vazia, nenhum resultado e consulta não executada por filtros inválidos onde já existirem.

#### Escopo e limites

Os estados e suas ações já existem; adaptar sua apresentação sem criar mensagens ou validações novas. Preservar o resultado tabular das consultas com dados, entregue em “Colunas e ações com rolagem interna”.

#### Critérios de aceite

- Nas listagens Usuários, Perfis de acesso, Alertas de erros e Histórico de comandos Artisan, o estado de lista vazia apresenta título e descrição completos dentro da largura visível, sem exigir rolagem horizontal para lê-los.
- Uma busca ou filtro sem resultado apresenta mensagem completa e ações de recuperação existentes, que continuam alcançáveis e operantes.
- Quando existente, o estado de consulta não executada por filtros inválidos mantém texto e orientações legíveis sem alterar a validação.
- Conferir as mensagens em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768 e 767/768px e 1024/1025px, com e sem envbar onde permitido; permitir quebra de texto sem deslocar conteúdo, navegação ou ações para fora da página.
- Comparar com as mensagens cortadas de E02/E04 e preservar ícones, hierarquia, linguagem visual e leitura habitual quando houver espaço.

#### Dependências

Não há bloqueios de início. Integrar os estados sem registros com o enquadramento das colunas e os controles de consulta/paginação antes do aceite integral.

#### Referências

[Pai #1016398](https://redmine.remsoft.com.br/issues/1016398). [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); identidade e componentes aplicáveis às telas existentes. Evidências do defeito: [E02 — Tabela de Usuários em tela menor; captura original de 14/11/2026 às 10:27:32.](https://redmine.remsoft.com.br/attachments/download/3374/e02-tabela-usuarios-tela-menor.png); [E03 — Tabela de Usuários em largura maior para comparação; captura original de 14/11/2026 às 10:27:15.](https://redmine.remsoft.com.br/attachments/download/3375/e03-tabela-usuarios-comparacao.png); [E04 — Tabela de Usuários com conteúdo cortado; captura original de 14/11/2026 às 10:26:44.](https://redmine.remsoft.com.br/attachments/download/3376/e04-tabela-usuarios-conteudo-cortado.png).

Cobertura: CC03; CC05–CC07 nos estados sem registros. Condições: CT-006, CT-007, CT-008, CT-009, CT-010, na revisão r001 do DOCX do pai 1016398. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem: project-slices:1016398:r001:D04.

### 5. [QA] [WEB] [USUÁRIO] Corrigir tabelas em telas menores

Papel: QA. Estimativa: 2h. Sequencing: 44. Filha: [#1016407](https://redmine.remsoft.com.br/issues/1016407).

#### Entrega

Validar a tabela completa nas quatro listagens consumidoras, incluindo consulta dos dados e ações, busca, filtros, paginação e estados sem registros no espaço disponível.

#### Escopo e limites

Preparar registros longos, mais de uma página e cenários sem dados/resultado. A QA integrada verifica o enquadramento do conjunto, sem tratar a validação isolada das regiões como prova de ausência de rolagem horizontal global.

#### Critérios de aceite

- Executar CT-001–CT-010 no conjunto dos quatro consumidores, registrando os cenários aplicáveis a cada tela e as evidências dos desvios.
- Conferir 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, as transições 767/768px e 1024/1025px e a integração com e sem envbar onde permitido.
- Conferir todas as colunas e ações à direita, alinhamento, menus sem cortes, busca/filtros utilizáveis, paginação, quantidade e contadores externos à rolagem.
- Conferir lista vazia, nenhum resultado e filtros inválidos onde disponíveis: texto e ações completos sem rolagem horizontal para leitura.
- Confirmar que a tabela inteira não alarga a página, preserva navegação, permissões, consultas, resultados e confirmações; comparar o resultado às falhas E02–E04.
- Usar o DOCX do pai #1016398 r001, registrar resultados e realizar um reteste dirigido das correções encontradas.

#### Dependências

A campanha completa aguarda “Colunas e ações com rolagem interna”, “Buscar e filtrar no espaço disponível”, “Paginar no espaço disponível” e “Mensagens sem registros na largura visível”, todas do Bug “Corrigir tabelas em telas menores”.

#### Referências

[Pai #1016398](https://redmine.remsoft.com.br/issues/1016398). [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); identidade e componentes aplicáveis às telas existentes. Evidências do defeito: [E02 — Tabela de Usuários em tela menor; captura original de 14/11/2026 às 10:27:32.](https://redmine.remsoft.com.br/attachments/download/3374/e02-tabela-usuarios-tela-menor.png); [E03 — Tabela de Usuários em largura maior para comparação; captura original de 14/11/2026 às 10:27:15.](https://redmine.remsoft.com.br/attachments/download/3375/e03-tabela-usuarios-comparacao.png); [E04 — Tabela de Usuários com conteúdo cortado; captura original de 14/11/2026 às 10:26:44.](https://redmine.remsoft.com.br/attachments/download/3376/e04-tabela-usuarios-conteudo-cortado.png).

Cobertura: CC01–CC07. Condições: CT-001–CT-010, na revisão r001 do DOCX do pai 1016398. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem: project-slices:1016398:r001:Q01.
#### Documento de condições

[Condições de teste de #1016398 — r001](https://redmine.remsoft.com.br/attachments/download/3380/1016398%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).

## Publicação autorizada

- Servidor: https://redmine.remsoft.com.br. Identidade consultada: Mário Tinelli (131789).
- Criar 5 filhas novas sob o pai #1016398; tracker Task (4), status New (1), prioridade Normal (4), projeto FinAi (65224), versão Livewire (20359). Sem categoria, responsável, datas ou outros campos adicionais. Títulos, descrições, estimativas e Sequencing são os da prévia acima.
- As descrições remotas serão integralmente as seções Entrega, Escopo e limites, Critérios de aceite, Dependências e Referências de cada filha, preservando a origem estável. As referências de evidência são links para anexos Redmine; nenhum caminho do computador será usado como evidência.
- Filhas existentes: consultas de todos os status por pai não retornaram filhas. Nenhuma adoção, exclusão, cancelamento, alteração de status ou renumeração de issue alheia é proposta.
- Relações novas: D01 → Q01 (`blocks`); D02 → Q01 (`blocks`); D03 → Q01 (`blocks`); D04 → Q01 (`blocks`). A origem é a fornecedora/bloqueadora e o destino é a consumidora/QA; substituir as chaves pelos IDs confirmados. Preservar todas as relações existentes.
- Atualizar somente Sequencing do pai #1016398 para 40, espelhando a primeira filha e sem consumir posição adicional; preservar descrição, status e demais campos do pai.
- Anexar `1016398 - Condições de testes.docx`, revisão r001, às QAs Q01 — [QA] [WEB] [USUÁRIO] Corrigir tabelas em telas menores. A QA executa todas as condições do documento. Preservar anexos já existentes.
- Materializar `tasks/dev-<ID>-<slug>/task.md` e `tasks/qa-<ID>-<slug>/task.md` somente após releitura integral da publicação. Não criar planning.md nem implementar neste fluxo.

## Sequencing

Campo real: Sequencing, custom field 2. Consulta MCP completa: projeto 65224, versão 20359, todos os status/trackers, uma página com 46 de 46 issues. Maior inteiro positivo ocupado: 37; nenhum valor não vazio inválido. Espelhos históricos de pai/primeira filha são mantidos como ocupados.

Bloco proposto deste pai: 40–44; âncora do pai: 40. Blocos do conjunto na ordem aprovada: envbar 38–39; tabelas 40–44; temas 45–50. Nenhuma lacuna é reutilizada e nenhum número atual será deslocado. Renovar a leitura integral antes de publicar; colisão exige conciliação, sem recalcular números já autorizados silenciosamente.

## Revisão e publicação

Conjunto completo aprovado por Mário nesta conversa. As operações foram executadas e relidas; IDs e resultados estão na tabela de publicação confirmada abaixo. Não há operação incerta ou bloqueio de publicação.

## Documento Word conferido

O DOCX r001 foi gerado com Microsoft Word 16.0 disponível nesta máquina. O pacote ZIP/OpenXML e o conteúdo legível foram conferidos: 10 condições, equivalentes integralmente ao Markdown da revisão após normalizar apenas a apresentação dos títulos e links. O arquivo aprovado foi associado às QAs previstas e seus anexos foram relidos. As condições representam verificações futuras, não testes já executados.

## Resultado consolidado e pendências

Slicing integralmente publicado e conferido. [D01 #1016403](https://redmine.remsoft.com.br/issues/1016403); [D02 #1016404](https://redmine.remsoft.com.br/issues/1016404); [D03 #1016405](https://redmine.remsoft.com.br/issues/1016405); [D04 #1016406](https://redmine.remsoft.com.br/issues/1016406); [Q01 #1016407](https://redmine.remsoft.com.br/issues/1016407). Total 7h; bloco 40–44, pai espelhando 40. DOCX confirmado: [QA #1016407, anexo 3380](https://redmine.remsoft.com.br/attachments/download/3380/1016398%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx). Arquivos task.md por ID materializados após readback. Próximo passo: plan-issue nas DEVs, respeitando os fornecedores declarados; QAs aguardam implementação. Não houve implementação ou execução de testes do produto.

## Publicação aprovada — execução

Mário aprovou o conjunto completo nesta conversa, incluindo revisão funcional r002 de temas, estimativas corrigidas dos Bugs, Sequencing, relações e DOCX. A identidade textual portátil substitui os caminhos locais na nova publicação; a correspondência ao documento permanece aqui.

| Entrega autorizada | ID/URL confirmado | Resultado | Próximo passo |
| --- | --- | --- | --- |
| D01 | [#1016403](https://redmine.remsoft.com.br/issues/1016403) | Campos, descrição, relações e numeração conferidos | Pronta para plan-issue |
| D02 | [#1016404](https://redmine.remsoft.com.br/issues/1016404) | Campos, descrição, relações e numeração conferidos | Pronta para plan-issue |
| D03 | [#1016405](https://redmine.remsoft.com.br/issues/1016405) | Campos, descrição, relações e numeração conferidos | Pronta para plan-issue |
| D04 | [#1016406](https://redmine.remsoft.com.br/issues/1016406) | Campos, descrição, relações e numeração conferidos | Pronta para plan-issue |
| Q01 | [#1016407](https://redmine.remsoft.com.br/issues/1016407) | Campos, descrição, relações e numeração conferidos; DOCX 3380 associado | Aguardar implementação para executar QA |

Pais permanecem no status atual; anexos e relações existentes serão preservados. Nenhuma implementação autorizada por esta publicação.


## Conferência final do conjunto

Leitura completa final: 59 de 59 issues de FinAi/Livewire; bloco 38–50 sem colisões indevidas, âncoras 38/40/45 e Sequencing das issues alheias preservados. Pais e filhas relidos; descrições, estimativas, versão, prioridade, relações e anexos confirmados. Publicações usam apenas IDs/URLs remotos e identidades textuais portáteis; caminhos de código/fontes ficam no contexto local. Não foram duplicadas as capturas já acessíveis nos pais.

