# Reusable review criteria

This discipline receives a comparison and identified requirements. Selection, remote access, approval and persistence belong to the calling workflow. Apply the criteria to affected paths, deepen review according to risk, and record what could not be examined. Write all findings and conclusions in Brazilian Portuguese.

## Correctness and integration

Trace inputs, rules and outputs. Examine edge cases, missing data, errors, repeated operations, transactions, rollback and concurrency where applicable. Check affected callers and contracts, including consumers outside modified files. Distinguish defects introduced or worsened by the change from preexisting problems; the latter may be contextual observations without attributing them to this change.

Assess design and complexity against current needs, conventions and documented boundaries. An equally valid technical alternative is not a defect. Check compatibility of APIs, formats and configuration, migrations and operational behavior. For performance, identify the execution path, volume and plausible impact; do not present a slowdown hypothesis as a measurement.

## Standards and maintenance

Use applicable instructions, style guides, architecture and effective project configuration. Identify the violated rule when reporting standards issues. Check naming, clarity, affected public documentation and comments explaining relevant decisions. Personal preferences and polish are optional rather than grounds for rejection.

## Security proportional to risk

At affected trust boundaries, follow data from source to use: validation, per-user/resource authorization, authentication and sessions, tenant isolation, persistence, serialization, files and paths, command execution and integrations. Check secrets and sensitive data in responses, logs and errors without reproducing their values in the report.

Examine existing controls removed or bypassed by the change and abuse scenarios for business rules. Include configuration, dependencies and cryptography when touched or affected. A missing text-search pattern is only a clue: verify actual controls and exploit prerequisites. Use specific security requirements, such as ASVS for web applications, only when applicable and identify the consulted version. Incremental review does not certify the entire system's security.

## Tests and evidence

Assess whether tests would detect incorrect behavior, cover relevant acceptance criteria and exercise integration and failure paths in proportion to risk. Coverage percentages or mocks mirroring implementation do not prove alignment. Distinguish missing tests, failing tests and tests not executed. Missing coverage is a required finding only when grounded in a project rule or an explained concrete risk.

## Finding quality

Each defect includes a direct title, category, minimal useful location, trigger, consequence, evidence and correction guidance without prescribing an arbitrary implementation. Link the relevant requirement or standard. Deduplicate the same cause, using other occurrences as evidence in one finding. For omissions, identify the requirement and expected execution path without inventing a diff line.

Use these Portuguese severity labels in user-facing output:

| Label | Impact criterion |
| --- | --- |
| Crítica | Demonstrable extreme impact, such as broad compromise or irreversible data loss; state prerequisites. |
| Alta | Major functionality or security-control failure without a reasonable workaround for the affected scenario. |
| Média | Relevant error limited to particular scenarios, incompatibility or concrete requirement/standard violation. |
| Baixa | Localized defect with small, verifiable consequences. |

Severity measures impact, not certainty. Insufficiently supported suspicions are questions; improvements without a concrete defect are optional suggestions. Assign neither a defect severity nor a mandatory finding quota to them.

## Conclusions

Use the following Portuguese labels:

- Technical: **ajustes necessários** when a defect is confirmed; **inconclusiva** when material limitations prevent sufficient assessment and no defect is confirmed; otherwise **nenhum problema confirmado no escopo revisado**. Report both confirmed defects and limitations when they coexist.
- Scope: **pendente** when material information prevents assessing full alignment; otherwise **divergente** for incompatible behavior or a functional addition confirmed to be outside approved scope; **parcial** for known missing or incomplete requirements; **aderente** when identified requirements are met without divergence. Proven gaps and divergences remain explicit even with pending questions. Without pending questions, divergence takes precedence over partial delivery when both occur.

These conclusions do not trigger platform approval, merge blocking or merge.

## Basis

Original synthesis of [Google review criteria](https://google.github.io/eng-practices/review/reviewer/looking-for.html), [Google review standard](https://google.github.io/eng-practices/review/reviewer/standard.html) and [OWASP secure review](https://cheatsheetseries.owasp.org/cheatsheets/Secure_Code_Review_Cheat_Sheet.html). The scales and conclusions above are this skill's contract, not policies attributed to those sources.
