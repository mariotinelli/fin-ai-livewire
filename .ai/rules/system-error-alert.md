---
paths:
    - "app/Actions/SystemErrorAlert/**"
---

# System Error Alert

## Atomic alert grouping and reopening

A fingerprint/environment pair identifies a unique group in the database. Every recurrence increments the count atomically, preserves the occurrence time bounds, and reopens Resolved alerts as Open, even when the event arrives late; Acknowledged and last_notified_at remain unchanged. Consolidation preserves complete row snapshots and audit IDs in consolidated_history, reassigns audits to the lowest alert ID, and prioritizes unresolved statuses. Pause alert writers during consolidation to prevent new duplicate groups before the unique index exists. PostgreSQL supports transactional DDL through Laravel's migration transaction; verify the actual connection and withinTransaction setting rather than relying on MySQL transaction assumptions. The existing down() restores the non-unique index and drops uniqueness only: it preserves consolidated_history, the widened counter and merged data, and does not recreate deleted rows or reverse audit reassignment. Full data restoration requires a separate approved recovery plan.
