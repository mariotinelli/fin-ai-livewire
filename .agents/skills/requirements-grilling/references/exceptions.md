# Exceptions and provenance

Read the section whose condition occurred; do not load these branches into an ordinary round preemptively.

## Deferred decisions

Record the question, why it matters to this delivery, its current answerer, the decisions it blocks, and the condition for resuming. Keep it `deferred` until an attributable answer resolves it. Continue independent branches of the same item in small rounds. Postponing an in-scope decision still blocks approval; an explicit decision to remove the affected behavior from this delivery may resolve it as a boundary, preserving the original question and attribution. Follow any caller scope-change procedure before treating that boundary as approved.

## Questions for third parties

Keep the functional gap `blocking` unless the stakeholder deliberately chooses `deferred`. Record:

- the responsible role or named source;
- the exact product question and why it matters;
- every decision or deliverable it blocks;
- state, answer, provenance, and answer date.

The question remains visible after resolution as decision history. Relaying an unattributed answer does not resolve it.

## Contradictory sources

A contradiction that can change delivered behavior, scope, or acceptance is `blocking`. Show each conflicting position, identify its source, explain the product impact, and recommend a resolution when evidence supports one. Only an authorized stakeholder decision resolves the contradiction; source recency alone does not. Conflicting details entirely outside an approved boundary remain recorded with that boundary and do not require deciding the excluded behavior.

## New evidence

Read and identify the new evidence before resuming the interview. Report which decisions it confirms, contradicts, invalidates, or reopens. Recompute both the tree and next small round. A formerly resolved decision returns to `blocking` when the evidence makes its product meaning uncertain again.

## Consolidated pending decisions

At closure or material interruption, summarize unresolved decisions and relevant attributed resolutions in the caller's document or conversation. A table may help:

| ID | Estado | Decisão ou pergunta | Pré-requisitos | Responsável/fonte | Bloqueios | Resolução |
|---|---|---|---|---|---|---|

Keep technical choices with implementation. No per-round ledger or separate question history is required.

**Exception check:** every postponement, third-party question, contradiction, and reopened decision remains traceable until an attributable resolution is incorporated.
