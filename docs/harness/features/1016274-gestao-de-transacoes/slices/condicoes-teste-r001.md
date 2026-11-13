# Condições de teste

Pai: Gestão de transações — #1016274.
Projeto: FinAi (65224). Versão: Livewire (20359).
Revisão: r001, prévia de 13/11/2026; condições ainda não executadas.

## Contexto

Executar pela navegação, formulário, histórico e diálogos reais de Transações. A fundação visual F01 e a jornada pessoal F02 precisam estar implementadas e verificadas; a publicação de suas tarefas em New não comprova isso. Usar ambiente de homologação isolado, duas contas pessoais confirmadas A/B, uma conta pendente, visitante e perfis administrativos/de suporte sem acesso adicional às finanças de terceiros. Preparar dados próprios, sem gravar exemplos de demonstração como dados reais.

Preparar pelo menos 101 registros da conta A, em meses e anos diferentes, com receitas/despesas de todas as categorias, datas iguais, instantes de criação iguais para verificar desempate estável, descrição com acentos e caixa variada e descrições contendo literalmente %, _ e !. Preparar registros distintos de B, uma conta sem transações, descrições de 1/120/121 caracteres e valores nos limites. Dados preparados permitem aceitar a consulta antes de existir cadastro; o fluxo integrado final usa cadastro real.

Disponibilizar controle de relógio próximo à virada do dia e do mês em America/Sao_Paulo, falhas reversíveis de leitura/gravação e de obtenção de categorias quando houver essa operação, latência e perda de resposta, e duas sessões da mesma conta para indisponibilidade concorrente. Preparação desses controles faz parte da QA. Mecanismo interno de categorias não cria obrigação de falha remota inexistente.

Visual V01: docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip, entrada index.html, seções #transactions, #month-wrap, #transaction-dialog, #detail-dialog e #delete-dialog; consultar a ordem final das regras visuais e DESIGN-HANDOFF.md. Comparar com a base F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px. Estados adicionais aprovados no requisito usam a mesma linguagem visual. Dados persistidos por titular e regras do requisito substituem armazenamento local e regras demonstrativas do protótipo.

F05/F06/F07 verificam seus canais ao entregá-los. Esta QA termina na gestão manual real, sem aguardar dashboard ou IA e sem reescrever mensagens históricas. Registrar evidências e defeitos por condição; repetir cenários afetados após correção.

## CT-001 — Entrada financeira e restrições

Verificação: Abrir Transações pela navegação e por referência direta como A confirmada, visitante e conta pendente. Tentar as operações financeiras com sessão pendente, inclusive após alteração de e-mail que retire a confirmação.

Resultado esperado: A acessa sua gestão. Visitante e conta pendente não consultam nem alteram finanças; as funções não financeiras de F02 permanecem disponíveis conforme autorização.

Origem no requisito: Atores e permissões; R6; CA10.

## CT-002 — Mês inicial e consulta de outros períodos

Verificação: Abrir a tela sem filtros escolhidos com dados em diferentes meses. Selecionar outro mês, remover o mês e retornar ao mês corrente. Repetir com relógio próximo à virada de mês em São Paulo.

Resultado esperado: A abertura usa o mês corrente em America/Sao_Paulo. Outro mês mostra apenas suas movimentações; sem mês a consulta inclui todo o histórico próprio, inclusive datas antigas. Não há dados demonstrativos.

Origem no requisito: R4, R7, R8; CA03, CA04, CA05, CA12.

## CT-003 — Ordem, contagem e paginação

Verificação: Consultar mais de 50 registros estáveis, navegar anterior/próxima e conferir datas iguais e empates no instante de criação.

Resultado esperado: Cada página mostra até 50 registros, contagem e página atual, com controles quando necessários. A ordem é data da movimentação decrescente, criação mais recente primeiro na mesma data e desempate estável, sem omissões ou repetições entre páginas.

Origem no requisito: R8; CA05.

## CT-004 — Leitura integral dos detalhes

Verificação: Abrir uma linha com descrição de 120 caracteres, maior valor permitido e campos resumidos na listagem móvel; fechar e reabrir os detalhes.

