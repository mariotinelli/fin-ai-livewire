# [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Cinco últimas movimentações

## Identidade e fontes

- Filha: [#1016367](https://redmine.remsoft.com.br/issues/1016367); papel: DEV; status remoto conferido: New.
- Pai: [Assistente de consulta financeira — #1016276](https://redmine.remsoft.com.br/issues/1016276); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **20**; pai espelha 17.
- Estimativa: **1,5h**. Estimativa proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Assistente de consulta financeira - Saldo geral em conversa salva — #1016364](https://redmine.remsoft.com.br/issues/1016364).
- Condições da Feature: [CT-001–CT-024, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016276 - Condições de testes.docx>), [anexo #3365 da QA #1016369](https://redmine.remsoft.com.br/attachments/download/3365/1016276%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação, execução de QA e chamada de IA não realizadas neste fluxo.

## Entrega

Permitir perguntar pelas últimas movimentações e receber até cinco transações próprias atuais de todo o histórico, com dados suficientes para reconhecê-las e orientação para o histórico manual quando houver mais resultados.

## Escopo e limites

A resposta recente tem resultado próprio, independente das somas mensais ou por intervalo. Usar a ordenação e o histórico reais de F04, sem criar outra tela de transações ou um relatório novo.

## Critérios de aceite

- Interpretar perguntas compreensíveis de últimas movimentações por IA real e consultar registros atuais de todo o histórico próprio, sem restringir silenciosamente ao mês corrente.
- Apresentar até cinco registros reais com data, descrição, tipo e valor em BRL com centavos.
- Preservar a ordem de F04: data financeira decrescente, criação mais recente primeiro na mesma data e desempate estável.
- Quando houver mais resultados, indicar que o restante está no histórico manual real de F04; com menos de cinco, não completar a resposta com exemplos fictícios.
- Sem movimentações, informar ausência real após consulta bem-sucedida. Falha de IA ou consulta informa problema e permite retomada, sem apresentar ausência falsa.
- Cada nova pergunta reflete criação, edição e exclusão manuais atuais; não usar apenas uma resposta antiga nem reescrever mensagens históricas.
- A sugestão “Últimas movimentações” executa a consulta real no mesmo chat, com persistência, autoria, momento e processamento verdadeiros, sem duplicar mensagens já salvas.
- Manter histórico, contexto, registros e respostas limitados ao titular confirmado, inclusive contra referências diretas e instruções para consultar terceiros; mensagens não criam, editam ou excluem finanças.
- Comparar sugestão e resposta de recentes nos estados de resultado, ausência e falha com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, com transições 767/768px e 1024/1025px, com descrições extensas, datas e valores legíveis, autoria distinguível, foco e acesso às ações, sem rolagem horizontal da página ou controles encobertos.

## Dependências

O início depende de Assistente de consulta financeira - Saldo geral em conversa salva. O histórico de F04 já é fornecedor dessa entrega; totais mensais e intervalos não bloqueiam a consulta de recentes.

## Referências

[Pai #1016276](https://redmine.remsoft.com.br/issues/1016276); R2–R5/R7–R12 nas parcelas de recentes; CA02/CA03/CA06/CA07/CA09–CA12/CA14; CT-002, CT-008, CT-015–CT-017, CT-020/CT-021, CT-023/CT-024.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #assistant, #messages, .suggestions e sugestão de últimas movimentações. O resultado usa F04 atual, sem exemplos locais de demonstração.

Intenção estável de criação: `docs/harness/features/1016276-assistente-de-consulta-financeira/slices/slices.md#D04-r001`.
