# Fatiamento de Adequação visual completa do FinAI

## Identidade

- Pai: [#1016270](https://redmine.remsoft.com.br/issues/1016270); [requisito](../feature.md).
- Projeto FinAi (65224), versão Livewire (20359).
- Slicing publicado e conferido, sem implementação ou execução de QA neste fluxo.
- Uma única QA cobre a Feature inteira.

## Tarefas

| Tarefa                                                                                                                                          | Papel | Horas | Sequencing |
| ----------------------------------------------------------------------------------------------------------------------------------------------- | ----- | ----: | ---------: |
| [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual](https://redmine.remsoft.com.br/issues/1016281) | DEV   |   1,5 |          1 |
| [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Layout desktop e tablet](https://redmine.remsoft.com.br/issues/1016282)             | DEV   |     2 |          2 |
| [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Navegação no celular e transições](https://redmine.remsoft.com.br/issues/1016283)   | DEV   |     2 |          3 |
| [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Jornadas de acesso](https://redmine.remsoft.com.br/issues/1016284)                  | DEV   |     2 |          4 |
| [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Perfil e notificações](https://redmine.remsoft.com.br/issues/1016285)               | DEV   |     2 |          5 |
| [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Gestão de usuários e perfis](https://redmine.remsoft.com.br/issues/1016286)         | DEV   |     2 |          6 |
| [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Alertas e comandos de suporte](https://redmine.remsoft.com.br/issues/1016287)       | DEV   |     2 |          7 |
| [[QA] [WEB] [USUARIO] Adequação visual completa do FinAI](https://redmine.remsoft.com.br/issues/1016288)                                        | QA    |     4 |          8 |

Total: 17,5h. Estimativas definidas pelo responsável; incluem verificação da entrega e QA integrada.

## Cobertura integral

Cada parcela tem um dono; critérios transversais são particionados por superfície ou faixa, não duplicados como implementações independentes.

| Regra/critério aprovado                                        | Destino da mudança                                                              | Condições QA                                  |
| -------------------------------------------------------------- | ------------------------------------------------------------------------------- | --------------------------------------------- |
| R1 / CA01 — dashboard e apresentação comum                     | D01                                                                             | CT-001, CT-018                                |
| R1 / CA01 — acesso, recuperação e confirmação                  | D04                                                                             | CT-006, CT-007                                |
| R1 / CA01 — perfil e notificações                              | D05                                                                             | CT-010, CT-011                                |
| R1 / CA01 — gestão                                             | D06                                                                             | CT-012, CT-013                                |
| R1 / CA01 — suporte                                            | D07                                                                             | CT-014, CT-015                                |
| R2/R3 / CA02 — marca, paleta, tipografia, estados-base         | D01, consumidos pelos demais                                                    | CT-001, CT-016, CT-017                        |
| CA02 — composição específica das telas sem mockup              | D04/D05/D06/D07, cada qual em seu inventário                                    | CT-006, CT-007, CT-010–CT-016                 |
| R6 / CA03 — desktop e contorno >=768px                         | D02                                                                             | CT-002                                        |
| R5 / CA04 — tablet                                             | D02                                                                             | CT-003                                        |
| R4 / CA05 — celular                                            | D03                                                                             | CT-004                                        |
| CA06 — transições de faixas                                    | D03, integrando D02                                                             | CT-005                                        |
| CA06 — matriz responsiva de todas as telas                     | D01–D07, somente suas próprias superfícies                                      | CT-001, CT-006, CT-007, CT-010–CT-016, CT-018 |
| R7 / CA07 — navegação/conta por faixa                          | D02 (>=768px), D03 (<=767px)                                                    | CT-002–CT-005, CT-009                         |
| R8 / CA08/CA09 — estados e operações preservados               | D04 acesso; D05 perfil/notificações; D06 gestão; D07 suporte; D02/D03 navegação | CT-006–CT-016, CT-018                         |
| R9 / CA10 — marca e ausência de rótulos locais/simulados       | D01, consumida em todas as superfícies                                          | CT-001, CT-017                                |
| R10 / CA11 — dashboard sem antecipar finanças e destinos reais | D01 conteúdo; D02/D03 destinos                                                  | CT-001, CT-009, CT-017                        |

Não há resultado visual integral classificado como existente. Operações e contratos atuais são reaproveitados com evidência de leitura e preservação, não como prova de conformidade. Nenhuma regra ou critério está excluído por ausência de mockup.

## Condições de teste

[Condições vigentes](condicoes-teste-r002.md) e [DOCX](<r002/1016270 - Condições de testes.docx>), associados à [QA #1016288](https://redmine.remsoft.com.br/issues/1016288).

## Descrições das tarefas

### [DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual

#### Entrega

Substituir a identidade visual Rem Soft pela identidade FinAI no dashboard atual. Estabelecer os padrões compartilhados de marca, cores, tipografia e estados visuais que serão utilizados pelas demais telas.

#### Escopo e limites

Preservar a finalidade atual do dashboard e os contratos dos componentes existentes. A estrutura responsiva e as composições específicas das outras telas são entregues pelas tarefas responsáveis.

#### Critérios de aceite

- Aplicar fundo #F5F7F8, superfícies brancas, texto principal #172622, texto secundário #52615C, verde principal #145C46, positivo #146345, negativo #A12B36, borda #D6DFDB e destaque #E4F0E9.
- Usar Georgia nos títulos de destaque e system-ui no corpo; manter controles com raio de 8px e painéis com raio de 16px.
- Comparar a marca, a hierarquia, os espaçamentos, as proporções, as bordas e as sombras do dashboard e dos elementos comuns com o design fornecido, substituindo a aparência anterior.
- Nos componentes comuns apresentados no dashboard, preservar os estados existentes de normal, hover, foco, ativo, desabilitado, carregamento, vazio, erro, sucesso, confirmação e cancelamento quando aplicáveis.
- Conferir o dashboard e seus elementos comuns em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, sem rolagem horizontal da página, controles encobertos ou perda de foco, rótulos e uso por teclado.
- Manter campos, dados, validações, operações, destinos e permissões existentes dos elementos abrangidos.
- Apresentar a marca FinAI sem renomear dados próprios dos usuários e sem mensagens de conta local, armazenamento exclusivo no navegador ou assistente simulado.
- Manter o dashboard sem saldo, transações, chat, novos destinos financeiros ou dados demonstrativos.

#### Dependências

Pode iniciar sobre o dashboard existente. Para concluir a composição compartilhada, integrar [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Layout desktop e tablet](https://redmine.remsoft.com.br/issues/1016282) e [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Navegação no celular e transições](https://redmine.remsoft.com.br/issues/1016283).

#### Referências

Pai #1016270; R1 (dashboard e base), R2, R3, R9 e R10; CA01/CA02 (base), CA06, CA08 (estados-base), CA10 e CA11; CT-001, CT-017 e CT-018.

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Comparar marca, paleta, tipografia e elementos comuns do dashboard.

Identidade estável da intenção de criação: `docs/harness/features/1016270-adequacao-visual-completa-do-finai/slices/slices.md#D01-r001`.

### [DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Layout desktop e tablet

#### Entrega

Reorganizar o cabeçalho, a navegação lateral e a superfície de conteúdo das áreas de cliente, administração e suporte a partir de 768px, seguindo o design fornecido.

#### Escopo e limites

Esta entrega abrange a composição de tablet e desktop. Preservar os destinos, grupos e operações atuais; a composição do celular é fornecida pela tarefa de navegação móvel.

#### Critérios de aceite

- A partir de 1025px, apresentar a lateral desktop com recolhimento funcional e indicação do destino ativo.
- Manter todos os destinos e ações autorizados alcançáveis com a lateral desktop aberta ou recolhida.
- De 768 a 1024px inclusive, apresentar a lateral compacta de 72px mais a área segura, marca compacta, alvos de pelo menos 48px e conteúdo ao lado, sem barra inferior.
- Com altura de tela reduzida no tablet, manter todos os controles da lateral e da conta alcançáveis.
- A partir de 768px, apresentar superfície de trabalho com contorno de 1px, raio de 16px, margem de 8px e cabeçalho transparente, preservando a relação entre navegação e conteúdo do design.
- Manter acesso à conta, ao perfil, às notificações e à saída nas três áreas, por mouse e teclado, sem ampliar permissões ou modificar o resultado das operações.
- Nos controles de navegação, preservar rótulos, foco visível e os estados atuais aplicáveis, incluindo normal, hover, ativo, desabilitado, carregamento e feedbacks existentes.
- Comparar a composição de tablet e desktop com a referência e conferir sua integração em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, preservando a identidade FinAI, sem rolagem horizontal da página ou ações encobertas.
- Usar apenas destinos implementados e manter mensagens funcionais coerentes, sem páginas financeiras antecipadas ou rótulos de simulação.

#### Dependências

Pode iniciar sobre a navegação existente. Para concluir a apresentação, integrar [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual](https://redmine.remsoft.com.br/issues/1016281). A tarefa [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Navegação no celular e transições](https://redmine.remsoft.com.br/issues/1016283) verifica as transições entre faixas em conjunto com esta entrega.

#### Referências

Pai #1016270; R5, R6, R7/R8 na navegação a partir de 768px; CA03, CA04 e parcelas de CA02/CA06/CA07/CA08/CA09; CT-002, CT-003, CT-005 e CT-009.

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Comparar as regras finais de `.app`, `.sidebar`, `.workspace` e `.topbar`, incluindo marca, contorno e estados da navegação.

Identidade estável: `docs/harness/features/1016270-adequacao-visual-completa-do-finai/slices/slices.md#D02-r001`.

### [DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Navegação no celular e transições

#### Entrega

Substituir a apresentação móvel atual pela marca no topo e pela navegação inferior do design. Manter os destinos autorizados e as ações da conta nas três áreas e verificar a mudança de modo ao redimensionar.

#### Escopo e limites

Esta entrega abrange a composição até 767px e a integração das transições. A geometria de tablet e desktop é fornecida pela tarefa responsável por essas faixas.

#### Critérios de aceite

- Até 767px, apresentar a marca no topo e a barra inferior em largura total, com base de 56px acrescida da área segura inferior.
- Usar ícones de 24px e alvos de pelo menos 44px, sem legenda visual, com nomes acessíveis, foco visível e indicação do destino ativo.
- Manter acesso aos destinos e grupos autorizados, à conta, ao perfil, às notificações e à saída nas áreas de cliente, administração e suporte.
- Adaptar menus com mais destinos que os três itens do protótipo, preservando as opções existentes sem criar navegação financeira futura.
- Ao rolar, focar controles e abrir menus, notificações, diálogos e painéis, manter conteúdo, mensagens e ações livres da barra inferior e da área segura.
- Após recolher a lateral desktop, redimensionar entre 767/768px e 1024/1025px aplicando o modo correto, sem perder ações ou foco e sem manter barra inferior nas faixas maiores.
- Preservar rótulos, uso por teclado e os estados atuais aplicáveis da navegação e de seus feedbacks, sem alterar dados, operações, validações ou permissões.
- Comparar a composição móvel e as transições com o design fornecido e conferir a integração em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, mantendo a identidade FinAI e sem rolagem horizontal da página.
- Não introduzir mensagens de armazenamento local ou assistente simulado nos elementos de navegação.

#### Dependências

Pode iniciar sobre a navegação existente. Para concluir e verificar as transições, integrar [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual](https://redmine.remsoft.com.br/issues/1016281) e [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Layout desktop e tablet](https://redmine.remsoft.com.br/issues/1016282).

#### Referências

Pai #1016270; R4, R7/R8 na navegação móvel; CA05, transições de CA06 e parcelas de CA02/CA07/CA08/CA09; CT-004, CT-005 e CT-009.

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Comparar a marca no topo, a navegação inferior, as áreas seguras e as regras finais responsivas.

Identidade estável: `docs/harness/features/1016270-adequacao-visual-completa-do-finai/slices/slices.md#D03-r001`.

### [DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Jornadas de acesso

#### Entrega

Adequar à identidade FinAI as telas de cadastro, login de cliente/administração/suporte, recuperação e redefinição de senha, verificação e reenvio de e-mail e confirmação de senha, utilizando as funções existentes.

#### Escopo e limites

Adaptar a composição dessas telas e os campos de acesso comuns, sem alterar regras de autenticação, URLs, tokens ou permissões. As mudanças funcionais da entrada pessoal pertencem à F02.

#### Critérios de aceite

- Apresentar marca, títulos, campos, botões, ajuda e links com a linguagem visual FinAI em todas as telas de acesso listadas, inclusive quando não houver mockup específico.
- Preservar os campos e as validações existentes ao enviar dados válidos e inválidos.
- Preservar as restrições por área e os resultados das operações de cadastro e login.
- Preservar o significado, os destinos e as comunicações atuais de recuperação, redefinição, verificação, reenvio e confirmação de senha.
- Aplicar a identidade aos estados existentes de normal, hover, foco, ativo, desabilitado, carregamento, vazio, erro, sucesso, confirmação e cancelamento quando aplicáveis às jornadas de acesso.
- Comparar os formulários, erros e processamento com a linguagem do design em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, mantendo campos e ações utilizáveis por mouse e teclado, sem corte, encobrimento ou rolagem horizontal da página.
- Manter foco e rótulos dos controles e preservar dados informados pelo usuário.
- Não criar novos destinos financeiros, dados de demonstração, regras de autenticação ou rótulos de conta local e assistente simulado.

#### Dependências

Pode iniciar sobre os formulários existentes. Integrar a marca, a tipografia, os componentes e os estados compartilhados fornecidos por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual](https://redmine.remsoft.com.br/issues/1016281) para concluir a apresentação.

#### Referências

Pai #1016270; R1 (acesso), R2 e R8; CA01/CA02/CA06/CA08/CA09 no acesso; CT-006 a CT-009.

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Aplicar a identidade e os estados dos formulários às telas de acesso sem desenho próprio.

Identidade estável: `docs/harness/features/1016270-adequacao-visual-completa-do-finai/slices/slices.md#D04-r001`.

### [DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Perfil e notificações

#### Entrega

Adequar à identidade FinAI o perfil, os formulários de dados pessoais e senha e o painel e histórico de notificações nas áreas em que existem.

#### Escopo e limites

Adaptar a composição dessas telas e preservar eventual apresentação legada ainda utilizada. Não criar uma operação de exclusão de conta onde existe apenas texto sem ação funcional.

#### Critérios de aceite

- Apresentar os campos e feedbacks de dados pessoais e senha no padrão FinAI, preservando suas validações e efeitos atuais.
- Manter as operações atuais da conta, sem acrescentar novos recursos ao perfil.
- Preservar os dados, grupos, leitura, carregamento e ações disponíveis no painel e no histórico de notificações.
- Aplicar a identidade FinAI aos estados existentes dos formulários e notificações, incluindo vazio, textos longos, processamento, erros, sucesso, confirmações e cancelamentos quando aplicáveis, além de normal, hover, foco, ativo e desabilitado nos controles.
- Comparar perfil e notificações com a linguagem do design em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, mantendo conteúdo legível e ações alcançáveis, sem rolagem horizontal da página.
- Permitir o uso por teclado, com rótulos e foco preservados, sem menus ou barra inferior encobrindo campos, mensagens e ações da conta.
- Preservar a titularidade dos dados e notificações e as permissões existentes.
- Não introduzir destinos financeiros futuros, dados fictícios ou rótulos de armazenamento local e assistente simulado.

#### Dependências

Pode iniciar sobre os formulários e históricos existentes. A identidade compartilhada é fornecida por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual](https://redmine.remsoft.com.br/issues/1016281). A estrutura nas telas maiores é fornecida por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Layout desktop e tablet](https://redmine.remsoft.com.br/issues/1016282) e a navegação móvel por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Navegação no celular e transições](https://redmine.remsoft.com.br/issues/1016283). Integrar essas capacidades para concluir a apresentação desta entrega, sem reconstruí-las.

#### Referências

Pai #1016270; R1 (perfil e notificações), R2 e R7/R8 nessas telas; CA01/CA02/CA06/CA08/CA09 correspondentes; CT-010, CT-011 e CT-016.

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Aplicar a linguagem visual comum aos formulários de perfil, painel e histórico de notificações, incluindo seus estados atuais.

Identidade estável: `docs/harness/features/1016270-adequacao-visual-completa-do-finai/slices/slices.md#D05-r001`.

### [DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Gestão de usuários e perfis

#### Entrega

Adequar à identidade FinAI as listas e os formulários de usuários e perfis de acesso, preservando as operações de busca, filtros, paginação, criação, edição, exclusão, restauração e convite já disponíveis. Adaptar as tabelas e os painéis compartilhados usados por essas composições para que os consumidores de suporte possam reutilizá-los.

#### Escopo e limites

Alterar a apresentação e a composição das operações existentes, sem modificar o CRUD, as regras de papéis ou as permissões. As telas de suporte continuam sob responsabilidade da entrega correspondente.

#### Critérios de aceite

- Apresentar listas, formulários, permissões, diálogos e painéis de gestão com a identidade FinAI e as mesmas informações existentes.
- Preservar a busca, os filtros e a paginação atuais, inclusive os estados de lista vazia e de pesquisa sem resultados.
- Manter os efeitos das ações autorizadas de criação, edição, exclusão, restauração e convite onde essas operações estiverem disponíveis.
- Preservar as validações e os resultados de entradas válidas e inválidas.
- Manter os efeitos das confirmações e cancelamentos e recusar ações sem permissão.
- Aplicar os estados atuais dos controles e feedbacks de gestão, incluindo normal, hover, foco, ativo, desabilitado, carregamento, vazio, erro e sucesso quando aplicáveis.
- Comparar as composições de gestão com a linguagem do design em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080; tabelas largas, textos e painéis continuam legíveis e utilizáveis, sem rolagem horizontal da página ou controles encobertos.
- Manter rótulos, foco e acesso por teclado durante rolagem, uso de tabelas, diálogos e painéis.
- Preservar os consumidores de suporte e notificações ao adaptar componentes compartilhados, sem introduzir dados financeiros, novas operações ou rótulos de simulação.

#### Dependências

Pode iniciar sobre a gestão existente. A identidade compartilhada é fornecida por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual](https://redmine.remsoft.com.br/issues/1016281). A estrutura nas telas maiores é fornecida por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Layout desktop e tablet](https://redmine.remsoft.com.br/issues/1016282) e a navegação móvel por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Navegação no celular e transições](https://redmine.remsoft.com.br/issues/1016283). Integrar essas capacidades para concluir a apresentação desta entrega, sem reconstruí-las. Para a integração dos componentes compartilhados com suporte, manter os contratos utilizados por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Alertas e comandos de suporte](https://redmine.remsoft.com.br/issues/1016287).

#### Referências

Pai #1016270; R1 (gestão e componentes), R2 e R7/R8; CA01/CA02/CA06/CA08/CA09 na gestão; CT-012, CT-013 e CT-016.

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Aplicar a linguagem visual de tabelas, campos, botões, diálogos e painéis às telas de gestão sem mockup específico.

Identidade estável: `docs/harness/features/1016270-adequacao-visual-completa-do-finai/slices/slices.md#D06-r001`.

### [DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Alertas e comandos de suporte

#### Entrega

Adequar à identidade FinAI a lista e os detalhes de alertas e o executor e histórico de comandos, preservando filtros, estados, ações e a leitura de mensagens técnicas e saídas extensas.

#### Escopo e limites

Adaptar a composição de suporte utilizando a base visual e os componentes compartilhados. Manter a execução de comandos, o reconhecimento e a resolução de alertas e as proteções de acesso existentes.

#### Critérios de aceite

- Apresentar a lista e os detalhes de alertas no padrão FinAI, incluindo resumo, mensagens, contexto e trace.
- Preservar filtros, estados e ações condicionais dos alertas.
- Manter as funções e restrições atuais do executor, das sugestões, do processamento, do histórico, da saída e da reexecução.
- Aplicar a identidade aos estados vazios, falhas, validações e feedbacks atuais do suporte e aos estados de normal, hover, foco, ativo, desabilitado e carregamento dos controles quando aplicáveis.
- Preservar os resultados de confirmações e cancelamentos existentes.
- Manter as restrições por tipo de usuário, permissão e IP, sem ampliar acesso.
- Comparar as superfícies de suporte com a linguagem do design em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080; textos técnicos e saídas longas permanecem legíveis e consultáveis por rolagem apropriada, sem rolagem horizontal da página ou ações encobertas.
- Manter rótulos, foco e uso por teclado nas listas, detalhes e controles de execução.
- Não criar destinos financeiros, novas operações, dados fictícios ou rótulos de armazenamento local e assistente simulado.

#### Dependências

Pode iniciar sobre as telas de suporte existentes. A identidade compartilhada é fornecida por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual](https://redmine.remsoft.com.br/issues/1016281). A estrutura nas telas maiores é fornecida por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Layout desktop e tablet](https://redmine.remsoft.com.br/issues/1016282) e a navegação móvel por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Navegação no celular e transições](https://redmine.remsoft.com.br/issues/1016283). Integrar essas capacidades para concluir a apresentação desta entrega, sem reconstruí-las. Para concluir as composições que utilizam tabelas e painéis compartilhados, integrar as adaptações fornecidas por [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Gestão de usuários e perfis](https://redmine.remsoft.com.br/issues/1016286).

#### Referências

Pai #1016270; R1 (suporte), R2 e R7/R8; CA01/CA02/CA06/CA08/CA09 no suporte; CT-014 a CT-016.

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Aplicar a linguagem visual comum às listas, detalhes de alertas, executor e histórico, preservando a leitura de conteúdo técnico.

Identidade estável: `docs/harness/features/1016270-adequacao-visual-completa-do-finai/slices/slices.md#D07-r001`.

### [QA] [WEB] [USUARIO] Adequação visual completa do FinAI

#### Entrega

Verificar integralmente as condições CT-001–CT-018 da revisão r002 e o resultado completo da adequação visual, registrando evidências, defeitos e um reteste focalizado.

#### Escopo e limites

Executar uma única QA da Feature inteira. Preservar as operações existentes e utilizar dados próprios de teste; não criar funcionalidades para suprir lacunas do inventário.

#### Critérios de aceite

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

#### Dependências

Executar após a conclusão das seguintes tarefas:

- [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Identidade FinAI no dashboard atual](https://redmine.remsoft.com.br/issues/1016281).
- [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Layout desktop e tablet](https://redmine.remsoft.com.br/issues/1016282).
- [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Navegação no celular e transições](https://redmine.remsoft.com.br/issues/1016283).
- [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Jornadas de acesso](https://redmine.remsoft.com.br/issues/1016284).
- [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Perfil e notificações](https://redmine.remsoft.com.br/issues/1016285).
- [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Gestão de usuários e perfis](https://redmine.remsoft.com.br/issues/1016286).
- [[DEV] [WEB] [USUARIO] Adequação visual completa do FinAI - Alertas e comandos de suporte](https://redmine.remsoft.com.br/issues/1016287).

#### Referências

Pai #1016270; R1–R10 e CA01–CA11; condições r002, CT-001–CT-018.

[Condições de teste r002 — DOCX anexado](https://redmine.remsoft.com.br/attachments/download/3354/1016270%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).

Visual V01 — design fornecido: `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`. Comparar todas as telas do inventário e seus estados aplicáveis, preservando as adaptações aprovadas para telas sem mockup.

Identidade estável: `docs/harness/features/1016270-adequacao-visual-completa-do-finai/slices/slices.md#QA-r002`.

## Sequencing e dependências

O pai espelha o primeiro número de seu bloco, sem consumir posição adicional. Os bloqueios confirmados estão nas descrições e relações das tarefas. Nenhuma dependência de integração foi convertida em bloqueio apenas por compartilhar arquivos.
