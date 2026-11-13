---
paths:
  - 'resources/views/**'
---

# Views

## Follow the internal x-ui component contract
Use the remsoft-ui-components conventions whenever creating or editing x-ui.* elements. Reuse existing component APIs and sibling screen patterns.

## Keep table actions on the far right
Place table action columns and controls at the far right by default.

## Use the standard modal presentation
Use divided on x-ui.modal by default. Use a right-aligned modal footer with the established gray background and spacing classes found in sibling modals.

## Do not bind money or date inputs to models
Never bind x-ui.input.money or x-ui.input.datepicker directly to a model attribute. Bind them to the component's separate money or date state property.

## Verify internal component contracts
Treat the local component implementation as the source of truth. Use only declared props, prefer direct flags for boolean props, and omit name or id when wire:model already supplies them.

## Import PHP classes with Blade use
Import PHP classes with @use at the top of Blade files. Avoid inline fully qualified class names in Blade expressions.

## Use Alpine for conditional presentation
Prefer Alpine directives for interaction-driven conditional presentation when viable. Keep critical validation on the backend.

## Use reusable x-ui badge colors
Add unsupported badge colors as generic reusable x-ui.badge options, then render statuses with x-ui.badge and :color instead of inline status classes.

## Pass enum options directly
Pass enum options directly to x-ui selects with options() or toArray(); do not add a Livewire property that only forwards the same options.

## Use searchable selects for relationships
Use x-ui.input.select-search or multi-select-search for relationship fields. Do not use plain select components for relational data unless the user explicitly requests and documents an exception.

## Validate component and HTML attributes
Before using an attribute on x-ui.*, x-icons.*, or an HTML element, verify it on the target implementation or official documentation. Do not infer attribute names by similarity.

## Block invalid relationship select delivery
Do not conclude with a relational field using a plain select or preloaded option collection. Fix it first unless the user explicitly approves and documents an exception.

## Use the shared filter panel and isolated button feedback
Enable draft-filters on x-ui.table and bind filter controls to filterDraft without .live or .blur; keep the built-in Limpar/Filtrar footer and discard unapplied edits on close. Use x-ui.button and group-actions.action for feedback on the initiating control only; never target a cancel spinner at save or add a parallel Alpine spinner. Icon buttons preserve dimensions; text-only buttons grow only while showing the spinner. The source catalog documents current props, slots and loading behavior.

## Preserve shared overlay accessibility
Use existing modal, sidepage, dropdown and alert-modal contracts instead of rebuilding focus, keyboard or loading behavior. Provide stable IDs and accessible names, especially for icon-only controls; preserve focus containment/restoration, Escape behavior and pending-action close guards. Disabled presentation never replaces server authorization. Example: group-actions.action owns its accessible disabled state; alert-modal awaits confirmation before closing, while sidepage blocks dismissal during configured save actions.
