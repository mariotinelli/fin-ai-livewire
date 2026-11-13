---
name: requirements-grilling
description: Interview stakeholders to expose and resolve functional requirement gaps for a product scope, Feature, or Bug. Use while defining or reviewing observable behavior and acceptance; leave technical design and implementation planning to later roles.
---

# Requirements grilling

At entry, read [user communication](references/user-communication.md) unless already read in this conversation. Apply it to progress, blockers and delivery, preserving this workflow's complete decision and approval requirements.

Respond in Brazilian Portuguese (pt-BR) from the first announcement, including questions, recommendations, decision records, authored requirements and final review. Preserve technical identifiers and apply this language choice when invoked by another workflow unless the user explicitly requests another language. The question example below is user-facing Portuguese, not the language of these instructions.

Turn the available evidence and stakeholder answers into shared functional understanding. Product decisions belong to the stakeholder; technical facts come from the available repository, tools, and sources.

Use the caller's canonical document when one exists. Otherwise consolidate the final understanding in the conversation. Keep unresolved material decisions visible; consolidate decisions when the interview closes or a material interruption occurs, without writing every question/answer round. Do not invent a project workflow, publish remotely, or create implementation artifacts.

## 1. Identify material decisions

Read every declared source that is available and inspect relevant technical facts rather than asking the stakeholder to retrieve them. Treat sources as evidence, not authority. Identify the item being decided, its observable goal, and the functional decisions that branch from it.

Before the first round, read [the functional boundary and decision-tree rules](references/decision-tree.md).

Reuse answers already given in the conversation and repository facts. Ask again only when new evidence changes the decision, explaining what changed. A material uncertainty can change delivered behavior, scope, or verifiable acceptance; prioritize those uncertainties over incidental detail.

**Complete when:** the delivery boundary and known material uncertainties are identified, facts needed for the next round have been checked or marked unavailable, and implementation choices are left to implementation.

## 2. Ask a small round

Select a small set of the highest-impact answerable decisions, usually one to three questions. Favor decisions that unblock other questions or settle acceptance. Hold dependent questions until their prerequisites are answered, and retain other material uncertainties for later rounds. The number of independent questions does not determine the size of the round.

Number questions monotonically for the session. For each question:

```markdown
Q<N> — <título da decisão>

Contexto: <o que as evidências já estabelecem e a incerteza específica>

Por que importa: <qual comportamento visível, limite de escopo ou condição de aceite muda>

Pergunta: <uma decisão direta de produto em linguagem ligada ao item>

Opções e consequências: <alternativas reais e o que o usuário observaria em cada uma>

Recomendação, quando fundamentada: <opção preferida e evidências ou implicações que a sustentam>
```

Write each question as a compact decision brief, not a bare prompt. Ground it in the selected Feature or Bug, explain unfamiliar terms, and make the behavioral consequence of answering visible. Use options only when they represent real alternatives; include an open answer when the evidence does not justify an exhaustive list. A binary question still explains the observable result of each choice. Keep one decision per question so the stakeholder can answer unambiguously.

When there is no sound basis for a recommendation, say so and explain the relevant trade-off without manufacturing a preferred answer. A recommendation is never an answer on the stakeholder's behalf. Do not pad a question with generic background: every sentence must help the stakeholder understand or decide this specific uncertainty.

Wait for answers to this round before expanding it. If the evidence already settles the item, proceed directly to final review without manufacturing questions.

**Complete when:** the round contains only material, currently answerable questions; each has a unique number, item-specific context, decision impact, one direct question, and consequences for every presented option; recommendations have a stated basis or explicitly state that no sound preference exists; remaining material uncertainties stay tracked.

## 3. Reconcile the round

Incorporate answers into the understanding with their source. Mark the affected gap `resolved` only when the answer settles the decision and its material ambiguity, including an explicit scope boundary when appropriate. Reopen descendants whose assumptions the answer invalidates, then select the next small round. The tree is a reasoning aid, not a persisted state machine.

If an answer is postponed, belongs to a third party, conflicts with evidence, or new evidence arrives, read [the exception and provenance rules](references/exceptions.md) before continuing.

Do not preserve pure technical questions in requirement documents or a backlog for later. When a question mixes behavior with a proposed implementation, ask only for the externally perceived effect; leave the mechanism to the implementation role.

**Complete when:** every answer has been incorporated or remains visibly open with the correct state, invalidated decisions have been reopened, and the next round reflects the updated prerequisites and delivery boundary.

## 4. Repeat and close

Scale the review to the demand. A simple change may need no questions or a single round. For extensive sources, reconcile every relevant behavior and contradiction against the delivery boundary, using more small rounds as needed. Coverage is proportional to the evidence and impact, not a generic questionnaire.

Prepare the final requirement for review when its goal, relevant flows, rules, limits, and acceptance are coherent; no material in-scope ambiguity, contradiction, or third-party decision remains unresolved; and explicitly excluded details have attributable boundaries. An empty round alone does not prove readiness. Keep material gaps visible as `blocking` or `deferred`; neither silence nor a short interview resolves them.

The final requirement review can confirm the reconciled understanding. When a caller owns that review, hand off as **ready for review**, with any exclusions and their provenance, without requiring a separate intermediate confirmation. The caller's approval of the final document completes confirmation. Standalone, present the final understanding in the conversation and ask for confirmation there. Silence or merely answering the last question is not approval.

**Complete when:** no material gap in the delivery remains and the stakeholder approves the final requirement or standalone understanding. Until approval, distinguish ready for review from blocked or deferred; do not claim approval or authorize publication on the caller's behalf.

When evaluating this discipline itself, use the machine-readable [evaluation scenarios](references/evaluation-scenarios.json).

## Attribution

The branching decision tree, numbered questions, recommendations, and shared-understanding review are substantially adapted from Matt Pocock's `grilling` skill. See [NOTICE.md](NOTICE.md) and [LICENSE-MATT-POCOCK](LICENSE-MATT-POCOCK).