Resultado esperado: Tipo, valor BRL exato, descrição, categoria e data aparecem integralmente nos detalhes. A linha distingue receita/despesa por sinal e identificação além da cor. Campos resumidos não ficam inacessíveis no celular.

Origem no requisito: R2, R9, R12; Dados percebidos; CA06, CA13.

## CT-005 — Catálogo comum e opções sem movimentações

Verificação: Antes da carga histórica do contexto, abrir cadastro nas contas A/B ainda sem registros e alternar receita/despesa. Comparar as opções e procurar ações de manutenção de categorias.

Resultado esperado: Ambas recebem exatamente Salário, Freelance, Rendimentos e Outras receitas para receita; Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras e Outras despesas para despesa. Nomes e acentos são preservados. Não há manutenção, personalização, subcategoria, importação ou nova tela de categorias.

Origem no requisito: R5; CA14, CA15.

## CT-006 — Cadastro e permanência

Verificação: Cadastrar receita e despesa válidas, incluindo 35,90, 1.234,56 e uma data de mês anterior. Conferir no mês adequado ou em todo o histórico, abrir detalhes, voltar à tela e acessar a mesma conta em outro navegador.

Resultado esperado: Cada envio concluído grava uma única transação do titular, com cinco campos exatos e centavos preservados. A data começa em hoje no formulário. Os registros permanecem disponíveis à mesma conta, sem novo login para atualizar a consulta atual.

Origem no requisito: R1, R2, R4, R6, R11; CA01, CA12, CA14.

## CT-007 — Campos obrigatórios e descrição

Verificação: Em criação e edição, omitir separadamente cada um dos cinco campos, tentar tipo inválido, descrição apenas com espaços e textos de 1, 120 e 121 caracteres após retirar espaços nas extremidades.

Resultado esperado: Dados inválidos são recusados com erro associado ao campo e preenchimento corrigível, sem gravação parcial nem truncamento. Descrições válidas preservam o texto após a retirada dos espaços nas extremidades.

Origem no requisito: R1, R3, R9; CA02, CA06.

## CT-008 — Valores brasileiros e limites

Verificação: Em criação e edição, usar 0,01 e 999.999.999,99, além de zero, negativo e 1.000.000.000,00. Digitar e colar 35,901: verificar recusa, sem virar 359,01 ou ser arredondado. Tentar entrada digitada e colada de 35,90 e 1.234,56.

Resultado esperado: Valores positivos até o limite, com até duas casas, preservam exatamente centavos. Zero, negativo, excesso de limite e mais de duas casas são recusados; não são arredondados nem transformados silenciosamente em outro valor. Despesa é representada pelo tipo, sem exigir número negativo.

Origem no requisito: R2; CA02, CA06.

## CT-009 — Datas válidas e fuso

Verificação: Em criação e edição, usar 01/01/1900, hoje e data passada válida; tentar 31/12/1899, data inexistente e amanhã. Controlar o relógio em ambos os lados da virada do dia em São Paulo, inclusive quando a data UTC difere.

Resultado esperado: Aceitar apenas datas reais entre 01/01/1900 e hoje em America/Sao_Paulo, inclusive. Não exigir horário nem deslocar a data financeira informada. O mesmo critério vale no cadastro e na edição.

Origem no requisito: R4, R9; CA03, CA06.

## CT-010 — Compatibilidade da categoria

Verificação: Criar e editar com cada categoria compatível, incluindo as duas opções Outras. Alternar tipo e tentar salvar categoria do tipo anterior, inexistente ou oculta por alteração de referência.

Resultado esperado: A seleção mostra opções compatíveis e a categoria que será salva; valores inexistentes ou incompatíveis são recusados. Histórico, detalhes e filtros apresentam o mesmo vocabulário aprovado.

Origem no requisito: R5, R9; CA02, CA06, CA14.

## CT-011 — Cancelamentos de formulário

Verificação: Preencher criação e edição e usar Cancelar e Fechar em cada uma.

