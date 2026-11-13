---
paths:
    - 'app/**'
---

# App

## Reuse explicit application Actions

Put reusable mutations in app/Actions, grouped by domain. Use verb names without an Action suffix, typed handle() arguments and explicit return types. Call them through the container with named arguments. Keep one-off behavior with its owner.

Use a transactional orchestrator Action for dependent mutations and native Laravel Jobs for queued work. Keep secrets out of serialized results and logging; mark password parameters with SensitiveParameter.

## Prefer supported PHP attributes

When Laravel or an installed package supports a PHP attribute for static class configuration, use the attribute instead of the equivalent class property. Confirm the exact attribute and arguments in version-specific documentation.

## Use the DB facade for transaction control

Use DB::transaction, DB::transactionLevel and DB::afterCommit in application code instead of obtaining connections through model getConnection() calls. Preserve atomicity and rollback; cache invalidation and persistence-dependent notifications must run after commit. For a specific connection, use DB::connection(name) and keep operations and callbacks on that connection.

## Prefer match for same-value branching

Prefer a match expression when several if/elseif branches compare the same value and select one result or behavior. Keep if statements for unrelated conditions, short-circuit logic, ranges, or stateful branching.

## Separate operations, query objects and simple Eloquent reads

Use Actions for application operations and Query Objects for complex or reusable reads. Keep simple, local reads in Eloquent or model scopes; do not create a Query class for every lookup or introduce a generic repository or query base class.
Keep request validation and operation authorization at entry points. Queries must apply any viewer, tenant or visibility constraints that determine which records may be returned.

## Reuse the shared literal insensitive search scopes

For partial user-facing text searches, reuse whereInsensitive/orWhereInsensitive from HasInsensitiveSearch instead of duplicating raw unaccent/ILIKE SQL in each consumer. Group OR search branches inside a where closure so existing authorization, visibility and filter constraints still apply. Treat %, _ and ! as literal search text and preserve the string "0" as a valid term. The scope quotes/qualifies identifiers, binds values and keeps COLLATE default for partial matching; this does not change citext uniqueness or apply app_ai_ci globally. Examples: User::search, SystemErrorAlertsQuery and ArtisanCommands/History.
