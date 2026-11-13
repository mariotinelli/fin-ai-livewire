---
paths:
  - 'app/Support/**'
---

# Support

## Keep Support focused on cross-cutting technical concerns
Use Support for contracts, data and cross-cutting technical primitives, such as QueueNames, NotificationCount and the existing navigation and email delivery components. These helpers may maintain technical state; do not turn Support into a catch-all for business operations. Reusable application operations belong in Actions; external integrations belong in Services. Reuse existing typed contracts where applicable without requiring a DTO, Data class or helper migration for every payload.
