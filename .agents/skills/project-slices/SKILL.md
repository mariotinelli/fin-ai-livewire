---
name: project-slices
description: Decomponha Feature, Bug ou escopo aprovado em tarefas DEV/QA e publique pelo MCP Redmine. Use para slicing, QA-only, Study excepcional e revisão de tarefas publicadas.
---

# Project Slices

Leia [comunicação](references/user-communication.md) uma vez por conversa. Responda em pt-BR. O agente conduz este fluxo por documentos Markdown e ferramentas disponíveis; acesso Redmine ocorre exclusivamente pelo MCP, sem ler credenciais ou chamar HTTP diretamente.

## 1. Reconhecer entrada

Receba um pai ou scope.md. Localize feature.md/bug.md aprovado e leia suas fontes, limites, critérios e decisões. Documento existente é entrada válida sem novos estados/hashes. Para escopo, siga [múltiplos pais](references/scope-orchestration.md); para artefatos antigos, [reconciliação histórica](references/legacy-reconciliation.md).

Para Feature, confira o [caminho de aceite funcional](../project-flow/references/catalog-discipline.md): o QA deve conseguir executar um fluxo no canal real do produto ao concluir a entrega, com as dependências anteriores disponíveis. Se as telas/consumidores necessários estiverem todos fora do escopo ou prometidos para Features futuras, exponha a fronteira inadequada e devolva ao responsável pelos requisitos antes de aprovar a decomposição. Não resolva criando uma QA para chamar métodos internos ou adiando todo o aceite. Preserve requisito, IDs e relações já aprovados até uma decisão específica de correção.

Confira identidade, contexto e versão remota conforme [preflight](../project-flow/references/redmine-preflight.md). Leia pai, todas as filhas abertas/fechadas, relações e metadados. Comportamento remoto divergente volta a [revisão de mudança](references/change-review.md); indisponibilidade permite preparar rascunho, sem declarar publicação concluída.

**Concluído quando:** requisito aprovado está identificado, diferenças e trabalho existente são conhecidos e, para Feature, há caminho funcional de aceite coerente com a entrega, ou o impedimento específico está registrado.

## 2. Inspecionar e propor

Invoke `vertical-slicing` para avaliar entregas verticais, cobertura, estimativas, fronteiras visuais e dependências reais. Inspecione código e testes; publicação não prova implementação. Mapeie cada regra/critério para DEV, comportamento existente com evidência, ou limite explicitamente aprovado. QA cobre o resultado completo. Sem DEV necessário, use [QA-only e adoção](references/existing-children.md).

Revise a granularidade antes das horas e da redação final: cada DEV tem uma interação completa, útil e verificável com suas dependências declaradas. Se reunir objetivos com aceite próprio, avalie separá-los; mantê-los juntos exige uma justificativa breve de necessidade em Entrega/Escopo e limites. Compartilhar código, tela ou entidade, caber em seis horas e obter estimativas concordantes não justificam o agrupamento. A conferência mínima do resultado não absorve automaticamente outras operações. Reaproveite os pareceres já previstos para questionar fronteiras e sobreposição antes de estimar, sem novo gate ou pergunta obrigatória.

Escreva `slices/slices.md` pelo [template](templates/slices.md), com descrições completas e estimativa positiva de até seis horas para cada DEV, QA ou Study. Divida QA maior que seis horas sem omitir cobertura. Quando uma incerteza impedir decomposição, siga [Study](references/studies.md).

Prepare [condições e DOCX obrigatório](references/test-conditions.md), [Sequencing](references/sequencing.md) e [dependências externas](references/dependencies.md). Preserve critérios de design e adaptações aprovadas nas tarefas e condições.

**Concluído quando:** fronteiras foram revisadas antes das estimativas, agrupamentos necessários estão explicados, cada DEV tem resultado demonstrável na própria conclusão com seus pré-requisitos disponíveis, sem depender de operações reservadas a entregas posteriores, e a proposta tem cobertura exaustiva, tarefas até seis horas, condições verificáveis, bloqueios acíclicos e prévia completa revisável.

## 3. Revisar e publicar

Quando houver arquivos de evidência/design, siga [evidências publicadas](../project-flow/references/published-evidence.md), incluindo anexos e imagens na descrição na prévia do conjunto. Nunca publique caminhos do computador ou links relativos ao repositório como acesso à evidência.

Siga [publicação](references/publication.md). Antes de apresentar a prévia, aplique a [revisão de escrita](../vertical-slicing/references/task-writing.md) às descrições finais formatadas, dentro desta mesma etapa. Peça uma decisão sobre o conjunto completo: pai/destino, filhas novas/adotadas/externas, campos, descrições completas, estimativas, relações, Sequencing e DOCX. Reutilize consentimento para o mesmo conteúdo, sem confirmação equivalente; mudanças materiais exigem nova revisão.

Publique somente as operações autorizadas pelo MCP. Consulte IDs conhecidos e reconcilie resultados incertos antes de repetir. Preserve status do pai, conteúdo humano, relações e filhas alheias. Registre operações e pendências de modo legível no próprio slices.md, sem motor de estados.

**Concluído quando:** leitura remota confirma filhas, relações, numeração, anexo e preservação de dados alheios; publicação parcial permanece parcial.

## 4. Materializar e entregar

Após conferência integral, materialize `tasks/dev-<id>-<slug>/task.md`, `tasks/qa-<id>-<slug>/task.md` e Study quando aplicável. Use [template da tarefa](templates/task.md), com IDs definitivos, referências e critérios autossuficientes. Não renomeie slug quando o título mudar.

Consolide no slices.md o resultado, links, decisões e pendências; em escopo atualize o marco de slicing do item sem afirmar implementação. Para revisão posterior de requisito, condições ou filhas use [mudanças](references/change-review.md).

**Concluído quando:** arquivos por ID correspondem ao remoto conferido, fonte e condições são localizáveis e próximo passo está claro.
