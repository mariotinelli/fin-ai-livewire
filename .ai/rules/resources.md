---
paths:
  - 'app/Http/Resources/**'
---

# Resources

## Reuse domain API resources
Return reusable JsonResource or ResourceCollection objects for successful API responses. Reuse a domain Resource instead of creating an endpoint-specific Resource.

## Expose stable public identifiers
When API clients must reference a returned resource, prefer a stable public key such as slug or UUID. Expose an internal ID only for low-risk data, an internal integration, or a documented technical requirement.
