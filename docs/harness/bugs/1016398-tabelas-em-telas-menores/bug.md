# Tabelas utilizáveis em telas menores

## Identidade e revisão

- Item B02 do [catálogo aprovado](../../scopes/2026-11-14-temas-e-responsividade/scope.md).
- Projeto: FinAi (65224). Versão escolhida por Mário: Livewire (20359).
- Bug [#1016398](https://redmine.remsoft.com.br/issues/1016398), requisito e publicação aprovados por Mário nesta conversa. Publicação relida e conferida. Sem implementação neste fluxo.
- Decisão de Mário nesta conversa: preservar o formato tabular e permitir rolagem horizontal interna para acessar as demais colunas em telas menores.

## Objetivo

Corrigir a apresentação das tabelas em telas menores para permitir consultar todas as colunas e usar os controles e ações existentes sem alargar a página nem cortar suas mensagens.

## Impacto

As capturas da lista de Usuários mostram colunas fora da área visível e a mensagem de lista vazia parcialmente cortada. O usuário pode não conseguir consultar os dados ou alcançar ações em pouco espaço. As imagens não demonstram se a rolagem interna atual permite alcançar todas as colunas.

## Comportamento atual

As evidências E02 e E04 mostram o recorte de conteúdo da tabela e do estado vazio em larguras reduzidas. E03 apresenta a mesma listagem em uma composição mais larga e serve de comparação. As larguras exatas dos viewports não foram informadas. A inspeção do componente identifica uma região de rolagem horizontal existente, mas isso não comprova seu funcionamento nem a causa do defeito. Não houve reprodução em navegador neste fluxo.

## Comportamento esperado

1. Manter a apresentação em tabela. Quando as colunas não couberem, permitir rolar horizontalmente apenas a região de cabeçalho e linhas, alcançando todas as colunas e suas ações.
2. A página e a estrutura externa da listagem permanecem ajustadas à largura disponível. Busca, filtros, contadores, seleção de quantidade por página e paginação não devem exigir deslocar horizontalmente as colunas para serem usados; podem se reorganizar conforme o espaço.
3. Preservar a correspondência entre cabeçalhos e células durante a rolagem. As ações continuam na coluna à direita e alcançáveis ao rolar até ela, sem obrigação de fixar colunas.
4. Mensagens de lista vazia e de nenhum resultado, incluindo suas ações existentes, devem ser legíveis dentro da largura visível, sem exigir rolagem horizontal para ler o texto completo. Preservar também as mensagens existentes quando uma consulta não é executada por erro de filtros.
5. Menus de ação, filtros e demais controles associados devem abrir e permanecer utilizáveis em telas menores, sem serem cortados pela região rolável.
6. Preservar resultados, pesquisa, ordenação, filtros, paginação, quantidade por página, efeitos das ações e permissões de cada listagem. Em larguras onde as colunas couberem, preservar a leitura habitual.

## Passos de reprodução conhecidos

1. Entrar com acesso à gestão de Usuários e abrir sua listagem.
2. Usar uma situação sem usuários cadastrados, como nas evidências, ou sem resultados para uma consulta.
3. Reduzir a largura da janela para uma faixa de celular.
4. Observar o enquadramento da tabela, das colunas e da mensagem vazia. Conferir se há conteúdo cortado e se é possível alcançar todas as colunas.

Os passos foram inferidos das imagens e do código, sem execução. A validação da correção também inclui registros preenchidos e textos longos, pois o estado vazio isolado não demonstra acesso às ações e dados.

## Contexto e condições

A correção abrange o componente compartilhado e seus quatro consumidores existentes identificados no código:

- Gestão de Usuários.
- Gestão de Perfis de acesso.
- Alertas de erros.
- Histórico de comandos Artisan.

Cada tela é validada com um ator que já possua acesso, sem ampliar permissões. Conferir com e sem barra de ambiente, nos contextos onde isso já é permitido, para separar este defeito de B01 (#1016397). Não há dependência funcional de B01 nem requisito de criar outras listagens.

## Evidências

### E02

E02 — Tabela de Usuários em tela menor; captura original de 14/11/2026 às 10:27:32.

[Baixar evidência E02](https://redmine.remsoft.com.br/attachments/download/3374/e02-tabela-usuarios-tela-menor.png)

![Evidência E02](https://redmine.remsoft.com.br/attachments/download/3374/e02-tabela-usuarios-tela-menor.png)

### E03

E03 — Tabela de Usuários em largura maior para comparação; captura original de 14/11/2026 às 10:27:15.

[Baixar evidência E03](https://redmine.remsoft.com.br/attachments/download/3375/e03-tabela-usuarios-comparacao.png)

![Evidência E03](https://redmine.remsoft.com.br/attachments/download/3375/e03-tabela-usuarios-comparacao.png)

### E04

E04 — Tabela de Usuários com conteúdo cortado; captura original de 14/11/2026 às 10:26:44.

[Baixar evidência E04](https://redmine.remsoft.com.br/attachments/download/3376/e04-tabela-usuarios-conteudo-cortado.png)

![Evidência E04](https://redmine.remsoft.com.br/attachments/download/3376/e04-tabela-usuarios-conteudo-cortado.png)

As capturas originais estão anexadas a esta issue e podem ser consultadas sem acesso ao computador de origem.

Referência de cobertura visual: [#1016270 — Adequação visual completa do FinAI](https://redmine.remsoft.com.br/issues/1016270).

## Frequência e alcance

O defeito foi relatado com três capturas da tela de Usuários. Frequência não medida; não se afirma que os quatro consumidores apresentam todos os sintomas. A cobertura compartilhada busca preservar o resultado nas tabelas existentes.

## Critérios de correção

- **CC01 — Rolagem restrita à tabela:** em 360×800, 390×844 e 430×932, consultar registros de Usuários com conteúdo suficiente para exceder a largura. Rolar as colunas até o início e o fim; todos os cabeçalhos, dados e ações são alcançáveis e alinhados. A tabela não provoca rolagem horizontal global da página.
- **CC02 — Controles externos utilizáveis:** nas mesmas larguras, usar busca, filtros disponíveis, quantidade por página e paginação. Os controles e contadores permanecem dentro da largura visível e não acompanham o deslocamento horizontal das colunas. Seus resultados continuam equivalentes aos atuais.
- **CC03 — Estados sem registros:** conferir lista vazia e busca ou filtros sem resultado. Título, descrição e ações existentes ficam integralmente legíveis, com quebra de texto quando necessária, sem rolar horizontalmente. Quando existente, a mensagem de consulta não executada por filtros inválidos também cabe na largura visível.
- **CC04 — Ações e menus:** alcançar a coluna de ações à direita, abrir menus e usar ações permitidas de cada tela. Os controles não ficam cortados pela região de rolagem; permissões, resultados e confirmações existentes permanecem equivalentes.
- **CC05 — Consumidores existentes:** conferir Usuários, Perfis de acesso, Alertas de erros e Histórico de comandos, com dados, sem dados e sem resultados conforme os estados existentes de cada tela, incluindo textos longos.
- **CC06 — Outras larguras e transições:** conferir também 600×960, 820×1180, 1024×768 e 1366×768, incluindo transições 767/768px e 1024/1025px. Quando as colunas couberem, a listagem mantém a leitura habitual; quando não couberem, a rolagem permanece interna.
- **CC07 — Integração com o layout:** conferir com e sem barra de ambiente nas condições existentes e navegar até o fim da listagem. A tabela não desloca a página horizontalmente nem torna conteúdo ou ações inacessíveis junto à navegação principal.

## Designs e evidências

Não há mockup novo. As capturas comprovam os sintomas observados, sem estabelecer a composição final. Mário escolheu expressamente tabela com rolagem horizontal interna, preservando as colunas. A correção mantém a identidade visual vigente; não converte os registros em cartões nem introduz novas informações.

## Dentro do escopo

Apresentação responsiva da tabela compartilhada e de seus consumidores identificados, rolagem interna das colunas, enquadramento de busca/filtros/paginação e demais controles, mensagens dos estados existentes e acesso às ações, preservando operações e permissões.

## Fora do escopo

Correção da barra de ambiente (B01), escolha de temas (T01), conversão em cartões, novas colunas ou funcionalidades de listagem, mudanças de regras de consulta ou permissões e criação de novas telas.

## Publicação autorizada e conferida

- Servidor: https://redmine.remsoft.com.br. Usuário consultado neste fluxo: Mário Tinelli (131789).
- Criar Bug (tracker 1), projeto FinAi (65224), versão Livewire (20359), status New (1), prioridade Normal (4), sem categoria, responsável, pai ou Sequencing definidos nesta operação.
- Título: `[WEB] [USUÁRIO] Corrigir tabelas em telas menores`.
- Descrição: publicar integralmente de Objetivo até Fora do escopo, incluindo CC01–CC07, com delimitadores project-flow e a origem estável `docs/harness/.runs/2026-11-14-temas-e-responsividade/b02-tabelas/bug.md`, item B02.
- Após confirmar o ID retornado, mover para `docs/harness/bugs/<ID>-tabelas-em-telas-menores/bug.md` e acrescentar esse caminho definitivo à descrição, preservando a referência de origem.
- Criar relação B02 `relates` #1016270, pela cobertura de tabelas responsivas da adequação visual, sem bloqueio. Não criar dependência de B01.
- Não modificar conteúdo ou campos de outras issues. A publicação inicial não incluiu comentários nem anexos; os anexos foram acrescentados na correção solicitada pelo responsável.
- Buscas por títulos contendo “tabela” e “table”, em todos os status de FinAi, não retornaram candidatos; a busca anterior por “responsiv” também não retornou candidatos. Conferir novamente contexto e similaridade antes de publicar.

| Operação autorizada | Resultado conferido |
| --- | --- |
| Criar Bug com descrição integral e origem estável | #1016398 criado; Bug, New, Normal, FinAi, versão Livewire; descrição relida e equivalente à enviada |
| Acrescentar referência definitiva | Caminho docs/harness/bugs/1016398-tabelas-em-telas-menores/bug.md acrescentado, preservando origem e conteúdo |
| Relacionar com #1016270 | Relação `relates` 954 confirmada entre #1016270 e #1016398 |

Sequencing ficou vazio na publicação inicial; o slicing aprovado atribuiu a âncora 40 ao pai. Não houve comentários, slicing ou implementação. Entrada disponível para project-slices: este requisito aprovado, pai #1016398 confirmado e evidências E02–E04 anexadas ao Bug no Redmine e referenciadas acima.

## Correção das referências de evidência

Por solicitação de Mário, as referências ao computador de origem foram substituídas pelos anexos originais no Redmine, também incluídos como imagens na descrição. Anexos confirmados: [e02-tabela-usuarios-tela-menor.png](https://redmine.remsoft.com.br/attachments/download/3374/e02-tabela-usuarios-tela-menor.png), [e03-tabela-usuarios-comparacao.png](https://redmine.remsoft.com.br/attachments/download/3375/e03-tabela-usuarios-comparacao.png), [e04-tabela-usuarios-conteudo-cortado.png](https://redmine.remsoft.com.br/attachments/download/3376/e04-tabela-usuarios-conteudo-cortado.png). A alteração preserva critérios, status, versão, prioridade, campos e relações do requisito.

## Slicing publicado e conferido

[D01 #1016403](https://redmine.remsoft.com.br/issues/1016403) — 2h, Sequencing 40; [D02 #1016404](https://redmine.remsoft.com.br/issues/1016404) — 1h, Sequencing 41; [D03 #1016405](https://redmine.remsoft.com.br/issues/1016405) — 1h, Sequencing 42; [D04 #1016406](https://redmine.remsoft.com.br/issues/1016406) — 1h, Sequencing 43; [Q01 #1016407](https://redmine.remsoft.com.br/issues/1016407) — 2h, Sequencing 44. [Slicing](slices/slices.md). Relações e DOCX conferidos; task.md materializados. Próximo passo: plan-issue nas DEVs; implementação e QA ainda não executadas.
