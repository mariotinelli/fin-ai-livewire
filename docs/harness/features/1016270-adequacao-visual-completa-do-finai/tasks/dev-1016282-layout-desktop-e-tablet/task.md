# [DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Layout desktop e tablet

## Identidade

- Tarefa: [#1016282](https://redmine.remsoft.com.br/issues/1016282).
- Pai: [#1016270](https://redmine.remsoft.com.br/issues/1016270); [requisito](../../feature.md).
- Projeto FinAi (65224), versão Livewire (20359).
- Sequencing: 2.
- Estimativa: 2h, definida pelo responsável.
- [Slicing](../../slices/slices.md).
- [Condições de teste](../../slices/condicoes-teste-r002.md); [DOCX](<../../slices/r002/1016270 - Condições de testes.docx>).

## Entrega

Reorganizar o cabeçalho, a navegação lateral e a superfície de conteúdo das áreas de cliente, administração e suporte a partir de 768px, seguindo o design fornecido.

## Escopo e limites

Esta entrega abrange a composição de tablet e desktop. Preservar os destinos, grupos e operações atuais; a composição do celular é fornecida pela tarefa de navegação móvel.

## Critérios de aceite

- A partir de 1025px, apresentar a lateral desktop com recolhimento funcional e indicação do destino ativo.
- Manter todos os destinos e ações autorizados alcançáveis com a lateral desktop aberta ou recolhida.
- De 768 a 1024px inclusive, apresentar a lateral compacta de 72px mais a área segura, marca compacta, alvos de pelo menos 48px e conteúdo ao lado, sem barra inferior.
- Com altura de tela reduzida no tablet, manter todos os controles da lateral e da conta alcançáveis.
- A partir de 768px, apresentar superfície de trabalho com contorno de 1px, raio de 16px, margem de 8px e cabeçalho transparente, preservando a relação entre navegação e conteúdo do design.
- Manter acesso à conta, ao perfil, às notificações e à saída nas três áreas, por mouse e teclado, sem ampliar permissões ou modificar o resultado das operações.
- Nos controles de navegação, preservar rótulos, foco visível e os estados atuais aplicáveis, incluindo normal, hover, ativo, desabilitado, carregamento e feedbacks existentes.
- Comparar a composição de tablet e desktop com a referência e conferir sua integração em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, preservando a identidade FinAI, sem rolagem horizontal da página ou ações encobertas.
- Usar apenas destinos implementados e manter mensagens funcionais coerentes, sem páginas financeiras antecipadas ou rótulos de simulação.

## Dependências

Pode iniciar sobre a navegação existente. Para concluir a apresentação, integrar [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual](https://redmine.remsoft.com.br/issues/1016281). A tarefa [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Navegação no celular e transições](https://redmine.remsoft.com.br/issues/1016283) verifica as transições entre faixas em conjunto com esta entrega.

## Referências

Pai #1016270; R5, R6, R7/R8 na navegação a partir de 768px; CA03, CA04 e parcelas de CA02/CA06/CA07/CA08/CA09; CT-002, CT-003, CT-005 e CT-009.

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Comparar as regras finais de `.app`, `.sidebar`, `.workspace` e `.topbar`, incluindo marca, contorno e estados da navegação.

Identidade estável: `docs/harness/features/1016270-adequacao-visual-completa-do-finai/slices/slices.md#D02-r001`.

[Design fornecido](../../../../scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip).
