# [DEV] [WEB] [USUARIO] Registro de transações por IA com confirmação - Proposta completa e confirmação individual

## Identidade e fontes

- Filha: [#1016386](https://redmine.remsoft.com.br/issues/1016386); papel: DEV; status remoto conferido: New.
- Pai: [#1016277](https://redmine.remsoft.com.br/issues/1016277); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **31**; pai espelha 31.
- Estimativa: **5,5h**, proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[QA] [WEB] [USUARIO] Assistente de consulta financeira — #1016369](https://redmine.remsoft.com.br/issues/1016369).
- Fornecedor do aceite financeiro integrado: [[QA] [WEB] [USUARIO] Dashboard financeiro — #1016385](https://redmine.remsoft.com.br/issues/1016385), preservando CA13 e a dependência original F05→F07.
- Condições: [CT-001–CT-027, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016277 - Condições de testes.docx>), [anexo #3367 da QA #1016392](https://redmine.remsoft.com.br/attachments/download/3367/1016277%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Permitir que uma mensagem com os cinco campos explícitos gere uma proposta revisável no mesmo chat de F06 e que o titular registre uma única transação ao usar Confirmar no resumo completo atual, conferindo os dados nos canais reais.

## Escopo e limites

Reconhecimento por IA, proposta persistida, resumo e confirmação ficam juntos porque somente o resultado completo permite ao usuário revisar e registrar sua intenção pelo canal aprovado. O preparo comum do estado das propostas pertence a esta primeira interação, consumindo chat F06 e cadastro/regras F04 já entregues. Não criar uma tarefa técnica isolada de armazenamento.

Completar dados omitidos, revisar campos já definidos por formulário ou mensagem, cancelar e extrair várias movimentações da mesma mensagem têm entregas próprias. Não oferecer controles dessas operações como se já funcionassem. Uma nova mensagem/intenção não deve sobrescrever outra proposta pendente; a multiplicidade em uma única mensagem é ampliada em Várias propostas independentes.

## Critérios de aceite

- Interpretar por IA real mensagens completas de receita/despesa e apresentar tipo, valor, descrição, categoria e data exatamente informados. Datas relativas expressas são convertidas em America/Sao_Paulo e exibidas como data revisável; nenhum campo omitido é preenchido silenciosamente.
- Mensagem, interpretação e resumo não criam transação. Dados ausentes, ambíguos ou inválidos impedem confirmar e recebem orientação; o diálogo de complementação é entregue em Completar dados e aceitar sugestões.
- Aplicar F04: cinco campos obrigatórios; BRL maior que zero até R$ 999.999.999,99, até duas casas sem arredondar ou transformar entrada inválida; descrição de 1–120 caracteres após retirar espaços nas extremidades; data real de 01/01/1900 até hoje em America/Sao_Paulo.
- Exigir categoria existente e compatível com receita/despesa no catálogo F04, incluindo Outras receitas/Outras despesas. Não criar categoria, usar negativo para despesa, truncar texto ou ajustar data/valor silenciosamente.
- Somente Confirmar da proposta completa, válida e atual grava; “sim”, aceitação de campos ou pedido de confirmação por texto orientam o botão, sem gravar.
- Cada confirmação verifica titular e estado atual, salva os cinco campos revisados, marca a proposta registrada e informa sucesso somente após persistir. Cliques repetidos, outra aba/navegador e controles antigos não geram outra transação.
- Duas propostas intencionais de dados iguais são permitidas, cada uma registrada no máximo uma vez por confirmação própria.
- Persistir estado e vínculo do resultado no mesmo chat, preservando mensagens e autoria. Retornar, trocar de navegador ou recarregar não reativa proposta registrada nem transforma estado não salvo em preservado.
- Falha de IA/proposta/gravação informa o problema e permite retomada coerente, sem sucesso ou alteração parcial. Resultado incerto exige consultar o registro real antes de induzir repetição e reconhecer a transação existente se a gravação ocorreu.
- Consultas de F06 continuam disponíveis com uma proposta pendente e após novas mensagens; não confirmam, cancelam ou perdem pendências. Só registros confirmados entram no saldo/totais, e respostas históricas continuam preservadas.
- Após confirmar, encontrar a mesma transação no histórico/detalhes F04, nas novas consultas F06 e nos indicadores F05, sem novo login, respeitando tipo, valor, categoria e data/mês. Proposta apenas preparada não altera esses canais.
- Restringir proposta, resumo, estado e confirmação ao titular autenticado e confirmado, inclusive por referência direta ou instrução no chat. Visitante/conta pendente e administração/suporte não recebem acesso financeiro de terceiros.
- Pedidos de editar/excluir transação já registrada orientam F04; correção da proposta não altera registro financeiro existente.
- Comparar proposta, resumo e estados de processamento, erro, retomada e registro com V01/F01/F06 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px. Os cinco campos são legíveis, o alvo de Confirmar é claro e foco/teclado/ações ficam alcançáveis, sem sobreposição, rolagem horizontal da página, simulação ou mecanismos internos.

## Dependências

O início depende de [[QA] [WEB] [USUARIO] Assistente de consulta financeira](https://redmine.remsoft.com.br/issues/1016369), que já consome F04 verificada por [QA #1016356](https://redmine.remsoft.com.br/issues/1016356), identidade e base visual. As tarefas publicadas estão New e não comprovam implementação.

Para concluir o efeito integrado, é necessário [Dashboard financeiro #1016275](https://redmine.remsoft.com.br/issues/1016275) entregue e verificado por [QA] [WEB] [USUARIO] Dashboard financeiro, proposta com Sequencing 30 na decomposição F05, conforme CA13. Essa identificação específica substitui o fornecedor provisório da prévia, sem alterar capacidade ou aceite. Sua ausência não impede preparar o slicing ou iniciar desenvolvimento com F06 pronta, mas impede concluir esse aceite e a QA integral. Preservar a relação original F05→F07.

## Referências

[Pai #1016277](https://redmine.remsoft.com.br/issues/1016277); R1/R5/R6/R9–R13; CA01/CA05/CA06/CA09–CA15 nas parcelas de confirmação/canal; CT-001/CT-002, CT-005–CT-009, CT-017–CT-025, CT-026/CT-027.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, regras visuais finais e `DESIGN-HANDOFF.md`. Locadores: #assistant, #messages, showProposal() e .dialog-actions. Persistência, IA real e confirmação pelo estado atual substituem o armazenamento local e o comportamento simplificado do protótipo.

Intenção estável de criação: `docs/harness/features/1016277-registro-de-transacoes-por-ia-com-confirmacao/slices/slices.md#D01-r001`.
