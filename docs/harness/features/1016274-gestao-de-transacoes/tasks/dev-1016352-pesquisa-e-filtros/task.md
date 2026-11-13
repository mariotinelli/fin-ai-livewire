# [DEV] [WEB] [USUARIO] Gestão de transações - Pesquisa e filtros

## Identidade e fontes

- Filha: [#1016352](https://redmine.remsoft.com.br/issues/1016352); papel: DEV; status remoto conferido: New.
- Pai: [Gestão de transações — #1016274](https://redmine.remsoft.com.br/issues/1016274); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **12**; pai espelha 11.
- Estimativa: **2h**, corrigida pelo responsável e publicada. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Gestão de transações - Histórico por mês e detalhes — #1016351](https://redmine.remsoft.com.br/issues/1016351).
- Condições da Feature: [CT-001–CT-025, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016274 - Condições de testes.docx>), [anexo #3363 da QA #1016356](https://redmine.remsoft.com.br/attachments/download/3363/1016274%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Permitir localizar transações próprias por trecho da descrição e pela combinação de tipo, categoria e mês, com consulta, contagem e paginação fiéis ao recorte e limpeza completa dos filtros.

## Escopo e limites

Usar o histórico e os detalhes já entregues. Mês e consulta de todo o histórico pertencem à entrega Histórico por mês e detalhes; esta tarefa integra esses controles à pesquisa e aos novos filtros de tipo/categoria, sem refazer a consulta de base.

## Critérios de aceite

- Pesquisar parte da descrição ignora caixa e acentos e trata %, _ e ! como texto literal, sem ampliar a consulta para registros alheios.
- Os filtros isolados ou combinados de tipo, categoria e mês restringem os registros próprios em conjunto com a descrição.
- As categorias nos filtros usam exatamente Salário, Freelance, Rendimentos, Outras receitas, Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras e Outras despesas, preservando nomes e acentos do catálogo comum.
- Limpar filtros remove descrição, tipo, categoria e mês, passando a consultar todo o histórico próprio.
- Alterar pesquisa ou qualquer filtro retorna à primeira página; contagem e controles anterior/próxima permanecem coerentes com o resultado e com o limite de 50 por página.
- Sem correspondências, informar ausência no recorte e permitir ajuste/limpeza. Não confundir esse estado com conta sem registros nem com falha de carregamento.
- Falha ao consultar informa erro e permite tentar novamente sem exibir dados de outra conta ou aparentar histórico vazio.
- Visitante e conta pendente continuam impedidos de consultar; troca de conta não conserva resultados da anterior.
- Comparar #transactions, #search, #type-filter, #category-filter, #filter-count e #clear-filters com V01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, nos estados aplicáveis de normal, foco, processamento, vazio e erro. Rótulos, nomes de categorias, controles e resultados permanecem legíveis e utilizáveis, sem sobreposição nem rolagem horizontal da página.

## Dependências

O início depende de Gestão de transações - Histórico por mês e detalhes, que fornece a navegação, a leitura própria, o catálogo e a paginação sobre F01/F02 já verificadas. A implementação do cadastro não é necessária: dados próprios de homologação permitem demonstrar a pesquisa.

## Referências

[Pai #1016274](https://redmine.remsoft.com.br/issues/1016274); R5–R8/R12; CA04/CA05/CA09–CA15 nas parcelas de pesquisa; CT-002/CT-003, CT-010, CT-012–CT-014, CT-019, CT-023–CT-025.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final de suas regras e `DESIGN-HANDOFF.md`. Locadores: #transactions, .filters, #search, #type-filter, #category-filter, #clear-filters e #pagination. Aplicar pesquisa e permissões aprovadas, sem reproduzir armazenamento local.

Intenção estável de criação: `docs/harness/features/1016274-gestao-de-transacoes/slices/slices.md#D02-r001`.