Resultado esperado: Criação não adiciona transação; edição mantém os dados persistidos anteriores. Fechar não equivale a salvar.

Origem no requisito: Fluxos alternativos; CA07.

## CT-012 — Busca literal por descrição

Verificação: Pesquisar trechos de descrições com diferenças de caixa/acentos e com %, _ e !, inclusive fora da primeira página antes da pesquisa.

Resultado esperado: Somente correspondências literais próprias aparecem, sem interpretar os caracteres como curingas. A pesquisa ignora diferenças de caixa e acentos e retorna à primeira página.

Origem no requisito: R7, R8; CA04, CA05.

## CT-013 — Filtros combinados e limpeza

Verificação: Filtrar isoladamente por tipo, categoria e mês; combinar todos com descrição. Alterar cada filtro a partir de outra página. Usar Limpar filtros.

Resultado esperado: Resultados e contagem correspondem à interseção dos filtros próprios e retornam à primeira página quando o recorte muda. Limpar remove descrição, tipo, categoria e mês, passando a todo o histórico. Categorias mantêm os nomes de R5.

Origem no requisito: R5, R7, R8; CA04, CA05, CA14.

## CT-014 — Vazio inicial e recorte sem resultado

Verificação: Abrir Transações em conta sem registros e em conta com registros fora do mês/filtros selecionados.

Resultado esperado: Sem registros, orientar primeiro cadastro e oferecer ação funcional de cadastro. Sem correspondências, informar ausência no recorte e permitir ajuste/limpeza. Não exibir transações fictícias nem tratar falha como vazio.

Origem no requisito: Fluxos alternativos; CA11.

## CT-015 — Edição completa sem cópia

Verificação: Alterar cada um dos cinco campos de transação própria e salvar; trocar tipo e categoria; conferir identificação do mesmo registro, histórico e detalhes.

Resultado esperado: O mesmo registro é atualizado com as regras de criação, sem cópia ou troca de titular. A consulta e os detalhes mostram os dados atuais na sessão, sem novo login.

Origem no requisito: R1–R6, R9, R11; CA02, CA03, CA06, CA12, CA14.

## CT-016 — Salvamento fora do recorte

Verificação: Criar transação em mês diferente do atual e editar data, tipo, categoria ou descrição de modo que deixe de corresponder ao recorte. Usar o mês correto ou limpar o recorte para reencontrar o resultado.

Resultado esperado: Sucesso é informado somente após salvar; a ausência no recorte não parece falha. Filtros permanecem fiéis e a página continua válida; o registro salvo pode ser conferido pelos canais de consulta já entregues.

Origem no requisito: Fluxos alternativos; R8, R9, R11; CA01, CA05, CA06, CA12.

## CT-017 — Confirmação e cancelamento de exclusão

Verificação: Solicitar exclusão nos detalhes, ler o aviso e usar Cancelar e Fechar antes de confirmar em tentativas distintas.

Resultado esperado: O diálogo explica saída do histórico e dos totais e ausência de desfazer. Nenhum registro ou efeito financeiro é removido sem confirmação explícita.

Origem no requisito: R10; CA07, CA08.

## CT-018 — Exclusão persistida e página válida

Verificação: Confirmar exclusão própria, incluindo o único item da última página. Reabrir a consulta em outro navegador e tentar os detalhes pelo identificador anterior.

Resultado esperado: O registro deixa histórico e detalhes ativos, não reaparece após retorno e não oferece desfazer. A consulta continua em página válida. O dado excluído fica fora do conjunto financeiro ativo; os indicadores e consultas de F05/F06 serão verificados por essas Features.

Origem no requisito: R8, R10, R11; CA05, CA08, CA12.

## CT-019 — Falhas de leitura e categorias

Verificação: Provocar falha reversível ao carregar histórico/detalhes e ao pesquisar/aplicar filtros. Quando o mecanismo usado obtiver categorias por operação falhável, falhar essa operação na abertura/troca do formulário.

Resultado esperado: Apresentar erro e possibilidade de tentar novamente, sem aparentar histórico ou catálogo vazio. Não permitir categoria improvisada nem exibir dados de outra conta. Na recuperação, mostrar dados reais.

