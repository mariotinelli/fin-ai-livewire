# Temas e correções de responsividade do FinAI

## Situação

Catálogo aprovado por Mário nesta conversa, incluindo a separação dos três itens e a ordem B01 → B02 → T01. Origem: solicitação de Mário em 14/11/2026. Os três requisitos foram aprovados, publicados e relidos: B01 #1016397, B02 #1016398 e T01 #1016399. Nenhuma implementação realizada neste fluxo.

Projeto identificado pelos artefatos existentes: FinAi (65224). Versões abertas consultadas pelo MCP: Sprint 1 (20355) e Livewire (20359), ambas sem data de entrega. Mário escolheu explicitamente Livewire (20359) para os três itens nesta conversa.

## Objetivo

Permitir escolher a aparência do sistema entre claro, escuro e sistema e corrigir os problemas de uso em telas menores apresentados nas capturas da barra de ambiente e da tabela de Usuários.

## Catálogo aprovado

| ID | Candidato | Tipo | Ator, fluxo e resultado | Limites e aceite resumido | Destino proposto |
| --- | --- | --- | --- | --- | --- |
| T01 | Escolha de tema claro, escuro e sistema | Feature | Usuário escolhe uma das três opções na interface e percebe a aplicação do tema. Sistema acompanha a preferência de aparência do dispositivo. | Cobrir as telas existentes e componentes compartilhados, preservando a identidade FinAI e a legibilidade dos estados. QA alterna as opções na interface e confere telas públicas e autenticadas aplicáveis. Decisões aprovadas: padrão Sistema e preferência por navegador na área de trabalho; revisão solicitada por Mário retira o seletor das telas de acesso, que passam a seguir automaticamente o dispositivo. | Feature #1016399; temas adicionais estavam explicitamente fora da Feature #1016270. |
| B01 | Barra de ambiente utilizável em telas menores | Bug | Usuário com a barra de ambiente habilitada abre uma tela em largura reduzida e continua vendo o conteúdo e alcançando os controles da barra. | Identificação de ambiente e branch e controles existentes devem permanecer acessíveis, sem deslocar a página para fora da área visível nem sobrepor o conteúdo. QA confere a tela de Usuários das evidências, com branch longa, e outras telas que usam a barra. A composição esperada em pouco espaço será definida na entrevista. | Bug próprio; relacionar à adequação visual #1016270 após conferir os registros remotos pertinentes. |
| B02 | Tabelas utilizáveis em telas menores | Bug | Usuário autorizado consulta uma listagem em largura reduzida e alcança conteúdo, busca, filtros, paginação e ações existentes. | Evidência inicial na lista de Usuários, inclusive estado vazio. Proposta de cobertura do componente compartilhado e das listagens consumidoras, com dados e sem dados. Não perder acesso às colunas e ações nem provocar rolagem horizontal da página. A adaptação da tabela e as larguras de aceite serão definidas na entrevista. | Bug próprio; relacionar à adequação visual #1016270 após conferir os registros remotos pertinentes. |

Todos os três pedidos têm destino próprio. Não há exclusão aprovada nem item absorvido por outro.

## Evidências e fatos inspecionados

