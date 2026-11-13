# [QA] [WEB] [USUARIO] Registro de transações por IA com confirmação

## Identidade e fontes

- Filha: [#1016392](https://redmine.remsoft.com.br/issues/1016392); papel: QA; status remoto conferido: New.
- Pai: [#1016277](https://redmine.remsoft.com.br/issues/1016277); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **37**; pai espelha 31.
- Estimativa: **6h**, proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Proposta completa e confirmação individual — #1016386](https://redmine.remsoft.com.br/issues/1016386); [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Completar dados e aceitar sugestões — #1016387](https://redmine.remsoft.com.br/issues/1016387); [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Correção pelo formulário — #1016388](https://redmine.remsoft.com.br/issues/1016388); [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Correção pela conversa — #1016389](https://redmine.remsoft.com.br/issues/1016389); [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Cancelamento individual — #1016390](https://redmine.remsoft.com.br/issues/1016390); [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Várias propostas independentes — #1016391](https://redmine.remsoft.com.br/issues/1016391); [[QA] [WEB] [USUARIO] Dashboard financeiro — #1016385](https://redmine.remsoft.com.br/issues/1016385).
- Condições: [CT-001–CT-027, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016277 - Condições de testes.docx>), [anexo #3367 da QA #1016392](https://redmine.remsoft.com.br/attachments/download/3367/1016277%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Verificar o fluxo inteiro de registro por IA real no chat existente, das mensagens às propostas e confirmações individuais, com estados persistidos e efeitos reais no histórico, nas consultas e no dashboard, cobrindo CT-001–CT-027 r001.

## Escopo e limites

Executar uma única QA da Feature. Preparar dados/contas, relógio, falhas reversíveis, latência, duas sessões/navegadores e acesso à IA real; registrar resultados, defeitos e reteste focalizado. Fakes e verificações internas apoiam integridade, mas não substituem o canal real nem a comparação visual.

F04, F06 e F05 precisam estar entregues. O planejamento antecipado não autoriza concluir CA13 com um dashboard futuro ou simulado.

## Critérios de aceite

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

## Dependências

Executar após as seis entregas Registro de transações por IA com confirmação - Proposta completa e confirmação individual; Completar dados e aceitar sugestões; Correção pelo formulário; Correção pela conversa; Cancelamento individual; e Várias propostas independentes.

[Dashboard financeiro #1016275](https://redmine.remsoft.com.br/issues/1016275), verificado por [QA] [WEB] [USUARIO] Dashboard financeiro da proposta F05 (Sequencing 30), fornece os indicadores reais necessários para iniciar a QA integrada e concluir CA13. Esse fornecedor específico substitui a referência provisória da prévia no complemento em revisão. Chat e transações são fornecidos por [QA F06 #1016369](https://redmine.remsoft.com.br/issues/1016369) e [QA F04 #1016356](https://redmine.remsoft.com.br/issues/1016356). Publicação em New não demonstra disponibilidade.

## Referências

[Pai #1016277](https://redmine.remsoft.com.br/issues/1016277); R1–R13, CA01–CA15; CT-001–CT-027 r001; anexo previsto `1016277 - Condições de testes.docx`.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, regras visuais finais e `DESIGN-HANDOFF.md`. Locadores: #assistant, #messages, showProposal(), .dialog-actions e #transaction-dialog; adaptações Q10/Q11 para multiplicidade e sugestões explícitas.

Intenção estável de criação: `docs/harness/features/1016277-registro-de-transacoes-por-ia-com-confirmacao/slices/slices.md#QA-r001`.
