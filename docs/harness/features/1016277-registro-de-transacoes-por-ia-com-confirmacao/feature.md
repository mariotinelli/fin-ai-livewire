# Registro de transações por IA com confirmação

## Identidade e situação

- Item F07 do [catálogo aprovado](../../scopes/2026-11-13-finai-mvp/scope.md).
- Situação: requisito completo e publicação aprovados pelo responsável; Feature #1016277 publicada e relida, com referência definitiva e três relações conferidas. Não implementada.
- Destino: projeto FinAi (65224), versão Livewire (20359).
- Referência estável: `docs/harness/.runs/2026-11-13-finai-mvp/f07-registro-ia/feature.md`.

## Objetivo

Permitir registrar receitas e despesas pela conversa com IA real, transformando mensagens em uma ou várias propostas independentes, sem completar campos silenciosamente e sem persistir transações antes da revisão e confirmação individual do titular.

## Resultado esperado

O titular informa movimentações com suas palavras. A IA identifica os dados explícitos, pergunta pelos dados faltantes e pode apresentar sugestões que só são adotadas após aceitação. Cada movimentação possui resumo completo, correção, cancelamento e confirmação próprios. Somente a confirmação final cria a transação, usando as mesmas regras do cadastro manual.

## Atores e permissões

- Titular autenticado e com e-mail confirmado: cria, revisa, aceita sugestões, corrige, cancela e confirma suas próprias propostas.
- Visitantes e contas pendentes não acessam dados ou ações financeiras, conforme F02.
- Outra conta não consulta, altera, aceita ou confirma propostas do titular; administração e suporte não recebem acesso adicional.

## Histórias de usuário

1. Como titular, quero dizer que gastei ou recebi um valor para preparar seu registro sem preencher o formulário inteiro.
2. Como titular, quero mencionar várias movimentações em uma mensagem para revisar cada uma separadamente.
3. Como titular, quero que informações não fornecidas sejam perguntadas ou sugeridas com pedido de aceitação para manter controle sobre o registro.
4. Como titular, quero corrigir ou cancelar uma proposta antes de confirmar para evitar lançar dados incorretos.
5. Como titular, quero confirmar uma proposta uma única vez e encontrar a transação no histórico e nos indicadores.

## Fluxo principal

1. Na conversa contínua de F06, enviar uma mensagem com uma ou mais movimentações. Preservar os limites e estados de envio já aprovados para o chat.
2. Interpretar por IA real e separar as movimentações identificáveis em propostas independentes, com referência visível que permita distingui-las.
3. Em cada proposta, distinguir dados expressamente informados de informações ausentes ou ambíguas. Perguntar pelos dados faltantes; quando houver sugestão fundamentada, apresentá-la como sugestão e perguntar se pode ser adotada.
4. A resposta do titular preenche o campo explicitamente ou aceita/corrige a sugestão correspondente. Nenhuma sugestão é adotada por silêncio, por navegação ou por interação com outra proposta.
5. Depois de todos os campos obrigatórios estarem informados ou expressamente aceitos e válidos, apresentar o resumo completo: tipo, valor, descrição, categoria e data, com Confirmar, Corrigir e Cancelar próprios.
6. Corrigir abre a revisão dos cinco campos conforme o formulário de F04; a conversa também pode receber correções quando o alvo for inequívoco. Após corrigir, apresentar novo resumo, ainda não gravado.
7. Confirmar no resumo atual persiste uma única transação do titular com os dados revisados. Exibir sucesso somente após confirmação da gravação e marcar a proposta como registrada, sem permitir nova gravação pela mesma proposta.
8. Atualizar o histórico e os indicadores disponíveis. As demais propostas continuam em seus estados próprios, até que sejam completadas, confirmadas ou canceladas individualmente.

## Fluxos alternativos e exceções

