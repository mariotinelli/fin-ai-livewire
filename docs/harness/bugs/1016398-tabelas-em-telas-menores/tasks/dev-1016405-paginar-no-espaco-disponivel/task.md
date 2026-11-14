# [DEV] [WEB] [USUÁRIO] Corrigir tabelas em telas menores - Paginar no espaço disponível

## Identidade e fontes

- Filha: [#1016405](https://redmine.remsoft.com.br/issues/1016405); papel DEV.
- Pai: [#1016398](https://redmine.remsoft.com.br/issues/1016398); requisito canônico: docs/harness/bugs/1016398-tabelas-em-telas-menores/bug.md.
- Slicing aprovado: [slices.md](../../slices/slices.md), revisão r001.
- Sequencing: 42. Estimativa: 1h, corrigida expressamente por Mário; base da proposta: Rodapé responsivo já existente; resta enquadramento e verificação dos controles e contadores nos consumidores.
- Condições: [Markdown r001](../../slices/condicoes-teste-r001.md); [DOCX confirmado na QA #1016407](https://redmine.remsoft.com.br/attachments/download/3380/1016398%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Situação: publicação e relações conferidas; implementação e execução QA não realizadas.

## Entrega

A paginação e a quantidade por página já existem. Ajustar seu enquadramento em telas menores para percorrer páginas e consultar os contadores sem deslocamento horizontal da região das colunas.

## Escopo e limites

Abrange rodapé, seleção de quantidade e contadores. Preservar as consultas, buscas e filtros já aplicados; não recriar mecanismos de paginação.

## Critérios de aceite

- Com mais de uma página em Usuários, Perfis de acesso, Alertas de erros e Histórico de comandos Artisan, os controles de página, quantidade e contadores permanecem visíveis e utilizáveis na largura disponível.
- Rolar horizontalmente as colunas não desloca o rodapé. Mudar página e quantidade preserva os efeitos e restrições existentes, inclusive manutenção dos critérios da consulta.
- Conferir o rodapé em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, incluindo 767/768px e 1024/1025px, com e sem envbar onde permitido; ele não alarga a página nem perde acesso ao alcançar o fim da listagem.
- Manter a aparência dos contadores e controles coerente com a listagem existente, sem omitir informações para fazê-los caber.

## Dependências

Não há bloqueios de início. Integrar o rodapé às demais regiões da tabela antes da QA integral.

## Referências

[Pai #1016398](https://redmine.remsoft.com.br/issues/1016398). [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); identidade e componentes aplicáveis às telas existentes. Evidências do defeito: [E02 — Tabela de Usuários em tela menor; captura original de 14/11/2026 às 10:27:32.](https://redmine.remsoft.com.br/attachments/download/3374/e02-tabela-usuarios-tela-menor.png); [E03 — Tabela de Usuários em largura maior para comparação; captura original de 14/11/2026 às 10:27:15.](https://redmine.remsoft.com.br/attachments/download/3375/e03-tabela-usuarios-comparacao.png); [E04 — Tabela de Usuários com conteúdo cortado; captura original de 14/11/2026 às 10:26:44.](https://redmine.remsoft.com.br/attachments/download/3376/e04-tabela-usuarios-conteudo-cortado.png).

Cobertura: CC02 na paginação; CC05–CC07 no rodapé. Condições: CT-005, CT-009, CT-010, na revisão r001 do DOCX do pai 1016398. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem: project-slices:1016398:r001:D03.
