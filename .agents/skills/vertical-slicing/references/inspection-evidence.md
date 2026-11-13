# Inspection evidence

## Verify technical claims

For every claim supporting a slice or its omission, record observed behavior and a verifiable source: file/symbol or line, effective configuration, test or execution result. Check defaults in the installed version and project overrides. Record value, unit and applicability; distinguish cookie duration, session validity and renewal when these affect requirements.

Separate reading findings from executed checks. A discovered test supports only its exercised scenario; state whether it ran. If effective configuration or a relevant path cannot be confirmed, record uncertainty and impact without reading or persisting credentials. Resolve technical facts by inspection; product decisions remain with the tech lead.

**Complete when:** every classification claim has a checked source and unknown values or conditions are explicit rather than presented as confirmed behavior.

## Classify complete behavior

Compare evidence against all requirement conditions: actors, permissions, access paths, transitions, timing and devices where applicable. An isolated mechanism such as soft deletion, logout or a menu filter requires tracing its consumers before concluding about complete behavior.

Use `existing` only when evidence fully supports the approved outcome. Reading the complete path may suffice; run a targeted check when the conclusion depends on uncertain runtime behavior. For partial implementation, record what works and what remains, classify inspection as `adapt` and assign the requirement to the slice delivering the difference. Missing tests alone do not mean missing implementation. Inconclusive evidence remains uncertain; if it prevents complete slicing, route to the caller's Study branch.

**Complete when:** every `existing` classification supports all relevant conditions, every adaptation identifies its delivery gap, and no uncertainty becomes confirmed coverage.
