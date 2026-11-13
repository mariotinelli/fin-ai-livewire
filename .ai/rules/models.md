---
paths:
  - 'app/Models/**'
---

# Models

## Cast persisted enums on models
Cast every persisted enum attribute to its enum class on the Eloquent model. Keep models focused on persistence, relationships, public local scopes, and casts.

## Type Eloquent relationships
Declare explicit Laravel relationship return types on all Eloquent relationship methods.

## Use project money and datetime casts
Use App\Casts\Money for monetary attributes and App\Casts\Datetime for date or datetime attributes that participate in forms.

## Inherit auditing through the model base
Extend BaseModel for ordinary Eloquent models so they inherit auditing. Preserve framework-specific bases: User applies Auditable directly, while Notification remains on DatabaseNotification without auditing.
