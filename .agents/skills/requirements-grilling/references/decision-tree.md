# Functional boundary and decision tree

Use this reference before selecting the first round and whenever classification is uncertain.

## Classify the uncertainty

A **functional gap** needs a product decision that can change delivered behavior, a business rule, scope, or verifiable acceptance. It belongs in the tree. For each candidate question, identify what changes depending on the answer; if nothing material changes, it does not need an interview question.

An **explicit exclusion** describes behavior outside this delivery according to an attributed stakeholder decision or an already approved boundary. Record the boundary and its source; leave excluded details undefined. A proposed exclusion still needs a product decision when it changes scope. Do not reclassify an unanswered in-scope question as excluded to finish early. If a previously blocking question is settled by excluding behavior, retain its history and resolve it with the attributed boundary decision, without inventing how the excluded behavior works.

A **technical choice** selects a mechanism without changing visible behavior or scope. Repository structure, persistence, caching, retry algorithms, files, infrastructure, and similar mechanisms belong to later implementation roles. Inspect the environment for facts that constrain the product discussion, but keep the mechanism out of the requirement and interview.

If an uncertainty mixes the two, remove the proposed mechanism and expose the product effect. Portuguese question example: replace “Isso deve usar uma fila?” with “O usuário pode aguardar a conclusão ou o resultado precisa chegar depois?”.

Preserve a non-functional requirement only when the evidence states it extremely explicitly. Do not proactively elicit performance, security, accessibility, or availability targets, and do not turn a vague mention into a gap.

A supplied design explicitly establishes visual intent for the identified delivery. Reconcile material differences in fields, states, actions and navigation with stakeholder answers, preserving the reference's appearance except for approved adaptations. “Visual only” separates visual intent from prototype business logic; it does not exclude visual acceptance. Ask about conflicting user-visible outcomes, leaving CSS, component selection and other implementation choices to the implementation role.

## States

- `blocking`: a material functional decision within the delivery is unanswered. Descendants cannot advance, while unrelated branches may continue in small rounds.
- `deferred`: the decision was deliberately postponed. Other independent questions for the same item may continue, but approval, publication, the next item, and downstream workflows remain closed.
- `resolved`: the decision and its material ambiguity have an attributable answer incorporated into the shared understanding.

Only these states describe functional gaps. An explicit exclusion is a scope boundary, not an open gap or a fourth gap state. A technical choice belongs to implementation rather than the product decision ledger.

## Grow the tree

Start from the observable goal, then expand only branches relevant to the item. Test for gaps in:

- actors, permissions, and success;
- user-perceived inputs and results;
- main, empty, initial, and final states;
- alternatives, cancellation, repetition, and recovery from functional errors;
- validations, messages, business rules, calculations, dates, and time zones;
- user-visible concurrency, integrations, notifications, and audit history;
- user-visible compatibility or migration;
- acceptance conditions and boundaries inside or outside the item.

This is a coverage lens, not a questionnaire. A branch exists only when evidence, an answer, or the nature of the item makes it relevant. Reuse settled answers and inspect repository facts before proposing a question. For a small demand, examine only relevant branches. For extensive sources, retain coverage of relevant behaviors and contradictions across rounds; small rounds do not justify silently dropping source material.

## Compute a round

For unresolved material decisions, identify unsettled prerequisites. From currently answerable decisions, prioritize impact on behavior, scope, acceptance, and the decisions each answer unblocks. Select a small round, usually one to three questions. A candidate whose need or wording could change based on another answer waits for that answer. Keep unasked material decisions visible for later rounds.

After the answers, update dependencies before discovering more detail. A changed parent can resolve, replace, or reopen an entire descendant branch.

**Round check:** each question is material and answerable now, facts and prior answers have been reused, and the remaining material decisions are retained without requiring their simultaneous presentation.
