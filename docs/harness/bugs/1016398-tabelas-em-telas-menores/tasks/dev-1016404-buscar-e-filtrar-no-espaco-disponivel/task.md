# [DEV] [WEB] [USUÁRIO] Corrigir tabelas em telas menores - Buscar e filtrar no espaço disponível

## Identidade e fontes

- Filha: [#1016404](https://redmine.remsoft.com.br/issues/1016404); papel DEV.
- Pai: [#1016398](https://redmine.remsoft.com.br/issues/1016398); requisito canônico: docs/harness/bugs/1016398-tabelas-em-telas-menores/bug.md.
- Slicing aprovado: [slices.md](../../slices/slices.md), revisão r001.
- Sequencing: 41. Estimativa: 1h, corrigida expressamente por Mário; base da proposta: Adaptação da largura mínima e agrupamentos, painel de filtros e conferência dos consumidores sem reescrever consultas.
- Condições: [Markdown r001](../../slices/condicoes-teste-r001.md); [DOCX confirmado na QA #1016407](https://redmine.remsoft.com.br/attachments/download/3380/1016398%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Situação: publicação e relações conferidas; implementação e execução QA não realizadas.

## Entrega

A busca e os filtros já funcionam, mas sua composição pode exceder a largura disponível. Tornar a consulta por busca e filtros utilizável no cabeçalho da tabela em telas menores, preservando as regras e os resultados atuais.

## Escopo e limites

Busca e filtros compõem a mesma consulta pelo cabeçalho, com confirmação e limpeza existentes. A navegação entre páginas e a região das colunas permanecem nas tarefas próprias.

## Critérios de aceite

- Nas telas Usuários, Perfis de acesso, Alertas de erros e Histórico de comandos Artisan, a busca existente fica visível e utilizável na largura disponível, independentemente da posição horizontal das colunas.
- Nas telas com filtros, abrir, preencher, aplicar e limpar o painel mantém campos, botões e contadores alcançáveis, sem corte pelo contêiner rolável.
- Resultados da busca, critérios aplicados, contadores e regras de autorização/validação continuam equivalentes aos atuais; não consultar por mudanças de apresentação.
- Conferir cabeçalho e painel em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, incluindo 767/768px e 1024/1025px, com e sem envbar onde permitido: a região de consulta não alarga a página nem encobre navegação/ações.
- Manter campos e contadores externos à rolagem das colunas, preservando a linguagem visual das listagens.

## Dependências

Não há bloqueios de início. Integrar o cabeçalho com as regiões de colunas, paginação e mensagens entregues pelas outras tarefas do Bug para a QA integral.

## Referências

[Pai #1016398](https://redmine.remsoft.com.br/issues/1016398). [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); identidade e componentes aplicáveis às telas existentes. Evidências do defeito: [E02 — Tabela de Usuários em tela menor; captura original de 14/11/2026 às 10:27:32.](https://redmine.remsoft.com.br/attachments/download/3374/e02-tabela-usuarios-tela-menor.png); [E03 — Tabela de Usuários em largura maior para comparação; captura original de 14/11/2026 às 10:27:15.](https://redmine.remsoft.com.br/attachments/download/3375/e03-tabela-usuarios-comparacao.png); [E04 — Tabela de Usuários com conteúdo cortado; captura original de 14/11/2026 às 10:26:44.](https://redmine.remsoft.com.br/attachments/download/3376/e04-tabela-usuarios-conteudo-cortado.png).

Cobertura: CC02 na busca/filtros; CC04 nos filtros; CC05–CC07 nessa região. Condições: CT-003, CT-004, CT-009, CT-010, na revisão r001 do DOCX do pai 1016398. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem: project-slices:1016398:r001:D02.
