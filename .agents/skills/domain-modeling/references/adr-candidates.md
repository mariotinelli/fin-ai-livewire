# ADR candidate triage

An ADR preserves rationale for a consequential architecture choice. Qualification requires the intersection of three tests, not a score or a general sense of importance.

## Test the decision

A choice is a real candidate only when all three answers are supported by concrete evidence:

1. **Difficult to reverse:** changing course later would require a material migration, compatibility break, coordinated rollout, data conversion, contractual change, or comparable cost.
2. **Surprising:** a capable contributor could not reliably infer the choice and its rationale from normal project conventions, code, or configuration.
3. **Real alternative:** at least one viable alternative exists, and the trade-off explains why reasonable people could choose differently.

A choice fails the gate when it is merely a business rule for one requirement, a temporary experiment, an ordinary implementation detail, an obvious convention, or a readily reversible preference. High effort alone does not make a decision architectural.

**Complete when:** evidence answers every test, viable alternatives and trade-offs are named, and any failed test ends ADR candidacy.

## Keep Project Flow at the requirements boundary

During Project Flow, classify the result without selecting the architecture or creating an ADR. Behavior, business rules, scope, acceptance, and decisions unique to the item remain in the canonical requirement even when they are important or long-lived.

For a qualifying technical choice, signal technical leadership with:

- the decision that will eventually need to be made;
- evidence for difficult reversal and surprise;
- the viable alternatives and central trade-off;
- affected contexts or system boundaries;
- a pointer to the requirement that exposed it.

Use candidate language. Do not present an option as chosen unless technical leadership has made that decision through its own process. A rejected candidate needs only a short note in the current work when that prevents repeated triage; it does not need an ADR.

**Complete when:** the requirement contains only requirement-owned decisions, every qualifying candidate has a concise leadership signal, and no ADR or architecture decision was created by Project Flow.
