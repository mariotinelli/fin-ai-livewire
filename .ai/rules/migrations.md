---
paths:
  - 'database/migrations/**'
---

# Migrations

## Use project storage types for money and enums
Store monetary amounts as integer cents in PostgreSQL bigint columns, not floating-point or PostgreSQL money values. Store integer-backed enum values in an integer type sized for their actual values, usually smallint. Existing unsignedBigInteger/unsignedTinyInteger Blueprint calls compile to signed bigint/smallint on PostgreSQL; they do not enforce non-negative values, a 0..255 range or enum membership. Preserve domain validation and model enum casts; add explicit CHECK constraints only when the domain requires a database guarantee, after checking existing rows. Do not assume MySQL unsigned ranges or rewrite published migrations to retrofit constraints.

## Keep schema rollouts backward compatible
Use a two-step rollout when old and new application versions or workers must coexist, or a rename, removal, backfill or stricter constraint would break current readers/writers. First add compatible schema, deploy compatible code and backfill existing data without removing the old contract. After verifying the backfill and retiring old consumers, enforce the new constraint or remove the old schema in a later release. Account for PostgreSQL locks and large-table work; transactional DDL does not make a migration lock-free. Treat conversion of an existing MySQL installation as a separate approved migration project, not a normal application migration.

## Separate schema rollback from irreversible data changes
Provide a faithful down() for reversible schema changes. A rollback does not recover deleted, deduplicated or transformed data unless that recovery is explicitly implemented; document one-way data transformations or guarded rollbacks and retain required history instead of inventing it. Example: alert consolidation rolls back index uniqueness while retaining consolidated_history and the widened counter; it does not recreate merged alerts or their former audit links. Define backup/recovery and code compatibility before a destructive rollout.

## Preserve the distinct PostgreSQL text comparison contracts
Target the adopted PostgreSQL 16 baseline with provisioned citext/unaccent extensions and ICU support; do not infer compatibility from a run on a newer major. The initial users migration owns app_ai_ci (ICU, und-u-ks-level1, deterministic=false); reuse it only where accent- and case-insensitive equality/ordering is required, as for users.name. Preserve citext uniqueness for users.email and roles/permissions.name; it does not promise accent-insensitive uniqueness. PostgreSQL 16 pattern matching cannot use nondeterministic collation directly: reuse HasInsensitiveSearch's unaccent/ILIKE with a deterministic comparison rather than applying app_ai_ci globally. Catalog inspection must match the server major: PostgreSQL 16 exposes pg_collation.colliculocale, while 17+ uses colllocale. Check collisions and ICU compatibility before changing existing comparisons; do not create feature-specific collation copies or shadow columns.
