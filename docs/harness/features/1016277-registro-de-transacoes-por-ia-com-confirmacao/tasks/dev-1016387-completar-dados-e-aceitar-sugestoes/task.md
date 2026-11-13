# [DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Completar dados e aceitar sugestões

## Identidade e fontes

- Filha: [#1016387](https://redmine.remsoft.com.br/issues/1016387); papel: DEV; status remoto conferido: New.
- Pai: [#1016277](https://redmine.remsoft.com.br/issues/1016277); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **32**; pai espelha 31.
- Estimativa: **3,5h**, proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Proposta completa e confirmação individual — #1016386](https://redmine.remsoft.com.br/issues/1016386).
- Fornecedor do aceite financeiro integrado: [[QA] [WEB] [USUARIO] Dashboard financeiro — #1016385](https://redmine.remsoft.com.br/issues/1016385), preservando CA13 e a dependência original F05→F07.
- Condições: [CT-001–CT-027, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016277 - Condições de testes.docx>), [anexo #3367 da QA #1016392](https://redmine.remsoft.com.br/attachments/download/3367/1016277%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Permitir completar uma proposta com dados faltantes por perguntas e sugestões fundamentadas, adotando apenas informações expressas ou expressamente aceitas, até obter um resumo válido que ainda exige confirmação individual.

## Escopo e limites

Perguntar e sugerir são alternativas da mesma interação de completar campos sem suposição silenciosa. Esta entrega forma o primeiro resumo completo a partir dos dados pendentes; alterar campos já definidos de uma proposta é tratado pelas entregas de correção. A aceitação não é uma autorização financeira.

## Critérios de aceite

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

## Dependências

O início depende de Registro de transações por IA com confirmação - Proposta completa e confirmação individual, que fornece o estado persistido, o chat e a confirmação final. Dashboard F05 continua necessário ao aceite integrado da Feature; não reconstruir esse fornecedor.

## Referências

[Pai #1016277](https://redmine.remsoft.com.br/issues/1016277); R1–R3/R5/R6/R10–R13; CA03–CA06/CA10–CA15 nas parcelas de complementação; CT-002–CT-009, CT-020–CT-024, CT-026/CT-027.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, regras visuais finais e `DESIGN-HANDOFF.md`. Locadores: #assistant, #messages, showProposal() e .dialog-actions. Q11/CA03–CA05 aprovam a aceitação explícita em lugar de preenchimento automático.

Intenção estável de criação: `docs/harness/features/1016277-registro-de-transacoes-por-ia-com-confirmacao/slices/slices.md#D02-r001`.
