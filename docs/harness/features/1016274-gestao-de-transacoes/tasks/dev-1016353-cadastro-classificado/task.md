# [DEV] [WEB] [USUARIO] Gestão de transações - Cadastro classificado

## Identidade e fontes

- Filha: [#1016353](https://redmine.remsoft.com.br/issues/1016353); papel: DEV; status remoto conferido: New.
- Pai: [Gestão de transações — #1016274](https://redmine.remsoft.com.br/issues/1016274); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **13**; pai espelha 11.
- Estimativa: **2h**, corrigida pelo responsável e publicada. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Gestão de transações - Histórico por mês e detalhes — #1016351](https://redmine.remsoft.com.br/issues/1016351).
- Condições da Feature: [CT-001–CT-025, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016274 - Condições de testes.docx>), [anexo #3363 da QA #1016356](https://redmine.remsoft.com.br/attachments/download/3363/1016274%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Permitir cadastrar uma receita ou despesa realizada com tipo, valor, descrição, categoria e data, confirmar o salvamento real e reencontrar os dados no histórico e nos detalhes da própria conta.

## Escopo e limites

Receita e despesa são variantes da mesma interação: o tipo determina entrada/saída e as opções de classificação do formulário. Consumir o catálogo comum introduzido no histórico e disponibilizar suas opções mesmo sem movimentações. A ação Nova transação e sua orientação no vazio inicial pertencem a esta entrega. Não incluir edição, manutenção de categorias ou registro por IA.

## Critérios de aceite

- Nova transação abre formulário com cinco campos obrigatórios e data inicial de hoje em America/Sao_Paulo. Tipo aceita somente receita ou despesa.
- Aceitar valor em BRL maior que zero, até R$ 999.999.999,99 e com até duas casas decimais; reconhecer 35,90 e 1.234,56 preservando exatamente os centavos, inclusive ao colar.
- Recusar zero, negativo, excesso de limite ou mais de duas casas, sem arredondar ou transformar silenciosamente a entrada em outro valor. Despesa usa tipo, sem valor negativo.
- A descrição aceita de 1 a 120 caracteres após retirar espaços nas extremidades, mantendo o texto; omissão, apenas espaços e excesso são recusados sem truncar.
- Aceitar somente datas reais entre 01/01/1900 e hoje em America/Sao_Paulo, inclusive, sem horário obrigatório ou deslocamento da data financeira; recusar data anterior, inexistente e futura.
- Para receita oferecer exatamente Salário, Freelance, Rendimentos e Outras receitas; para despesa, Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras e Outras despesas. Preservar acentos e nomes.
- Trocar tipo reapresenta opções compatíveis e a categoria que será salva; categoria inexistente, oculta ou do tipo anterior incompatível é recusada.
- O mesmo catálogo permanece disponível sem transações e entre contas, sem ações de criar, editar, excluir, personalizar, importar ou organizar subcategorias.
- Quando houver falha real de obtenção das opções, comunicar o erro e permitir nova tentativa, sem catálogo vazio enganoso ou categoria improvisada.
- Validar dados e autorização antes de persistir. Cada envio concluído cria uma única transação do usuário autenticado, sem escolha de titular, gravação parcial ou acesso financeiro de visitante/conta pendente.
- Erros de campo mantêm o formulário corrigível. Cancelar ou fechar não grava; falha de salvamento não apresenta sucesso e preserva o preenchimento necessário enquanto o formulário estiver aberto.
- Mostrar processamento e impedir repetição do mesmo envio pela interface. Em resultado incerto, consultar o estado real antes de induzir repetição. Duas transações intencionais com dados iguais continuam permitidas.
- Após sucesso, atualizar o histórico sem novo login respeitando filtros ativos. Se a data ou outros dados ficarem fora do recorte, informar sucesso sem inserir resultado incompatível; permitir conferir o registro pelo mês adequado ou em todo o histórico e pelos detalhes já disponíveis.
- Retornar à tela ou usar a mesma conta em outro navegador preserva os cinco campos; trocar de conta não mistura registros.
- Comparar formulário #transaction-dialog, mensagens, seleção de categorias e estados de validação/processamento/falha/sucesso/cancelamento com V01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px. Preservar hierarquia, espaços, cores e tipografia da base F01, rótulos, foco e teclado; nomes/valores extensos não encobrem ações e a navegação não encobre o diálogo.

## Dependências

O início depende de Gestão de transações - Histórico por mês e detalhes, necessário para conferir integralmente registros atuais ou antigos, inclusive no celular. Pesquisa e filtros não bloqueia o início; ao estar disponível, sua consulta deve continuar fiel após o cadastro. Usar F01/F02 já verificadas, sem reconstruí-las.

## Referências

[Pai #1016274](https://redmine.remsoft.com.br/issues/1016274); R1–R6/R9/R11/R12 na criação; CA01–CA03/CA07/CA09–CA15 nas parcelas de cadastro; CT-001, CT-005–CT-011, CT-014, CT-016, CT-019–CT-021, CT-023–CT-025.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final de suas regras e `DESIGN-HANDOFF.md`. Locadores: #new-transaction, #transaction-dialog, #transaction-form, #form-summary, #tx-type, #tx-value, #tx-description, #tx-category e #tx-date. Datas, limites, falhas e persistência seguem o requisito aprovado; não herdar validações locais do protótipo.

Intenção estável de criação: `docs/harness/features/1016274-gestao-de-transacoes/slices/slices.md#D03-r001`.
