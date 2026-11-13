# [DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Correção pela conversa

## Identidade e fontes

- Filha: [#1016389](https://redmine.remsoft.com.br/issues/1016389); papel: DEV; status remoto conferido: New.
- Pai: [#1016277](https://redmine.remsoft.com.br/issues/1016277); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **34**; pai espelha 31.
- Estimativa: **2,5h**, proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Proposta completa e confirmação individual — #1016386](https://redmine.remsoft.com.br/issues/1016386).
- Fornecedor do aceite financeiro integrado: [[QA] [WEB] [USUARIO] Dashboard financeiro — #1016385](https://redmine.remsoft.com.br/issues/1016385), preservando CA13 e a dependência original F05→F07.
- Condições: [CT-001–CT-027, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016277 - Condições de testes.docx>), [anexo #3367 da QA #1016392](https://redmine.remsoft.com.br/attachments/download/3367/1016277%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Permitir alterar dados já definidos de uma proposta por mensagem com alvo claro, distinguindo correção expressa de nova sugestão, e apresentar resumo atual sem gravar transação.

## Escopo e limites

A correção por linguagem natural tem aceite próprio: exige interpretar intenção, campo e alvo, enquanto o formulário recebe campos explicitamente escolhidos. Não duplicar o preparo do estado da proposta ou transformar a conversa em edição de transações registradas.

## Critérios de aceite

- Interpretar por IA real alteração de tipo, valor, descrição, categoria ou data com proposta/campo inequívocos; pedir esclarecimento quando o alvo ou a alteração forem ambíguos.
- Dado fornecido diretamente pelo usuário é validado; dado sugerido pela IA continua exigindo aceitação identificável, sem completar silenciosamente data, categoria ou tipo.
- Aplicar cinco campos obrigatórios e F04: BRL positivo até R$ 999.999.999,99 com até duas casas; descrição de 1–120 caracteres após retirar espaços externos; data real de 01/01/1900 até hoje em America/Sao_Paulo; categoria existente compatível. Não arredondar, truncar ou ajustar inválidos para salvá-los.
- Trocar tipo requer classificação compatível e aceitação de qualquer nova sugestão; enquanto incompleta/inválida, a proposta não permite confirmação.
- Persistir a alteração como proposta, apresentar novo resumo e invalidar controles do anterior, inclusive em outra aba. A correção não grava transação e só a confirmação do resumo atual pode fazê-lo.
- Preservar dados e estados efetivamente salvos ao retornar ou usar outro navegador. Falha de interpretação/salvamento não altera alvo errado, anuncia sucesso fictício ou autoriza duplicação.
- Autorizar titular confirmado e estado atual em cada ação; manter consultas e mensagens da mesma conversa sem gravar/cancelar pendências por efeito de uma consulta. Para transação registrada, orientar F04.
- Comparar mensagens corretivas, esclarecimento, nova sugestão e resumo com V01/F01/F06 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px. Manter autoria, dados extensos, foco/teclado e ações legíveis com alvo claro, sem sobreposição, rolagem horizontal ou mecanismos internos.

## Dependências

O início depende de Registro de transações por IA com confirmação - Proposta completa e confirmação individual. Para concluir o tratamento de novas sugestões, integrar Completar dados e aceitar sugestões. O canal por formulário não é bloqueador; ambos preservam as mesmas regras e estado atual.

## Referências

[Pai #1016277](https://redmine.remsoft.com.br/issues/1016277); R2/R3/R5–R7/R9/R10/R12/R13; CA04/CA06/CA07/CA09/CA10/CA12/CA14/CA15; CT-004–CT-008, CT-011/CT-012, CT-020–CT-027.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, regras visuais finais e `DESIGN-HANDOFF.md`. Locadores: #assistant, #messages, #chat-form, showProposal() e .dialog-actions, com adaptação aprovada de alvo e aceitação explícita.

Intenção estável de criação: `docs/harness/features/1016277-registro-de-transacoes-por-ia-com-confirmacao/slices/slices.md#D04-r001`.
