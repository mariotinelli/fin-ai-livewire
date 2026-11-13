# Condições de teste

Pai: Dashboard financeiro — #1016275.
Projeto: FinAi (65224). Versão: Livewire (20359).
Revisão: r001, prévia de 13/11/2026. Condições não executadas.

## Contexto

Executar pela Visão geral real do titular, com F04 e F06 implementadas/verificadas e, transitivamente, F01/F02 disponíveis. As tarefas fornecedoras publicadas estão New; publicação não prova capacidade pronta. A QA usa formulário, histórico, detalhes e chat reais existentes desses fornecedores, sem reconstruí-los nem repetir suas campanhas completas.

Preparar homologação com contas confirmadas A/B, conta pendente e visitante, registros excluídos e dados distintos de outra conta, relógio em America/Sao_Paulo e falhas reversíveis de leitura/carregamento e mutação. Administração/suporte não ganham visão financeira de terceiros. Dados/controles, registro de evidências e reteste focalizado integram a QA; espera por serviço/fornecedor fica separada.

Fixar hoje em 13/11/2026 para a base: receitas de A Salário R$ 1.000,10 em 30/09/2026 e Freelance R$ 200,20 em 05/11/2026; despesas Alimentação R$ 50,05 em 01/11/2026, Transporte R$ 25,10 em 10/11/2026, Moradia R$ 30,15 em 31/10/2026 e Lazer R$ 10,00 em 01/10/2026. Saldo geral R$ 1.085,00; novembro receitas R$ 200,20/1 e despesas R$ 75,15/2, resultado R$ 125,05; outubro receitas R$ 0,00/0 e despesas R$ 40,15/2, resultado -R$ 40,15; setembro receita R$ 1.000,10/1 sem despesas. Usar agosto de 2026 sem registros e uma conta sem registros. Repor a base entre cenários que a alteram.

Preparar adicionalmente meses com receitas/despesas iguais, empates de data/criação e mais de cinco registros, descrições/valores extensos, registros cuja criação/edição ocorra em mês diferente da data financeira e mais de 50 registros para reconhecer que Ver todas abre o histórico completo. Resultados esperados desses conjuntos são calculados previamente.

Visual V01: docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip, entrada index.html; #overview, .stats, .stat-card, #balance, #income, #expense, #income-count, #expense-count, #month-wrap/#month, #graph, #chart-month, #month-result, #recent, #new-transaction, link Ver todas e .assistant-teaser/#open-chat. Considerar a ordem final das regras e DESIGN-HANDOFF.md, sobre F01. Dados persistidos por titular, estados verdadeiros e chat real substituem armazenamento local, simulação e dados demonstrativos do protótipo.

Comparar em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080 e transições 767/768px e 1024/1025px. Registrar resultado/evidência por CT, defeitos e reteste dos cenários afetados.

## CT-001 — Entrada e acesso financeiro

Verificação: Abrir a Visão geral pela navegação e por referência direta como A, visitante e conta pendente; repetir após alteração de e-mail que retire confirmação.

Resultado esperado: Titular confirmado acessa seu dashboard real; visitante e conta pendente não consultam finanças. As funções não financeiras permanecem disponíveis conforme F02 e nenhuma referência amplia acesso.

Origem no requisito: Atores e permissões; R1; CA09.

## CT-002 — Saldo acumulado próprio

Verificação: Com a base, consultar saldo e comparar com receitas menos despesas de todo o histórico. Incluir registros excluídos e de B para conferir que ficam fora.

Resultado esperado: A vê R$ 1.085,00; excluídos e dados alheios não entram. Não existe saldo inicial separado ou dado demonstrativo.

Origem no requisito: R1, R2; CA01, CA10.

## CT-003 — Saldo zero e negativo

Verificação: Usar conta sem registros e, na base A, acrescentar por F04 uma despesa de R$ 1.500,00.

Resultado esperado: Sem registros, saldo real R$ 0,00. A despesa leva o saldo da base a -R$ 415,00, com sinal/identificação legíveis, sem limitar a zero. Cancelamento/falha de cadastro não aplica o efeito.

Origem no requisito: R2, R8, R9; CA01, CA06, CA07.

## CT-004 — Mês corrente e data financeira

Verificação: Abrir o dashboard e selecionar novembro, outubro e setembro da base. Usar registros criados/editados em mês diferente da sua data financeira. Neste cenário adicional, preparar receita de R$ 300,00 em 05/11/2025 e alternar novembro de 2025 e 2026 para conferir que o ano também restringe o recorte; repor a base depois.

