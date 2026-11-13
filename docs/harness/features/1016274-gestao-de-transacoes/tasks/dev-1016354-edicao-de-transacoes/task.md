# [DEV] [WEB] [USUARIO] Gestão de transações - Edição de transações

## Identidade e fontes

- Filha: [#1016354](https://redmine.remsoft.com.br/issues/1016354); papel: DEV; status remoto conferido: New.
- Pai: [Gestão de transações — #1016274](https://redmine.remsoft.com.br/issues/1016274); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **14**; pai espelha 11.
- Estimativa: **2h**, corrigida pelo responsável e publicada. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Gestão de transações - Histórico por mês e detalhes — #1016351](https://redmine.remsoft.com.br/issues/1016351).
- Condições da Feature: [CT-001–CT-025, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016274 - Condições de testes.docx>), [anexo #3363 da QA #1016356](https://redmine.remsoft.com.br/attachments/download/3363/1016274%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Permitir corrigir tipo, valor, descrição, categoria e data de uma transação própria pelos detalhes, atualizando o mesmo registro e refletindo os dados atuais na consulta sem novo login.

## Escopo e limites

Usar os detalhes e o catálogo comuns e manter as mesmas regras funcionais da criação. A edição tem aceite próprio; o compartilhamento do formulário ou das validações não obriga esperar o cadastro para iniciar. Dados próprios preparados em homologação permitem demonstrar a atualização.

## Critérios de aceite

- Abrir edição pelos detalhes carrega integralmente os cinco campos atuais. O titular não pode ser escolhido nem alterado, e salvar atualiza o mesmo registro sem criar cópia.
- Exigir tipo receita/despesa, valor, descrição, categoria e data. Recusar omissões e tipo inválido com erros associados ao campo e preenchimento corrigível.
- Aceitar BRL positivo até R$ 999.999.999,99, com até duas casas, incluindo 35,90 e 1.234,56 digitados/colados com centavos exatos. Recusar zero, negativo, excesso e mais de duas casas, sem arredondamento ou transformação silenciosa.
- Aceitar descrição de 1 a 120 caracteres após retirar espaços nas extremidades, preservando o texto. Recusar apenas espaços e excesso sem truncar.
- Aceitar somente data real entre 01/01/1900 e hoje em America/Sao_Paulo, inclusive; recusar datas anteriores, inexistentes ou futuras, sem exigir horário ou deslocar a data financeira.
- Oferecer exatamente Salário, Freelance, Rendimentos e Outras receitas para receita; Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras e Outras despesas para despesa. Não disponibilizar manutenção de categorias.
- Trocar tipo reapresenta categorias compatíveis e torna clara a seleção que será salva; recusar categoria inexistente ou incompatível, inclusive referência oculta do tipo anterior.
- Falha real ao obter categorias é comunicada e permite retomada, sem catálogo vazio enganoso ou categoria improvisada.
- Validar e autorizar a atualização de registro próprio antes de gravar, inclusive por referência direta. Visitante, conta pendente e outra conta não alteram ou leem os dados; privilégios administrativos/de suporte não concedem acesso adicional.
- Cancelar ou fechar mantém os dados anteriores. Falha de gravação não anuncia sucesso nem aplica alteração parcial e mantém os dados corrigíveis enquanto a tela estiver aberta.
- Mostrar processamento e impedir repetição do mesmo envio pela interface; resultado incerto exige conferir estado atual antes de induzir nova tentativa.
- Registro removido ou indisponível antes de concluir edição não é recriado; informar indisponibilidade e atualizar a consulta sem revelar dados alheios.
- Após salvar, atualizar histórico e detalhes sem novo login, manter uma página válida e respeitar o recorte. Se a alteração retirar o registro dos filtros atuais, o sucesso permanece claro e o registro atualizado é encontrado no recorte adequado.
- Comparar edição em #transaction-dialog e detalhes em #detail-dialog com V01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, incluindo dados preenchidos, validação, processamento, falha, indisponibilidade, sucesso e cancelamento. Preservar hierarquia visual F01 e controles legíveis e alcançáveis por teclado, sem sobreposições ou rolagem horizontal da página.

## Dependências

O início depende de Gestão de transações - Histórico por mês e detalhes. Para concluir, manter coerência de campos e validações com Gestão de transações - Cadastro classificado e integrar o resultado aos recortes de Gestão de transações - Pesquisa e filtros. Essas integrações não impõem bloqueio de início; o preparo comum das regras do formulário é contabilizado uma vez no cadastro.

## Referências

[Pai #1016274](https://redmine.remsoft.com.br/issues/1016274); R1–R6/R8/R9/R11/R12 na atualização; CA02/CA03/CA05–CA07/CA09/CA10/CA12–CA15 nas parcelas de edição; CT-001, CT-007–CT-011, CT-015/CT-016, CT-019–CT-025.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final de suas regras e `DESIGN-HANDOFF.md`. Locadores: #detail-dialog, #edit-transaction e #transaction-dialog preenchido. Aplicar as validações e a titularidade aprovadas; não herdar arredondamento ou disponibilidade silenciosa do protótipo.

Intenção estável de criação: `docs/harness/features/1016274-gestao-de-transacoes/slices/slices.md#D04-r001`.
