# [QA] [WEB] [SUPORTE] Corrigir barra de ambiente em telas menores

## Identidade e fontes

- Filha: [#1016402](https://redmine.remsoft.com.br/issues/1016402); papel QA.
- Pai: [#1016397](https://redmine.remsoft.com.br/issues/1016397); requisito canônico: docs/harness/bugs/1016397-barra-de-ambiente-em-telas-menores/bug.md.
- Slicing aprovado: [slices.md](../../slices/slices.md), revisão r001.
- Sequencing: 39. Estimativa: 1h, corrigida expressamente por Mário; base da proposta: Preparação de branch e atores, dois layouts, matriz responsiva, login e registro/reteste dirigido.
- Condições: [Markdown r001](../../slices/condicoes-teste-r001.md); [DOCX confirmado na QA #1016402](https://redmine.remsoft.com.br/attachments/download/3379/1016397%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Situação: publicação e relações conferidas; implementação e execução QA não realizadas.

## Entrega

Validar a correção completa da barra de ambiente nos layouts público e autenticado, comparando a falha E01 ao comportamento compacto e expansível aprovado.

## Escopo e limites

Preparar branch longa, usuário permitido e contextos com e sem habilitação da barra; executar as condições e um reteste dirigido dos defeitos encontrados. Não tratar problemas próprios da tabela como ampliação deste Bug.

## Critérios de aceite

- Executar CT-001–CT-008 e registrar, por condição, contexto, resultado observado e evidência dos desvios encontrados.
- Conferir os estados compacto/expandido em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, a transição 767/768px e redimensionamento com a barra aberta e fechada nos dois layouts.
- Conferir branch completa e ausente, LOGIN permitido, preservação das restrições e ausência da barra onde não é habilitada.
- Confirmar que a barra não encobre conteúdo/navegação nem provoca rolagem horizontal global; comparar visualmente a região com a falha E01 e a adaptação aprovada.
- Utilizar o DOCX do pai #1016397, revisão r001, como conjunto completo de condições; registrar defeitos e resultado do reteste dirigido sem afirmar aprovação antes da execução.

## Dependências

A execução integral aguarda “Corrigir barra de ambiente em telas menores - Barra compacta e expansão no celular”. A preparação de dados pode ocorrer antes.

## Referências

[Pai #1016397](https://redmine.remsoft.com.br/issues/1016397). [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); identidade e componentes aplicáveis às telas existentes. Evidências do defeito: [E01 — Barra de ambiente em tela menor; captura original de 14/11/2026 às 10:27:39.](https://redmine.remsoft.com.br/attachments/download/3373/e01-envbar-tela-menor.png).

Cobertura: CC01–CC06. Condições: CT-001–CT-008, na revisão r001 do DOCX do pai 1016397. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem: project-slices:1016397:r001:Q01.
## Documento de condições

[Condições de teste de #1016397 — r001](https://redmine.remsoft.com.br/attachments/download/3379/1016397%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
