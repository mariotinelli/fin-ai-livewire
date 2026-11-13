---
paths:
  - 'app/Services/**/Entities/**'
---

# Entities

## Map API responses through local entity factories
Represent integration response data with local entity classes using promoted typed properties and a static createFromApi(array $data): self factory. Keep response-field translation in that factory.
