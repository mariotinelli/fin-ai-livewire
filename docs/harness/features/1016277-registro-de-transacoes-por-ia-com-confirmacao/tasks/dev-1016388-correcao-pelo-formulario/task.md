# [DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Correção pelo formulário

## Identidade e fontes

- Filha: [#1016388](https://redmine.remsoft.com.br/issues/1016388); papel: DEV; status remoto conferido: New.
- Pai: [#1016277](https://redmine.remsoft.com.br/issues/1016277); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **33**; pai espelha 31.
- Estimativa: **2h**, proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Proposta completa e confirmação individual — #1016386](https://redmine.remsoft.com.br/issues/1016386).
- Fornecedor do aceite financeiro integrado: [[QA] [WEB] [USUARIO] Dashboard financeiro — #1016385](https://redmine.remsoft.com.br/issues/1016385), preservando CA13 e a dependência original F05→F07.
- Condições: [CT-001–CT-027, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016277 - Condições de testes.docx>), [anexo #3367 da QA #1016392](https://redmine.remsoft.com.br/attachments/download/3367/1016277%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Permitir revisar os cinco campos de uma proposta pelo formulário, preservar a alteração como proposta e apresentar novo resumo, invalidando a confirmação anterior sem criar transação.

## Escopo e limites

O formulário é um canal completo e verificável de revisão de dados explícitos, independente da interpretação de uma mensagem corretiva. Usar a apresentação e as regras F04; a gravação final permanece na confirmação atual, e esta revisão não edita transação já registrada.

## Critérios de aceite

- Corrigir abre os cinco campos atuais da proposta e permite alterar tipo, valor, descrição, categoria e data.
- Salvar a revisão atualiza somente a proposta persistida, com novo resumo e os mesmos dados que a confirmação posterior gravará; não cria transação.
- Validar cinco campos obrigatórios, receita/despesa, BRL positivo até R$ 999.999.999,99 com até duas casas sem transformação silenciosa, descrição de 1–120 caracteres após retirar espaços externos e data real entre 01/01/1900 e hoje em America/Sao_Paulo.
- Troca de tipo exige categoria existente/compatível do catálogo F04, sem categoria improvisada ou fallback silencioso. Se surgir nova sugestão, exigir aceitação antes de incorporá-la.
- Revisão/nova sugestão invalida o resumo anterior. Confirmar por controle antigo em outra aba não grava; verificar estado atual e titular antes de atualizar ou confirmar.
- Recarregar ou usar outro navegador preserva a revisão efetivamente salva e não reativa resumos substituídos. Falha não anuncia preservação/gravação fictícia e permite retomada coerente.
- Não revisar como proposta um registro já confirmado: orientar as ações reais de F04. Manter consultas F06 e os demais dados da conversa sem efeitos financeiros antes de Confirmar.
- Comparar #transaction-dialog e novo resumo com V01/F01/F06 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, incluindo preenchimento, validação, processamento, erro e retomada. Manter os cinco campos, foco/teclado e ações legíveis/alcançáveis, sem sobreposição, rolagem horizontal ou mecanismos internos.

## Dependências

O início depende de Registro de transações por IA com confirmação - Proposta completa e confirmação individual. Para concluir casos de novas sugestões, integrar Completar dados e aceitar sugestões; isso não bloqueia iniciar a revisão de dados expressos. Correção pela conversa tem aceite independente.

## Referências

[Pai #1016277](https://redmine.remsoft.com.br/issues/1016277); R5–R7/R9/R10/R12/R13; CA06/CA07/CA09/CA10/CA12/CA14/CA15; CT-005–CT-008, CT-010/CT-012, CT-020/CT-021/CT-024–CT-027.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, regras visuais finais e `DESIGN-HANDOFF.md`. Locadores: #transaction-dialog, campos de revisão F04, showProposal() e .dialog-actions; Q10/Q11 preservam alvo individual e aceitação de sugestão.

Intenção estável de criação: `docs/harness/features/1016277-registro-de-transacoes-por-ia-com-confirmacao/slices/slices.md#D03-r001`.
