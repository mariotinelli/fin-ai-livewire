# [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Sistema como padrão e acompanhamento

## Identidade e fontes

- Filha: [#1016410](https://redmine.remsoft.com.br/issues/1016410); papel DEV.
- Pai: [#1016399](https://redmine.remsoft.com.br/issues/1016399); requisito canônico: docs/harness/features/1016399-temas-claro-escuro-e-sistema/feature.md.
- Slicing aprovado: [slices.md](../../slices/slices.md), revisão r002.
- Sequencing: 47. Estimativa: 1.5h, conforme revisão aprovada; pareceres e fundamento em slices.md.
- Condições: [Markdown r002](../../slices/condicoes-teste-r002.md); [DOCX confirmado na QA #1016412](https://redmine.remsoft.com.br/attachments/download/3381/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx); [DOCX confirmado na QA #1016413](https://redmine.remsoft.com.br/attachments/download/3382/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Situação: publicação e relações conferidas; implementação e execução QA não realizadas.

## Entrega

Acrescentar Sistema como terceira opção no menu da conta da área de trabalho autenticada, como padrão sem escolha válida e com acompanhamento da aparência do dispositivo.

## Escopo e limites

A escolha explícita Claro/Escuro permanece prioritária até o usuário voltar a Sistema. Não duplicar a seleção ou a paleta nem implementar a lembrança persistente, que pertence à tarefa própria.

## Critérios de aceite

- Sem escolha autenticada anterior válida, Sistema fica selecionado no menu da conta e produz a aparência do dispositivo; sem preferência escura, produz Claro.
- O menu da conta apresenta exatamente Claro, Escuro e Sistema e identifica a opção selecionada; Sistema continua identificado mesmo quando sua aparência resultante é clara ou escura.
- Em Sistema, alterar a preferência do dispositivo com a aplicação aberta atualiza a área de trabalho. Em Claro/Escuro explícitos, manter a escolha mesmo com mudança do dispositivo.
- Voltar a Sistema retoma o acompanhamento e não limpa campos, filtros ou contexto já presentes.
- Conferir a opção nas áreas permitidas de cliente/administração/suporte em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, incluindo 767/768px e 1024/1025px, sem alargar a página ou encobrir controles. Telas de acesso permanecem sem seletor.

## Dependências

Bloqueio de início pela primeira seleção/base visual de “Escolher tema claro, escuro ou sistema - Escolha clara e escura no menu da conta”. A aparência automática das telas de acesso compartilha o acompanhamento do dispositivo, sem bloqueio nativo adicional entre as duas entregas. Não aguarda a lembrança autenticada para a interação atual funcionar.

## Referências

[Feature #1016399](https://redmine.remsoft.com.br/issues/1016399), revisão funcional r002 proposta. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270), aplicada às telas e estados existentes. Sem mockup de seletor ou paleta escura exata; seguir R4–R5 e a decisão de retirar o seletor das telas de acesso.

Cobertura: R1 opções/padrão autenticado; R3 e R6 nessa interação; CA01–CA03, CA06 e CA08 na área de trabalho. Condições: CT-001, CT-002, CT-006, CT-007, CT-015, revisão r002 do documento do pai #1016399.

Origem: project-slices:1016399:r002:D03.
