---
name: remsoft-ui-components
description: "Technical reference for internal Blade x-ui.* components. Use when creating or editing screens, forms, tables, modals, navigation, inputs, visual feedback, component props, slots, bindings, or visual variants."
---

# Remsoft UI Components

Use this skill for the exact API of internal `x-ui.*` components. Follow the matching project rules for standing UI conventions.

## Component reference

Read [`references/component-catalog.md`](references/component-catalog.md) when choosing or verifying component props, slots, bindings, variants, events, or usage examples. Load it only when the task needs exact component details.

## Validation workflow

1. Confirm that every prop, slot, `x-ui.*` attribute, `x-icons.*` attribute, and HTML attribute exists on its target.
2. Confirm that `wire:model`, `name`, and `id` follow the component contract.
3. Confirm that the selected color, size, style, and visual variant exist.
4. Confirm that optional domain components exist in the current project before using them.
5. Inspect the local Blade file or component class whenever the catalog and implementation differ.

## Delivery check

Before concluding a UI change, review every changed relational field against the applicable project rules. Do not deliver a violation; if the user explicitly approved an exception, report its file and justification in the final response.
