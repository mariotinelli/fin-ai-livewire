# [DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Cancelamento individual

## Identidade e fontes

- Filha: [#1016390](https://redmine.remsoft.com.br/issues/1016390); papel: DEV; status remoto conferido: New.
- Pai: [#1016277](https://redmine.remsoft.com.br/issues/1016277); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **35**; pai espelha 31.
- Estimativa: **1,5h**, proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Proposta completa e confirmação individual — #1016386](https://redmine.remsoft.com.br/issues/1016386).
- Fornecedor do aceite financeiro integrado: [[QA] [WEB] [USUARIO] Dashboard financeiro — #1016385](https://redmine.remsoft.com.br/issues/1016385), preservando CA13 e a dependência original F05→F07.
- Condições: [CT-001–CT-027, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016277 - Condições de testes.docx>), [anexo #3367 da QA #1016392](https://redmine.remsoft.com.br/attachments/download/3367/1016277%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Permitir cancelar uma proposta sem transação, preservando as mensagens e o estado cancelado no mesmo chat e impedindo confirmação por controles antigos.

## Escopo e limites

Cancelar a proposta encerra somente essa intenção. Uma nova intenção pode gerar outra proposta com revisão e confirmação próprias; não excluir mensagens ou transação já registrada.

## Critérios de aceite

- Cancelar identifica a proposta e informa que ela não foi registrada, sem criar transação ou alterar saldo, totais, histórico e consultas.
- Persistir estado cancelado e preservar mensagens. Recarregar, sair/entrar ou usar outro navegador não reativa a proposta nem habilita confirmação por controle antigo.
- Autorizar titular confirmado e estado atual em cada ação. Outra conta/referência direta não pode cancelar; proposta já registrada recebe orientação para manutenção em F04.
- Falha ao preservar cancelamento informa o problema, não apresenta estado não salvo como concluído e permite retomada coerente pelo estado real.
- Nova intenção após cancelamento pode gerar nova proposta independente, que exige revisão e confirmação próprias. Cancelar não afeta pendências vizinhas; Várias propostas independentes amplia a verificação no conjunto extraído da mesma mensagem.
- Comparar cancelamento, processamento, erro e retomada com V01/F01/F06 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px. Manter alvo, estado e mensagens legíveis, com foco/teclado e controles alcançáveis, sem sobreposição, rolagem horizontal ou mecanismos internos.

## Dependências

O início depende de Registro de transações por IA com confirmação - Proposta completa e confirmação individual. Não aguarda correção ou complementação para cancelar uma proposta pronta. Integrar os estados incompletos quando Completar dados e aceitar sugestões estiver disponível.

## Referências

[Pai #1016277](https://redmine.remsoft.com.br/issues/1016277); R4/R8–R10/R13; CA02/CA08/CA10/CA12–CA15 nas parcelas de cancelamento; CT-013/CT-016/CT-020–CT-027.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, regras visuais finais e `DESIGN-HANDOFF.md`. Locadores: showProposal(), Cancelar em .dialog-actions e #messages, preservando histórico e alvo individual.

Intenção estável de criação: `docs/harness/features/1016277-registro-de-transacoes-por-ia-com-confirmacao/slices/slices.md#D05-r001`.
