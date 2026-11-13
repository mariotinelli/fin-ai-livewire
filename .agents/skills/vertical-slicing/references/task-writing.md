# Task descriptions for implementers

Write user-facing descriptions and examples in Brazilian Portuguese, using complete sentences with initial capitals and appropriate punctuation in paragraphs and list items. Preserve the spelling and case of code, identifiers and literal values.

## Write the delivery

Use `delivery` to explain relevant functional context and expected change. State the outcome directly: prefer “Estabelecer os padrões compartilhados de cores e tipografia” to “Esta é a dona da paleta”. When inspection proves existing behavior, distinguish adaptations from preservation. For new capabilities, explain the outcome to create without inventing a previous scenario. Keep files, symbols and detailed technical conclusions in inspection evidence.

In `limits`, record only boundaries preventing real uncertainty about responsibility. Avoid repeating delivery or enumerating every excluded Feature. Use product language: “manter o acesso por 30 dias” and “sair somente deste navegador” are more direct than “comportamento temporal da lembrança” and “isolamento da saída”.

**Complete when:** implementers can identify what to change and preserve without consulting the conversation or receiving a technical recipe.

## Write criteria and relations

Write one verifiable condition per item, separating outcomes that can independently pass or fail instead of putting several checks in a single paragraph. Related conditions may stay together when clearer. Preserve all approved timing, device, permission and accessibility details; do not impose size or count limits that remove coverage. Use one acceptance section. `kind` remains internal; criterion text must not repeat the user-facing labels Sucesso, Erro or Permissão.

Adapt shared text to each task's actual responsibility rather than copying the complete common block into every description. Retain every assigned condition, including approved visual values, viewports and states. Name a supplier's capability as a dependency instead of importing the supplier's delivery into this task; preserve total requirement coverage across the proposal.

In `dependencies`, name the necessary capability and responsible task. Distinguish startup blockers from integration needed for completion without automatically turning the latter into `blocked_by`. Without relevant relations, simply state there are no dependencies. Explanations of blocker calculation belong to planning, not descriptions.

Reference the required capability and responsible task by name and, when the destination exists and is confirmed, by link. Numbers such as “entrega 1” identify preview entries only and do not suffice independently. Without a confirmed destination, retain the name instead of inventing an ID or URL. Do not add links to approved content during publication without corresponding review.

Keep traceability as compact references to the parent requirement and covered IDs. References supplement criteria rather than replacing their explanation.

For a UI delivery, include the primary visual source ID, repository-relative normalized path and relevant screen/state locators in `description.visual_references` (a nonempty string array rendered under `Referências`). Explain approved differences in fields, actions or states in delivery/limits, with their decision origin. Visual criteria describe the appearance to preserve and how it can be compared with the reference, including applicable viewport/state boundaries. Shared shell ownership and completion dependencies must be named. A source link alone, generic responsiveness, or reuse of existing components does not express visual acceptance. Backend-only slices inherit no unrelated visual work.

For visual foundation slices, retain the inspected inventory of all existing screens and verify navigation on supported destinations. Screens lacking a dedicated mockup inherit the established visual language with their behavior preserved. Future business pages, routes and navigation belong to their supplier Features; do not introduce placeholder-page deliveries into the foundation's criteria. Explicit approved exclusions remain attributable boundaries.

**Complete when:** every assigned condition is represented, criteria can be checked individually, and relations are understandable outside the preview.

## Editorial example: authentication

These Portuguese excerpts illustrate writing, not a new breakdown or a complete description. Use current inspection facts and preserve all other requirements when applying them.

Before: “Permitir que pessoas de todos os perfis com conta ativa entrem no Nexum.”

After, when inspection proves the existing restriction: “O login atual restringe a entrada de alguns perfis. Ajustar a entrada para que qualquer conta ativa acesse o painel permitido ao seu perfil, preservando as restrições administrativas.”

Before: “Erro: Campos obrigatórios ausentes ou e-mail inválido exibem validação; credenciais inválidas recusam a entrada; conta inativa recebe orientação.”

After:

- Sem e-mail ou senha, o formulário informa os campos obrigatórios e permite corrigir sem autenticar.
- Com e-mail em formato inválido, o formulário informa a validação e permite corrigir sem autenticar.
- Com credenciais incorretas, a entrada é recusada com mensagem acessível.
- Com conta inativa, a entrada é recusada e a mensagem orienta solicitar reativação.

Before: “Usa o bloqueio da entrega 1; compartilhar código não constitui bloqueio de início.”

After: “Pode iniciar com a base de login existente. Para concluir, integrar com ‘Autenticação - Entrada e navegação de contas ativas’ e verificar que a lembrança de acesso também recusa contas desativadas.”

## Review before approval

Read the final formatted description as its recipient, not only the labeled proposal. When turning “Entrega: substituir...” into a standalone paragraph, revise it to start with “Substituir...”; apply the same review to limits, dependencies and references. Check expected change, preservation of existing behavior, every assigned requirement's coverage, scenario separation and related-task identification. Remove repetition, estimates already held in dedicated fields and administrative comments about approval or workflow operation.

Perform this review in the existing proposal review before presenting it for approval, without a separate gate, checklist file or user question. After approval, preserve the authorized text; later editorial changes follow the caller's existing revision flow.

**Complete when:** the description is self-contained and readable without coverage omissions, scope expansion or unnecessary administrative language. This is semantic review; a structural helper does not prove writing quality.
