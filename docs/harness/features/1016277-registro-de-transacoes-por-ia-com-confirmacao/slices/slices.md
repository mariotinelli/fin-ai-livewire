# Fatiamento de Registro de transações por IA com confirmação

## Identidade e situação

- Pai: [#1016277](https://redmine.remsoft.com.br/issues/1016277), `[WEB] [USUARIO] Registro de transações por IA com confirmação`; [requisito aprovado](../feature.md).
- Projeto FinAi (65224), versão aberta Livewire (20359), selecionada no [escopo](../../../scopes/2026-11-13-finai-mvp/scope.md).
- Revisão r001 de 13/11/2026: conjunto aprovado, publicado e integralmente conferido; nenhuma implementação ou execução de QA realizada neste fluxo.
- Contexto MCP: redmine.remsoft.com.br, mario.tinelli (131789), projeto FinAi (65224), versão Livewire (20359). Antes de publicar, pai New (1)/Normal (4), sem filhas/anexo/Sequencing. Depois, permanece New e espelha 31, com requisito/campos/relações anteriores preservados.
- O responsável antecipou apenas o planejamento de F07. CA13, F05→F07 e a ordem de execução foram mantidas; após aprovação do complemento, publicaram-se F05 23–30 e F07 31–37.

## Evidências e caminho funcional

O titular usa o mesmo chat F06 para preparar dados, aceitar sugestões, revisar e confirmar individualmente. O resultado só é aceito com transação real no histórico F04, consulta atual F06 e indicadores F05 disponíveis, conforme CA13. Preparar o slicing antes do dashboard não equivale a implementar ou encerrar o aceite antes dele.

| Evidência                                                                                                                | Consequência                                                                                                                                                                                                                                 |
| ------------------------------------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Requisito local/remote #1016277; relações #888 F04→F07, #889 F06→F07, #900 F05→F07                                       | Aprovação funcional e dependências preservadas. O planejamento foi antecipado por decisão do responsável; não houve revisão de aceite.                                                                                                       |
| Buscas em app/routes/tests e inspeção anterior de modelos/rotas                                                          | Não há consumidor de propostas, chat ou transações implementado neste checkout. Nenhuma capacidade financeira é considerada existente apenas porque sua tarefa foi publicada.                                                                |
| F04 DEV #1016351–#1016355/QA #1016356 e F06 DEV #1016364–#1016368/QA #1016369, lidas pelo MCP                            | Fornecem regras/cadastro/histórico e chat/memória/consulta quando implementadas. Todas New; o esforço de F07 consome os fornecedores sem reconstruí-los.                                                                                     |
| F05 #1016275 lida com filhas/relações                                                                                    | New, sem filhas e sem Sequencing; ainda não há fornecedor específico ou tamanho de bloco definido para indicadores. Pai provisório só enquanto faltar sua decomposição.                                                                      |
| Composer laravel/ai 1.3.0; `vendor/laravel/ai/src/Approvals/PendingApproval.php`, mecanismos de memória já inspecionados | Há memória/aprovação genérica, mas não comprovam proposta financeira persistida, campos aceitos, resumo vigente, alvo ou uma gravação por proposta. Estado funcional e transições pertencem a F07; adequação de chat/storage pertence a F06. |
| V01, ZIP compartilhado, index.html showProposal(), cancelProposal(), completePending(), #transaction-dialog              | Fonte inspecionada. Protótipo tem um pending global, preenchimento de hoje/categoria e armazenamento local. Q10/Q11 aprovam várias propostas, consentimento explícito e estado real; não transportar esses atalhos como regra do produto.    |
| Grafo remoto completo da versão                                                                                          | 28 issues e 41 relações blocks, todos os endpoints lidos, sem ciclo; não há filho remoto a adotar ou preservar como externo neste pai.                                                                                                       |

Inspeção estática e leituras MCP, sem testes executados, criação de dados ou chamada de IA. Não há incerteza técnica objetiva que impeça descrever as entregas e exija Study; a pendência de numeração é de ordenação/publicação.

## Tarefas publicadas por referência local

As referências D01–D06/QA são identidades locais, não valores provisórios de Sequencing.

| Ref. | Título completo                                                                                                                                                   | Papel | Horas | Bloqueio de início              | Sequencing |
| ---- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----- | ----: | ------------------------------- | ---------- |
| D01  | [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Proposta completa e confirmação individual](https://redmine.remsoft.com.br/issues/1016386) | DEV   |   5,5 | QA F06 #1016369                 | 31         |
| D02  | [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Completar dados e aceitar sugestões](https://redmine.remsoft.com.br/issues/1016387)        | DEV   |   3,5 | D01                             | 32         |
| D03  | [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Correção pelo formulário](https://redmine.remsoft.com.br/issues/1016388)                   | DEV   |     2 | D01                             | 33         |
| D04  | [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Correção pela conversa](https://redmine.remsoft.com.br/issues/1016389)                     | DEV   |   2,5 | D01                             | 34         |
| D05  | [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Cancelamento individual](https://redmine.remsoft.com.br/issues/1016390)                    | DEV   |   1,5 | D01                             | 35         |
| D06  | [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Várias propostas independentes](https://redmine.remsoft.com.br/issues/1016391)             | DEV   |   3,5 | D01                             | 36         |
| QA   | [[QA] [WEB] [USUARIO] Registro de transações por IA com confirmação](https://redmine.remsoft.com.br/issues/1016392)                                               | QA    |     6 | D01–D06 e QA Dashboard #1016385 | 37         |

Estimativa aprovada e publicada: **18,5h DEV + 6h QA = 24,5h**, todas positivas até seis horas.

D01 reúne identificação/resumo/confirmação porque o primeiro registro revisado precisa ser útil e conferível de ponta a ponta, com preparo comum contado uma vez. Complementação por perguntas/sugestões são alternativas da mesma interação de preencher faltantes. Correção por formulário e por mensagem permanecem separadas: cada canal tem resultado próprio e pode ser priorizado/verificado independentemente. Cancelamento encerra uma intenção sem gravar. Multiplicidade acrescenta extração/arbitragem do conjunto, usando as operações individuais sem duplicá-las.

Consultas com pendências e preservação de outra proposta de mensagem anterior valem desde D01/D02; D06 não recebe a primeira responsabilidade por preservar o chat. Dashboard segue fornecedor de conclusão do efeito e bloqueio de início da QA completa.

## Estimativas e calibração

Dois pareceres independentes, `slicing_review_delivery` e `slicing_review_reuse`, receberam o mesmo requisito/evidências sem horas candidatas nem acesso às estimativas um do outro. Ambos revisaram os cortes antes das horas e recomendaram seis DEV. São propostas de esforço, não medições ou correções humanas.

| Parecer              | D01 | D02 | D03 | D04 | D05 | D06 |  QA | Total |
| -------------------- | --: | --: | --: | --: | --: | --: | --: | ----: |
| Entrega              | 5,5 | 3,5 | 1,5 | 2,5 |   1 | 3,5 |   6 |  23,5 |
| Reuso/cobertura      | 5,5 | 3,5 |   2 | 2,5 | 1,5 | 3,5 |   6 |  24,5 |
| Proposta responsável | 5,5 | 3,5 |   2 | 2,5 | 1,5 | 3,5 |   6 |  24,5 |

A proposta considera verificação de revisão e cancelamento persistidos entre sessões/controles antigos. Não é média nem escolha por voto. O preparo comum do estado/confirmação fica em D01; cadastro/validação F04 e canal/memória F06 não são reconstruídos.

Os dois pareceres revisaram as descrições finais formatadas e as condições contra o requisito. Foram corrigidas CT-003 para não obrigar sugestões específicas que o requisito apenas permite e CT-021 para exercitar falha definitiva de gravação financeira, separada do resultado incerto de CT-019. As fronteiras, cálculos, dependências, CA13 e pendência de Sequencing não receberam outra objeção material. A escrita mantém condições observáveis sem substituir o planejamento técnico de implementação.

| Entrega    | Base de esforço                                                                                                                                                                                   |
| ---------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| D01 — 5,5h | IA sobre dados explícitos, proposta/resumo persistido, confirmação financeira única, autorização, concorrência/resultado incerto e conferência real.                                              |
| D02 — 3,5h | Perguntas, sugestões fundamentadas, consentimento identificável, recusa e resumo completo com estado retomável.                                                                                   |
| D03 — 2h   | Formulário de revisão sobre interação F04, cinco campos, validação, resumo substituído e retomada sem gravação.                                                                                   |
| D04 — 2,5h | Interpretação da alteração/alvo, distinção de dado direto/sugestão, esclarecimento e atualização do resumo.                                                                                       |
| D05 — 1,5h | Cancelamento individual persistido, mensagens preservadas, bloqueio de controles antigos e nova intenção independente.                                                                            |
| D06 — 3,5h | Separação de movimentações, alvos, independência das operações e coexistência de estados/consultas.                                                                                               |
| QA — 6h    | Cerca de 1h preparo/controles, 2h jornadas reais/sugestões/revisões/multiplicidade, 1,25h falhas/concorrência/isolamento e três canais, 1h visual agrupado e 0,75h evidências/reteste focalizado. |

Premissas: executor familiar ao projeto, F04/F06 prontas, IA real e homologação acessíveis, sem infraestrutura adicional não conhecida. Preparar dados/falhas não é gratuito; espera por fornecedor/serviço é separada do esforço. QA não repete as suites inteiras de F04/F06/F05, mas verifica os efeitos e regressões causados pelo registro conversacional. Reteste amplo ou novo trabalho material exige recalibrar sem retirar cobertura.

Calibrações humanas anteriores: F04 10h DEV + 2h QA = 12h; F06 16h DEV + QA corrigida para 4h = 20h; Visual 17,5h e Acesso 3,5h. Não são tempos realizados. As diferenças de interpretação, estados e concorrência de F07 impedem copiar percentuais ou aplicar desconto uniforme.

## Cobertura

Cada operação mantém suas regras, autorização e falhas; referências comuns não significam duplicação da implementação do estado ou confirmação.

| Origem / parcela                                                 | Destino                                                                  | Condições                          |
| ---------------------------------------------------------------- | ------------------------------------------------------------------------ | ---------------------------------- |
| R1 — proposta não grava; só confirmação final                    | D01; D02–D05 preservam em cada operação                                  | CT-001/CT-003/CT-009/CT-023        |
| R2/R3 — faltantes, fundamento, sugestão, aceitação identificável | D02                                                                      | CT-002–CT-004                      |
| R2/R3 — nova sugestão na revisão                                 | D03 formulário; D04 mensagem                                             | CT-008/CT-010/CT-011               |
| R4 — extração múltipla, referência/alvo, sem lote                | D06                                                                      | CT-014–CT-017                      |
| R5 — validação da confirmação                                    | D01                                                                      | CT-005–CT-009                      |
| R5 — validação ao completar/revisar                              | D02 faltantes; D03 formulário; D04 mensagem                              | CT-005–CT-008/CT-010/CT-011        |
| R6 — Confirmar atual, texto não grava                            | D01                                                                      | CT-009/CT-018/CT-019               |
| R6/R7 — resumo substituído após correção                         | D03 formulário; D04 mensagem                                             | CT-010–CT-012                      |
| R8 — cancelamento e não reativação                               | D05                                                                      | CT-013/CT-020                      |
| R9 — uma gravação por proposta, duas intenções iguais            | D01; D06 amplia no conjunto extraído da mesma mensagem                   | CT-017–CT-019                      |
| R10 — estado persistido/titularidade                             | D01 base; cada operação guarda seu próprio estado em D02–D06             | CT-012/CT-013/CT-020/CT-021/CT-024 |
| R11 — efeitos financeiros e propostas sem efeito                 | D01 confirmação; D06 resultado independente do conjunto                  | CT-022/CT-023                      |
| R12 — IA real, contexto F06 e limites                            | D01; D04 interpretação corretiva; D06 extração múltipla                  | CT-001/CT-011/CT-014/CT-022/CT-025 |
| R13 — apresentação                                               | Cada DEV na sua operação; QA compara o conjunto adaptado                 | CT-026/CT-027                      |
| CA01 — interpretação completa                                    | D01                                                                      | CT-001                             |
| CA02 — várias propostas e ações independentes                    | D06 integra operações D01–D05                                            | CT-014–CT-017                      |
| CA03/CA04 — sugestões/sem invenção                               | D02; D06 resolve alvos múltiplos                                         | CT-002–CT-004/CT-015               |
| CA05 — aceitação diferente de gravação                           | D02 aceitação; D01 botão final                                           | CT-003/CT-009                      |
| CA06 — limites comuns                                            | D01 confirmação; D02 completude; D03/D04 revisão própria                 | CT-005–CT-008                      |
| CA07 — correção                                                  | D03 formulário; D04 conversa                                             | CT-010–CT-012                      |
| CA08 — cancelar                                                  | D05; D06 preserva vizinhas                                               | CT-013/CT-016                      |
| CA09 — confirmação/repetição/iguais                              | D01; D06 múltiplas legítimas                                             | CT-017–CT-019                      |
| CA10 — retomar/isolar estados                                    | Cada operação no seu estado; D06 conjunto                                | CT-020/CT-024                      |
| CA11 — consultas com pendências                                  | D01/D02 única pronta/incompleta; D06 conjunto                            | CT-022                             |
| CA12 — falhas/resultado incerto                                  | Cada operação; D01 confirmação incerta                                   | CT-019/CT-021                      |
| CA13 — três canais reais disponíveis                             | D01 efeito; D06 conjunto; QA integrada com F05 obrigatória               | CT-023/CT-027                      |
| CA14 — fronteira financeira e acesso                             | D01 base/confirmação; D03/D04 não editam registradas; cada ação autoriza | CT-024/CT-025                      |
| CA15 — fidelidade adaptada                                       | Cada DEV operação própria; QA integral                                   | CT-026/CT-027                      |

Nenhum critério foi transferido ao futuro para permitir fechar F07. A ausência atual de dashboard impede o aceite integrado, não a descrição do trabalho.

## Condições de teste

Fonte: [condicoes-teste-r001.md](condicoes-teste-r001.md). Documento de revisão: [1016277 - Condições de testes.docx](<r001/1016277 - Condições de testes.docx>), destinado à única QA quando a publicação puder ser aprovada integralmente.

Pai: Registro de transações por IA com confirmação — #1016277.
Projeto: FinAi (65224). Versão: Livewire (20359).
Revisão: r001, prévia de 13/11/2026. Condições não executadas.

### Contexto

Executar pelo mesmo chat real e persistido de F06, com F04, F06 e dashboard F05 implementados e disponíveis para o aceite integrado. O planejamento de F07 foi antecipado; CA13 e a dependência do dashboard permanecem aprovados. Publicação de fornecedores em New não comprova implementação. Não substituir IA real ou indicadores por simulação, testes internos ou aceite prometido para uma Feature futura.

Usar homologação com IA real configurada, contas confirmadas A/B, conta pendente, visitante e perfis administrativos/de suporte sem acesso financeiro de terceiros. Preparar duas sessões/abas e outro navegador da mesma conta, relógio controlável em America/Sao_Paulo, latência, perda de resposta e falhas reversíveis de IA, salvamento de proposta/revisão e gravação financeira. Contas e controles são preparo da QA; não se presume ambiente de falhas pronto ou uso gratuito do serviço. Espera por acesso/fornecedor fica separada do esforço ativo.

Fixar hoje em 13/11/2026 para exemplos e limites relativos, ou preparar datas equivalentes mantendo as mesmas relações. Registrar previamente saldo, totais e recentes de A, sem movimentações de B misturadas. Usar mensagens completas de receita e despesa com cinco campos explícitos, como “Registre despesa de R$ 30,00, descrição Almoço, categoria Alimentação, data 13/11/2026”. Conferir os dados em histórico/detalhes F04, novas consultas F06 e dashboard F05. Propostas de despesas R$ 30,00 e R$ 15,00 só produzem duas transações e efeito conjunto R$ 45,00 se ambas forem confirmadas individualmente.

Aplicar as regras de F04: cinco campos obrigatórios; BRL positivo até R$ 999.999.999,99 com até duas casas, sem arredondamento silencioso; descrição de 1–120 caracteres após retirar espaços nas extremidades; datas reais de 01/01/1900 até hoje no fuso aprovado; receitas Salário, Freelance, Rendimentos e Outras receitas; despesas Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras e Outras despesas. Datas relativas expressas podem ser convertidas, mas data omitida não é preenchida silenciosamente.

Visual V01: docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip, entrada index.html, #assistant, #messages, proposta de showProposal(), .dialog-actions e revisão em #transaction-dialog; considerar as regras visuais finais e DESIGN-HANDOFF.md. Aplicar as adaptações já aprovadas para várias propostas e aceitação explícita de sugestões, ausentes na interação simplificada do protótipo.

Comparar em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px. Preservar a composição F01 e os controles F06 de até 500 caracteres, Enter, Shift+Enter, processamento e sugestões. Registrar resultado/evidência por condição, defeitos e reteste focalizado.

### CT-001 — Proposta completa com IA real

Verificação: Enviar mensagens completas de receita e despesa com os cinco campos explícitos, usando linguagem variada e datas relativas explicitamente informadas.

Resultado esperado: IA real reconhece os dados e apresenta proposta/resumo com tipo, valor, descrição, categoria e data revisáveis. A data relativa é exibida como data concreta. Interpretação e resumo não criam transação nem alteram indicadores.

Origem no requisito: R1, R5, R12; CA01, CA05, CA06, CA13.

### CT-002 — Dados faltantes sem invenção

Verificação: Omitir separadamente valor, tipo, descrição, categoria e data; usar contexto insuficiente para fundamentar os campos omitidos.

Resultado esperado: Perguntar pelo que falta, sem inventar valor financeiro, presumir tipo, hoje ou categoria geral. Não permitir confirmação final enquanto houver campo ausente, ambíguo, não aceito ou inválido.

Origem no requisito: R1–R3, R5; CA03–CA06.

### CT-003 — Sugestões consentidas e duas decisões

Verificação: Em uma proposta incompleta, exercer um cenário em que a IA apresente sugestões fundamentadas e aceitar inequivocamente os campos identificados, inclusive em uma pergunta conjunta da mesma proposta. “Gastei 30 no almoço” é exemplo possível; não exigir Alimentação e hoje como sugestões obrigatórias. Perguntar em vez de sugerir também é válido. No cenário com sugestões, aguardar sem responder, navegar e consultar antes de aceitar.

Resultado esperado: Sugestões ficam identificadas e não adotadas por silêncio/navegação/consulta. Aceitação explícita preenche somente os campos indicados e pode habilitar o resumo completo; ainda não grava. Só Confirmar individual no resumo atual registra a transação.

Origem no requisito: R1–R3, R6; CA03, CA05, CA13.

### CT-004 — Recusa e alteração de sugestão

Verificação: Recusar sugestão de categoria/data e fornecer outro dado válido; responder de forma ambígua quando a aceitação puder ter mais de um alvo.

Resultado esperado: Adotar apenas dado explícito ou sugestão expressamente aceita, validar e refletir o resumo atual. Pedir identificação quando houver ambiguidade. Nova sugestão não é aceita automaticamente nem reaproveita autorização de um resumo anterior.

Origem no requisito: R2, R3, R5–R7; CA03–CA07.

### CT-005 — Valores e precisão comuns

Verificação: Por mensagem e revisão, testar 0,01, 35,90, 1.234,56 e 999.999.999,99; tentar zero, negativo, 1.000.000.000,00 e 35,901, inclusive por colagem no formulário.

Resultado esperado: Valores válidos preservam centavos; inválidos não habilitam gravação. Não arredondar nem transformar silenciosamente 35,901 em outro valor. Despesa é indicada pelo tipo, sem valor negativo.

Origem no requisito: R5; CA06.

### CT-006 — Descrição e campos obrigatórios

Verificação: Revisar propostas com omissão de cada campo, descrição só de espaços, 1/120/121 caracteres após retirar espaços nas extremidades e tipo inválido.

Resultado esperado: Somente cinco campos presentes e válidos permitem resumo confirmável; descrição válida preserva o texto após retirar espaços externos. Recusar excesso sem truncar e apresentar orientação corrigível, sem gravação parcial.

Origem no requisito: R1, R5; CA05, CA06.

### CT-007 — Datas e fuso

Verificação: Informar hoje, ontem, 01/01/1900, data passada válida, 31/12/1899, data inexistente e amanhã; repetir próximo à virada do dia em São Paulo.

Resultado esperado: Converter somente referências expressas e aceitar datas reais de 01/01/1900 a hoje em America/Sao_Paulo. Exibir a data que será salva. Data omitida exige pergunta/sugestão aceita; inválida/futura não é ajustada silenciosamente.

Origem no requisito: R2, R5; CA03, CA06.

### CT-008 — Catálogo e troca de tipo

Verificação: Usar categorias válidas de receita/despesa, inclusive as duas opções Outras; tentar categoria inexistente/incompatível e trocar o tipo por ambos os canais de revisão.

Resultado esperado: Usar catálogo F04 sem criar categoria. Troca de tipo exige classificação compatível; nova sugestão da IA precisa de aceitação, e campo incompatível impede confirmar. Não substituir silenciosamente por categoria geral.

Origem no requisito: R2, R5, R7, R12; CA03, CA06, CA07, CA14.

### CT-009 — Confirmação final pelo controle atual

Verificação: Com proposta pronta, enviar “sim”, “confirmo” ou pedido genérico de confirmar por texto, depois usar Confirmar do resumo atual.

Resultado esperado: Texto ou aceitação de campos não grava; orientar o botão da proposta pronta. Confirmar atual grava somente a proposta completa e válida com os dados revisados, informa sucesso após persistir e marca registrada.

Origem no requisito: R1, R3, R6, R9; CA05, CA09.

### CT-010 — Revisão pelo formulário

Verificação: Abrir Corrigir e alterar cada um dos cinco campos pelo formulário; salvar a revisão e conferir novamente o resumo antes de confirmar.

Resultado esperado: A revisão valida conforme F04, atualiza a proposta persistida e apresenta novo resumo sem criar transação. Os dados novos são os que a confirmação atual gravará.

Origem no requisito: R5–R7, R10; CA06, CA07, CA10.

### CT-011 — Revisão pela conversa

Verificação: Pedir correção com alvo inequívoco, por exemplo alterar valor ou data de uma proposta identificada. Tentar alvo/campo ambíguo e correção que leve a uma nova sugestão.

Resultado esperado: Validar dados expressos, pedir esclarecimento quando necessário e exigir aceitação de nova sugestão. Atualizar a proposta e resumo persistidos sem gravar transação ou alterar outra proposta.

Origem no requisito: R2, R3, R5–R7, R10; CA04, CA06, CA07, CA10.

### CT-012 — Resumos substituídos e outra aba

Verificação: Abrir o mesmo resumo em duas sessões, corrigir campos em uma e tentar Confirmar pelo controle antigo na outra, inclusive após nova sugestão.

Resultado esperado: O resumo antigo não grava nem usa dados anteriores. Cada ação respeita o estado atual; só a versão atual completa, validada e aceita pode ser confirmada.

Origem no requisito: R6, R7, R9, R10; CA07, CA09, CA10.

### CT-013 — Cancelamento persistido

Verificação: Cancelar uma proposta, retornar à conversa e tentar confirmar por controle antigo ou outra aba. Enviar depois uma nova intenção equivalente.

Resultado esperado: Informar que a proposta cancelada não foi registrada; preservar mensagens e não reativá-la. Nova intenção pode gerar outra proposta independente, com revisão e confirmação próprias.

Origem no requisito: R8–R10; CA08, CA10.

### CT-014 — Várias movimentações em uma mensagem

Verificação: Enviar “gastei 30 no almoço e 15 no transporte” e completar os dados necessários de cada proposta.

Resultado esperado: Apresentar duas propostas distinguíveis sem somar valores. Cada uma conserva seus dados, perguntas, sugestões e ações individuais; não existe confirmação final em lote.

Origem no requisito: R2–R5; CA02–CA05.

### CT-015 — Alvos e respostas ambíguas

Verificação: Com várias propostas/perguntas pendentes, responder “sim”, “mude para 40” ou “cancele” sem alvo inequívoco; depois identificar a proposta pretendida.

Resultado esperado: Pedir esclarecimento antes de aceitar, corrigir, cancelar ou registrar. A resposta identificada afeta somente o alvo correto; uma aceitação não vale para propostas vizinhas.

Origem no requisito: R3, R4, R10; CA02, CA04, CA05.

### CT-016 — Estados independentes entre propostas

Verificação: Deixar uma proposta incompleta, outra pronta e outra cancelada. Confirmar a pronta, completar outra depois e revisar uma proposta específica.

Resultado esperado: Cada ação preserva os estados das demais. Uma pronta pode ser confirmada com outra incompleta, e uma cancelada não impede as restantes. Não sobrescrever pendências de mensagens anteriores.

Origem no requisito: R4, R6–R10; CA02, CA07–CA10.

### CT-017 — Duas propostas legítimas iguais

Verificação: Criar duas propostas intencionais com os mesmos cinco campos e confirmar cada uma separadamente.

Resultado esperado: Criar dois registros legítimos, uma vez por proposta. Igualdade dos dados não confunde duas intenções com repetição do mesmo comando.

Origem no requisito: R4, R9; CA02, CA09.

### CT-018 — Cliques repetidos e concorrência

Verificação: Com latência, repetir Confirmar e confirmar a mesma proposta em duas abas/navegadores; reabrir uma proposta já registrada.

Resultado esperado: Gravar no máximo uma transação para essa proposta. Controles antigos, estado registrado e retorno ao histórico não habilitam outra gravação; feedback respeita o registro efetivo.

Origem no requisito: R6, R9, R10; CA09, CA10.

### CT-019 — Confirmação com resultado incerto

Verificação: Provocar perda de resposta depois de uma possível gravação e retomar/tentar novamente.

Resultado esperado: Conferir o resultado real antes de induzir repetição; reconhecer transação já registrada em vez de duplicá-la. Não anunciar sucesso fictício nem perder a relação da proposta com seu registro.

Origem no requisito: R9–R11; CA09, CA12.

### CT-020 — Retomada dos estados reais

Verificação: Recarregar, sair/entrar e usar outro navegador com campos pendentes, sugestões não aceitas, resumo atual, proposta corrigida, cancelada e registrada.

Resultado esperado: Retomar no mesmo chat com os estados efetivamente salvos. Registradas, canceladas ou substituídas não voltam a oferecer ação válida de gravação; sugestões pendentes não se tornam aceitas.

Origem no requisito: R1–R3, R6–R10; CA03, CA07–CA10.

### CT-021 — Falhas de interpretação e preservação

Verificação: Provocar falhas reversíveis de IA, salvamento de proposta, salvamento de correção/cancelamento e gravação financeira antes de concluir a transação. Conferir histórico F04, nova consulta F06 e dashboard F05, reabrir a conversa, restabelecer o serviço e tentar novamente após conferir o resultado real. CT-019 cobre separadamente a perda de resposta após possível gravação.

Resultado esperado: Informar o problema com retomada coerente. Não tratar classificação incerta como aceita, estado não salvo como preservado ou mensagem como registro financeiro. Falha da gravação não anuncia sucesso, deixa registro parcial ou modifica os três canais; manter a proposta retomável pelo estado efetivamente salvo e permitir nova tentativa sem duplicação após conferir o resultado. Reabrir usa somente o estado confirmado no sistema.

Origem no requisito: R1, R2, R7–R12; CA04, CA07–CA10, CA12, CA13.

### CT-022 — Consultas durante pendências

Verificação: Perguntar saldo/totais com proposta pronta não confirmada e com campos/sugestões pendentes; repetir com várias propostas e depois de confirmar apenas uma.

Resultado esperado: F06 responde com transações atuais reais, sem confirmar, cancelar ou perder pendências. Valores não confirmados não entram nas respostas; após confirmar uma, só esse registro novo passa a compor o resultado.

Origem no requisito: R1, R4, R10–R12; CA11, CA13.

### CT-023 — Efeito real no histórico, consultas e dashboard

Verificação: Antes e depois de confirmar, consultar histórico/detalhes F04, nova resposta F06 e indicadores/recentes F05. Usar receita/despesa de mês atual e anterior; comparar também proposta só sugerida, campos aceitos e proposta cancelada.

Resultado esperado: Somente confirmação bem-sucedida cria registro real com os cinco campos revisados e atualiza superfícies disponíveis sem novo login. Saldo considera todo o histórico; totais do mês respeitam a data, e propostas não confirmadas/canceladas não alteram nenhum canal. Todos os três canais precisam estar disponíveis na conclusão.

Origem no requisito: R1, R5, R9–R11; CA05, CA08, CA09, CA11, CA13.

### CT-024 — Acesso e titularidade

Verificação: Como visitante/conta pendente, tentar propor e confirmar. Com A/B, adulterar referências de proposta/resumo e pedir por mensagem ações na conta alheia; repetir como administração/suporte e após troca de conta.

Resultado esperado: Nenhum acesso ou ação contorna a confirmação de e-mail, o titular ou o estado atual. Outra conta não lê, completa, aceita, corrige, cancela ou confirma propostas alheias; privilégios administrativos/de suporte não concedem acesso adicional.

Origem no requisito: R10, R12; CA10, CA14.

### CT-025 — Operações sobre transações já registradas

Verificação: Pedir alteração/exclusão de transação já confirmada por conversa ou usar Corrigir de proposta registrada. Pedir previsão futura ou categoria personalizada.

Resultado esperado: Orientar detalhes e ações reais de F04 para editar/excluir; não confundir revisão de proposta com manutenção de transação existente. Não lançar futuro, criar categoria ou ampliar permissões.

Origem no requisito: R5, R7, R12; CA06, CA14.

### CT-026 — Fidelidade visual das propostas

Verificação: Comparar V01 com proposta única e várias, dados longos, sugestões pendentes/aceitas, resumo completo, revisão, processamento, falha, cancelamento e registro, nas nove dimensões/transições do contexto. Usar mouse e teclado.

Resultado esperado: Preservar linguagem F01/F06, hierarquia, tipografia e controles. Referência de cada proposta e alvo de Confirmar/Corrigir/Cancelar permanecem claros; os cinco campos são legíveis e acessíveis para revisão. Não encobrir conteúdo/foco com navegação, causar rolagem horizontal da página ou exibir simulação e mecanismos internos. A avaliação compara a referência e as adaptações aprovadas de multiplicidade/consentimento.

Origem no requisito: R4, R10, R13; CA02, CA03, CA07, CA15.

### CT-027 — Jornada integrada e preservação do chat

Verificação: No chat F06, usar botão, sugestões, Enter e Shift+Enter com o limite de 500 caracteres; preparar propostas, esclarecer, aceitar sugestões, revisar por ambos os canais, cancelar, confirmar individualmente e retomar em outro navegador. Conferir os três canais de CT-023.

Resultado esperado: O mesmo assistente mantém mensagens, limites e estados verdadeiros, com IA real e sem segunda conversa. A jornada inteira conclui com confirmação e efeitos reais, sem esperar dashboard futuro, simular funções ou substituir o aceite por chamadas internas.

Origem no requisito: Fluxo principal; R1–R13; CA01–CA15.

## Descrições completas

### D01 — [DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Proposta completa e confirmação individual

#### Entrega

Permitir que uma mensagem com os cinco campos explícitos gere uma proposta revisável no mesmo chat de F06 e que o titular registre uma única transação ao usar Confirmar no resumo completo atual, conferindo os dados nos canais reais.

#### Escopo e limites

Reconhecimento por IA, proposta persistida, resumo e confirmação ficam juntos porque somente o resultado completo permite ao usuário revisar e registrar sua intenção pelo canal aprovado. O preparo comum do estado das propostas pertence a esta primeira interação, consumindo chat F06 e cadastro/regras F04 já entregues. Não criar uma tarefa técnica isolada de armazenamento.

Completar dados omitidos, revisar campos já definidos por formulário ou mensagem, cancelar e extrair várias movimentações da mesma mensagem têm entregas próprias. Não oferecer controles dessas operações como se já funcionassem. Uma nova mensagem/intenção não deve sobrescrever outra proposta pendente; a multiplicidade em uma única mensagem é ampliada em Várias propostas independentes.

#### Critérios de aceite

- Interpretar por IA real mensagens completas de receita/despesa e apresentar tipo, valor, descrição, categoria e data exatamente informados. Datas relativas expressas são convertidas em America/Sao_Paulo e exibidas como data revisável; nenhum campo omitido é preenchido silenciosamente.
- Mensagem, interpretação e resumo não criam transação. Dados ausentes, ambíguos ou inválidos impedem confirmar e recebem orientação; o diálogo de complementação é entregue em Completar dados e aceitar sugestões.
- Aplicar F04: cinco campos obrigatórios; BRL maior que zero até R$ 999.999.999,99, até duas casas sem arredondar ou transformar entrada inválida; descrição de 1–120 caracteres após retirar espaços nas extremidades; data real de 01/01/1900 até hoje em America/Sao_Paulo.
- Exigir categoria existente e compatível com receita/despesa no catálogo F04, incluindo Outras receitas/Outras despesas. Não criar categoria, usar negativo para despesa, truncar texto ou ajustar data/valor silenciosamente.
- Somente Confirmar da proposta completa, válida e atual grava; “sim”, aceitação de campos ou pedido de confirmação por texto orientam o botão, sem gravar.
- Cada confirmação verifica titular e estado atual, salva os cinco campos revisados, marca a proposta registrada e informa sucesso somente após persistir. Cliques repetidos, outra aba/navegador e controles antigos não geram outra transação.
- Duas propostas intencionais de dados iguais são permitidas, cada uma registrada no máximo uma vez por confirmação própria.
- Persistir estado e vínculo do resultado no mesmo chat, preservando mensagens e autoria. Retornar, trocar de navegador ou recarregar não reativa proposta registrada nem transforma estado não salvo em preservado.
- Falha de IA/proposta/gravação informa o problema e permite retomada coerente, sem sucesso ou alteração parcial. Resultado incerto exige consultar o registro real antes de induzir repetição e reconhecer a transação existente se a gravação ocorreu.
- Consultas de F06 continuam disponíveis com uma proposta pendente e após novas mensagens; não confirmam, cancelam ou perdem pendências. Só registros confirmados entram no saldo/totais, e respostas históricas continuam preservadas.
- Após confirmar, encontrar a mesma transação no histórico/detalhes F04, nas novas consultas F06 e nos indicadores F05, sem novo login, respeitando tipo, valor, categoria e data/mês. Proposta apenas preparada não altera esses canais.
- Restringir proposta, resumo, estado e confirmação ao titular autenticado e confirmado, inclusive por referência direta ou instrução no chat. Visitante/conta pendente e administração/suporte não recebem acesso financeiro de terceiros.
- Pedidos de editar/excluir transação já registrada orientam F04; correção da proposta não altera registro financeiro existente.
- Comparar proposta, resumo e estados de processamento, erro, retomada e registro com V01/F01/F06 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px. Os cinco campos são legíveis, o alvo de Confirmar é claro e foco/teclado/ações ficam alcançáveis, sem sobreposição, rolagem horizontal da página, simulação ou mecanismos internos.

#### Dependências

O início depende de [[QA] [WEB] [USUARIO] Assistente de consulta financeira](https://redmine.remsoft.com.br/issues/1016369), que já consome F04 verificada por [QA #1016356](https://redmine.remsoft.com.br/issues/1016356), identidade e base visual. As tarefas publicadas estão New e não comprovam implementação.

Para concluir o efeito integrado, é necessário [Dashboard financeiro #1016275](https://redmine.remsoft.com.br/issues/1016275) entregue e verificado por [QA] [WEB] [USUARIO] Dashboard financeiro, proposta com Sequencing 30 na decomposição F05, conforme CA13. Essa identificação específica substitui o fornecedor provisório da prévia, sem alterar capacidade ou aceite. Sua ausência não impede preparar o slicing ou iniciar desenvolvimento com F06 pronta, mas impede concluir esse aceite e a QA integral. Preservar a relação original F05→F07.

#### Referências

[Pai #1016277](https://redmine.remsoft.com.br/issues/1016277); R1/R5/R6/R9–R13; CA01/CA05/CA06/CA09–CA15 nas parcelas de confirmação/canal; CT-001/CT-002, CT-005–CT-009, CT-017–CT-025, CT-026/CT-027.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, regras visuais finais e `DESIGN-HANDOFF.md`. Locadores: #assistant, #messages, showProposal() e .dialog-actions. Persistência, IA real e confirmação pelo estado atual substituem o armazenamento local e o comportamento simplificado do protótipo.

Intenção estável de criação: `docs/harness/features/1016277-registro-de-transacoes-por-ia-com-confirmacao/slices/slices.md#D01-r001`.

### D02 — [DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Completar dados e aceitar sugestões

#### Entrega

Permitir completar uma proposta com dados faltantes por perguntas e sugestões fundamentadas, adotando apenas informações expressas ou expressamente aceitas, até obter um resumo válido que ainda exige confirmação individual.

#### Escopo e limites

Perguntar e sugerir são alternativas da mesma interação de completar campos sem suposição silenciosa. Esta entrega forma o primeiro resumo completo a partir dos dados pendentes; alterar campos já definidos de uma proposta é tratado pelas entregas de correção. A aceitação não é uma autorização financeira.

#### Critérios de aceite

- Distinguir dados explícitos de ausentes/ambíguos em tipo, valor, descrição, categoria e data e perguntar pelo que falta quando não houver fundamento, sem inventar valores ou presumir hoje, tipo ou categoria geral.
- Identificar sugestões fundamentadas como sugestões e perguntar se podem ser adotadas. Enquanto não aceitas, não compõem os dados confirmados nem habilitam gravação.
- Permitir pergunta conjunta com sugestões claramente identificadas da mesma proposta e aceitação inequívoca conjunta; resposta com mais de um alvo possível pede esclarecimento antes de alterar campos.
- Recusa e dado alternativo expresso são permitidos. Adotar somente os campos indicados/aceitos, validando conforme F04 sem truncar, arredondar, corrigir data ou classificar silenciosamente.
- Exigir cinco campos presentes/válidos antes do resumo confirmável: BRL positivo até R$ 999.999.999,99 com até duas casas; descrição de 1–120 caracteres após retirar espaços externos; datas reais de 01/01/1900 até hoje em America/Sao_Paulo; categoria existente compatível com o tipo.
- Aceitar uma sugestão, navegar, consultar ou enviar “sim” não grava transação. O resumo completo permanece sujeito a Confirmar individual atual.
- Persistir campos pendentes, sugestões não aceitas, dados aceitos e resumo no mesmo chat. Recarregar/retomar não converte sugestão em aceitação ou reativa estado substituído.
- Consultas F06 com proposta incompleta ou sugestão pendente usam apenas transações reais, sem alterar, perder ou confirmar a pendência. Nenhum efeito financeiro ocorre antes da confirmação final.
- Falhas de interpretação/persistência informam o problema e permitem retomada pelo estado realmente salvo, sem afirmar aceitação/preservação fictícias. Cada ação respeita o titular confirmado e o estado atual, inclusive por outra aba ou referência direta.
- Comparar perguntas, sugestões pendentes/aceitas, recusas e resumo com V01/F01/F06 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, aplicando a adaptação aprovada de consentimento explícito. Campos, nomes, foco, teclado e alvo permanecem claros/legíveis, sem controles cobertos ou rolagem horizontal da página.

#### Dependências

O início depende de Registro de transações por IA com confirmação - Proposta completa e confirmação individual, que fornece o estado persistido, o chat e a confirmação final. Dashboard F05 continua necessário ao aceite integrado da Feature; não reconstruir esse fornecedor.

#### Referências

[Pai #1016277](https://redmine.remsoft.com.br/issues/1016277); R1–R3/R5/R6/R10–R13; CA03–CA06/CA10–CA15 nas parcelas de complementação; CT-002–CT-009, CT-020–CT-024, CT-026/CT-027.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, regras visuais finais e `DESIGN-HANDOFF.md`. Locadores: #assistant, #messages, showProposal() e .dialog-actions. Q11/CA03–CA05 aprovam a aceitação explícita em lugar de preenchimento automático.

Intenção estável de criação: `docs/harness/features/1016277-registro-de-transacoes-por-ia-com-confirmacao/slices/slices.md#D02-r001`.

### D03 — [DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Correção pelo formulário

#### Entrega

Permitir revisar os cinco campos de uma proposta pelo formulário, preservar a alteração como proposta e apresentar novo resumo, invalidando a confirmação anterior sem criar transação.

#### Escopo e limites

O formulário é um canal completo e verificável de revisão de dados explícitos, independente da interpretação de uma mensagem corretiva. Usar a apresentação e as regras F04; a gravação final permanece na confirmação atual, e esta revisão não edita transação já registrada.

#### Critérios de aceite

- Corrigir abre os cinco campos atuais da proposta e permite alterar tipo, valor, descrição, categoria e data.
- Salvar a revisão atualiza somente a proposta persistida, com novo resumo e os mesmos dados que a confirmação posterior gravará; não cria transação.
- Validar cinco campos obrigatórios, receita/despesa, BRL positivo até R$ 999.999.999,99 com até duas casas sem transformação silenciosa, descrição de 1–120 caracteres após retirar espaços externos e data real entre 01/01/1900 e hoje em America/Sao_Paulo.
- Troca de tipo exige categoria existente/compatível do catálogo F04, sem categoria improvisada ou fallback silencioso. Se surgir nova sugestão, exigir aceitação antes de incorporá-la.
- Revisão/nova sugestão invalida o resumo anterior. Confirmar por controle antigo em outra aba não grava; verificar estado atual e titular antes de atualizar ou confirmar.
- Recarregar ou usar outro navegador preserva a revisão efetivamente salva e não reativa resumos substituídos. Falha não anuncia preservação/gravação fictícia e permite retomada coerente.
- Não revisar como proposta um registro já confirmado: orientar as ações reais de F04. Manter consultas F06 e os demais dados da conversa sem efeitos financeiros antes de Confirmar.
- Comparar #transaction-dialog e novo resumo com V01/F01/F06 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, incluindo preenchimento, validação, processamento, erro e retomada. Manter os cinco campos, foco/teclado e ações legíveis/alcançáveis, sem sobreposição, rolagem horizontal ou mecanismos internos.

#### Dependências

O início depende de Registro de transações por IA com confirmação - Proposta completa e confirmação individual. Para concluir casos de novas sugestões, integrar Completar dados e aceitar sugestões; isso não bloqueia iniciar a revisão de dados expressos. Correção pela conversa tem aceite independente.

#### Referências

[Pai #1016277](https://redmine.remsoft.com.br/issues/1016277); R5–R7/R9/R10/R12/R13; CA06/CA07/CA09/CA10/CA12/CA14/CA15; CT-005–CT-008, CT-010/CT-012, CT-020/CT-021/CT-024–CT-027.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, regras visuais finais e `DESIGN-HANDOFF.md`. Locadores: #transaction-dialog, campos de revisão F04, showProposal() e .dialog-actions; Q10/Q11 preservam alvo individual e aceitação de sugestão.

Intenção estável de criação: `docs/harness/features/1016277-registro-de-transacoes-por-ia-com-confirmacao/slices/slices.md#D03-r001`.

### D04 — [DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Correção pela conversa

#### Entrega

Permitir alterar dados já definidos de uma proposta por mensagem com alvo claro, distinguindo correção expressa de nova sugestão, e apresentar resumo atual sem gravar transação.

#### Escopo e limites

A correção por linguagem natural tem aceite próprio: exige interpretar intenção, campo e alvo, enquanto o formulário recebe campos explicitamente escolhidos. Não duplicar o preparo do estado da proposta ou transformar a conversa em edição de transações registradas.

#### Critérios de aceite

- Interpretar por IA real alteração de tipo, valor, descrição, categoria ou data com proposta/campo inequívocos; pedir esclarecimento quando o alvo ou a alteração forem ambíguos.
- Dado fornecido diretamente pelo usuário é validado; dado sugerido pela IA continua exigindo aceitação identificável, sem completar silenciosamente data, categoria ou tipo.
- Aplicar cinco campos obrigatórios e F04: BRL positivo até R$ 999.999.999,99 com até duas casas; descrição de 1–120 caracteres após retirar espaços externos; data real de 01/01/1900 até hoje em America/Sao_Paulo; categoria existente compatível. Não arredondar, truncar ou ajustar inválidos para salvá-los.
- Trocar tipo requer classificação compatível e aceitação de qualquer nova sugestão; enquanto incompleta/inválida, a proposta não permite confirmação.
- Persistir a alteração como proposta, apresentar novo resumo e invalidar controles do anterior, inclusive em outra aba. A correção não grava transação e só a confirmação do resumo atual pode fazê-lo.
- Preservar dados e estados efetivamente salvos ao retornar ou usar outro navegador. Falha de interpretação/salvamento não altera alvo errado, anuncia sucesso fictício ou autoriza duplicação.
- Autorizar titular confirmado e estado atual em cada ação; manter consultas e mensagens da mesma conversa sem gravar/cancelar pendências por efeito de uma consulta. Para transação registrada, orientar F04.
- Comparar mensagens corretivas, esclarecimento, nova sugestão e resumo com V01/F01/F06 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px. Manter autoria, dados extensos, foco/teclado e ações legíveis com alvo claro, sem sobreposição, rolagem horizontal ou mecanismos internos.

#### Dependências

O início depende de Registro de transações por IA com confirmação - Proposta completa e confirmação individual. Para concluir o tratamento de novas sugestões, integrar Completar dados e aceitar sugestões. O canal por formulário não é bloqueador; ambos preservam as mesmas regras e estado atual.

#### Referências

[Pai #1016277](https://redmine.remsoft.com.br/issues/1016277); R2/R3/R5–R7/R9/R10/R12/R13; CA04/CA06/CA07/CA09/CA10/CA12/CA14/CA15; CT-004–CT-008, CT-011/CT-012, CT-020–CT-027.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, regras visuais finais e `DESIGN-HANDOFF.md`. Locadores: #assistant, #messages, #chat-form, showProposal() e .dialog-actions, com adaptação aprovada de alvo e aceitação explícita.

Intenção estável de criação: `docs/harness/features/1016277-registro-de-transacoes-por-ia-com-confirmacao/slices/slices.md#D04-r001`.

### D05 — [DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Cancelamento individual

#### Entrega

Permitir cancelar uma proposta sem transação, preservando as mensagens e o estado cancelado no mesmo chat e impedindo confirmação por controles antigos.

#### Escopo e limites

Cancelar a proposta encerra somente essa intenção. Uma nova intenção pode gerar outra proposta com revisão e confirmação próprias; não excluir mensagens ou transação já registrada.

#### Critérios de aceite

- Cancelar identifica a proposta e informa que ela não foi registrada, sem criar transação ou alterar saldo, totais, histórico e consultas.
- Persistir estado cancelado e preservar mensagens. Recarregar, sair/entrar ou usar outro navegador não reativa a proposta nem habilita confirmação por controle antigo.
- Autorizar titular confirmado e estado atual em cada ação. Outra conta/referência direta não pode cancelar; proposta já registrada recebe orientação para manutenção em F04.
- Falha ao preservar cancelamento informa o problema, não apresenta estado não salvo como concluído e permite retomada coerente pelo estado real.
- Nova intenção após cancelamento pode gerar nova proposta independente, que exige revisão e confirmação próprias. Cancelar não afeta pendências vizinhas; Várias propostas independentes amplia a verificação no conjunto extraído da mesma mensagem.
- Comparar cancelamento, processamento, erro e retomada com V01/F01/F06 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px. Manter alvo, estado e mensagens legíveis, com foco/teclado e controles alcançáveis, sem sobreposição, rolagem horizontal ou mecanismos internos.

#### Dependências

O início depende de Registro de transações por IA com confirmação - Proposta completa e confirmação individual. Não aguarda correção ou complementação para cancelar uma proposta pronta. Integrar os estados incompletos quando Completar dados e aceitar sugestões estiver disponível.

#### Referências

[Pai #1016277](https://redmine.remsoft.com.br/issues/1016277); R4/R8–R10/R13; CA02/CA08/CA10/CA12–CA15 nas parcelas de cancelamento; CT-013/CT-016/CT-020–CT-027.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, regras visuais finais e `DESIGN-HANDOFF.md`. Locadores: showProposal(), Cancelar em .dialog-actions e #messages, preservando histórico e alvo individual.

Intenção estável de criação: `docs/harness/features/1016277-registro-de-transacoes-por-ia-com-confirmacao/slices/slices.md#D05-r001`.

### D06 — [DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Várias propostas independentes

#### Entrega

Permitir que uma mensagem origine várias propostas distinguíveis e que o titular complete, revise, cancele e confirme cada uma individualmente, mantendo as outras em seus estados próprios.

#### Escopo e limites

Esta entrega acrescenta a extração de várias movimentações da mesma mensagem e a identificação/arbitragem de alvos. As operações individuais vêm das tarefas responsáveis. Consultas com pendências já devem funcionar desde a primeira proposta; aqui se preservam com várias pendências simultâneas.

#### Critérios de aceite

- Interpretar por IA real mensagens com várias movimentações e separá-las sem unir valores ou misturar campos. Exibir referência visível que permita reconhecer cada proposta.
- Cada proposta conserva seus campos, perguntas, sugestões pendentes/aceitas e resumo atual. Uma resposta inequívoca só afeta o alvo indicado; diante de múltiplos alvos possíveis, pedir esclarecimento antes de modificar estado.
- Cada Confirmar registra somente sua proposta completa/atual. Não oferecer confirmação final em lote nem interpretar um “sim” genérico como autorização de todas.
- Permitir confirmar uma pronta com outra incompleta, completar outra depois e cancelar/revisar uma sem afetar as vizinhas. Nenhuma nova mensagem sobrescreve pendência anterior.
- Duas propostas intencionais de mesmos dados podem gerar dois registros legítimos, uma confirmação por proposta; repetição, controles antigos ou outra aba não duplicam a mesma proposta.
- Consultas F06 usam só transações reais sem confirmar/cancelar/perder pendências. Após confirmar uma, a nova consulta considera esse registro e mantém as demais em seus estados.
- Persistir estados independentes ao retornar/trocar de navegador, respeitando titularidade, resumos substituídos e estados cancelado/registrado. Falha em uma operação não anuncia estado fictício ou aplica ação a outra proposta.
- Com F05 disponível, confirmar individualmente e conferir os efeitos reais no histórico, chat e dashboard; propostas não confirmadas/canceladas não afetam indicadores, e a data de cada registro governa seu mês.
- Comparar várias propostas, dados longos, sugestões e ações com V01/F01/F06 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, usando a adaptação aprovada de Q10/Q11. Preservar legibilidade, foco/teclado, acesso aos cinco campos e alvo de cada ação, sem sobreposição, rolagem horizontal, simulação ou mecanismos internos.

#### Dependências

O início depende de Registro de transações por IA com confirmação - Proposta completa e confirmação individual. Para concluir a cobertura múltipla, integrar Completar dados e aceitar sugestões, Correção pelo formulário, Correção pela conversa e Cancelamento individual. Não bloquear o início por mero compartilhamento dessas operações.

Dashboard financeiro #1016275, verificado por [QA] [WEB] [USUARIO] Dashboard financeiro da proposta F05 (Sequencing 30), continua fornecedor necessário ao efeito integrado. Esse complemento de fornecedor está em revisão, sem alterar a relação original #900 ou o aceite.

#### Referências

[Pai #1016277](https://redmine.remsoft.com.br/issues/1016277); R2–R11/R13 nas parcelas de multiplicidade; CA02–CA05/CA07–CA13/CA15; CT-003/CT-004/CT-008, CT-012–CT-024, CT-026/CT-027.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, regras visuais finais e `DESIGN-HANDOFF.md`. Locadores: #messages, showProposal() e .dialog-actions; Q10/Q11/CA02–CA05/CA15 aprovam propostas distinguíveis e consentimento por alvo.

Intenção estável de criação: `docs/harness/features/1016277-registro-de-transacoes-por-ia-com-confirmacao/slices/slices.md#D06-r001`.

## Publicação conferida — complemento aplicado

### QA — [QA] [WEB] [USUARIO] Registro de transações por IA com confirmação

#### Entrega

Verificar o fluxo inteiro de registro por IA real no chat existente, das mensagens às propostas e confirmações individuais, com estados persistidos e efeitos reais no histórico, nas consultas e no dashboard, cobrindo CT-001–CT-027 r001.

#### Escopo e limites

Executar uma única QA da Feature. Preparar dados/contas, relógio, falhas reversíveis, latência, duas sessões/navegadores e acesso à IA real; registrar resultados, defeitos e reteste focalizado. Fakes e verificações internas apoiam integridade, mas não substituem o canal real nem a comparação visual.

F04, F06 e F05 precisam estar entregues. O planejamento antecipado não autoriza concluir CA13 com um dashboard futuro ou simulado.

#### Critérios de aceite

- Executar CT-001–CT-027, registrando resultado/evidência e cobrindo R1–R13 e CA01–CA15; condições não executadas permanecem explícitas.
- Interpretar receita/despesa completas por IA real, obter resumo dos cinco campos e confirmar uma única transação pelos dados revisados.
- Verificar campos omitidos, sugestões fundamentadas e aceitação identificável; “sim”, silêncio, navegação ou consulta não equivalem a confirmação financeira.
- Recusar valores inválidos ou acima de R$ 999.999.999,99, mais de duas casas, descrição fora de 1–120 caracteres após espaços externos, datas anteriores a 01/01/1900/inexistentes/futuras e categorias inexistentes/incompatíveis, sem ajustes silenciosos.
- Revisar cada campo pelo formulário e pela conversa, exigir aceitação de nova sugestão e impedir confirmação de resumo substituído, inclusive em outra aba.
- Cancelar individualmente sem transação, preservando mensagens e estado, e retomar propostas em todos os estados por outro navegador.
- Separar várias propostas da mesma mensagem, reconhecer alvos ambíguos, operar uma sem alterar outra e permitir duas intenções iguais com confirmações separadas.
- Conferir cliques repetidos, concorrência e resposta incerta sem duplicar uma gravação; falhas de IA, proposta/revisão e gravação final não geram sucesso fictício.
- Conferir consultas durante pendências e após confirmação, sem que consultas confirmem/cancelem pendências ou incluam dados não registrados.
- Verificar isolamento, confirmação de e-mail, referências diretas e ausência de acesso financeiro de terceiros por administração/suporte.
- Conferir orientação a F04 para editar/excluir registros já criados, sem transformar revisão de proposta em alteração financeira.
- Após confirmar, confrontar os mesmos dados em F04, F06 e indicadores/recentes F05, sem novo login e respeitando data/tipo/categoria; aceitação de campo e cancelamento não alteram nenhum desses canais.
- Comparar proposta única/múltipla, sugestões, revisão e estados com V01 sobre F01/F06 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, mantendo alvo, dados extensos, foco, teclado e controles legíveis/alcançáveis, sem sobreposição ou rolagem horizontal. Preservar limites e envio do chat F06 e não exibir simulação ou mecanismos internos.

#### Dependências

Executar após as seis entregas Registro de transações por IA com confirmação - Proposta completa e confirmação individual; Completar dados e aceitar sugestões; Correção pelo formulário; Correção pela conversa; Cancelamento individual; e Várias propostas independentes.

[Dashboard financeiro #1016275](https://redmine.remsoft.com.br/issues/1016275), verificado por [QA] [WEB] [USUARIO] Dashboard financeiro da proposta F05 (Sequencing 30), fornece os indicadores reais necessários para iniciar a QA integrada e concluir CA13. Esse fornecedor específico substitui a referência provisória da prévia no complemento em revisão. Chat e transações são fornecidos por [QA F06 #1016369](https://redmine.remsoft.com.br/issues/1016369) e [QA F04 #1016356](https://redmine.remsoft.com.br/issues/1016356). Publicação em New não demonstra disponibilidade.

#### Referências

[Pai #1016277](https://redmine.remsoft.com.br/issues/1016277); R1–R13, CA01–CA15; CT-001–CT-027 r001; anexo previsto `1016277 - Condições de testes.docx`.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, regras visuais finais e `DESIGN-HANDOFF.md`. Locadores: #assistant, #messages, showProposal(), .dialog-actions e #transaction-dialog; adaptações Q10/Q11 para multiplicidade e sugestões explícitas.

Intenção estável de criação: `docs/harness/features/1016277-registro-de-transacoes-por-ia-com-confirmacao/slices/slices.md#QA-r001`.

### Destino e campos preparados

Sete filhas novas no projeto 65224, versão 20359, pai 1016277. Não há adoções, filhas externas ou Study. Conteúdo funcional aprovado; o complemento de Sequencing e fornecedor específico abaixo depende de decisão antes da publicação.

| Campo                                           | D01–D06                                       | QA                                                                 |
| ----------------------------------------------- | --------------------------------------------- | ------------------------------------------------------------------ |
| subject                                         | Título completo de cada descrição             | [QA] [WEB] [USUARIO] Registro de transações por IA com confirmação |
| tracker_id                                      | Task (4)                                      | Deliverable (5)                                                    |
| status_id / priority_id                         | New (1) / Normal (4)                          | New (1) / Normal (4)                                               |
| project_id / fixed_version_id / parent_issue_id | 65224 / 20359 / 1016277                       | 65224 / 20359 / 1016277                                            |
| estimated_hours                                 | 5.5 / 3.5 / 2 / 2.5 / 1.5 / 3.5               | 6                                                                  |
| custom_fields, Sequencing id 2                  | Propostos 31 / 32 / 33 / 34 / 35 / 36         | Proposto 37, posição final do bloco F07                            |
| responsável / categoria / datas                 | Sem atribuição/categoria/datas por inferência | Idem                                                               |
| description                                     | Seções completas e identidade estável acima   | Idem, CT-001–CT-027 e anexo previsto                               |

Pai #1016277 atualizado e relido: Sequencing id 2, vazio→31. Status New, requisito, versão, prioridade, campos e relações alheios preservados. Nenhum comentário adicional foi publicado.

### Relações preparadas

Direção blocks: origem bloqueia o início do destino. Fornecimento necessário apenas à conclusão consta das descrições, sem bloqueio artificial de início.

| Origem                                                                                                                 | Destino                                                                                                                | Motivo                                                                                               |
| ---------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------- |
| [#1016369 — [QA] [WEB] [USUARIO] Assistente de consulta financeira](https://redmine.remsoft.com.br/issues/1016369)     | D01 — [DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Proposta completa e confirmação individual | Chat real e consultas sobre F04 verificada.                                                          |
| D01 — [DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Proposta completa e confirmação individual | Cada uma de D02–D06, com os títulos completos acima                                                                    | Cinco relações: proposta persistida/confirmação antes das operações individuais e extração múltipla. |
| Cada uma de D01–D06, com os títulos completos acima                                                                    | QA — [QA] [WEB] [USUARIO] Registro de transações por IA com confirmação                                                | Seis relações, uma por DEV, antes do aceite completo.                                                |
| QA F05 — [QA] [WEB] [USUARIO] Dashboard financeiro (proposta, Sequencing 30)                                           | QA — [QA] [WEB] [USUARIO] Registro de transações por IA com confirmação                                                | Fornecedor específico de início da QA integrada: indicadores reais para CA13.                        |

Delta preparado: treze relações novas, acíclicas sobre o grafo lido. O complemento substitui somente o endpoint provisório planejado F05-pai→QA F07 por QA F05→QA F07; não há relação provisória nativa criada para remover. Preservar todas as 41 atuais, inclusive #888, #889 e a relação original do Project Flow #900. Não remover ou refinar outras relações implicitamente.

### Documento QA

Arquivo r001: `slices/r001/1016277 - Condições de testes.docx`, pai #1016277, contexto e CT-001–CT-027 com origem. Ferramentas já disponíveis: Word 16.0 e league/commonmark 2.10.7; sem instalar dependências ou novo conversor.

DOCX real gerado no Word 16.0 e conferido: pacote ZIP/OpenXML válido, 27 condições, texto integral equivalente à fonte revisada normalizando apenas espaços e marcação de títulos; 21.309 bytes. A fonte corresponde integralmente ao espelho nesta prévia. Fonte/documento não comprovam execução.

Upload/associação pelo MCP concluídos na [QA #1016392](https://redmine.remsoft.com.br/issues/1016392), [anexo #3367](https://redmine.remsoft.com.br/attachments/download/3367/1016277%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx), descrição “Condições de teste r001 — Registro de transações por IA com confirmação”. Nome, identidade, descrição e 21.309 bytes confirmados; nenhuma alteração no DOCX aprovado ou remoção de anexos anteriores.

## Sequencing proposto e complemento em revisão

Leitura completa MCP: projeto 65224/versão aberta 20359, status *, todos os trackers, offset 0/limit 100/total 28. Campo Sequencing id 2. Ocupações válidas 1–22: Visual 1–8, Acesso 9–10, Transações 11–16 e Consultas IA 17–22; pais espelham o primeiro filho. F05/F07 ainda não numeradas no remoto.

A [prévia do Dashboard](../../1016275-dashboard-financeiro/slices/slices.md) agora contém sete DEV e uma QA: bloco proposto 23–30, pai #1016275 espelha 23. Com esse tamanho conhecido, o complemento propõe F07 D01–D06 em **31–36**, QA em **37**, pai #1016277 espelha **31**. Não há reserva fictícia, preenchimento de lacuna ou renumeração alheia.

O conteúdo funcional da F07 já foi aprovado. Falta decidir apenas esse complemento exato e o fornecedor específico QA Dashboard financeiro, proposto com Sequencing 30, junto à decisão sobre a nova F05. A sequência preserva a relação #900/CA13 e antecipa somente o planejamento da F07, sem inverter a execução.

Publicar primeiro F05 e depois F07 somente após essa decisão. Antes de escrever, renovar contexto/versão/grafo/pais/filhas; colisão exige conciliar, sem mudar números autorizados silenciosamente. Nenhum número foi gravado ou filha criada neste trabalho.

## Revisão e publicação

O responsável aprovou seis DEV, uma QA, 24,5h, descrições, condições/DOCX r001; depois aprovou o complemento exato 31–37/pai31 e a QA Dashboard financeiro como fornecedor, junto à F05. Tudo foi publicado e conferido, preservando o conteúdo funcional e o anexo aprovados.

| Operação autorizada         | ID/URL conhecido                                                                                                                                                                           | Resultado                                                                  | Próximo passo                                                     |
| --------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------- | ----------------------------------------------------------------- |
| Criar D01                   | [#1016386](https://redmine.remsoft.com.br/issues/1016386)                                                                                                                                  | Confirmada: descrição/campos, 5,5h, Sequencing 31                          | Planejamento/execução na etapa própria, respeitando dependências. |
| Criar D02                   | [#1016387](https://redmine.remsoft.com.br/issues/1016387)                                                                                                                                  | Confirmada: descrição/campos, 3,5h, Sequencing 32                          | Planejamento/execução na etapa própria, respeitando dependências. |
| Criar D03                   | [#1016388](https://redmine.remsoft.com.br/issues/1016388)                                                                                                                                  | Confirmada: descrição/campos, 2h, Sequencing 33                            | Planejamento/execução na etapa própria, respeitando dependências. |
| Criar D04                   | [#1016389](https://redmine.remsoft.com.br/issues/1016389)                                                                                                                                  | Confirmada: descrição/campos, 2,5h, Sequencing 34                          | Planejamento/execução na etapa própria, respeitando dependências. |
| Criar D05                   | [#1016390](https://redmine.remsoft.com.br/issues/1016390)                                                                                                                                  | Confirmada: descrição/campos, 1,5h, Sequencing 35                          | Planejamento/execução na etapa própria, respeitando dependências. |
| Criar D06                   | [#1016391](https://redmine.remsoft.com.br/issues/1016391)                                                                                                                                  | Confirmada: descrição/campos, 3,5h, Sequencing 36                          | Planejamento/execução na etapa própria, respeitando dependências. |
| Criar QA                    | [#1016392](https://redmine.remsoft.com.br/issues/1016392)                                                                                                                                  | Confirmada: descrição/campos, 6h, Sequencing 37                            | Planejamento/execução na etapa própria, respeitando dependências. |
| Criar treze relações blocks | Relações #940–#952; fornecedores #1016369 e QA F05 #1016385                                                                                                                                | Confirmadas pelos endpoints; #900 e demais relações anteriores preservadas | Sem pendência de publicação.                                      |
| Numerar filhas 31–37/pai31  | Pai #1016277; filhas #1016386–#1016392                                                                                                                                                     | Bloco integral e âncora confirmados; sem renumerar terceiros               | Sem pendência de publicação.                                      |
| Anexar DOCX r001            | [QA #1016392](https://redmine.remsoft.com.br/issues/1016392), [anexo #3367](https://redmine.remsoft.com.br/attachments/download/3367/1016277%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx) | Conferido, 21.309 bytes e 27 CT equivalentes à fonte                       | Execução futura pela QA.                                          |
| Materializar task.md        | Sete arquivos por ID listados abaixo                                                                                                                                                       | Concluída após conferência integral remota                                 | Etapas próprias de planejamento/execução.                         |

## Resultado consolidado e pendências

Publicado e conferido: seis DEV #1016386–#1016391 (18,5h) e QA #1016392 (6h), total 24,5h, todas New. Bloco 31–37/pai31, relações #940–#952 e anexo #3367 confirmados. A QA Dashboard #1016385 fornece o aceite integrado; a relação #900 foi preservada. Critérios, horas, condições e DOCX aprovados foram mantidos; não houve implementação ou QA executada.

Sem pendência de publicação. O complemento aprovado foi aplicado, e o requisito mantém efeitos reais em F04/F06/F05 para concluir CA13. Fornecedores ainda New não liberam execução automaticamente. O próximo passo é planejamento/execução das DEV, mantendo a ordem aprovada.

| Ref. | Issue confirmada                                          | Arquivo materializado                                                                |
| ---- | --------------------------------------------------------- | ------------------------------------------------------------------------------------ |
| D01  | [#1016386](https://redmine.remsoft.com.br/issues/1016386) | [task.md](../tasks/dev-1016386-proposta-completa-e-confirmacao-individual/task.md)   |
| D02  | [#1016387](https://redmine.remsoft.com.br/issues/1016387) | [task.md](../tasks/dev-1016387-completar-dados-e-aceitar-sugestoes/task.md)          |
| D03  | [#1016388](https://redmine.remsoft.com.br/issues/1016388) | [task.md](../tasks/dev-1016388-correcao-pelo-formulario/task.md)                     |
| D04  | [#1016389](https://redmine.remsoft.com.br/issues/1016389) | [task.md](../tasks/dev-1016389-correcao-pela-conversa/task.md)                       |
| D05  | [#1016390](https://redmine.remsoft.com.br/issues/1016390) | [task.md](../tasks/dev-1016390-cancelamento-individual/task.md)                      |
| D06  | [#1016391](https://redmine.remsoft.com.br/issues/1016391) | [task.md](../tasks/dev-1016391-varias-propostas-independentes/task.md)               |
| QA   | [#1016392](https://redmine.remsoft.com.br/issues/1016392) | [task.md](../tasks/qa-1016392-registro-de-transacoes-por-ia-com-confirmacao/task.md) |
