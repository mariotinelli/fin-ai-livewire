# [DEV] [WEB] [USUARIO] Dashboard financeiro - Comparação e resultado mensal

## Identidade e fontes

- Filha: [#1016380](https://redmine.remsoft.com.br/issues/1016380); papel: DEV; status remoto conferido: New.
- Pai: [#1016275](https://redmine.remsoft.com.br/issues/1016275); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **25**; pai espelha 23.
- Estimativa: **1,5h**, proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Dashboard financeiro - Totais e contagens mensais — #1016379](https://redmine.remsoft.com.br/issues/1016379).
- Condições: [CT-001–CT-019, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016275 - Condições de testes.docx>), [anexo #3366 da QA #1016385](https://redmine.remsoft.com.br/attachments/download/3366/1016275%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Permitir comparar visualmente receitas e despesas do mês selecionado e reconhecer o resultado mensal, usando exatamente os mesmos totais apresentados nos cartões.

## Escopo e limites

Comparar o resultado tem aceite próprio depois da consulta de totais/contagens. Consumir o recorte e os valores já entregues, sem manter outro significado de mês ou cálculo financeiro divergente.

## Critérios de aceite

- Apresentar comparação de receitas/despesas e resultado igual a receitas menos despesas do mesmo mês selecionado, identificando o período e os valores em reais (BRL) com centavos exatos.
- Preservar os mesmos totais dos cartões, rótulos e valores legíveis, inclusive receitas/despesas iguais, zero e mês com somente um tipo.
- Resultado negativo é válido e aparece com sinal/identificação compreensível. Mês sem registros tem orientação vazia e valores reais coerentes, sem comparação enganosa ou dados demonstrativos.
- Troca de mês e criação/edição/exclusão manual bem-sucedida atualizam comparação/resultado com o recorte correto sem novo login; cancelar/falhar não modifica números.
- Carregamento/falha não vira comparação vazia ou zero fictício. Se o período novo falhar, identificar indisponibilidade sem atribuir ao novo mês os valores anteriores.
- Consumir exclusivamente dados próprios atuais, respeitando autorização e exclusões da consulta mensal.
- Comparar .overview-grid, #graph, #chart-month e #month-result com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, nos estados positivo/negativo/igual/zero/vazio/carregamento/erro. Preservar composição, rótulos e valores extensos legíveis, sem sobreposição ou rolagem horizontal da página.

## Dependências

O início depende de Dashboard financeiro - Totais e contagens mensais, que fornece recorte e números funcionais. O convite ao assistente ocupa outra superfície e integra a composição final quando disponível, sem reconstruir seus dados ou comportamento.

## Referências

[Pai #1016275](https://redmine.remsoft.com.br/issues/1016275); R1/R3–R5/R8–R10; CA02/CA03/CA06–CA08/CA10/CA11; CT-004–CT-007, CT-011–CT-016, CT-018/CT-019.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: .overview-grid, #graph, #chart-month e #month-result; balanço simples aprovado em Q2/Q7.

Intenção estável de criação: `docs/harness/features/1016275-dashboard-financeiro/slices/slices.md#D03-r001`.
