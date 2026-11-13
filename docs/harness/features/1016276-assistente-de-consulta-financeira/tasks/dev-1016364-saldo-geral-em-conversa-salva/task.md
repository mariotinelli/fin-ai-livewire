# [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Saldo geral em conversa salva

## Identidade e fontes

- Filha: [#1016364](https://redmine.remsoft.com.br/issues/1016364); papel: DEV; status remoto conferido: New.
- Pai: [Assistente de consulta financeira — #1016276](https://redmine.remsoft.com.br/issues/1016276); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **17**; pai espelha 17.
- Estimativa: **6h**. Estimativa proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[QA] [WEB] [USUARIO] Gestão de transações — #1016356](https://redmine.remsoft.com.br/issues/1016356).
- Condições da Feature: [CT-001–CT-024, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016276 - Condições de testes.docx>), [anexo #3365 da QA #1016369](https://redmine.remsoft.com.br/attachments/download/3365/1016276%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação, execução de QA e chamada de IA não realizadas neste fluxo.

## Entrega

Permitir que o titular abra Assistente pela navegação própria, pergunte pelo saldo em linguagem natural e receba uma resposta de IA real baseada nas transações atuais da sua conta, em uma conversa contínua salva e retomável.

## Escopo e limites

Navegação, composição, interpretação real, persistência, retomada e estados de falha ficam juntos porque são necessários para concluir e reconhecer essa primeira consulta pelo canal aprovado. A tarefa não entrega apenas uma tela vazia ou uma infraestrutura interna. Usar F01/F02/F04 verificadas e adaptar o armazenamento existente da conversa sem reconstruir essas Features.

Totais por período, recentes e continuidade contextual têm entregas próprias. A orientação inicial deve corresponder às consultas realmente disponíveis; as sugestões aplicáveis dessas entregas são integradas quando funcionais. A sugestão de registrar gasto orienta o cadastro manual de F04, sem antecipar propostas de F07. O produto mantém uma única conversa por titular.

## Critérios de aceite

- A navegação própria abre o chat real do titular autenticado com e-mail confirmado. Visitante e conta pendente não acessam histórico, contexto, consultas ou respostas; referências diretas não ampliam acesso.
- Administração e suporte não recebem acesso a conversas ou dados financeiros de terceiros. Sair e trocar de conta carrega apenas a conversa da segunda, sem contexto ou resultados da anterior.
- Na primeira utilização, apresentar orientação das consultas disponíveis e sugestões aplicáveis do design. Não oferecer criação, seleção, renomeação ou exclusão manual de múltiplas conversas.
- O botão Enviar, Enter e sugestão de saldo permitem enviar uma mensagem válida de até 500 caracteres; Shift+Enter insere quebra de linha. Recusar vazio, apenas espaços e excesso com orientação, sem truncar silenciosamente, inclusive na colagem.
- Ao aceitar o envio, registrar a mensagem e indicar processamento real. Mensagem e resposta exibem autoria, ordem e data/hora reconhecíveis em America/Sao_Paulo.
- Durante o processamento, impedir novo envio pela interface até conclusão ou falha comunicada, mantendo a conversa legível e evitando duplicar mensagem já confirmada.
- Interpretar perguntas compreensíveis de saldo com IA real e responder em pt-BR com valor em BRL e centavos, pela diferença das receitas e despesas próprias atuais de todo o histórico. Identificar o caráter geral/acumulado do saldo, inclusive zero real sem movimentações.
- Números mencionados no chat e respostas antigas não substituem os registros atuais. Nova pergunta após criação, edição ou exclusão manual usa dados atuais; mensagens históricas permanecem como foram dadas, com posição e momento reconhecíveis.
- Mensagem ambígua ou interpretação insegura não gera número por suposição; pedir esclarecimento. A conclusão contextual sem repetir a pergunta inteira é ampliada pela entrega Continuidade e esclarecimento.
- Salvar mensagens não cria, altera ou exclui transações. Pedidos fora das consultas suportadas recebem explicação do limite e opções disponíveis; pedido/sugestão de registro orienta o cadastro manual real de F04, sem proposta ou confirmação simulada.
- Recarregar, sair/entrar e usar a mesma conta em outro navegador retoma a única conversa salva, preservando mensagens do usuário e assistente, autoria, ordem e data/hora, inclusive ao abrir a mesma conta em duas sessões.
- Falha de carregamento informa indisponibilidade e permite tentar novamente, sem apresentar conversa vazia como primeira utilização.
- Falha ao salvar mensagem não a apresenta como persistida; preservar texto ainda não enviado quando aplicável e permitir nova tentativa sem duplicar mensagem já salva.
- Falha de IA ou consulta financeira informa o problema e permite retomada, sem zero de conveniência, valor inventado, resposta simulada ou gravação financeira.
- Falha ao salvar resposta distingue processamento de preservação efetiva. Retomar ou tentar novamente mantém coerência com as mensagens já confirmadas, sem anunciar histórico salvo ou duplicar conteúdo indevidamente.
- Instruções para ignorar limites, consultar outra pessoa ou usar valores do chat não mudam titularidade nem fonte financeira.
- Comparar cabeçalho, mensagens, composição, orientação, sugestões e estados de carregamento, foco, envio, processamento, vazio inicial, ausência real, erro e recuperação com V01 sobre F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, com transições 767/768px e 1024/1025px. Manter hierarquia, autoria distinguível, datas/horas legíveis, teclado e foco, textos longos e histórico extenso utilizáveis, sem controles cobertos ou rolagem horizontal da página.
- Retirar rótulos de assistente simulado/armazenamento local e não expor depuração, nomes de ferramentas internas ou configuração do provedor na conversa.

## Dependências

O início depende de [[QA] [WEB] [USUARIO] Gestão de transações](https://redmine.remsoft.com.br/issues/1016356), que verifica os registros, as categorias e a gestão manual reais de F04. Essa entrega consome a identidade/confirmação de F02 e a base visual F01 já verificadas. A publicação das tarefas em New não libera esses fornecedores.

Serviço de IA real configurado e acessível é necessário para concluir a integração e verificá-la; a escolha interna de provedor/modelo não altera os requisitos funcionais. Dashboard F05 e registro por IA F07 não bloqueiam esta consulta.

## Referências

[Pai #1016276](https://redmine.remsoft.com.br/issues/1016276); R1/R2 e R3–R12 nas parcelas de saldo, canal, persistência, acesso e limites; CA01–CA04/CA06/CA09–CA14 nas respectivas parcelas; CT-001–CT-010, CT-015, CT-017, CT-020–CT-024.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #assistant, .chat-top, #messages, .message, #chat-form, #chat-input, #send-message, .suggestions e .chat-guide. A persistência, IA real e data/hora aprovadas substituem o comportamento demonstrativo/local do design.

Intenção estável de criação: `docs/harness/features/1016276-assistente-de-consulta-financeira/slices/slices.md#D01-r001`.
