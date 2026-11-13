# [DEV] [WEB] [USUARIO] Dashboard financeiro - Convite para o assistente real

## Identidade e fontes

- Filha: [#1016384](https://redmine.remsoft.com.br/issues/1016384); papel: DEV; status remoto conferido: New.
- Pai: [#1016275](https://redmine.remsoft.com.br/issues/1016275); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **29**; pai espelha 23.
- Estimativa: **0,5h**, proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[QA] [WEB] [USUARIO] Assistente de consulta financeira — #1016369](https://redmine.remsoft.com.br/issues/1016369).
- Condições: [CT-001–CT-019, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016275 - Condições de testes.docx>), [anexo #3366 da QA #1016385](https://redmine.remsoft.com.br/attachments/download/3366/1016275%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação e execução de QA não realizadas neste fluxo.

## Entrega

Apresentar na Visão geral a área de convite ao assistente conforme o design, permitindo abrir a conversa financeira real já entregue por F06.

## Escopo e limites

A entrega abrange o convite e seu destino funcional. Não implementar chat, memória, IA ou registro por conversa novamente, nem criar promessa de capacidade futura para substituir o destino.

## Critérios de aceite

- O convite abre o chat real próprio de F06, já disponível, mantendo identidade e composição aprovadas.
- Visitante/conta pendente e referências alheias continuam sujeitos ao acesso financeiro vigente; não ampliar permissões ao navegar.
- Preservar o tratamento real de indisponibilidade do serviço em F06, sem substituí-lo por chat simulado, resposta fictícia ou controle sem destino.
- Retirar rótulos de assistente simulado/armazenamento local; o conteúdo do convite corresponde às capacidades reais disponíveis.
- Comparar .assistant-teaser/#open-chat com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, incluindo transições 767/768px e 1024/1025px, mantendo composição, textos, hierarquia, foco/teclado e ações legíveis/alcançáveis, sem sobreposição ou rolagem horizontal.

## Dependências

O início depende de [[QA] [WEB] [USUARIO] Assistente de consulta financeira](https://redmine.remsoft.com.br/issues/1016369), que já consome F04 e a base F01/F02 verificadas. A Visão geral já existe; não bloquear por um cálculo financeiro sem relação com o convite. Para concluir a composição da tela, integrar a superfície de Comparação e resultado mensal conforme V01.

## Referências

[Pai #1016275](https://redmine.remsoft.com.br/issues/1016275); R1/R10; CA09/CA11/CA12; CT-001/CT-016–CT-019.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: .assistant-teaser e #open-chat; abertura real de F06 substitui a simulação do protótipo. F07 entrega registro por IA separadamente.

Intenção estável de criação: `docs/harness/features/1016275-dashboard-financeiro/slices/slices.md#D07-r001`.
