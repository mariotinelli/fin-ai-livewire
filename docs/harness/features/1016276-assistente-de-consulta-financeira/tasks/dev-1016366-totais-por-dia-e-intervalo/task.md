# [DEV] [WEB] [USUARIO] Assistente de consulta financeira - Totais por dia e intervalo

## Identidade e fontes

- Filha: [#1016366](https://redmine.remsoft.com.br/issues/1016366); papel: DEV; status remoto conferido: New.
- Pai: [Assistente de consulta financeira — #1016276](https://redmine.remsoft.com.br/issues/1016276); [requisito aprovado](../../feature.md).
- Projeto FinAi (65224); versão Livewire (20359).
- Slicing r001: [descrições, cobertura e publicação conferida](../../slices/slices.md).
- Sequencing: **19**; pai espelha 17.
- Estimativa: **2,5h**. Estimativa proposta e aprovada pelo responsável. Não é medição de execução.
- Bloqueios de início confirmados: [[DEV] [WEB] [USUARIO] Assistente de consulta financeira - Saldo geral em conversa salva — #1016364](https://redmine.remsoft.com.br/issues/1016364).
- Condições da Feature: [CT-001–CT-024, r001](../../slices/condicoes-teste-r001.md).
- Documento QA: [DOCX r001](<../../slices/r001/1016276 - Condições de testes.docx>), [anexo #3365 da QA #1016369](https://redmine.remsoft.com.br/attachments/download/3365/1016276%20-%20Condi%C3%A7%C3%B5es%20de%20testes.docx).
- Publicação e conteúdo remoto conferidos; implementação, execução de QA e chamada de IA não realizadas neste fluxo.

## Entrega

Permitir consultar receitas e despesas de hoje, ontem, uma data ou intervalo explícito, com categoria opcional, recebendo soma e contagem dos registros próprios com datas e filtros utilizados declarados.

## Escopo e limites

Hoje/ontem, datas explícitas e intervalos são recortes da consulta de realização diária. Validação de datas e inclusão das duas bordas são necessárias para que o resultado seja útil e correto. A consulta mensal tem entrega própria; usar o mesmo chat, catálogo e apresentação de totais sem duplicar seu preparo.

## Critérios de aceite

- Interpretar perguntas por IA real para hoje, ontem, data explícita e intervalo informado, separando receitas e despesas quando ambos forem solicitados.
- Usar America/Sao_Paulo para referências relativas e limites de dia, sem deslocar a data financeira registrada.
- Incluir datas inicial e final de um intervalo válido e aplicar o tipo/categoria compreendidos, sem incluir registros fora das bordas.
- Apresentar em pt-BR e BRL com centavos soma e quantidade por tipo solicitado, identificando dia ou intervalo e categoria quando houver.
- Usar exatamente o catálogo comum de F04, incluindo Outras receitas e Outras despesas, sem criar categoria ou supor classificação incerta.
- Intervalo invertido, data inexistente, categoria inexistente/incompatível ou interpretação insegura requer esclarecimento antes de número, sem corrigir ou completar silenciosamente o recorte. Continuidade e esclarecimento acrescenta a conclusão do diálogo pendente sem repetir a pergunta inteira.
- Recorte válido sem registros informa soma/contagem zero e ausência real; falha de IA ou dados informa o problema com possibilidade de retomada, sem resultado inventado ou zero de conveniência.
- Nova consulta usa registros atuais após criação, edição ou exclusão manual, sem tomar mensagens/respostas anteriores como fonte financeira e sem reescrever mensagens históricas.
- Manter o isolamento do titular confirmado no histórico, contexto, dados e resposta, inclusive por referência direta ou instrução para ignorar limites. Conversar não grava transações.
- Envio, processamento, persistência e recuperação usam o canal existente sem duplicar mensagens já salvas.
- Comparar respostas de dia/intervalo, recorte esclarecido, ausência e falha com V01/F01 em 360×800, 390×844, 430×932, 600×960, 820×1180, 1024×768, 1366×768, 1440×900 e 1920×1080, com transições 767/768px e 1024/1025px. Datas, categorias, valores, contagens e mensagens longas permanecem legíveis e distinguíveis por autoria, sem controles encobertos ou rolagem horizontal da página.

## Dependências

O início depende de Assistente de consulta financeira - Saldo geral em conversa salva. Para concluir, manter coerência dos totais e da classificação com Assistente de consulta financeira - Totais mensais por tipo e categoria; compartilhar o preparo do cálculo não constitui bloqueio de início adicional.

## Referências

[Pai #1016276](https://redmine.remsoft.com.br/issues/1016276); R2–R8/R10–R12 nas consultas diárias/por intervalo; CA03/CA05/CA06/CA08–CA12/CA14 nas respectivas parcelas; CT-008, CT-012–CT-015, CT-017, CT-020/CT-021, CT-023/CT-024.

Visual V01 — `docs/harness/scopes/2026-11-13-finai-mvp/sources/FinAI-Controle-Financeiro.zip`, entrada `index.html`, considerando a ordem final das regras e `DESIGN-HANDOFF.md`. Locadores: #assistant, #messages, #chat-form e #chat-input. Datas/intervalos inclusivos e esclarecimentos seguem R3–R6, prevalecendo sobre o parser demonstrativo.

Intenção estável de criação: `docs/harness/features/1016276-assistente-de-consulta-financeira/slices/slices.md#D03-r001`.
