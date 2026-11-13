---
name: vertical-slicing
description: Evaluate and draft human-readable vertical implementation slices from an approved Feature and inspected code evidence. Use when another planning flow needs behavior-sized DEV work, estimates, real blockers, and exhaustive requirement coverage without publishing tracker issues.
---

# Vertical Slicing

At entry, read [user communication](references/user-communication.md) unless already read in this conversation. Apply it to progress, blockers and delivery, preserving this workflow's complete decision and approval requirements.

Turn an approved Feature or Bug and code evidence into narrow, complete, verifiable DEV deliveries. This discipline determines slicing quality; the calling workflow owns selection, dialogue, approval, persistence and any external integration.

Respond in Brazilian Portuguese (pt-BR), including proposals, task titles/descriptions, questions, estimates, progress and final delivery. Preserve technical identifiers and apply this language rule to delegated evaluations.

## Find the slices

Define the functional outcome and how QA can demonstrate it through the real product channel before estimating. A DEV slice is a small, complete interaction with a useful, verifiable result. Being end-to-end or fitting within six hours does not by itself establish adequate granularity.

Before estimating, look for goals or acceptance outcomes that can be prioritized and demonstrated separately. Split them unless they are indispensable to complete or demonstrate the main interaction. Sharing an entity, screen, component or implementation is not sufficient reason to group them. When several goals remain together, briefly explain their necessity in the existing delivery/limits; do not create a separate checklist or approval. Do not split an action from the response needed to make it useful, or create tasks per button, field or architectural layer.

Consider operations, alternative paths, business-rule or data variants, and simpler complete versions as possible cuts, not a fixed CRUD template. Each chosen interaction must satisfy its applicable correctness, permission, validation and visual requirements; allocate every remaining requirement to another delivery without silently dropping or weakening it. A legitimate ordering dependency does not force slices to merge. Prepared homologation data can support verification, but QA must observe the real product behavior, not a mock or an internal test standing in for the delivery.

Minimum result verification includes only what is needed to recognize and check the actual outcome of that interaction. It does not automatically include a separate consultation, navigation, report or management operation. Check that every supported outcome can be verified before later slices exist, including results outside a default view or filter; a success message alone may not prove the promised persisted effect. Use the product's approved interaction rather than inventing a demonstration screen or endpoint.

Internal rules and automated integration tests support DEV verification; they do not alone complete a Feature or its QA. The parent must deliver an observable product flow through an existing consumer or one included in its own scope, using screens for UI applications or the actual CLI/public API when that is the product. If acceptance depends entirely on future consumers, return the boundary gap for requirement review.

