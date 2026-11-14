# [DEV] [WEB] [USUÁRIO] Corrigir tabelas em telas menores - Mensagens sem registros na largura visível

## Identidade e fontes

- Filha: [#1016406](https://redmine.remsoft.com.br/issues/1016406); papel DEV.
- Pai: [#1016398](https://redmine.remsoft.com.br/issues/1016398); requisito canônico: docs/harness/bugs/1016398-tabelas-em-telas-menores/bug.md.
- Slicing aprovado: [slices.md](../../slices/slices.md), revisão r001.
- Sequencing: 43. Estimativa: 1h, corrigida expressamente por Mário; base da proposta: Adaptação dos estados existentes em células largas, incluindo nenhum resultado e filtros inválidos nos consumidores aplicáveis.
- Condições: [Markdown r001](../../slices/condicoes-teste-r001.md); [DOCX confirmado na QA #1016407](https://redmine.remsoft.com.br/attachments/download/3380/1016398%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Situação: publicação e relações conferidas; implementação e execução QA não realizadas.

## Entrega

As mensagens sem registros são renderizadas dentro da tabela e aparecem cortadas nas evidências. Tornar legíveis, sem rolagem horizontal, os estados de lista vazia, nenhum resultado e consulta não executada por filtros inválidos onde já existirem.

## Escopo e limites

Os estados e suas ações já existem; adaptar sua apresentação sem criar mensagens ou validações novas. Preservar o resultado tabular das consultas com dados, entregue em “Colunas e ações com rolagem interna”.

## Critérios de aceite

- Nas listagens Usuários, Perfis de acesso, Alertas de erros e Histórico de comandos Artisan, o estado de lista vazia apresenta título e descrição completos dentro da largura visível, sem exigir rolagem horizontal para lê-los.
- Uma busca ou filtro sem resultado apresenta mensagem completa e ações de recuperação existentes, que continuam alcançáveis e operantes.
- Quando existente, o estado de consulta não executada por filtros inválidos mantém texto e orientações legíveis sem alterar a validação.
- Conferir as mensagens em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768 e 767/768px e 1024/1025px, com e sem envbar onde permitido; permitir quebra de texto sem deslocar conteúdo, navegação ou ações para fora da página.
- Comparar com as mensagens cortadas de E02/E04 e preservar ícones, hierarquia, linguagem visual e leitura habitual quando houver espaço.

## Dependências

Não há bloqueios de início. Integrar os estados sem registros com o enquadramento das colunas e os controles de consulta/paginação antes do aceite integral.

## Referências

[Pai #1016398](https://redmine.remsoft.com.br/issues/1016398). [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); identidade e componentes aplicáveis às telas existentes. Evidências do defeito: [E02 — Tabela de Usuários em tela menor; captura original de 14/11/2026 às 10:27:32.](https://redmine.remsoft.com.br/attachments/download/3374/e02-tabela-usuarios-tela-menor.png); [E03 — Tabela de Usuários em largura maior para comparação; captura original de 14/11/2026 às 10:27:15.](https://redmine.remsoft.com.br/attachments/download/3375/e03-tabela-usuarios-comparacao.png); [E04 — Tabela de Usuários com conteúdo cortado; captura original de 14/11/2026 às 10:26:44.](https://redmine.remsoft.com.br/attachments/download/3376/e04-tabela-usuarios-conteudo-cortado.png).

Cobertura: CC03; CC05–CC07 nos estados sem registros. Condições: CT-006, CT-007, CT-008, CT-009, CT-010, na revisão r001 do DOCX do pai 1016398. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem: project-slices:1016398:r001:D04.
