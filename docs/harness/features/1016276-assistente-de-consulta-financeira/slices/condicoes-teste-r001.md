# Condições de teste

Pai: Assistente de consulta financeira — #1016276.
Projeto: FinAi (65224). Versão: Livewire (20359).
Revisão: r001, prévia de 13/11/2026. Condições não executadas.

## Contexto

Executar pela navegação própria e pelo chat real da aplicação, com IA real configurada em homologação, F04 implementada/verificada e, transitivamente, F01/F02 disponíveis. Publicação de tarefas New não comprova disponibilidade. O provedor não foi chamado neste slicing; sua configuração operacional e o consumo necessário à QA precisam estar disponíveis na execução. Fakes podem apoiar verificações automatizadas, mas não substituem a interpretação e resposta reais exigidas nesta QA.

Usar contas confirmadas A/B com dados distintos, conta pendente e visitante, além de perfis administrativos/de suporte para verificar a ausência de acesso a terceiros. Preparar uma conta sem movimentações, histórico extenso de mensagens próprias, duas sessões/navegadores da mesma conta, relógio controlável e falhas reversíveis de carregamento, salvamento de mensagem, IA, consulta financeira e salvamento da resposta. Preparação e reteste focalizado integram a estimativa de QA; espera por serviço/fornecedor indisponível não é esforço ativo.

Para números de referência, fixar hoje em 13/11/2026, America/Sao_Paulo, e preparar em A: receita Salário de R$ 1.000,10 em 30/09/2026; receita Freelance de R$ 200,20 em 05/11/2026; despesa Alimentação de R$ 50,05 em 01/11/2026; despesa Transporte de R$ 25,10 em 10/11/2026; despesa Moradia de R$ 30,15 em 31/10/2026; despesa Lazer de R$ 10,00 em 01/10/2026. Saldo geral: R$ 1.085,00. Novembro: receitas R$ 200,20/1 registro; despesas R$ 75,15/2 registros. Outubro: receitas R$ 0,00/0; despesas R$ 40,15/2. Repor a base entre condições que alteram registros; cenários de empate, hoje/ontem e limites de intervalo usam dados adicionais próprios, com resultados calculados previamente.

Manter o catálogo aprovado de F04: receitas Salário, Freelance, Rendimentos, Outras receitas; despesas Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras, Outras despesas. Valores somente mencionados em mensagens e dados de B não entram nos cálculos de A.

Visual V01: docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip, entrada index.html, #assistant, .chat-top, #messages, .message, #chat-form, #chat-input, #send-message, .suggestions e .chat-guide; considerar a ordem final das regras e DESIGN-HANDOFF.md. Comparar em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080 e transições 767/768px e 1024/1025px, usando a base F01. IA real, persistência por titular, data/hora e estados aprovados substituem os rótulos, armazenamento local e comportamento por regras do protótipo.

F05 integra seu próprio convite ao chat pronto e F07 acrescenta registros com confirmação no mesmo chat. Não são condições futuras para encerrar F06. Registrar resultado/evidência por CT; defeitos e condições não executadas permanecem identificados.

## CT-001 — Navegação e autorização do chat

Verificação: Abrir Assistente pela navegação e por referência direta como A, visitante e conta pendente. Repetir após mudança de e-mail que retire a confirmação, preservando as funções não financeiras autorizadas.

Resultado esperado: A abre seu chat real; visitante e conta pendente não acessam histórico, contexto, respostas ou consultas financeiras. O acesso não depende do convite do dashboard futuro.

Origem no requisito: Atores e permissões; R8, R12; CA12, CA14.

## CT-002 — Envio pelo botão, teclado e sugestões

Verificação: Enviar pergunta válida pelo botão, por Enter e por sugestão de saldo, totais e recentes, em tentativas distintas. Usar Shift+Enter para compor mensagem com quebra de linha.

Resultado esperado: Cada envio aceito aparece uma única vez, com autoria e processamento real. Enter envia; Shift+Enter conserva a quebra de linha sem disparar envio; botão e sugestões permanecem utilizáveis. A conversa continua legível.

Origem no requisito: R10–R12; CA02, CA03, CA14.

## CT-003 — Limites e preservação da composição

Verificação: Tentar mensagem vazia, apenas espaços, mensagem de 500 caracteres e mensagem de 501 caracteres, inclusive por colagem.

