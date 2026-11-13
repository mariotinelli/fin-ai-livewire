# [DEV] [WEB] [USUARIO] Gestão de transações - Histórico por mês e detalhes

## Identidade e fontes

- Filha: [#1016351](https://redmine.remsoft.com.br/issues/1016351); papel: DEV; status remoto conferido: New.
- Pai: [Gestão de transações — #1016274](https://redmine.remsoft.com.br/issues/1016274); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **11**; pai espelha 11.
- Estimativa: **3h**, corrigida pelo responsável e publicada. Não é medição de execução.
- Bloqueios de início confirmados: [[QA] [WEB] [USUARIO] Acesso autenticado e espaço financeiro pessoal — #1016293](https://redmine.remsoft.com.br/issues/1016293).
- Condições da Feature: [CT-001–CT-025, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016274 - Condições de testes.docx>), [anexo #3363 da QA #1016356](https://redmine.remsoft.com.br/attachments/download/3363/1016274%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Disponibilizar Transações na navegação real para o titular consultar suas receitas e despesas por mês ou em todo o histórico, navegar páginas e abrir os cinco campos integrais de cada registro. Usar a base visual FinAI já verificada.

## Escopo e limites

Histórico e detalhes permanecem juntos porque a linha móvel resume ou oculta campos que precisam estar integralmente acessíveis no mesmo fluxo de consulta, conforme R12/CA13. O catálogo comum necessário à classificação apresentada começa nesta entrega. Pesquisa por descrição, filtros de tipo/categoria, cadastro, edição e exclusão têm entregas próprias; seus controles só devem oferecer operações reais quando disponíveis. A conferência inicial pode usar dados próprios preparados em homologação.

## Critérios de aceite

- O titular autenticado com e-mail confirmado encontra Transações na navegação e consulta somente registros próprios, inclusive por acesso direto. Visitante e conta pendente não acessam dados financeiros; administração e suporte não recebem acesso a finanças de terceiros.
- A abertura usa o mês corrente em America/Sao_Paulo. Selecionar outro mês consulta esse período; remover o mês consulta todo o histórico, inclusive datas antigas.
- A listagem apresenta dados reais, com descrição, data, categoria e valor compreensíveis, distinguindo receita/despesa por sinal e identificação do tipo além da cor.
- O catálogo comum preserva os nomes Salário, Freelance, Rendimentos e Outras receitas para receitas; Alimentação, Moradia, Transporte, Saúde, Educação, Lazer, Compras e Outras despesas para despesas. Não criar manutenção ou tela de categorias.
- Ordenar por data financeira decrescente, criação mais recente primeiro na mesma data e desempate estável. Com dados estáveis, anterior/próxima não omitem nem repetem registros entre páginas.
- Exibir até 50 registros por página, contagem, página atual e controles quando necessários. Mudar o mês retorna à primeira página.
- Os detalhes mostram tipo, valor em BRL com centavos exatos, descrição integral, categoria e data, inclusive quando a linha móvel resume campos.
- Sem registros, apresentar orientação de primeiro cadastro; com registros fora do mês, informar ausência no recorte e permitir ajustar/remover o mês. A ação de cadastro é integrada pela entrega Cadastro classificado.
- Falha de leitura não se apresenta como histórico vazio; informar erro e permitir nova tentativa. Registro indisponível ao abrir detalhes gera orientação e atualização da consulta, sem dados alheios.
- Sair, trocar de conta ou retornar em outro navegador mantém o isolamento. A titularidade dos registros não é alterada por sua consulta.
- Comparar listagem, mês, paginação, detalhes e estados aplicáveis com #transactions, #month-wrap e #detail-dialog de V01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px. Preservar hierarquia, proporções, tipografia, cores e controles da F01; textos/valores extensos e foco não ficam encobertos nem causam rolagem horizontal da página.

## Dependências

O início depende da identidade e confirmação de e-mail implementadas e verificadas por [[QA] [WEB] [USUARIO] Acesso autenticado e espaço financeiro pessoal](https://redmine.remsoft.com.br/issues/1016293), fornecidas pela [DEV #1016292](https://redmine.remsoft.com.br/issues/1016292). Essa jornada já depende da base visual implementada e verificada por [[QA] [WEB] [USUARIO] Adequação visual completa do FinAI](https://redmine.remsoft.com.br/issues/1016288). As publicações atuais não liberam esses pré-requisitos.

## Referências

[Pai #1016274](https://redmine.remsoft.com.br/issues/1016274); R2/R4–R9/R12 na leitura; CA03–CA06/CA09–CA15 nas parcelas de consulta; CT-001–CT-004, CT-014, CT-019, CT-022–CT-025.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final de suas regras e `DESIGN-HANDOFF.md`. Locadores: #transactions, #history, #month-wrap, #pagination e #detail-dialog. As restrições e a persistência aprovadas substituem o comportamento local do protótipo.

Intenção estável de criação: `docs/harness/features/1016274-gestao-de-transacoes/slices/slices.md#D01-r001`.
