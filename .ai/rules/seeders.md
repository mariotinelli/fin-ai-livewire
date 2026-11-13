---
paths:
    - "database/seeders/**"
---

# Seeders

## Seed realistic new listings

When adding a new listing, add a seeder for its main model if none exists. Generate 100 to 300 records so pagination, filtering, search, and sorting can be exercised realistically.

## Persist seed data in batches

Seeders must persist data with batch insert or upsert operations, never per-record create/save calls, including factory dependencies. Preserve casts, sanitization, security invariants, and timestamps when preparing rows; use upsert when the semantics require idempotency.
