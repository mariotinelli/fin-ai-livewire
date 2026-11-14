# [QA] [WEB] [USUÁRIO] Corrigir tabelas em telas menores

## Identidade e fontes

- Filha: [#1016407](https://redmine.remsoft.com.br/issues/1016407); papel QA.
- Pai: [#1016398](https://redmine.remsoft.com.br/issues/1016398); requisito canônico: docs/harness/bugs/1016398-tabelas-em-telas-menores/bug.md.
- Slicing aprovado: [slices.md](../../slices/slices.md), revisão r001.
- Sequencing: 44. Estimativa: 2h, corrigida expressamente por Mário; base da proposta: Quatro consumidores, dados longos, múltiplas páginas, estados, ações e matriz responsiva; preparação compartilhada, registro e reteste dirigido.
- Condições: [Markdown r001](../../slices/condicoes-teste-r001.md); [DOCX confirmado na QA #1016407](https://redmine.remsoft.com.br/attachments/download/3380/1016398%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Situação: publicação e relações conferidas; implementação e execução QA não realizadas.

## Entrega

Validar a tabela completa nas quatro listagens consumidoras, incluindo consulta dos dados e ações, busca, filtros, paginação e estados sem registros no espaço disponível.

## Escopo e limites

Preparar registros longos, mais de uma página e cenários sem dados/resultado. A QA integrada verifica o enquadramento do conjunto, sem tratar a validação isolada das regiões como prova de ausência de rolagem horizontal global.

## Critérios de aceite

- Executar CT-001–CT-010 no conjunto dos quatro consumidores, registrando os cenários aplicáveis a cada tela e as evidências dos desvios.
- Conferir 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, as transições 767/768px e 1024/1025px e a integração com e sem envbar onde permitido.
- Conferir todas as colunas e ações à direita, alinhamento, menus sem cortes, busca/filtros utilizáveis, paginação, quantidade e contadores externos à rolagem.
- Conferir lista vazia, nenhum resultado e filtros inválidos onde disponíveis: texto e ações completos sem rolagem horizontal para leitura.
- Confirmar que a tabela inteira não alarga a página, preserva navegação, permissões, consultas, resultados e confirmações; comparar o resultado às falhas E02–E04.
- Usar o DOCX do pai #1016398 r001, registrar resultados e realizar um reteste dirigido das correções encontradas.

## Dependências

A campanha completa aguarda “Colunas e ações com rolagem interna”, “Buscar e filtrar no espaço disponível”, “Paginar no espaço disponível” e “Mensagens sem registros na largura visível”, todas do Bug “Corrigir tabelas em telas menores”.

## Referências

[Pai #1016398](https://redmine.remsoft.com.br/issues/1016398). [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); identidade e componentes aplicáveis às telas existentes. Evidências do defeito: [E02 — Tabela de Usuários em tela menor; captura original de 14/11/2026 às 10:27:32.](https://redmine.remsoft.com.br/attachments/download/3374/e02-tabela-usuarios-tela-menor.png); [E03 — Tabela de Usuários em largura maior para comparação; captura original de 14/11/2026 às 10:27:15.](https://redmine.remsoft.com.br/attachments/download/3375/e03-tabela-usuarios-comparacao.png); [E04 — Tabela de Usuários com conteúdo cortado; captura original de 14/11/2026 às 10:26:44.](https://redmine.remsoft.com.br/attachments/download/3376/e04-tabela-usuarios-conteudo-cortado.png).

Cobertura: CC01–CC07. Condições: CT-001–CT-010, na revisão r001 do DOCX do pai 1016398. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem: project-slices:1016398:r001:Q01.
## Documento de condições

[Condições de teste de #1016398 — r001](https://redmine.remsoft.com.br/attachments/download/3380/1016398%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
