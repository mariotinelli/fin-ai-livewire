# Fatiamento de Gestão de transações

## Identidade e situação

- Pai: [#1016274](https://redmine.remsoft.com.br/issues/1016274), `[WEB] [USUARIO] Gestão de transações`; [requisito aprovado](../feature.md).
- Projeto FinAi (65224); versão Livewire (20359), aberta e vinculada ao pai. Retomada do próximo item indicado no [escopo](../../../scopes/2026-11-13-finai-mvp/scope.md).
- Revisão r001 de 13/11/2026: conjunto aprovado, publicado e integralmente conferido, com estimativas corrigidas pelo responsável.
- Contexto MCP conferido: servidor redmine.remsoft.com.br; usuário mario.tinelli (131789), projeto FinAi (65224), versão aberta Livewire (20359). Antes da publicação, o pai estava New (1), prioridade Normal (4), sem filhas, anexo ou Sequencing. Após publicar, continua New e espelha Sequencing 11; requisito e relações anteriores foram preservados.
- Uma única QA cobre o resultado completo. Publicação não comprova implementação nem execução de condições.

## Evidências e fronteira funcional

O titular conclui cadastro, consulta, detalhes, edição e exclusão pela interface real desta Feature. Categorias pertencem ao primeiro fluxo que permite classificar e conferir registros; F05/F06/F07 possuem o aceite dos seus próprios indicadores, consultas e propostas. Não há dependência futura para concluir a QA manual de F04.

Inspeção estática, sem executar testes ou afirmar conformidade de comportamento ainda inexistente:

| Evidência                                                                                                                        | Conclusão para a proposta                                                                                                                                                                                                                             |
| -------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `routes/customer.php`, `app/Models`, `database/migrations`, `app/Livewire` e testes inspecionados                                | Não há módulo de transações/categorias. A área pessoal atual contém dashboard, perfil e notificações. O módulo é criação, com reuso parcial de mecanismos comuns.                                                                                     |
| `resources/views/dashboard.blade.php`; `app/Support/Navigation/Definitions/BaseSidebarMenu.php::groups`                          | Dashboard atual é boas-vindas Rem Soft; menu básico só tem Dashboard. Não comprova base FinAI implementada ou navegação financeira existente.                                                                                                         |
| `app/Traits/Models/HasInsensitiveSearch.php::applyInsensitiveSearch`; `tests/Feature/Traits/Models/HasInsensitiveSearchTest.php` | Existe mecanismo de trecho com unaccent/ILIKE e escape literal de %, _ e !. D02 integra à consulta própria; testes encontrados não foram executados.                                                                                                  |
| `app/Traits/Components/WithTable.php`; `tests/Unit/Traits/Components/WithTableTest.php`                                          | Filtros, paginação e reset são parcialmente reutilizáveis; defaults 10/id não entregam a ordem/paginação financeira. D01 define consulta e D02 integra recortes.                                                                                      |
| `app/Rules/Traits/MoneyValidations.php::default`; `app/Traits/Components/WithConverters.php::converterStringToInt`               | Default mínimo zero/máximo 9.999.999,99 diverge de R2; conversor arredonda. Não classificar como validação financeira pronta.                                                                                                                         |
| `resources/js/components/money.js::mask`; testes monetários existentes                                                           | Máscara remove separadores e interpreta dígitos como centavos; 35,901 pode virar 359,01. D03/D04 precisam cumprir recusa sem transformação silenciosa, inclusive ao colar.                                                                            |
| `config/app.php`, `config/database.php`, migração inicial de usuários                                                            | Defaults declarados America/Sao_Paulo e pgsql com extensão unaccent; não foi consultada configuração efetiva. Verificar fuso na entrega, sem presumir que o default prove R4.                                                                         |
| Pacotes consultados por Composer                                                                                                 | Laravel 13.40.0, Livewire 4.4.8 e Pest 5.3.5. Nenhuma API nova ou implementação é prescrita neste slicing.                                                                                                                                            |
| V01: ZIP compartilhado, `index.html`, `DESIGN-HANDOFF.md`, `DESIGN-MANIFEST.json`                                                | Fonte lida. #transactions contém filtros/histórico/paginação; #transaction-dialog contém os cinco campos; #detail-dialog permite leitura integral e #delete-dialog contém confirmação. A linha móvel resumida exige os detalhes na primeira consulta. |
| F01 QA #1016288; F02 DEV #1016292 e QA #1016293                                                                                  | Todas New. São fornecedores publicados pendentes, não capacidades disponíveis. F01 já bloqueia F02 por sua QA.                                                                                                                                        |

Foram aplicados `vertical-slicing`, `livewire-development`, `remsoft-ui-components` e `testing-best-practices` na inspeção e seleção da cobertura. Não houve implementação ou alteração de dependências.

## Prévia numerada

| Ref. | Título completo                                                           | Papel | Horas | Sequencing | Bloqueio de início                             |
| ---- | ------------------------------------------------------------------------- | ----- | ----: | ---------: | ---------------------------------------------- |
| D01  | [DEV] [WEB] [USUARIO] Gestão de transações - Histórico por mês e detalhes | DEV   |     3 |         11 | QA F02 #1016293, que consome a QA F01 #1016288 |
| D02  | [DEV] [WEB] [USUARIO] Gestão de transações - Pesquisa e filtros           | DEV   |     2 |         12 | D01                                            |
| D03  | [DEV] [WEB] [USUARIO] Gestão de transações - Cadastro classificado        | DEV   |     2 |         13 | D01                                            |
| D04  | [DEV] [WEB] [USUARIO] Gestão de transações - Edição de transações         | DEV   |     2 |         14 | D01                                            |
| D05  | [DEV] [WEB] [USUARIO] Gestão de transações - Exclusão confirmada          | DEV   |     1 |         15 | D01                                            |
| QA   | [QA] [WEB] [USUARIO] Gestão de transações                                 | QA    |     2 |         16 | D01, D02, D03, D04 e D05                       |

Total aprovado: **10h DEV + 2h QA = 12h**. Estimativas corrigidas pelo responsável na ordem da prévia; todas positivas até seis horas.

Histórico e detalhes ficam juntos porque a leitura completa dos campos resumidos no celular faz parte da resposta necessária da consulta. Pesquisa/filtros, cadastro, edição e exclusão têm objetivos próprios e permanecem separados. Receita/despesa são variantes da mesma interação classificada, sem tarefa separada de preparação técnica.

D01 permite verificar dados de qualquer mês antes do cadastro; assim D03 pode ser conferida sem pesquisa avançada futura. D02, D04 e D05 podem usar dados próprios preparados. D04 não recebe bloqueio artificial por validações compartilhadas com D03; coerência das regras e integração ao recorte são necessárias à conclusão.

## Fundamento das estimativas

Duas avaliações independentes (`slicing_review_delivery` e `slicing_review_reuse`) receberam requisito, fronteiras e evidências sem estimativas candidatas ou acesso ao parecer uma da outra. Ambas questionaram os cortes antes das horas e recomendaram inicialmente 5,5h / 2,5h / 5,5h / 3,5h / 2h / 6h, total de 25h. Esses valores permanecem como histórico dos pareceres, não como horas vigentes ou medição realizada.

O responsável corrigiu explicitamente para **3h / 2h / 2h / 2h / 1h / 2h**, total de **12h**, e aprovou o restante do conjunto e sua publicação. A correção é calibração humana, sem redução de escopo, condições ou critérios. O quadro abaixo registra o esforço identificado na proposta original; o detalhamento temporal original da QA não representa distribuição das novas 2h.

| Entrega e estimativa inicial (histórico) | Esforço dominante e premissa                                                                                                                                                                                                                                                  |
| ---------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| D01 — 5,5h                               | Primeira capacidade financeira: preparo de dados/catálogo necessário à leitura, consulta própria, navegação, mês/todo histórico, ordem, paginação, detalhes e verificações relevantes. O preparo comum é contado aqui uma única vez.                                          |
| D02 — 2,5h                               | Integração da busca literal e filtros ao histórico com reuso parcial de busca/paginação; inclui estados e verificação.                                                                                                                                                        |
| D03 — 5,5h                               | Cadastro novo, classificação, regras rigorosas de dinheiro/data e falhas/envios incertos. Preparo comum das regras do formulário contado aqui uma única vez; mecanismo monetário existente não satisfaz sozinho R2.                                                           |
| D04 — 3,5h                               | Atualização do mesmo registro, integração das regras comuns, indisponibilidade concorrente e saída do recorte, sem reconstruir o cadastro.                                                                                                                                    |
| D05 — 2h                                 | Confirmação, autorização, cancelamento, falhas, persistência da exclusão e recomposição da página.                                                                                                                                                                            |
| QA — 6h                                  | Aproximadamente 1h preparo de dados/controles, 3h jornadas e limites/isolamento/falhas, 1,25h comparação visual agrupando estados nas nove dimensões/transições e 0,75h evidências/reteste focalizado. Cobertura integral CT-001–CT-025, sem percentual automático sobre DEV. |

Premissas: executor familiar ao projeto, ambiente de homologação acessível, uso das ferramentas existentes e dados preparados sem trabalho de infraestrutura novo. Não se presume uso de IA, automação visual pronta ou falhas já configuradas: a preparação dos controles está incluída. Espera por fornecedores não entra nas horas. Reteste amplo ou infraestrutura adicional exige recalibrar antes da publicação, sem remover cobertura nem ultrapassar seis horas silenciosamente.

Calibração humana disponível: Visual 13,5h DEV + 4h QA; Acesso 2h DEV + 1,5h QA. Foram correções do responsável, não tempos realizados. Acesso reutilizava funcionalidades existentes; este módulo é novo, portanto não copiar sua proporção ou valores.

## Cobertura

A alocação distingue a aplicação de uma regra em operações diferentes; não duplica a implementação comum. A QA verifica todos os destinos integrados.

| Regra/critério e parcela                                                                        | Destino único por comportamento                                                                               | Condições                             |
| ----------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------- | ------------------------------------- |
| R1/R2/R3/R4 — entrada, valor, descrição e data na criação                                       | D03                                                                                                           | CT-006–CT-009                         |
| R1/R2/R3/R4 — entrada, valor, descrição e data na edição                                        | D04                                                                                                           | CT-007–CT-009, CT-015                 |
| R4 — mês corrente na consulta; R7 — período inicial                                             | D01                                                                                                           | CT-002                                |
| R5 — catálogo comum necessário à leitura, nomes em histórico/detalhes                           | D01                                                                                                           | CT-004/CT-010                         |
| R5 — disponibilidade, compatibilidade, troca de tipo, ausência de manutenção e falha na criação | D03                                                                                                           | CT-005/CT-010/CT-019                  |
| R5 — compatibilidade, opções e falha na edição                                                  | D04                                                                                                           | CT-010/CT-019                         |
| R5/R7 — nomes e classificação nos filtros, descrição literal/composição                         | D02                                                                                                           | CT-012/CT-013                         |
| R6 — acesso/isolamento/persistência da leitura                                                  | D01                                                                                                           | CT-001/CT-004/CT-023                  |
| R6 — titularidade/persistência de criação, edição e exclusão                                    | D03 / D04 / D05, cada mutação própria                                                                         | CT-006/CT-015/CT-018/CT-023           |
| R8 — ordem, página, contagem e troca/remoção do mês                                             | D01                                                                                                           | CT-002/CT-003                         |
| R8 — limpar todos os filtros e reset ao pesquisar/filtrar                                       | D02                                                                                                           | CT-012/CT-013                         |
| R8 — página válida após editar/excluir                                                          | D04 / D05, cada mutação própria                                                                               | CT-016/CT-018                         |
| R9 — detalhes integrais                                                                         | D01                                                                                                           | CT-004                                |
| R9 — edição do mesmo registro                                                                   | D04                                                                                                           | CT-015/CT-022                         |
| R9 — transações intencionais iguais permitidas                                                  | D03                                                                                                           | CT-021                                |
| R10 — confirmação, cancelamento e exclusão financeira ativa                                     | D05                                                                                                           | CT-017/CT-018                         |
| R11 — atualização nesta sessão após cada mutação                                                | D03 / D04 / D05, cada resultado próprio                                                                       | CT-006/CT-015/CT-016/CT-018/CT-025    |
| R11 — indicadores/consultas/propostas e mensagens históricas                                    | Limite aprovado F05/F06/F07; não criar trabalho nesta Feature                                                 | CT-025 delimita o encerramento manual |
| R12 — apresentação                                                                              | D01 consulta/detalhes; D02 filtros; D03 criação; D04 edição; D05 confirmação, sem sobreposição de superfícies | CT-024                                |
| CA01 — cadastro, permanência e uma gravação por envio                                           | D03                                                                                                           | CT-006/CT-021/CT-023                  |
| CA02/CA03 — validação e datas                                                                   | D03 criação; D04 edição                                                                                       | CT-007–CT-010                         |
| CA04 — mês inicial                                                                              | D01                                                                                                           | CT-002                                |
| CA04 — pesquisa e combinação                                                                    | D02                                                                                                           | CT-012/CT-013                         |
| CA05 — ordem/paginação base                                                                     | D01                                                                                                           | CT-003                                |
| CA05 — limpeza/reset                                                                            | D02                                                                                                           | CT-013                                |
| CA05 — página válida após mutação                                                               | D04 edição; D05 exclusão                                                                                      | CT-016/CT-018                         |
| CA06 — detalhes                                                                                 | D01                                                                                                           | CT-004                                |
| CA06 — editar campos/categoria/recorte                                                          | D04                                                                                                           | CT-010/CT-015/CT-016                  |
| CA07 — cancelar/fechar                                                                          | D03 criação; D04 edição; D05 confirmação                                                                      | CT-011/CT-017                         |
| CA08 — exclusão persistida, sem desfazer                                                        | D05                                                                                                           | CT-017/CT-018                         |
| CA09 — falhas de leitura e indisponibilidade em detalhes                                        | D01                                                                                                           | CT-019/CT-022                         |
| CA09 — falha de pesquisa                                                                        | D02                                                                                                           | CT-019                                |
| CA09 — falhas/repetição/resultado incerto em mutações e categorias                              | D03 criação; D04 edição; D05 exclusão                                                                         | CT-019–CT-022                         |
| CA10 — identidade, acesso direto e isolamento                                                   | F02 fornece identidade; cada entrega de F04 aplica e verifica a autorização financeira do seu canal           | CT-001/CT-023                         |
| CA11 — vazio inicial/recorte                                                                    | D01 mês; D02 pesquisa/filtros; D03 ação real de cadastro                                                      | CT-014                                |
| CA12 — fechamento manual                                                                        | QA integrada após D01–D05                                                                                     | CT-025                                |
| CA13 — visual                                                                                   | Cada DEV na sua superfície; QA compara o conjunto                                                             | CT-024                                |
| CA14 — catálogo e classificação                                                                 | D01 nomes na leitura; D02 filtros; D03 criação; D04 edição                                                    | CT-005/CT-010/CT-013                  |
| CA15 — catálogo sem manutenção, opções sem registro/falha e legibilidade                        | D03 criação; D04 edição; demais superfícies mantêm nomes e legibilidade                                       | CT-005/CT-019/CT-024                  |

Nenhuma regra financeira nova é classificada como totalmente existente. Cancelamentos, recortes fora do mês e processamento estão descritos nas respectivas mutações, além do vínculo de rastreabilidade.

## Condições de teste

Fonte de revisão: [condicoes-teste-r001.md](condicoes-teste-r001.md). Documento previsto para a única QA: [1016274 - Condições de testes.docx](<r001/1016274 - Condições de testes.docx>). As condições abaixo integram a mesma decisão sobre descrições, campos, dependências e anexo.

Pai: Gestão de transações — #1016274.
Projeto: FinAi (65224). Versão: Livewire (20359).
Revisão: r001, prévia de 13/11/2026; condições ainda não executadas.

### Contexto

Executar pela navegação, formulário, histórico e diálogos reais de Transações. A fundação visual F01 e a jornada pessoal F02 precisam estar implementadas e verificadas; a publicação de suas tarefas em New não comprova isso. Usar ambiente de homologação isolado, duas contas pessoais confirmadas A/B, uma conta pendente, visitante e perfis administrativos/de suporte sem acesso adicional às finanças de terceiros. Preparar dados próprios, sem gravar exemplos de demonstração como dados reais.

Preparar pelo menos 101 registros da conta A, em meses e anos diferentes, com receitas/despesas de todas as categorias, datas iguais, instantes de criação iguais para verificar desempate estável, descrição com acentos e caixa variada e descrições contendo literalmente %, _ e !. Preparar registros distintos de B, uma conta sem transações, descrições de 1/120/121 caracteres e valores nos limites. Dados preparados permitem aceitar a consulta antes de existir cadastro; o fluxo integrado final usa cadastro real.

Disponibilizar controle de relógio próximo à virada do dia e do mês em America/Sao_Paulo, falhas reversíveis de leitura/gravação e de obtenção de categorias quando houver essa operação, latência e perda de resposta, e duas sessões da mesma conta para indisponibilidade concorrente. Preparação desses controles faz parte da QA. Mecanismo interno de categorias não cria obrigação de falha remota inexistente.

Visual V01: docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip, entrada index.html, seções #transactions, #month-wrap, #transaction-dialog, #detail-dialog e #delete-dialog; consultar a ordem final das regras visuais e DESIGN-HANDOFF.md. Comparar com a base F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px. Estados adicionais aprovados no requisito usam a mesma linguagem visual. Dados persistidos por titular e regras do requisito substituem armazenamento local e regras demonstrativas do protótipo.

F05/F06/F07 verificam seus canais ao entregá-los. Esta QA termina na gestão manual real, sem aguardar dashboard ou IA e sem reescrever mensagens históricas. Registrar evidências e defeitos por condição; repetir cenários afetados após correção.

### CT-001 — Entrada financeira e restrições

Verificação: Abrir Transações pela navegação e por referência direta como A confirmada, visitante e conta pendente. Tentar as operações financeiras com sessão pendente, inclusive após alteração de e-mail que retire a confirmação.

Resultado esperado: A acessa sua gestão. Visitante e conta pendente não consultam nem alteram finanças; as funções não financeiras de F02 permanecem disponíveis conforme autorização.

Origem no requisito: Atores e permissões; R6; CA10.

### CT-002 — Mês inicial e consulta de outros períodos

Verificação: Abrir a tela sem filtros escolhidos com dados em diferentes meses. Selecionar outro mês, remover o mês e retornar ao mês corrente. Repetir com relógio próximo à virada de mês em São Paulo.

Resultado esperado: A abertura usa o mês corrente em America/Sao_Paulo. Outro mês mostra apenas suas movimentações; sem mês a consulta inclui todo o histórico próprio, inclusive datas antigas. Não há dados demonstrativos.

Origem no requisito: R4, R7, R8; CA03, CA04, CA05, CA12.

### CT-003 — Ordem, contagem e paginação

Verificação: Consultar mais de 50 registros estáveis, navegar anterior/próxima e conferir datas iguais e empates no instante de criação.

Resultado esperado: Cada página mostra até 50 registros, contagem e página atual, com controles quando necessários. A ordem é data da movimentação decrescente, criação mais recente primeiro na mesma data e desempate estável, sem omissões ou repetições entre páginas.

Origem no requisito: R8; CA05.

### CT-004 — Leitura integral dos detalhes

Verificação: Abrir uma linha com descrição de 120 caracteres, maior valor permitido e campos resumidos na listagem móvel; fechar e reabrir os detalhes.

Resultado esperado: Tipo, valor BRL exato, descrição, categoria e data aparecem integralmente nos detalhes. A linha distingue receita/despesa por sinal e identificação além da cor. Campos resumidos não ficam inacessíveis no celular.

Origem no requisito: R2, R9, R12; Dados percebidos; CA06, CA13.

### CT-005 — Catálogo comum e opções sem movimentações

Verificação: Antes da carga histórica do contexto, abrir cadastro nas contas A/B ainda sem registros e alternar receita/despesa. Comparar as opções e procurar ações de manutenção de categorias.

Resultado esperado: Ambas recebem exatamente Salário, Freelance, Rendimentos e Outras receitas para receita; Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras e Outras despesas para despesa. Nomes e acentos são preservados. Não há manutenção, personalização, subcategoria, importação ou nova tela de categorias.

Origem no requisito: R5; CA14, CA15.

### CT-006 — Cadastro e permanência

Verificação: Cadastrar receita e despesa válidas, incluindo 35,90, 1.234,56 e uma data de mês anterior. Conferir no mês adequado ou em todo o histórico, abrir detalhes, voltar à tela e acessar a mesma conta em outro navegador.

Resultado esperado: Cada envio concluído grava uma única transação do titular, com cinco campos exatos e centavos preservados. A data começa em hoje no formulário. Os registros permanecem disponíveis à mesma conta, sem novo login para atualizar a consulta atual.

Origem no requisito: R1, R2, R4, R6, R11; CA01, CA12, CA14.

### CT-007 — Campos obrigatórios e descrição

Verificação: Em criação e edição, omitir separadamente cada um dos cinco campos, tentar tipo inválido, descrição apenas com espaços e textos de 1, 120 e 121 caracteres após retirar espaços nas extremidades.

Resultado esperado: Dados inválidos são recusados com erro associado ao campo e preenchimento corrigível, sem gravação parcial nem truncamento. Descrições válidas preservam o texto após a retirada dos espaços nas extremidades.

Origem no requisito: R1, R3, R9; CA02, CA06.

### CT-008 — Valores brasileiros e limites

Verificação: Em criação e edição, usar 0,01 e 999.999.999,99, além de zero, negativo e 1.000.000.000,00. Digitar e colar 35,901: verificar recusa, sem virar 359,01 ou ser arredondado. Tentar entrada digitada e colada de 35,90 e 1.234,56.

Resultado esperado: Valores positivos até o limite, com até duas casas, preservam exatamente centavos. Zero, negativo, excesso de limite e mais de duas casas são recusados; não são arredondados nem transformados silenciosamente em outro valor. Despesa é representada pelo tipo, sem exigir número negativo.

Origem no requisito: R2; CA02, CA06.

### CT-009 — Datas válidas e fuso

Verificação: Em criação e edição, usar 01/01/1900, hoje e data passada válida; tentar 31/12/1899, data inexistente e amanhã. Controlar o relógio em ambos os lados da virada do dia em São Paulo, inclusive quando a data UTC difere.

Resultado esperado: Aceitar apenas datas reais entre 01/01/1900 e hoje em America/Sao_Paulo, inclusive. Não exigir horário nem deslocar a data financeira informada. O mesmo critério vale no cadastro e na edição.

Origem no requisito: R4, R9; CA03, CA06.

### CT-010 — Compatibilidade da categoria

Verificação: Criar e editar com cada categoria compatível, incluindo as duas opções Outras. Alternar tipo e tentar salvar categoria do tipo anterior, inexistente ou oculta por alteração de referência.

Resultado esperado: A seleção mostra opções compatíveis e a categoria que será salva; valores inexistentes ou incompatíveis são recusados. Histórico, detalhes e filtros apresentam o mesmo vocabulário aprovado.

Origem no requisito: R5, R9; CA02, CA06, CA14.

### CT-011 — Cancelamentos de formulário

Verificação: Preencher criação e edição e usar Cancelar e Fechar em cada uma.

Resultado esperado: Criação não adiciona transação; edição mantém os dados persistidos anteriores. Fechar não equivale a salvar.

Origem no requisito: Fluxos alternativos; CA07.

### CT-012 — Busca literal por descrição

Verificação: Pesquisar trechos de descrições com diferenças de caixa/acentos e com %, _ e !, inclusive fora da primeira página antes da pesquisa.

Resultado esperado: Somente correspondências literais próprias aparecem, sem interpretar os caracteres como curingas. A pesquisa ignora diferenças de caixa e acentos e retorna à primeira página.

Origem no requisito: R7, R8; CA04, CA05.

### CT-013 — Filtros combinados e limpeza

Verificação: Filtrar isoladamente por tipo, categoria e mês; combinar todos com descrição. Alterar cada filtro a partir de outra página. Usar Limpar filtros.

Resultado esperado: Resultados e contagem correspondem à interseção dos filtros próprios e retornam à primeira página quando o recorte muda. Limpar remove descrição, tipo, categoria e mês, passando a todo o histórico. Categorias mantêm os nomes de R5.

Origem no requisito: R5, R7, R8; CA04, CA05, CA14.

### CT-014 — Vazio inicial e recorte sem resultado

Verificação: Abrir Transações em conta sem registros e em conta com registros fora do mês/filtros selecionados.

Resultado esperado: Sem registros, orientar primeiro cadastro e oferecer ação funcional de cadastro. Sem correspondências, informar ausência no recorte e permitir ajuste/limpeza. Não exibir transações fictícias nem tratar falha como vazio.

Origem no requisito: Fluxos alternativos; CA11.

### CT-015 — Edição completa sem cópia

Verificação: Alterar cada um dos cinco campos de transação própria e salvar; trocar tipo e categoria; conferir identificação do mesmo registro, histórico e detalhes.

Resultado esperado: O mesmo registro é atualizado com as regras de criação, sem cópia ou troca de titular. A consulta e os detalhes mostram os dados atuais na sessão, sem novo login.

Origem no requisito: R1–R6, R9, R11; CA02, CA03, CA06, CA12, CA14.

### CT-016 — Salvamento fora do recorte

Verificação: Criar transação em mês diferente do atual e editar data, tipo, categoria ou descrição de modo que deixe de corresponder ao recorte. Usar o mês correto ou limpar o recorte para reencontrar o resultado.

Resultado esperado: Sucesso é informado somente após salvar; a ausência no recorte não parece falha. Filtros permanecem fiéis e a página continua válida; o registro salvo pode ser conferido pelos canais de consulta já entregues.

Origem no requisito: Fluxos alternativos; R8, R9, R11; CA01, CA05, CA06, CA12.

### CT-017 — Confirmação e cancelamento de exclusão

Verificação: Solicitar exclusão nos detalhes, ler o aviso e usar Cancelar e Fechar antes de confirmar em tentativas distintas.

Resultado esperado: O diálogo explica saída do histórico e dos totais e ausência de desfazer. Nenhum registro ou efeito financeiro é removido sem confirmação explícita.

Origem no requisito: R10; CA07, CA08.

### CT-018 — Exclusão persistida e página válida

Verificação: Confirmar exclusão própria, incluindo o único item da última página. Reabrir a consulta em outro navegador e tentar os detalhes pelo identificador anterior.

Resultado esperado: O registro deixa histórico e detalhes ativos, não reaparece após retorno e não oferece desfazer. A consulta continua em página válida. O dado excluído fica fora do conjunto financeiro ativo; os indicadores e consultas de F05/F06 serão verificados por essas Features.

Origem no requisito: R8, R10, R11; CA05, CA08, CA12.

### CT-019 — Falhas de leitura e categorias

Verificação: Provocar falha reversível ao carregar histórico/detalhes e ao pesquisar/aplicar filtros. Quando o mecanismo usado obtiver categorias por operação falhável, falhar essa operação na abertura/troca do formulário.

Resultado esperado: Apresentar erro e possibilidade de tentar novamente, sem aparentar histórico ou catálogo vazio. Não permitir categoria improvisada nem exibir dados de outra conta. Na recuperação, mostrar dados reais.

Origem no requisito: Fluxos alternativos; R5; CA09, CA11, CA15.

### CT-020 — Falhas de gravação e retomada

Verificação: Provocar falha reversível ao criar, editar e excluir e tentar novamente depois de restabelecer a operação.

Resultado esperado: Não apresentar sucesso nem alteração parcial na falha. Manter o preenchimento necessário à retomada enquanto o formulário estiver aberto; preservar o registro na exclusão não concluída. Reconciliar o estado real quando o resultado estiver incerto.

Origem no requisito: Fluxos alternativos; R11; CA09.

### CT-021 — Processamento, resposta incerta e registros iguais

Verificação: Com latência, tentar disparar repetidamente o mesmo envio de criação/edição/exclusão. Simular perda de resposta após possível gravação. Depois criar intencionalmente duas transações válidas com dados iguais.

Resultado esperado: Processamento é visível e impede repetição do envio pela interface. Em resposta incerta, consultar o estado atual antes de induzir repetição. Envios intencionais distintos com dados iguais são permitidos e não confundidos com duplicação do mesmo envio.

Origem no requisito: Fluxos alternativos; R9; CA01, CA09.

### CT-022 — Indisponibilidade concorrente

Verificação: Em duas sessões da mesma conta, abrir detalhes/edição/exclusão e remover o registro em uma antes de concluir a ação na outra.

Resultado esperado: Informar indisponibilidade e atualizar a consulta. Não recriar silenciosamente registro removido, não apresentar atualização/exclusão inexistente como concluída e não revelar dados alheios.

Origem no requisito: Fluxos alternativos; R9; CA06, CA09, CA10.

### CT-023 — Titularidade em todos os acessos

Verificação: Com A/B, tentar histórico, filtros, detalhes, edição e exclusão por identificadores da outra conta, incluindo referência direta e adulteração do titular no cadastro/edição. Sair e trocar de conta; repetir leitura em outro navegador. Como administração/suporte, tentar finanças de terceiros.

Resultado esperado: Consultas e alterações se restringem ao titular autenticado; titularidade não é escolhida nem editada. Nenhuma conta herda dados da sessão anterior ou recebe acesso financeiro de terceiro por privilégio administrativo/de suporte.

Origem no requisito: Atores e permissões; R6; CA01, CA10.

### CT-024 — Fidelidade visual, estados e navegação

Verificação: Comparar V01 com listagem, mês, paginação, busca/filtros, criação/edição, detalhes e confirmação nas nove dimensões e transições do contexto. Exercitar estados normal, foco, carregamento, vazio, validação, erro, sucesso, cancelamento e confirmação aplicáveis, usando mouse e teclado e lateral recolhida quando disponível.

Resultado esperado: Preservar marca, paleta, tipografia, hierarquia, proporções, espaços, bordas, raios e controles da referência sobre F01. Campos, nomes de categorias, valores grandes, descrições longas, mensagens e ações permanecem legíveis e alcançáveis, sem sobreposição ou rolagem horizontal da página. A navegação não encobre conteúdo/foco; campos resumidos no celular são lidos nos detalhes. Não transportar textos de armazenamento local ou simulação. Evidências incluem comparação visual, não somente ausência de erro.

Origem no requisito: R5, R12; CA13, CA14, CA15; dependência visual F01.

### CT-025 — Jornada manual integrada

Verificação: Pela interface, cadastrar receita/despesa, consultar outro mês e todo o histórico, pesquisar, combinar/limpar filtros, navegar páginas, abrir detalhes, editar, cancelar e confirmar exclusão. Reabrir a mesma conta e repetir o confronto de dados com B.

Resultado esperado: O ciclo manual termina com dados reais persistidos, atuais e isolados; cada resultado é conferido no histórico/detalhes sem novo login. A QA de F04 encerra sem depender de dashboard/IA futuros. A preservação de respostas históricas permanece limite do requisito, com verificação no canal correspondente em F06/F07.

Origem no requisito: R6–R11; CA01, CA04–CA12.

## Descrições completas

### D01 — [DEV] [WEB] [USUARIO] Gestão de transações - Histórico por mês e detalhes

#### Entrega

Disponibilizar Transações na navegação real para o titular consultar suas receitas e despesas por mês ou em todo o histórico, navegar páginas e abrir os cinco campos integrais de cada registro. Usar a base visual FinAI já verificada.

#### Escopo e limites

Histórico e detalhes permanecem juntos porque a linha móvel resume ou oculta campos que precisam estar integralmente acessíveis no mesmo fluxo de consulta, conforme R12/CA13. O catálogo comum necessário à classificação apresentada começa nesta entrega. Pesquisa por descrição, filtros de tipo/categoria, cadastro, edição e exclusão têm entregas próprias; seus controles só devem oferecer operações reais quando disponíveis. A conferência inicial pode usar dados próprios preparados em homologação.

#### Critérios de aceite

- O titular autenticado com e-mail confirmado encontra Transações na navegação e consulta somente registros próprios, inclusive por acesso direto. Visitante e conta pendente não acessam dados financeiros; administração e suporte não recebem acesso a finanças de terceiros.
- A abertura usa o mês corrente em America/Sao_Paulo. Selecionar outro mês consulta esse período; remover o mês consulta todo o histórico, inclusive datas antigas.
- A listagem apresenta dados reais, com descrição, data, categoria e valor compreensíveis, distinguindo receita/despesa por sinal e identificação do tipo além da cor.
- O catálogo comum preserva os nomes Salário, Freelance, Rendimentos e Outras receitas para receitas; Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras e Outras despesas para despesas. Não criar manutenção ou tela de categorias.
- Ordenar por data financeira decrescente, criação mais recente primeiro na mesma data e desempate estável. Com dados estáveis, anterior/próxima não omitem nem repetem registros entre páginas.
- Exibir até 50 registros por página, contagem, página atual e controles quando necessários. Mudar o mês retorna à primeira página.
- Os detalhes mostram tipo, valor em BRL com centavos exatos, descrição integral, categoria e data, inclusive quando a linha móvel resume campos.
- Sem registros, apresentar orientação de primeiro cadastro; com registros fora do mês, informar ausência no recorte e permitir ajustar/remover o mês. A ação de cadastro é integrada pela entrega Cadastro classificado.
- Falha de leitura não se apresenta como histórico vazio; informar erro e permitir nova tentativa. Registro indisponível ao abrir detalhes gera orientação e atualização da consulta, sem dados alheios.
- Sair, trocar de conta ou retornar em outro navegador mantém o isolamento. A titularidade dos registros não é alterada por sua consulta.
- Comparar listagem, mês, paginação, detalhes e estados aplicáveis com #transactions, #month-wrap e #detail-dialog de V01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px. Preservar hierarquia, proporções, tipografia, cores e controles da F01; textos/valores extensos e foco não ficam encobertos nem causam rolagem horizontal da página.

#### Dependências

O início depende da identidade e confirmação de e-mail implementadas e verificadas por [[QA] [WEB] [USUARIO] Acesso autenticado e espaço financeiro pessoal](https://redmine.remsoft.com.br/issues/1016293), fornecidas pela [DEV #1016292](https://redmine.remsoft.com.br/issues/1016292). Essa jornada já depende da base visual implementada e verificada por [[QA] [WEB] [USUARIO] Adequação visual completa do FinAI](https://redmine.remsoft.com.br/issues/1016288). As publicações atuais não liberam esses pré-requisitos.

#### Referências

[Pai #1016274](https://redmine.remsoft.com.br/issues/1016274); R2/R4–R9/R12 na leitura; CA03–CA06/CA09–CA15 nas parcelas de consulta; CT-001–CT-004, CT-014, CT-019, CT-022–CT-025.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final de suas regras e `DESIGN-HANDOFF.md`. Locadores: #transactions, #history, #month-wrap, #pagination e #detail-dialog. As restrições e a persistência aprovadas substituem o comportamento local do protótipo.

Intenção estável de criação: `docs/harness/features/1016274-gestao-de-transacoes/slices/slices.md#D01-r001`.

### D02 — [DEV] [WEB] [USUARIO] Gestão de transações - Pesquisa e filtros

#### Entrega

Permitir localizar transações próprias por trecho da descrição e pela combinação de tipo, categoria e mês, com consulta, contagem e paginação fiéis ao recorte e limpeza completa dos filtros.

#### Escopo e limites

Usar o histórico e os detalhes já entregues. Mês e consulta de todo o histórico pertencem à entrega Histórico por mês e detalhes; esta tarefa integra esses controles à pesquisa e aos novos filtros de tipo/categoria, sem refazer a consulta de base.

#### Critérios de aceite

- Pesquisar parte da descrição ignora caixa e acentos e trata %, _ e ! como texto literal, sem ampliar a consulta para registros alheios.
- Os filtros isolados ou combinados de tipo, categoria e mês restringem os registros próprios em conjunto com a descrição.
- As categorias nos filtros usam exatamente Salário, Freelance, Rendimentos, Outras receitas, Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras e Outras despesas, preservando nomes e acentos do catálogo comum.
- Limpar filtros remove descrição, tipo, categoria e mês, passando a consultar todo o histórico próprio.
- Alterar pesquisa ou qualquer filtro retorna à primeira página; contagem e controles anterior/próxima permanecem coerentes com o resultado e com o limite de 50 por página.
- Sem correspondências, informar ausência no recorte e permitir ajuste/limpeza. Não confundir esse estado com conta sem registros nem com falha de carregamento.
- Falha ao consultar informa erro e permite tentar novamente sem exibir dados de outra conta ou aparentar histórico vazio.
- Visitante e conta pendente continuam impedidos de consultar; troca de conta não conserva resultados da anterior.
- Comparar #transactions, #search, #type-filter, #category-filter, #filter-count e #clear-filters com V01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, nos estados aplicáveis de normal, foco, processamento, vazio e erro. Rótulos, nomes de categorias, controles e resultados permanecem legíveis e utilizáveis, sem sobreposição nem rolagem horizontal da página.

#### Dependências

O início depende de Gestão de transações - Histórico por mês e detalhes, que fornece a navegação, a leitura própria, o catálogo e a paginação sobre F01/F02 já verificadas. A implementação do cadastro não é necessária: dados próprios de homologação permitem demonstrar a pesquisa.

#### Referências

[Pai #1016274](https://redmine.remsoft.com.br/issues/1016274); R5–R8/R12; CA04/CA05/CA09–CA15 nas parcelas de pesquisa; CT-002/CT-003, CT-010, CT-012–CT-014, CT-019, CT-023–CT-025.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final de suas regras e `DESIGN-HANDOFF.md`. Locadores: #transactions, .filters, #search, #type-filter, #category-filter, #clear-filters e #pagination. Aplicar pesquisa e permissões aprovadas, sem reproduzir armazenamento local.

Intenção estável de criação: `docs/harness/features/1016274-gestao-de-transacoes/slices/slices.md#D02-r001`.

### D03 — [DEV] [WEB] [USUARIO] Gestão de transações - Cadastro classificado

#### Entrega

Permitir cadastrar uma receita ou despesa realizada com tipo, valor, descrição, categoria e data, confirmar o salvamento real e reencontrar os dados no histórico e nos detalhes da própria conta.

#### Escopo e limites

Receita e despesa são variantes da mesma interação: o tipo determina entrada/saída e as opções de classificação do formulário. Consumir o catálogo comum introduzido no histórico e disponibilizar suas opções mesmo sem movimentações. A ação Nova transação e sua orientação no vazio inicial pertencem a esta entrega. Não incluir edição, manutenção de categorias ou registro por IA.

#### Critérios de aceite

- Nova transação abre formulário com cinco campos obrigatórios e data inicial de hoje em America/Sao_Paulo. Tipo aceita somente receita ou despesa.
- Aceitar valor em BRL maior que zero, até R$ 999.999.999,99 e com até duas casas decimais; reconhecer 35,90 e 1.234,56 preservando exatamente os centavos, inclusive ao colar.
- Recusar zero, negativo, excesso de limite ou mais de duas casas, sem arredondar ou transformar silenciosamente a entrada em outro valor. Despesa usa tipo, sem valor negativo.
- A descrição aceita de 1 a 120 caracteres após retirar espaços nas extremidades, mantendo o texto; omissão, apenas espaços e excesso são recusados sem truncar.
- Aceitar somente datas reais entre 01/01/1900 e hoje em America/Sao_Paulo, inclusive, sem horário obrigatório ou deslocamento da data financeira; recusar data anterior, inexistente e futura.
- Para receita oferecer exatamente Salário, Freelance, Rendimentos e Outras receitas; para despesa, Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras e Outras despesas. Preservar acentos e nomes.
- Trocar tipo reapresenta opções compatíveis e a categoria que será salva; categoria inexistente, oculta ou do tipo anterior incompatível é recusada.
- O mesmo catálogo permanece disponível sem transações e entre contas, sem ações de criar, editar, excluir, personalizar, importar ou organizar subcategorias.
- Quando houver falha real de obtenção das opções, comunicar o erro e permitir nova tentativa, sem catálogo vazio enganoso ou categoria improvisada.
- Validar dados e autorização antes de persistir. Cada envio concluído cria uma única transação do usuário autenticado, sem escolha de titular, gravação parcial ou acesso financeiro de visitante/conta pendente.
- Erros de campo mantêm o formulário corrigível. Cancelar ou fechar não grava; falha de salvamento não apresenta sucesso e preserva o preenchimento necessário enquanto o formulário estiver aberto.
- Mostrar processamento e impedir repetição do mesmo envio pela interface. Em resultado incerto, consultar o estado real antes de induzir repetição. Duas transações intencionais com dados iguais continuam permitidas.
- Após sucesso, atualizar o histórico sem novo login respeitando filtros ativos. Se a data ou outros dados ficarem fora do recorte, informar sucesso sem inserir resultado incompatível; permitir conferir o registro pelo mês adequado ou em todo o histórico e pelos detalhes já disponíveis.
- Retornar à tela ou usar a mesma conta em outro navegador preserva os cinco campos; trocar de conta não mistura registros.
- Comparar formulário #transaction-dialog, mensagens, seleção de categorias e estados de validação/processamento/falha/sucesso/cancelamento com V01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px. Preservar hierarquia, espaços, cores e tipografia da base F01, rótulos, foco e teclado; nomes/valores extensos não encobrem ações e a navegação não encobre o diálogo.

#### Dependências

O início depende de Gestão de transações - Histórico por mês e detalhes, necessário para conferir integralmente registros atuais ou antigos, inclusive no celular. Pesquisa e filtros não bloqueia o início; ao estar disponível, sua consulta deve continuar fiel após o cadastro. Usar F01/F02 já verificadas, sem reconstruí-las.

#### Referências

[Pai #1016274](https://redmine.remsoft.com.br/issues/1016274); R1–R6/R9/R11/R12 na criação; CA01–CA03/CA07/CA09–CA15 nas parcelas de cadastro; CT-001, CT-005–CT-011, CT-014, CT-016, CT-019–CT-021, CT-023–CT-025.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final de suas regras e `DESIGN-HANDOFF.md`. Locadores: #new-transaction, #transaction-dialog, #transaction-form, #form-summary, #tx-type, #tx-value, #tx-description, #tx-category e #tx-date. Datas, limites, falhas e persistência seguem o requisito aprovado; não herdar validações locais do protótipo.

Intenção estável de criação: `docs/harness/features/1016274-gestao-de-transacoes/slices/slices.md#D03-r001`.

### D04 — [DEV] [WEB] [USUARIO] Gestão de transações - Edição de transações

#### Entrega

Permitir corrigir tipo, valor, descrição, categoria e data de uma transação própria pelos detalhes, atualizando o mesmo registro e refletindo os dados atuais na consulta sem novo login.

#### Escopo e limites

Usar os detalhes e o catálogo comuns e manter as mesmas regras funcionais da criação. A edição tem aceite próprio; o compartilhamento do formulário ou das validações não obriga esperar o cadastro para iniciar. Dados próprios preparados em homologação permitem demonstrar a atualização.

#### Critérios de aceite

- Abrir edição pelos detalhes carrega integralmente os cinco campos atuais. O titular não pode ser escolhido nem alterado, e salvar atualiza o mesmo registro sem criar cópia.
- Exigir tipo receita/despesa, valor, descrição, categoria e data. Recusar omissões e tipo inválido com erros associados ao campo e preenchimento corrigível.
- Aceitar BRL positivo até R$ 999.999.999,99, com até duas casas, incluindo 35,90 e 1.234,56 digitados/colados com centavos exatos. Recusar zero, negativo, excesso e mais de duas casas, sem arredondamento ou transformação silenciosa.
- Aceitar descrição de 1 a 120 caracteres após retirar espaços nas extremidades, preservando o texto. Recusar apenas espaços e excesso sem truncar.
- Aceitar somente data real entre 01/01/1900 e hoje em America/Sao_Paulo, inclusive; recusar datas anteriores, inexistentes ou futuras, sem exigir horário ou deslocar a data financeira.
- Oferecer exatamente Salário, Freelance, Rendimentos e Outras receitas para receita; Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras e Outras despesas para despesa. Não disponibilizar manutenção de categorias.
- Trocar tipo reapresenta categorias compatíveis e torna clara a seleção que será salva; recusar categoria inexistente ou incompatível, inclusive referência oculta do tipo anterior.
- Falha real ao obter categorias é comunicada e permite retomada, sem catálogo vazio enganoso ou categoria improvisada.
- Validar e autorizar a atualização de registro próprio antes de gravar, inclusive por referência direta. Visitante, conta pendente e outra conta não alteram ou leem os dados; privilégios administrativos/de suporte não concedem acesso adicional.
- Cancelar ou fechar mantém os dados anteriores. Falha de gravação não anuncia sucesso nem aplica alteração parcial e mantém os dados corrigíveis enquanto a tela estiver aberta.
- Mostrar processamento e impedir repetição do mesmo envio pela interface; resultado incerto exige conferir estado atual antes de induzir nova tentativa.
- Registro removido ou indisponível antes de concluir edição não é recriado; informar indisponibilidade e atualizar a consulta sem revelar dados alheios.
- Após salvar, atualizar histórico e detalhes sem novo login, manter uma página válida e respeitar o recorte. Se a alteração retirar o registro dos filtros atuais, o sucesso permanece claro e o registro atualizado é encontrado no recorte adequado.
- Comparar edição em #transaction-dialog e detalhes em #detail-dialog com V01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, incluindo dados preenchidos, validação, processamento, falha, indisponibilidade, sucesso e cancelamento. Preservar hierarquia visual F01 e controles legíveis e alcançáveis por teclado, sem sobreposições ou rolagem horizontal da página.

#### Dependências

O início depende de Gestão de transações - Histórico por mês e detalhes. Para concluir, manter coerência de campos e validações com Gestão de transações - Cadastro classificado e integrar o resultado aos recortes de Gestão de transações - Pesquisa e filtros. Essas integrações não impõem bloqueio de início; o preparo comum das regras do formulário é contabilizado uma vez no cadastro.

#### Referências

[Pai #1016274](https://redmine.remsoft.com.br/issues/1016274); R1–R6/R8/R9/R11/R12 na atualização; CA02/CA03/CA05–CA07/CA09/CA10/CA12–CA15 nas parcelas de edição; CT-001, CT-007–CT-011, CT-015/CT-016, CT-019–CT-025.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final de suas regras e `DESIGN-HANDOFF.md`. Locadores: #detail-dialog, #edit-transaction e #transaction-dialog preenchido. Aplicar as validações e a titularidade aprovadas; não herdar arredondamento ou disponibilidade silenciosa do protótipo.

Intenção estável de criação: `docs/harness/features/1016274-gestao-de-transacoes/slices/slices.md#D04-r001`.

### D05 — [DEV] [WEB] [USUARIO] Gestão de transações - Exclusão confirmada

#### Entrega

Permitir excluir uma transação própria após confirmação explícita, retirando-a do histórico e dos detalhes ativos de forma persistente e mantendo a consulta em uma página válida.

#### Escopo e limites

A confirmação informa a saída do histórico e dos totais e a ausência de desfazer. A exclusão deixa o registro fora dos dados financeiros ativos; F05/F06 verificam seus indicadores e novas consultas ao entregar esses canais. O aceite desta tarefa usa o histórico e os detalhes reais de F04.

#### Critérios de aceite

- Solicitar exclusão pelos detalhes apresenta a confirmação de que o registro sairá do histórico e dos totais e não pode ser desfeito.
- Cancelar ou fechar a confirmação mantém o registro e seus efeitos financeiros. Somente a confirmação explícita aplica a exclusão.
- Autorizar a exclusão de registro próprio antes de gravar, inclusive em referência direta. Visitante, conta pendente e outra conta não consultam ou removem o registro; administração e suporte não ganham acesso financeiro de terceiro.
- Mostrar processamento e impedir repetição do mesmo envio pela interface. Falha não anuncia sucesso nem remoção parcial; resultado incerto exige consultar o estado atual antes de induzir repetição.
- Registro já removido ou indisponível gera orientação e atualização da consulta, sem revelar dados alheios ou anunciar nova exclusão inexistente.
- Após sucesso, atualizar histórico e detalhes sem novo login; o registro deixa consultas financeiras ativas e não compõe seu conjunto de saldo, totais ou balanços.
- Preservar a exclusão ao retornar ou usar outro navegador, sem opção de desfazer no produto.
- Manter os filtros e uma página válida, inclusive ao excluir o último registro da última página; ausência no recorte não é falha de leitura.
- Comparar #delete-dialog, #detail-dialog e retorno à listagem com V01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, incluindo confirmação, cancelamento, processamento, erro, indisponibilidade e sucesso. Preservar texto legível, foco e teclado, ações alcançáveis e composição F01, sem controles encobertos ou rolagem horizontal da página.

#### Dependências

O início depende de Gestão de transações - Histórico por mês e detalhes. Cadastro e edição não são bloqueadores: registros próprios preparados permitem demonstrar a exclusão. Para concluir, preservar os recortes de Gestão de transações - Pesquisa e filtros quando disponíveis. Dashboard e IA não bloqueiam esta entrega.

#### Referências

[Pai #1016274](https://redmine.remsoft.com.br/issues/1016274); R6/R8/R10–R12; CA05/CA07–CA10/CA12/CA13 nas parcelas de exclusão; CT-001, CT-017/CT-018, CT-020–CT-025.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final de suas regras e `DESIGN-HANDOFF.md`. Locadores: #detail-dialog, #delete-transaction, #delete-dialog e #confirm-delete. A confirmação e o efeito de exclusão são os aprovados no requisito, sem impor mecanismo interno de armazenamento.

Intenção estável de criação: `docs/harness/features/1016274-gestao-de-transacoes/slices/slices.md#D05-r001`.

## Publicação proposta

### QA — [QA] [WEB] [USUARIO] Gestão de transações

#### Entrega

Verificar a gestão manual completa de transações e categorias pelas telas reais, cobrindo CT-001–CT-025 da revisão r001, com evidências de resultados, defeitos e um reteste focalizado.

#### Escopo e limites

Executar uma única QA da Feature inteira. Preparar contas, dados históricos, controles de relógio, latência e falhas reversíveis em homologação. Verificações automatizadas relevantes apoiam a conferência, sem substituir o fluxo real ou a comparação visual. A execução não depende dos canais futuros F05/F06/F07.

#### Critérios de aceite

- Executar CT-001–CT-025 do documento de condições r001, registrando resultado e evidência por condição, cobrindo R1–R12 e CA01–CA15.
- Demonstrar cadastro de receita/despesa, permanência em outro navegador, consulta mensal e total, pesquisa literal, filtros combinados, limpeza, paginação e leitura integral dos detalhes.
- Conferir os cinco campos obrigatórios, valores positivos em BRL até R$ 999.999.999,99 e duas casas sem arredondamento silencioso, descrição de 1–120 caracteres após retirada de espaços nas extremidades e datas válidas de 01/01/1900 a hoje em America/Sao_Paulo.
- Conferir todos os nomes e a compatibilidade das quatro categorias de receita e oito de despesa, troca de tipo, opções sem registros, catálogo comum entre contas e ausência de manutenção.
- Demonstrar edição de cada campo sem cópia, sucesso fora do recorte, cancelamentos de criação/edição/exclusão, confirmação explícita, exclusão persistida e página válida.
- Conferir falhas de leitura, categorias quando sua obtenção puder falhar, gravação e resultado incerto; processamento impede repetição do mesmo envio, enquanto transações intencionais iguais são permitidas.
- Verificar indisponibilidade concorrente sem recriação, acesso direto e isolamento entre duas contas, visitante/conta pendente e ausência de acesso financeiro de terceiros por administração/suporte.
- Comparar listagem, filtros, mês, paginação, formulários, detalhes, confirmação e estados aplicáveis com V01 e a base F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px. Verificar legibilidade, rótulos, foco, teclado, campos resumidos acessíveis em detalhes, ações alcançáveis e ausência de sobreposições ou rolagem horizontal da página.
- Concluir a jornada manual integrada de CT-025 com dados reais e atuais, sem novo login para refletir alterações e sem aguardar dashboard/IA. A verificação da preservação das respostas históricas pertence a F06/F07 nos respectivos canais.
- Registrar defeitos e repetir os cenários afetados em um reteste focalizado; falha ou condição não executada permanece explicitamente pendente.

#### Dependências

Executar após Gestão de transações - Histórico por mês e detalhes; Gestão de transações - Pesquisa e filtros; Gestão de transações - Cadastro classificado; Gestão de transações - Edição de transações; e Gestão de transações - Exclusão confirmada. Essas entregas consomem F01/F02 implementadas e verificadas.

#### Referências

[Pai #1016274](https://redmine.remsoft.com.br/issues/1016274); R1–R12, CA01–CA15; condições r001, CT-001–CT-025; anexo previsto `1016274 - Condições de testes.docx`.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final de suas regras e `DESIGN-HANDOFF.md`. Locadores: #transactions, #month-wrap, #transaction-dialog, #detail-dialog e #delete-dialog. O requisito prevalece sobre armazenamento local, mensagens de simulação e regras funcionais do protótipo.

Intenção estável de criação: `docs/harness/features/1016274-gestao-de-transacoes/slices/slices.md#QA-r001`.

### Destino e campos exatos

Todas as seis filhas serão novas sob o pai 1016274, projeto 65224 e versão 20359. Não há filha para adotar ou manter externa. Não publicar tarefa Study: as incertezas inspecionadas permitem uma proposta completa.

| Campo                                           | DEV D01–D05                                                                                                               | QA                                         |
| ----------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------ |
| subject                                         | Título completo mostrado em cada descrição                                                                                | [QA] [WEB] [USUARIO] Gestão de transações  |
| tracker_id                                      | Task (4)                                                                                                                  | Deliverable (5)                            |
| status_id                                       | New (1)                                                                                                                   | New (1)                                    |
| priority_id                                     | Normal (4)                                                                                                                | Normal (4)                                 |
| project_id / fixed_version_id / parent_issue_id | 65224 / 20359 / 1016274                                                                                                   | 65224 / 20359 / 1016274                    |
| estimated_hours                                 | 3 / 2 / 2 / 2 / 1                                                                                                         | 2                                          |
| custom_fields                                   | Sequencing id 2: 11 / 12 / 13 / 14 / 15                                                                                   | Sequencing id 2: 16                        |
| responsible / category / dates                  | Sem atribuição, categoria ou datas; não preencher outros campos por inferência                                            | Idem                                       |
| description                                     | Seções Entrega, Escopo e limites, Critérios, Dependências e Referências, com rodapé estável, exatamente como nesta prévia | Idem, com CT-001–CT-025 e arquivo previsto |

Usar nomes de tarefas ainda sem ID exatamente como apresentados nas dependências; não inserir links adicionais durante publicação sem revisão correspondente. IDs confirmados entram nos registros da publicação e em task.md.

Alteração proposta no pai: somente `custom_fields` Sequencing (id 2) de vazio para 11, espelhando D01. Preservar descrição, status New, prioridade, versão, relações, conteúdo humano e demais campos. Não publicar comentário adicional, não alterar status e não editar os outros pais.

### Relações novas

Direção `blocks`: origem bloqueia destino. As referências D01–D05/QA serão substituídas pelos IDs confirmados, sem mudar os endpoints funcionais aprovados.

| Origem                                                                                                                          | Destino                                                                         | Motivo                                                                                          |
| ------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------- |
| [#1016293 — [QA] [WEB] [USUARIO] Acesso autenticado e espaço financeiro pessoal](https://redmine.remsoft.com.br/issues/1016293) | D01 — [DEV] [WEB] [USUARIO] Gestão de transações - Histórico por mês e detalhes | Identidade/confirmação verificadas sobre a base visual F01 antes de iniciar o canal financeiro. |
| D01 — [DEV] [WEB] [USUARIO] Gestão de transações - Histórico por mês e detalhes                                                 | D02 — [DEV] [WEB] [USUARIO] Gestão de transações - Pesquisa e filtros           | Consulta e paginação reais para restringir.                                                     |
| D01 — [DEV] [WEB] [USUARIO] Gestão de transações - Histórico por mês e detalhes                                                 | D03 — [DEV] [WEB] [USUARIO] Gestão de transações - Cadastro classificado        | Conferência de qualquer data/campo após salvar.                                                 |
| D01 — [DEV] [WEB] [USUARIO] Gestão de transações - Histórico por mês e detalhes                                                 | D04 — [DEV] [WEB] [USUARIO] Gestão de transações - Edição de transações         | Registro próprio consultável e detalhes de entrada.                                             |
| D01 — [DEV] [WEB] [USUARIO] Gestão de transações - Histórico por mês e detalhes                                                 | D05 — [DEV] [WEB] [USUARIO] Gestão de transações - Exclusão confirmada          | Registro próprio e detalhes de entrada.                                                         |
| D01, D02, D03, D04 e D05, com os títulos completos acima                                                                        | QA — [QA] [WEB] [USUARIO] Gestão de transações                                  | Cinco relações, uma por DEV, para verificar o resultado inteiro.                                |

São dez relações novas. Não criar D03→D04 por mero reuso, nem dependência de cadastro para exclusão. F01 QA #1016288 já bloqueia F02 DEV #1016292, que bloqueia F02 QA #1016293: o novo bloqueio a partir desta QA preserva a ordem visual sem aresta redundante.

O grafo remoto alcançável contém 16 issues e 21 relações blocks, lidas pelos dois endpoints, sem ciclo e sem endpoints externos não consultados. Acrescentar as dez relações propostas continua acíclico. Preservar as 21 atuais, inclusive as relações de Project Flow #879 (F01→F04), #880 (F02→F04), #883 (F04→F05), #886 (F04→F06) e #888 (F04→F07). Nenhuma relação provisória será retirada; nenhum refinamento de bloqueios dos consumidores é autorizado nesta prévia.

### Documento QA

Gerar e conferir o pacote Word real a partir das condições r001; nome obrigatório `1016274 - Condições de testes.docx`, caminho `slices/r001/1016274 - Condições de testes.docx`. A capacidade local identificada é Word instalado por COM, com conversão Markdown/HTML via league/commonmark 2.10.7 já disponível, sem instalar dependências nem implementar conversor novo.

A prévia DOCX foi gerada no Word 16.0 e conferida: pacote ZIP/OpenXML com as entradas obrigatórias, 25 condições e equivalência integral do texto com o Markdown r001, normalizando somente espaços e marcação dos títulos. Arquivo real de 20.741 bytes; condições não executadas.

Depois da autorização, fazer upload pelo MCP e associar somente à nova QA desta Feature, com descrição de anexo “Condições de teste r001 — Gestão de transações”. Conferir nome, identidade e conteúdo do arquivo no preparo e presença do anexo na QA após associação. Não anexar ao pai nem alterar anexos existentes.

## Sequencing

Leitura completa MCP: projeto 65224/versão 20359, status *, todos os trackers, offset 0/limit 100/total 16. Não houve segunda página. Sequencing é o campo customizado id 2 do projeto, observado no pai e em filhas Task/Deliverable.

Posições ocupadas: 1–8, Visual (pai #1016270 espelha 1; DEV #1016281–#1016287 e QA #1016288); 9–10, Acesso (pai #1016271 espelha 9; DEV #1016292 e QA #1016293). Os outros quatro pais têm valor vazio. Não foram encontrados valores não vazios inválidos; os espelhos conhecidos não consomem nova posição.

Novo bloco proposto: **11–16**, D01–D05 em 11–15 e QA em 16; pai #1016274 espelha 11. Não preencher lacunas nem renumerar terceiros. Nenhum deslocamento de tarefa existente.

Antes de qualquer escrita, renovar contexto/pai/filhas/versão/grafo e leitura completa do Sequencing. Colisão ou mudança material exige conciliar a prévia, sem escolher outro bloco silenciosamente.

## Revisão e publicação

A revisão de escrita foi aplicada às descrições completas: contextos separados de evidências técnicas, condições observáveis por operação, nomes de fornecedores, superfícies/estados visuais e limites sem receita de implementação. Os dois pareceres sustentam os cortes e as horas, sem constituir aprovação do responsável.

O responsável corrigiu as estimativas para 3h / 2h / 2h / 2h / 1h / 2h e aprovou explicitamente o restante e a publicação do conjunto completo: destino, cinco DEV, uma QA, descrições, 12h, campos, dez relações, bloco 11–16/âncora 11 e DOCX r001. Todas as operações autorizadas foram executadas e conferidas por nova leitura MCP.

| Operação autorizada           | ID/URL conhecido                                                                                                                                                                           | Resultado                                                                                                | Próximo passo                                               |
| ----------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------- |
| Criar D01                     | [#1016351](https://redmine.remsoft.com.br/issues/1016351)                                                                                                                                  | Confirmada: descrição/campos, 3h, Sequencing 11                                                          | Planejamento DEV quando fornecedores estiverem disponíveis. |
| Criar D02                     | [#1016352](https://redmine.remsoft.com.br/issues/1016352)                                                                                                                                  | Confirmada: descrição/campos, 2h, Sequencing 12                                                          | Aguardar D01.                                               |
| Criar D03                     | [#1016353](https://redmine.remsoft.com.br/issues/1016353)                                                                                                                                  | Confirmada: descrição/campos, 2h, Sequencing 13                                                          | Aguardar D01.                                               |
| Criar D04                     | [#1016354](https://redmine.remsoft.com.br/issues/1016354)                                                                                                                                  | Confirmada: descrição/campos, 2h, Sequencing 14                                                          | Aguardar D01.                                               |
| Criar D05                     | [#1016355](https://redmine.remsoft.com.br/issues/1016355)                                                                                                                                  | Confirmada: descrição/campos, 1h, Sequencing 15                                                          | Aguardar D01.                                               |
| Criar QA                      | [#1016356](https://redmine.remsoft.com.br/issues/1016356)                                                                                                                                  | Confirmada: descrição/campos, 2h, Sequencing 16                                                          | Aguardar as cinco DEV.                                      |
| Criar dez relações blocks     | Relações #905–#914; filhas #1016351–#1016356; fornecedor #1016293                                                                                                                          | Confirmadas pelos endpoints; grafo de 22 issues/31 relações acíclico, 21 relações anteriores preservadas | Sem pendência de publicação.                                |
| Numerar filhas 11–16 e pai 11 | Pai #1016274; filhas #1016351–#1016356                                                                                                                                                     | Bloco integral confirmado; nenhuma renumeração alheia                                                    | Sem pendência de publicação.                                |
| Anexar DOCX r001 à QA         | [Anexo #3363](https://redmine.remsoft.com.br/attachments/download/3363/1016274%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx), [QA #1016356](https://redmine.remsoft.com.br/issues/1016356) | Nome, identidade, descrição e 20.741 bytes confirmados; fonte local com 25 CT equivalentes               | Executar futuramente na QA.                                 |
| Materializar task.md por ID   | Seis arquivos listados abaixo                                                                                                                                                              | Concluída após conferência integral remota                                                               | Planejamento/execução nas etapas próprias.                  |

## Resultado consolidado e pendências

Publicado e conferido: cinco DEV (10h) e uma QA (2h), total de 12h, todas New, com bloco 11–16 e pai espelhando 11. Descrições/campos correspondem ao conjunto aprovado com as horas corrigidas pelo responsável. Não foram alterados status, conteúdo humano, campos ou anexos anteriores de outras issues; as 21 relações anteriores foram preservadas.

| Ref. | Issue publicada                                                                          | Arquivo materializado                                                |
| ---- | ---------------------------------------------------------------------------------------- | -------------------------------------------------------------------- |
| D01  | [#1016351 — Histórico por mês e detalhes](https://redmine.remsoft.com.br/issues/1016351) | [task.md](../tasks/dev-1016351-historico-por-mes-e-detalhes/task.md) |
| D02  | [#1016352 — Pesquisa e filtros](https://redmine.remsoft.com.br/issues/1016352)           | [task.md](../tasks/dev-1016352-pesquisa-e-filtros/task.md)           |
| D03  | [#1016353 — Cadastro classificado](https://redmine.remsoft.com.br/issues/1016353)        | [task.md](../tasks/dev-1016353-cadastro-classificado/task.md)        |
| D04  | [#1016354 — Edição de transações](https://redmine.remsoft.com.br/issues/1016354)         | [task.md](../tasks/dev-1016354-edicao-de-transacoes/task.md)         |
| D05  | [#1016355 — Exclusão confirmada](https://redmine.remsoft.com.br/issues/1016355)          | [task.md](../tasks/dev-1016355-exclusao-confirmada/task.md)          |
| QA   | [#1016356 — Gestão de transações](https://redmine.remsoft.com.br/issues/1016356)         | [task.md](../tasks/qa-1016356-gestao-de-transacoes/task.md)          |

Sem pendência de publicação. O início das DEV continua dependente de F01/F02 implementadas e verificadas, atualmente New. Não há implementação nem QA executada neste fluxo. Próximo item do catálogo para slicing: Assistente de consulta financeira, pai #1016276.
