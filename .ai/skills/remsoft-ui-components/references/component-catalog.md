# x-ui Component Catalog

The local Blade components and their PHP/JavaScript implementations are the source of truth. Prop names below use camelCase; pass them as kebab-case Blade attributes. Slots are named explicitly. This catalog does not require optional components from other products.

- [Layout and navigation](#layout-and-navigation)
- [Typography and display](#typography-and-display)
- [Feedback and overlays](#feedback-and-overlays)
- [Actions and navigation widgets](#actions-and-navigation-widgets)
- [Table system](#table-system)
- [Form shell](#form-shell)
- [Input system](#input-system)
- [Modal system](#modal-system)
- [Repeater and wizard](#repeater-and-wizard)
- [Domain components](#domain-components-optional)
- [Quick usage patterns](#quick-usage-patterns)

### Layout and Navigation

#### `x-ui.page`

- Props: `title`, `breadcrumb`, `description=null`, `headerActions=null`, `widgets=null`, `contentClass=null`
- Slots: default, `headerActions`, `widgets`

#### `x-ui.page.header`

- Props: `title`, `description`, `actions=null`

#### `x-ui.page.widgets`

- No declared props

#### `x-ui.breadcrumb`

- Props: `items=[]`
- `items` accepts a string or an array with `label` and optional `route` (URL).

#### `x-ui.navbar`

- No declared props

#### `x-ui.main`

- No declared props

#### `x-ui.sidepage`

- Props: `id=null`, `scrollable=true`, `clickAway=true`, `blockCloseWhileLoading='save'`, `openOnEvent=null`, `loading=null`, `header=null`, `title='Painel lateral'`, `footer=null`, `description=null`, `sm|md|lg|xl|xl2|xl3|xl4|xl5|xl6|xl7=false`.
- Slots: default, `header`, `footer`, `loading`. The loading slot replaces the default opening placeholder.
- Control: uses `@entangle('sidepageOpen').live` and `WithSidepage`. `openSidepage` opens optimistically; `open-on-event` enables the same presentation for a named window event.
- `block-close-while-loading` accepts the save method(s); pending saves block close, Escape and outside clicks. Opening can be canceled without a late response reopening the panel.
- External close lock: dispatch `ui-sidepage-close-lock` with `{ id: panelId, locked: true|false }`.
- Accessibility: named dialog, focus containment and restoration, `aria-busy` during opening/saving. Uses the public scoped Livewire interceptors supported by the installed version.

#### `x-ui.sidebar.group`

- Props: `name`, `open=true`

#### `x-ui.sidebar.link`

- Props: `route`, `name`, `icon`, `permission=null`, `prefix=null`

#### `x-ui.sidebar.links`

- Declared props: `route`, `name`, `icon`, `permission` (slot wrapper)

### Typography and Display

#### `x-ui.title`

- Props: `lg=false`, `md=false`, `sm=false`

#### `x-ui.card`

- Props: `header=null`, `description=null`, `divided=null`, `headerAction=null`, `footer=null`, `wizard=false`
- Slots: default, `header`, `headerAction`, `footer`
- Usage pattern: include `divided` on all cards (except when there is visual justification).

#### `x-ui.badge`

- Content props: `label=null`, `icon=null`, `rightIcon=false`
- Size props: `xs|sm|md|lg`
- Color props: `primary|secondary|accent|neutral|info|success|warning|error` or `color='...'`
- Style props: `outline`, `ghost`, `circle`
- Dot: `addDot`, `animateDot`

#### `x-ui.quote`

- Props: `title=null`, colors `neutral|primary|secondary|accent|success|warning|info|error|white`, `color=null`

#### `x-ui.details.card`

- Props: `title`, `value`

#### `x-ui.copy`

- Props: `text`, `label=null`, `copyLabel=null`, `successMessage='Copiado com sucesso!'`, `errorMessage='Não foi possível copiar'`, `successToast=false`, `alwaysShowIcon=true`.
- Slots: default display content, `prefix`, `icon`. The copied value is always `text`, independently of the displayed label or slot.
- Accessible name: `copy-label`, then `aria-label`, then a label-derived or generic fallback. The native button stops click propagation to parent handlers and never submits a form.
- Successful copying swaps the icon and shows local feedback; `success-toast` additionally emits a success toast. Failure shows local feedback and emits an error toast. Status text uses a polite live region, and temporary feedback is cleared after one second.
- Uses the Clipboard API when available in a secure context; otherwise uses the existing textarea fallback, removes it and restores button focus. A rejected Clipboard API promise reports failure rather than claiming success.

#### `x-ui.application-logo`

- Props: `purpleHorizontal=false`, `greenHorizontal=false`

### Feedback and Overlays

#### `x-ui.alert`

- Props: `title`, `icon=null`, `success|warning|info|error=false`, `color=null`, `soft=false`, `outline=false`, `dash=false`

#### `x-ui.alert-modal`

- Props: `color=null`, `icon=null` (defaults for incoming alerts).
- Listens to the window `alert` event. Prefer `WithAlert::alert()` or `confirmAlert()` to include the owning `componentId`.
- Event payload: `title`, `description`, `type`, `method`, `params`, `componentId`, `actionConfirm`, `textConfirm`, `textCancel`, `actionCancel`, `color`, `icon`, `descriptionHighlight`.
- Colors: `primary|secondary|accent|neutral|success|warning|info|error`. Icons: `check-circle|exclamation-triangle|information-circle|x-circle|question-mark-circle`.
- Confirmation callbacks are awaited: any result other than `false` closes the alert; `false` or rejection keeps it available for retry. Confirm, cancel, close and Escape are blocked while pending.
- Titles, descriptions, highlights and labels are plain text. Confirmation defaults to error styling; focus is trapped and restored. This shared confirmation does not replace a stateful form modal.

#### `x-ui.toast`

- No declared props
- Consumes session toasts and the `toast` event.
- Timed notifications expose a progressbar named `Tempo restante da notificação`, with values from 0 to 100. Persistent notifications hide this countdown. Preserve the close button's accessible name and text escaping.

#### `x-ui.loading`

- No declared props

#### `x-ui.loading.dot`

- Props: `activeDot=0`

#### `x-ui.tooltip`

- Props: `label=null`, `open=false`, position `top|bottom|left|right|position`, color `primary|secondary|accent|info|success|warning|error`

### Actions and Navigation Widgets

#### `x-ui.button`

- Label and icon: `label`, `icon`, `rightIcon=false`
- Colors: `neutral|primary|secondary|accent|success|warning|info|error|white`
- Styles: `ghost|link|active|outline|soft|hover|noAnimation`
- Size: `xs|sm|md|lg`
- Shape/layout: `wide|block|circle|square|uppercase`
- State: `loading=null`, `withLoading=true`
- Behavior: `href=false`, `navigate=true`, `inputAction=false`, `cancelButton=false`
- Content: default slot or `label`; pass `aria-label` for an icon-only action. `loading` specifies an action target, not a boolean state; a `wire:click` expression supplies the default target.
- Loading comes from `resources/js/components/button-loading.js` and belongs to the initiating control, including local actions, form submitters and navigation. Never activate a cancel button's spinner for a save action.
- With icon and text, the spinner replaces the icon; icon-only controls and pagination keep their dimensions. Text-only buttons insert the spinner before the unchanged text and grow only while loading. Navigation settles on `livewire:navigated`.
- `:with-loading="false"` omits the spinner; shared activation/disabled feedback still applies. Do not add a second Alpine spinner or component-wide `wire:loading` indicator.

#### `x-ui.dropdown`

- Props: `id=null`, `trigger`, `header=null`, `description=null`, `footer=null`, `end|top|bottom|left|right=false`, `hover=false`, `open=false`, `controlled=false`, `sm|md|lg=false`, `width='w-52'`.
- Slots: default, `trigger`, `header`, `description`, `footer`.
- A plain dropdown uses menu semantics; `controlled`, a description or a footer selects dialog semantics. Keyboard navigation, Escape, focus return and viewport-constrained scrolling are shared behavior; do not duplicate them in consumers.

#### `x-ui.group-actions`

- Props: `id=null`, `label=null`, `button=false`, `size='sm'`, `icon='ellipsis-horizontal'`, `ariaLabel='Ações'`, `width='w-64'`, `end=true`, `top=false`, `bottom=true`, `left=false`, `right=false`.
- Default slot contains `x-ui.group-actions.action` items. `button` displays a labeled trigger; otherwise the trigger is an icon button. Supported trigger sizes are `xs|sm|md|lg`.
- Reuses `x-ui.dropdown`; the trigger omits a spinner while menu actions retain their own feedback.

#### `x-ui.group-actions.action`

- Props: `label=null`, `icon=null`, `href=false`, `navigate=true`, `disabled=false`, `withLoading=true`.
- Label comes from `label` or the default slot. Pass `wire:click` with its complete argument expression, or `href` for navigation.
- Disabled items render native disabled buttons without a destination or executable handlers, with `aria-disabled=true` and `tabindex=-1`. Server-side authorization remains required.

#### `x-ui.dropdown.link`

- Props: `route`, `name`, `icon`

#### `x-ui.tabs`

- Props: `border|lift|box`, sizes `xs|sm|md|lg|xl`, position `top|bottom`

#### `x-ui.tabs.link`

- Props: `name`, `active=false`, `key='lists_tab'`, `icon=null`

### Table System

#### `x-ui.table`

- Props: `records`, `search=true`, `pagination=true`, `header=null`, `body=null`, `filtersHeader=null`, `filtersDropdown=null`, `tableHeader=null`, `searchInput=null`, `toggleOnlyTrashed=false`, `draftFilters=false`, `activeFilterCount=null`
- Slots: `filtersHeader`, `filtersDropdown`, `searchInput`, `tableHeader`, `header`, `body`
- Common Livewire dependencies: `search`, `perPage`, `perPageValues`, `filters`, `sortBy()`, `resetFilters()`.
- With `draft-filters`, bind filter fields to `filterDraft` without `.live` or `.blur`. Queries read the applied `filters`, not the draft. Closing without applying restores the applied state locally.
- `applyFilters(): bool` must validate and authorize before copying the draft; return `true` to close the filter panel. `resetFilters()` resets both states and pagination. The trait supplies defaults, while each listing owns its rules and authorization.
- The component provides the `Limpar` and `Filtrar` controls; do not duplicate that footer. Search remains independently live/debounced.

#### `x-ui.table.th`

- Props: `name=null`, `upperCase=true`, `colspan=null`, `textAlign='left'`, `inline=true`, `withSort=true`

#### `x-ui.table.tr`

- Props: `textAlign='left'`

#### `x-ui.table.td`

- No declared props

#### `components.ui.pagination` (internal)

- No declared `@props`
- May expect pagination context variables (e.g., `recordCount`, `perPageValues`) depending on the local implementation.
- Table and card pagination keep distinct presentations. Their controls use `data-ui-pagination` so loading replaces the number/arrow without changing dimensions.

### Form Shell

#### `x-ui.form`

- Props: `footer=null`, `cancelRoute=null`

### Input System

#### `x-ui.input`

- Structural props: `id=null`, `name=null`, `label=null`, `placeholder=null`, `parentClass=null`
- Size: `xs|sm|md|lg`
- UX: `showError=true`, `helperText=null`, `hint=null`, `prefix=null`, `suffix=null`, `disabled=false`
- Other: `icon=false`, `loading=false`

#### `x-ui.input.label`

- Props: `id`, `name=null`, `label`, `required=false`

#### `x-ui.input.error`

- Props: `message`

#### `x-ui.input.password`

- No declared props
- `x-ui.input` wrapper with show/hide password toggle.

#### `x-ui.input.textarea`

- Props: `id=null`, `label=null`, `placeholder=null`, `xs|sm|md|lg`, `showError=true`, `maxLength=500`, `hint=null`, `helperText=null`, `parentClass=null`

#### `x-ui.input.checkbox`

- Props: `id=null`, `name=null`, `label=null`, sizes `xs|sm|md|lg`, colors `primary|success|warning|error|info`, `showError=true`, `helperText=null`, `inline=true`, `rightLabel=true`

#### `x-ui.input.radio`

- Props: `id=null`, `label=null`, sizes `xs|sm|md|lg`, colors `primary|success|warning|error|info`, `showError=true`, `helperText=null`, `inline=true`, `rightLabel=true`

#### `x-ui.input.toggle`

- Props: `id=null`, `label=null`, colors `primary|success|info|warning|error`, `labelRight=false`, `inline=false`, `helperText=null`

#### `x-ui.input.money`

- Props: `locale='pt-BR'`, `prefix=false`
- Accepts `wire:model`, `wire:model.live[.Xms]`, `wire:model.blur`.
- Implemented locales: `pt-BR` and `en-US`.

#### `x-ui.input.datepicker`

- Props in the `App\View\Components\Ui\Input\Datepicker` class:
    - `range=false`, `multiple=false`, `showMonths=1`, `time24hr=true`
    - `minDate=null`, `maxDate=null`, `minTime=null`, `maxTime=null`
    - `date=false`, `time=false`, `datetime=false`, `allowInput=true`
- Automatic formats:
    - `date` -> `d/m/Y`
    - `time` -> `H:i`
    - `datetime` -> `d/m/Y H:i`

#### `x-ui.input.select`

- Props: `disableWhileLoading=false`, `name`, `initialValue=null`, `id=null`, `label=null`, `options=[]`, `labeless=false`, `showError=true`, `defaultOptionLabel='Selecione uma opção'`, `helperText=null`, `hint=null`, `prefix=null`, `suffix=null`, `clearable=true`, `parentClass=null`, `emptyLabel=null`
- Selects preserve deferred `wire:model` synchronization; `.live` enables immediate Livewire updates. Option-search HTTP requests are separate from model synchronization. `disable-while-loading` is an explicit opt-in, not the default for unrelated requests.

#### `x-ui.input.select-search`

- Props: `disableWhileLoading=false`, `name`, `route`, `withInfinityScroll=true`, `loadOnOpen=false`, `initialValue=null`, `withSearch=true`, `id=null`, `label=null`, `wire=null`, `labeless=false`, `showError=true`, `defaultOptionLabel='Selecione uma opção'`, `helperText=null`, `hint=null`, `prefix=null`, `suffix=null`, `selectedColumn='id'`, `params=[]`, `parentClass=null`
- Dependent `params` map query keys to Livewire property paths, for example `:params="['region' => 'context.region']"`, rather than supplying the current region value. The component observes those properties and synchronizes the request context.
- Context changes clear stale selection/options and cancel or ignore obsolete responses. Failed requests expose retry separately from an empty result; pagination is scoped to the current context and component lifetime.

#### `x-ui.input.multi-select`

- Props: `disableWhileLoading=false`, `name`, `initialValue=[]`, `id=null`, `label=null`, `options=[]`, `labeless=false`, `showError=true`, `defaultOptionLabel='Selecione uma ou mais opções'`, `helperText=null`, `hint=null`, `prefix=null`, `suffix=null`, `clearable=true`

#### `x-ui.input.multi-select-search`

- Props: `disableWhileLoading=false`, `name`, `route`, `withInfinityScroll=true`, `loadOnOpen=false`, `initialValue=[]`, `withSearch=true`, `id=null`, `label=null`, `wire=null`, `labeless=false`, `defaultOptionLabel='Selecione uma ou mais opções'`, `showError=true`, `helperText=null`, `hint=null`, `prefix=null`, `suffix=null`, `selectedColumn='id'`, `params=[]`, `parentClass=null`
- Uses the same dependent-property `params` mapping, deferred/live binding, context isolation and retry contract as `select-search`; context changes clear the selection list instead of retaining IDs from the previous parent.

#### `x-ui.input.autocomplete`

- Props: `name`, `route`, `withInfinityScroll=true`, `id=null`, `label=null`, `wire=null`, `labeless=false`, `showError=true`, `helperText=null`, `hint=null`, `prefix=null`, `suffix=null`, `params=[]`

#### `x-ui.input.upload`

- Props: `label=null`, `id=null`, `name=null`, `description=null`, `accept=null`, `maxSize=10`

#### `x-ui.input.multiple-upload`

- Props: `label=null`, `id=null`, `name=null`, `description=null`, `accept=null`, `maxSize=10`, `maxFiles=10`, `oldFiles=[]`

#### Upload internals

- `x-ui.input.upload.card`: `prefix`, `oldFile=false`, `disabled=false`
- `x-ui.input.upload.details`: `loading=true`
- `x-ui.input.upload.remove-button`: `prefix`, `oldFile=false`
- `x-ui.input.upload.alert-error`: `model`
- `x-ui.input.upload.previews.image|pdf|video`: `prefix`

### Modal System

#### `x-ui.modal`

- Props: `id`, `title=''`, `description=''`, `footer=''`, `lg|xl|xl2|xl3=false`, `clickAway=true`, `divided=false`, `headerAlign='left'`, `scrollable=false`, `closeButton=true`, `escapable=true`, `manual=false`.
- Slots: default and `footer`. Uses `@entangle('modalOpen')` when hosted by Livewire and not `manual`; `WithModal` supplies open/close state and clears validation on opening.
- Window events `open-modal` and `close-modal` accept the modal ID as the event detail. `manual` starts closed and uses these events without entangling Livewire state. Closing emits `modal-closed` with `{ modal: id }`.
- Provides dialog semantics, stacked focus containment, focus restoration, Escape and optional outside-click dismissal. Headers/footers stay outside the default scrollable body; `scrollable` changes the content layout.
- A modal owning form state, validation or mutation belongs to a dedicated class-based Livewire component. Reauthorize both opening and mutation; a hidden or disabled button is not authorization. Pure local presentation can use `manual`; shared confirmations use `x-ui.alert-modal`.

### Repeater and Wizard

#### `x-ui.repeater`

- Props: `header=null`, `title=null`, `subtitle=null`, `addButtonText=null`, `addButton=null`, `model=null`, `openAll=true`, `wizard=false`
- Expects Livewire methods: `addItem`, `duplicateItem`, `removeItem`.

#### `x-ui.repeater.item`

- Props: `index`, `itemHeader`, `open=true`, `copyable=true`, `removable=true`
- `@aware`: `model`

#### `x-ui.repeater.item-header`

- Props: `headerActions=null`, `copyable=true`, `removable=true`
- `@aware`: `model`, `index`

#### `x-ui.wizard`

- Props: `header`, `content`, `steps`, `submit='save'`
- Expects Livewire state: `currentStep`, `firstStep`, `lastStep` and methods `prevStep`, `nextStep`.

#### `x-ui.wizard.steps.content`

- Props: `id`, `active=false`

### Domain Components (optional)

#### `x-ui.roles.permissions.group`

- Props: `header`, `description`

#### `x-ui.roles.permissions.group.header`

- Props: `group`, `groupKey`

#### `x-ui.roles.permissions.group.content`

- Props: `group`

#### `x-ui.auth-session-status`

- Props: `status`

Only components present in this base are listed. Do not assume components from ERP business domains exist here.

## Quick Usage Patterns

### Button with icon on the right

```blade
<x-ui.button primary icon="check" right-icon> Salvar </x-ui.button>
```

### Select with enum directly in Blade

```blade
@use ('App\Enums\TypeUsers')

<x-ui.input.select :options="TypeUsers::toArray()" wire:model="filterDraft.type" label="Tipo de usuário" />
```

Use this enum example in a listing that defines and validates `filterDraft.type`; relationship fields use searchable selects instead.

### Modal with the project's default footer

```blade
<x-ui.modal id="user-modal" divided title="Editar usuário">
    <div class="py-2">...</div>

    <x-slot name="footer">
        <div class="flex w-full items-center justify-end gap-2 bg-base-200 p-3">
            <x-ui.button neutral sm wire:click="closeModal">Fechar</x-ui.button>
            <x-ui.button primary sm wire:click="save">Salvar</x-ui.button>
        </div>
    </x-slot>
</x-ui.modal>
```

The owning component uses `WithModal` and defines authorized `save()` behavior. Keep this component separate from the listing that opens it.

### Grouped row action

```blade
<x-ui.group-actions aria-label="Ações do usuário">
    <x-ui.group-actions.action label="Editar" icon="pencil-square" wire:click="$dispatch('users::update', { userId: {{ $user->id }} })" />
</x-ui.group-actions>
```

The receiving users Update component owns loading the record, validation and mutation. It reauthorizes the actor and target before saving; authorization must not depend on whether the menu item was rendered.

### Table with actions in the last column

```blade
<x-slot name="header">
    <x-ui.table.th name="name">Nome</x-ui.table.th>
    <x-ui.table.th></x-ui.table.th>
</x-slot>
```
