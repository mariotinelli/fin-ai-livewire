# Condições de teste

Pai: Registro de transações por IA com confirmação — #1016277.
Projeto: FinAi (65224). Versão: Livewire (20359).
Revisão: r001, prévia de 13/11/2026. Condições não executadas.

## Contexto

Executar pelo mesmo chat real e persistido de F06, com F04, F06 e dashboard F05 implementados e disponíveis para o aceite integrado. O planejamento de F07 foi antecipado; CA13 e a dependência do dashboard permanecem aprovados. Publicação de fornecedores em New não comprova implementação. Não substituir IA real ou indicadores por simulação, testes internos ou aceite prometido para uma Feature futura.

Usar homologação com IA real configurada, contas confirmadas A/B, conta pendente, visitante e perfis administrativos/de suporte sem acesso financeiro de terceiros. Preparar duas sessões/abas e outro navegador da mesma conta, relógio controlável em America/Sao_Paulo, latência, perda de resposta e falhas reversíveis de IA, salvamento de proposta/revisão e gravação financeira. Contas e controles são preparo da QA; não se presume ambiente de falhas pronto ou uso gratuito do serviço. Espera por acesso/fornecedor fica separada do esforço ativo.

Fixar hoje em 13/11/2026 para exemplos e limites relativos, ou preparar datas equivalentes mantendo as mesmas relações. Registrar previamente saldo, totais e recentes de A, sem movimentações de B misturadas. Usar mensagens completas de receita e despesa com cinco campos explícitos, como “Registre despesa de R$ 30,00, descrição Almoço, categoria Alimentação, data 13/11/2026”. Conferir os dados em histórico/detalhes F04, novas consultas F06 e dashboard F05. Propostas de despesas R$ 30,00 e R$ 15,00 só produzem duas transações e efeito conjunto R$ 45,00 se ambas forem confirmadas individualmente.

Aplicar as regras de F04: cinco campos obrigatórios; BRL positivo até R$ 999.999.999,99 com até duas casas, sem arredondamento silencioso; descrição de 1–120 caracteres após retirar espaços nas extremidades; datas reais de 01/01/1900 até hoje no fuso aprovado; receitas Salário, Freelance, Rendimentos e Outras receitas; despesas Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras e Outras despesas. Datas relativas expressas podem ser convertidas, mas data omitida não é preenchida silenciosamente.

Visual V01: docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip, entrada index.html, #assistant, #messages, proposta de showProposal(), .dialog-actions e revisão em #transaction-dialog; considerar as regras visuais finais e DESIGN-HANDOFF.md. Aplicar as adaptações já aprovadas para várias propostas e aceitação explícita de sugestões, ausentes na interação simplificada do protótipo.

Comparar em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px. Preservar a composição F01 e os controles F06 de até 500 caracteres, Enter, Shift+Enter, processamento e sugestões. Registrar resultado/evidência por condição, defeitos e reteste focalizado.

## CT-001 — Proposta completa com IA real

Verificação: Enviar mensagens completas de receita e despesa com os cinco campos explícitos, usando linguagem variada e datas relativas explicitamente informadas.

Resultado esperado: IA real reconhece os dados e apresenta proposta/resumo com tipo, valor, descrição, categoria e data revisáveis. A data relativa é exibida como data concreta. Interpretação e resumo não criam transação nem alteram indicadores.

Origem no requisito: R1, R5, R12; CA01, CA05, CA06, CA13.

## CT-002 — Dados faltantes sem invenção

Verificação: Omitir separadamente valor, tipo, descrição, categoria e data; usar contexto insuficiente para fundamentar os campos omitidos.

Resultado esperado: Perguntar pelo que falta, sem inventar valor financeiro, presumir tipo, hoje ou categoria geral. Não permitir confirmação final enquanto houver campo ausente, ambíguo, não aceito ou inválido.

Origem no requisito: R1–R3, R5; CA03–CA06.

## CT-003 — Sugestões consentidas e duas decisões

Verificação: Em uma proposta incompleta, exercer um cenário em que a IA apresente sugestões fundamentadas e aceitar inequivocamente os campos identificados, inclusive em uma pergunta conjunta da mesma proposta. “Gastei 30 no almoço” é exemplo possível; não exigir Alimentação e hoje como sugestões obrigatórias. Perguntar em vez de sugerir também é válido. No cenário com sugestões, aguardar sem responder, navegar e consultar antes de aceitar.