- Sem valor, tipo, descrição, categoria ou data suficientemente definidos, não habilitar a confirmação final. Fazer perguntas sobre os campos pendentes.
- Para um campo omitido, a IA pode sugerir um valor fundamentado no contexto, sempre identificado como sugestão e acompanhado de pedido de aceitação. Sem fundamento, perguntar em vez de inventar. Aceitar uma sugestão não constitui confirmação final da transação.
- Exemplo: “gastei 30 no almoço” permite identificar despesa, valor e descrição. Categoria Alimentação e data de hoje podem ser sugeridas com “Pode ser Alimentação, com data de hoje?”. Só após aceitação entram no resumo; a gravação continua dependendo de Confirmar.
- O titular pode recusar uma sugestão e fornecer outro dado. Uma resposta ambígua, como “sim” quando há várias perguntas ou propostas possíveis, exige identificar o alvo antes de alterar campos ou gravar.
- Cada proposta pode ser completada em momentos diferentes. Uma proposta pronta pode ser confirmada mesmo com outra incompleta; uma proposta cancelada não impede concluir as demais.
- Cancelar uma proposta informa que ela não foi registrada. Não apaga mensagens históricas nem cancela automaticamente propostas vizinhas.
- Corrigir o tipo exige categoria compatível; se a IA sugerir outra categoria, pedir aceitação. Correção ou nova sugestão invalida o resumo anterior para confirmação.
- Data futura ou inválida, valor fora das regras, descrição inválida ou categoria incompatível impede concluir a proposta ou gravá-la, conforme F03/F04. Não ajustar data ou valor automaticamente para torná-los válidos.
- Ao surgir consulta financeira durante propostas pendentes, atender conforme F06 sem gravar ou cancelar propostas. Movimentações não confirmadas não entram nos resultados. Correções ambíguas continuam exigindo identificação do alvo.
- Ao sair, recarregar ou abrir outro navegador, retomar a conversa e as propostas com seus estados reais; proposta registrada, cancelada ou substituída não volta a permitir confirmação.
- Falha de interpretação solicita esclarecimento ou nova tentativa, sem apresentar classificação incerta como aceita e sem criar registros.
- Falha ao salvar uma proposta ou sua correção informa o problema e não apresenta o estado como preservado com sucesso. A retomada deve usar apenas estados efetivamente salvos.
- Falha ao gravar a transação não gera sucesso nem atualização financeira falsa. Manter possibilidade de tentar novamente após conferir o resultado; se a gravação já tiver ocorrido, reconhecer o registro existente em vez de duplicá-lo.
- Pedido de editar ou excluir uma transação já registrada recebe orientação para os detalhes e ações reais de F04; não transformar a correção de proposta em edição de registro existente.

## Regras de negócio

**R1 — Proposta não é transação.** Mensagens, identificação da IA, sugestões, aceitação de campos e resumo de revisão não criam movimentação. Só a confirmação final da proposta atual, completa e válida permite gravar.

**R2 — Nenhum preenchimento silencioso.** Campos omitidos ou ambíguos nunca recebem automaticamente um valor presumido. A IA pode sugerir data, descrição, tipo ou categoria quando houver base, mas deve perguntar se o usuário aceita antes de adotá-los. Não presumir hoje, categoria geral ou tipo por conveniência. Não inventar valores financeiros para completar dados faltantes.

**R3 — Aceitação identificável.** Uma pergunta pode reunir sugestões claramente identificadas de uma mesma proposta, e uma resposta inequívoca pode aceitá-las em conjunto. Quando houver mais de um alvo possível, pedir esclarecimento. A aceitação de campos precede o resumo completo e não substitui a confirmação final individual.

**R4 — Múltiplas movimentações.** Uma mensagem pode originar várias propostas independentes. Mostrar qual movimentação cada uma representa. Não unir valores de movimentações distintas nem aplicar uma confirmação, correção ou cancelamento a todas por inferência. Não oferecer confirmação final em lote no MVP: cada proposta tem seu próprio Confirmar.

**R5 — Regras financeiras comuns.** As cinco informações obrigatórias, moeda BRL, precisão, limites, descrição, datas até hoje em America/Sao_Paulo e categorias seguem F03/F04. Datas relativas expressamente informadas, como hoje ou ontem, podem ser convertidas para a data correspondente, exibida no resumo; isso não autoriza inventar uma data omitida. Os dados revisados devem ser os mesmos que serão persistidos.

**R6 — Confirmação atual.** A ação final proposta para esta revisão é o botão Confirmar do resumo completo atual. Respostas de aceitação de sugestões e mensagens genéricas como “sim” não gravam transações. Se alguém pedir confirmação por texto, orientar o uso do botão da proposta pronta, sem dispensar campos pendentes. Resumos antigos ou substituídos não podem gravar após correção.

