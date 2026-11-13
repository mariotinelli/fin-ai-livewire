# [DEV] [WEB] [USUARIO] Gestão de transações - Exclusão confirmada

## Identidade e fontes

- Filha: [#1016355](https://redmine.remsoft.com.br/issues/1016355); papel: DEV; status remoto conferido: New.
- Pai: [Gestão de transações — #1016274](https://redmine.remsoft.com.br/issues/1016274); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **15**; pai espelha 11.
- Estimativa: **1h**, corrigida pelo responsável e publicada. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Gestão de transações - Histórico por mês e detalhes — #1016351](https://redmine.remsoft.com.br/issues/1016351).
- Condições da Feature: [CT-001–CT-025, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016274 - Condições de testes.docx>), [anexo #3363 da QA #1016356](https://redmine.remsoft.com.br/attachments/download/3363/1016274%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Permitir excluir uma transação própria após confirmação explícita, retirando-a do histórico e dos detalhes ativos de forma persistente e mantendo a consulta em uma página válida.

## Escopo e limites

A confirmação informa a saída do histórico e dos totais e a ausência de desfazer. A exclusão deixa o registro fora dos dados financeiros ativos; F05/F06 verificam seus indicadores e novas consultas ao entregar esses canais. O aceite desta tarefa usa o histórico e os detalhes reais de F04.

## Critérios de aceite

- Solicitar exclusão pelos detalhes apresenta a confirmação de que o registro sairá do histórico e dos totais e não pode ser desfeito.
- Cancelar ou fechar a confirmação mantém o registro e seus efeitos financeiros. Somente a confirmação explícita aplica a exclusão.
- Autorizar a exclusão de registro próprio antes de gravar, inclusive em referência direta. Visitante, conta pendente e outra conta não consultam ou removem o registro; administração e suporte não ganham acesso financeiro de terceiro.
- Mostrar processamento e impedir repetição do mesmo envio pela interface. Falha não anuncia sucesso nem remoção parcial; resultado incerto exige consultar o estado atual antes de induzir repetição.
- Registro já removido ou indisponível gera orientação e atualização da consulta, sem revelar dados alheios ou anunciar nova exclusão inexistente.
- Após sucesso, atualizar histórico e detalhes sem novo login; o registro deixa consultas financeiras ativas e não compõe seu conjunto de saldo, totais ou balanços.
- Preservar a exclusão ao retornar ou usar outro navegador, sem opção de desfazer no produto.
- Manter os filtros e uma página válida, inclusive ao excluir o último registro da última página; ausência no recorte não é falha de leitura.
- Comparar #delete-dialog, #detail-dialog e retorno à listagem com V01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, incluindo confirmação, cancelamento, processamento, erro, indisponibilidade e sucesso. Preservar texto legível, foco e teclado, ações alcançáveis e composição F01, sem controles encobertos ou rolagem horizontal da página.

## Dependências

O início depende de Gestão de transações - Histórico por mês e detalhes. Cadastro e edição não são bloqueadores: registros próprios preparados permitem demonstrar a exclusão. Para concluir, preservar os recortes de Gestão de transações - Pesquisa e filtros quando disponíveis. Dashboard e IA não bloqueiam esta entrega.

## Referências

[Pai #1016274](https://redmine.remsoft.com.br/issues/1016274); R6/R8/R10–R12; CA05/CA07–CA10/CA12/CA13 nas parcelas de exclusão; CT-001, CT-017/CT-018, CT-020–CT-025.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final de suas regras e `DESIGN-HANDOFF.md`. Locadores: #detail-dialog, #delete-transaction, #delete-dialog e #confirm-delete. A confirmação e o efeito de exclusão são os aprovados no requisito, sem impor mecanismo interno de armazenamento.

Intenção estável de criação: `docs/harness/features/1016274-gestao-de-transacoes/slices/slices.md#D05-r001`.
