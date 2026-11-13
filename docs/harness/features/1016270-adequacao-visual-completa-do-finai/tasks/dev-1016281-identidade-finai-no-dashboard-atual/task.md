# [DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual

## Identidade

- Tarefa: [#1016281](https://redmine.remsoft.com.br/issues/1016281).
- Pai: [#1016270](https://redmine.remsoft.com.br/issues/1016270); [requisito](../../feature.md).
- Projeto FinAi (65224), versão Livewire (20359).
- Sequencing: 1.
- Estimativa: 1,5h, definida pelo responsável.
- [Slicing](../../slices/slices.md).
- [Condições de teste](../../slices/condicoes-teste-r002.md); [DOCX](<../../slices/r002/1016270 - Condições de testes.docx>).

## Entrega

Substituir a identidade visual Rem Soft pela identidade FinAI no dashboard atual. Estabelecer os padrões compartilhados de marca, cores, tipografia e estados visuais que serão utilizados pelas demais telas.

## Escopo e limites

Preservar a finalidade atual do dashboard e os contratos dos componentes existentes. A estrutura responsiva e as composições específicas das outras telas são entregues pelas tarefas responsáveis.

## Critérios de aceite

- Aplicar fundo #F5F7F8, superfícies brancas, texto principal #172622, texto secundário #52615C, verde principal #145C46, positivo #146345, negativo #A12B36, borda #D6DFDB e destaque #E4F0E9.
- Usar Georgia nos títulos de destaque e system-ui no corpo; manter controles com raio de 8px e painéis com raio de 16px.
- Comparar a marca, a hierarquia, os espaçamentos, as proporções, as bordas e as sombras do dashboard e dos elementos comuns com o design fornecido, substituindo a aparência anterior.
- Nos componentes comuns apresentados no dashboard, preservar os estados existentes de normal, hover, foco, ativo, desabilitado, carregamento, vazio, erro, sucesso, confirmação e cancelamento quando aplicáveis.
- Conferir o dashboard e seus elementos comuns em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, sem rolagem horizontal da página, controles encobertos ou perda de foco, rótulos e uso por teclado.
- Manter campos, dados, validações, operações, destinos e permissões existentes dos elementos abrangidos.
- Apresentar a marca FinAI sem renomear dados próprios dos usuários e sem mensagens de conta local, armazenamento exclusivo no navegador ou assistente simulado.
- Manter o dashboard sem saldo, transações, chat, novos destinos financeiros ou dados demonstrativos.

## Dependências

Pode iniciar sobre o dashboard existente. Para concluir a composição compartilhada, integrar [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Layout desktop e tablet](https://redmine.remsoft.com.br/issues/1016282) e [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Navegação no celular e transições](https://redmine.remsoft.com.br/issues/1016283).

## Referências

Pai #1016270; R1 (dashboard e base), R2, R3, R9 e R10; CA01/CA02 (base), CA06, CA08 (estados-base), CA10 e CA11; CT-001, CT-017 e CT-018.

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Comparar marca, paleta, tipografia e elementos comuns do dashboard.

Identidade estável da intenção de criação: `docs/harness/features/1016270-adequacao-visual-completa-do-finai/slices/slices.md#D01-r001`.

[Design fornecido](../../../../scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip).