**R7 — Correção antes de registrar.** Permitir revisar os cinco campos pelo formulário e por mensagens com alvo claro. Informações fornecidas diretamente pelo usuário são validadas; novas sugestões de campos continuam exigindo aceitação. Salvar a revisão do formulário atualiza a proposta e apresenta novo resumo, sem criar a transação.

**R8 — Cancelamento individual.** Cancelar mantém histórico da conversa e marca a proposta como cancelada, sem transação. Uma proposta cancelada não pode ser confirmada por controles antigos. Uma nova intenção de registrar pode gerar nova proposta, sempre revisada e confirmada.

**R9 — Uma gravação por proposta.** Repetição do mesmo comando de confirmação, clique repetido, retorno a resumo antigo ou reabertura em outro navegador não cria nova transação para uma proposta já registrada. Duas propostas intencionais de movimentações iguais podem gerar dois registros legítimos, cada qual confirmado separadamente.

**R10 — Estado persistido e titularidade.** A conversa de F06 preserva dados e estados das propostas: campos pendentes, sugestões não aceitas, resumo atual, cancelamento ou registro confirmado. Cada ação verifica o titular e o estado atual, inclusive em outra aba ou navegador; não aceita controles antigos ou referências de outra conta como autorização.

**R11 — Integração financeira.** A transação confirmada aparece no mesmo histórico de F04 e participa dos cálculos e consultas atuais, conforme F05/F06. Propostas pendentes ou canceladas não aparecem como movimentações, nem alteram indicadores. Atualizar as superfícies disponíveis sem exigir novo login.

**R12 — Escopo da IA.** Usar IA real na interpretação, compartilhando a experiência e o contexto de F06. Esta Feature acrescenta criação de receitas/despesas; não concede permissão de alterar ou excluir transações existentes por conversa, inventar categorias, lançar previsões futuras ou ampliar acesso a outra conta.

**R13 — Apresentação.** Usar o design fornecido e F01 para proposta, resumo, estados e ações Confirmar/Corrigir/Cancelar. Adaptar para várias propostas distinguíveis e para perguntas de aceitação das sugestões, mantendo legibilidade e alvo da ação claros em celular, tablet e desktop. Não expor mecanismos internos no fluxo do produto.

## Dados percebidos pelo usuário

Mensagens, propostas identificáveis, dados fornecidos, sugestões pendentes e aceitas, perguntas de esclarecimento, resumo dos cinco campos, ações individuais e estados de processamento, cancelamento, falha ou registro confirmado. Após sucesso, identificação clara da transação registrada; sem alegar gravação antes de confirmá-la.

## Critérios de aceite

**CA01 — Interpretação real.** Enviar mensagens com receitas/despesas completas e reconhecer dados explícitos em propostas usando IA real, sem criar registros no momento da interpretação.

**CA02 — Várias propostas.** Enviar “gastei 30 no almoço e 15 no transporte” e obter duas propostas distinguíveis. Completar, corrigir, cancelar e confirmar cada uma separadamente, sem somar valores ou aplicar ações à outra. Não existe confirmação final em lote.

**CA03 — Sugestões consentidas.** Omitir data, categoria ou outro campo: a IA pergunta e pode sugerir com base no contexto, pedindo aceitação. Antes da resposta, o dado não é tratado como aceito e a proposta não pode ser gravada. Recusar ou corrigir a sugestão é permitido. Não assumir hoje ou Outras categorias silenciosamente.

**CA04 — Sem dados inventados.** Omitir valor, descrição ou tipo sem contexto suficiente: perguntar em vez de criar dados. Pedidos e respostas ambíguos com várias propostas não alteram a proposta errada nem gravam transação; o assistente pede identificação do alvo.

**CA05 — Duas decisões distintas.** Aceitar uma sugestão completa apenas os campos identificados. Com todos os dados válidos, mostrar os cinco campos no resumo e exigir o Confirmar individual atual. Mensagem genérica de aceitação, navegação ou silêncio não registra.

**CA06 — Validações comuns.** Exercitar campos ausentes, valor zero/negativo/acima do limite/com precisão inválida, descrição vazia/longa, categoria incompatível/inexistente e data inválida/futura. Recusar conforme F03/F04, sem ajustes silenciosos, sucesso falso ou gravação parcial. Datas relativas explícitas são exibidas como datas revisáveis no resumo.

