# [DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Gestão de usuários e perfis

## Identidade

- Tarefa: [#1016286](https://redmine.remsoft.com.br/issues/1016286).
- Pai: [#1016270](https://redmine.remsoft.com.br/issues/1016270); [requisito](../../feature.md).
- Projeto FinAi (65224), versão Livewire (20359).
- Sequencing: 6.
- Estimativa: 2h, definida pelo responsável.
- [Slicing](../../slices/slices.md).
- [Condições de teste](../../slices/condicoes-teste-r002.md); [DOCX](<../../slices/r002/1016270 - Condições de testes.docx>).

## Entrega

Adequar à identidade FinAI as listas e os formulários de usuários e perfis de acesso, preservando as operações de busca, filtros, paginação, criação, edição, exclusão, restauração e convite já disponíveis. Adaptar as tabelas e os painéis compartilhados usados por essas composições para que os consumidores de suporte possam reutilizá-los.

## Escopo e limites

Alterar a apresentação e a composição das operações existentes, sem modificar o CRUD, as regras de papéis ou as permissões. As telas de suporte continuam sob responsabilidade da entrega correspondente.

## Critérios de aceite

- Apresentar listas, formulários, permissões, diálogos e painéis de gestão com a identidade FinAI e as mesmas informações existentes.
- Preservar a busca, os filtros e a paginação atuais, inclusive os estados de lista vazia e de pesquisa sem resultados.
- Manter os efeitos das ações autorizadas de criação, edição, exclusão, restauração e convite onde essas operações estiverem disponíveis.
- Preservar as validações e os resultados de entradas válidas e inválidas.
- Manter os efeitos das confirmações e cancelamentos e recusar ações sem permissão.
- Aplicar os estados atuais dos controles e feedbacks de gestão, incluindo normal, hover, foco, ativo, desabilitado, carregamento, vazio, erro e sucesso quando aplicáveis.
- Comparar as composições de gestão com a linguagem do design em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080; tabelas largas, textos e painéis continuam legíveis e utilizáveis, sem rolagem horizontal da página ou controles encobertos.
- Manter rótulos, foco e acesso por teclado durante rolagem, uso de tabelas, diálogos e painéis.
- Preservar os consumidores de suporte e notificações ao adaptar componentes compartilhados, sem introduzir dados financeiros, novas operações ou rótulos de simulação.

## Dependências

Pode iniciar sobre a gestão existente. A identidade compartilhada é fornecida por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual](https://redmine.remsoft.com.br/issues/1016281). A estrutura nas telas maiores é fornecida por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Layout desktop e tablet](https://redmine.remsoft.com.br/issues/1016282) e a navegação móvel por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Navegação no celular e transições](https://redmine.remsoft.com.br/issues/1016283). Integrar essas capacidades para concluir a apresentação desta entrega, sem reconstruí-las. Para a integração dos componentes compartilhados com suporte, manter os contratos utilizados por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Alertas e comandos de suporte](https://redmine.remsoft.com.br/issues/1016287).

## Referências

Pai #1016270; R1 (gestão e componentes), R2 e R7/R8; CA01/CA02/CA06/CA08/CA09 na gestão; CT-012, CT-013 e CT-016.

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Aplicar a linguagem visual de tabelas, campos, botões, diálogos e painéis às telas de gestão sem mockup específico.

Identidade estável: `docs/harness/features/1016270-adequacao-visual-completa-do-finai/slices/slices.md#D06-r001`.

[Design fornecido](../../../../scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip).
