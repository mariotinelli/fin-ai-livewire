# Dashboard financeiro

## Identidade e situação

- Item F05 do [catálogo aprovado](../../scopes/2026-11-13-finai-mvp/scope.md).
- Situação: requisito completo e publicação aprovados pelo responsável; Feature #1016275 publicada e relida, com referência definitiva e duas relações conferidas. Não implementada.
- Destino: projeto FinAi (65224), versão Livewire (20359).
- Referência estável: `docs/harness/.runs/2026-11-13-finai-mvp/f05-dashboard/feature.md`.

## Objetivo

Apresentar a situação financeira do titular com saldo geral, receitas e despesas do mês selecionado, balanço mensal e últimas movimentações, calculados a partir das transações reais persistidas.

## Resultado esperado

O titular reconhece seu saldo acumulado e o resultado de um mês, consulta as cinco movimentações mais recentes e pode iniciar um cadastro ou acessar o histórico completo. Alterações financeiras bem-sucedidas são refletidas sem exigir novo login. A ausência de registros e a indisponibilidade dos dados têm apresentações distintas.

## Atores e permissões

- Titular autenticado e com e-mail confirmado: consulta apenas sua situação financeira e acessa os próprios registros.
- Visitantes e contas com e-mail pendente não acessam o dashboard financeiro, conforme F02.
- Não há visão consolidada das finanças de terceiros para administração ou suporte.

## Histórias de usuário

1. Como titular, quero ver meu saldo geral para conhecer o resultado acumulado das movimentações registradas.
2. Como titular, quero selecionar um mês e comparar receitas e despesas para entender seu resultado.
3. Como titular, quero consultar minhas últimas movimentações e abrir seus detalhes para conferir os registros.
4. Como titular, quero iniciar um registro ou abrir o histórico completo a partir do dashboard para continuar organizando minhas finanças.

## Fluxo principal

1. Acessar Visão geral com as condições de F02 atendidas. Carregar os dados reais do titular e selecionar inicialmente o mês corrente, conforme America/Sao_Paulo definido em F04.
2. Apresentar saldo geral calculado sobre todo o histórico, total de receitas e total de despesas do mês selecionado e as contagens correspondentes de receitas/despesas desse mês.
3. Apresentar o balanço visual simples: comparação entre receitas e despesas do mês e resultado igual a receitas menos despesas.
4. Apresentar até cinco últimas movimentações de todo o histórico, na mesma ordem definida por F04, com acesso aos detalhes próprios.
5. Ao trocar o mês, atualizar receitas, despesas, contagens, comparação e resultado mensal. Manter saldo geral e últimas movimentações considerando todo o histórico.
6. Nova transação abre o cadastro de F04. Após salvar, atualizar as informações do dashboard, respeitando a data do registro e o mês selecionado.
7. Ver todas abre o histórico de F04 consultando todo o histórico, sem manter filtros anteriores que impeçam essa visão completa.

## Fluxos alternativos e exceções

- Sem qualquer transação, apresentar saldo e totais reais iguais a R$ 0,00, contagens zero, orientações de primeiro registro e ação de cadastro. Não inserir dados demonstrativos.
- Com registros em outros meses, mas nenhum no mês selecionado, apresentar os indicadores mensais zerados e comparação vazia; saldo geral e recentes continuam mostrando o histórico existente.
- Um resultado negativo é válido, tanto para saldo geral quanto para resultado mensal. Apresentá-lo com sinal e distinção visual adequada, sem esconder ou limitar artificialmente o valor a zero.
- Meses sem receitas ou sem despesas apresentam o total e a contagem zero para o respectivo tipo, mantendo os dados reais do outro tipo.
- Durante o carregamento, identificar o estado de processamento. Falha de consulta não é apresentada como saldo zero ou ausência de transações; informar indisponibilidade e oferecer nova tentativa.
- Se o mês solicitado não puder ser carregado, não exibir valores do mês anterior como se correspondessem ao novo recorte. Identificar a indisponibilidade do recorte e permitir nova tentativa.
- Edição ou exclusão iniciada nos detalhes usa os fluxos e confirmações de F04. Depois do sucesso, atualizar valores e recentes de acordo com o conjunto persistido; cancelar ou falhar não altera os números.
- A área de convite ao assistente segue o design. A ação de abrir o chat é integrada quando F06 entregar o destino real, sem antecipar chat simulado, respostas ou links sem destino funcional.

