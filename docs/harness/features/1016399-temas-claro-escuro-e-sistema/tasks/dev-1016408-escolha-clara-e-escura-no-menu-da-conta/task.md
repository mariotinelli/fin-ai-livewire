# [DEV] [WEB] [USUÁRIO] Escolher tema claro, escuro ou sistema - Escolha clara e escura no menu da conta

## Identidade e fontes

- Filha: [#1016408](https://redmine.remsoft.com.br/issues/1016408); papel DEV.
- Pai: [#1016399](https://redmine.remsoft.com.br/issues/1016399); requisito canônico: docs/harness/features/1016399-temas-claro-escuro-e-sistema/feature.md.
- Slicing aprovado: [slices.md](../../slices/slices.md), revisão r002.
- Sequencing: 45. Estimativa: 5h, conforme revisão aprovada; pareceres e fundamento em slices.md.
- Condições: [Markdown r002](../../slices/condicoes-teste-r002.md); [DOCX confirmado na QA #1016412](https://redmine.remsoft.com.br/attachments/download/3381/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx); [DOCX confirmado na QA #1016413](https://redmine.remsoft.com.br/attachments/download/3382/1016399%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Situação: publicação e relações conferidas; implementação e execução QA não realizadas.

## Entrega

Disponibilizar Claro e Escuro no menu da conta da área de trabalho autenticada, entregando junto a paleta e os estados compartilhados que tornam a escolha visível e utilizável em cliente, administração e suporte.

## Escopo e limites

Cobrir dashboard atual, perfil, notificações, Usuários, Perfis de acesso, Alertas de erros, executor e Histórico de comandos conforme permissões existentes. A paleta e os estados comuns integram esta primeira interação real; não são preparação interna separada. A aparência automática nas telas de acesso, a opção Sistema e a lembrança por navegador têm entregas próprias. Não oferecer uma opção Sistema inoperante; o pai só estará completo com as três opções.

## Critérios de aceite

- Cliente, administrador e suporte encontram o seletor no menu da conta das telas já autorizadas e alternam Claro/Escuro na tela atual; a opção escolhida fica identificável e os outros controles do menu continuam alcançáveis.
- Alternar com formulário preenchido ou filtros aplicados mantém campos, critérios e contexto; não exige salvar perfil ou sair e entrar novamente.
- Claro preserva marca, hierarquia e identidade FinAI; Escuro adapta superfícies, textos, bordas, ícones e estados com legibilidade em dashboard, perfil, notificações, gestão e suporte, incluindo tabelas e saída de comandos. Não há paleta escura exata ou mockup aprovado.
- Menus, diálogos, painéis laterais, seleção, foco, desabilitado, carregamento, sucesso, aviso, erro e estados vazios conservam o significado e a legibilidade.
- Conferir menu da conta e superfícies autenticadas em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768 e 1366×768, incluindo 767/768px e 1024/1025px; a seleção não alarga a página nem encobre conteúdo, navegação ou ações.
- Permissões, resultados de operações e impressão/PDF/exportações disponíveis mantêm as regras e aparência anteriores; envbar permitida conserva informações e distinções legíveis.

## Dependências

Não há bloqueio de início nem novo fornecedor externo. Usa a identidade FinAI existente de #1016270. Fornece a base visual compartilhada implementada e verificável às demais entregas de temas.

## Referências

[Feature #1016399](https://redmine.remsoft.com.br/issues/1016399), revisão funcional r002 proposta. [Identidade visual #1016270](https://redmine.remsoft.com.br/issues/1016270), aplicada às telas e estados existentes. Sem mockup de seletor ou paleta escura exata; seguir R4–R5 e a decisão de retirar o seletor das telas de acesso.

Cobertura: R1 Claro/Escuro; R3–R6 na área de trabalho; CA02, CA06–CA08 e CA10 nessas superfícies. Condições: CT-004, CT-005, CT-013–CT-016 na área de trabalho, revisão r002 do documento do pai #1016399.

Origem: project-slices:1016399:r002:D01.
