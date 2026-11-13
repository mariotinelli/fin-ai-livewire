# [DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Alertas e comandos de suporte

## Identidade

- Tarefa: [#1016287](https://redmine.remsoft.com.br/issues/1016287).
- Pai: [#1016270](https://redmine.remsoft.com.br/issues/1016270); [requisito](../../feature.md).
- Projeto FinAi (65224), versão Livewire (20359).
- Sequencing: 7.
- Estimativa: 2h, definida pelo responsável.
- [Slicing](../../slices/slices.md).
- [Condições de teste](../../slices/condicoes-teste-r002.md); [DOCX](<../../slices/r002/1016270 - Condições de testes.docx>).

## Entrega

Adequar à identidade FinAI a lista e os detalhes de alertas e o executor e histórico de comandos, preservando filtros, estados, ações e a leitura de mensagens técnicas e saídas extensas.

## Escopo e limites

Adaptar a composição de suporte utilizando a base visual e os componentes compartilhados. Manter a execução de comandos, o reconhecimento e a resolução de alertas e as proteções de acesso existentes.

## Critérios de aceite

- Apresentar a lista e os detalhes de alertas no padrão FinAI, incluindo resumo, mensagens, contexto e trace.
- Preservar filtros, estados e ações condicionais dos alertas.
- Manter as funções e restrições atuais do executor, das sugestões, do processamento, do histórico, da saída e da reexecução.
- Aplicar a identidade aos estados vazios, falhas, validações e feedbacks atuais do suporte e aos estados de normal, hover, foco, ativo, desabilitado e carregamento dos controles quando aplicáveis.
- Preservar os resultados de confirmações e cancelamentos existentes.
- Manter as restrições por tipo de usuário, permissão e IP, sem ampliar acesso.
- Comparar as superfícies de suporte com a linguagem do design em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080; textos técnicos e saídas longas permanecem legíveis e consultáveis por rolagem apropriada, sem rolagem horizontal da página ou ações encobertas.
- Manter rótulos, foco e uso por teclado nas listas, detalhes e controles de execução.
- Não criar destinos financeiros, novas operações, dados fictícios ou rótulos de armazenamento local e assistente simulado.

## Dependências

Pode iniciar sobre as telas de suporte existentes. A identidade compartilhada é fornecida por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual](https://redmine.remsoft.com.br/issues/1016281). A estrutura nas telas maiores é fornecida por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Layout desktop e tablet](https://redmine.remsoft.com.br/issues/1016282) e a navegação móvel por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Navegação no celular e transições](https://redmine.remsoft.com.br/issues/1016283). Integrar essas capacidades para concluir a apresentação desta entrega, sem reconstruí-las. Para concluir as composições que utilizam tabelas e painéis compartilhados, integrar as adaptações fornecidas por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Gestão de usuários e perfis](https://redmine.remsoft.com.br/issues/1016286).

## Referências

Pai #1016270; R1 (suporte), R2 e R7/R8; CA01/CA02/CA06/CA08/CA09 no suporte; CT-014 a CT-016.

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Aplicar a linguagem visual comum às listas, detalhes de alertas, executor e histórico, preservando a leitura de conteúdo técnico.

Identidade estável: `docs/harness/features/1016270-adequacao-visual-completa-do-finai/slices/slices.md#D07-r001`.

[Design fornecido](../../../../scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip).
