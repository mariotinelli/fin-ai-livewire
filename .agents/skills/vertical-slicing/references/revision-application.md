# Revision-application discipline

Use only for the current specifically approved functional semantic review and its exact localized impact, identified in the owning document. A new revision, rejection, baseline change or expanded impact ends previous authority; do not create approval hashes or operational state.

## Choose the representation

Classify every remote task by native status observed at planning time: not started, in progress, completed or canceled. New work becomes a new child under current title, description, coverage, QA, adoption and dependency contracts. In-progress tasks may receive only localized changes after a concrete preview and additional tech lead approval tied to task, current snapshot and mutation. Completed tasks stay outside the delta; corrections or additions become new children linked to the revision. Merging or replacement cancels only tasks proven not started and records reason and replacements in the native transition journal.

**Complete when:** every approved impact has a representation, completed tasks are outside mutations, and each cancellation has proof of non-start, reason and replacements.

## Reconcile before acting

Compare task payload and status again immediately before each mutation. Changes since preview invalidate intent or approval: locate the new state, rebuild the delta and present a new preview. Classify/transition statuses using exact native catalog IDs and names; missing, ambiguous or divergent metadata stops application.

Model creation, update, cancellation, relation addition and removal with intent persisted before the call, result afterward and readback for uncertain outcomes. A reconciled operation is not sent to the remote tool again.

**Complete when:** every operation began with a proven current snapshot and every uncertain attempt was observed as present or absent before retry.

## Prove preservation

In final readback, verify expected payloads/statuses, cancellation reasons/replacements, affected DEV→QA blockers, absence only of approved removed edges and exact presence of unaffected relations. Also verify completed, unaffected, adopted and external children, Study/divergence/semantic-review evidence, and parent execution status.

**Complete when:** the whole delta is proven, everything outside it remains identical and the parent retains its pre-application status.
