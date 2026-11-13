---
paths:
    - 'app/Livewire/**'
---

# Livewire

## Keep Livewire components thin

Livewire components validate, authorize, delegate, and translate results to UI state or feedback. Delegate reusable domain mutations to application Actions; keep thin one-off UI-specific behavior local when it has no meaningful reuse.

## Split Livewire CRUD responsibilities

When the operations exist, split a Livewire CRUD into Index, Create, Update, Delete, and Show components. Keep the table and action controls in Index.

## Choose modal or page by form size

Use a modal for a small form. Use a dedicated page when the form is large, has several sections, is multi-step, or needs a stable URL.

## Separate Livewire lifecycle responsibilities

Use mount() for initial loading and access authorization, rules() for validation, and the mutation handler for reauthorization and delegation. Keep render() limited to view construction.

## Namespace and match component events

Name component events as feature::action. The dispatched event name must exactly match its corresponding #[On(...)] listener name.

## Use the established Livewire concern traits

Use WithTable for paginated/filterable/sortable lists, WithModal for modals, WithToast for feedback, WithRepeater for repeaters, WithWizard for multi-step forms, and WithFileUploads for uploads.

## Use separate money and date form state

Never bind x-ui.input.money or x-ui.input.datepicker directly to a model attribute. Use ?string for date state and float|string|null for money state; hydrate it in mount() and copy it into the mutation payload in the handler.

## Allowlist relationship-column sorting

For x-ui.table relationship-column sorting, join the related table, select aliased columns, and map requested sort names through an allowlist to real database columns.

## Validate persisted enums with Rule enum

Validate persisted enum inputs with Rule::enum for the relevant enum class rather than duplicating the allowed values manually.

## Follow the Livewire CRUD event flow

Open Create, Update, and Delete through feature events, confirm deletion in a modal, and dispatch feature::refresh after a successful mutation.

## Call only the multi-step orchestrator

For a dependent multi-step mutation, the Livewire component must call only the transactional orchestrator Action, rather than coordinating individual steps.

## Call explicit Action methods

Inject Actions and services as typed parameters of the Livewire method that uses them, before client-supplied parameters (e.g. `updatePassword(UpdateOwnPassword $updateOwnPassword)`). Let Livewire resolve these dependencies; do not use `app()`, `resolve()`, or `new` for them inside the method.

For dependencies shared across methods, inject them in `boot()` and store them in protected properties so they are initialized on every request; do not use component constructors or public dependency properties. Call the injected Action's `handle()` with named, typed operation arguments and consume its declared return value directly.

## Do not preload relationship select options

Back relationship selects with paginated search endpoints. Do not load the full related collection into a property or Computed value for options.

## Use class-based Livewire components

Use class-based Livewire components in app/Livewire with corresponding Blade views in resources/views/livewire for both full-page and nested components.

## Give stateful modals their own component
A modal owning form state, validation or mutation must be a dedicated class-based Livewire component, including non-CRUD operations. The host dispatches a feature::action event; the modal loads and authorizes its target on opening, reauthorizes the mutation, validates its own state and emits the feature refresh event after success. Example: Users/Create and Users/Update own their forms rather than sharing Users/Index state. Use the shared WithAlert confirmation for simple confirmations without a separate form.

## Keep filter drafts separate from applied queries
Use WithTable's filterDraft for editable filter fields and filters for query criteria. Validate and authorize in applyFilters() before copying the draft; return true only after applying, and reset pagination. resetFilters() resets both states and errors. Lock applied state where the listing already uses #[Locked], and preserve server-side validation before querying. Example: SystemErrorAlerts/Index and ArtisanCommands/History implement this contract; do not restore updatedFilters or query on draft edits.