## Regras de negócio

**R1 — Dados próprios e reais.** Todos os cálculos e listas utilizam exclusivamente as transações persistidas e disponíveis do titular autenticado. Registros excluídos não contribuem para nenhum indicador nem lista. Respeitar a confirmação de e-mail e a separação de contas de F02.

**R2 — Saldo geral.** Somar todas as receitas e subtrair todas as despesas de todo o histórico, independentemente do mês selecionado. O ponto de partida sem registros é zero; não existe um campo de saldo inicial separado nesta entrega.

**R3 — Totais e contagens mensais.** Somar separadamente os valores e contar separadamente os registros de receita e despesa cuja data financeira pertence ao mês e ano selecionados. Usar a data da movimentação, não a data em que o registro foi criado ou editado.

**R4 — Resultado e comparação do mês.** O resultado mensal é total de receitas menos total de despesas do mesmo mês. A comparação visual usa esses mesmos totais, com rótulos e valores legíveis. Meses sem registros apresentam orientação vazia; valores iguais ou zero não provocam comparação enganosa ou falha visual.

**R5 — Período.** Inicializar o dashboard no mês corrente em America/Sao_Paulo. O seletor identifica mês e ano e atualiza apenas os dados mensais; nenhum filtro do histórico de transações modifica o significado do saldo geral ou das últimas movimentações. Selecionar um mês sem registros não cria nem prevê movimentações.

**R6 — Recentes.** Mostrar até cinco transações próprias de todo o histórico, da data financeira mais recente para a mais antiga, com a mesma ordem de desempate de F04. Não filtrar a lista pelo mês selecionado no dashboard. Exibir os dados aplicáveis do registro e permitir consultar detalhes com todos os campos, conforme F04.

**R7 — Ações de continuidade.** Nova transação usa o formulário e as regras de F04, sem criar outro fluxo de cadastro. Ver todas abre todo o histórico, removendo filtros anteriores de descrição, tipo, categoria e mês para cumprir o destino aprovado. Detalhes, edição e exclusão reutilizam as ações da gestão de transações.

**R8 — Atualização.** Após criação, edição ou exclusão bem-sucedida realizada a partir da interface disponível, recalcular os indicadores e a lista exibidos na mesma sessão, sem exigir novo login. Uma transação passada altera seu respectivo mês e o saldo geral; não altera indevidamente os totais do mês selecionado se estiver fora dele. Quando F07 estiver disponível, registros confirmados pela IA seguem a mesma regra.

**R9 — Formatação e estados.** Apresentar moeda em reais e centavos conforme F04, valores negativos com sinal e identificação textual dos tipos além de cor. Contagens correspondem a registros, não a somas de valores. Distinguir zero real, carregamento, ausência de registros e erro de consulta.

**R10 — Identidade visual.** Seguir o design fornecido para a Visão geral: cabeçalho, seletor de mês, ação de cadastro, cartões de saldo/receitas/despesas, balanço simples, área de convite ao assistente e últimas movimentações, usando a base responsiva de F01. Mensagens de armazenamento local ou assistente simulado não são transportadas para o produto. A integração funcional do convite ao chat pertence a F06 e não impede demonstrar os indicadores de F05.

## Dados percebidos pelo usuário

Mês e ano de referência; saldo geral; totais e contagens de receitas/despesas mensais; comparação visual e resultado do mês; até cinco transações recentes com seus dados, sinais e categorias; estados de carregamento, vazio e erro; ações de cadastro, detalhes e histórico completo.

## Critérios de aceite

**CA01 — Saldo acumulado.** Com receitas e despesas próprias distribuídas por vários meses, apresentar a diferença de todo o histórico. Trocar o mês não altera esse saldo; registros excluídos e de outras contas não entram no cálculo. Sem registros, o saldo é R$ 0,00, sem saldo inicial separado.

