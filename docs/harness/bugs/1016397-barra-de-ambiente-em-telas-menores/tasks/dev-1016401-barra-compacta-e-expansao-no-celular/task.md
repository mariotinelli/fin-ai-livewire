# [DEV] [WEB] [SUPORTE] Corrigir barra de ambiente em telas menores - Barra compacta e expansão no celular

## Identidade e fontes

- Filha: [#1016401](https://redmine.remsoft.com.br/issues/1016401); papel DEV.
- Pai: [#1016397](https://redmine.remsoft.com.br/issues/1016397); requisito canônico: docs/harness/bugs/1016397-barra-de-ambiente-em-telas-menores/bug.md.
- Slicing aprovado: [slices.md](../../slices/slices.md), revisão r001.
- Sequencing: 38. Estimativa: 2h, corrigida expressamente por Mário; base da proposta: Nova interação sobre controles existentes, com ajuste do espaço reservado nos dois layouts e verificação focada das transições.
- Condições: [Markdown r001](../../slices/condicoes-teste-r001.md); [DOCX confirmado na QA #1016402](https://redmine.remsoft.com.br/attachments/download/3379/1016397%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Situação: publicação e relações conferidas; implementação e execução QA não realizadas.

## Entrega

A barra atual ocupa uma altura fixa e não permite recolher seus detalhes. Torná-la compacta no celular, permitindo expandir e recolher a identificação de branch e os controles de login, com o espaço da página ajustado nos layouts público e autenticado.

## Escopo e limites

A consulta da branch e o uso do LOGIN integram a mesma expansão; seu acesso completo é necessário para que a interação seja útil. Preservar a aparência e o significado da identificação de ambiente, as condições de habilitação da barra e os efeitos e restrições do login. Não corrigir as tabelas nesta tarefa.

## Critérios de aceite

- Até 767px, a barra inicia compacta com ambiente e controle de expansão visíveis, sem corte ou aumento da largura causado pela barra.
- Ao expandir, o nome completo da branch longa pode ser consultado e seleção de usuário e LOGIN ficam alcançáveis. Recolher e reabrir continuam funcionando.
- Com a barra compacta ou expandida, conteúdo e navegação dos layouts público e autenticado permanecem utilizáveis e não ficam encobertos.
- Conferir 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768 e a transição 767/768px, redimensionando com a barra aberta e fechada; informações e controles permanecem alcançáveis.
- Quando a branch não estiver disponível, não apresentar uma área de texto quebrada; ambiente e controles continuam utilizáveis.
- Selecionar um usuário permitido e usar LOGIN mantém o resultado e as restrições atuais. Contextos que não permitem a envbar continuam sem exibi-la.
- Comparar a falha E01 com a correção: a composição compacta/expansível aprovada substitui o corte de conteúdo, preservando a linguagem visual existente.

## Dependências

Não há bloqueios de início ou fornecedores externos. A integração entre a barra e o espaço disponível nos dois layouts faz parte desta entrega.

## Referências

[Pai #1016397](https://redmine.remsoft.com.br/issues/1016397). [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270); identidade e componentes aplicáveis às telas existentes. Evidências do defeito: [E01 — Barra de ambiente em tela menor; captura original de 14/11/2026 às 10:27:39.](https://redmine.remsoft.com.br/attachments/download/3373/e01-envbar-tela-menor.png).

Cobertura: CC01–CC06. Condições: CT-001–CT-008, na revisão r001 do DOCX do pai 1016397. As condições e critérios visuais se aplicam às telas/estados da entrega; a captura de defeito não é mockup final.

Origem: project-slices:1016397:r001:D01.