Resultado esperado: Sugestões ficam identificadas e não adotadas por silêncio/navegação/consulta. Aceitação explícita preenche somente os campos indicados e pode habilitar o resumo completo; ainda não grava. Só Confirmar individual no resumo atual registra a transação.

Origem no requisito: R1–R3, R6; CA03, CA05, CA13.

## CT-004 — Recusa e alteração de sugestão

Verificação: Recusar sugestão de categoria/data e fornecer outro dado válido; responder de forma ambígua quando a aceitação puder ter mais de um alvo.

Resultado esperado: Adotar apenas dado explícito ou sugestão expressamente aceita, validar e refletir o resumo atual. Pedir identificação quando houver ambiguidade. Nova sugestão não é aceita automaticamente nem reaproveita autorização de um resumo anterior.

Origem no requisito: R2, R3, R5–R7; CA03–CA07.

## CT-005 — Valores e precisão comuns

Verificação: Por mensagem e revisão, testar 0,01, 35,90, 1.234,56 e 999.999.999,99; tentar zero, negativo, 1.000.000.000,00 e 35,901, inclusive por colagem no formulário.

Resultado esperado: Valores válidos preservam centavos; inválidos não habilitam gravação. Não arredondar nem transformar silenciosamente 35,901 em outro valor. Despesa é indicada pelo tipo, sem valor negativo.

Origem no requisito: R5; CA06.

## CT-006 — Descrição e campos obrigatórios

Verificação: Revisar propostas com omissão de cada campo, descrição só de espaços, 1/120/121 caracteres após retirar espaços nas extremidades e tipo inválido.

Resultado esperado: Somente cinco campos presentes e válidos permitem resumo confirmável; descrição válida preserva o texto após retirar espaços externos. Recusar excesso sem truncar e apresentar orientação corrigível, sem gravação parcial.

Origem no requisito: R1, R5; CA05, CA06.

## CT-007 — Datas e fuso

Verificação: Informar hoje, ontem, 01/01/1900, data passada válida, 31/12/1899, data inexistente e amanhã; repetir próximo à virada do dia em São Paulo.

Resultado esperado: Converter somente referências expressas e aceitar datas reais de 01/01/1900 a hoje em America/Sao_Paulo. Exibir a data que será salva. Data omitida exige pergunta/sugestão aceita; inválida/futura não é ajustada silenciosamente.

Origem no requisito: R2, R5; CA03, CA06.

## CT-008 — Catálogo e troca de tipo

Verificação: Usar categorias válidas de receita/despesa, inclusive as duas opções Outras; tentar categoria inexistente/incompatível e trocar o tipo por ambos os canais de revisão.

Resultado esperado: Usar catálogo F04 sem criar categoria. Troca de tipo exige classificação compatível; nova sugestão da IA precisa de aceitação, e campo incompatível impede confirmar. Não substituir silenciosamente por categoria geral.

Origem no requisito: R2, R5, R7, R12; CA03, CA06, CA07, CA14.

## CT-009 — Confirmação final pelo controle atual

Verificação: Com proposta pronta, enviar “sim”, “confirmo” ou pedido genérico de confirmar por texto, depois usar Confirmar do resumo atual.

Resultado esperado: Texto ou aceitação de campos não grava; orientar o botão da proposta pronta. Confirmar atual grava somente a proposta completa e válida com os dados revisados, informa sucesso após persistir e marca registrada.

Origem no requisito: R1, R3, R6, R9; CA05, CA09.

## CT-010 — Revisão pelo formulário

Verificação: Abrir Corrigir e alterar cada um dos cinco campos pelo formulário; salvar a revisão e conferir novamente o resumo antes de confirmar.

Resultado esperado: A revisão valida conforme F04, atualiza a proposta persistida e apresenta novo resumo sem criar transação. Os dados novos são os que a confirmação atual gravará.

Origem no requisito: R5–R7, R10; CA06, CA07, CA10.

## CT-011 — Revisão pela conversa

Verificação: Pedir correção com alvo inequívoco, por exemplo alterar valor ou data de uma proposta identificada. Tentar alvo/campo ambíguo e correção que leve a uma nova sugestão.

Resultado esperado: Validar dados expressos, pedir esclarecimento quando necessário e exigir aceitação de nova sugestão. Atualizar a proposta e resumo persistidos sem gravar transação ou alterar outra proposta.

Origem no requisito: R2, R3, R5–R7, R10; CA04, CA06, CA07, CA10.

