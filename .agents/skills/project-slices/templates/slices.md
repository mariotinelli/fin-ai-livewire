# Fatiamento de <Feature>

## Prévia numerada

1. `<título DEV preservando o nome pai>` — `<estimativa>h`
   - Entrega: comportamento observável.
   - Bloqueado por: números anteriores ou nenhum.
   - Bloqueios externos: slice específico; ou Feature provisória, capacidade e motivo explícito; ou nenhum.

## Cobertura

| Regra ou critério | Destino | Evidência |
| --- | --- | --- |
| `<id>: <resumo>` | Slice 1 / existente / outra Feature | `<evidência>` |

## Condições de teste

As condições integram a aprovação da prévia completa e sua autorização de publicação. Consulte as [condições e o DOCX obrigatório](../references/test-conditions.md).

Documento: `<ID do pai> - Condições de testes.docx`; informe o caminho da revisão e as QAs de destino na publicação proposta, seguindo a referência acima.

### Contexto

<contexto comum necessário para verificar o comportamento do item inteiro>

### CT-001 — <título>

Verificação: <o que verificar, com dados e passos quando necessários>.

Resultado esperado: <resultado observável sustentado pelo requisito aprovado>.

Origem no requisito: <IDs e resumos dos requisitos correspondentes>.

Inclua contexto específico e agrupamento somente quando ajudarem a leitura. Para regressões externas, explicite o impacto que as justifica.

## Descrições completas

### 1. <título>

#### Entrega

<contexto funcional comprovado, quando relevante; mudança esperada e comportamento a preservar>

#### Escopo e limites

<fronteiras necessárias para esclarecer a responsabilidade desta tarefa>

#### Critérios de aceite

- <condição e resultado observável de um comportamento>.
- <outro cenário verificável, preservando as condições do requisito>.

#### Dependências

<capacidade e tarefa responsável; distinguir bloqueio de início de integração para conclusão; usar nome e link confirmado quando disponível>

#### Referências

Feature Redmine `<id>`; regras/critérios `<ids>`.

Quando houver interface com design: `<ID e referência remota confirmada da fonte visual principal>`;
`<telas/estados aplicáveis>`; `<adaptações aprovadas e origem da decisão>`.
Os critérios visuais e a responsabilidade pela aparência compartilhada devem estar explícitos
na entrega, no aceite e nas condições de teste correspondentes.

Arquivos usados como evidência devem ser anexados e imagens apresentadas na descrição
conforme [publicação de evidências](../../project-flow/references/published-evidence.md).
Caminhos de origem ficam somente no documento local; a prévia remota usa anexos e links acessíveis.

Inclua `Contexto técnico` antes das referências somente quando uma decisão aprovada exigir esse contexto; omita a seção nos demais casos. Aplique a [disciplina de escrita](../../vertical-slicing/references/task-writing.md) à descrição final formatada, depois de preencher o template e antes de apresentar a prévia para aprovação.

## Publicação proposta

Inclua a descrição QA completa, os campos Redmine derivados, relações, anexo e o tratamento de cada filha existente. Esta seção e as anteriores formam uma única prévia e recebem uma única decisão.

Cada filha nova inclui no rodapé uma identidade textual estável `Origem: project-slices:<rascunho>:<entrega>`, preservada em tentativas e conciliação. A correspondência com o caminho deste slices.md fica somente no documento local, sem link ou caminho local na descrição remota.

## Sequencing

<Leitura completa da versão, bloco, números por filha, âncora do pai e deslocamentos autorizados.>

## Revisão e publicação

| Operação autorizada | ID/URL conhecido | Resultado confirmado/pendente/incerto | Próximo passo |
| --- | --- | --- | --- |

## Resultado consolidado e pendências
