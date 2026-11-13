# Canonical glossary

Use this branch to resolve and apply shared domain language. The glossary records stable, reusable distinctions; it is not a summary of a feature, bug, interview, or implementation.

## Resolve the term

Gather how the concept is named in relevant requirements, existing domain documents, user-facing behavior, and code. Prefer an already approved canonical term. Treat code identifiers as evidence rather than automatic business truth.

When sources disagree, distinguish a harmless alias from a difference in meaning. Ask the user to decide when the distinction affects product language, behavior, scope, or acceptance. Preserve the resolution and its source in the current work before editing the glossary.

**Complete when:** the preferred term has one clear meaning, important aliases or terms to avoid are known, and any consequential conflict has an explicit user resolution.

## Apply the lazy-write gate

Create or update glossary content only when all of these are true:

1. The term's meaning is resolved rather than tentative.
2. The term is useful beyond one requirement or immediate task.
3. Recording it prevents a meaningful ambiguity, synonym drift, or boundary mistake.

If any condition fails, use the best-supported wording in the current artifact and leave domain documentation unchanged. The absence of `CONTEXT.md` does not itself justify creating one.

**Complete when:** each proposed glossary edit passes all three conditions, and rejected proposals cause no domain-documentation write.

## Write the smallest durable entry

Follow the repository's established domain-document format and context boundaries. In a mapped repository, edit the context that owns the concept; use the system-level location only for genuinely cross-context language. When no domain structure exists and the first qualifying term appears, create the smallest `CONTEXT.md` appropriate to the repository's demonstrated context; ask the user when ownership or context boundaries are a product decision.

Record only what future readers need to use the term consistently:

- canonical term and concise definition;
- significant aliases or explicitly avoided terms, when they exist;
- boundary or contrast needed to distinguish it from a nearby concept;
- provenance when the repository's format calls for it.

Preserve unrelated entries and organization. Keep workflows, acceptance criteria, technical design, and item history in their owning artifacts.

**Complete when:** every changed entry is concise, reusable, placed in the owning context, consistent with current usage, and free of requirement duplication.

## Verify downstream language

Review the artifact that triggered this branch plus any directly affected names, examples, or tests. Replace accidental synonyms where they refer to the canonical concept; retain deliberate aliases only where their distinction is explained.

**Complete when:** each affected concept is named consistently and no glossary change silently alters approved behavior or scope.
