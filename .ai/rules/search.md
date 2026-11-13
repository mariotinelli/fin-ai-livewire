---
paths:
  - 'app/Http/Controllers/Search/**'
---

# Search

## Preserve selected relationship options
When a search endpoint receives selected without page, include the selected records again using the id and name contract.

## Use the shared relationship search query contract
Pass an Eloquent builder to BaseSearchController::getOptions() for relationship-option endpoints. Keep its 10-item length-aware pagination and deterministic ordering by the search column, then id.