Resultado esperado: Inicializar em mês/ano correntes de America/Sao_Paulo. Somas e contagens são separadas por tipo e data financeira, não por criação/edição; novembro de 2026 tem R$ 200,20/1 receita e R$ 75,15/2 despesas, outubro de 2026 R$ 0,00/0 e R$ 40,15/2. No cenário adicional, novembro de 2025 tem somente R$ 300,00/1 receita e R$ 0,00/0 despesa, sem misturar o mesmo mês de outro ano.

Origem no requisito: R3, R5, R9; CA02, CA10.

## CT-005 — Troca de período e independência de filtros

Verificação: Trocar mês/ano no dashboard após aplicar descrição/tipo/categoria/mês no histórico F04. Conferir saldo e recentes antes/depois e testar relógio próximo à virada de dia/mês em São Paulo.

Resultado esperado: Apenas totais, contagens, comparação e resultado mensal mudam com o seletor. Saldo/recentes continuam sobre todo o histórico próprio, sem herdar filtros F04 ou fuso UTC. Mês sem registros não cria nem prevê transações.

Origem no requisito: R2, R5, R6; CA01, CA02, CA04, CA10.

## CT-006 — Comparação e resultado mensal

Verificação: Conferir base de novembro/outubro/setembro, mês com somente despesas, mês com receitas/despesas iguais e mês vazio.

Resultado esperado: Comparação usa os mesmos totais dos cartões e declara o mês; resultado é receita menos despesa: R$ 125,05 em novembro e -R$ 40,15 em outubro. Igualdade, zero e ausência de um tipo mantêm rótulos/valores corretos e apresentação sem engano ou falha visual.

Origem no requisito: R3, R4, R9; CA03, CA10.

## CT-007 — Conta sem dados e mês vazio

Verificação: Comparar conta sem qualquer registro com A em mês vazio.

Resultado esperado: Conta vazia mostra saldo/totais reais zero, contagens zero, orientação e ação funcional de primeiro cadastro. Em mês vazio de A, só os dados mensais ficam zero/vazios; saldo e recentes mantêm todo o histórico. Não inventar transações.

Origem no requisito: R2–R6, R9; CA01, CA03, CA07.

## CT-008 — Cinco recentes e ordem estável

Verificação: Com mais de cinco registros em vários meses, selecionar outros meses e conferir empates de data/criação e excluídos.

Resultado esperado: Até cinco registros próprios de todo o histórico, na ordem F04: data financeira decrescente, criação mais recente primeiro na mesma data e desempate estável. Mês escolhido não filtra recentes; registros excluídos e alheios ficam fora.

Origem no requisito: R1, R5, R6; CA04, CA10.

## CT-009 — Detalhes integrais

Verificação: Abrir um recente com descrição/valor extensos no desktop e celular e conferir todos os campos.

Resultado esperado: Reutilizar detalhes F04 próprios com tipo, valor, descrição, categoria e data integrais, inclusive campos resumidos na linha móvel. Sinal e identificação textual distinguem tipo além da cor, sem controles encobertos.

Origem no requisito: R6, R7, R9, R10; CA04, CA11.

## CT-010 — Histórico completo sem filtros anteriores

Verificação: Aplicar em F04 descrição, tipo, categoria e mês restritivos, retornar ao dashboard e usar Ver todas. Usar conjunto maior que cinco e que 50 registros.

Resultado esperado: Abrir F04 com todos os quatro filtros removidos e acesso a todo o histórico próprio, sem herdar mês do dashboard ou limite de cinco recentes. Reconhecer o conjunto completo pela contagem/paginação fornecidas por F04.

Origem no requisito: R5, R7; CA05.

## CT-011 — Cadastro pela Visão geral

Verificação: Acionar Nova transação e salvar receita/despesa em mês selecionado e em outro mês, usando o formulário real F04; repetir cancelamento, fechamento e falha.

Resultado esperado: Preservar formulário/regras F04. Após sucesso, atualizar saldo, totais/contagens, comparação/resultado e recentes sem novo login: registro fora do mês altera saldo e seu próprio período, sem alterar indevidamente o recorte atual. Cancelar/fechar/falhar não muda valores nem apresenta sucesso falso.

Origem no requisito: R7–R9; CA06, CA07, CA10.

