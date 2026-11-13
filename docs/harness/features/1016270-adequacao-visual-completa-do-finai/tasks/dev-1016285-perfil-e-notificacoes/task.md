# [DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Perfil e notificações

## Identidade

- Tarefa: [#1016285](https://redmine.remsoft.com.br/issues/1016285).
- Pai: [#1016270](https://redmine.remsoft.com.br/issues/1016270); [requisito](../../feature.md).
- Projeto FinAi (65224), versão Livewire (20359).
- Sequencing: 5.
- Estimativa: 2h, definida pelo responsável.
- [Slicing](../../slices/slices.md).
- [Condições de teste](../../slices/condicoes-teste-r002.md); [DOCX](<../../slices/r002/1016270 - Condições de testes.docx>).

## Entrega

Adequar à identidade FinAI o perfil, os formulários de dados pessoais e senha e o painel e histórico de notificações nas áreas em que existem.

## Escopo e limites

Adaptar a composição dessas telas e preservar eventual apresentação legada ainda utilizada. Não criar uma operação de exclusão de conta onde existe apenas texto sem ação funcional.

## Critérios de aceite

- Apresentar os campos e feedbacks de dados pessoais e senha no padrão FinAI, preservando suas validações e efeitos atuais.
- Manter as operações atuais da conta, sem acrescentar novos recursos ao perfil.
- Preservar os dados, grupos, leitura, carregamento e ações disponíveis no painel e no histórico de notificações.
- Aplicar a identidade FinAI aos estados existentes dos formulários e notificações, incluindo vazio, textos longos, processamento, erros, sucesso, confirmações e cancelamentos quando aplicáveis, além de normal, hover, foco, ativo e desabilitado nos controles.
- Comparar perfil e notificações com a linguagem do design em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, mantendo conteúdo legível e ações alcançáveis, sem rolagem horizontal da página.
- Permitir o uso por teclado, com rótulos e foco preservados, sem menus ou barra inferior encobrindo campos, mensagens e ações da conta.
- Preservar a titularidade dos dados e notificações e as permissões existentes.
- Não introduzir destinos financeiros futuros, dados fictícios ou rótulos de armazenamento local e assistente simulado.

## Dependências

Pode iniciar sobre os formulários e históricos existentes. A identidade compartilhada é fornecida por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual](https://redmine.remsoft.com.br/issues/1016281). A estrutura nas telas maiores é fornecida por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Layout desktop e tablet](https://redmine.remsoft.com.br/issues/1016282) e a navegação móvel por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Navegação no celular e transições](https://redmine.remsoft.com.br/issues/1016283). Integrar essas capacidades para concluir a apresentação desta entrega, sem reconstruí-las.

## Referências

Pai #1016270; R1 (perfil e notificações), R2 e R7/R8 nessas telas; CA01/CA02/CA06/CA08/CA09 correspondentes; CT-010, CT-011 e CT-016.

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Aplicar a linguagem visual comum aos formulários de perfil, painel e histórico de notificações, incluindo seus estados atuais.

Identidade estável: `docs/harness/features/1016270-adequacao-visual-completa-do-finai/slices/slices.md#D05-r001`.

[Design fornecido](../../../../scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip).
