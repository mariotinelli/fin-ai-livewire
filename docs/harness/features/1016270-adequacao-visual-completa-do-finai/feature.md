# Adequação visual completa do FinAI

## Identidade

- Feature: [#1016270](https://redmine.remsoft.com.br/issues/1016270).
- Projeto: FinAi (65224).
- Versão: Livewire (20359).
- Situação: requisito aprovado; implementação não realizada neste fluxo.
- [Catálogo](../../scopes/2026-11-13-finai-mvp/scope.md).

## Objetivo

Adequar integralmente a aparência e o layout das telas existentes do sistema à identidade FinAI do design fornecido, corrigindo as divergências da estrutura atual e estabelecendo a base visual das futuras telas financeiras.

## Resultado esperado

O sistema apresenta marca, paleta, tipografia, componentes, estrutura das páginas e navegação coerentes com o design, em computador, tablet e celular. A entrega inclui a alteração da composição e geometria do layout, além da identidade visual. As telas sem mockup próprio recebem a mesma linguagem visual, mantendo suas finalidades, campos, ações e permissões.

## Atores e permissões

- Visitantes acessam as telas públicas já disponíveis, conforme as restrições existentes.
- Usuários autenticados acessam suas telas atuais de cliente, administração ou suporte conforme seus tipos e permissões existentes.
- A adequação visual não concede acesso adicional, remove restrições nem muda operações. O acesso pessoal às finanças e suas regras serão tratados em F02 e nos itens financeiros.

## Histórias de usuário

1. Como visitante, quero reconhecer a identidade FinAI nas telas de acesso e recuperação de conta para perceber continuidade com o produto.
2. Como usuário autenticado, quero navegar em um layout coerente com o design para encontrar os destinos e ações disponíveis na minha área.
3. Como usuário de celular, tablet ou computador, quero usar as telas atuais com a composição adequada ao meu dispositivo, sem perder acesso aos controles.
4. Como usuário de perfil, gestão ou suporte, quero encontrar os mesmos padrões visuais de campos, listas, diálogos e feedback sem perder as operações existentes.

## Fluxo principal

1. Abrir uma tela pública ou autenticada já existente. Apresentar a marca e a linguagem visual FinAI na composição adequada à tela.
2. Na área autenticada, apresentar a navegação correspondente aos destinos reais e autorizados do usuário, indicando a seção ativa.
3. Adequar a estrutura ao espaço disponível: navegação lateral no desktop, lateral compacta no tablet e barra principal inferior no celular, seguindo a referência.
4. Abrir páginas, preencher formulários, consultar listas ou usar ações existentes. Manter campos e resultados, aplicando o padrão visual aos controles e feedbacks.
5. Acessar perfil, notificações e saída em qualquer faixa de tela. A adaptação da navegação mantém disponíveis os controles que existem hoje, mesmo onde o protótipo oculta suas áreas de conta.

## Fluxos alternativos e exceções

- Telas sem mockup específico, como login, recuperação, perfil, administração e suporte, recebem marca, paleta, tipografia, espaçamento e componentes da referência, preservando suas funções.
- Destinos sem permissão continuam indisponíveis ao usuário; a navegação visual não amplia acessos.
- Estados existentes de carregamento, vazio, validação, erro, sucesso, confirmação e cancelamento mantêm seu significado e passam a usar a identidade FinAI.
- Textos longos, listas extensas, diálogos e formulários mantêm acesso a seus dados e ações em telas estreitas; a navegação não encobre conteúdo ou foco.
- Ao redimensionar entre as faixas de navegação, o sistema aplica o modo correspondente e mantém os destinos acessíveis, inclusive após recolher a lateral no desktop.
- O dashboard atual recebe adequação de sua apresentação existente. Dados e controles financeiros novos chegam em F05, sem simulações para aparentar conclusão antecipada.

## Regras de negócio

**R1 — Cobertura integral.** Todas as telas atuais inventariadas abaixo entram na adequação, incluindo componentes e estados que elas utilizam. Ausência de mockup próprio não exclui uma tela. A confirmação do responsável nesta conversa explicita a correção completa do layout divergente.

| Grupo                      | Cobertura existente                                                                                                                                      |
| -------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Acesso                     | Login de cliente, administração e suporte; cadastro; recuperação e redefinição de senha; verificação de e-mail; confirmação de senha                     |
| Área autenticada           | Dashboard atual, cabeçalho, navegação, identificação da conta, perfil, notificações e saída                                                              |
| Perfil                     | Dados pessoais, alteração de senha e exclusão de conta, nas áreas em que estão disponíveis                                                               |
| Gestão administrativa      | Listas e formulários de usuários e perfis de acesso; ações existentes de criação, edição, exclusão/restauração e convite conforme a tela e as permissões |
| Suporte                    | Listagem e detalhe de alertas de erros; executor e histórico de comandos Artisan                                                                         |
| Componentes compartilhados | Formulários e seus campos, botões, links, tabelas, filtros existentes, paginação, menus, diálogos, painéis laterais e feedbacks usados pelas telas acima |

**R2 — Identidade visual.** A referência principal é o `index.html` do ZIP fornecido, considerando a ordem final de suas regras visuais. Usar a marca FinAI e a hierarquia de cores, títulos, textos, ícones, espaçamentos, superfícies, bordas, raios e sombras do design. A aparência Rem Soft atual deve ser substituída na interface do produto abrangida pela entrega; preservar nomes e dados que pertençam aos usuários ou ao conteúdo funcional.

**R3 — Referências visuais observáveis.** O design usa fundo #F5F7F8, superfícies brancas, texto principal #172622, secundário #52615C, destaque principal #145C46, positivo #146345, negativo #A12B36, borda #D6DFDB e destaque suave #E4F0E9. Títulos de destaque em Georgia e corpo em system-ui; controles com raio de 8px e painéis de 16px. Preservar hierarquia, proporções e ritmo de espaçamento conforme a referência, sem limitar a entrega a trocar cores ou logotipo.

**R4 — Celular.** Até 767px, apresentar marca no topo e navegação principal fixa na base, em largura total, conforme o design: base de 56px acrescida da área segura inferior, ícones de 24px e alvos de pelo menos 44px. Os itens principais usam ícones sem legenda visual, mantendo nomes acessíveis, foco e indicação do destino ativo. Reservar espaço para que a barra não encubra conteúdo, mensagens, foco ou ações.

**R5 — Tablet.** De 768 a 1024px inclusive, apresentar lateral compacta de 72px mais a área segura lateral, marca compacta, alvos de pelo menos 48px e conteúdo ao lado. Não apresentar simultaneamente a barra inferior de celular. Manter os controles alcançáveis também com altura de tela reduzida.

**R6 — Desktop e superfície de trabalho.** A partir de 1025px, apresentar navegação lateral desktop, preservando a possibilidade atual de recolhimento e os destinos autorizados. A partir de 768px, o conteúdo usa superfície de trabalho com contorno de 1px, raio de 16px, margem de 8px e cabeçalho transparente, com a navegação integrada ao entorno conforme a referência. Ajustar a geometria do layout atual, incluindo a composição do cabeçalho e a relação entre lateral e conteúdo.

**R7 — Navegação real e operações existentes.** Os itens da referência Transações e Assistente só passam a existir quando suas Features entregarem as telas reais. Nesta entrega, aplicar a composição do design aos destinos atuais do sistema. Todos os destinos, grupos, ações da conta, notificações e saída hoje disponíveis permanecem alcançáveis nas três faixas, respeitando permissões. Áreas administrativas ou de suporte com mais destinos que os três itens do protótipo devem preservar seus grupos e acesso sem sobrepor controles nem inventar novos destinos.

**R8 — Comportamento preservado.** Formulários, validações, resultados, confirmações, cancelamentos e controles de acesso existentes mantêm seus efeitos. Adequar apresentação não cria requisitos de dois fatores, passkeys, temas adicionais ou tradução de URLs descritos em outras demandas remotas, que não integram o inventário desta Feature.

**R9 — Mensagens coerentes.** Não transportar para a aplicação mensagens que afirmem armazenamento apenas neste navegador, conta local ou assistente simulado. Os dados da conta exibidos são os reais disponíveis; mensagens de funcionalidades futuras não devem indicar que elas já funcionam.

**R10 — Limite das próximas Features.** F01 possui a base compartilhada e a adequação integral das telas atuais. A composição específica e os dados das novas telas de categorias, transações, dashboard e chat serão entregues e aceitos nas Features responsáveis usando esta identidade. F01 não deve criar páginas financeiras vazias nem dados demonstrativos.

## Dados percebidos pelo usuário

Marca FinAI, títulos, textos, cores, tipografia, ícones, destinos de navegação, identificação da conta, campos, registros atualmente exibidos, ações e estados visuais. Os dados e permissões existentes permanecem equivalentes; não há criação de informações financeiras nesta Feature.

## Critérios de aceite

**CA01 — Cobertura completa.** Percorrer todas as telas e estados de R1 disponíveis a cada ator; todas apresentam a identidade FinAI, inclusive acesso, recuperação, perfil, administração e suporte. Telas sem mockup mantêm finalidade, campos e ações com a linguagem visual comum.

**CA02 — Fidelidade da base.** Comparar os elementos compartilhados aplicáveis com o `index.html`: marca, paleta de R3, tipografia, hierarquia, espaços, proporções, bordas, raios, sombras e estados correspondem à referência. A composição Rem Soft atual não permanece como layout apenas recolorido.

**CA03 — Layout desktop.** Nas larguras a partir de 1025px, verificar lateral desktop, recolhimento, cabeçalho, superfície contornada e relação entre navegação e conteúdo de R6. Acessar todos os destinos e ações atuais autorizados com lateral aberta e recolhida.

**CA04 — Layout tablet.** Nas larguras de 768 a 1024px, verificar lateral compacta, dimensões e área segura de R5, conteúdo ao lado e ausência de barra inferior. Acessar os controles da lateral e da conta, inclusive com pouco espaço vertical.

**CA05 — Layout celular.** Até 767px, verificar marca no topo e barra inferior de R4, com estado ativo, nomes acessíveis e foco. Rolar até o fim da página, focar controles, abrir menus e diálogos: navegação e área segura não encobrem dados, mensagens ou ações.

**CA06 — Matriz responsiva.** Conferir as telas abrangidas em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, comparando as partes aplicáveis com a referência e verificando as adaptações das demais telas. Não há rolagem horizontal da página nem perda de ações. Conferir também transições 767/768px e 1024/1025px, inclusive após recolher a lateral desktop.

**CA07 — Navegação preservada.** Como cliente, administrador e suporte, acessar todos os destinos previamente permitidos, perfil, notificações e saída em cada faixa. Destinos sem permissão continuam indisponíveis. Não aparecem atalhos para telas financeiras ainda não entregues.

**CA08 — Componentes e estados.** Exercitar os estados aplicáveis existentes de normal, hover, foco, ativo, desabilitado, carregamento, vazio, erro, sucesso, confirmação e cancelamento. Eles usam a identidade comum e continuam distinguíveis e utilizáveis com mouse e teclado.

**CA09 — Funções equivalentes.** Enviar formulários atuais com dados válidos e inválidos e usar ações de lista, diálogo e painel lateral conforme disponíveis. Os campos, validações, resultados, cancelamentos e restrições mantêm o comportamento anterior após a adequação visual.

**CA10 — Conteúdo coerente.** Não há identidade genérica Rem Soft apresentada como marca do produto nas superfícies abrangidas, nem textos do protótipo sobre armazenamento local ou assistente simulado. Conteúdo funcional e dados próprios dos usuários mantêm seus significados.

**CA11 — Fronteira da entrega.** A adequação pode ser demonstrada nas telas atuais sem criar páginas financeiras, números fictícios ou integração de IA. O dashboard atual está visualmente adequado, enquanto os indicadores financeiros aguardam F05.

## Dependências

Sem dependência funcional das outras Features. Usa as telas atuais como base de aceitação e o pacote compartilhado como fonte. F02–F07 consomem a fundação visual; suas funções e composições específicas não precisam ser antecipadas para concluir F01.

## Designs e evidências

O design fornecido para o FinAI é a referência visual desta entrega, incluindo identidade, componentes, estados e composição responsiva. Os critérios CA01–CA11 especificam sua aplicação às telas existentes e às adaptações aprovadas.

Telas sem desenho específico recebem a mesma linguagem visual, preservando campos, ações e permissões. A navegação mantém os destinos reais e os controles da conta disponíveis em todas as larguras. Mensagens demonstrativas sobre armazenamento local e assistente simulado não são transportadas para o produto.

## Dentro do escopo

Adequação visual integral das telas atuais, correção da estrutura e geometria do layout, identidade FinAI, navegação adaptável, componentes e estados compartilhados, com cobertura de acesso, recuperação, perfil, administração e suporte. Definição da base consumida pelas próximas Features.

## Fora do escopo

Novas operações financeiras, criação de telas de Transações ou Assistente, indicadores financeiros reais, integração com IA e mudanças de autenticação ou permissões. Esses comportamentos pertencem aos demais itens aprovados. Não há redução da cobertura visual de telas existentes.