Origem no requisito: Fluxos alternativos; R5; CA09, CA11, CA15.

## CT-020 — Falhas de gravação e retomada

Verificação: Provocar falha reversível ao criar, editar e excluir e tentar novamente depois de restabelecer a operação.

Resultado esperado: Não apresentar sucesso nem alteração parcial na falha. Manter o preenchimento necessário à retomada enquanto o formulário estiver aberto; preservar o registro na exclusão não concluída. Reconciliar o estado real quando o resultado estiver incerto.

Origem no requisito: Fluxos alternativos; R11; CA09.

## CT-021 — Processamento, resposta incerta e registros iguais

Verificação: Com latência, tentar disparar repetidamente o mesmo envio de criação/edição/exclusão. Simular perda de resposta após possível gravação. Depois criar intencionalmente duas transações válidas com dados iguais.

Resultado esperado: Processamento é visível e impede repetição do envio pela interface. Em resposta incerta, consultar o estado atual antes de induzir repetição. Envios intencionais distintos com dados iguais são permitidos e não confundidos com duplicação do mesmo envio.

Origem no requisito: Fluxos alternativos; R9; CA01, CA09.

## CT-022 — Indisponibilidade concorrente

Verificação: Em duas sessões da mesma conta, abrir detalhes/edição/exclusão e remover o registro em uma antes de concluir a ação na outra.

Resultado esperado: Informar indisponibilidade e atualizar a consulta. Não recriar silenciosamente registro removido, não apresentar atualização/exclusão inexistente como concluída e não revelar dados alheios.

Origem no requisito: Fluxos alternativos; R9; CA06, CA09, CA10.

## CT-023 — Titularidade em todos os acessos

Verificação: Com A/B, tentar histórico, filtros, detalhes, edição e exclusão por identificadores da outra conta, incluindo referência direta e adulteração do titular no cadastro/edição. Sair e trocar de conta; repetir leitura em outro navegador. Como administração/suporte, tentar finanças de terceiros.

Resultado esperado: Consultas e alterações se restringem ao titular autenticado; titularidade não é escolhida nem editada. Nenhuma conta herda dados da sessão anterior ou recebe acesso financeiro de terceiro por privilégio administrativo/de suporte.

Origem no requisito: Atores e permissões; R6; CA01, CA10.

## CT-024 — Fidelidade visual, estados e navegação

Verificação: Comparar V01 com listagem, mês, paginação, busca/filtros, criação/edição, detalhes e confirmação nas nove dimensões e transições do contexto. Exercitar estados normal, foco, carregamento, vazio, validação, erro, sucesso, cancelamento e confirmação aplicáveis, usando mouse e teclado e lateral recolhida quando disponível.

Resultado esperado: Preservar marca, paleta, tipografia, hierarquia, proporções, espaços, bordas, raios e controles da referência sobre F01. Campos, nomes de categorias, valores grandes, descrições longas, mensagens e ações permanecem legíveis e alcançáveis, sem sobreposição ou rolagem horizontal da página. A navegação não encobre conteúdo/foco; campos resumidos no celular são lidos nos detalhes. Não transportar textos de armazenamento local ou simulação. Evidências incluem comparação visual, não somente ausência de erro.

Origem no requisito: R5, R12; CA13, CA14, CA15; dependência visual F01.

## CT-025 — Jornada manual integrada

Verificação: Pela interface, cadastrar receita/despesa, consultar outro mês e todo o histórico, pesquisar, combinar/limpar filtros, navegar páginas, abrir detalhes, editar, cancelar e confirmar exclusão. Reabrir a mesma conta e repetir o confronto de dados com B.

Resultado esperado: O ciclo manual termina com dados reais persistidos, atuais e isolados; cada resultado é conferido no histórico/detalhes sem novo login. A QA de F04 encerra sem depender de dashboard/IA futuros. A preservação de respostas históricas permanece limite do requisito, com verificação no canal correspondente em F06/F07.

Origem no requisito: R6–R11; CA01, CA04–CA12.