**CA07 — Correção.** Corrigir cada campo pelo formulário e por mensagens de alvo claro. A revisão não cria transação; apresenta novo resumo completo. Trocar tipo requer categoria compatível e aceitação de qualquer nova sugestão. Confirmar o resumo antigo é impedido.

**CA08 — Cancelamento.** Cancelar uma proposta deixa claro que nada foi registrado para ela, preserva mensagens e não afeta as demais. Controle antigo não reativa nem grava a proposta cancelada.

**CA09 — Confirmação e repetição.** Confirmar proposta completa e atual cria uma única transação própria com os dados revisados. Repetir o comando ou agir em outra aba/navegador não duplica. Duas propostas legítimas de mesmos dados podem ser confirmadas uma vez cada.

**CA10 — Retomada.** Sair/entrar, recarregar e abrir outro navegador preserva campos, sugestões não aceitas e estados. Registradas/canceladas/substituídas não voltam a oferecer ação válida de gravação. Outra conta não lê ou executa ações sobre essas propostas.

**CA11 — Consultas com pendências.** Consultar saldo ou totais enquanto existem propostas pendentes usa apenas transações reais, sem confirmar/cancelar pendências por efeito da consulta. Após confirmar uma delas, consulta nova considera o registro atual e mantém as demais pendentes.

**CA12 — Falhas.** Falhas de IA, persistência de propostas ou gravação final são comunicadas com possibilidade de retomada, sem estado salvo fictício ou transação alegadamente criada. Resultado de confirmação incerto é conferido antes da nova tentativa para evitar duplicação.

**CA13 — Efeito no sistema.** Após confirmação, encontrar o registro em F04 e conferir seu efeito em F05/F06 disponíveis, respeitando data, tipo, valor e categoria. Propostas só sugeridas, aceitas nos campos ou canceladas não alteram histórico e indicadores financeiros.

**CA14 — Fronteira de operações.** Pedido de editar/excluir uma transação já registrada orienta F04 e não é executado pela conversa. Regras de acesso de F02 permanecem válidas; nenhuma mensagem ou referência contorna a confirmação de e-mail ou a titularidade.

**CA15 — Aceite visual.** Comparar propostas e revisão com o design fornecido, adaptado à multiplicidade e à aceitação de sugestões, nas nove dimensões de F01. Mensagens e dados extensos continuam legíveis, cada ação tem alvo reconhecível e os cinco campos estão disponíveis para revisão, sem rótulos de simulação.

## Dependências

