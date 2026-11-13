# [DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Navegação no celular e transições

## Identidade

- Tarefa: [#1016283](https://redmine.remsoft.com.br/issues/1016283).
- Pai: [#1016270](https://redmine.remsoft.com.br/issues/1016270); [requisito](../../feature.md).
- Projeto FinAi (65224), versão Livewire (20359).
- Sequencing: 3.
- Estimativa: 2h, definida pelo responsável.
- [Slicing](../../slices/slices.md).
- [Condições de teste](../../slices/condicoes-teste-r002.md); [DOCX](<../../slices/r002/1016270 - Condições de testes.docx>).

## Entrega

Substituir a apresentação móvel atual pela marca no topo e pela navegação inferior do design. Manter os destinos autorizados e as ações da conta nas três áreas e verificar a mudança de modo ao redimensionar.

## Escopo e limites

Esta entrega abrange a composição até 767px e a integração das transições. A geometria de tablet e desktop é fornecida pela tarefa responsável por essas faixas.

## Critérios de aceite

- Até 767px, apresentar a marca no topo e a barra inferior em largura total, com base de 56px acrescida da área segura inferior.
- Usar ícones de 24px e alvos de pelo menos 44px, sem legenda visual, com nomes acessíveis, foco visível e indicação do destino ativo.
- Manter acesso aos destinos e grupos autorizados, à conta, ao perfil, às notificações e à saída nas áreas de cliente, administração e suporte.
- Adaptar menus com mais destinos que os três itens do protótipo, preservando as opções existentes sem criar navegação financeira futura.
- Ao rolar, focar controles e abrir menus, notificações, diálogos e painéis, manter conteúdo, mensagens e ações livres da barra inferior e da área segura.
- Após recolher a lateral desktop, redimensionar entre 767/768px e 1024/1025px aplicando o modo correto, sem perder ações ou foco e sem manter barra inferior nas faixas maiores.
- Preservar rótulos, uso por teclado e os estados atuais aplicáveis da navegação e de seus feedbacks, sem alterar dados, operações, validações ou permissões.
- Comparar a composição móvel e as transições com o design fornecido e conferir a integração em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, mantendo a identidade FinAI e sem rolagem horizontal da página.
- Não introduzir mensagens de armazenamento local ou assistente simulado nos elementos de navegação.

## Dependências

Pode iniciar sobre a navegação existente. Para concluir e verificar as transições, integrar [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual](https://redmine.remsoft.com.br/issues/1016281) e [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Layout desktop e tablet](https://redmine.remsoft.com.br/issues/1016282).

## Referências

Pai #1016270; R4, R7/R8 na navegação móvel; CA05, transições de CA06 e parcelas de CA02/CA07/CA08/CA09; CT-004, CT-005 e CT-009.

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Comparar a marca no topo, a navegação inferior, as áreas seguras e as regras finais responsivas.

Identidade estável: `docs/harness/features/1016270-adequacao-visual-completa-do-finai/slices/slices.md#D03-r001`.

[Design fornecido](../../../../scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip).