## CT-012 — Resumos substituídos e outra aba

Verificação: Abrir o mesmo resumo em duas sessões, corrigir campos em uma e tentar Confirmar pelo controle antigo na outra, inclusive após nova sugestão.

Resultado esperado: O resumo antigo não grava nem usa dados anteriores. Cada ação respeita o estado atual; só a versão atual completa, validada e aceita pode ser confirmada.

Origem no requisito: R6, R7, R9, R10; CA07, CA09, CA10.

## CT-013 — Cancelamento persistido

Verificação: Cancelar uma proposta, retornar à conversa e tentar confirmar por controle antigo ou outra aba. Enviar depois uma nova intenção equivalente.

Resultado esperado: Informar que a proposta cancelada não foi registrada; preservar mensagens e não reativá-la. Nova intenção pode gerar outra proposta independente, com revisão e confirmação próprias.

Origem no requisito: R8–R10; CA08, CA10.

## CT-014 — Várias movimentações em uma mensagem

Verificação: Enviar “gastei 30 no almoço e 15 no transporte” e completar os dados necessários de cada proposta.

Resultado esperado: Apresentar duas propostas distinguíveis sem somar valores. Cada uma conserva seus dados, perguntas, sugestões e ações individuais; não existe confirmação final em lote.

Origem no requisito: R2–R5; CA02–CA05.

## CT-015 — Alvos e respostas ambíguas

Verificação: Com várias propostas/perguntas pendentes, responder “sim”, “mude para 40” ou “cancele” sem alvo inequívoco; depois identificar a proposta pretendida.

Resultado esperado: Pedir esclarecimento antes de aceitar, corrigir, cancelar ou registrar. A resposta identificada afeta somente o alvo correto; uma aceitação não vale para propostas vizinhas.

Origem no requisito: R3, R4, R10; CA02, CA04, CA05.

## CT-016 — Estados independentes entre propostas

Verificação: Deixar uma proposta incompleta, outra pronta e outra cancelada. Confirmar a pronta, completar outra depois e revisar uma proposta específica.

Resultado esperado: Cada ação preserva os estados das demais. Uma pronta pode ser confirmada com outra incompleta, e uma cancelada não impede as restantes. Não sobrescrever pendências de mensagens anteriores.

Origem no requisito: R4, R6–R10; CA02, CA07–CA10.

## CT-017 — Duas propostas legítimas iguais

Verificação: Criar duas propostas intencionais com os mesmos cinco campos e confirmar cada uma separadamente.

Resultado esperado: Criar dois registros legítimos, uma vez por proposta. Igualdade dos dados não confunde duas intenções com repetição do mesmo comando.

Origem no requisito: R4, R9; CA02, CA09.

## CT-018 — Cliques repetidos e concorrência

Verificação: Com latência, repetir Confirmar e confirmar a mesma proposta em duas abas/navegadores; reabrir uma proposta já registrada.

Resultado esperado: Gravar no máximo uma transação para essa proposta. Controles antigos, estado registrado e retorno ao histórico não habilitam outra gravação; feedback respeita o registro efetivo.

Origem no requisito: R6, R9, R10; CA09, CA10.

## CT-019 — Confirmação com resultado incerto

Verificação: Provocar perda de resposta depois de uma possível gravação e retomar/tentar novamente.

Resultado esperado: Conferir o resultado real antes de induzir repetição; reconhecer transação já registrada em vez de duplicá-la. Não anunciar sucesso fictício nem perder a relação da proposta com seu registro.

Origem no requisito: R9–R11; CA09, CA12.

## CT-020 — Retomada dos estados reais

Verificação: Recarregar, sair/entrar e usar outro navegador com campos pendentes, sugestões não aceitas, resumo atual, proposta corrigida, cancelada e registrada.

Resultado esperado: Retomar no mesmo chat com os estados efetivamente salvos. Registradas, canceladas ou substituídas não voltam a oferecer ação válida de gravação; sugestões pendentes não se tornam aceitas.

Origem no requisito: R1–R3, R6–R10; CA03, CA07–CA10.

## CT-021 — Falhas de interpretação e preservação

Verificação: Provocar falhas reversíveis de IA, salvamento de proposta, salvamento de correção/cancelamento e gravação financeira antes de concluir a transação. Conferir histórico F04, nova consulta F06 e dashboard F05, reabrir a conversa, restabelecer o serviço e tentar novamente após conferir o resultado real. CT-019 cobre separadamente a perda de resposta após possível gravação.