Resultado esperado: Vazio/espaços e excesso de 500 caracteres são recusados com orientação. Uma mensagem válida no limite é preservada integralmente; não truncar silenciosamente dados acima do limite nem apresentá-los como enviados.

Origem no requisito: Fluxos alternativos; R11; CA02.

## CT-004 — Saldo real de todo o histórico

Verificação: Com a base A, perguntar pelo saldo com variações compreensíveis, como “qual é meu saldo?” e “quanto tenho no total?”. Incluir em mensagem número financeiro divergente, sem registrá-lo em F04.

Resultado esperado: A IA real consulta os registros atuais e responde em pt-BR com R$ 1.085,00, identificando saldo geral/acumulado de todo o histórico. Números do chat não alteram a resposta nem viram transações. A fórmula comum ao requisito do dashboard não exige que o dashboard esteja entregue.

Origem no requisito: R2, R3, R5–R9; CA03, CA04, CA12.

## CT-005 — Retomada e conversa única

Verificação: Enviar e receber mensagens, recarregar, sair/entrar e abrir a mesma conta em outro navegador. Na primeira utilização, abrir a conta em dois navegadores e verificar a continuidade ao alterná-los.

Resultado esperado: Retomar uma única conversa contínua própria, com mensagens salvas, autoria, ordem e data/hora reconhecíveis em America/Sao_Paulo. Não oferecer criação, seleção, renomeação ou exclusão manual de múltiplas conversas.

Origem no requisito: R1, R8; CA01.

## CT-006 — Falha ao carregar o histórico

Verificação: Provocar falha reversível no carregamento de uma conversa que possui mensagens e tentar novamente após restabelecer o serviço.

Resultado esperado: Informar indisponibilidade com possibilidade de nova tentativa; não apresentar conversa vazia como primeira utilização nem mensagens de outra conta. Após recuperação, retomar o histórico salvo.

Origem no requisito: Fluxos alternativos; R1, R10; CA10, CA11.

## CT-007 — Falha ao salvar a mensagem

Verificação: Compor uma pergunta e falhar seu salvamento antes da consulta; depois permitir nova tentativa. Conferir o histórico após recarregar.

Resultado esperado: Não apresentar a mensagem como persistida quando seu salvamento falhou. Preservar o texto ainda não enviado, quando aplicável, e permitir nova tentativa coerente, sem duplicar mensagem já confirmada como salva.

Origem no requisito: Fluxos alternativos; R1, R10; CA11.

## CT-008 — Falhas de IA e de consulta financeira

Verificação: Provocar separadamente indisponibilidade da IA e erro da consulta financeira em perguntas de saldo, totais e recentes. Restabelecer e tentar novamente.

Resultado esperado: Comunicar o problema; não substituir falha por zero, ausência falsa, valores inventados ou atividade simulada. Manter mensagens já salvas e permitir recuperação sem duplicá-las nem gravar transação financeira.

Origem no requisito: Fluxos alternativos; R2, R7, R9, R10; CA03, CA10, CA11.

## CT-009 — Falha ao preservar a resposta

Verificação: Permitir a interpretação e a consulta, mas provocar falha ao salvar a resposta. Recarregar ou retornar à conversa e usar a recuperação disponível.

Resultado esperado: Distinguir resultado processado de resposta efetivamente salva. Não afirmar que a conversa foi preservada com sucesso; permitir recuperação/nova tentativa coerente, sem duplicar mensagens já confirmadas e sem fabricar resposta histórica.

Origem no requisito: Fluxos alternativos; R1, R10; CA11.

## CT-010 — Processamento e repetição de envio

Verificação: Com latência real/controlada, tentar repetir clique, Enter ou sugestão enquanto aguarda resposta e conferir o histórico após concluir. Repetir após uma falha comunicada.

Resultado esperado: Impedir novo envio pela interface até conclusão ou falha comunicada. A mesma tentativa não duplica mensagem salva; a conversa permanece legível e permite nova tentativa quando liberada, preservando o estado confirmado.

Origem no requisito: Fluxos alternativos; R10, R11; CA02, CA11.

## CT-011 — Totais mensais separados

Verificação: Com a base A, perguntar receitas/despesas do mês atual, mês passado e setembro de 2026, usando variações de linguagem e pedido dos dois tipos.

