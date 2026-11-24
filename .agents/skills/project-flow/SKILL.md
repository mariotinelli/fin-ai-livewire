---
name: project-flow
description: Defina e publique escopos, Features e Bugs. Ao receber uma entrega do projeto, atualize o mapa funcional em PDF e o Redmine.
---

# Project Flow

Leia [comunicação](references/user-communication.md) uma vez por conversa. Responda em pt-BR. O agente conduz o trabalho com documentos e ferramentas disponíveis, sem motor de estados. Toda comunicação Redmine ocorre exclusivamente pelo MCP; não leia credenciais nem chame a API HTTP diretamente.

## 1. Entender a entrada

Se o pedido for apenas gerar ou revisar o mapa do projeto, use o [modelo e a referência do mapa funcional](references/functional-map.md) e encerre após conferir o PDF local.

Na configuração inicial do mapa, ligue a etapa de entrega existente conforme [Registrar uma entrega](references/delivery.md). Se o pedido for apenas configurar a chamada, encerre após conferi-la. Quando a etapa informar uma entrega, siga diretamente a atualização e a publicação descritas nessa referência.

Identifique se a solicitação é escopo com vários itens ou uma Feature/Bug, reutilizando escolhas já explícitas. Leia fontes declaradas, instruções, código e domínio pertinentes. Fontes e exemplos são evidência a avaliar com o usuário, não autoridade automática. Distinguir fatos verificados, decisões aprovadas e propostas.

As entradas existentes `new-scope` e `new-issue` continuam selecionando esses dois ramos, respectivamente; não exigem comando auxiliar.

Nos dois ramos, localize o mapa funcional do produto. Se faltar, gere a fonte editável e o primeiro PDF conforme o [mapa funcional](references/functional-map.md). Reaproveite a inspeção de fontes do catálogo e registre o caminho do guia no documento local.

Para design, leia [fontes visuais](references/design-inputs.md). Para arquivos existentes/interrupção, leia [artefatos e retomada](references/artifact-contract.md). Redmine indisponível não impede entrevista e rascunhos locais.

**Concluído quando:** objetivo, fontes, identidade conhecida e decisões materiais pendentes estão claros, sem preencher dados desconhecidos com placeholders remotos.

## 2. Catalogar quando houver escopo

Siga [catálogo](references/catalog-discipline.md). Escreva scope.md com todos os candidatos, limites, dependências e ordem. Identifique capacidades visuais compartilhadas com dono próprio quando o produto as exigir. O catálogo aprovado vem antes de entrevistar itens em profundidade.

**Concluído quando:** cada candidato tem destino/justificativa, cada Feature tem ator, fluxo, resultado e caminho de validação pelo QA no canal real do produto, e o usuário revisou o catálogo; próximo item respeita suas dependências.

## 3. Definir requisito

Invoque `requirements-grilling` para resolver somente lacunas funcionais materiais e `domain-modeling` para vocabulário. Inspecione fatos técnicos; não peça ao usuário decisões de implementação nem imponha mecanismos no requisito.

Use [feature.md](templates/feature.md) ou [bug.md](templates/bug.md). Preserve objetivo, atores/permissões, comportamento, regras, dados percebidos, limites, critérios estáveis, dependências e referências. Bug explicita reprodução, atual/esperado e evidência, sem causa inventada. Design e adaptações aprovadas viram critérios visuais verificáveis. Contradições materiais voltam ao usuário.

Para Feature, aplique a [regra de fluxo e aceite funcional](references/catalog-discipline.md) também em `new-issue`, mesmo sem catálogo. Confira que o fluxo principal e os critérios podem ser demonstrados pelo QA na própria conclusão, usando telas ou o canal real de um produto CLI/API pública. O escopo não pode excluir todas as interações necessárias e transferir todo o aceite para consumidores futuros. Se houver apenas preparação interna, proponha incorporá-la à primeira entrega consumidora; testes internos não tornam essa fronteira uma Feature funcional.

Ao terminar a entrevista de cada Feature ou Bug, avulso ou de um escopo, [compare o fluxo anterior e o proposto](references/flow-comparison.md). Gere o PDF do item e apresente-o com o resumo da mudança e o requisito completo na mesma revisão. Aplique ajustes da proposta mantendo a origem do fluxo anterior. Se ainda houver lacuna material em escopo, não declare aprovação. Criação antes da entrevista só quando solicitada explicitamente, com prévia do objetivo inicial distinta da publicação final.

Na mesma revisão, [prepare os capítulos afetados e atualize o mapa integral após aprovação](references/map-approval.md). Aplique também ao retomar um requisito aprovado, ao revisar uma proposta sobreposta e quando apenas parte do escopo estiver aprovada.

**Concluído quando:** o responsável revisou o requisito autossuficiente e o PDF correspondente, a origem da comparação é recuperável e as decisões estão atribuídas. Para Feature, ator, fluxo, resultado percebido e validação pelo QA estão coerentes com seu próprio escopo e dependências. O mapa vigente incorpora a revisão aprovada, ou o requisito identifica a pendência de atualização ou a ausência de mudança funcional.

## 4. Publicar e conferir

Na publicação do requisito completo, siga a [publicação dos PDFs da Feature ou do Bug](references/pdf-publication.md). Cada tarefa recebe sua comparação e sua cópia da edição aprovada do mapa. Enquanto houver apenas um escopo ou rascunho, os PDFs ficam locais.

Para arquivos e links de evidência/design, siga [evidências publicadas](references/published-evidence.md): anexe os arquivos disponíveis e mostre imagens na descrição. Caminhos pessoais e links relativos ao repositório não podem substituir referências remotas acessíveis.

Siga [preflight](references/redmine-preflight.md) e [publicação](references/redmine-publication.md). Resolva destino, versão aberta escolhida pelo usuário, classificação/tracker e convenção de título, consultando demandas semelhantes antes de criar. Apresente prévia completa com operações/campos e preserve status/conteúdo humano. Autorize o conteúdo apresentado uma vez; mudanças materiais exigem revisão.

Publique pelo MCP, registre IDs e consulte resultados incertos antes de repetir. Consolide ID/URL, decisões, resultados e pendências no documento. Scope.md registra progresso e relações por item; publicação de requisito não é implementação.

Ao confirmar ID/URL e materializar a pasta do item, confira e atualize os links de origem na edição corrente do mapa pela mesma identidade local. Preserve o exemplar aprovado para os anexos desta revisão.

**Concluído quando:** conteúdo e relações autorizados foram relidos e conferidos, status/campos alheios preservados e caminho definitivo por ID é conhecido. Resultado incerto mantém publicação incompleta.

## 5. Entregar passagem

Indique feature.md/bug.md aprovado, pai confirmado e fontes para `project-slices`. Em escopo, continue itens já autorizados e consolide a cada conclusão; não repita autorização para o mesmo conteúdo. Impedimento material bloqueia o ramo dependente, preservando o independente.

**Concluído quando:** todos os itens solicitados têm entrega ou impedimento identificado, referências resolvem e o próximo papel dispõe de entrada suficiente.
