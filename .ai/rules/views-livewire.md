---
paths:
  - 'resources/views/livewire/**'
---

# Views Livewire

## Keep data transformation out of Livewire views
Do not use @php for meaningful data transformation or composition. Move it to Livewire or a support class; allow @php only for a trivial local case with no extraction benefit.

## Use class-based Livewire components
Use class-based Livewire components in app/Livewire with corresponding Blade views in resources/views/livewire for both full-page and nested components.