Resultado esperado: Responder com somas e contagens separadas por tipo, declarar o mês utilizado e usar somente dados de A. Novembro: receita R$ 200,20/1 e despesa R$ 75,15/2; outubro: receita R$ 0,00/0 e despesa R$ 40,15/2; setembro inclui receita R$ 1.000,10/1.

Origem no requisito: R2–R5, R7; CA03, CA05, CA06.

## CT-012 — Categoria e vocabulário comum

Verificação: Consultar totais com categorias de receita e despesa existentes, incluindo Outras receitas e Outras despesas com dados preparados. Perguntar por categoria inexistente, incerta ou incompatível com o tipo solicitado.

Resultado esperado: Para categoria compreendida com segurança, declarar seu nome aprovado, tipo, período, soma e quantidade corretos. Referência inexistente/incerta/incompatível exige esclarecimento antes de resultado numérico; não criar categoria nem classificá-la silenciosamente.

Origem no requisito: R3, R5, R6; CA05, CA08.

## CT-013 — Hoje, ontem e dia explícito

Verificação: Preparar transações próprias em hoje/ontem e no dia 10/11/2026. Perguntar receitas/despesas desses dias, com e sem categoria, inclusive perto da virada do dia em São Paulo.

Resultado esperado: Usar o dia compreendido em America/Sao_Paulo, declarar data, tipo/categoria quando houver, soma e contagem. O recorte de 10/11/2026 da base contém despesa Transporte de R$ 25,10/1, sem incluir registros de outros dias.

Origem no requisito: R3–R5; CA05, CA06.

## CT-014 — Intervalos inclusivos e inválidos

Verificação: Consultar intervalo explícito de 31/10/2026 a 05/11/2026 com registros em ambas as bordas e fora delas, filtrando tipo/categoria quando solicitado. Tentar intervalo invertido, data inexistente e referência temporal insegura.

Resultado esperado: Incluir datas inicial/final. Na base A e nesse intervalo, receitas R$ 200,20/1 e despesas R$ 80,20/2. Recortes inválidos ou inseguros pedem esclarecimento antes de apresentar resultado, sem inverter datas ou supor um intervalo silenciosamente.

Origem no requisito: R3–R6; CA05, CA06, CA08.

## CT-015 — Períodos padrão e limites de mês

Verificação: Sem contexto pertinente, perguntar total sem período. Comparar com saldo e recentes. Controlar relógio quando UTC já está em outro dia/mês, mas America/Sao_Paulo ainda não.

Resultado esperado: Totais sem período/contexto usam e declaram o mês corrente de São Paulo; saldo e recentes usam todo o histórico. Não deslocar a data financeira nem aplicar o mês de outro fuso.

Origem no requisito: R3–R5; CA04, CA06, CA07.

## CT-016 — Cinco últimas movimentações

Verificação: Perguntar pelas últimas movimentações com zero, menos de cinco e mais de cinco registros próprios. Preparar empates de data/criação para conferir a ordem de F04.

Resultado esperado: Apresentar até cinco registros reais de todo o histórico, na ordem de data financeira decrescente, criação mais recente primeiro na mesma data e desempate estável de F04. Informar data, descrição, tipo e valor em BRL. Com mais resultados, indicar o histórico manual real; sem registros, informar ausência sem exemplos inventados.

Origem no requisito: R3–R5, R7; CA06, CA07.

## CT-017 — Recorte válido sem correspondências

Verificação: Consultar totais de mês, dia, intervalo e categoria válidos sem registros; repetir em conta sem movimentações e perguntar saldo/recentes.

Resultado esperado: Totais informam soma/contagem zero e ausência explícita no recorte, quando aplicáveis; saldo sem movimentações é zero geral, e recentes informa ausência. Esses resultados só ocorrem após consulta bem-sucedida, nunca como substituição de falha.

Origem no requisito: Fluxos alternativos; R3–R5, R10; CA04–CA07, CA10.

## CT-018 — Continuação com filtros claros

Verificação: Consultar despesas de Alimentação do mês corrente e continuar “e no mês passado?”. Testar também continuação de uma consulta de dia/intervalo e de receitas, e repetir uma continuação clara após retomar a conversa no navegador.

Resultado esperado: Manter assunto/tipo/categoria claros e mudar apenas o recorte solicitado, declarando-o; consultar dados atuais novamente. Não exigir repetir a pergunta inteira nem mudar tipo/categoria sem fundamento.

