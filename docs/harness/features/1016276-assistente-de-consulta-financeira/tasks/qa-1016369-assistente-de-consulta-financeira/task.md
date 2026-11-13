# [QA] [WEB] [USUARIO] Assistente de consulta financeira

## Identidade e fontes

- Filha: [#1016369](https://redmine.remsoft.com.br/issues/1016369); papel: QA; status remoto conferido: New.
- Pai: [Assistente de consulta financeira — #1016276](https://redmine.remsoft.com.br/issues/1016276); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **22**; pai espelha 17.
- Estimativa: **4h**. Correção explícita do responsável de 6h para 4h; cobertura integral preservada. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Assistente de consulta financeira - Saldo geral em conversa salva — #1016364](https://redmine.remsoft.com.br/issues/1016364); [[DEV] [WEB] [USUARIO] Assistente de consulta financeira - Totais mensais por tipo e categoria — #1016365](https://redmine.remsoft.com.br/issues/1016365); [[DEV] [WEB] [USUARIO] Assistente de consulta financeira - Totais por dia e intervalo — #1016366](https://redmine.remsoft.com.br/issues/1016366); [[DEV] [WEB] [USUARIO] Assistente de consulta financeira - Cinco últimas movimentações — #1016367](https://redmine.remsoft.com.br/issues/1016367); [[DEV] [WEB] [USUARIO] Assistente de consulta financeira - Continuidade e esclarecimento — #1016368](https://redmine.remsoft.com.br/issues/1016368).
- Condições da Feature: [CT-001–CT-024, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016276 - Condições de testes.docx>), [anexo #3365 da QA #1016369](https://redmine.remsoft.com.br/attachments/download/3365/1016276%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação, execução de QA e chamada de IA não realizadas neste fluxo.

## Entrega

Verificar o Assistente de consulta financeira completo pelas telas reais, com interpretação por IA real, consultas aos dados atuais próprios e conversa contínua persistida, cobrindo CT-001–CT-024 da revisão r001.

## Escopo e limites

Executar uma única QA para toda a Feature, incluindo preparação de contas/dados, relógio, falhas reversíveis, acesso ao serviço de IA real, registro de resultados e reteste focalizado. Testes automatizados com fakes apoiam integridade e falhas, sem substituir a integração real ou comparação visual.

F05 verifica seu convite ao chat e F07 seu registro confirmado no mesmo chat. Esta QA conclui pela navegação própria sem esperar essas Features nem simular suas operações.

## Critérios de aceite

- Executar CT-001–CT-024 com resultado e evidência por condição, cobrindo R1–R12 e CA01–CA14; condições não executadas e defeitos ficam explicitamente pendentes.
- Demonstrar envio pelo botão, Enter e sugestões, Shift+Enter, limite de 500 caracteres, recusa de vazio/excesso sem truncamento e bloqueio de novo envio enquanto processa.
- Retomar uma única conversa da mesma conta após recarregar, sair/entrar e usar outro navegador, preservando autoria, ordem e data/hora em America/Sao_Paulo.
- Confirmar por perguntas variadas que interpretação e resposta usam IA real e registros atuais, sem atividade ou valores fictícios.
- Conferir saldo acumulado de todo o histórico, totais mensais e por dia/intervalo inclusivo com tipo/categoria, somas e contagens, mês corrente padrão declarado e referências relativas no fuso aprovado.
- Conferir até cinco recentes de todo o histórico com data, descrição, tipo, valor, ordem de F04 e orientação ao histórico manual.
- Completar continuações claras e perguntas pendentes por esclarecimento sem repetir tudo; referência antiga/ambígua, categoria incerta e intervalo inválido não recebem número por suposição.
- Criar, editar e excluir manualmente em F04 e fazer nova consulta: usar dados atuais e preservar as respostas históricas reconhecíveis, sem transformar números do chat em transações.
- Diferenciar ausência real de falhas de carregamento, gravação de mensagem, IA, dados e salvamento de resposta, com recuperação coerente e sem duplicar mensagens já salvas.
- Conferir isolamento de mensagens/contexto/dados entre A/B, referências diretas, instruções para ignorar acesso e recusa de visitante/conta pendente e de acesso financeiro alheio por administração/suporte.
- Conferir orientação a pedidos fora do escopo e cadastro manual de F04 pela sugestão de registro, sem propostas simuladas, gravação financeira ou segunda conversa.
- Comparar chat, sugestões, mensagens longas, histórico extenso e estados aplicáveis com V01 sobre F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, com transições 767/768px e 1024/1025px. Manter hierarquia, autoria, data/hora, foco, teclado, leitura e ações alcançáveis, sem sobreposição, rolagem horizontal ou rótulos de simulação.

## Dependências

Executar após Assistente de consulta financeira - Saldo geral em conversa salva; Assistente de consulta financeira - Totais mensais por tipo e categoria; Assistente de consulta financeira - Totais por dia e intervalo; Assistente de consulta financeira - Cinco últimas movimentações; e Assistente de consulta financeira - Continuidade e esclarecimento.

F04 e seus fornecedores F01/F02 precisam estar implementados/verificados, e o serviço de IA real precisa estar disponível. Espera por acesso/fornecedores não é esforço ativo de teste.

## Referências

[Pai #1016276](https://redmine.remsoft.com.br/issues/1016276); R1–R12, CA01–CA14; CT-001–CT-024, r001; anexo previsto `1016276 - Condições de testes.docx`.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #assistant, .chat-top, #messages, .message, #chat-form, #chat-input, #send-message, .suggestions e .chat-guide. IA real, persistência e estados aprovados prevalecem sobre o protótipo.

Intenção estável de criação: `docs/harness/features/1016276-assistente-de-consulta-financeira/slices/slices.md#QA-r001`.
