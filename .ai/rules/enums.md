---
paths:
  - 'app/Enums/**'
---

# Enums

## Model closed value sets as plural enums
Use a dedicated enum for a closed domain or UI value, and prefer a plural enum class name for an option set. Persist it as an integer-backed enum unless the domain requires another stable representation.

## Return badge color identifiers from enums
For status or domain enums, return only the reusable color identifier from a dedicated method such as color(), not CSS classes.
