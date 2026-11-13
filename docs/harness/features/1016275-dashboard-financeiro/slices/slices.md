# Fatiamento de Dashboard financeiro

## Identidade e situação

- Pai: [#1016275](https://redmine.remsoft.com.br/issues/1016275), `[WEB] [USUARIO] Dashboard financeiro`; [requisito aprovado](../feature.md).
- Projeto FinAi (65224); versão aberta Livewire (20359), seleção vigente no [escopo](../../../scopes/2026-11-13-finai-mvp/scope.md).
- Revisão r001 de 13/11/2026: conjunto aprovado, publicado e integralmente conferido; nenhuma implementação ou execução de QA realizada neste fluxo.
- MCP confirmado: redmine.remsoft.com.br, mario.tinelli (131789), projeto FinAi (65224), versão aberta Livewire (20359). Antes de publicar, pai New (1)/Normal (4), sem filhas/anexos/Sequencing. Depois, permanece New e espelha 23; requisito, demais campos e relações anteriores preservados.
- A F07 teve conteúdo funcional aprovado separadamente. Esta prévia fecha o tamanho do bloco F05 e apresenta apenas o complemento de números/fornecedor da F07, sem reabrir sua aprovação de escopo/horas.

## Evidências e aceite próprio

O titular abre a Visão geral, reconhece indicadores reais, muda mês, consulta detalhes/histórico e usa cadastro e chat reais de F04/F06. Todos esses fornecedores precisam estar disponíveis na conclusão; F07 consome indicadores posteriormente e não bloqueia o dashboard.

| Evidência                                                                                                               | Conclusão                                                                                                                                                  |
| ----------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `resources/views/dashboard.blade.php`                                                                                   | Apresenta saudação Rem Soft; não comprova qualquer indicador financeiro pronto. A adequação visual compartilhada pertence a F01.                           |
| `routes/customer.php`, `app/Support/Navigation/Definitions/BaseSidebarMenu.php`                                         | Rota/navegação de dashboard já existem. Não criar bloqueio entre consumidores somente porque compartilham essa tela.                                       |
| Busca em app/tests/views e fornecedores no MCP                                                                          | Não há código financeiro implementado neste checkout. F04 QA #1016356 e F06 QA #1016369 estão New; publicação não prova reuso operacional disponível.      |
| F04 slicing/filhas #1016351–#1016356                                                                                    | Fornecerá regras, cadastro, leitura/histórico/detalhes/edição/exclusão reais. Consumir, sem reconstruir esses fluxos na F05.                               |
| F06 slicing/filhas #1016364–#1016369                                                                                    | Fornecerá chat/consulta real para o convite, sem exigir implementação de IA na F05.                                                                        |
| V01 index.html #overview/.stats/cartões, #month, #graph/#month-result, #recent, Ver todas, .assistant-teaser/#open-chat | Fonte real inspecionada. #recent é o locador correto, e o convite usa classe .assistant-teaser. Simulação/armazenamento local não são regras da aplicação. |
| Grafo MCP completo                                                                                                      | 28 issues/41 relações blocks, todos os endpoints lidos e sem ciclo. Relação #900 F05→F07 permanece preservada.                                             |

Inspeção estática e leituras MCP, sem teste executado ou chamada de IA. O caminho de aceite existe no escopo próprio da F05 com fornecedores anteriores disponíveis; não há Study necessária.

## Tarefas publicadas

| Ref. | Título completo                                                                                                                          | Papel | Horas | Sequencing | Bloqueio de início |
| ---- | ---------------------------------------------------------------------------------------------------------------------------------------- | ----- | ----: | ---------: | ------------------ |
| D01  | [[DEV] [WEB] [USUARIO] Dashboard financeiro - Saldo acumulado real](https://redmine.remsoft.com.br/issues/1016378)                       | DEV   |     2 |         23 | QA F04 #1016356    |
| D02  | [[DEV] [WEB] [USUARIO] Dashboard financeiro - Totais e contagens mensais](https://redmine.remsoft.com.br/issues/1016379)                 | DEV   |     2 |         24 | QA F04 #1016356    |
| D03  | [[DEV] [WEB] [USUARIO] Dashboard financeiro - Comparação e resultado mensal](https://redmine.remsoft.com.br/issues/1016380)              | DEV   |   1,5 |         25 | D02                |
| D04  | [[DEV] [WEB] [USUARIO] Dashboard financeiro - Recentes e detalhes reais](https://redmine.remsoft.com.br/issues/1016381)                  | DEV   |     2 |         26 | QA F04 #1016356    |
| D05  | [[DEV] [WEB] [USUARIO] Dashboard financeiro - Cadastro pela Visão geral](https://redmine.remsoft.com.br/issues/1016382)                  | DEV   |     1 |         27 | QA F04 #1016356    |
| D06  | [[DEV] [WEB] [USUARIO] Dashboard financeiro - Histórico completo a partir da Visão geral](https://redmine.remsoft.com.br/issues/1016383) | DEV   |   0,5 |         28 | QA F04 #1016356    |
| D07  | [[DEV] [WEB] [USUARIO] Dashboard financeiro - Convite para o assistente real](https://redmine.remsoft.com.br/issues/1016384)             | DEV   |   0,5 |         29 | QA F06 #1016369    |
| QA   | [[QA] [WEB] [USUARIO] Dashboard financeiro](https://redmine.remsoft.com.br/issues/1016385)                                               | QA    |   3,5 |         30 | D01–D07            |

Estimativa publicada: **9,5h DEV + 3,5h QA = 13h**, todas positivas até seis horas e aprovadas pelo responsável.

Totais/contagens e comparação/resultado têm aceites próprios; o segundo consome o período/números do primeiro. Recentes incluem detalhes por necessidade de leitura integral móvel, preservando manutenção F04 já fornecida. Consultar todo o histórico remove um recorte anterior e tem resultado distinto dos cinco recentes; cadastro e convite também concluem jornadas com resultado real, sem tarefas limitadas a desenhar botões.

Cada consumidor atualiza o próprio resultado após mutação bem-sucedida; o preparo comum é contado uma vez no primeiro consumidor. Cadastro/detalhes acionam operações fornecidas por F04, sem receber outra implementação de todos os cálculos. Integrações necessárias à conclusão são declaradas nas descrições; compartilhar a rota existente não cria bloqueios de início adicionais.

## Estimativas e calibração

Dois pareceres independentes, `slicing_review_delivery` e `slicing_review_reuse`, receberam requisito, evidências e referências humanas sem horas candidatas nem acesso às estimativas um do outro. Revisaram os cortes antes das horas e recomendaram sete DEV.

| Parecer              | D01 | D02 | D03 | D04 | D05 | D06 |  D07 |  QA | Total |
| -------------------- | --: | --: | --: | --: | --: | --: | ---: | --: | ----: |
| Entrega              |   2 |   2 | 1,5 | 1,5 |   1 | 0,5 |  0,5 |   3 |    12 |
| Reuso/cobertura      | 1,5 |   2 |   1 |   2 |   1 | 0,5 | 0,75 | 3,5 | 12,25 |
| Proposta responsável |   2 |   2 | 1,5 |   2 |   1 | 0,5 |  0,5 | 3,5 |    13 |

A proposta considera o primeiro conteúdo financeiro, a verificação visual de comparação/zeros e a integração de manutenção/retorno nos consumidores. Não é média, voto, medição ou nova correção humana.

Os dois pareceres revisaram as descrições finais formatadas e as condições. Foram explicitados BRL/centavos nos cartões e no balanço, o recorte do mesmo mês em anos diferentes e agosto de 2026 como mês sem registros. Não houve outra lacuna material de cobertura, atualização, dependências ou blocos. A revisão de escrita mantém cenários observáveis e fornecedores claros sem prescrever implementação técnica.

| Entrega    | Esforço dominante                                                                                                                                               |
| ---------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| D01 — 2h   | Saldo e primeiro conteúdo real sobre F01, autorização, estados e preparo comum de leitura/atualização.                                                          |
| D02 — 2h   | Seletor/recorte por data financeira, somas/contagens e falha ao trocar mês.                                                                                     |
| D03 — 1,5h | Comparação/resultado pelos mesmos totais, igualdade/zeros/negativos e apresentação visual.                                                                      |
| D04 — 2h   | Ordem de recentes, detalhes e preservação das ações F04, atualização após manutenção e mobile.                                                                  |
| D05 — 1h   | Entrada no cadastro F04 e integração do resultado/cancelamento/falha na Visão geral.                                                                            |
| D06 — 0,5h | Transição ao histórico completo com reset dos quatro filtros, usando destino já pronto.                                                                         |
| D07 — 0,5h | Convite visual e navegação ao chat F06 já entregue; sem construir provedor, memória ou consultas.                                                               |
| QA — 3,5h  | Cerca de 0,5h preparo, 1,25h jornadas/recortes/mutações, 0,5h falhas/isolamento, 0,75h comparação visual agrupada nas nove dimensões e 0,5h evidências/reteste. |

Premissas: executor familiar ao projeto, homologação acessível, F04/F06 verificadas, controles reversíveis preparados dentro da QA, sem infraestrutura adicional nova. Espera por fornecedores/serviço não entra no esforço. A QA verifica usos/efeitos e não repete campanhas inteiras dos fornecedores; não se presume automação visual pronta ou uso de IA para implementar.

Referências humanas: F04 total12h (10 DEV+2 QA); F06 total20h (16 DEV+4 QA corrigida); F07 conteúdo aprovado24,5h; Visual17,5h e Acesso3,5h. São estimativas/correções, não tempos realizados. Reuso de fluxos prontos reduz trabalho específico da F05 sem aplicar percentual ou desconto uniforme.

## Cobertura

| Origem / parcela                           | Destino                                                                                  | Condições                          |
| ------------------------------------------ | ---------------------------------------------------------------------------------------- | ---------------------------------- |
| R1 — dados próprios/atuais/exclusões       | Cada consumidor D01 saldo, D02 mensais, D03 comparação, D04 recentes; jornadas preservam | CT-001/CT-002/CT-008/CT-016        |
| R2 — saldo acumulado/zero/negativo         | D01                                                                                      | CT-002/CT-003/CT-005               |
| R3 — totais/contagens pela data financeira | D02                                                                                      | CT-004/CT-005/CT-013               |
| R4 — comparação e resultado mensal         | D03                                                                                      | CT-006/CT-007                      |
| R5 — mês/fuso/independência                | D02 seletor; D01 saldo e D04 recentes preservam acumulado                                | CT-004/CT-005/CT-013/CT-015        |
| R6 — cinco recentes/ordem/detalhes         | D04                                                                                      | CT-008/CT-009                      |
| R7 — Nova transação                        | D05                                                                                      | CT-011                             |
| R7 — Ver todas/histórico completo          | D06                                                                                      | CT-010                             |
| R7 — ações reais dos detalhes              | D04 preserva F04                                                                         | CT-009/CT-012                      |
| R8 — atualização                           | D01 saldo, D02 mensais, D03 comparação, D04 lista; D05 cadastro/D04 detalhes integram    | CT-011–CT-013                      |
| R9 — formatação/contagens/estados          | Cada consumidor/superfície própria                                                       | CT-002–CT-009/CT-014/CT-015/CT-018 |
| R10 — visual                               | Cada DEV sua superfície; D07 convite                                                     | CT-018                             |
| CA01 — saldo acumulado                     | D01                                                                                      | CT-002/CT-003/CT-005               |
| CA02 — mês/data financeira                 | D02                                                                                      | CT-004/CT-005/CT-013               |
| CA03 — balanço                             | D03                                                                                      | CT-006                             |
| CA04 — recentes/detalhes                   | D04                                                                                      | CT-008/CT-009                      |
| CA05 — histórico completo                  | D06                                                                                      | CT-010                             |
| CA06 — cadastro/manutenção/efeitos         | D05 cadastro; D04 detalhes; consumidores D01–D04 atualizam                               | CT-011–CT-013                      |
| CA07 — conta/mês vazio                     | D01 saldo, D02 mensais, D03 comparação, D04 recentes, D05 cadastro                       | CT-003/CT-007                      |
| CA08 — falhas                              | D01 saldo, D02 recorte, D03 comparação, D04 recentes                                     | CT-014/CT-015                      |
| CA09 — acesso/isolamento                   | Cada superfície protege seu canal                                                        | CT-001/CT-016                      |
| CA10 — dados reais                         | Cada consumidor próprio                                                                  | CT-002/CT-004/CT-006/CT-008/CT-013 |
| CA11 — fidelidade                          | Cada DEV sua superfície; QA conjunto                                                     | CT-009/CT-018                      |
| CA12 — convite real                        | D07                                                                                      | CT-017/CT-018                      |

Nenhum indicador é classificado como implementado pela existência de uma rota ou do protótipo. Todas as regras/critérios têm dono e verificação futura; F07 verifica registros por IA sem condicionar esta QA.

## Condições de teste

Fonte: [condicoes-teste-r001.md](condicoes-teste-r001.md); documento previsto [1016275 - Condições de testes.docx](<r001/1016275 - Condições de testes.docx>), destinado à única QA. As condições integrais abaixo compõem a decisão sobre o conjunto.

Pai: Dashboard financeiro — #1016275.
Projeto: FinAi (65224). Versão: Livewire (20359).
Revisão: r001, prévia de 13/11/2026. Condições não executadas.

### Contexto

Executar pela Visão geral real do titular, com F04 e F06 implementadas/verificadas e, transitivamente, F01/F02 disponíveis. As tarefas fornecedoras publicadas estão New; publicação não prova capacidade pronta. A QA usa formulário, histórico, detalhes e chat reais existentes desses fornecedores, sem reconstruí-los nem repetir suas campanhas completas.

Preparar homologação com contas confirmadas A/B, conta pendente e visitante, registros excluídos e dados distintos de outra conta, relógio em America/Sao_Paulo e falhas reversíveis de leitura/carregamento e mutação. Administração/suporte não ganham visão financeira de terceiros. Dados/controles, registro de evidências e reteste focalizado integram a QA; espera por serviço/fornecedor fica separada.

Fixar hoje em 13/11/2026 para a base: receitas de A Salário R$ 1.000,10 em 30/09/2026 e Freelance R$ 200,20 em 05/11/2026; despesas Alimentação R$ 50,05 em 01/11/2026, Transporte R$ 25,10 em 10/11/2026, Moradia R$ 30,15 em 31/10/2026 e Lazer R$ 10,00 em 01/10/2026. Saldo geral R$ 1.085,00; novembro receitas R$ 200,20/1 e despesas R$ 75,15/2, resultado R$ 125,05; outubro receitas R$ 0,00/0 e despesas R$ 40,15/2, resultado -R$ 40,15; setembro receita R$ 1.000,10/1 sem despesas. Usar agosto de 2026 sem registros e uma conta sem registros. Repor a base entre cenários que a alteram.

Preparar adicionalmente meses com receitas/despesas iguais, empates de data/criação e mais de cinco registros, descrições/valores extensos, registros cuja criação/edição ocorra em mês diferente da data financeira e mais de 50 registros para reconhecer que Ver todas abre o histórico completo. Resultados esperados desses conjuntos são calculados previamente.

Visual V01: docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip, entrada index.html; #overview, .stats, .stat-card, #balance, #income, #expense, #income-count, #expense-count, #month-wrap/#month, #graph, #chart-month, #month-result, #recent, #new-transaction, link Ver todas e .assistant-teaser/#open-chat. Considerar a ordem final das regras e DESIGN-HANDOFF.md, sobre F01. Dados persistidos por titular, estados verdadeiros e chat real substituem armazenamento local, simulação e dados demonstrativos do protótipo.

Comparar em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080 e transições 767/768px e 1024/1025px. Registrar resultado/evidência por CT, defeitos e reteste dos cenários afetados.

### CT-001 — Entrada e acesso financeiro

Verificação: Abrir a Visão geral pela navegação e por referência direta como A, visitante e conta pendente; repetir após alteração de e-mail que retire confirmação.

Resultado esperado: Titular confirmado acessa seu dashboard real; visitante e conta pendente não consultam finanças. As funções não financeiras permanecem disponíveis conforme F02 e nenhuma referência amplia acesso.

Origem no requisito: Atores e permissões; R1; CA09.

### CT-002 — Saldo acumulado próprio

Verificação: Com a base, consultar saldo e comparar com receitas menos despesas de todo o histórico. Incluir registros excluídos e de B para conferir que ficam fora.

Resultado esperado: A vê R$ 1.085,00; excluídos e dados alheios não entram. Não existe saldo inicial separado ou dado demonstrativo.

Origem no requisito: R1, R2; CA01, CA10.

### CT-003 — Saldo zero e negativo

Verificação: Usar conta sem registros e, na base A, acrescentar por F04 uma despesa de R$ 1.500,00.

Resultado esperado: Sem registros, saldo real R$ 0,00. A despesa leva o saldo da base a -R$ 415,00, com sinal/identificação legíveis, sem limitar a zero. Cancelamento/falha de cadastro não aplica o efeito.

Origem no requisito: R2, R8, R9; CA01, CA06, CA07.

### CT-004 — Mês corrente e data financeira

Verificação: Abrir o dashboard e selecionar novembro, outubro e setembro da base. Usar registros criados/editados em mês diferente da sua data financeira. Neste cenário adicional, preparar receita de R$ 300,00 em 05/11/2025 e alternar novembro de 2025 e 2026 para conferir que o ano também restringe o recorte; repor a base depois.

Resultado esperado: Inicializar em mês/ano correntes de America/Sao_Paulo. Somas e contagens são separadas por tipo e data financeira, não por criação/edição; novembro de 2026 tem R$ 200,20/1 receita e R$ 75,15/2 despesas, outubro de 2026 R$ 0,00/0 e R$ 40,15/2. No cenário adicional, novembro de 2025 tem somente R$ 300,00/1 receita e R$ 0,00/0 despesa, sem misturar o mesmo mês de outro ano.

Origem no requisito: R3, R5, R9; CA02, CA10.

### CT-005 — Troca de período e independência de filtros

Verificação: Trocar mês/ano no dashboard após aplicar descrição/tipo/categoria/mês no histórico F04. Conferir saldo e recentes antes/depois e testar relógio próximo à virada de dia/mês em São Paulo.

Resultado esperado: Apenas totais, contagens, comparação e resultado mensal mudam com o seletor. Saldo/recentes continuam sobre todo o histórico próprio, sem herdar filtros F04 ou fuso UTC. Mês sem registros não cria nem prevê transações.

Origem no requisito: R2, R5, R6; CA01, CA02, CA04, CA10.

### CT-006 — Comparação e resultado mensal

Verificação: Conferir base de novembro/outubro/setembro, mês com somente despesas, mês com receitas/despesas iguais e mês vazio.

Resultado esperado: Comparação usa os mesmos totais dos cartões e declara o mês; resultado é receita menos despesa: R$ 125,05 em novembro e -R$ 40,15 em outubro. Igualdade, zero e ausência de um tipo mantêm rótulos/valores corretos e apresentação sem engano ou falha visual.

Origem no requisito: R3, R4, R9; CA03, CA10.

### CT-007 — Conta sem dados e mês vazio

Verificação: Comparar conta sem qualquer registro com A em mês vazio.

Resultado esperado: Conta vazia mostra saldo/totais reais zero, contagens zero, orientação e ação funcional de primeiro cadastro. Em mês vazio de A, só os dados mensais ficam zero/vazios; saldo e recentes mantêm todo o histórico. Não inventar transações.

Origem no requisito: R2–R6, R9; CA01, CA03, CA07.

### CT-008 — Cinco recentes e ordem estável

Verificação: Com mais de cinco registros em vários meses, selecionar outros meses e conferir empates de data/criação e excluídos.

Resultado esperado: Até cinco registros próprios de todo o histórico, na ordem F04: data financeira decrescente, criação mais recente primeiro na mesma data e desempate estável. Mês escolhido não filtra recentes; registros excluídos e alheios ficam fora.

Origem no requisito: R1, R5, R6; CA04, CA10.

### CT-009 — Detalhes integrais

Verificação: Abrir um recente com descrição/valor extensos no desktop e celular e conferir todos os campos.

Resultado esperado: Reutilizar detalhes F04 próprios com tipo, valor, descrição, categoria e data integrais, inclusive campos resumidos na linha móvel. Sinal e identificação textual distinguem tipo além da cor, sem controles encobertos.

Origem no requisito: R6, R7, R9, R10; CA04, CA11.

### CT-010 — Histórico completo sem filtros anteriores

Verificação: Aplicar em F04 descrição, tipo, categoria e mês restritivos, retornar ao dashboard e usar Ver todas. Usar conjunto maior que cinco e que 50 registros.

Resultado esperado: Abrir F04 com todos os quatro filtros removidos e acesso a todo o histórico próprio, sem herdar mês do dashboard ou limite de cinco recentes. Reconhecer o conjunto completo pela contagem/paginação fornecidas por F04.

Origem no requisito: R5, R7; CA05.

### CT-011 — Cadastro pela Visão geral

Verificação: Acionar Nova transação e salvar receita/despesa em mês selecionado e em outro mês, usando o formulário real F04; repetir cancelamento, fechamento e falha.

Resultado esperado: Preservar formulário/regras F04. Após sucesso, atualizar saldo, totais/contagens, comparação/resultado e recentes sem novo login: registro fora do mês altera saldo e seu próprio período, sem alterar indevidamente o recorte atual. Cancelar/fechar/falhar não muda valores nem apresenta sucesso falso.

Origem no requisito: R7–R9; CA06, CA07, CA10.

### CT-012 — Edição e exclusão pelos detalhes

Verificação: Abrir recente, editar valor/tipo/data/categoria por F04 e excluir outro após confirmação. Comparar também cancelar revisão/exclusão e falha de mutação.

Resultado esperado: Ações são as reais de F04. Após sucesso, recalcular saldo, dados mensais, comparação/resultado e recompor recentes com os registros atuais na mesma sessão. Cancelamento/falha preserva valores anteriores; exclusão deixa o conjunto ativo.

Origem no requisito: R1, R6–R9; CA04, CA06, CA10.

### CT-013 — Atualização conforme o mês do registro

Verificação: No mês atual selecionado, criar/editar/excluir registro de mês passado e alterar data de registro entre meses.

Resultado esperado: Saldo geral e recentes refletem o conjunto atual; totais/contagens/comparação do recorte só mudam quando a data financeira pertencer a ele. Ao selecionar o outro mês, seus dados atuais aparecem corretamente, sem novo login.

Origem no requisito: R2–R6, R8; CA01–CA04, CA06.

### CT-014 — Carregamento e falha inicial

Verificação: Introduzir latência e provocar falha ao obter saldo, cartões, comparação ou recentes, depois tentar novamente.

Resultado esperado: Identificar carregamento e indisponibilidade com nova tentativa; não mostrar zero/vazio de conveniência, registro fictício ou sucesso. Após recuperação, mostrar dados reais do titular.

Origem no requisito: R1, R9; CA07, CA08, CA10.

### CT-015 — Falha ao mudar o mês

Verificação: Carregar um mês conhecido, selecionar outro e falhar a leitura; depois restabelecer e tentar novamente.

Resultado esperado: Identificar indisponibilidade do recorte solicitado. Não atribuir valores/contagens/comparação do mês anterior ao mês novo nem substituir falha por zero real. Recuperação apresenta o mês escolhido com seus dados corretos.

Origem no requisito: R3–R5, R9; CA02, CA03, CA08.

### CT-016 — Isolamento e troca de conta

Verificação: Com A/B, comparar todos os indicadores/recentes, acessar referências de detalhes alheios, trocar de conta e tentar visão de terceiros como administração/suporte.

Resultado esperado: Cada uma vê apenas seus dados atuais e ações permitidas. Troca de conta não reutiliza resultados/cache/contexto da anterior; referências ou privilégios não concedem visão financeira de terceiro.

Origem no requisito: Atores e permissões; R1; CA09, CA10.

### CT-017 — Convite funcional ao assistente

Verificação: Reconhecer a área de convite e acioná-la; enviar consulta no chat real F06. Provocar indisponibilidade do serviço e observar o tratamento real do destino.

Resultado esperado: Abrir a conversa própria real, com identidade/composição do design e estados verdadeiros de F06. Não há destino futuro, rótulo simulado, resposta inventada ou promessa de que a integração já funcionou quando falhou.

Origem no requisito: R10; CA12.

### CT-018 — Fidelidade visual e controles

Verificação: Comparar V01 com a Visão geral completa nas nove dimensões/transições do contexto, usando dados/valores extensos e estados de normal, foco, carregamento, vazio, erro e retomada; usar mouse/teclado e lateral recolhida quando disponível.

Resultado esperado: Preservar cabeçalho, seletor, cartões, comparação, lista, ações e convite, hierarquia, superfícies, cores/tipografia/espaços sobre F01. Valores, contagens, sinais, categorias e rótulos permanecem legíveis; detalhes expõem campos resumidos no celular. Manter foco e ações alcançáveis sem sobreposição ou rolagem horizontal, sem textos de armazenamento local/simulação. Comparação, não só captura ou ausência de erro, comprova fidelidade.

Origem no requisito: R9, R10; CA11, CA12.

### CT-019 — Jornada integrada

Verificação: Pela Visão geral, conferir saldo, selecionar mês/ano, comparar resultado, abrir recente/detalhes, cadastrar, editar/excluir, consultar todo o histórico e acessar o assistente. Confrontar os resultados atuais entre os canais.

Resultado esperado: Dashboard conclui seu fluxo com F04/F06 reais disponíveis e dados próprios coerentes sem novo login, inclusive após mutações. A QA não depende do registro por IA F07; essa Feature verificará os efeitos dos registros que introduzir.

Origem no requisito: R1–R10; CA01–CA12.

## Descrições completas

### D01 — [DEV] [WEB] [USUARIO] Dashboard financeiro - Saldo acumulado real

#### Entrega

Apresentar na Visão geral o saldo próprio acumulado, calculado sobre todas as receitas e despesas reais disponíveis do titular, preservando acesso, moeda e estados verdadeiros.

#### Escopo e limites

A Visão geral e sua rota já existem. Integrar o primeiro conteúdo financeiro sobre F01, contando aqui o preparo comum de leitura/atualização, sem criar uma tarefa técnica separada. Os cartões mensais, comparação, recentes e jornadas de continuidade têm entregas próprias; não apresentar valores demonstrativos ou controles futuros para aparentar conclusão.

#### Critérios de aceite

- Titular autenticado com e-mail confirmado abre a Visão geral real; visitante e conta pendente não consultam finanças, inclusive por acesso direto. Administração/suporte não recebem visão financeira de terceiros.
- Calcular saldo pela soma de receitas menos despesas de todo o histórico próprio, sem saldo inicial separado; registros excluídos e de outras contas ficam fora.
- Apresentar BRL com centavos exatos, inclusive zero real e saldo negativo com sinal e identificação compreensível, sem limitar a zero.
- Mês escolhido no dashboard e filtros do histórico não mudam o significado acumulado do saldo. Integrar essa preservação quando o seletor mensal estiver disponível.
- Após criação, edição ou exclusão manual bem-sucedida pelas ações disponíveis, recalcular o saldo na mesma sessão sem novo login, inclusive quando a transação estiver fora do mês selecionado. Cancelamento/falha não altera o saldo.
- Distinguir carregamento, zero real e falha, com indisponibilidade/nova tentativa sem fabricar valores. Troca de conta não reutiliza resultados da anterior.
- Comparar cabeçalho aplicável e cartão #balance com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, nos estados de normal, foco, carregamento, zero, negativo e erro/retomada. Preservar hierarquia, tipografia, espaços e superfícies, valores extensos legíveis e ações/foco alcançáveis, sem sobreposição ou rolagem horizontal da página.
- Não transportar textos de armazenamento local ou simulação para a apresentação financeira.

#### Dependências

O início depende de [[QA] [WEB] [USUARIO] Gestão de transações](https://redmine.remsoft.com.br/issues/1016356), que fornece transações e acesso pessoal sobre F01/F02 verificadas. Publicação em New não comprova implementação. Integrar seletor e ações de cadastro/detalhes ao resultado quando suas entregas estiverem disponíveis, sem reconstruir F04.

#### Referências

[Pai #1016275](https://redmine.remsoft.com.br/issues/1016275); R1/R2/R5/R8–R10 nas parcelas do saldo; CA01/CA06–CA11; CT-001–CT-005, CT-007, CT-011–CT-016, CT-018/CT-019.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #overview, .stats, .stat-card.balance e #balance. A base visual pertence a F01; saldo próprio real substitui dados locais do protótipo.

Intenção estável de criação: `docs/harness/features/1016275-dashboard-financeiro/slices/slices.md#D01-r001`.

### D02 — [DEV] [WEB] [USUARIO] Dashboard financeiro - Totais e contagens mensais

#### Entrega

Permitir selecionar mês/ano na Visão geral e reconhecer os totais e quantidades de receitas e despesas desse período, calculados pela data financeira dos registros próprios.

#### Escopo e limites

Totais, contagens e seletor formam a mesma consulta mensal: o recorte precisa estar identificado para que os números tenham sentido. Comparação e resultado visual mensal são outra entrega. Não reconstruir classificação, cadastro ou regras financeiras de F04.

#### Critérios de aceite

- Inicializar no mês corrente em America/Sao_Paulo e identificar claramente mês/ano. Referências próximas da virada de dia/mês seguem esse fuso.
- Somar separadamente receitas/despesas e contar seus registros pelo mês/ano da data financeira, sem usar criação/edição como substituto. Considerar só dados atuais próprios disponíveis, excluindo alheios e excluídos.
- Apresentar totais em reais (BRL) com centavos exatos e contagens como quantidade de registros, sem confundir as duas informações.
- Mudar mês/ano atualiza totais e contagens desse recorte; não mudar o significado de saldo geral ou recentes acumulados nem herdar filtros de descrição/tipo/categoria/mês de F04.
- Sem registros no mês, apresentar totais/contagens zero reais; um tipo ausente não elimina os valores do outro. Selecionar mês vazio não cria nem prevê movimentações.
- Após criação, edição ou exclusão manual bem-sucedida, atualizar os cartões na mesma sessão sem novo login. Registro fora do recorte não altera seus valores; ao selecionar o mês daquele registro, mostrar o resultado atual. Cancelamento/falha mantém os dados anteriores.
- Identificar carregamento e falha com nova tentativa. Se o mês novo falhar, não apresentar números do mês anterior como se fossem do recorte solicitado nem substituir indisponibilidade por zero.
- Restringir a titular confirmado, inclusive em acesso direto/troca de conta; visitantes, pendentes e privilégios administrativos/de suporte não ampliam acesso financeiro.
- Comparar #month-wrap/#month, #income/#expense e suas contagens com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, incluindo zero, dados extensos, carregamento e erro/retomada. Manter rótulos, contagens, foco e teclado legíveis/alcançáveis, sem sobreposição ou rolagem horizontal.

#### Dependências

O início depende de [[QA] [WEB] [USUARIO] Gestão de transações](https://redmine.remsoft.com.br/issues/1016356). A rota da Visão geral já existe, portanto não criar bloqueio de início por compartilhar a tela com Saldo acumulado real. Para concluir a composição/integração, manter saldo e recentes acumulados quando esses consumidores estiverem disponíveis. O preparo comum da leitura/atualização fica no primeiro consumidor, sem duplicação.

#### Referências

[Pai #1016275](https://redmine.remsoft.com.br/issues/1016275); R1/R3/R5/R8–R10; CA02/CA06–CA11; CT-001/CT-004/CT-005/CT-007, CT-011–CT-016, CT-018/CT-019.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #month-wrap, #month, #income, #expense, #income-count e #expense-count.

Intenção estável de criação: `docs/harness/features/1016275-dashboard-financeiro/slices/slices.md#D02-r001`.

### D03 — [DEV] [WEB] [USUARIO] Dashboard financeiro - Comparação e resultado mensal

#### Entrega

Permitir comparar visualmente receitas e despesas do mês selecionado e reconhecer o resultado mensal, usando exatamente os mesmos totais apresentados nos cartões.

#### Escopo e limites

Comparar o resultado tem aceite próprio depois da consulta de totais/contagens. Consumir o recorte e os valores já entregues, sem manter outro significado de mês ou cálculo financeiro divergente.

#### Critérios de aceite

- Apresentar comparação de receitas/despesas e resultado igual a receitas menos despesas do mesmo mês selecionado, identificando o período e os valores em reais (BRL) com centavos exatos.
- Preservar os mesmos totais dos cartões, rótulos e valores legíveis, inclusive receitas/despesas iguais, zero e mês com somente um tipo.
- Resultado negativo é válido e aparece com sinal/identificação compreensível. Mês sem registros tem orientação vazia e valores reais coerentes, sem comparação enganosa ou dados demonstrativos.
- Troca de mês e criação/edição/exclusão manual bem-sucedida atualizam comparação/resultado com o recorte correto sem novo login; cancelar/falhar não modifica números.
- Carregamento/falha não vira comparação vazia ou zero fictício. Se o período novo falhar, identificar indisponibilidade sem atribuir ao novo mês os valores anteriores.
- Consumir exclusivamente dados próprios atuais, respeitando autorização e exclusões da consulta mensal.
- Comparar .overview-grid, #graph, #chart-month e #month-result com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, nos estados positivo/negativo/igual/zero/vazio/carregamento/erro. Preservar composição, rótulos e valores extensos legíveis, sem sobreposição ou rolagem horizontal da página.

#### Dependências

O início depende de Dashboard financeiro - Totais e contagens mensais, que fornece recorte e números funcionais. O convite ao assistente ocupa outra superfície e integra a composição final quando disponível, sem reconstruir seus dados ou comportamento.

#### Referências

[Pai #1016275](https://redmine.remsoft.com.br/issues/1016275); R1/R3–R5/R8–R10; CA02/CA03/CA06–CA08/CA10/CA11; CT-004–CT-007, CT-011–CT-016, CT-018/CT-019.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: .overview-grid, #graph, #chart-month e #month-result; balanço simples aprovado em Q2/Q7.

Intenção estável de criação: `docs/harness/features/1016275-dashboard-financeiro/slices/slices.md#D03-r001`.

### D04 — [DEV] [WEB] [USUARIO] Dashboard financeiro - Recentes e detalhes reais

#### Entrega

Apresentar até cinco movimentações recentes de todo o histórico próprio na Visão geral, permitindo abrir seus dados integrais pelos detalhes reais de F04.

#### Escopo e limites

Detalhes completam a leitura dos campos resumidos/ocultos na linha móvel e por isso acompanham a consulta de recentes. Editar/excluir são operações já fornecidas por F04: preservar essas ações e integrar seus efeitos, sem reconstruir manutenção. A transição para todo o histórico tem entrega própria e não é absorvida pela conferência dos cinco registros.

#### Critérios de aceite

- Mostrar até cinco registros atuais próprios de todo o histórico, excluindo removidos e alheios, sem filtrar pelo mês escolhido no dashboard ou por filtros anteriores F04.
- Ordenar por data financeira decrescente, criação mais recente primeiro na mesma data e desempate estável de F04. Com menos de cinco, não completar com exemplos.
- Exibir dados aplicáveis, BRL/centavos, sinal e identificação textual do tipo além de cor; abrir detalhes integrais de tipo, valor, descrição, categoria e data, inclusive no celular.
- Preservar edição/exclusão e confirmações/cancelamentos reais dos detalhes F04. Depois do sucesso, recompor recentes e integrar a atualização dos indicadores disponíveis sem novo login; cancelar/falhar não muda o conjunto financeiro.
- Criar registro pelas ações disponíveis recompõe recentes segundo a ordem real; a data do registro, não o mês selecionado, define se entra nos cinco.
- Ausência real é distinguida de carregamento/erro de leitura, com orientação e nova tentativa sem registros fictícios. Referência indisponível ou alheia não revela dados de terceiro.
- Manter acesso apenas ao titular confirmado, inclusive por referência direta e troca de conta.
- Comparar #recent e detalhes F04 com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, usando textos/valores longos e estados normal/foco/vazio/processamento/erro. Campos resumidos continuam acessíveis nos detalhes; ações, foco e teclado permanecem alcançáveis sem sobreposição ou rolagem horizontal.

#### Dependências

O início depende de [[QA] [WEB] [USUARIO] Gestão de transações](https://redmine.remsoft.com.br/issues/1016356), fornecedora de leitura, ordem, detalhes e manutenção. A Visão geral já existe e não exige bloqueio de início por outro cartão. Para concluir, integrar os efeitos da manutenção aos consumidores Saldo acumulado real, Totais e contagens mensais e Comparação e resultado mensal, sem duplicar o trabalho de seus cálculos.

#### Referências

[Pai #1016275](https://redmine.remsoft.com.br/issues/1016275); R1/R5–R10; CA04/CA06–CA11; CT-001/CT-005/CT-007–CT-009, CT-011–CT-014/CT-016/CT-018/CT-019.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #recent, linhas de movimentação e #detail-dialog da referência; a leitura integral mobile justifica os detalhes na mesma entrega.

Intenção estável de criação: `docs/harness/features/1016275-dashboard-financeiro/slices/slices.md#D04-r001`.

### D05 — [DEV] [WEB] [USUARIO] Dashboard financeiro - Cadastro pela Visão geral

#### Entrega

Permitir iniciar uma transação manual na Visão geral pelo formulário real de F04 e reconhecer seu efeito financeiro nos componentes do dashboard após salvamento bem-sucedido.

#### Escopo e limites

A entrega é a jornada de cadastro iniciada neste contexto, com resposta observável após salvar. Não criar outro cadastro, validação ou fluxo financeiro. Cada indicador continua responsável por recalcular seu próprio resultado.

#### Critérios de aceite

- Nova transação e a orientação de primeiro registro abrem o cadastro real F04, preservando campos, regras e titularidade, sem valores demonstrativos.
- Depois do sucesso, atualizar saldo, totais/contagens, comparação/resultado e recentes disponíveis na mesma sessão, sem exigir novo login.
- Registro no mês escolhido altera seus dados mensais; registro de outro mês altera saldo e seu próprio período sem contaminar o recorte atual, respeitando a ordem de recentes.
- Cancelar, fechar sem salvar ou falhar não grava, altera números ou anuncia sucesso falso. Usar os estados verdadeiros do formulário F04.
- Exigir titular autenticado/confirmado e preservar isolamento, inclusive em referências diretas/troca de conta.
- Comparar #new-transaction, vazio inicial e formulário com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, incluindo processamento/validação/falha/sucesso/cancelamento. Manter dados, foco/teclado e ações legíveis/alcançáveis sem controles encobertos ou rolagem horizontal.

#### Dependências

O início depende de [[QA] [WEB] [USUARIO] Gestão de transações](https://redmine.remsoft.com.br/issues/1016356), que fornece o cadastro. Para concluir a resposta completa no dashboard, integrar Saldo acumulado real, Totais e contagens mensais, Comparação e resultado mensal e Recentes e detalhes reais. Essas integrações não criam bloqueio artificial para iniciar a jornada sobre a rota já existente.

#### Referências

[Pai #1016275](https://redmine.remsoft.com.br/issues/1016275); R1/R7–R10; CA06/CA07/CA09–CA11; CT-001/CT-003/CT-007/CT-011–CT-013/CT-016/CT-018/CT-019.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #new-transaction, #transaction-dialog e orientações de primeiro registro; regras e formulário permanecem F04.

Intenção estável de criação: `docs/harness/features/1016275-dashboard-financeiro/slices/slices.md#D05-r001`.

### D06 — [DEV] [WEB] [USUARIO] Dashboard financeiro - Histórico completo a partir da Visão geral

#### Entrega

Permitir sair da Visão geral para consultar todo o histórico próprio, mesmo depois de ter usado filtros restritivos em F04.

#### Escopo e limites

O resultado é a consulta completa no destino real, com recortes anteriores removidos; não se limita a desenhar ou ligar o controle Ver todas. Não alterar a pesquisa ou paginação fornecidas por F04.

#### Critérios de aceite

- Acionar Ver todas abre o histórico real F04 com descrição, tipo, categoria e mês anteriores removidos.
- O destino consulta todo o histórico próprio, sem limitar ao mês escolhido no dashboard ou aos cinco recentes; conjuntos extensos continuam acessíveis pela contagem/paginação existentes.
- Preservar acesso do titular confirmado e não reutilizar dados/filtros de outra conta; não criar tela demonstrativa ou destino futuro.
- Comparar o controle e sua posição no painel de recentes com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, mantendo rótulo, foco/teclado, legibilidade e ação alcançável sem sobreposição.

#### Dependências

O início depende de [[QA] [WEB] [USUARIO] Gestão de transações](https://redmine.remsoft.com.br/issues/1016356). Para concluir a composição da origem, integrar Recentes e detalhes reais, que fornece o painel de onde o titular amplia a consulta. Compartilhar o painel não exige aguardar seus dados para iniciar a transição/reset de filtros no destino já disponível.

#### Referências

[Pai #1016275](https://redmine.remsoft.com.br/issues/1016275); R1/R5/R7/R10; CA05/CA09/CA11; CT-001/CT-010/CT-016/CT-018/CT-019.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, ordem final das regras e `DESIGN-HANDOFF.md`. Locador: link Ver todas no painel de últimas movimentações e destino #transactions, adaptado à navegação real F04 com filtros removidos.

Intenção estável de criação: `docs/harness/features/1016275-dashboard-financeiro/slices/slices.md#D06-r001`.

### D07 — [DEV] [WEB] [USUARIO] Dashboard financeiro - Convite para o assistente real

#### Entrega

Apresentar na Visão geral a área de convite ao assistente conforme o design, permitindo abrir a conversa financeira real já entregue por F06.

#### Escopo e limites

A entrega abrange o convite e seu destino funcional. Não implementar chat, memória, IA ou registro por conversa novamente, nem criar promessa de capacidade futura para substituir o destino.

#### Critérios de aceite

- O convite abre o chat real próprio de F06, já disponível, mantendo identidade e composição aprovadas.
- Visitante/conta pendente e referências alheias continuam sujeitos ao acesso financeiro vigente; não ampliar permissões ao navegar.
- Preservar o tratamento real de indisponibilidade do serviço em F06, sem substituí-lo por chat simulado, resposta fictícia ou controle sem destino.
- Retirar rótulos de assistente simulado/armazenamento local; o conteúdo do convite corresponde às capacidades reais disponíveis.
- Comparar .assistant-teaser/#open-chat com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, mantendo composição, textos, hierarquia, foco/teclado e ações legíveis/alcançáveis, sem sobreposição ou rolagem horizontal.

#### Dependências

O início depende de [[QA] [WEB] [USUARIO] Assistente de consulta financeira](https://redmine.remsoft.com.br/issues/1016369), que já consome F04 e a base F01/F02 verificadas. A Visão geral já existe; não bloquear por um cálculo financeiro sem relação com o convite. Para concluir a composição da tela, integrar a superfície de Comparação e resultado mensal conforme V01.

#### Referências

[Pai #1016275](https://redmine.remsoft.com.br/issues/1016275); R1/R10; CA09/CA11/CA12; CT-001/CT-016–CT-019.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: .assistant-teaser e #open-chat; abertura real de F06 substitui a simulação do protótipo. F07 entrega registro por IA separadamente.

Intenção estável de criação: `docs/harness/features/1016275-dashboard-financeiro/slices/slices.md#D07-r001`.

## Publicação conferida

### QA — [QA] [WEB] [USUARIO] Dashboard financeiro

#### Entrega

Verificar o Dashboard financeiro completo pelas jornadas reais, com indicadores próprios atuais, recortes mensais, recentes, cadastro/manutenção/histórico F04 e convite para F06, cobrindo CT-001–CT-019 r001.

#### Escopo e limites

Executar uma única QA da Feature, incluindo preparo de dados/contas, relógio e falhas reversíveis, evidências e reteste focalizado. Reutilizar fornecedores já verificados, sem repetir integralmente suas campanhas ou substituir comparação visual por testes internos. F07 não é condição de encerramento.

#### Critérios de aceite

- Executar CT-001–CT-019 com resultado/evidência por condição, cobrindo R1–R10 e CA01–CA12; pendências/defeitos não executados ficam explícitos.
- Conferir saldo acumulado sobre todo o histórico próprio, incluindo zero/negativo, sem saldo inicial e sem registros excluídos/alheios.
- Conferir mês/ano inicial em America/Sao_Paulo, totais/contagens pela data financeira e independência do saldo/recentes em relação ao seletor/filtros do histórico.
- Conferir comparação e resultado pelos mesmos totais, incluindo igualdade, zero, negativo, apenas um tipo e mês vazio.
- Conferir até cinco recentes na ordem de F04, campos integrais nos detalhes e manutenção real com atualização dos consumidores sem novo login.
- Cadastrar pela Visão geral em mês atual e anterior, comparar sucesso/cancelamento/fechamento/falha e verificar os efeitos em cada componente.
- Abrir Ver todas após filtros restritivos e reconhecer todo o histórico próprio com descrição/tipo/categoria/mês removidos.
- Abrir o chat real pelo convite F06 e conferir seu estado verdadeiro, sem simulação ou destino futuro.
- Provocar falha inicial e ao trocar mês, sem zero/vazio enganoso ou números do recorte anterior atribuídos ao novo.
- Conferir confirmação de e-mail, duas contas, troca de conta e referências diretas sem visão financeira de terceiros.
- Comparar a Visão geral completa e seus estados com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, com dados extensos, foco/teclado, hierarquia e controles alcançáveis, sem sobreposição ou rolagem horizontal da página.

#### Dependências

Executar após Dashboard financeiro - Saldo acumulado real; Totais e contagens mensais; Comparação e resultado mensal; Recentes e detalhes reais; Cadastro pela Visão geral; Histórico completo a partir da Visão geral; e Convite para o assistente real.

F04 e F06 precisam estar implementadas/verificadas, consumindo F01/F02 disponíveis. Não aguardar registro por IA F07 para concluir o dashboard.

#### Referências

[Pai #1016275](https://redmine.remsoft.com.br/issues/1016275); R1–R10, CA01–CA12; CT-001–CT-019 r001; anexo previsto `1016275 - Condições de testes.docx`.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #overview, cartões, #month, #graph/#month-result, #recent, Nova transação, Ver todas e .assistant-teaser/#open-chat.

Intenção estável de criação: `docs/harness/features/1016275-dashboard-financeiro/slices/slices.md#QA-r001`.

### Destino e campos exatos

Oito filhas novas no projeto 65224, versão 20359, pai 1016275. Busca com todos os status retornou zero filhas; nenhuma adoção/externa/Study.

| Campo                                           | D01–D07                                           | QA                                        |
| ----------------------------------------------- | ------------------------------------------------- | ----------------------------------------- |
| subject                                         | Título completo de cada descrição                 | [QA] [WEB] [USUARIO] Dashboard financeiro |
| tracker_id                                      | Task (4)                                          | Deliverable (5)                           |
| status_id / priority_id                         | New (1) / Normal (4)                              | New (1) / Normal (4)                      |
| project_id / fixed_version_id / parent_issue_id | 65224 / 20359 / 1016275                           | 65224 / 20359 / 1016275                   |
| estimated_hours                                 | 2 / 2 / 1.5 / 2 / 1 / 0.5 / 0.5                   | 3.5                                       |
| custom_fields                                   | Sequencing id 2: 23 / 24 / 25 / 26 / 27 / 28 / 29 | Sequencing id 2: 30                       |
| responsável/categoria/datas                     | Não atribuir nem preencher por inferência         | Idem                                      |
| description                                     | Seções completas/identidade estável acima         | Idem, CT-001–CT-019 e arquivo previsto    |

Pai #1016275: atualizar somente Sequencing (id2), vazio→23. Preservar status New, requisito/descrição, versão, prioridade, campos/conteúdo humano e relações. Não publicar comentário adicional.

Dependências sem ID usam os nomes aprovados, sem inserir links adicionais nas descrições remotas sem revisão; IDs definitivos entram no registro/task.md.

### Relações novas

Direção blocks: origem bloqueia o início do destino. Integrações só de conclusão ficam explícitas nas descrições sem aresta artificial.

| Origem                                                                        | Destino                                                                                       | Motivo                                                          |
| ----------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------- | --------------------------------------------------------------- |
| #1016356 — [QA] [WEB] [USUARIO] Gestão de transações                          | D01 — [DEV] [WEB] [USUARIO] Dashboard financeiro - Saldo acumulado real                       | Dados/regras próprios verificados.                              |
| #1016356 — [QA] [WEB] [USUARIO] Gestão de transações                          | D02 — [DEV] [WEB] [USUARIO] Dashboard financeiro - Totais e contagens mensais                 | Mesma fonte real para o recorte.                                |
| D02 — [DEV] [WEB] [USUARIO] Dashboard financeiro - Totais e contagens mensais | D03 — [DEV] [WEB] [USUARIO] Dashboard financeiro - Comparação e resultado mensal              | Mês e totais funcionais a comparar.                             |
| #1016356 — [QA] [WEB] [USUARIO] Gestão de transações                          | D04 — [DEV] [WEB] [USUARIO] Dashboard financeiro - Recentes e detalhes reais                  | Registros, ordem e manutenção disponíveis.                      |
| #1016356 — [QA] [WEB] [USUARIO] Gestão de transações                          | D05 — [DEV] [WEB] [USUARIO] Dashboard financeiro - Cadastro pela Visão geral                  | Cadastro real.                                                  |
| #1016356 — [QA] [WEB] [USUARIO] Gestão de transações                          | D06 — [DEV] [WEB] [USUARIO] Dashboard financeiro - Histórico completo a partir da Visão geral | Histórico e filtros reais.                                      |
| #1016369 — [QA] [WEB] [USUARIO] Assistente de consulta financeira             | D07 — [DEV] [WEB] [USUARIO] Dashboard financeiro - Convite para o assistente real             | Chat funcional verificado.                                      |
| Cada uma de D01–D07, com os títulos acima                                     | QA — [QA] [WEB] [USUARIO] Dashboard financeiro                                                | Sete relações, uma por entrega, antes da verificação integrada. |

Quatorze relações novas F05. O grafo de 28 issues/41 relações foi lido integralmente e é acíclico; o delta também é. Preservar as relações anteriores #882 F01→F05, #883 F04→F05, #899 F06→F05, #900 F05→F07 e todas as demais. Nenhuma remoção ou renumeração alheia.

### Documento QA

Documento r001 `slices/r001/1016275 - Condições de testes.docx`, pai #1016275, contexto e CT-001–CT-019. Arquivo real gerado com Word 16.0/commonmark 2.10.7 já disponíveis e conferido: ZIP/OpenXML válido, 19 condições, texto integral equivalente ao Markdown normalizando somente espaços/marcação dos títulos, 19.033 bytes. A fonte corresponde ao espelho desta prévia; condições não executadas.

Upload/associação pelo MCP concluídos na [QA #1016385](https://redmine.remsoft.com.br/issues/1016385), [anexo #3366](https://redmine.remsoft.com.br/attachments/download/3366/1016275%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx), descrição “Condições de teste r001 — Dashboard financeiro”. Nome, identidade, descrição e 19.033 bytes confirmados; nenhum anexo anterior removido.

## Sequencing F05 e complemento da F07

Leitura completa da versão20359/projeto65224, status *, todos os trackers, offset0/limit100/total28. Campo Sequencing id2. Ocupações válidas1–22: Visual1–8, Acesso9–10, Transações11–16, ConsultasIA17–22; pais espelham o primeiro filho. F05/F07 sem número.

Proposta sem lacunas/reservas fictícias/renumeração:

- F05 D01–D07: **23–29**; QA **30**; pai #1016275 espelha **23**.
- F07 D01–D06: **31–36**; QA **37**; pai #1016277 espelha **31**.

A sequência respeita F05→F07 e a aprovação de antecipar apenas o planejamento da F07. Revalidar versão/grafo/contexto imediatamente antes de publicar; colisão exige conciliar em vez de trocar números autorizados silenciosamente.

### Delta da F07 já aprovada

[Prévia da F07](../../1016277-registro-de-transacoes-por-ia-com-confirmacao/slices/slices.md): seis DEV/QA, descrições, 24,5h e DOCX27CT já aprovados pelo responsável. Não pedir aprovação equivalente desse conteúdo.

Complemento que ainda precisa de decisão:

1. Atribuir D01–D06 a31–36 e QA37, pai31.
2. Trocar no delta planejado o fornecedor provisório #1016275→QA F07 pelo fornecedor específico **[QA] [WEB] [USUARIO] Dashboard financeiro**, desta proposta, com Sequencing30. Não há relação provisória nativa a excluir, pois F07 ainda não foi publicada.
3. Atualizar somente a identificação de fornecedor nos textos D01/D06/QA F07, passando do pai sem filhas ao nome da QA específica, sem mudar capacidade, aceite, escopo ou estimativa. IDs serão associados após criação/conferência, com nomes nas descrições conforme a prévia.
4. Preservar a relação original #900 F05→F07 e as demais. Os outros doze bloqueios preparados da F07 permanecem, totalizando treze.

Publicação conjunta proposta: primeiro F05, depois F07, com campos e relações definidos nas respectivas prévias. Total de oito filhas F05 e sete F07; 14+13 relações novas. A revisão aprova este novo Dashboard e somente esse complemento da F07, reutilizando o consentimento já recebido para o restante.

## Revisão e publicação

O responsável aprovou a F05 integralmente, com 13h, oito filhas, campos, descrições, relações, DOCX e bloco 23–30/pai23, e o complemento F07 31–37/pai31 com fornecedor QA Dashboard financeiro. Aprovações aplicadas e verificadas no remoto, preservando a aprovação funcional anterior da F07.

| Operação autorizada                           | ID conhecido                                                                                                                                                                               | Resultado                                                       | Próximo passo                                                     |
| --------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | --------------------------------------------------------------- | ----------------------------------------------------------------- |
| Criar D01                                     | [#1016378](https://redmine.remsoft.com.br/issues/1016378)                                                                                                                                  | Confirmada: descrição/campos, 2h, Sequencing 23                 | Planejamento/execução na etapa própria, respeitando dependências. |
| Criar D02                                     | [#1016379](https://redmine.remsoft.com.br/issues/1016379)                                                                                                                                  | Confirmada: descrição/campos, 2h, Sequencing 24                 | Planejamento/execução na etapa própria, respeitando dependências. |
| Criar D03                                     | [#1016380](https://redmine.remsoft.com.br/issues/1016380)                                                                                                                                  | Confirmada: descrição/campos, 1,5h, Sequencing 25               | Planejamento/execução na etapa própria, respeitando dependências. |
| Criar D04                                     | [#1016381](https://redmine.remsoft.com.br/issues/1016381)                                                                                                                                  | Confirmada: descrição/campos, 2h, Sequencing 26                 | Planejamento/execução na etapa própria, respeitando dependências. |
| Criar D05                                     | [#1016382](https://redmine.remsoft.com.br/issues/1016382)                                                                                                                                  | Confirmada: descrição/campos, 1h, Sequencing 27                 | Planejamento/execução na etapa própria, respeitando dependências. |
| Criar D06                                     | [#1016383](https://redmine.remsoft.com.br/issues/1016383)                                                                                                                                  | Confirmada: descrição/campos, 0,5h, Sequencing 28               | Planejamento/execução na etapa própria, respeitando dependências. |
| Criar D07                                     | [#1016384](https://redmine.remsoft.com.br/issues/1016384)                                                                                                                                  | Confirmada: descrição/campos, 0,5h, Sequencing 29               | Planejamento/execução na etapa própria, respeitando dependências. |
| Criar QA                                      | [#1016385](https://redmine.remsoft.com.br/issues/1016385)                                                                                                                                  | Confirmada: descrição/campos, 3,5h, Sequencing 30               | Planejamento/execução na etapa própria, respeitando dependências. |
| Numerar F05 23–30/pai23                       | Pai #1016275; filhas #1016378–#1016385                                                                                                                                                     | Bloco integral e âncora confirmados; sem renumerar terceiros    | Sem pendência de publicação.                                      |
| Criar quatorze relações                       | Relações #926–#939; fornecedores #1016356/#1016369                                                                                                                                         | Confirmadas pelos endpoints                                     | Sem pendência de publicação.                                      |
| Anexar DOCX F05                               | [QA #1016385](https://redmine.remsoft.com.br/issues/1016385), [anexo #3366](https://redmine.remsoft.com.br/attachments/download/3366/1016275%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx) | Conferido, 19.033 bytes e 19 CT equivalentes à fonte            | Execução futura pela QA.                                          |
| Completar F07 31–37/pai31 e fornecedor QA F05 | Pai #1016277; filhas #1016386–#1016392; QA F05 #1016385                                                                                                                                    | Complemento aplicado e conferido; conteúdo funcional preservado | Sem pendência de publicação.                                      |
| Materializar task.md                          | Oito arquivos por ID listados abaixo                                                                                                                                                       | Concluída após conferência integral remota                      | Etapas próprias de planejamento/execução.                         |

## Resultado consolidado e pendências

Publicado e conferido: sete DEV #1016378–#1016384 (9,5h) e QA #1016385 (3,5h), total 13h, todas New. Bloco 23–30/pai23, relações #926–#939 e anexo #3366 confirmados. Na publicação conjunta, 15 filhas/27 relações novas, 41 relações anteriores preservadas e grafo final de 43 issues/68 relações sem ciclos; descrições e campos coincidem com as prévias aprovadas.

Sem pendência de publicação. As seis Features do MVP têm slicing publicado: 37 filhas em Sequencing 1–37, estimativa total 90,5h (69,5h DEV + 21h QA). Isso não comprova implementação ou execução de QA. Próxima etapa é planejar/executar as DEV na ordem das dependências, com fornecedores ainda New.

| Ref. | Issue confirmada                                          | Arquivo materializado                                                              |
| ---- | --------------------------------------------------------- | ---------------------------------------------------------------------------------- |
| D01  | [#1016378](https://redmine.remsoft.com.br/issues/1016378) | [task.md](../tasks/dev-1016378-saldo-acumulado-real/task.md)                       |
| D02  | [#1016379](https://redmine.remsoft.com.br/issues/1016379) | [task.md](../tasks/dev-1016379-totais-e-contagens-mensais/task.md)                 |
| D03  | [#1016380](https://redmine.remsoft.com.br/issues/1016380) | [task.md](../tasks/dev-1016380-comparacao-e-resultado-mensal/task.md)              |
| D04  | [#1016381](https://redmine.remsoft.com.br/issues/1016381) | [task.md](../tasks/dev-1016381-recentes-e-detalhes-reais/task.md)                  |
| D05  | [#1016382](https://redmine.remsoft.com.br/issues/1016382) | [task.md](../tasks/dev-1016382-cadastro-pela-visao-geral/task.md)                  |
| D06  | [#1016383](https://redmine.remsoft.com.br/issues/1016383) | [task.md](../tasks/dev-1016383-historico-completo-a-partir-da-visao-geral/task.md) |
| D07  | [#1016384](https://redmine.remsoft.com.br/issues/1016384) | [task.md](../tasks/dev-1016384-convite-para-o-assistente-real/task.md)             |
| QA   | [#1016385](https://redmine.remsoft.com.br/issues/1016385) | [task.md](../tasks/qa-1016385-dashboard-financeiro/task.md)                        |
