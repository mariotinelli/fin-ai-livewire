# [QA] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Preferências e transições de acesso

## Identidade e fontes

- Filha: [#1016412](https://redmine.remsoft.com.br/issues/1016412); papel QA.
- Pai: [#1016399](https://redmine.remsoft.com.br/issues/1016399); requisito canônico: docs/harness/features/1016399-temas-claro-escuro-e-sistema/feature.md.
- Slicing aprovado: [slices.md](../../slices/slices.md), revisão r002.
- Sequencing: 49. Estimativa: 3h, conforme revisão aprovada; pareceres e fundamento em slices.md.
- Condições: [Markdown r002](../../slices/condicoes-teste-r002.md); [DOCX confirmado na QA #1016412](https://redmine.remsoft.com.br/attachments/download/3381/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx); [DOCX confirmado na QA #1016413](https://redmine.remsoft.com.br/attachments/download/3382/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Situação: publicação e relações conferidas; implementação e execução QA não realizadas.

## Entrega

Validar a escolha autenticada, Sistema e lembrança por navegador, bem como a separação entre essa preferência guardada e a aparência automática das telas de acesso.

## Escopo e limites

Preparar contextos independentes, mudança de aparência e falha controlada de lembrança. A varredura visual completa de superfícies e operações fica na QA “Aparência e operações nas telas existentes”, sem reduzir a validação funcional desta tarefa.

## Critérios de aceite

- Executar CT-001, CT-002, CT-004–CT-011, CT-015 e CT-017–CT-019 em suas verificações funcionais, registrando contexto, resultado e evidências de desvios; CT-003 foi retirada e seu ID está reservado.
- Conferir as três opções no menu da conta, Sistema padrão/dinâmico e prioridade das escolhas explícitas, preservando campos/filtros já presentes.
- Conferir lembrança em navegação/recarga/reabertura, entrada/saída/troca de conta, contextos independentes, limpeza de dados e falha controlada de armazenamento.
- Confirmar ausência de seletor nas telas de acesso, inclusive as que exigem sessão; usar dispositivo Claro/Escuro/sem preferência e mudança com campos preenchidos.
- Usar uma escolha autenticada oposta ao dispositivo para comprovar que acesso direto/logout seguem o dispositivo sem apagar a preferência, e que nova entrada a restaura.
- Exercitar as opções autenticadas e o automático de acesso em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768 e 767/768px e 1024/1025px, mantendo controles alcançáveis.
- Usar o DOCX r002 do pai #1016399 e compartilhar resultados com a QA visual para a conferência final, sem substituir a comparação visual por testes de lógica.

## Dependências

A campanha completa aguarda as quatro DEV do pai: escolha no menu da conta, aparência automática de acesso, Sistema e lembrança autenticada. Preparação de contextos pode ser antecipada.

## Referências

[Feature #1016399](https://redmine.remsoft.com.br/issues/1016399), revisão funcional r002 proposta. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270), aplicada às telas e estados existentes. Sem mockup de seletor ou paleta escura exata; seguir R4–R5 e a decisão de retirar o seletor das telas de acesso.

Cobertura: R1–R3 e R6; CA01–CA06, CA08–CA10 em preferências/transições. Condições: CT-001, CT-002, CT-004–CT-011, CT-015, CT-017–CT-019, revisão r002 do documento do pai #1016399.

Origem: project-slices:1016399:r002:Q01.
## Documento de condições

[Condições de teste de #1016399 — r002](https://redmine.remsoft.com.br/attachments/download/3381/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
