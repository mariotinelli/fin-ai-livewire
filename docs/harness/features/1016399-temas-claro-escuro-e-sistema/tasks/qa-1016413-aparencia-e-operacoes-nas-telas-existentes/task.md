# [QA] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Aparência e operações nas telas existentes

## Identidade e fontes

- Filha: [#1016413](https://redmine.remsoft.com.br/issues/1016413); papel QA.
- Pai: [#1016399](https://redmine.remsoft.com.br/issues/1016399); requisito canônico: docs/harness/features/1016399-temas-claro-escuro-e-sistema/feature.md.
- Slicing aprovado: [slices.md](../../slices/slices.md), revisão r002.
- Sequencing: 50. Estimativa: 4h, conforme revisão aprovada; pareceres e fundamento em slices.md.
- Condições: [Markdown r002](../../slices/condicoes-teste-r002.md); [DOCX confirmado na QA #1016412](https://redmine.remsoft.com.br/attachments/download/3381/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx); [DOCX confirmado na QA #1016413](https://redmine.remsoft.com.br/attachments/download/3382/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Situação: publicação e relações conferidas; implementação e execução QA não realizadas.

## Entrega

Validar a cobertura visual de Claro e Escuro em todas as telas existentes abrangidas e a preservação das operações, consolidando o resultado com a QA de escolha e continuidade.

## Escopo e limites

Cobertura pública: Login de cliente, administração e suporte; cadastro; recuperação e redefinição de senha; verificação de e-mail e confirmação de senha, conforme as condições reais de acesso. Cobertura autenticada: Dashboard atual, perfil, notificações, Usuários, Perfis de acesso, Alertas de erros, executor e Histórico de comandos Artisan, conforme permissões de cliente, administrador e suporte. Conferir identidade, estados e legibilidade por comparação humana, sem exigir uma paleta escura ou mockup que não foram aprovados.

## Critérios de aceite

- Executar CT-012–CT-014 e CT-016 no inventário completo; usar CT-015 e CT-017–CT-018 para a composição visual nas faixas e transições.
- Nas telas de acesso, obter as duas aparências pelo dispositivo, sem seletor. Na área de trabalho, obter pelo menu da conta; incluir cliente, administração e suporte conforme acessos.
- Comparar a identidade clara e a hierarquia FinAI de #1016270; em Escuro, conferir adaptação legível de superfícies, bordas, textos, ícones e estados, sem paleta exata inventada.
- Conferir tabelas com dados/vazias, formulários, erros, foco, seleção, desabilitado, carregamento, sucesso, avisos, menus, diálogos, painéis, notificações, envbar permitida e saída de comandos.
- Percorrer 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768 e 767/768px e 1024/1025px; as telas de acesso ficam sem seletor e a área de trabalho mantém o menu utilizável sem alargar a página ou encobrir ações.
- Registrar por tela as operações existentes exercitadas nas duas aparências, resultados/restrições e casos não aplicáveis. Impressão, PDFs e exportações mantêm suas regras e aparência anteriores.
- Consolidar com a QA de preferências o resultado integrado, registrar desvios e um reteste dirigido, sem declarar aprovação antes das duas campanhas. Usar o DOCX integral r002 do pai #1016399.

## Dependências

A campanha completa aguarda as quatro DEV do pai. A QA “Preferências e transições de acesso” fornece seus resultados à conferência final; não há bloqueio de início entre as duas QAs.

## Referências

[Feature #1016399](https://redmine.remsoft.com.br/issues/1016399), revisão funcional r002 proposta. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270), aplicada às telas e estados existentes. Sem mockup de seletor ou paleta escura exata; seguir R4–R5 e a decisão de retirar o seletor das telas de acesso.

Cobertura: R3–R6; CA06–CA08 e CA10 na aparência/operações. Condições: CT-012–CT-018 na cobertura visual/operações, revisão r002 do documento do pai #1016399.

Origem: project-slices:1016399:r002:Q02.
## Documento de condições

[Condições de teste de #1016399 — r002](https://redmine.remsoft.com.br/attachments/download/3382/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
