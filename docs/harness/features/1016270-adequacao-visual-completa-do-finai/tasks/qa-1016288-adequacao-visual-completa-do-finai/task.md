# [QA] [WEB] [USUARIO] Adequação visual completa do FinAI

## Identidade

- Tarefa: [#1016288](https://redmine.remsoft.com.br/issues/1016288).
- Pai: [#1016270](https://redmine.remsoft.com.br/issues/1016270); [requisito](../../feature.md).
- Projeto FinAi (65224), versão Livewire (20359).
- Sequencing: 8.
- Estimativa: 4h, definida pelo responsável.
- [Slicing](../../slices/slices.md).
- [Condições de teste](../../slices/condicoes-teste-r002.md); [DOCX](<../../slices/r002/1016270 - Condições de testes.docx>).

## Entrega

Verificar integralmente as condições CT-001–CT-018 da revisão r002 e o resultado completo da adequação visual, registrando evidências, defeitos e um reteste focalizado.

## Escopo e limites

Executar uma única QA da Feature inteira. Preservar as operações existentes e utilizar dados próprios de teste; não criar funcionalidades para suprir lacunas do inventário.

## Critérios de aceite

- Comparar identidade, marca, cores, tipografia, componentes, layout e estados das telas existentes abrangidas com o design fornecido. Telas sem mockup específico herdam a linguagem visual.
- Percorrer a matriz 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080 em todas as telas abrangidas, verificando legibilidade, controles alcançáveis e ausência de sobreposições ou rolagem horizontal da página.
- Verificar a lateral desktop recolhível, a lateral compacta de tablet de 72px e a navegação inferior do celular com área segura, conforme os critérios e medidas de CT-002–CT-004.
- Após recolher a lateral desktop, conferir as transições 767/768px e 1024/1025px sem perda de ações ou aplicação do modo incorreto.
- Conferir destinos autorizados e acesso à conta, ao perfil, às notificações e à saída nas áreas de cliente, administração e suporte, preservando as restrições de acesso.
- Usar mouse e teclado para verificar rótulos, foco e todos os estados atuais aplicáveis.
- Verificar cadastro, três logins, recuperação e redefinição de senha, verificação e reenvio de e-mail e confirmação de senha.
- Verificar dados pessoais, senha, painel e histórico de notificações nas áreas em que existem.
- Conferir listas, formulários e ações existentes de usuários e perfis de acesso.
- Conferir lista e detalhes de alertas e executor e histórico de comandos de suporte.
- Preservar campos, validações, confirmações, cancelamentos e efeitos das funções atuais, com listas vazias ou longas, textos técnicos e valores extensos.
- Utilizar somente comandos de suporte seguros e autorizados nos dados próprios de teste.
- Não criar exclusão de conta funcional onde ela não existe, novos destinos financeiros, dados fictícios ou rótulos de simulação.
- Registrar o resultado de R1–R10, CA01–CA11 e CT-001–CT-018 e repetir os cenários afetados por ajustes posteriores nos componentes ou na navegação.
- Basear a avaliação de fidelidade em comparação com a referência; testes de lógica ou screenshots sem comparação não comprovam conformidade visual.

## Dependências

Executar após a conclusão das seguintes tarefas:

- [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual](https://redmine.remsoft.com.br/issues/1016281).
- [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Layout desktop e tablet](https://redmine.remsoft.com.br/issues/1016282).
- [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Navegação no celular e transições](https://redmine.remsoft.com.br/issues/1016283).
- [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Jornadas de acesso](https://redmine.remsoft.com.br/issues/1016284).
- [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Perfil e notificações](https://redmine.remsoft.com.br/issues/1016285).
- [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Gestão de usuários e perfis](https://redmine.remsoft.com.br/issues/1016286).
- [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Alertas e comandos de suporte](https://redmine.remsoft.com.br/issues/1016287).

## Referências

Pai #1016270; R1–R10 e CA01–CA11; condições r002, CT-001–CT-018.

[Condições de teste r002 — DOCX anexado](https://redmine.remsoft.com.br/attachments/download/3354/1016270%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Comparar todas as telas do inventário e seus estados aplicáveis, preservando as adaptações aprovadas para telas sem mockup.

Identidade estável: `docs/harness/features/1016270-adequacao-visual-completa-do-finai/slices/slices.md#QA-r002`.

[Design fornecido](../../../../scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip).
