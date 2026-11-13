---
paths:
  - 'app/Policies/**'
---

# Policies

## Centralize reusable actor and model authorization
Keep reusable decisions about the actor, target model, state and sensitive fields in Policies; use standalone Gates for permissions without a model target. Entry points validate and authorize the operation and its references before calling the Action; reuse must not remove these checks or internal invariants. Example: UserPolicy::create/update considers the assigned Role, and user components reauthorize with that Role before persistence.
