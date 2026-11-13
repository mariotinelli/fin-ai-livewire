---
paths:
    - 'tests/Unit/Actions/**'
---

# Actions

## Test Actions directly in the Unit suite

Place direct Action tests under tests/Unit/Actions, mirroring the production path. Verify persistence, transactions, side effects and important failure modes through the Action's public contract. Keep request validation, authorization and HTTP or Livewire integration tests in Feature.
