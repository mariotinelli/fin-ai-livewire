---
paths:
    - 'app/Actions/**'
---

# Application Actions

Use domain-grouped classes with typed handle() arguments and explicit returns. Name operations with a verb, without the Action suffix. Receive validated, authorized input from Livewire, controllers or Form Requests. Keep input validation and Gate/Policy calls at those entry points, including the full role/permission context. Allowlist persisted fields and preserve business invariants, transactions, locks and effects after commit.

At entry points that accept enum input, use Rule::enum rather than duplicating its values.

## Use final readonly Actions with constructor-injected dependencies

Declare every Action as `final readonly`. Inject collaborating Actions and service classes through typed, private constructor-promoted properties, and use those properties inside `handle()` instead of resolving or constructing dependencies there.
Keep `handle()` parameters for operation data. Data objects, notifications and exceptions may be created from that data; existing Laravel facades and Eloquent APIs remain supported. Keep mutable helpers outside `app/Actions`.

## Reuse cohesive operations with explicit payloads
Before creating an Action, reuse an equivalent operation without coupling it to screens, requests or UI feedback. Do not create an Action per field or database call, or generalize business differences with speculative flags. Preserve handle(), named arguments, typed returns, entry-point validation and authorization, and operation invariants. Example: CreateInvitedUser coordinates CreateUser and SendUserInvitation; do not import Brain's run()/dispatchSync() lifecycle, since Brain is not installed in this base.

## Allowlist writable fields at every payload level
For external arrays, including nested arrays, explicitly select writable keys before normalization and validation; persist only the allowed contract instead of passing complete payloads to create(), update() or fill(). Each nested object needs its own allowlist; unknown keys must never control internal attributes. Preserve authorization for the actor, target and sensitive fields at the entry point. Example: CreateUser maps name/email/type/role_id and receives invitationPending separately; UpdateAddress maps address fields without accepting owner, id or timestamps from the payload.