## CT-012 — Edição e exclusão pelos detalhes

Verificação: Abrir recente, editar valor/tipo/data/categoria por F04 e excluir outro após confirmação. Comparar também cancelar revisão/exclusão e falha de mutação.

Resultado esperado: Ações são as reais de F04. Após sucesso, recalcular saldo, dados mensais, comparação/resultado e recompor recentes com os registros atuais na mesma sessão. Cancelamento/falha preserva valores anteriores; exclusão deixa o conjunto ativo.

Origem no requisito: R1, R6–R9; CA04, CA06, CA10.

## CT-013 — Atualização conforme o mês do registro

Verificação: No mês atual selecionado, criar/editar/excluir registro de mês passado e alterar data de registro entre meses.

Resultado esperado: Saldo geral e recentes refletem o conjunto atual; totais/contagens/comparação do recorte só mudam quando a data financeira pertencer a ele. Ao selecionar o outro mês, seus dados atuais aparecem corretamente, sem novo login.

Origem no requisito: R2–R6, R8; CA01–CA04, CA06.

## CT-014 — Carregamento e falha inicial

Verificação: Introduzir latência e provocar falha ao obter saldo, cartões, comparação ou recentes, depois tentar novamente.

Resultado esperado: Identificar carregamento e indisponibilidade com nova tentativa; não mostrar zero/vazio de conveniência, registro fictício ou sucesso. Após recuperação, mostrar dados reais do titular.

Origem no requisito: R1, R9; CA07, CA08, CA10.

## CT-015 — Falha ao mudar o mês

Verificação: Carregar um mês conhecido, selecionar outro e falhar a leitura; depois restabelecer e tentar novamente.

Resultado esperado: Identificar indisponibilidade do recorte solicitado. Não atribuir valores/contagens/comparação do mês anterior ao mês novo nem substituir falha por zero real. Recuperação apresenta o mês escolhido com seus dados corretos.

Origem no requisito: R3–R5, R9; CA02, CA03, CA08.

## CT-016 — Isolamento e troca de conta

Verificação: Com A/B, comparar todos os indicadores/recentes, acessar referências de detalhes alheios, trocar de conta e tentar visão de terceiros como administração/suporte.

Resultado esperado: Cada uma vê apenas seus dados atuais e ações permitidas. Troca de conta não reutiliza resultados/cache/contexto da anterior; referências ou privilégios não concedem visão financeira de terceiro.

Origem no requisito: Atores e permissões; R1; CA09, CA10.

## CT-017 — Convite funcional ao assistente

Verificação: Reconhecer a área de convite e acioná-la; enviar consulta no chat real F06. Provocar indisponibilidade do serviço e observar o tratamento real do destino.

Resultado esperado: Abrir a conversa própria real, com identidade/composição do design e estados verdadeiros de F06. Não há destino futuro, rótulo simulado, resposta inventada ou promessa de que a integração já funcionou quando falhou.

Origem no requisito: R10; CA12.

## CT-018 — Fidelidade visual e controles

Verificação: Comparar V01 com a Visão geral completa nas nove dimensões/transições do contexto, usando dados/valores extensos e estados de normal, foco, carregamento, vazio, erro e retomada; usar mouse/teclado e lateral recolhida quando disponível.

Resultado esperado: Preservar cabeçalho, seletor, cartões, comparação, lista, ações e convite, hierarquia, superfícies, cores/tipografia/espaços sobre F01. Valores, contagens, sinais, categorias e rótulos permanecem legíveis; detalhes expõem campos resumidos no celular. Manter foco e ações alcançáveis sem sobreposição ou rolagem horizontal, sem textos de armazenamento local/simulação. Comparação, não só captura ou ausência de erro, comprova fidelidade.

Origem no requisito: R9, R10; CA11, CA12.

## CT-019 — Jornada integrada

Verificação: Pela Visão geral, conferir saldo, selecionar mês/ano, comparar resultado, abrir recente/detalhes, cadastrar, editar/excluir, consultar todo o histórico e acessar o assistente. Confrontar os resultados atuais entre os canais.

Resultado esperado: Dashboard conclui seu fluxo com F04/F06 reais disponíveis e dados próprios coerentes sem novo login, inclusive após mutações. A QA não depende do registro por IA F07; essa Feature verificará os efeitos dos registros que introduzir.

Origem no requisito: R1–R10; CA01–CA12.