**CA02 — Recorte mensal.** Ao abrir o dashboard, selecionar o mês corrente em America/Sao_Paulo. Selecionar outro mês/ano atualiza totais e contagens usando a data financeira de cada registro, inclusive quando criado ou editado em outra data. Indicar claramente o recorte selecionado.

**CA03 — Balanço.** Comparação e resultado mensal correspondem aos mesmos totais dos cartões. Conferir resultado positivo, negativo, zero, receita sem despesa e despesa sem receita. A comparação preserva rótulos e valores verdadeiros também quando os totais são iguais ou zero.

**CA04 — Recentes.** Com mais de cinco movimentações em vários meses, apresentar somente as cinco mais recentes de todo o histórico, na ordem de F04, independentemente do mês selecionado. Abrir detalhes mostra os dados completos do registro próprio.

**CA05 — Histórico completo.** Acionar Ver todas abre F04 sem filtros anteriores de mês, tipo, categoria ou descrição e permite consultar todo o histórico do titular. Não limitar a consulta aos cinco recentes ou ao mês do dashboard.

**CA06 — Cadastro e manutenção.** Criar por Nova transação usando F04; após sucesso, o dashboard reflete o registro. Editar e excluir pelos detalhes disponíveis também atualiza indicadores e recentes. Movimentações fora do mês selecionado alteram o saldo geral, sem afetar indevidamente os totais mensais. Cancelamento ou falha não altera valores.

**CA07 — Sem dados.** Conferir conta sem transações e mês vazio de conta com histórico. O primeiro caso tem indicadores zerados e orientação para primeiro registro; no segundo, apenas os dados mensais ficam zerados, mantendo saldo e recentes do histórico existente. Nenhum estado usa dados demonstrativos.

**CA08 — Falhas.** Durante a consulta, reconhecer carregamento. Provocar falha ao obter os indicadores ou ao trocar mês: apresentar indisponibilidade e nova tentativa, sem substituir por zeros ou atribuir números de outro período ao recorte atual. Restabelecida a consulta, apresentar os dados reais.

**CA09 — Acesso pessoal.** Visitante e conta com e-mail pendente não acessam o dashboard financeiro. Com duas contas, cada uma vê seus próprios totais, contagens e recentes; referências diretas e troca de conta não revelam dados alheios.

**CA10 — Dados registrados pela IA.** Quando F07 estiver disponível, confirmar uma transação pela IA e conferir seu efeito real nos indicadores e recentes. Mensagem ou proposta ainda não confirmada não altera o dashboard.

**CA11 — Aceite visual.** Comparar a Visão geral e seus estados aplicáveis com o design fornecido nas nove dimensões de F01. Preservar composição, hierarquia, cartões, comparação, lista, botões e seletor, com dados e valores extensos legíveis e controles acessíveis. No celular, os detalhes mantêm acesso aos campos resumidos na lista.

**CA12 — Convite ao assistente.** Preservar a composição visual do convite sem identificar a IA como simulada nem criar destino fictício. A ação funcional é integrada por F06; quando disponível, abre o chat real. A aceitação dos indicadores de F05 não requer antecipar o assistente.

## Dependências

