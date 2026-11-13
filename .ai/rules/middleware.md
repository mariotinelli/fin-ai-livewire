---
paths:
    - app/Http/Middleware/SignedLogin.php
---

# Middleware

## Require temporary signatures for signed login

Validate the request signature, including expiration, before resolving the target user. Reject missing or soft-deleted users and only then replace the authenticated session.
