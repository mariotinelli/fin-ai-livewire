---
paths:
    - 'tests/Unit/Queries/**'
---

# Unit Queries

## Test queries at their owning boundary

Give each behavior-bearing Query its own mirrored Unit test file. Cover returned records, filter combinations, ordering, pagination and relevant visibility restrictions against an isolated database. Keep endpoint authorization and UI integration tests with the Feature caller; do not duplicate the full query test matrix there.