Origem no requisito: R1, R3–R7; CA01, CA05, CA08, CA09.

## CT-019 — Esclarecimento e contexto incerto

Verificação: Enviar pergunta sem tipo/recorte materialmente compreensíveis, categoria incerta ou intervalo inválido; responder ao pedido de esclarecimento com a informação que falta. Após trocar de assunto, usar referência que possa apontar para mais de um assunto antigo.

Resultado esperado: Pedir esclarecimento antes de número, completar a consulta pendente com a resposta e aplicar o recorte confirmado sem exigir repetir tudo. Contexto antigo/ambíguo não é tomado como certeza; números mencionados na conversa não viram movimentações.

Origem no requisito: Fluxos alternativos; R4, R6; CA08.

## CT-020 — Dados atuais e respostas históricas

Verificação: Consultar saldo/totais/recentes, depois criar, editar valor/tipo/data/categoria e excluir registros manualmente em F04, realizando nova pergunta após cada alteração.

Resultado esperado: Cada resposta nova considera o estado persistido atual e as exclusões, sem usar exclusivamente números antigos. Respostas históricas continuam como foram dadas, com posição, autoria e data/hora reconhecíveis. F07 verifica seus próprios registros por IA futuramente.

Origem no requisito: R6, R7; CA04, CA09.

## CT-021 — Titularidade contra referências e instruções

Verificação: Com A/B, pedir dados/contexto da outra conta, adulterar referências diretas de conversa/mensagem e instruir o assistente a ignorar limites. Trocar de conta e tentar consultas como administração/suporte sobre finanças de terceiros.

Resultado esperado: Histórico, contexto, consultas e respostas continuam limitados ao titular confirmado. Não revelar mensagens, valores ou registros alheios nem conceder acesso por instrução no chat ou privilégios administrativos/de suporte. A segunda conta não reutiliza contexto da primeira.

Origem no requisito: R1, R6, R8; CA01, CA12.

## CT-022 — Limites de consulta e encaminhamento manual

Verificação: Pedir cadastro, edição, exclusão, recomendações de investimento ou consulta externa não suportada; usar a sugestão “Registrar um gasto”. Seguir a orientação de cadastro manual quando aplicável e conferir os registros em F04 antes/depois de conversar.

Resultado esperado: Orientar o limite e as consultas disponíveis, sem falsa conclusão. Pedido/sugestão de registro direciona ao cadastro manual real de F04; o chat não cria, altera ou exclui transações nem mostra proposta/confirmação simulada. Não criar segunda conversa para F07.

Origem no requisito: R9, R12; CA12, CA13.

## CT-023 — Fidelidade visual e histórico extenso

Verificação: Comparar V01 com chat inicial, mensagens longas/próximas do limite, resposta extensa e histórico longo nas nove dimensões e transições do contexto. Usar mouse e teclado, lateral recolhida quando disponível e estados de carregamento, foco, envio, processamento, vazio, ausência de dados, erro e recuperação aplicáveis.

Resultado esperado: Preservar hierarquia, espaços, superfícies, cores e tipografia sobre F01, distinguindo autoria e mantendo data/hora legível. Composição, botão e sugestões permanecem alcançáveis, foco/rolagem legíveis, sem controles cobertos pela navegação ou rolagem horizontal da página. Não exibir rótulos de simulação, armazenamento local, depuração, nomes de ferramentas internas ou configuração do provedor. Comparação visual, não só captura ou ausência de erro, fundamenta o aceite.

Origem no requisito: Dados percebidos; R1, R10–R12; CA01, CA02, CA14.

## CT-024 — Jornada integrada com IA real

Verificação: Pela navegação própria, enviar perguntas de saldo, totais mensais, dia/intervalo e recentes com linguagem variada; continuar contexto, esclarecer ambiguidade, retomar conversa e confrontar os dados após alteração manual. Registrar evidência complementar da integração real sem exibir credenciais.

Resultado esperado: O ciclo usa interpretação por IA real e registros atuais próprios, preserva a conversa única e distingue sucesso, ausência e falha. A navegação própria permite concluir a QA sem convite do dashboard nem registro por IA futuros. Fakes ou interpretação demonstrativa por regras não comprovam esta condição.

Origem no requisito: R1–R12; CA01–CA14.