- E01 — [E01 — Barra de ambiente em tela menor; captura original de 14/11/2026 às 10:27:39.](https://redmine.remsoft.com.br/attachments/download/3373/e01-envbar-tela-menor.png) — anexo 3373 em [#1016397](https://redmine.remsoft.com.br/issues/1016397).
- E02 — [E02 — Tabela de Usuários em tela menor; captura original de 14/11/2026 às 10:27:32.](https://redmine.remsoft.com.br/attachments/download/3374/e02-tabela-usuarios-tela-menor.png) — anexo 3374 em [#1016398](https://redmine.remsoft.com.br/issues/1016398).
- E03 — [E03 — Tabela de Usuários em largura maior para comparação; captura original de 14/11/2026 às 10:27:15.](https://redmine.remsoft.com.br/attachments/download/3375/e03-tabela-usuarios-comparacao.png) — anexo 3375 em [#1016398](https://redmine.remsoft.com.br/issues/1016398).
- E04 — [E04 — Tabela de Usuários com conteúdo cortado; captura original de 14/11/2026 às 10:26:44.](https://redmine.remsoft.com.br/attachments/download/3376/e04-tabela-usuarios-conteudo-cortado.png) — anexo 3376 em [#1016398](https://redmine.remsoft.com.br/issues/1016398).

As quatro imagens foram abertas e inspecionadas. Mostram a tela de Usuários em espaço reduzido, com barra de ambiente no topo nas capturas aplicáveis. Há cortes de conteúdo da tabela em algumas capturas; a mensagem vazia também aparece cortada. As dimensões exatas do viewport e o comportamento ao interagir não foram demonstrados pelas imagens. Não houve reprodução em navegador nem comprovação da causa técnica.

No código inspecionado, os layouts público e autenticado fixam `data-theme="remsoft"`; `resources/css/themes.css` define esse tema como claro. A barra compartilhada está em `resources/views/components/dev/bar.blade.php`, com identificação em `resources/views/livewire/dev/env-bar.blade.php`. A tabela compartilhada está em `resources/views/components/ui/table.blade.php`. Essas referências identificam áreas pertinentes, sem impor solução técnica.

Fonte aprovada existente: [Adequação visual completa do FinAI — #1016270](../../features/1016270-adequacao-visual-completa-do-finai/feature.md). O requisito inclui telas públicas, autenticadas, perfil, administração e suporte; exige uso responsivo sem perda de ações e sem rolagem horizontal da página. Temas adicionais estão fora daquele escopo. Seu documento não comprova o estado atual da implementação nem autoriza alterar seus critérios.

Consulta inicial no Redmine por título contendo “tema”, em todo o projeto FinAi e todos os status, não retornou resultados. A busca não esgota similaridade: conferir outros termos e ler os candidatos pertinentes antes de qualquer publicação.

## Vocabulário

- Tema: aparência visual da interface. Opções solicitadas: claro, escuro e sistema.
- Sistema: opção que acompanha a preferência de aparência do dispositivo; detalhes de atualização pendentes de entrevista.
- Barra de ambiente (envbar): faixa de identificação de ambiente e branch com os controles de acesso já existentes; não confundir com o cabeçalho ou a navegação principal.
- Tabela: componente de listagem e seus controles associados; Usuários é a tela comprovada nas evidências.

## Dependências e ordem proposta

Não foi demonstrada dependência funcional entre T01, B01 e B02. Cada item pode ser definido e aceito nas telas existentes. B01 e B02 têm relação de contexto com #1016270, sem bloqueio remoto estabelecido.

Grafo: T01, B01 e B02 independentes. Ordem sugerida: B01 → B02 → T01, como prioridade de tratamento dos defeitos observados, sem representar dependência. Ao validar B02, conferir o caso com e sem barra de ambiente para distinguir a contribuição de cada problema.

A capacidade visual compartilhada de temas pertence integralmente a T01, incluindo a escolha utilizável na interface e sua aplicação às telas. Os Bugs possuem seus respectivos comportamentos responsivos. Não criar uma entrega interna de preparação sem resultado demonstrável pelo QA.

## Resultado e passagem para project-slices

Os três requisitos e respectivas publicações foram aprovados separadamente pelo responsável. Descrições completas, projeto, versão, status e relações foram relidos e conferidos; não houve resultado remoto incerto. Cada item tem uma relação `relates` com #1016270, sem dependências bloqueadoras entre os novos itens. Não houve modificação de conteúdo ou status de demandas existentes.

Project-slices iniciado na ordem aprovada B01 → B02 → T01. As três decomposições foram aprovadas, publicadas e conferidas, com 13 filhas, 28h, Sequencing 38–50 e DOCX nas quatro QAs. O requisito de temas r002 está aplicado no pai. Nenhuma implementação foi iniciada.

| Item | Requisito e publicação | Slicing / implementação |
| --- | --- | --- |
| B01 | [Requisito aprovado](../../bugs/1016397-barra-de-ambiente-em-telas-menores/bug.md); [#1016397](https://redmine.remsoft.com.br/issues/1016397), Livewire, New; relação `relates` com #1016270 conferida | [Slicing publicado](../../bugs/1016397-barra-de-ambiente-em-telas-menores/slices/slices.md): 1 DEV + 1 QA, 3h, sequência 38–39; 8 condições e DOCX r001 conferido. Publicado e conferido; sem implementação |
| B02 | [Requisito aprovado](../../bugs/1016398-tabelas-em-telas-menores/bug.md); [#1016398](https://redmine.remsoft.com.br/issues/1016398), Livewire, New; relação `relates` com #1016270 conferida; tabela com rolagem horizontal interna | [Slicing proposto](../../bugs/1016398-tabelas-em-telas-menores/slices/slices.md): 4 DEV + 1 QA, 7h, sequência 40–44; 10 condições e DOCX r001 conferido. Publicado e conferido; sem implementação |
| T01 | [Requisito aprovado](../../features/1016399-temas-claro-escuro-e-sistema/feature.md); [#1016399](https://redmine.remsoft.com.br/issues/1016399), Livewire, New; relação `relates` com #1016270 conferida; padrão Sistema/preferência por navegador na área de trabalho; [requisito r002 aprovado](../../features/1016399-temas-claro-escuro-e-sistema/slices/r002/feature-proposta.md), sem seletor nas telas de acesso | [Slicing proposto](../../features/1016399-temas-claro-escuro-e-sistema/slices/slices.md): 4 DEV + 2 QA, 18h, sequência 45–50; revisão funcional r002 com 18 condições ativas, CT-003 reservada e DOCX r002 associado/conferido nas duas QAs. Publicado e conferido; sem implementação |

Fontes para a próxima etapa: E01 para B01; E02–E04 para B02; identidade visual e inventário de #1016270 para T01. As quatro imagens originais estão anexadas aos Bugs correspondentes no Redmine e referenciadas neste catálogo e nas descrições remotas, sem depender do computador de origem. A correção foi solicitada expressamente por Mário após a publicação inicial. A Feature de temas teve seu link remoto para #1016270 corrigido; não recebeu capturas próprias.

## Calibração de estimativas pelo responsável

Mário corrigiu as estimativas nesta conversa: envbar DEV 2h e QA 1h; tabelas DEV 2h, 1h, 1h e 1h, QA 2h. Totais vigentes: envbar 3h, tabelas 7h, temas 19h, conjunto 29h. Sem mudança de escopo, condições, DOCX, relações ou Sequencing. A dúvida sobre a presença de seletor de temas nas telas públicas não constitui, por si, alteração do requisito aprovado; a publicação do slicing continua pendente.

## Acompanhamento da publicação do slicing aprovado

Mário aprovou a revisão r002 de temas e o conjunto completo. Sem implementação ou execução de QA neste fluxo.

| Item | Publicação do slicing | Próximo passo |
| --- | --- | --- |
| B01 | DEV #1016401 (2h), QA #1016402 (1h), Sequencing 38–39; relação, âncora 38 e DOCX r001 na QA conferidos; task.md materializados | plan-issue para a DEV |
| B02 | DEV #1016403–#1016406 (2h/1h/1h/1h), QA #1016407 (2h), Sequencing 40–44; quatro bloqueios, âncora 40 e DOCX r001 conferidos; task.md materializados | plan-issue para as DEVs |
| T01 | Requisito r002, DEV #1016408–#1016411 (5h/2h/1,5h/2,5h), QAs #1016412 (3h) e #1016413 (4h), Sequencing 45–50; onze bloqueios, âncora 45 e DOCX r002 nas duas QAs conferidos; task.md materializados | plan-issue para DEVs conforme fornecedores |

## Correção funcional sobre temas nas telas de acesso

Mário retirou expressamente a escolha de temas das telas públicas de login/esqueci a senha e demais jornadas de acesso. A [revisão r002 do requisito](../../features/1016399-temas-claro-escuro-e-sistema/slices/r002/feature-proposta.md) propõe aparência automática do dispositivo nessas superfícies, sem seletor e sem aplicar a escolha autenticada guardada. A escolha Claro/Escuro/Sistema e sua lembrança por navegador permanecem apenas na área de trabalho. Algumas telas de acesso exigem sessão; sua política continua automática conforme a superfície.

O requisito r001 permanece preservado no histórico; o requisito canônico e a descrição remota foram atualizados para r002 após aprovação. [Slicing r002](../../features/1016399-temas-claro-escuro-e-sistema/slices/slices.md): 4 DEV e 2 QA, 18h. CT-003 retirada/reservada, CT-017–CT-019 novas; fonte e Word r001 preservados, Word r002 gerado e conferido. As 13 filhas, relações, âncoras e DOCX foram publicados e relidos. Conjunto confirmado: envbar 3h + tabelas 7h + temas 18h = 28h, com 13 filhas e blocos 38–50 inalterados. Os valores anteriores de 19h/29h no registro de calibração são históricos e foram substituídos por esta revisão.

## Entrega final do project-slices

Slicing concluído: 13 filhas publicadas e conferidas, 28h de esforço estimado, bloco 38–50 e âncoras dos pais 38/40/45. Status dos pais New preservados e demais issues sem renumeração. DOCX r001 de envbar na QA #1016402 (anexo 3379), DOCX r001 de tabelas na QA #1016407 (3380), DOCX r002 de temas nas QAs #1016412 (3381) e #1016413 (3382). Nenhuma operação incerta. Os 13 task.md estão materializados com IDs definitivos e fontes remotas.

A escolha de tema permanece só no menu da conta da área de trabalho; telas de acesso seguem o dispositivo sem seletor e sem apagar a preferência autenticada. Próximo papel: plan-issue, iniciando pela DEV #1016401 e seguindo os fornecedores de cada tarefa. Não houve implementação ou execução QA neste fluxo.
