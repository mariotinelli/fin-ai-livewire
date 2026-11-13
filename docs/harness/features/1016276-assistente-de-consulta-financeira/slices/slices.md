# Fatiamento de Assistente de consulta financeira

## Identidade e situação

- Pai: [#1016276](https://redmine.remsoft.com.br/issues/1016276), `[WEB] [USUARIO] Assistente de consulta financeira`; [requisito aprovado](../feature.md).
- Projeto FinAi (65224); versão aberta Livewire (20359), retomada da seleção vigente no [escopo](../../../scopes/2026-11-13-finai-mvp/scope.md).
- Revisão r001 de 13/11/2026: conjunto aprovado, publicado e integralmente conferido, com QA corrigida pelo responsável para 4h.
- MCP: servidor redmine.remsoft.com.br, usuário mario.tinelli (131789). Na leitura anterior à publicação, o pai estava New (1), prioridade Normal (4), sem responsável, categoria, anexo, filhas ou Sequencing. Após publicar, continua New e espelha 17; requisito e relações anteriores foram preservados.
- Uma única QA cobre o resultado inteiro. Publicação de fornecedores não prova implementação.

## Evidências e caminho de aceite

O titular abre o chat real pela navegação própria, envia uma pergunta e confere respostas de IA real baseadas em transações atuais de F04. Retoma a mesma conversa, continua consultas e esclarece recortes. A referência de CA04 à fórmula do saldo de F05 é regra financeira compartilhada, não dependência de uma tela futura. O convite do dashboard é aceito em F05, e o registro por IA em F07; nenhum deles impede o fechamento funcional de F06.

| Evidência lida/consultada                                                                                                                                                                                                                                   | Conclusão para o slicing                                                                                                                                                                                                                                                                                                                                                                                                                                                      |
| ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `routes/customer.php`, `app/Support/Navigation/Definitions/BaseSidebarMenu.php`; busca por Agent/chat/conversa/SDK em app/routes/tests                                                                                                                      | Ainda não há chat financeiro, agente de consultas ou consumidor de memória no app; área pessoal atual tem dashboard, perfil e notificações. Criar o novo canal, sem tratá-lo como existente.                                                                                                                                                                                                                                                                                  |
| Composer: `laravel/ai` 1.3.0; `config/ai.php`                                                                                                                                                                                                               | SDK está instalado e configuração declara OpenAI como default. Não foram lidas credenciais, validada configuração efetiva do provedor ou feitas chamadas reais de IA. Provedor/modelo permanecem decisão interna de implementação.                                                                                                                                                                                                                                            |
| Boost search-docs, consultas Conversation Context / Tools / Structured Output / Testing                                                                                                                                                                     | Há suporte documentado à memória, ferramentas e fakes. Resultados identificam latest; fatos usados na estimativa foram conferidos no SDK local 1.3.0. Nenhuma API é prescrita na tarefa funcional.                                                                                                                                                                                                                                                                            |
| `vendor/laravel/ai/src/Concerns/RemembersConversations.php`                                                                                                                                                                                                 | Fornece memória e retomada da última conversa; não garante conversa única por titular nem UI/repetição segura. Limite padrão de contexto de 100 mensagens não equivale a apagar histórico legível do produto.                                                                                                                                                                                                                                                                 |
| `vendor/laravel/ai/src/Storage/DatabaseConversationStore.php`                                                                                                                                                                                               | Fornece persistência e verificação de titularidade; a aplicação ainda precisa autorizar histórico exibido e consultas financeiras. O armazenamento usa `steps` e `status`.                                                                                                                                                                                                                                                                                                    |
| Migrações locais `2026_03_20_101853_create_agent_conversations_table.php` e `2026_09_17_202136_upgrade_agent_conversations_for_participants.php`; Boost database-schema filtrado em agent_conversation e detalhes de colunas de agent_conversation_messages | Tabelas já existem no app e no banco efetivo, com tool_calls/tool_results/approval_state e participantes, mas sem steps/status. As colunas antigas tool_calls/tool_results são NOT NULL sem default, e o writer novo não as preenche: a compatibilização considera o contrato inteiro, não apenas duas colunas ausentes. É adaptação objetiva para o primeiro consumidor, não evidência de chat pronto. A hipótese inicial de migrações ausentes foi corrigida pela inspeção. |
| Boost database-query, somente COUNT(*) em agent_conversations/messages                                                                                                                                                                                      | Ambas têm zero registros neste ambiente. Não foram lidos textos de conversa nem presumido que outros ambientes estejam vazios. Preservar eventual histórico válido ao adaptar o armazenamento.                                                                                                                                                                                                                                                                                |
| `vendor/laravel/ai/src/Middleware/RememberConversation.php::handle/openTurn/rememberFailedTurn`                                                                                                                                                             | O turno é aberto após processamento concluído ou certos estados de falha; falha sem passos pode não salvar a mensagem. Não prova registro ao enviar, recuperação da resposta ou ausência de duplicação. D01 cobre a adaptação necessária.                                                                                                                                                                                                                                     |
| [F04 slicing](../../1016274-gestao-de-transacoes/slices/slices.md); DEV #1016351–#1016355 e QA #1016356 relidas no MCP                                                                                                                                      | Fonte futura de transações, catálogo, ordem e gestão manual já decomposta/publicada, toda New. Nenhuma capacidade é considerada implementada somente pela publicação.                                                                                                                                                                                                                                                                                                         |
| V01, ZIP compartilhado: index.html #assistant/.chat-top/#messages/#chat-form/#chat-input/#send-message/.suggestions/.chat-guide                                                                                                                             | Fonte real inspecionada, com limite 500, sugestões, autoria visual e Enter/Shift+Enter. Badges de simulação, parser por regras e armazenamento local são diferenças funcionais já resolvidas no requisito em favor de IA e persistência reais.                                                                                                                                                                                                                                |

Não foram executados testes ou chamadas de IA neste slicing. A compatibilidade do armazenamento é limitada e inspecionável, portanto integra D01; não há pergunta técnica aberta que justifique Study separada.

## Prévia numerada

| Ref. | Título completo                                                                               | Papel | Horas | Sequencing | Bloqueio de início |
| ---- | --------------------------------------------------------------------------------------------- | ----- | ----: | ---------: | ------------------ |
| D01  | [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Saldo geral em conversa salva       | DEV   |     6 |         17 | QA F04 #1016356    |
| D02  | [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Totais mensais por tipo e categoria | DEV   |   2,5 |         18 | D01                |
| D03  | [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Totais por dia e intervalo          | DEV   |   2,5 |         19 | D01                |
| D04  | [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Cinco últimas movimentações         | DEV   |   1,5 |         20 | D01                |
| D05  | [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Continuidade e esclarecimento       | DEV   |   3,5 |         21 | D02                |
| QA   | [QA] [WEB] [USUARIO] Assistente de consulta financeira                                        | QA    |     4 |         22 | D01–D05            |

Total aprovado: **16h DEV + 4h QA = 20h**. O responsável aprovou todas as DEV e corrigiu a QA para 4h. Todas as tarefas têm estimativa positiva até seis horas.

A primeira consulta reúne o canal e sua persistência porque o saldo precisa ser perguntado, respondido e retomado no produto para estar concluído. Os totais mensais e os de dia/intervalo têm consultas e aceites próprios; tipo/categoria são variantes dentro de cada uma. Recentes tem resultado próprio. Continuidade e esclarecimento completam a mesma interação de resolver referência/informação faltante, sem postergar segurança ou verdade dos resultados para uma tarefa futura.

D02, D03 e D04 podem iniciar após o chat D01; compartilhar consultas não cria bloqueio artificial entre elas. D05 inicia após D02 para demonstrar “e no mês passado?” com filtros claros; integra dia/intervalo e recentes para conclusão. QA final verifica todas, sem ciclos ou consumidores futuros.

## Fundamento das estimativas

Duas avaliações independentes, `slicing_review_delivery` e `slicing_review_reuse`, receberam o mesmo requisito, evidências e referências calibradas, sem estimativas candidatas nem acesso às horas uma da outra. Primeiro questionaram os cortes e ambas recomendaram separar totais mensais de dia/intervalo.

| Parecer                      | D01 | D02 | D03 | D04 | D05 |  QA | Total |
| ---------------------------- | --: | --: | --: | --: | --: | --: | ----: |
| Entrega                      |   6 | 2,5 |   2 | 1,5 |   3 | 5,5 |  20,5 |
| Reuso/cobertura              |   6 | 2,5 | 2,5 | 1,5 | 3,5 |   6 |    22 |
| Proposta inicial (histórico) |   6 | 2,5 | 2,5 | 1,5 | 3,5 |   6 |    22 |

Os números dos pareceres e da proposta inicial acima permanecem como histórico, não como medição realizada ou horas vigentes. O responsável aprovou todas as DEV e corrigiu explicitamente a QA de 6h para **4h**, totalizando **20h**. Essa é calibração humana, sem redução de cobertura, condições, descrições, relações ou escopo. O detalhamento temporal original da QA abaixo não representa uma distribuição das novas 4h.

Na revisão final, o parecer de Entrega manteve D01 em 6h após conferir o armazenamento efetivo: tabelas e participantes existentes reduzem o preparo inicial, e sua compatibilização substitui parte desse esforço em vez de somar uma reconstrução completa. Ambos os pareceres leram as descrições formatadas e as condições finais e não identificaram lacuna material de cobertura, dependências ou cálculos. A revisão de escrita preservou condições observáveis, superfícies visuais e limites sem prescrever o plano técnico.

| Entrega e horas iniciais (histórico) | Base de esforço                                                                                                                                                                                                                                                                                                                                     |
| ------------------------------------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| D01 — 6h                             | Primeiro fluxo real: composição/navegação, autorização, saldo simples por registros atuais, adaptação de armazenamento, conversa única/retomada, integração do serviço e falhas/retry com verificações relevantes. Preparo comum do canal contado uma vez aqui; usar SDK e componentes existentes sem introduzir streaming/WebSockets não exigidos. |
| D02 — 2,5h                           | Consulta mensal por tipo/categoria, defaults e recorte transparente com ensaio real; preparo comum de apresentação/cálculo de totais contado aqui.                                                                                                                                                                                                  |
| D03 — 2,5h                           | Datas relativas/explícitas, bordas inclusivas, fuso e intervalo inválido; reuso da apresentação/cálculo sem reconstruir o chat.                                                                                                                                                                                                                     |
| D04 — 1,5h                           | Até cinco registros atuais na ordem de F04, campos exigidos, ausência/falha e orientação manual.                                                                                                                                                                                                                                                    |
| D05 — 3,5h                           | Contexto pertinente, continuação, ambiguidade e conclusão de esclarecimentos preservando filtros e dados atuais, com verificação de retomada e isolamento.                                                                                                                                                                                          |
| QA — 6h                              | Aproximadamente 1h preparo de dados/relógio/falhas e acesso ao serviço, 2h jornadas reais/atualidade/contexto, 1h falhas/persistência/isolamento, 1,25h comparação visual agrupada nas nove dimensões e 0,75h evidências/reteste focalizado.                                                                                                        |

Premissas: executor familiar ao Laravel/Livewire do projeto, ambiente de homologação e fornecedores acessíveis, provedor de IA disponível para conclusão e sem infraestrutura adicional nova. Não se presume uso de IA para implementar, credencial pronta, controles de falha gratuitos ou automação visual existente. Espera por fornecedor/serviço é separada do esforço. Inspeção e disponibilidade concreta precisam ser conferidas na implementação; necessidade material adicional exige reavaliar, sem reduzir cobertura para caber nas horas.

Calibração humana disponível: F04 passou de proposta 25h a 12h por correção do responsável (3/2/2/2/1h DEV e 2h QA); Visual 13,5h DEV + 4h QA e Acesso 2h DEV + 1,5h QA. São correções, não medições. F06 introduz o primeiro fluxo com IA real e persistência de conversa adaptada, portanto não aplicar desconto uniforme nem copiar o esforço de F04.

## Cobertura

Cada parcela funcional tem dono; requisitos comuns se aplicam ao canal ou à consulta que os introduz. QA verifica o resultado completo, inclusive preservação entre as entregas.

| Origem e parcela                                                         | Destino                                                                            | Condições                                 |
| ------------------------------------------------------------------------ | ---------------------------------------------------------------------------------- | ----------------------------------------- |
| R1 — conversa única, mensagens, autoria, ordem, momento e retomada       | D01                                                                                | CT-005–CT-010, CT-023                     |
| R2 — canal com interpretação/IA real                                     | D01; cada consulta nova integra sua intenção real em D02–D05                       | CT-004/CT-008/CT-011/CT-013/CT-016/CT-024 |
| R3/R5 — saldo de todo o histórico                                        | D01                                                                                | CT-004                                    |
| R3–R5 — totais mensais por tipo/categoria, soma/contagem e mês declarado | D02                                                                                | CT-011/CT-012/CT-015/CT-017               |
| R3–R5 — totais de dia/intervalo, inclusividade e fuso                    | D03                                                                                | CT-012–CT-015/CT-017                      |
| R3–R5 — até cinco recentes e orientação ao histórico                     | D04                                                                                | CT-015–CT-017                             |
| R6 — recusa de suposição e números do chat sem efeito financeiro         | D01 saldo/canal; D02 mensal; D03 diário; D04 recentes                              | CT-004/CT-012/CT-014/CT-021               |
| R6 — resolver continuação clara e completar esclarecimento pendente      | D05                                                                                | CT-018/CT-019                             |
| R7 — dados atuais e preservação de respostas antigas                     | Cada consulta no seu resultado; D05 na continuação                                 | CT-020                                    |
| R8 — titularidade do histórico/envio/retomada                            | D01                                                                                | CT-001/CT-005/CT-021                      |
| R8 — titularidade dos recortes/resultados/contexto                       | D02 mensal; D03 diário; D04 recentes; D05 contextual                               | CT-021                                    |
| R9 — conversa sem gravação financeira, limites e orientação F04          | D01                                                                                | CT-004/CT-022                             |
| R10 — carregar, enviar, processar, salvar, falhar e retomar mensagens    | D01                                                                                | CT-006–CT-010                             |
| R10 — ausência/falha da consulta                                         | Cada resultado próprio D01–D05                                                     | CT-008/CT-017/CT-019                      |
| R11 — composição 500/Enter/Shift+Enter/botão/bloqueio                    | D01                                                                                | CT-002/CT-003/CT-010                      |
| R12 — navegação e chat; orientação/registro manual                       | D01                                                                                | CT-001/CT-022/CT-023                      |
| R12 — sugestões mensais/recentes e novas respostas                       | D02 mensal; D04 recentes; D03/D05 apresentação das respostas próprias              | CT-002/CT-023                             |
| R12 — convite dashboard e registro por IA                                | Limites aprovados F05/F07, sem trabalho nesta Feature                              | CT-024 encerra pelo chat próprio          |
| CA01 — retomada e isolamento                                             | D01; D05 preserva contexto claro retomado                                          | CT-005/CT-018/CT-021                      |
| CA02 — envio e sugestões                                                 | D01 controles/saldo; D02 sugestão mensal; D04 recentes; D01 orientação de registro | CT-002/CT-003/CT-010/CT-022               |
| CA03 — integração real                                                   | Cada consulta e QA integrada                                                       | CT-004/CT-008/CT-011/CT-013/CT-016/CT-024 |
| CA04 — saldo real                                                        | D01                                                                                | CT-004/CT-017                             |
| CA05 — totais/recortes                                                   | D02 mensal; D03 dia/intervalo                                                      | CT-011–CT-014/CT-017                      |
| CA06 — padrões temporais                                                 | D02 padrão mensal; D03 dias; D01 saldo e D04 recentes acumulados                   | CT-015                                    |
| CA07 — recentes                                                          | D04                                                                                | CT-016/CT-017                             |
| CA08 — continuidade e esclarecimento                                     | D05 diálogo; D02/D03 recusam insegurança desde sua conclusão                       | CT-012/CT-014/CT-018/CT-019               |
| CA09 — atualidade                                                        | Cada consulta responde por sua atualização e histórico                             | CT-020                                    |
| CA10 — ausência versus falha                                             | Cada consulta responde por seu resultado                                           | CT-008/CT-017                             |
| CA11 — persistência e recuperação                                        | D01 canal; demais entregas preservam                                               | CT-006–CT-010                             |
| CA12 — fronteira financeira e acesso                                     | D01 canal/limite; cada consulta/contexto protege dados próprios                    | CT-001/CT-004/CT-021/CT-022               |
| CA13 — limites e continuidade manual                                     | D01                                                                                | CT-022                                    |
| CA14 — fidelidade e navegação própria                                    | D01 base do chat; D02–D05 respostas/sugestões próprias; QA comparação integral     | CT-001/CT-023/CT-024                      |

Nenhuma capacidade de produto é classificada como completamente existente apenas por estar disponível no SDK. Não há omissão de mensagens antigas, falhas de resposta ou isolamento em retomada.

## Condições de teste

Fonte: [condicoes-teste-r001.md](condicoes-teste-r001.md); documento previsto para a QA: [1016276 - Condições de testes.docx](<r001/1016276 - Condições de testes.docx>). As condições integrais abaixo compõem a mesma decisão sobre tarefas, campos, relações, numeração e anexo.

Pai: Assistente de consulta financeira — #1016276.
Projeto: FinAi (65224). Versão: Livewire (20359).
Revisão: r001, prévia de 13/11/2026. Condições não executadas.

### Contexto

Executar pela navegação própria e pelo chat real da aplicação, com IA real configurada em homologação, F04 implementada/verificada e, transitivamente, F01/F02 disponíveis. Publicação de tarefas New não comprova disponibilidade. O provedor não foi chamado neste slicing; sua configuração operacional e o consumo necessário à QA precisam estar disponíveis na execução. Fakes podem apoiar verificações automatizadas, mas não substituem a interpretação e resposta reais exigidas nesta QA.

Usar contas confirmadas A/B com dados distintos, conta pendente e visitante, além de perfis administrativos/de suporte para verificar a ausência de acesso a terceiros. Preparar uma conta sem movimentações, histórico extenso de mensagens próprias, duas sessões/navegadores da mesma conta, relógio controlável e falhas reversíveis de carregamento, salvamento de mensagem, IA, consulta financeira e salvamento da resposta. Preparação e reteste focalizado integram a estimativa de QA; espera por serviço/fornecedor indisponível não é esforço ativo.

Para números de referência, fixar hoje em 13/11/2026, America/Sao_Paulo, e preparar em A: receita Salário de R$ 1.000,10 em 30/09/2026; receita Freelance de R$ 200,20 em 05/11/2026; despesa Alimentação de R$ 50,05 em 01/11/2026; despesa Transporte de R$ 25,10 em 10/11/2026; despesa Moradia de R$ 30,15 em 31/10/2026; despesa Lazer de R$ 10,00 em 01/10/2026. Saldo geral: R$ 1.085,00. Novembro: receitas R$ 200,20/1 registro; despesas R$ 75,15/2 registros. Outubro: receitas R$ 0,00/0; despesas R$ 40,15/2. Repor a base entre condições que alteram registros; cenários de empate, hoje/ontem e limites de intervalo usam dados adicionais próprios, com resultados calculados previamente.

Manter o catálogo aprovado de F04: receitas Salário, Freelance, Rendimentos, Outras receitas; despesas Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras, Outras despesas. Valores somente mencionados em mensagens e dados de B não entram nos cálculos de A.

Visual V01: docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip, entrada index.html, #assistant, .chat-top, #messages, .message, #chat-form, #chat-input, #send-message, .suggestions e .chat-guide; considerar a ordem final das regras e DESIGN-HANDOFF.md. Comparar em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080 e transições 767/768px e 1024/1025px, usando a base F01. IA real, persistência por titular, data/hora e estados aprovados substituem os rótulos, armazenamento local e comportamento por regras do protótipo.

F05 integra seu próprio convite ao chat pronto e F07 acrescenta registros com confirmação no mesmo chat. Não são condições futuras para encerrar F06. Registrar resultado/evidência por CT; defeitos e condições não executadas permanecem identificados.

### CT-001 — Navegação e autorização do chat

Verificação: Abrir Assistente pela navegação e por referência direta como A, visitante e conta pendente. Repetir após mudança de e-mail que retire a confirmação, preservando as funções não financeiras autorizadas.

Resultado esperado: A abre seu chat real; visitante e conta pendente não acessam histórico, contexto, respostas ou consultas financeiras. O acesso não depende do convite do dashboard futuro.

Origem no requisito: Atores e permissões; R8, R12; CA12, CA14.

### CT-002 — Envio pelo botão, teclado e sugestões

Verificação: Enviar pergunta válida pelo botão, por Enter e por sugestão de saldo, totais e recentes, em tentativas distintas. Usar Shift+Enter para compor mensagem com quebra de linha.

Resultado esperado: Cada envio aceito aparece uma única vez, com autoria e processamento real. Enter envia; Shift+Enter conserva a quebra de linha sem disparar envio; botão e sugestões permanecem utilizáveis. A conversa continua legível.

Origem no requisito: R10–R12; CA02, CA03, CA14.

### CT-003 — Limites e preservação da composição

Verificação: Tentar mensagem vazia, apenas espaços, mensagem de 500 caracteres e mensagem de 501 caracteres, inclusive por colagem.

Resultado esperado: Vazio/espaços e excesso de 500 caracteres são recusados com orientação. Uma mensagem válida no limite é preservada integralmente; não truncar silenciosamente dados acima do limite nem apresentá-los como enviados.

Origem no requisito: Fluxos alternativos; R11; CA02.

### CT-004 — Saldo real de todo o histórico

Verificação: Com a base A, perguntar pelo saldo com variações compreensíveis, como “qual é meu saldo?” e “quanto tenho no total?”. Incluir em mensagem número financeiro divergente, sem registrá-lo em F04.

Resultado esperado: A IA real consulta os registros atuais e responde em pt-BR com R$ 1.085,00, identificando saldo geral/acumulado de todo o histórico. Números do chat não alteram a resposta nem viram transações. A fórmula comum ao requisito do dashboard não exige que o dashboard esteja entregue.

Origem no requisito: R2, R3, R5–R9; CA03, CA04, CA12.

### CT-005 — Retomada e conversa única

Verificação: Enviar e receber mensagens, recarregar, sair/entrar e abrir a mesma conta em outro navegador. Na primeira utilização, abrir a conta em dois navegadores e verificar a continuidade ao alterná-los.

Resultado esperado: Retomar uma única conversa contínua própria, com mensagens salvas, autoria, ordem e data/hora reconhecíveis em America/Sao_Paulo. Não oferecer criação, seleção, renomeação ou exclusão manual de múltiplas conversas.

Origem no requisito: R1, R8; CA01.

### CT-006 — Falha ao carregar o histórico

Verificação: Provocar falha reversível no carregamento de uma conversa que possui mensagens e tentar novamente após restabelecer o serviço.

Resultado esperado: Informar indisponibilidade com possibilidade de nova tentativa; não apresentar conversa vazia como primeira utilização nem mensagens de outra conta. Após recuperação, retomar o histórico salvo.

Origem no requisito: Fluxos alternativos; R1, R10; CA10, CA11.

### CT-007 — Falha ao salvar a mensagem

Verificação: Compor uma pergunta e falhar seu salvamento antes da consulta; depois permitir nova tentativa. Conferir o histórico após recarregar.

Resultado esperado: Não apresentar a mensagem como persistida quando seu salvamento falhou. Preservar o texto ainda não enviado, quando aplicável, e permitir nova tentativa coerente, sem duplicar mensagem já confirmada como salva.

Origem no requisito: Fluxos alternativos; R1, R10; CA11.

### CT-008 — Falhas de IA e de consulta financeira

Verificação: Provocar separadamente indisponibilidade da IA e erro da consulta financeira em perguntas de saldo, totais e recentes. Restabelecer e tentar novamente.

Resultado esperado: Comunicar o problema; não substituir falha por zero, ausência falsa, valores inventados ou atividade simulada. Manter mensagens já salvas e permitir recuperação sem duplicá-las nem gravar transação financeira.

Origem no requisito: Fluxos alternativos; R2, R7, R9, R10; CA03, CA10, CA11.

### CT-009 — Falha ao preservar a resposta

Verificação: Permitir a interpretação e a consulta, mas provocar falha ao salvar a resposta. Recarregar ou retornar à conversa e usar a recuperação disponível.

Resultado esperado: Distinguir resultado processado de resposta efetivamente salva. Não afirmar que a conversa foi preservada com sucesso; permitir recuperação/nova tentativa coerente, sem duplicar mensagens já confirmadas e sem fabricar resposta histórica.

Origem no requisito: Fluxos alternativos; R1, R10; CA11.

### CT-010 — Processamento e repetição de envio

Verificação: Com latência real/controlada, tentar repetir clique, Enter ou sugestão enquanto aguarda resposta e conferir o histórico após concluir. Repetir após uma falha comunicada.

Resultado esperado: Impedir novo envio pela interface até conclusão ou falha comunicada. A mesma tentativa não duplica mensagem salva; a conversa permanece legível e permite nova tentativa quando liberada, preservando o estado confirmado.

Origem no requisito: Fluxos alternativos; R10, R11; CA02, CA11.

### CT-011 — Totais mensais separados

Verificação: Com a base A, perguntar receitas/despesas do mês atual, mês passado e setembro de 2026, usando variações de linguagem e pedido dos dois tipos.

Resultado esperado: Responder com somas e contagens separadas por tipo, declarar o mês utilizado e usar somente dados de A. Novembro: receita R$ 200,20/1 e despesa R$ 75,15/2; outubro: receita R$ 0,00/0 e despesa R$ 40,15/2; setembro inclui receita R$ 1.000,10/1.

Origem no requisito: R2–R5, R7; CA03, CA05, CA06.

### CT-012 — Categoria e vocabulário comum

Verificação: Consultar totais com categorias de receita e despesa existentes, incluindo Outras receitas e Outras despesas com dados preparados. Perguntar por categoria inexistente, incerta ou incompatível com o tipo solicitado.

Resultado esperado: Para categoria compreendida com segurança, declarar seu nome aprovado, tipo, período, soma e quantidade corretos. Referência inexistente/incerta/incompatível exige esclarecimento antes de resultado numérico; não criar categoria nem classificá-la silenciosamente.

Origem no requisito: R3, R5, R6; CA05, CA08.

### CT-013 — Hoje, ontem e dia explícito

Verificação: Preparar transações próprias em hoje/ontem e no dia 10/11/2026. Perguntar receitas/despesas desses dias, com e sem categoria, inclusive perto da virada do dia em São Paulo.

Resultado esperado: Usar o dia compreendido em America/Sao_Paulo, declarar data, tipo/categoria quando houver, soma e contagem. O recorte de 10/11/2026 da base contém despesa Transporte de R$ 25,10/1, sem incluir registros de outros dias.

Origem no requisito: R3–R5; CA05, CA06.

### CT-014 — Intervalos inclusivos e inválidos

Verificação: Consultar intervalo explícito de 31/10/2026 a 05/11/2026 com registros em ambas as bordas e fora delas, filtrando tipo/categoria quando solicitado. Tentar intervalo invertido, data inexistente e referência temporal insegura.

Resultado esperado: Incluir datas inicial/final. Na base A e nesse intervalo, receitas R$ 200,20/1 e despesas R$ 80,20/2. Recortes inválidos ou inseguros pedem esclarecimento antes de apresentar resultado, sem inverter datas ou supor um intervalo silenciosamente.

Origem no requisito: R3–R6; CA05, CA06, CA08.

### CT-015 — Períodos padrão e limites de mês

Verificação: Sem contexto pertinente, perguntar total sem período. Comparar com saldo e recentes. Controlar relógio quando UTC já está em outro dia/mês, mas America/Sao_Paulo ainda não.

Resultado esperado: Totais sem período/contexto usam e declaram o mês corrente de São Paulo; saldo e recentes usam todo o histórico. Não deslocar a data financeira nem aplicar o mês de outro fuso.

Origem no requisito: R3–R5; CA04, CA06, CA07.

### CT-016 — Cinco últimas movimentações

Verificação: Perguntar pelas últimas movimentações com zero, menos de cinco e mais de cinco registros próprios. Preparar empates de data/criação para conferir a ordem de F04.

Resultado esperado: Apresentar até cinco registros reais de todo o histórico, na ordem de data financeira decrescente, criação mais recente primeiro na mesma data e desempate estável de F04. Informar data, descrição, tipo e valor em BRL. Com mais resultados, indicar o histórico manual real; sem registros, informar ausência sem exemplos inventados.

Origem no requisito: R3–R5, R7; CA06, CA07.

### CT-017 — Recorte válido sem correspondências

Verificação: Consultar totais de mês, dia, intervalo e categoria válidos sem registros; repetir em conta sem movimentações e perguntar saldo/recentes.

Resultado esperado: Totais informam soma/contagem zero e ausência explícita no recorte, quando aplicáveis; saldo sem movimentações é zero geral, e recentes informa ausência. Esses resultados só ocorrem após consulta bem-sucedida, nunca como substituição de falha.

Origem no requisito: Fluxos alternativos; R3–R5, R10; CA04–CA07, CA10.

### CT-018 — Continuação com filtros claros

Verificação: Consultar despesas de Alimentação do mês corrente e continuar “e no mês passado?”. Testar também continuação de uma consulta de dia/intervalo e de receitas, e repetir uma continuação clara após retomar a conversa no navegador.

Resultado esperado: Manter assunto/tipo/categoria claros e mudar apenas o recorte solicitado, declarando-o; consultar dados atuais novamente. Não exigir repetir a pergunta inteira nem mudar tipo/categoria sem fundamento.

Origem no requisito: R1, R3–R7; CA01, CA05, CA08, CA09.

### CT-019 — Esclarecimento e contexto incerto

Verificação: Enviar pergunta sem tipo/recorte materialmente compreensíveis, categoria incerta ou intervalo inválido; responder ao pedido de esclarecimento com a informação que falta. Após trocar de assunto, usar referência que possa apontar para mais de um assunto antigo.

Resultado esperado: Pedir esclarecimento antes de número, completar a consulta pendente com a resposta e aplicar o recorte confirmado sem exigir repetir tudo. Contexto antigo/ambíguo não é tomado como certeza; números mencionados na conversa não viram movimentações.

Origem no requisito: Fluxos alternativos; R4, R6; CA08.

### CT-020 — Dados atuais e respostas históricas

Verificação: Consultar saldo/totais/recentes, depois criar, editar valor/tipo/data/categoria e excluir registros manualmente em F04, realizando nova pergunta após cada alteração.

Resultado esperado: Cada resposta nova considera o estado persistido atual e as exclusões, sem usar exclusivamente números antigos. Respostas históricas continuam como foram dadas, com posição, autoria e data/hora reconhecíveis. F07 verifica seus próprios registros por IA futuramente.

Origem no requisito: R6, R7; CA04, CA09.

### CT-021 — Titularidade contra referências e instruções

Verificação: Com A/B, pedir dados/contexto da outra conta, adulterar referências diretas de conversa/mensagem e instruir o assistente a ignorar limites. Trocar de conta e tentar consultas como administração/suporte sobre finanças de terceiros.

Resultado esperado: Histórico, contexto, consultas e respostas continuam limitados ao titular confirmado. Não revelar mensagens, valores ou registros alheios nem conceder acesso por instrução no chat ou privilégios administrativos/de suporte. A segunda conta não reutiliza contexto da primeira.

Origem no requisito: R1, R6, R8; CA01, CA12.

### CT-022 — Limites de consulta e encaminhamento manual

Verificação: Pedir cadastro, edição, exclusão, recomendações de investimento ou consulta externa não suportada; usar a sugestão “Registrar um gasto”. Seguir a orientação de cadastro manual quando aplicável e conferir os registros em F04 antes/depois de conversar.

Resultado esperado: Orientar o limite e as consultas disponíveis, sem falsa conclusão. Pedido/sugestão de registro direciona ao cadastro manual real de F04; o chat não cria, altera ou exclui transações nem mostra proposta/confirmação simulada. Não criar segunda conversa para F07.

Origem no requisito: R9, R12; CA12, CA13.

### CT-023 — Fidelidade visual e histórico extenso

Verificação: Comparar V01 com chat inicial, mensagens longas/próximas do limite, resposta extensa e histórico longo nas nove dimensões e transições do contexto. Usar mouse e teclado, lateral recolhida quando disponível e estados de carregamento, foco, envio, processamento, vazio, ausência de dados, erro e recuperação aplicáveis.

Resultado esperado: Preservar hierarquia, espaços, superfícies, cores e tipografia sobre F01, distinguindo autoria e mantendo data/hora legível. Composição, botão e sugestões permanecem alcançáveis, foco/rolagem legíveis, sem controles cobertos pela navegação ou rolagem horizontal da página. Não exibir rótulos de simulação, armazenamento local, depuração, nomes de ferramentas internas ou configuração do provedor. Comparação visual, não só captura ou ausência de erro, fundamenta o aceite.

Origem no requisito: Dados percebidos; R1, R10–R12; CA01, CA02, CA14.

### CT-024 — Jornada integrada com IA real

Verificação: Pela navegação própria, enviar perguntas de saldo, totais mensais, dia/intervalo e recentes com linguagem variada; continuar contexto, esclarecer ambiguidade, retomar conversa e confrontar os dados após alteração manual. Registrar evidência complementar da integração real sem exibir credenciais.

Resultado esperado: O ciclo usa interpretação por IA real e registros atuais próprios, preserva a conversa única e distingue sucesso, ausência e falha. A navegação própria permite concluir a QA sem convite do dashboard nem registro por IA futuros. Fakes ou interpretação demonstrativa por regras não comprovam esta condição.

Origem no requisito: R1–R12; CA01–CA14.

## Descrições completas

### D01 — [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Saldo geral em conversa salva

#### Entrega

Permitir que o titular abra Assistente pela navegação própria, pergunte pelo saldo em linguagem natural e receba uma resposta de IA real baseada nas transações atuais da sua conta, em uma conversa contínua salva e retomável.

#### Escopo e limites

Navegação, composição, interpretação real, persistência, retomada e estados de falha ficam juntos porque são necessários para concluir e reconhecer essa primeira consulta pelo canal aprovado. A tarefa não entrega apenas uma tela vazia ou uma infraestrutura interna. Usar F01/F02/F04 verificadas e adaptar o armazenamento existente da conversa sem reconstruir essas Features.

Totais por período, recentes e continuidade contextual têm entregas próprias. A orientação inicial deve corresponder às consultas realmente disponíveis; as sugestões aplicáveis dessas entregas são integradas quando funcionais. A sugestão de registrar gasto orienta o cadastro manual de F04, sem antecipar propostas de F07. O produto mantém uma única conversa por titular.

#### Critérios de aceite

- A navegação própria abre o chat real do titular autenticado com e-mail confirmado. Visitante e conta pendente não acessam histórico, contexto, consultas ou respostas; referências diretas não ampliam acesso.
- Administração e suporte não recebem acesso a conversas ou dados financeiros de terceiros. Sair e trocar de conta carrega apenas a conversa da segunda, sem contexto ou resultados da anterior.
- Na primeira utilização, apresentar orientação das consultas disponíveis e sugestões aplicáveis do design. Não oferecer criação, seleção, renomeação ou exclusão manual de múltiplas conversas.
- O botão Enviar, Enter e sugestão de saldo permitem enviar uma mensagem válida de até 500 caracteres; Shift+Enter insere quebra de linha. Recusar vazio, apenas espaços e excesso com orientação, sem truncar silenciosamente, inclusive na colagem.
- Ao aceitar o envio, registrar a mensagem e indicar processamento real. Mensagem e resposta exibem autoria, ordem e data/hora reconhecíveis em America/Sao_Paulo.
- Durante o processamento, impedir novo envio pela interface até conclusão ou falha comunicada, mantendo a conversa legível e evitando duplicar mensagem já confirmada.
- Interpretar perguntas compreensíveis de saldo com IA real e responder em pt-BR com valor em BRL e centavos, pela diferença das receitas e despesas próprias atuais de todo o histórico. Identificar o caráter geral/acumulado do saldo, inclusive zero real sem movimentações.
- Números mencionados no chat e respostas antigas não substituem os registros atuais. Nova pergunta após criação, edição ou exclusão manual usa dados atuais; mensagens históricas permanecem como foram dadas, com posição e momento reconhecíveis.
- Mensagem ambígua ou interpretação insegura não gera número por suposição; pedir esclarecimento. A conclusão contextual sem repetir a pergunta inteira é ampliada pela entrega Continuidade e esclarecimento.
- Salvar mensagens não cria, altera ou exclui transações. Pedidos fora das consultas suportadas recebem explicação do limite e opções disponíveis; pedido/sugestão de registro orienta o cadastro manual real de F04, sem proposta ou confirmação simulada.
- Recarregar, sair/entrar e usar a mesma conta em outro navegador retoma a única conversa salva, preservando mensagens do usuário e assistente, autoria, ordem e data/hora, inclusive ao abrir a mesma conta em duas sessões.
- Falha de carregamento informa indisponibilidade e permite tentar novamente, sem apresentar conversa vazia como primeira utilização.
- Falha ao salvar mensagem não a apresenta como persistida; preservar texto ainda não enviado quando aplicável e permitir nova tentativa sem duplicar mensagem já salva.
- Falha de IA ou consulta financeira informa o problema e permite retomada, sem zero de conveniência, valor inventado, resposta simulada ou gravação financeira.
- Falha ao salvar resposta distingue processamento de preservação efetiva. Retomar ou tentar novamente mantém coerência com as mensagens já confirmadas, sem anunciar histórico salvo ou duplicar conteúdo indevidamente.
- Instruções para ignorar limites, consultar outra pessoa ou usar valores do chat não mudam titularidade nem fonte financeira.
- Comparar cabeçalho, mensagens, composição, orientação, sugestões e estados de carregamento, foco, envio, processamento, vazio inicial, ausência real, erro e recuperação com V01 sobre F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, com transições 767/768px e 1024/1025px. Manter hierarquia, autoria distinguível, datas/horas legíveis, teclado e foco, textos longos e histórico extenso utilizáveis, sem controles cobertos ou rolagem horizontal da página.
- Retirar rótulos de assistente simulado/armazenamento local e não expor depuração, nomes de ferramentas internas ou configuração do provedor na conversa.

#### Dependências

O início depende de [[QA] [WEB] [USUARIO] Gestão de transações](https://redmine.remsoft.com.br/issues/1016356), que verifica os registros, as categorias e a gestão manual reais de F04. Essa entrega consome a identidade/confirmação de F02 e a base visual F01 já verificadas. A publicação das tarefas em New não libera esses fornecedores.

Serviço de IA real configurado e acessível é necessário para concluir a integração e verificá-la; a escolha interna de provedor/modelo não altera os requisitos funcionais. Dashboard F05 e registro por IA F07 não bloqueiam esta consulta.

#### Referências

[Pai #1016276](https://redmine.remsoft.com.br/issues/1016276); R1/R2 e R3–R12 nas parcelas de saldo, canal, persistência, acesso e limites; CA01–CA04/CA06/CA09–CA14 nas respectivas parcelas; CT-001–CT-010, CT-015, CT-017, CT-020–CT-024.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #assistant, .chat-top, #messages, .message, #chat-form, #chat-input, #send-message, .suggestions e .chat-guide. A persistência, IA real e data/hora aprovadas substituem o comportamento demonstrativo/local do design.

Intenção estável de criação: `docs/harness/features/1016276-assistente-de-consulta-financeira/slices/slices.md#D01-r001`.

### D02 — [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Totais mensais por tipo e categoria

#### Entrega

Permitir perguntar sobre receitas e despesas de um mês, com categoria opcional, e receber soma e quantidade de registros reais com o tipo, o mês e os filtros utilizados declarados na resposta.

#### Escopo e limites

Mês corrente, anterior e explícito são variantes da mesma consulta mensal; receitas/despesas e categoria não viram tarefas por campo. Totais por dia e intervalo têm consulta e aceite próprios. Usar o chat persistido já funcional, sem refazer envio, memória, autorização ou aparência compartilhada.

#### Critérios de aceite

- Interpretar por IA real perguntas compreensíveis de receitas, despesas ou ambos em este mês, mês passado e mês explícito; consultar somente os registros atuais próprios.
- Apresentar em pt-BR e BRL com centavos a soma e a quantidade separadas de cada tipo solicitado, declarando mês e categoria quando houver.
- Sem período explícito e sem contexto claro aplicável, usar e declarar o mês corrente em America/Sao_Paulo, inclusive quando UTC estiver em outro dia/mês.
- Reconhecer o catálogo comum de F04: Salário, Freelance, Rendimentos, Outras receitas, Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras e Outras despesas; aplicar somente categoria compatível compreendida com segurança.
- Categoria inexistente, incerta ou incompatível, tipo materialmente ambíguo ou período inseguro gera pedido de esclarecimento antes de número, sem inventar classificação. Completar a consulta pendente pela resposta curta é ampliado por Continuidade e esclarecimento.
- Mês/categoria válidos sem registros produzem soma e quantidade zero com ausência explícita; falha de IA ou dados informa problema e permite retomada, sem zero ou ausência falsa.
- Cada pergunta usa os dados atuais após criação, edição ou exclusão manual; valores mencionados na conversa não se tornam registros e respostas históricas não são reescritas.
- Histórico, contexto, consulta e resposta permanecem próprios, inclusive em referências diretas e pedidos para ignorar limites. Visitante e conta pendente não acessam o chat; mensagens não alteram finanças.
- A sugestão “Quanto gastei este mês?” executa a consulta real pela mesma composição, com processamento verdadeiro, persistência e recuperação coerentes, sem duplicar mensagens já salvas.
- Comparar sugestão mensal e respostas de totais nos estados de resultado, ausência, esclarecimento e falha com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, com transições 767/768px e 1024/1025px. Soma, quantidade, período, categoria e autoria permanecem legíveis, com foco/controles alcançáveis, sem sobreposição ou rolagem horizontal da página.

#### Dependências

O início depende de Assistente de consulta financeira - Saldo geral em conversa salva, que fornece chat, navegação, identidade e persistência reais sobre F04 verificada. Não depende de consultas por dia/intervalo ou de recentes.

#### Referências

[Pai #1016276](https://redmine.remsoft.com.br/issues/1016276); R2–R8/R10–R12 nas consultas mensais; CA02/CA03/CA05/CA06/CA08–CA12/CA14 nas parcelas mensais; CT-002, CT-008, CT-011/CT-012, CT-015, CT-017, CT-020/CT-021, CT-023/CT-024.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #assistant, #messages, .suggestions e sugestão mensal. As respostas transparentes de soma/contagem seguem o requisito, sem reproduzir as limitações de interpretação por regras do protótipo.

Intenção estável de criação: `docs/harness/features/1016276-assistente-de-consulta-financeira/slices/slices.md#D02-r001`.

### D03 — [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Totais por dia e intervalo

#### Entrega

Permitir consultar receitas e despesas de hoje, ontem, uma data ou intervalo explícito, com categoria opcional, recebendo soma e contagem dos registros próprios com datas e filtros utilizados declarados.

#### Escopo e limites

Hoje/ontem, datas explícitas e intervalos são recortes da consulta de realização diária. Validação de datas e inclusão das duas bordas são necessárias para que o resultado seja útil e correto. A consulta mensal tem entrega própria; usar o mesmo chat, catálogo e apresentação de totais sem duplicar seu preparo.

#### Critérios de aceite

- Interpretar perguntas por IA real para hoje, ontem, data explícita e intervalo informado, separando receitas e despesas quando ambos forem solicitados.
- Usar America/Sao_Paulo para referências relativas e limites de dia, sem deslocar a data financeira registrada.
- Incluir datas inicial e final de um intervalo válido e aplicar o tipo/categoria compreendidos, sem incluir registros fora das bordas.
- Apresentar em pt-BR e BRL com centavos soma e quantidade por tipo solicitado, identificando dia ou intervalo e categoria quando houver.
- Usar exatamente o catálogo comum de F04, incluindo Outras receitas e Outras despesas, sem criar categoria ou supor classificação incerta.
- Intervalo invertido, data inexistente, categoria inexistente/incompatível ou interpretação insegura requer esclarecimento antes de número, sem corrigir ou completar silenciosamente o recorte. Continuidade e esclarecimento acrescenta a conclusão do diálogo pendente sem repetir a pergunta inteira.
- Recorte válido sem registros informa soma/contagem zero e ausência real; falha de IA ou dados informa o problema com possibilidade de retomada, sem resultado inventado ou zero de conveniência.
- Nova consulta usa registros atuais após criação, edição ou exclusão manual, sem tomar mensagens/respostas anteriores como fonte financeira e sem reescrever mensagens históricas.
- Manter o isolamento do titular confirmado no histórico, contexto, dados e resposta, inclusive por referência direta ou instrução para ignorar limites. Conversar não grava transações.
- Envio, processamento, persistência e recuperação usam o canal existente sem duplicar mensagens já salvas.
- Comparar respostas de dia/intervalo, recorte esclarecido, ausência e falha com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, com transições 767/768px e 1024/1025px. Datas, categorias, valores, contagens e mensagens longas permanecem legíveis e distinguíveis por autoria, sem controles encobertos ou rolagem horizontal da página.

#### Dependências

O início depende de Assistente de consulta financeira - Saldo geral em conversa salva. Para concluir, manter coerência dos totais e da classificação com Assistente de consulta financeira - Totais mensais por tipo e categoria; compartilhar o preparo do cálculo não constitui bloqueio de início adicional.

#### Referências

[Pai #1016276](https://redmine.remsoft.com.br/issues/1016276); R2–R8/R10–R12 nas consultas diárias/por intervalo; CA03/CA05/CA06/CA08–CA12/CA14 nas respectivas parcelas; CT-008, CT-012–CT-015, CT-017, CT-020/CT-021, CT-023/CT-024.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #assistant, #messages, #chat-form e #chat-input. Datas/intervalos inclusivos e esclarecimentos seguem R3–R6, prevalecendo sobre o parser demonstrativo.

Intenção estável de criação: `docs/harness/features/1016276-assistente-de-consulta-financeira/slices/slices.md#D03-r001`.

### D04 — [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Cinco últimas movimentações

#### Entrega

Permitir perguntar pelas últimas movimentações e receber até cinco transações próprias atuais de todo o histórico, com dados suficientes para reconhecê-las e orientação para o histórico manual quando houver mais resultados.

#### Escopo e limites

A resposta recente tem resultado próprio, independente das somas mensais ou por intervalo. Usar a ordenação e o histórico reais de F04, sem criar outra tela de transações ou um relatório novo.

#### Critérios de aceite

- Interpretar perguntas compreensíveis de últimas movimentações por IA real e consultar registros atuais de todo o histórico próprio, sem restringir silenciosamente ao mês corrente.
- Apresentar até cinco registros reais com data, descrição, tipo e valor em BRL com centavos.
- Preservar a ordem de F04: data financeira decrescente, criação mais recente primeiro na mesma data e desempate estável.
- Quando houver mais resultados, indicar que o restante está no histórico manual real de F04; com menos de cinco, não completar a resposta com exemplos fictícios.
- Sem movimentações, informar ausência real após consulta bem-sucedida. Falha de IA ou consulta informa problema e permite retomada, sem apresentar ausência falsa.
- Cada nova pergunta reflete criação, edição e exclusão manuais atuais; não usar apenas uma resposta antiga nem reescrever mensagens históricas.
- A sugestão “Últimas movimentações” executa a consulta real no mesmo chat, com persistência, autoria, momento e processamento verdadeiros, sem duplicar mensagens já salvas.
- Manter histórico, contexto, registros e respostas limitados ao titular confirmado, inclusive contra referências diretas e instruções para consultar terceiros; mensagens não criam, editam ou excluem finanças.
- Comparar sugestão e resposta de recentes nos estados de resultado, ausência e falha com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, com transições 767/768px e 1024/1025px, com descrições extensas, datas e valores legíveis, autoria distinguível, foco e acesso às ações, sem rolagem horizontal da página ou controles encobertos.

#### Dependências

O início depende de Assistente de consulta financeira - Saldo geral em conversa salva. O histórico de F04 já é fornecedor dessa entrega; totais mensais e intervalos não bloqueiam a consulta de recentes.

#### Referências

[Pai #1016276](https://redmine.remsoft.com.br/issues/1016276); R2–R5/R7–R12 nas parcelas de recentes; CA02/CA03/CA06/CA07/CA09–CA12/CA14; CT-002, CT-008, CT-015–CT-017, CT-020/CT-021, CT-023/CT-024.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #assistant, #messages, .suggestions e sugestão de últimas movimentações. O resultado usa F04 atual, sem exemplos locais de demonstração.

Intenção estável de criação: `docs/harness/features/1016276-assistente-de-consulta-financeira/slices/slices.md#D04-r001`.

### D05 — [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Continuidade e esclarecimento

#### Entrega

Permitir continuar uma consulta em linguagem natural sem repetir o assunto inteiro e completar uma pergunta pendente ao responder ao esclarecimento, mantendo apenas contexto claro da própria conta e consultando novamente os registros atuais.

#### Escopo e limites

Continuação e esclarecimento completam o mesmo diálogo de interpretação: o usuário fornece o que muda ou falta na consulta. Cada consulta anterior já deve recusar interpretação insegura e falhas com honestidade. Esta tarefa acrescenta a resolução da referência e da resposta curta, sem assumir a integridade ou autorização que pertencem a todos os canais.

#### Critérios de aceite

- Após consultar despesas de uma categoria no mês corrente, “e no mês passado?” mantém assunto, tipo e categoria claros e muda o período solicitado, declarando os filtros aplicados.
- Interpretar continuações compreensíveis das consultas mensais, de dia/intervalo e recentes quando a referência tiver correspondência segura, usando a conversa da própria conta, inclusive após retomá-la em outro navegador.
- Não tratar assunto antigo, troca de assunto ou referência com múltiplos sentidos como certeza; pedir esclarecimento antes de apresentar número.
- Tipo, categoria, período, intervalo invertido ou referência inseguros geram pergunta clara sobre a informação faltante. A resposta seguinte completa a consulta pendente com o recorte confirmado, sem exigir repetir toda a pergunta.
- Categoria inexistente ou incompatível não é criada nem convertida silenciosamente para outra; esclarecer a classificação no catálogo comum de F04.
- Cada continuação/esclarecimento concluído consulta os registros persistidos atuais, incluindo alterações/exclusões manuais; números mencionados e respostas antigas não viram fonte financeira.
- Preservar mensagens e respostas históricas com autoria, ordem e data/hora; não reescrevê-las ao corrigir recorte ou alterar transações.
- O resultado conserva as informações de sua consulta: saldo geral/acumulado; totais com tipo/período/categoria quando houver, soma/contagem; ou até cinco recentes com dados e ordem de F04.
- Restringir histórico e contexto ao titular confirmado, inclusive contra instruções para ignorar acesso, referência direta a conversa alheia e troca de conta. Pedidos não suportados ou de gravação seguem a orientação manual existente sem modificar finanças.
- Ausência real não é confundida com falha de IA/dados. Falha de interpretação, salvamento ou resposta permite retomada coerente, sem inventar resultado, duplicar mensagem confirmada ou descartar o estado de persistência já conhecido.
- Comparar perguntas de esclarecimento, continuações e respostas longas nos estados de processamento, ausência, erro e retomada com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, com transições 767/768px e 1024/1025px. Manter autoria, momento, foco, teclado, texto e controles legíveis/alcançáveis, sem sobreposição ou rolagem horizontal da página.

#### Dependências

O início depende de Assistente de consulta financeira - Totais mensais por tipo e categoria, que já usa o chat persistido e permite demonstrar a continuação mensal com filtros. Para concluir a cobertura contextual completa, integrar também Assistente de consulta financeira - Totais por dia e intervalo e Assistente de consulta financeira - Cinco últimas movimentações. Essas integrações de conclusão não bloqueiam o início da continuação mensal.

#### Referências

[Pai #1016276](https://redmine.remsoft.com.br/issues/1016276); R1/R3–R8/R10–R12 na continuidade; CA01/CA05/CA06/CA08–CA12/CA14 nas parcelas contextuais; CT-005, CT-008/CT-009, CT-012–CT-015, CT-018–CT-024.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #assistant, #messages, .message, #chat-input e #chat-form. A continuidade persistida e o esclarecimento aprovados substituem a interpretação demonstrativa, sem nova conversa ou controles fora do escopo.

Intenção estável de criação: `docs/harness/features/1016276-assistente-de-consulta-financeira/slices/slices.md#D05-r001`.

## Publicação proposta

### QA — [QA] [WEB] [USUARIO] Assistente de consulta financeira

#### Entrega

Verificar o Assistente de consulta financeira completo pelas telas reais, com interpretação por IA real, consultas aos dados atuais próprios e conversa contínua persistida, cobrindo CT-001–CT-024 da revisão r001.

#### Escopo e limites

Executar uma única QA para toda a Feature, incluindo preparação de contas/dados, relógio, falhas reversíveis, acesso ao serviço de IA real, registro de resultados e reteste focalizado. Testes automatizados com fakes apoiam integridade e falhas, sem substituir a integração real ou comparação visual.

F05 verifica seu convite ao chat e F07 seu registro confirmado no mesmo chat. Esta QA conclui pela navegação própria sem esperar essas Features nem simular suas operações.

#### Critérios de aceite

- Executar CT-001–CT-024 com resultado e evidência por condição, cobrindo R1–R12 e CA01–CA14; condições não executadas e defeitos ficam explicitamente pendentes.
- Demonstrar envio pelo botão, Enter e sugestões, Shift+Enter, limite de 500 caracteres, recusa de vazio/excesso sem truncamento e bloqueio de novo envio enquanto processa.
- Retomar uma única conversa da mesma conta após recarregar, sair/entrar e usar outro navegador, preservando autoria, ordem e data/hora em America/Sao_Paulo.
- Confirmar por perguntas variadas que interpretação e resposta usam IA real e registros atuais, sem atividade ou valores fictícios.
- Conferir saldo acumulado de todo o histórico, totais mensais e por dia/intervalo inclusivo com tipo/categoria, somas e contagens, mês corrente padrão declarado e referências relativas no fuso aprovado.
- Conferir até cinco recentes de todo o histórico com data, descrição, tipo, valor, ordem de F04 e orientação ao histórico manual.
- Completar continuações claras e perguntas pendentes por esclarecimento sem repetir tudo; referência antiga/ambígua, categoria incerta e intervalo inválido não recebem número por suposição.
- Criar, editar e excluir manualmente em F04 e fazer nova consulta: usar dados atuais e preservar as respostas históricas reconhecíveis, sem transformar números do chat em transações.
- Diferenciar ausência real de falhas de carregamento, gravação de mensagem, IA, dados e salvamento de resposta, com recuperação coerente e sem duplicar mensagens já salvas.
- Conferir isolamento de mensagens/contexto/dados entre A/B, referências diretas, instruções para ignorar acesso e recusa de visitante/conta pendente e de acesso financeiro alheio por administração/suporte.
- Conferir orientação a pedidos fora do escopo e cadastro manual de F04 pela sugestão de registro, sem propostas simuladas, gravação financeira ou segunda conversa.
- Comparar chat, sugestões, mensagens longas, histórico extenso e estados aplicáveis com V01 sobre F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, com transições 767/768px e 1024/1025px. Manter hierarquia, autoria, data/hora, foco, teclado, leitura e ações alcançáveis, sem sobreposição, rolagem horizontal ou rótulos de simulação.

#### Dependências

Executar após Assistente de consulta financeira - Saldo geral em conversa salva; Assistente de consulta financeira - Totais mensais por tipo e categoria; Assistente de consulta financeira - Totais por dia e intervalo; Assistente de consulta financeira - Cinco últimas movimentações; e Assistente de consulta financeira - Continuidade e esclarecimento.

F04 e seus fornecedores F01/F02 precisam estar implementados/verificados, e o serviço de IA real precisa estar disponível. Espera por acesso/fornecedores não é esforço ativo de teste.

#### Referências

[Pai #1016276](https://redmine.remsoft.com.br/issues/1016276); R1–R12, CA01–CA14; CT-001–CT-024, r001; anexo previsto `1016276 - Condições de testes.docx`.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #assistant, .chat-top, #messages, .message, #chat-form, #chat-input, #send-message, .suggestions e .chat-guide. IA real, persistência e estados aprovados prevalecem sobre o protótipo.

Intenção estável de criação: `docs/harness/features/1016276-assistente-de-consulta-financeira/slices/slices.md#QA-r001`.

### Destino e campos exatos

Todas as seis filhas serão novas no projeto 65224, versão 20359, pai 1016276. A busca de todas as filhas, inclusive fechadas, retornou zero; não há adoção ou filha externa. Não criar Study.

| Campo                                           | D01–D05                                                                                                       | QA                                                     |
| ----------------------------------------------- | ------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------ |
| subject                                         | Título completo de cada descrição acima                                                                       | [QA] [WEB] [USUARIO] Assistente de consulta financeira |
| tracker_id                                      | Task (4)                                                                                                      | Deliverable (5)                                        |
| status_id / priority_id                         | New (1) / Normal (4)                                                                                          | New (1) / Normal (4)                                   |
| project_id / fixed_version_id / parent_issue_id | 65224 / 20359 / 1016276                                                                                       | 65224 / 20359 / 1016276                                |
| estimated_hours                                 | 6 / 2.5 / 2.5 / 1.5 / 3.5                                                                                     | 4                                                      |
| custom_fields                                   | Sequencing, id 2: 17 / 18 / 19 / 20 / 21                                                                      | Sequencing, id 2: 22                                   |
| responsável / categoria / datas                 | Sem atribuição, categoria ou datas; não preencher por inferência                                              | Idem                                                   |
| description                                     | Entrega, Escopo e limites, Critérios, Dependências, Referências e rodapé estável exatamente como apresentados | Idem, incluindo CT-001–CT-024 e arquivo previsto       |

Campos do pai a atualizar: somente Sequencing (id 2), de vazio para 17, espelhando D01. Preservar status New, descrição/requisito, versão, prioridade, demais campos e conteúdo humano. Não publicar comentário adicional nem mudar outros pais.

Nomes ainda sem ID nas dependências serão preservados como apresentados, sem inserir links adicionais na descrição remota durante publicação. IDs definitivos entram nos registros e task.md após conferência.

### Relações novas

Direção `blocks`: origem bloqueia início do destino. As referências locais de filhas serão substituídas pelos IDs confirmados.

| Origem                                                                                                | Destino                                                                                             | Motivo                                                                |
| ----------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------- |
| [#1016356 — [QA] [WEB] [USUARIO] Gestão de transações](https://redmine.remsoft.com.br/issues/1016356) | D01 — [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Saldo geral em conversa salva       | Registros/categorias e gestão manual reais verificados sobre F01/F02. |
| D01 — [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Saldo geral em conversa salva         | D02 — [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Totais mensais por tipo e categoria | Canal persistido real para a consulta mensal.                         |
| D01 — [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Saldo geral em conversa salva         | D03 — [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Totais por dia e intervalo          | Canal persistido real para dia/intervalo.                             |
| D01 — [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Saldo geral em conversa salva         | D04 — [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Cinco últimas movimentações         | Canal persistido real para recentes.                                  |
| D02 — [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Totais mensais por tipo e categoria   | D05 — [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Continuidade e esclarecimento       | Primeira continuação útil demonstrada com mês/tipo/categoria.         |
| Cada uma de D01–D05, com os títulos completos acima                                                   | QA — [QA] [WEB] [USUARIO] Assistente de consulta financeira                                         | Cinco relações, uma por entrega, antes da verificação integrada.      |

São dez relações novas. D03/D04 não são bloqueadas por D02 por mero reuso de cálculo ou memória; D05 integra seus resultados antes da conclusão. Não há aresta para aguardar F05/F07.

Grafo remoto lido: 22 issues, 31 relações blocks, todos os endpoints consultados e sem ciclo. O delta proposto continua acíclico. Preservar as 31 relações existentes, incluindo #884 F01→F06, #885 F02→F06, #886 F04→F06, #889 F06→F07 e #899 F06→F05; nenhuma relação provisória será removida. A nova dependência específica não altera as relações originais do Project Flow nem refina consumidores futuros sem autorização.

### DOCX e destino

Documento r001: `slices/r001/1016276 - Condições de testes.docx`, com título Condições de teste, pai #1016276, contexto e CT-001–CT-024 com origem. Fonte Markdown acima. A capacidade disponível foi demonstrada no pai anterior: Word 16.0 e league/commonmark 2.10.7 já instalados, sem novo conversor ou dependência.

A prévia real foi gerada no Word 16.0 e conferida: pacote ZIP/OpenXML válido, 24 condições, texto integral equivalente ao Markdown normalizando apenas espaços e marcação dos títulos, 20.952 bytes. Documento gerado não significa condições executadas.

Upload e associação pelo MCP concluídos na [QA #1016369](https://redmine.remsoft.com.br/issues/1016369), [anexo #3365](https://redmine.remsoft.com.br/attachments/download/3365/1016276%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx), descrição “Condições de teste r001 — Assistente de consulta financeira”. Nome, identidade, descrição e 20.952 bytes relidos e confirmados; nenhum anexo anterior foi removido.

## Sequencing

Leitura completa da versão: projeto 65224/Livewire 20359, status *, todos os trackers, offset 0/limit 100/total 22, sem página faltante. Metadado confirmado Sequencing id 2, observado em pais, Task e Deliverable.

Ocupação: Visual 1–8, pai #1016270 espelha 1; Acesso 9–10, pai #1016271 espelha 9; Transações 11–16, pai #1016274 espelha 11. Demais pais #1016275/#1016276/#1016277 sem número. Espelhos não consomem posição; não há valor não vazio inválido ou outra ocupação acima de 16.

Bloco proposto **17–22**, D01–D05 em 17–21 e QA em 22; pai #1016276 espelha **17**. Não renumerar terceiros nem preencher lacunas. Renovar leitura completa antes de publicar; colisão exige conciliação e nova revisão material, sem mudar o bloco autorizado silenciosamente.

## Revisão e publicação

O responsável aprovou o conjunto apresentado, mantendo todas as DEV e corrigindo somente a estimativa da QA para 4h: pai/destino, cinco DEV e uma QA, descrições, campos, 20h, dez relações, bloco 17–22/âncora 17, condições e DOCX r001. Todas as operações autorizadas foram executadas e conferidas por nova leitura MCP.

| Operação autorizada           | ID/URL conhecido                                                                                                                                                                           | Resultado                                                                                                | Próximo passo                                               |
| ----------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------- |
| Criar D01                     | [#1016364](https://redmine.remsoft.com.br/issues/1016364)                                                                                                                                  | Confirmada: descrição/campos, 6h, Sequencing 17                                                          | Planejamento DEV quando fornecedores estiverem disponíveis. |
| Criar D02                     | [#1016365](https://redmine.remsoft.com.br/issues/1016365)                                                                                                                                  | Confirmada: descrição/campos, 2,5h, Sequencing 18                                                        | Aguardar D01.                                               |
| Criar D03                     | [#1016366](https://redmine.remsoft.com.br/issues/1016366)                                                                                                                                  | Confirmada: descrição/campos, 2,5h, Sequencing 19                                                        | Aguardar D01.                                               |
| Criar D04                     | [#1016367](https://redmine.remsoft.com.br/issues/1016367)                                                                                                                                  | Confirmada: descrição/campos, 1,5h, Sequencing 20                                                        | Aguardar D01.                                               |
| Criar D05                     | [#1016368](https://redmine.remsoft.com.br/issues/1016368)                                                                                                                                  | Confirmada: descrição/campos, 3,5h, Sequencing 21                                                        | Aguardar D02; integrar D03/D04 para concluir.               |
| Criar QA                      | [#1016369](https://redmine.remsoft.com.br/issues/1016369)                                                                                                                                  | Confirmada: descrição/campos, 4h, Sequencing 22                                                          | Aguardar as cinco DEV.                                      |
| Criar dez relações blocks     | Relações #915–#924; fornecedor #1016356; filhas #1016364–#1016369                                                                                                                          | Confirmadas pelos endpoints; grafo de 28 issues/41 relações acíclico, 31 relações anteriores preservadas | Sem pendência de publicação.                                |
| Numerar filhas 17–22 e pai 17 | Pai #1016276; filhas #1016364–#1016369                                                                                                                                                     | Bloco integral confirmado; nenhuma renumeração alheia                                                    | Sem pendência de publicação.                                |
| Anexar DOCX r001 à QA         | [Anexo #3365](https://redmine.remsoft.com.br/attachments/download/3365/1016276%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx), [QA #1016369](https://redmine.remsoft.com.br/issues/1016369) | Nome, identidade, descrição e 20.952 bytes confirmados; fonte local com 24 CT equivalentes               | Executar futuramente na QA.                                 |
| Materializar task.md por ID   | Seis arquivos listados abaixo                                                                                                                                                              | Concluída após conferência integral remota                                                               | Planejamento/execução nas etapas próprias.                  |

## Resultado consolidado e pendências

Publicado e conferido: cinco DEV (16h) e uma QA (4h), total de 20h, todas New, com bloco 17–22 e pai espelhando 17. Descrições/campos correspondem ao conjunto aprovado, com a correção humana da QA. As 31 relações anteriores foram preservadas; nenhuma issue alheia teve status, conteúdo, numeração ou anexo alterado.

| Ref. | Issue publicada                                                                                 | Arquivo materializado                                                       |
| ---- | ----------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------- |
| D01  | [#1016364 — Saldo geral em conversa salva](https://redmine.remsoft.com.br/issues/1016364)       | [task.md](../tasks/dev-1016364-saldo-geral-em-conversa-salva/task.md)       |
| D02  | [#1016365 — Totais mensais por tipo e categoria](https://redmine.remsoft.com.br/issues/1016365) | [task.md](../tasks/dev-1016365-totais-mensais-por-tipo-e-categoria/task.md) |
| D03  | [#1016366 — Totais por dia e intervalo](https://redmine.remsoft.com.br/issues/1016366)          | [task.md](../tasks/dev-1016366-totais-por-dia-e-intervalo/task.md)          |
| D04  | [#1016367 — Cinco últimas movimentações](https://redmine.remsoft.com.br/issues/1016367)         | [task.md](../tasks/dev-1016367-cinco-ultimas-movimentacoes/task.md)         |
| D05  | [#1016368 — Continuidade e esclarecimento](https://redmine.remsoft.com.br/issues/1016368)       | [task.md](../tasks/dev-1016368-continuidade-e-esclarecimento/task.md)       |
| QA   | [#1016369 — Assistente de consulta financeira](https://redmine.remsoft.com.br/issues/1016369)   | [task.md](../tasks/qa-1016369-assistente-de-consulta-financeira/task.md)    |

Sem pendência de publicação. Fornecedor F04 QA #1016356 e seus antecedentes continuam New; o início permanece condicionado à implementação/verificação desses fornecedores. Não houve implementação, execução de condições ou chamada de IA neste fluxo. Próximo item do catálogo para slicing: Dashboard financeiro #1016275.
