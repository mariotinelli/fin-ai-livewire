# [DEV] [WEB] [USUÁRIO] Corrigir tabelas em telas menores - Colunas e ações com rolagem interna

## Identidade e fontes

- Filha: [#1016403](https://redmine.remsoft.com.br/issues/1016403); papel DEV.
- Pai: [#1016398](https://redmine.remsoft.com.br/issues/1016398); requisito canônico: docs/harness/bugs/1016398-tabelas-em-telas-menores/bug.md.
- Slicing aprovado: [slices.md](../../slices/slices.md), revisão r001.
- Sequencing: 40. Estimativa: 2h, corrigida expressamente por Mário; base da proposta: Adaptação da rolagem existente, margem externa, alinhamento e integração com ações/menus em quatro consumidores.
- Condições: [Markdown r001](../../slices/condicoes-teste-r001.md); [DOCX confirmado na QA #1016407](https://redmine.remsoft.com.br/attachments/download/3380/1016398%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Situação: publicação e relações conferidas; implementação e execução QA não realizadas.

## Entrega

A tabela já possui uma região rolável, mas as evidências mostram conteúdo cortado em telas menores. Ajustar o enquadramento dessa região para consultar todas as colunas e alcançar as ações à direita, mantendo cabeçalhos e células alinhados.

## Escopo e limites

Incluir o enquadramento externo mínimo necessário à região das colunas. Acesso às ações e abertura de seus menus são a resposta necessária à consulta da última coluna. Busca/filtros, paginação e mensagens sem registros têm entregas próprias; cada região deve integrar-se ao contêiner sem alargá-lo.

## Critérios de aceite

- Nas listagens Usuários, Perfis de acesso, Alertas de erros e Histórico de comandos Artisan, com dados e textos longos, rolar internamente até ambos os extremos permite alcançar todos os cabeçalhos, células e ações, sem deslocar a própria região para fora da largura disponível.
- Cabeçalhos e células continuam alinhados durante a rolagem; a apresentação permanece tabular e as ações ficam na coluna à direita, sem exigir colunas fixas.
- Ao alcançar as ações, abrir menus e executar ações já permitidas não deixa controles cortados pela região rolável; efeitos, confirmações e permissões atuais permanecem.
- Conferir a região das colunas em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, incluindo 767/768px e 1024/1025px: quando couber, manter leitura habitual; quando exceder, usar rolagem interna.
- Conferir a região com e sem envbar onde permitido e preservar acesso junto à navegação principal. A ausência de overflow global do conjunto será validada na integração com as outras regiões da tabela.
- Comparar com E02–E04: corrigir os cortes da região de dados sem converter registros em cartões ou alterar consultas.

## Dependências

Não há bloqueios de início. Integrar o enquadramento com “Buscar e filtrar no espaço disponível”, “Paginar no espaço disponível” e “Mensagens sem registros na largura visível” antes do aceite integral do Bug.

## Referências

[Pai #1016398](https://redmine.remsoft.com.br/issues/1016398). [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); identidade e componentes aplicáveis às telas existentes. Evidências do defeito: [E02 — Tabela de Usuários em tela menor; captura original de 14/11/2026 às 10:27:32.](https://redmine.remsoft.com.br/attachments/download/3374/e02-tabela-usuarios-tela-menor.png); [E03 — Tabela de Usuários em largura maior para comparação; captura original de 14/11/2026 às 10:27:15.](https://redmine.remsoft.com.br/attachments/download/3375/e03-tabela-usuarios-comparacao.png); [E04 — Tabela de Usuários com conteúdo cortado; captura original de 14/11/2026 às 10:26:44.](https://redmine.remsoft.com.br/attachments/download/3376/e04-tabela-usuarios-conteudo-cortado.png).

Cobertura: CC01, CC04; CC05–CC07 na região de colunas/ações. Condições: CT-001, CT-002, CT-009, CT-010, na revisão r001 do DOCX do pai 1016398. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem: project-slices:1016398:r001:D01.
