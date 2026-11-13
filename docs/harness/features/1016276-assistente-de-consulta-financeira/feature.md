# Assistente de consulta financeira

## Identidade

- Feature: [#1016276](https://redmine.remsoft.com.br/issues/1016276).
- Projeto: FinAi (65224).
- Versão: Livewire (20359).
- Situação: requisito aprovado; implementação não realizada neste fluxo.
- [Catálogo](../../scopes/2026-11-13-finai-mvp/scope.md).

## Objetivo

Permitir que o titular converse em linguagem natural com IA real para consultar suas finanças registradas, em uma conversa contínua salva por usuário, com respostas baseadas nos dados reais e atuais do sistema.

## Resultado esperado

O usuário consulta saldo, receitas, despesas e últimas movimentações, esclarece recortes quando necessário e continua perguntas usando um contexto compreensível. Ao voltar ao sistema ou trocar de navegador, encontra a mesma conversa. Dados de outras pessoas, números apenas mencionados no chat e respostas antigas não substituem os registros atuais como fonte financeira.

## Atores e permissões

- Titular autenticado e com e-mail confirmado: acessa sua conversa e consulta seus próprios dados.
- Visitantes e contas com e-mail pendente não acessam o chat financeiro, conforme F02.
- Administração e suporte não recebem acesso às conversas ou dados financeiros de terceiros por esta Feature.

## Histórias de usuário

1. Como titular, quero perguntar sobre meu saldo e movimentações com minhas palavras para consultar os dados sem montar filtros manualmente.
2. Como titular, quero perguntar “e no mês passado?” após uma consulta para continuar o raciocínio sem repetir o assunto inteiro.
3. Como titular, quero retomar minha conversa salva ao voltar para reconhecer o que perguntei e recebi como resposta.
4. Como titular, quero que o assistente peça esclarecimentos e informe falhas para não confundir interpretação incerta ou indisponibilidade com resultados financeiros.

## Fluxo principal

1. Abrir Assistente pela navegação própria da aplicação. Carregar a única conversa contínua do titular, com autoria, ordem e data/hora reconhecíveis.
2. Na primeira utilização, apresentar orientação das consultas disponíveis e sugestões de perguntas conforme o design fornecido.
3. Escrever uma mensagem ou escolher uma sugestão. Ao enviar, registrar a mensagem na conversa e indicar o processamento real; não permitir envios repetidos enquanto a resposta estiver em processamento.
4. Interpretar a intenção por IA real. Resolver tipo, período e categoria usando a mensagem e o contexto claro da própria conversa. Se faltar uma informação material, pedir esclarecimento antes de apresentar resultado numérico.
5. Consultar os registros atuais do titular com o recorte compreendido e responder em português brasileiro, informando o período e os filtros utilizados quando aplicáveis.
6. Salvar a resposta com autoria e momento, mantendo a conversa disponível após recarregar, sair/entrar ou acessar a mesma conta em outro navegador.
7. Ao receber uma continuação clara, como “e no mês passado?”, manter o assunto e os filtros pertinentes e consultar novamente os dados atuais para o novo período.

## Fluxos alternativos e exceções

- Mensagem vazia ou formada apenas por espaços não é enviada. Para revisão, propõe-se manter o limite de 500 caracteres do design; acima dele, orientar a redução sem truncar silenciosamente.
- Pergunta ambígua quanto a tipo, categoria, período ou referência contextual gera pedido de esclarecimento; a resposta do usuário completa a consulta pendente sem exigir repetição de toda a pergunta.
- Um recorte válido sem registros gera resposta explícita de ausência de movimentações, com total e contagem zero quando aplicáveis. Isso é diferente de falha ao consultar os dados.
- Categoria inexistente ou referência sem correspondência segura exige esclarecimento; o assistente não cria categorias nem apresenta uma suposição como classificação confirmada.
- Se o histórico da conversa não puder ser carregado, informar indisponibilidade e permitir nova tentativa; não apresentar uma conversa vazia como se a conta nunca tivesse mensagens.
- Falha ao salvar uma mensagem não a apresenta como persistida. Preservar o texto ainda não enviado, quando aplicável, e permitir nova tentativa sem duplicar um envio já confirmado.
- Falha de IA ou da consulta financeira gera uma indicação clara, sem valores inventados, zeros de conveniência ou mensagem falsa de conclusão. A consulta pode ser tentada novamente sem duplicar mensagens já salvas ou qualquer registro financeiro.
- Falha ao persistir a resposta não a apresenta como conversa salva com sucesso. Ao retomar, distinguir o resultado de processamento de uma resposta efetivamente preservada e permitir recuperação ou nova tentativa coerente.
- Um pedido fora das consultas deste MVP recebe explicação do limite e orientação das opções disponíveis, sem fingir uma operação concluída.
- Um pedido de registro financeiro não cria transação nesta Feature. O registro conversacional com propostas e confirmação pertence a F07; até sua integração, orientar o cadastro manual real de F04.
- Sair de uma conta e entrar em outra carrega apenas a conversa da segunda, sem mensagens, contexto ou resultados da primeira.

## Regras de negócio

**R1 — Conversa única persistida.** Cada titular tem uma conversa contínua, retomada após novos acessos e em outro navegador. Preservar mensagens do usuário e do assistente, autoria, ordem e data/hora. Não oferecer criação, seleção, renomeação ou exclusão manual de múltiplas conversas nesta entrega.

**R2 — IA real.** A interpretação e interação utilizam IA real. O assistente demonstrativo por regras do design não cumpre o requisito. Provedor, modelo e mecanismos internos não são decisões funcionais deste documento.

**R3 — Consultas incluídas.** Atender: saldo geral de todo o histórico; somas e contagens separadas de receitas/despesas por mês, dia ou intervalo informado, com filtro opcional de categoria; e até cinco últimas movimentações. Interpretar expressões compreensíveis como este mês, mês passado, hoje, ontem e datas/intervalos explícitos. Usar o catálogo de categorias e as regras de dados de F04.

**R4 — Padrões temporais.** Totais sem período explícito e sem continuação contextual clara usam o mês corrente, que deve ser declarado. Saldo geral e últimas movimentações usam todo o histórico. Interpretar dias, meses e referências relativas em America/Sao_Paulo, conforme F04. Consultas por intervalo incluem as datas inicial e final. Intervalo invertido ou interpretação insegura requer esclarecimento.

**R5 — Recortes transparentes.** Respostas de totais informam tipo, período, categoria quando houver, soma e quantidade de registros. Consultas de saldo identificam o caráter geral/acumulado. Últimas movimentações apresentam até cinco registros reais, na ordem de F04, com data, descrição, tipo e valor; quando houver mais resultados, indicar que o restante pode ser consultado no histórico manual.

**R6 — Contexto sem invenção.** Utilizar mensagens anteriores da mesma conta para resolver referências claras. Não tratar um assunto antigo ou ambíguo como certeza. Após esclarecer a ambiguidade, aplicar o recorte confirmado. Números mencionados pelo usuário ou pelo assistente não se tornam movimentações reais por estarem no histórico do chat.

**R7 — Dados atuais.** Cada consulta nova usa os registros persistidos atuais, incluindo as alterações e exclusões da gestão manual já entregue. F07 verifica o efeito dos registros que introduzir por IA, sem condicionar o aceite das consultas atuais. Não responder usando exclusivamente valores de uma resposta antiga. Mensagens históricas permanecem como foram dadas, identificáveis por posição e data/hora, sem reescrevê-las ao alterar transações.

**R8 — Titularidade.** Restringir histórico, contexto, consultas e respostas ao titular autenticado com e-mail confirmado. Pedidos para consultar outra pessoa, alterações de referências ou instruções na conversa não ampliam acesso nem mudam a fonte de dados financeira.

**R9 — Sem gravação financeira nesta Feature.** Salvar mensagens não cria, altera ou exclui transações. F07 acrescenta o registro de receitas/despesas ao mesmo chat com revisão e confirmação. F06 não antecipa propostas simuladas nem apresenta sugestão de registro como operação concluída.

**R10 — Estados verdadeiros.** Distinguir carregamento do histórico, envio, processamento de resposta, consulta sem registros e indisponibilidade. Não afirmar sucesso de gravação de mensagem/resposta não confirmada pelo sistema, nem produzir atividade fictícia para sugerir uso de IA.

**R11 — Composição de mensagens.** A proposta desta revisão é aceitar mensagens de até 500 caracteres, conforme o design. Enter envia e Shift+Enter permite quebra de linha; o botão Enviar permanece disponível. Durante processamento, impedir novo envio pela interface até conclusão ou falha comunicada, mantendo a conversa legível.

**R12 — Identidade e integração.** Seguir a superfície Assistente do design fornecido, usando F01: cabeçalho do chat, mensagens distintas por autoria, campo de composição, sugestões, estados e orientação contextual. Retirar rótulos de assistente simulado ou armazenamento local. O dashboard F05 integrará seu próprio convite ao chat já entregue; essa ação não é condição futura da QA de F06. A sugestão de registrar gasto será atendida por F07; antes disso, orientar F04 sem lançar nem simular confirmação.

## Dados percebidos pelo usuário

Mensagens e autoria, data/hora reconhecível em America/Sao_Paulo, texto em composição, sugestões, estados de envio e processamento, respostas com valores em BRL e centavos, somas, contagens, períodos, categorias e registros consultados. Dados de depuração, nomes de ferramentas internas e configuração do provedor não fazem parte do fluxo de uso.

## Critérios de aceite

**CA01 — Retomada.** Enviar e receber mensagens, sair/entrar, recarregar e abrir a mesma conta em outro navegador. Retomar uma única conversa com as mensagens salvas, autoria, ordem e data/hora preservadas. Outra conta não vê essa conversa.

**CA02 — Envio.** Mensagem válida é enviada uma vez e apresenta processamento real. Mensagens vazias ou acima de 500 caracteres são recusadas com orientação; dados não são truncados silenciosamente. Conferir botão, sugestões, Enter e Shift+Enter e bloqueio de novo envio durante processamento.

**CA03 — Integração real.** Com o serviço de IA configurado, enviar perguntas compreensíveis com variações de linguagem e obter interpretação e resposta usando IA real e dados do sistema. Falhas não são substituídas por respostas simuladas, valores fictícios ou atividade falsa.

**CA04 — Saldo.** Com registros reais conhecidos e números divergentes apenas no chat, consultar saldo geral. Responder pela diferença de receitas/despesas próprias de todo o histórico, conforme F05, sem tratar mensagens como movimentações.

**CA05 — Totais e recortes.** Consultar receitas e despesas por mês atual, mês anterior, dia e intervalo inclusivo informado, com e sem categoria. Somas e contagens correspondem aos registros próprios e a resposta declara o recorte aplicado, conforme R3–R5.

**CA06 — Padrões.** Consultar totais sem período e sem contexto aplicável usa mês corrente declarado. Saldo e recentes usam todo o histórico. Referências relativas e limites de dia/mês seguem America/Sao_Paulo.

**CA07 — Recentes.** Com mais de cinco transações, responder com até cinco registros reais na ordem de F04 e indicar o restante no histórico manual, sem inventar exemplos. Sem movimentações, informar a ausência real.

**CA08 — Continuidade e esclarecimento.** Após uma pergunta, enviar “e no mês passado?” e obter o novo recorte com o assunto/filtros claros mantidos. Enviar referência ambígua, categoria incerta ou intervalo inválido gera esclarecimento antes do resultado, e a resposta seguinte completa a consulta.

**CA09 — Atualidade.** Consultar, editar/excluir/criar transações manualmente e consultar novamente. A nova resposta usa o estado atual; mensagens antigas continuam identificáveis e preservadas. O efeito de registros criados pela IA é verificado em F07, que introduz essa operação.

**CA10 — Ausência e falha.** Recorte sem correspondências produz total/contagem zero e ausência explícita, quando aplicável. Falha de IA ou dados não produz zero, ausência falsa ou valor inventado; informa problema e permite tentar novamente.

**CA11 — Persistência da conversa.** Falhas ao carregar ou salvar mensagens/respostas são comunicadas sem afirmar histórico vazio ou gravação concluída. Preservar texto não enviado quando aplicável e retomar de forma coerente, sem duplicar mensagens já confirmadas como salvas.

**CA12 — Fronteira financeira e acesso.** Conversar não grava transações. Visitante e conta pendente não acessam o chat financeiro; duas contas confirmadas só consultam os próprios registros e contexto, inclusive por referências diretas ou instruções para ignorar limites de acesso.

**CA13 — Escopo e continuidade manual.** Pedido fora das consultas suportadas recebe orientação sem falsa conclusão. Pedido de registro, antes de F07, orienta o cadastro manual de F04. F07 consome esse mesmo chat e é responsável pelo seu fluxo de registro, sem criar segunda conversa; essa operação não integra o aceite atual de consultas.

**CA14 — Aceite visual.** Comparar o chat e os estados aplicáveis com o design fornecido nas nove dimensões de F01, com mensagens longas e histórico extenso. Preservar hierarquia, autoria distinguível, controles e sugestões utilizáveis, foco e leitura, sem rótulos de simulação. A entrada pela navegação própria abre o chat real. O convite do dashboard é integrado e aceito em F05.

## Dependências

- F01 — [#1016270](https://redmine.remsoft.com.br/issues/1016270): identidade, estrutura e estados.
- F02 — [#1016271](https://redmine.remsoft.com.br/issues/1016271): conta, confirmação e identidade do titular.
- F04 — [#1016274](https://redmine.remsoft.com.br/issues/1016274): transações reais e catálogo de categorias.
- F06 é demonstrável por sua navegação própria com os dados de F04. F05 usa o chat pronto no convite do dashboard; F07 usa o mesmo chat para registro com confirmação, sem bloquear o aceite de F06.

## Designs e evidências

O design fornecido estabelece a superfície do chat, campo de até 500 caracteres, sugestões e estados visuais. O responsável confirmou conversa contínua salva e consultas em Q8/Q9. Persistência real, IA real e respostas baseadas em dados do sistema prevalecem sobre o comportamento demonstrativo do design. Referência visual: CA14.

## Dentro do escopo

Uma conversa contínua por titular, mensagens e respostas salvas, interpretação por IA real, saldo geral, somas/contagens por tipo e período com categoria, cinco últimas movimentações, continuidade contextual, esclarecimentos, estados e falhas coerentes, integração visual e destino real do chat.

## Fora do escopo

Gestão de múltiplas conversas, anexos, áudio, novos relatórios, recomendações de investimento ou planejamento, dados bancários externos e vários agentes de IA. Registro, edição ou exclusão financeira por conversa não são entregues nesta Feature; F07 acrescenta o registro de receitas/despesas com confirmação.
