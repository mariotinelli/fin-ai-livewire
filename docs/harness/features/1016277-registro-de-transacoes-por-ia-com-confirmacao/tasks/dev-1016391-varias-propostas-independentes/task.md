# [DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Várias propostas independentes

## Identidade e fontes

- Filha: [#1016391](https://redmine.remsoft.com.br/issues/1016391); papel: DEV; status remoto conferido: New.
- Pai: [#1016277](https://redmine.remsoft.com.br/issues/1016277); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **36**; pai espelha 31.
- Estimativa: **3,5h**, proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Proposta completa e confirmação individual — #1016386](https://redmine.remsoft.com.br/issues/1016386).
- Fornecedor do aceite financeiro integrado: [[QA] [WEB] [USUARIO] Dashboard financeiro — #1016385](https://redmine.remsoft.com.br/issues/1016385), preservando CA13 e a dependência original F05→F07.
- Condições: [CT-001–CT-027, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016277 - Condições de testes.docx>), [anexo #3367 da QA #1016392](https://redmine.remsoft.com.br/attachments/download/3367/1016277%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Permitir que uma mensagem origine várias propostas distinguíveis e que o titular complete, revise, cancele e confirme cada uma individualmente, mantendo as outras em seus estados próprios.

## Escopo e limites

Esta entrega acrescenta a extração de várias movimentações da mesma mensagem e a identificação/arbitragem de alvos. As operações individuais vêm das tarefas responsáveis. Consultas com pendências já devem funcionar desde a primeira proposta; aqui se preservam com várias pendências simultâneas.

## Critérios de aceite

- Interpretar por IA real mensagens com várias movimentações e separá-las sem unir valores ou misturar campos. Exibir referência visível que permita reconhecer cada proposta.
- Cada proposta conserva seus campos, perguntas, sugestões pendentes/aceitas e resumo atual. Uma resposta inequívoca só afeta o alvo indicado; diante de múltiplos alvos possíveis, pedir esclarecimento antes de modificar estado.
- Cada Confirmar registra somente sua proposta completa/atual. Não oferecer confirmação final em lote nem interpretar um “sim” genérico como autorização de todas.
- Permitir confirmar uma pronta com outra incompleta, completar outra depois e cancelar/revisar uma sem afetar as vizinhas. Nenhuma nova mensagem sobrescreve pendência anterior.
- Duas propostas intencionais de mesmos dados podem gerar dois registros legítimos, uma confirmação por proposta; repetição, controles antigos ou outra aba não duplicam a mesma proposta.
- Consultas F06 usam só transações reais sem confirmar/cancelar/perder pendências. Após confirmar uma, a nova consulta considera esse registro e mantém as demais em seus estados.
- Persistir estados independentes ao retornar/trocar de navegador, respeitando titularidade, resumos substituídos e estados cancelado/registrado. Falha em uma operação não anuncia estado fictício ou aplica ação a outra proposta.
- Com F05 disponível, confirmar individualmente e conferir os efeitos reais no histórico, chat e dashboard; propostas não confirmadas/canceladas não afetam indicadores, e a data de cada registro governa seu mês.
- Comparar várias propostas, dados longos, sugestões e ações com V01/F01/F06 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, usando a adaptação aprovada de Q10/Q11. Preservar legibilidade, foco/teclado, acesso aos cinco campos e alvo de cada ação, sem sobreposição, rolagem horizontal, simulação ou mecanismos internos.

## Dependências

O início depende de Registro de transações por IA com confirmação - Proposta completa e confirmação individual. Para concluir a cobertura múltipla, integrar Completar dados e aceitar sugestões, Correção pelo formulário, Correção pela conversa e Cancelamento individual. Não bloquear o início por mero compartilhamento dessas operações.

Dashboard financeiro #1016275, verificado por [QA] [WEB] [USUARIO] Dashboard financeiro da proposta F05 (Sequencing 30), continua fornecedor necessário ao efeito integrado. Esse complemento de fornecedor está em revisão, sem alterar a relação original #900 ou o aceite.

## Referências

[Pai #1016277](https://redmine.remsoft.com.br/issues/1016277); R2–R11/R13 nas parcelas de multiplicidade; CA02–CA05/CA07–CA13/CA15; CT-003/CT-004/CT-008, CT-012–CT-024, CT-026/CT-027.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, regras visuais finais e `DESIGN-HANDOFF.md`. Locadores: #messages, showProposal() e .dialog-actions; Q10/Q11/CA02–CA05/CA15 aprovam propostas distinguíveis e consentimento por alvo.

Intenção estável de criação: `docs/harness/features/1016277-registro-de-transacoes-por-ia-com-confirmacao/slices/slices.md#D06-r001`.
