---
name: project-flow
description: Conduza catálogo de escopo ou requisito Feature/Bug até publicação aprovada no Redmine. Use para definir comportamento com o usuário, organizar demandas e publicar pelo MCP sem implementar ou fazer slicing.
---

# Project Flow

Leia [comunicação](references/user-communication.md) uma vez por conversa. Responda em pt-BR. O agente conduz o trabalho com documentos e ferramentas disponíveis, sem motor de estados. Toda comunicação Redmine ocorre exclusivamente pelo MCP; não leia credenciais nem chame a API HTTP diretamente.

## 1. Entender a entrada

Identifique se a solicitação é escopo com vários itens ou uma Feature/Bug, reutilizando escolhas já explícitas. Leia fontes declaradas, instruções, código e domínio pertinentes. Fontes e exemplos são evidência a avaliar com o usuário, não autoridade automática. Distinguir fatos verificados, decisões aprovadas e propostas.

As entradas existentes `new-scope` e `new-issue` continuam selecionando esses dois ramos, respectivamente; não exigem comando auxiliar.

Para design, leia [fontes visuais](references/design-inputs.md). Para arquivos existentes/interrupção, leia [artefatos e retomada](references/artifact-contract.md). Redmine indisponível não impede entrevista e rascunhos locais.

**Concluído quando:** objetivo, fontes, identidade conhecida e decisões materiais pendentes estão claros, sem preencher dados desconhecidos com placeholders remotos.

## 2. Catalogar quando houver escopo

Siga [catálogo](references/catalog-discipline.md). Escreva scope.md com todos os candidatos, limites, dependências e ordem. Identifique capacidades visuais compartilhadas com dono próprio quando o produto as exigir. O catálogo aprovado vem antes de entrevistar itens em profundidade.

**Concluído quando:** cada candidato tem destino/justificativa, cada Feature tem ator, fluxo, resultado e caminho de validação pelo QA no canal real do produto, e o usuário revisou o catálogo; próximo item respeita suas dependências.

## 3. Definir requisito

Invoque `requirements-grilling` para resolver somente lacunas funcionais materiais e `domain-modeling` para vocabulário. Inspecione fatos técnicos; não peça ao usuário decisões de implementação nem imponha mecanismos no requisito.

Use [feature.md](templates/feature.md) ou [bug.md](templates/bug.md). Preserve objetivo, atores/permissões, comportamento, regras, dados percebidos, limites, critérios estáveis, dependências e referências. Bug explicita reprodução, atual/esperado e evidência, sem causa inventada. Design e adaptações aprovadas viram critérios visuais verificáveis. Contradições materiais voltam ao usuário.

Para Feature, aplique a [regra de fluxo e aceite funcional](references/catalog-discipline.md) também em `new-issue`, mesmo sem catálogo. Confira que o fluxo principal e os critérios podem ser demonstrados pelo QA na própria conclusão, usando telas ou o canal real de um produto CLI/API pública. O escopo não pode excluir todas as interações necessárias e transferir todo o aceite para consumidores futuros. Se houver apenas preparação interna, proponha incorporá-la à primeira entrega consumidora; testes internos não tornam essa fronteira uma Feature funcional.

Consolide resultado no documento ao terminar entrevista, sem histórico obrigatório por pergunta. Apresente requisito completo para revisão. Se ainda houver lacuna material em escopo, não declare aprovação. Criação antes da entrevista só quando solicitada explicitamente, com prévia do objetivo inicial distinta da publicação final.

**Concluído quando:** requisito autossuficiente revisado pelo responsável, com decisões atribuídas e sem lacunas materiais disfarçadas de exclusões; para Feature, ator, fluxo, resultado percebido e validação pelo QA estão coerentes com seu próprio escopo e dependências.

## 4. Publicar e conferir

Siga [preflight](references/redmine-preflight.md) e [publicação](references/redmine-publication.md). Resolva destino, versão aberta escolhida pelo usuário, classificação/tracker e convenção de título, consultando demandas semelhantes antes de criar. Apresente prévia completa com operações/campos e preserve status/conteúdo humano. Autorize o conteúdo apresentado uma vez; mudanças materiais exigem revisão.

Publique pelo MCP, registre IDs e consulte resultados incertos antes de repetir. Consolide ID/URL, decisões, resultados e pendências no documento. Scope.md registra progresso e relações por item; publicação de requisito não é implementação.

**Concluído quando:** conteúdo e relações autorizados foram relidos e conferidos, status/campos alheios preservados e caminho definitivo por ID é conhecido. Resultado incerto mantém publicação incompleta.

## 5. Entregar passagem

Indique feature.md/bug.md aprovado, pai confirmado e fontes para `project-slices`. Em escopo, continue itens já autorizados e consolide a cada conclusão; não repita autorização para o mesmo conteúdo. Impedimento material bloqueia o ramo dependente, preservando o independente.

**Concluído quando:** todos os itens solicitados têm entrega ou impedimento identificado, referências resolvem e o próximo papel dispõe de entrada suficiente.
