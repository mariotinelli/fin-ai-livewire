---
paths:
    - 'app/Queries/**'
---

# Queries

## Use explicit final readonly Query Objects

Name Query Objects with the Query suffix and declare them final readonly. Inject collaborating Queries, Actions and services through typed constructor-promoted private properties; pass query criteria as explicit method arguments, not Request or Livewire objects.
Use get() for completed results and paginate() for paginated results, with declared return types and collection or array-shape PHPDoc. Expose a Builder only when a real caller needs composition. Reads may use external APIs and caches, but must not perform business mutations.

## Keep criteria explicit without speculative abstractions
Extract Query Objects when complexity or reuse justifies them; do not create a Query per lookup, a generic repository or a base class without a consumer. Preserve typed criteria, explicit returns and visibility constraints where applicable, without accepting a Request or Livewire component as criteria. Example: UsersWithPermissionsQuery accepts permissions and returns users; SystemErrorAlertsQuery accepts pagination and sorting filters. Keep simple reads in Eloquent/scopes and operation authorization at the entry point.
