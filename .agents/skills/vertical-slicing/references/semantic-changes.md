# Semantic-change discipline

Use when an approved requirement supersedes the version supporting approved slicing. Identify the old and new content through document references; compare observable behavior, rules, errors, permissions and boundaries against the approved semantic baseline.

## Classify

Use `editorial` when formatting, spelling or wording changes without altering behavior, rules, boundaries or verifiable results. Record each difference and explain equivalent meaning. Use `functional` when at least one observable behavior, rule, limit, criterion or obligation changes. Byte differences alone do not support `functional`.

Apply the existing classification to visual obligations too: a changed target layout, identity, state appearance or approved field adaptation is `functional` when it changes visual acceptance, even if data operations remain identical. A source-locator correction preserving the same visual target can be `editorial`. Include affected visual criteria, references and QA comparisons in the impact partition; new design evidence does not authorize silently rewriting published tasks.

**Complete when:** each relevant difference has before, after, classification and semantic justification; overall classification is `functional` if and only if a functional difference exists.

## Locate impact

Fully partition published/proposed tasks, acceptance criteria, coverage items and dependencies into affected and still valid. Explain each item's relationship to the change. Preserve valid IDs/evidence; localized change does not imply recreating the whole set. Preserve adopted/external-child decisions, Study results, divergences and QA coverage when present.

When test conditions exist, use the current version, trace requirement origins and classify every ID as affected or still valid. Identify new conditions separately. Resolve new or contradictory behavior in the requirement before approving expected results; structural validation does not decide semantic equivalence.

**Complete when:** every baseline item appears exactly once as affected or unaffected, and the explanation lets the tech lead assess the boundary without internal agent terminology.

## Bind the decision

Present classification and impact together in Portuguese. Approval must identify the exact baseline, new version, classification and impact plan. Changes to any require a new decision. Recorded editorial change preserves slicing validity. Functional change authorizes only preparing new revisions for affected items; general task-update/removal policy belongs to its implementing workflow.

**Complete when:** the attributed decision identifies the baseline, new content and exact impact reviewed, and no mutation uses earlier or broader approval. Consolidate that decision at the review milestone in the owning document; no approval hash or parallel state is required.