Resultado esperado: Informar o problema com retomada coerente. Não tratar classificação incerta como aceita, estado não salvo como preservado ou mensagem como registro financeiro. Falha da gravação não anuncia sucesso, deixa registro parcial ou modifica os três canais; manter a proposta retomável pelo estado efetivamente salvo e permitir nova tentativa sem duplicação após conferir o resultado. Reabrir usa somente o estado confirmado no sistema.

Origem no requisito: R1, R2, R7–R12; CA04, CA07–CA10, CA12, CA13.

## CT-022 — Consultas durante pendências

Verificação: Perguntar saldo/totais com proposta pronta não confirmada e com campos/sugestões pendentes; repetir com várias propostas e depois de confirmar apenas uma.

Resultado esperado: F06 responde com transações atuais reais, sem confirmar, cancelar ou perder pendências. Valores não confirmados não entram nas respostas; após confirmar uma, só esse registro novo passa a compor o resultado.

Origem no requisito: R1, R4, R10–R12; CA11, CA13.

## CT-023 — Efeito real no histórico, consultas e dashboard

Verificação: Antes e depois de confirmar, consultar histórico/detalhes F04, nova resposta F06 e indicadores/recentes F05. Usar receita/despesa de mês atual e anterior; comparar também proposta só sugerida, campos aceitos e proposta cancelada.

Resultado esperado: Somente confirmação bem-sucedida cria registro real com os cinco campos revisados e atualiza superfícies disponíveis sem novo login. Saldo considera todo o histórico; totais do mês respeitam a data, e propostas não confirmadas/canceladas não alteram nenhum canal. Todos os três canais precisam estar disponíveis na conclusão.

Origem no requisito: R1, R5, R9–R11; CA05, CA08, CA09, CA11, CA13.

## CT-024 — Acesso e titularidade

Verificação: Como visitante/conta pendente, tentar propor e confirmar. Com A/B, adulterar referências de proposta/resumo e pedir por mensagem ações na conta alheia; repetir como administração/suporte e após troca de conta.

Resultado esperado: Nenhum acesso ou ação contorna a confirmação de e-mail, o titular ou o estado atual. Outra conta não lê, completa, aceita, corrige, cancela ou confirma propostas alheias; privilégios administrativos/de suporte não concedem acesso adicional.

Origem no requisito: R10, R12; CA10, CA14.

## CT-025 — Operações sobre transações já registradas

Verificação: Pedir alteração/exclusão de transação já confirmada por conversa ou usar Corrigir de proposta registrada. Pedir previsão futura ou categoria personalizada.

Resultado esperado: Orientar detalhes e ações reais de F04 para editar/excluir; não confundir revisão de proposta com manutenção de transação existente. Não lançar futuro, criar categoria ou ampliar permissões.

Origem no requisito: R5, R7, R12; CA06, CA14.

## CT-026 — Fidelidade visual das propostas

Verificação: Comparar V01 com proposta única e várias, dados longos, sugestões pendentes/aceitas, resumo completo, revisão, processamento, falha, cancelamento e registro, nas nove dimensões/transições do contexto. Usar mouse e teclado.

Resultado esperado: Preservar linguagem F01/F06, hierarquia, tipografia e controles. Referência de cada proposta e alvo de Confirmar/Corrigir/Cancelar permanecem claros; os cinco campos são legíveis e acessíveis para revisão. Não encobrir conteúdo/foco com navegação, causar rolagem horizontal da página ou exibir simulação e mecanismos internos. A avaliação compara a referência e as adaptações aprovadas de multiplicidade/consentimento.

Origem no requisito: R4, R10, R13; CA02, CA03, CA07, CA15.

## CT-027 — Jornada integrada e preservação do chat

Verificação: No chat F06, usar botão, sugestões, Enter e Shift+Enter com o limite de 500 caracteres; preparar propostas, esclarecer, aceitar sugestões, revisar por ambos os canais, cancelar, confirmar individualmente e retomar em outro navegador. Conferir os três canais de CT-023.

Resultado esperado: O mesmo assistente mantém mensagens, limites e estados verdadeiros, com IA real e sem segunda conversa. A jornada inteira conclui com confirmação e efeitos reais, sem esperar dashboard futuro, simular funções ou substituir o aceite por chamadas internas.

Origem no requisito: Fluxo principal; R1–R13; CA01–CA15.