- F01 — [#1016270](https://redmine.remsoft.com.br/issues/1016270): identidade, estrutura e responsividade.
- F04 — [#1016274](https://redmine.remsoft.com.br/issues/1016274): transações persistidas, ordem de consulta e ações de manutenção, consumindo acesso F02 e categorias F03.
- F06 integra a ação de abrir o assistente; F07 permite conferir o reflexo dos registros por IA. Esses critérios integrados acompanham as entregas consumidoras, sem criar dependência circular ou antecipar sua implementação.

## Designs e evidências

O design fornecido é a referência da Visão geral. O responsável incluiu seletor de mês e balanço simples em Q2 e confirmou em Q7 os cálculos, recortes, cinco recentes e destino de Ver todas. A aparência segue F01; referência de aceite visual: CA11 e CA12.

## Dentro do escopo

Saldo acumulado, totais e contagens mensais, comparação e resultado do mês, seletor de mês/ano, cinco movimentações recentes de todo o histórico, acesso aos detalhes e histórico completo, cadastro por F04 e atualização após alterações persistidas. Estados de carregamento, vazio, erro e integração visual do convite ao assistente.

## Fora do escopo

Saldo inicial separado, valores previstos, novos cálculos bancários, metas, orçamento, relatórios avançados, exportação e consolidação entre titulares. Chat e registro por IA são entregues em F06/F07; não criar versões simuladas dessas capacidades nesta Feature.

## Decisões e revisão

- Q7 resolvida: o responsável respondeu “pode ser” ao saldo geral de todo o histórico, sem saldo inicial; totais e balanço no mês selecionado; cinco recentes de todo o histórico; Ver todas abrindo histórico completo.
- Q2 já incluiu o seletor de mês, balanço simples e demais controles do design; F04 definiu BRL e referência temporal America/Sao_Paulo.
- Este documento consolida as decisões e os estados propostos para a revisão integral. A confirmação de Q7 não equivale à aprovação automática da publicação.
- Preferência editorial respeitada: design mencionado como fornecido, sem sua origem pessoal.
- O responsável aprovou o requisito completo e a publicação apresentada respondendo “aprovado” nesta conversa, incluindo materialização definitiva e as relações F01/F04 bloqueiam F05.

## Publicação proposta

- Projeto FinAi (65224), versão Livewire (20359), selecionada pelo responsável.
- Criar Feature (tracker 2), título **[WEB] [USUARIO] Dashboard financeiro**, status inicial New (1), sem categoria, pai, responsável, datas, estimativa ou Sequencing; prioridade padrão do servidor.
- Descrição integral: seções de **Objetivo** até **Fora do escopo**, dentro de `<!-- project-flow:start -->` e `<!-- project-flow:end -->`, com a referência estável identificada no início.
- Após ID confirmado, materializar em `docs/harness/features/<ID>-dashboard-financeiro/feature.md`, corrigir referências relativas e acrescentar o caminho definitivo à descrição remota, preservando a referência estável inicial.
- Relações propostas: F01 #1016270 **bloqueia** a nova F05 pela base visual; F04 #1016274 **bloqueia** a nova F05 pelos dados e ações financeiras. Não criar tarefas DEV/QA nem relações com demandas da Sprint 1.
- Similaridade: a consulta na versão Livewire encontrou apenas F01–F04. Na Sprint 1 existe #1016106 — Dashboard financeiro, de outro catálogo, que permanece preservado; não adotar nem mover seu requisito ou filhas. Propõe-se publicação própria na versão escolhida.
- Publicação autorizada e confirmada como [Feature #1016275](https://redmine.remsoft.com.br/issues/1016275), com descrição integral e referência definitiva relidas. Projeto FinAi (65224), versão Livewire (20359), tracker Feature e status New conferidos; sem pai, categoria, responsável, datas, estimativa, Sequencing ou filhas. Relações #882 e #883 confirmadas nos dois endpoints de cada vínculo: F01 #1016270 e F04 #1016274 bloqueiam F05 #1016275. Nenhum resultado incerto de publicação.

## Resultado da publicação

| Operação autorizada                           | Identidade                                                      | Resultado                                                                 | Pendência |
| --------------------------------------------- | --------------------------------------------------------------- | ------------------------------------------------------------------------- | --------- |
| Criar F05 com o requisito aprovado            | #1016275, projeto FinAi, versão Livewire                        | Criação e leitura final confirmadas                                       | Nenhuma   |
| Materializar requisito e atualizar referência | `docs/harness/features/1016275-dashboard-financeiro/feature.md` | Documento materializado, fontes preservadas e referência remota conferida | Nenhuma   |
| F01 e F04 bloqueiam F05                       | #1016270 e #1016274 → #1016275, relações #882/#883              | Criadas e relidas nos dois endpoints de cada vínculo                      | Nenhuma   |

## Passagem

Entrada pronta para `project-slices`: este requisito aprovado, pai #1016275 confirmado na versão Livewire e dependências F01/F04 registradas. Design fornecido preservado nas fontes do escopo. Sem slicing, tarefas DEV/QA ou implementação nesta etapa.
