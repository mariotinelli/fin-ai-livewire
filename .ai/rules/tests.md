---
paths:
    - 'tests/**'
---

# Tests

## Test critical behavior at the owning boundary

Test behavior relevant to authorization, security, data integrity, business rules, user-visible outcomes, and integrations. Avoid framework wiring, implementation details, and duplicate responsibility across layers.

## Classify tests by the boundary under test

Use tests/Unit for tests focused on an individual application class, including Actions and Queries, even when they boot Laravel or use factories and an isolated database. Use tests/Feature for behavior exercised through application entry points such as HTTP requests, Livewire interactions and Artisan commands; do not create browser tests.
Choose the suite by the behavior exercised, not by database usage. Mirror the production class path within the owning suite and preserve meaningful coverage when moving tests.

## Keep only critical regression coverage

Preserve authorization, isolation, validation, data integrity, transactions, financial calculations, queues, notifications, uploads and integrations. Avoid tests that repeat declarations, framework behavior, tooling configuration or styling. There is no browser suite or mandatory coverage percentage. Always run PHP tests with `--tia`; use `--tia --fresh` to rebuild the map and report replayed results accurately. Keep reusable TALL traits; use their existing test consumers as PHPStan analysis contexts.

## Exclude database scaffolding and runner infrastructure test subjects
Do not create dedicated tests for migrations, seeders, factories, application/runner bootstrap or infrastructure setup. Keep tests/bootstrap.php, TestCase and Pest configuration needed to run behavioral tests, including isolation and fake guards. Using factories, seeders or application bootstrapping as setup does not make an authorization, persistence, queue, notification or integration behavior test an excluded scaffold test. Leave the protected testing-structure source unchanged; these explicit category exclusions govern test selection.