- F03 — [#1016273](https://redmine.remsoft.com.br/issues/1016273): categorias e compatibilidade.
- F04 — [#1016274](https://redmine.remsoft.com.br/issues/1016274): regras e persistência das transações, com acesso F02 e base visual F01.
- F06 — [#1016276](https://redmine.remsoft.com.br/issues/1016276): chat real, conversa salva e contexto do titular.
- F05 — [#1016275](https://redmine.remsoft.com.br/issues/1016275): conferência integrada dos indicadores de CA13, sem necessidade dos cálculos do dashboard para registrar a transação. Não criar dependência circular.

## Designs e evidências

O design fornecido é referência para resumo revisável, correção e confirmação/cancelamento. O responsável autorizou várias movimentações por mensagem em Q10 e determinou em Q11 que campos nunca sejam completados silenciosamente: apresentar sugestões e perguntar se podem ser adotadas. As adaptações a várias propostas e aceitação explícita integram CA02–CA05 e CA15.

## Dentro do escopo

Criação de receitas e despesas por IA real no chat existente, várias propostas por mensagem, esclarecimentos, sugestões aceitas explicitamente, resumo completo, correção, cancelamento e confirmação final individuais, estados persistidos, prevenção de repetição da mesma gravação e reflexo nos dados financeiros reais.

## Fora do escopo

Preenchimento automático de dados omitidos, confirmação final em lote, lançamentos futuros, edição/exclusão de registros existentes pela IA, categorias personalizadas, anexos, áudio e múltiplos agentes. Aceitar uma sugestão não equivale a autorizar a gravação final.

## Decisões e revisão

- Q10 resolvida: o responsável aceitou várias movimentações por mensagem, com propostas e ações individuais.
- Q11 resolvida: “nunca complete, sempre faça sugestões e perguntar se pode ser”. Essa decisão substitui a sugestão anterior de assumir hoje/categoria sem pergunta; campos omitidos permanecem pendentes até resposta explícita.
- Q2 já incluiu revisão, correção e cancelamento; F03/F04/F06 definem categorias, regras financeiras e conversa persistida.
- Propostas desta revisão completa: aceitação identificável de um conjunto de sugestões da mesma proposta, seguida de resumo e botão Confirmar individual; retomada de estados entre acessos; consultas sem cancelar pendências. A revisão completa confirma esses detalhes, sem atribuí-los antecipadamente à resposta Q11.
- Preferência editorial respeitada: apenas design fornecido, sem origem pessoal.
- O responsável aprovou o requisito completo e a publicação apresentada respondendo “aprovado” nesta conversa, incluindo detalhes de aceitação, confirmação, retomada, materialização definitiva e relações F03/F04/F06 bloqueiam F07.

## Publicação proposta

- Projeto FinAi (65224), versão Livewire (20359), escolhida pelo responsável.
- Criar Feature (tracker 2), título **[WEB] [USUARIO] Registro de transações por IA com confirmação**, status inicial New (1), sem categoria, pai, responsável, datas, estimativa ou Sequencing; prioridade padrão do servidor.
- Descrição integral: seções de **Objetivo** até **Fora do escopo**, dentro de `<!-- project-flow:start -->` e `<!-- project-flow:end -->`, com a referência estável identificada no início.
- Após ID confirmado, materializar em `docs/harness/features/<ID>-registro-de-transacoes-por-ia-com-confirmacao/feature.md`, corrigir referências relativas e acrescentar o caminho definitivo à descrição remota, preservando a referência estável inicial.
- Relações propostas: F03 #1016273, F04 #1016274 e F06 #1016276 **bloqueiam** a nova F07, por categorias, operações financeiras e chat. F05 integra a conferência dos indicadores, sem relação de bloqueio para a criação de registros. Não criar tarefas DEV/QA nem relações com a Sprint 1.
- Similaridade: consulta da versão Livewire encontrou apenas F01–F06. Na Sprint 1, #1016107 reúne funcionalidades de assistente de outro catálogo; permanece preservada com suas filhas. Nova publicação respeita a separação F06/F07 aprovada neste catálogo.
- Publicação autorizada e confirmada como [Feature #1016277](https://redmine.remsoft.com.br/issues/1016277), com descrição integral e referência definitiva relidas. Projeto FinAi (65224), versão Livewire (20359), tracker Feature e status New conferidos; sem pai, categoria, responsável, datas, estimativa, Sequencing ou filhas. Relações #887, #888 e #889 confirmadas nos dois endpoints de cada vínculo: F03 #1016273, F04 #1016274 e F06 #1016276 bloqueiam F07 #1016277. Nenhum resultado incerto de publicação.

## Resultado da publicação

| Operação autorizada                           | Identidade                                                                               | Resultado                                                                 | Pendência |
| --------------------------------------------- | ---------------------------------------------------------------------------------------- | ------------------------------------------------------------------------- | --------- |
| Criar F07 com o requisito aprovado            | #1016277, projeto FinAi, versão Livewire                                                 | Criação e leitura final confirmadas                                       | Nenhuma   |
| Materializar requisito e atualizar referência | `docs/harness/features/1016277-registro-de-transacoes-por-ia-com-confirmacao/feature.md` | Documento materializado, fontes preservadas e referência remota conferida | Nenhuma   |
| F03, F04 e F06 bloqueiam F07                  | #1016273, #1016274 e #1016276 → #1016277, relações #887/#888/#889                        | Criadas e relidas nos dois endpoints de cada vínculo                      | Nenhuma   |

## Passagem

Entrada pronta para `project-slices`: este requisito aprovado, pai #1016277 confirmado na versão Livewire e dependências F03/F04/F06 registradas. Design fornecido preservado nas fontes do escopo. Conferência integrada dos indicadores usa F05, sem nova relação de bloqueio. Sem slicing, tarefas DEV/QA ou implementação nesta etapa.