Background: [Humanizing Work's splitting patterns](https://www.humanizingwork.com/the-humanizing-work-guide-to-splitting-user-stories/), [Bill Wake on complete, small interactions](https://xp123.com/small-scalable-stories-in-the-invest-model/) and [action versus response](https://xp123.com/trigger-vs-response-split/). Apply these principles to the approved requirement; they do not authorize changing its scope or this workflow's hour ceiling.

Map every rule and criterion to observable behavior. Before classifying creation, adaptation or existing behavior, read and apply [inspection evidence](references/inspection-evidence.md). Group changes that must cross necessary layers together to produce the outcome; do not create tasks per layer or include a layer the behavior does not require.

For UI with a declared design, inspect its normalized sources and the parent's visual criteria/adaptations. Cover visual outcomes alongside functional ones; “visual only” does not remove them. Compare existing components/shell with the reference before claiming reuse or existing coverage. System-wide visual adaptation belongs to a separate visual foundation Feature, delivered first, with its own DEV/QA slices and estimates. Business slices name that supplier and consume its implemented baseline while owning their screen-specific appearance. If a business parent absorbs foundational alignment or omits its prerequisite, return the exact boundary/dependency gap for requirement alignment before affected slicing approval. Every UI slice retains its applicable visual criteria and reference locators; missing visual acceptance or unresolved field/state conflicts likewise return to the caller.

Integrate common technical preparation into its first consuming slice within the responsible Feature. The visual foundation is an independently accepted product Feature, not technical preparation to merge into a business slice. Separate other preparation only when it has its own verifiable purpose and the exception is explicit for approval. A small Feature may be one DEV slice when it already forms one complete interaction without a smaller useful split; do not impose task counts or equal sizes. Implemented behavior receives evidence and coverage rather than invented work. When the entire Feature is implemented, propose empty slices with complete `existing` coverage for the caller to confirm through review and route to QA only.

**Complete when:** each slice has a useful main outcome, its verification works within that slice and its stated prerequisites, any retained grouping is necessary, and every Feature behavior has exactly one coverage destination.

Compare every proposed delivery with the approved parent requirement's meaning. Material differences do not become slices: return the approved meaning, exact proposed correction, impact and affected children to the caller. Treat a consumable API as material expansion when absent from the approved requirement, even if an endpoint seems technically convenient. The caller owns the decision and parent alignment.

**Complete when:** each delivery is covered by the approved requirement or isolated as an explicit material divergence, without silently expanding scope.

When an objective technical question prevents complete slicing, read [Study discipline](references/studies.md). A Study produces evidence for a later proposal; it is not a behavior slice and does not authorize inventing the rest of the breakdown.

**Complete when:** complete slices are defined or the blocking uncertainty is formulated as a bounded Study.

## Order and estimate

Under the visual-first delivery policy, the separate foundation's implemented and visually verified baseline is a startup prerequisite for dependent business slices, not merely integration needed at final acceptance. Name the supplier and preserve that approved order without duplicating its visual work in consumers.

Separate startup blockers from suppliers required for completion. Publication does not prove implementation, and a simulated presentation does not prove integration. For mutual completion dependencies, define joint verification or revise slices without cyclic native blockers. Apply the ceiling after slicing, reuse review and calibration; it does not determine task count.

Declare only blockers that prevent starting a slice. For another Feature, identify the capability and its single owner; reference its supplier slice when available and, while the Feature has no children, identify the parent as provisional with an explicit reason. Maintain topological order in the relevant graph, not merely proposed edges; no blocker means immediate startup.

Before estimating DEV, QA or Study, read [estimation and calibration](references/estimation.md). Distinguish remaining work, team context, comparable references and explicit tech lead corrections.

When independent agents are available, request parallel assessments per slice from at least two agents, supplying the approved requirement, proposed delivery and technical evidence, including context and comparable calibrated references, without exposing either candidate estimate to the other. In these existing assessments, challenge the boundary, independent goals and overlap before suggesting hours; agreement on hours does not validate a grouping. Reconcile the cuts first, then remaining work, uncertainties and estimates, and own the final proposal; automatic averages or agent votes do not replace accountable judgment. Without independent agents, perform the same analysis directly and disclose that limitation during review.

Every new DEV, QA or Study task must have a positive estimate of at most six hours. If work exceeds six hours, refine it into smaller vertical, verifiable, nonoverlapping deliveries before approval. If evidence supports no coherent split, keep the proposal blocked for scope review; a justification does not authorize publishing an over-limit task.

**Complete when:** edges are real and acyclic, external dependencies do not duplicate supplied capabilities, and every estimate has an explicit basis and attribution, is reviewable by a person, and is greater than zero and at most six hours.

## Name and describe

Preserve the complete Feature name and prefixes. Prefix development with `[DEV]` and append the delivery suffix. For a consumable API delivery already specified in the requirement, insert `[API]` after `[WEB]`, for example `[DEV] [WEB] [API] [OPERACIONAL] Gestão de Usuários - Cadastro`; internal endpoints serving other behavior receive no marker.

Keep new titles focused on the delivery; do not add the destination project's name merely to identify its product. Preserve product names that distinguish functional scope, such as an integration with another system. An existing parent's title remains the naming basis; propose any redundant-name cleanup explicitly to the caller before changing published titles.

Before writing or reviewing descriptions, apply [task writing for implementers](references/task-writing.md). Use existing fields for functional context and expected change, relevant boundaries, verifiable criteria, dependencies and references. Technical context stays optional and does not prescribe implementation and testing.

Compare every assigned requirement with the complete slice description. Express observable conditions needed to verify delivery in acceptance criteria; a `traceability` reference does not replace that explanation. Preserve accessibility, responsiveness, timing and permission conditions when required rather than replacing them with generic adjectives such as “acessível”. Resolve omissions and contradictions between criteria, boundaries and coverage before presenting.

**Complete when:** title and description identify the outcome and boundaries without relying on conversation or prescribing the technical plan, and every assigned requirement's verifiable conditions appear in acceptance criteria.

## Requirement changes

When a new approved requirement supersedes the version used for published slicing, read [semantic-change discipline](references/semantic-changes.md). Classify meaning rather than bytes and locate affected and still-valid items before planning mutations.

**Complete when:** classification is supported by behavioral change and every baseline item is identified as affected or still valid.

When an approved functional review must be applied to published tasks, read [revision-application discipline](references/revision-application.md). It defines safe representation by task state and final preservation proof; the caller owns snapshots, approvals, persistence and MCP.

**Complete when:** each change uses a representation compatible with current remote state and no completed or out-of-impact task has been rewritten.

## Review the proposal

When the caller prepares test conditions alongside slices, apply [test-condition discipline](references/test-conditions.md) to the whole item, including Bugs and QA-only paths. The caller owns persistence, approval and document generation.

Present a numbered list of titles, deliveries, estimates and blockers followed by the coverage table. Invite the tech lead to merge, split and correct granularity or edges. Reassess coverage and dependencies after every change.

Read [evaluation scenarios](references/evaluation-scenarios.json) when evaluating the discipline or building semantic regressions.

**Complete when:** no rule is omitted or duplicated, no delivery expands the Feature, and the tech lead considers granularity appropriate.
