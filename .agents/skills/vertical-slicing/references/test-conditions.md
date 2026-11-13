# Test conditions for the complete item

## Prepare with evidence

When estimating QA, apply [estimation and calibration](estimation.md). Group execution sharing data and preparation while preserving every condition and expected result. Distinguish necessary manual testing from available automated evidence; condition count does not determine hours. Keep preparation, retesting and integration checks not covered by DEV explicit.

After inspection, derive what QA should verify and its observable result from the approved requirement. Conditions belong to the whole Feature or Bug: include relevant existing capabilities, cross-slice interactions and required preservation. Out-of-delivery regressions need an impact relationship justified by inspection; explain it.

For a Feature, identify the actor, actions and observable outcome through the actual product channel available at delivery: screens in a UI application, or the real CLI/public API when that is the product. The consumer may already exist or be delivered within this Feature. Calling internal methods, inspecting structures or running mocked/unit tests supports DEV but does not substitute functional QA acceptance. If all necessary interactions belong to future Features, return the boundary gap before approving conditions rather than treating internal verification as a completed QA or inventing a demonstration interface.

For Bugs, represent reproduction, corrected result and related regressions. Use the same coverage analysis on QA-only paths even without DEV slices.

Assess success, alternatives, errors, permissions, boundaries, integrations and preservation according to relevance. This imposes neither grouping nor a minimum count per category. Include data, context and steps when needed to remove ambiguity; grouping serves readability. Separate priority and risk-objective fields are not mandatory.

For approved visual criteria, include comparison conditions identifying source/screen, rendered state, applicable viewport and expected visual outcome, with approved adaptations explicit. Cover shared identity and relevant page/form/error/empty states across slices without duplicating ownership. Functional assertions, overflow checks and failure screenshots do not establish visual fidelity. Conditions may call for human visual comparison; they do not require a particular snapshot library or pixel-perfect threshold unless approved. Unresolved visual expectations return to requirement alignment.

**Complete when:** every approved behavior has verifiable conditions, the Feature's functional result can be checked through its real product channel, relevant existing capabilities and interactions are covered, and every external regression has justified impact.

## Resolve gaps and review meaning

A condition has a stable ID, title, verification, expected outcome and requirement origin; include context when necessary. Preserve IDs while conditions retain the same behavior, including editorial changes. New conditions receive new IDs; removed IDs remain reserved in history. Write user-facing conditions in Portuguese.

Compare conditions, requirement, inspection evidence and slices. A requirement-ID reference proves structural linkage, not correctness of expected outcome or complete scenario coverage. If inspection reveals missing or contradictory behavior, return the gap to the caller to resolve requirements before approving affected conditions.

Use [evaluation scenarios](test-condition-scenarios.json) when reviewing this discipline. They assess semantic decisions rather than product execution.

**Complete when:** no condition invents behavior, each outcome is observable and supported, and joint review with slices leaves no open gaps or contradictions. The caller collects approval, persists the source and generates the document.
