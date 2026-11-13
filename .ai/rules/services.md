---
paths:
  - 'app/Services/**'
---

# Services

## Services are infrastructure boundaries
Use Service classes only for external integrations or infrastructure concerns such as SDK and API calls. Do not place ordinary domain mutations or orchestration in Services.

## Preserve existing adapters and contracts without extra layers
New Services encapsulate integrations and infrastructure, such as ViaCepService and ParameterStore; coordinate reusable operations in Actions and keep one-off behavior with its owner. Do not introduce a Service or interface merely to forward a call. Preserve the fluent API of the existing Services/Notifications/DatabaseNotification builder, a payload presentation exception already used by this base; do not move public contracts merely to standardize directories.
