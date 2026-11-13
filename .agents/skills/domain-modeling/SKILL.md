---
name: domain-modeling
description: Maintain a project's canonical domain vocabulary and assess whether consequential technical choices are genuine ADR candidates. Use when resolving shared domain terms, writing or reviewing domain-facing artifacts, or triaging architecture decisions; during requirements work, keep item-specific decisions in the requirement and only flag architecture candidates for technical leadership.
---

# Domain Modeling

At entry, read [user communication](references/user-communication.md) unless already read in this conversation. Apply it to progress, blockers and delivery, preserving this workflow's complete decision and approval requirements.

Respond in Brazilian Portuguese (pt-BR) from the first announcement, including questions, explanations, authored domain documents and final summaries. Preserve technical identifiers and canonical terms; apply this language choice when invoked by another workflow unless the user explicitly requests another language.

Keep domain language consistent without turning requirements into a second documentation system. Treat requirement documents, code, existing domain documentation, and conversation as evidence; ask the user to resolve product meaning when the evidence conflicts or leaves a consequential ambiguity.

## Orient

Read the repository's agent instructions first. Then read `CONTEXT-MAP.md` and the relevant context documents when a map exists; otherwise read root `CONTEXT.md`. Read ADRs relevant to the work. Missing domain files are a valid state and require no warning or preventive file creation.

**Complete when:** the applicable vocabulary and decisions have been inspected, or their absence has been established without changing the repository.

## Route the work

- When a shared term is being resolved, introduced, renamed, or used in an artifact, read [references/glossary.md](references/glossary.md). Apply its canonical wording to the current output and update domain documentation only when its lazy-write gate passes.
- When a technical choice may deserve durable architectural rationale, read [references/adr-candidates.md](references/adr-candidates.md). Use all three qualification tests; a strong result on one or two tests is insufficient.
- Read both references only when the task contains both branches.

## Preserve ownership

During Project Flow, keep behavior, business rules, scope, and other item-specific decisions in that item's canonical requirement. A reusable term may also enter the glossary when it passes the lazy-write gate, but the glossary never substitutes for or copies the requirement.

Domain modeling identifies architecture candidates; it does not decide architecture or manage the ADR lifecycle. During Project Flow, report a qualifying candidate to technical leadership and continue requirements work without creating an ADR. Outside Project Flow, hand a confirmed candidate to the project's architecture-decision process when the user asks to pursue it.

**Complete when:** every domain concept in the output uses the canonical term, every documentation edit passes its owning reference's gate, item-specific decisions remain with the requirement, and each architecture candidate is either supported by all three tests or dismissed with the failing test identified.
