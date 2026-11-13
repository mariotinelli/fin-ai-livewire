# [QA] [WEB] [USUARIO] Gestão de transações

## Identidade e fontes

- Filha: [#1016356](https://redmine.remsoft.com.br/issues/1016356); papel: QA; status remoto conferido: New.
- Pai: [Gestão de transações — #1016274](https://redmine.remsoft.com.br/issues/1016274); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **16**; pai espelha 11.
- Estimativa: **2h**, corrigida pelo responsável e publicada. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Gestão de transações - Histórico por mês e detalhes — #1016351](https://redmine.remsoft.com.br/issues/1016351); [[DEV] [WEB] [USUARIO] Gestão de transações - Pesquisa e filtros — #1016352](https://redmine.remsoft.com.br/issues/1016352); [[DEV] [WEB] [USUARIO] Gestão de transações - Cadastro classificado — #1016353](https://redmine.remsoft.com.br/issues/1016353); [[DEV] [WEB] [USUARIO] Gestão de transações - Edição de transações — #1016354](https://redmine.remsoft.com.br/issues/1016354); [[DEV] [WEB] [USUARIO] Gestão de transações - Exclusão confirmada — #1016355](https://redmine.remsoft.com.br/issues/1016355).
- Condições da Feature: [CT-001–CT-025, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016274 - Condições de testes.docx>), [anexo #3363 da QA #1016356](https://redmine.remsoft.com.br/attachments/download/3363/1016274%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Verificar a gestão manual completa de transações e categorias pelas telas reais, cobrindo CT-001–CT-025 da revisão r001, com evidências de resultados, defeitos e um reteste focalizado.

## Escopo e limites

Executar uma única QA da Feature inteira. Preparar contas, dados históricos, controles de relógio, latência e falhas reversíveis em homologação. Verificações automatizadas relevantes apoiam a conferência, sem substituir o fluxo real ou a comparação visual. A execução não depende dos canais futuros F05/F06/F07.

## Critérios de aceite

- Executar CT-001–CT-025 do documento de condições r001, registrando resultado e evidência por condição, cobrindo R1–R12 e CA01–CA15.
- Demonstrar cadastro de receita/despesa, permanência em outro navegador, consulta mensal e total, pesquisa literal, filtros combinados, limpeza, paginação e leitura integral dos detalhes.
- Conferir os cinco campos obrigatórios, valores positivos em BRL até R$ 999.999.999,99 e duas casas sem arredondamento silencioso, descrição de 1–120 caracteres após retirada de espaços nas extremidades e datas válidas de 01/01/1900 a hoje em America/Sao_Paulo.
- Conferir todos os nomes e a compatibilidade das quatro categorias de receita e oito de despesa, troca de tipo, opções sem registros, catálogo comum entre contas e ausência de manutenção.
- Demonstrar edição de cada campo sem cópia, sucesso fora do recorte, cancelamentos de criação/edição/exclusão, confirmação explícita, exclusão persistida e página válida.
- Conferir falhas de leitura, categorias quando sua obtenção puder falhar, gravação e resultado incerto; processamento impede repetição do mesmo envio, enquanto transações intencionais iguais são permitidas.
- Verificar indisponibilidade concorrente sem recriação, acesso direto e isolamento entre duas contas, visitante/conta pendente e ausência de acesso financeiro de terceiros por administração/suporte.
- Comparar listagem, filtros, mês, paginação, formulários, detalhes, confirmação e estados aplicáveis com V01 e a base F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px. Verificar legibilidade, rótulos, foco, teclado, campos resumidos acessíveis em detalhes, ações alcançáveis e ausência de sobreposições ou rolagem horizontal da página.
- Concluir a jornada manual integrada de CT-025 com dados reais e atuais, sem novo login para refletir alterações e sem aguardar dashboard/IA. A verificação da preservação das respostas históricas pertence a F06/F07 nos respectivos canais.
- Registrar defeitos e repetir os cenários afetados em um reteste focalizado; falha ou condição não executada permanece explicitamente pendente.

## Dependências

Executar após Gestão de transações - Histórico por mês e detalhes; Gestão de transações - Pesquisa e filtros; Gestão de transações - Cadastro classificado; Gestão de transações - Edição de transações; e Gestão de transações - Exclusão confirmada. Essas entregas consomem F01/F02 implementadas e verificadas.

## Referências

[Pai #1016274](https://redmine.remsoft.com.br/issues/1016274); R1–R12, CA01–CA15; condições r001, CT-001–CT-025; anexo previsto `1016274 - Condições de testes.docx`.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final de suas regras e `DESIGN-HANDOFF.md`. Locadores: #transactions, #month-wrap, #transaction-dialog, #detail-dialog e #delete-dialog. O requisito prevalece sobre armazenamento local, mensagens de simulação e regras funcionais do protótipo.

Intenção estável de criação: `docs/harness/features/1016274-gestao-de-transacoes/slices/slices.md#QA-r001`.
