---
paths:
    - 'app/Http/Controllers/**'
---

# Controllers

## Keep controllers thin and delegate reusable mutations

Controllers validate, authorize, delegate, and translate results to HTTP responses. Delegate reusable domain mutations to application Actions; keep thin one-off HTTP-specific behavior local when it has no meaningful reuse.

## Return reusable resources from APIs

Return reusable JsonResource or ResourceCollection objects for successful API responses. Reuse the domain Resource rather than defining endpoint-specific response shapes.

## Call only the multi-step orchestrator

For a dependent multi-step mutation, the controller must call only the transactional orchestrator Action, rather than coordinating individual steps.

## Call explicit Action methods

Resolve the Action through the container and call handle() with named, typed arguments. Consume its declared return value directly.

## Use invokable single-action controllers

Implement every single-action controller with one public __invoke() method instead of a named action method.
