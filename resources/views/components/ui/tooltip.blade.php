@props([
    'label' => null,
    'open' => false,
    'top' => false,
    'bottom' => false,
    'left' => false,
    'right' => false,
    'primary' => false,
    'secondary' => false,
    'accent' => false,
    'info' => false,
    'success' => false,
    'warning' => false,
    'error' => false,
    'position' => null,
    'rich' => false,
])

<div
    {{ $attributes->except('class') }}
    x-id="['tooltip']"
    data-tooltip-label="{{ $label }}"
    @if ($rich) data-tooltip-rich @endif
    x-data="{
        tooltipLabel: {{ Js::from($label) }},
        isOpen: {{ $open ? 'true' : 'false' }},
        openDelayTimer: null,
        closeDelayTimer: null,
        useSelfAsTrigger: false,
        describedTarget: null,
        observer: null,
        setDescription(element, add) {
            if (!element) return;
            const id = this.$id('tooltip');
            const ids = (element.getAttribute('aria-describedby') || '').split(/\s+/).filter(value => value && value !== id);
            if (add) ids.push(id);
            const description = ids.length ? ids.join(' ') : null;
            if (element.getAttribute('aria-describedby') === description) return;
            if (description) element.setAttribute('aria-describedby', description);
            else element.removeAttribute('aria-describedby');
        },
        initA11y() {
            const focusableChild = this.$el.querySelector('a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex=\'-1\'])');

            const target = focusableChild || this.$el;
            if (this.describedTarget !== target) this.setDescription(this.describedTarget, false);
            this.describedTarget = target;
            this.setDescription(target, !this.$el.closest('[data-table-tooltips]'));
            if (!focusableChild && !this.$el.hasAttribute('tabindex')) {
                this.$el.setAttribute('tabindex', '0');
                this.useSelfAsTrigger = true;
            } else if (focusableChild && this.useSelfAsTrigger) {
                this.$el.removeAttribute('tabindex');
                this.useSelfAsTrigger = false;
            }
        },
        openWithDelay() {
            clearTimeout(this.openDelayTimer);
            if (this.closeDelayTimer) {
                clearTimeout(this.closeDelayTimer);
            }

            this.openDelayTimer = setTimeout(() => {
                this.isOpen = true;
            }, 150);
        },
        closeTooltip() {
            clearTimeout(this.closeDelayTimer);
            if (this.openDelayTimer) {
                clearTimeout(this.openDelayTimer);
            }

            this.closeDelayTimer = setTimeout(() => {
                this.isOpen = false;
            }, 50);
        },
        onEscape() {
            clearTimeout(this.openDelayTimer);
            clearTimeout(this.closeDelayTimer);
            this.isOpen = false;
        },
        init() {
            this.$nextTick(() => {
                this.initA11y();
                if (this.$el.contains(document.activeElement)) this.openWithDelay();
            });
            this.observer = new MutationObserver(() => {
                this.tooltipLabel = this.$el.getAttribute('data-tooltip-label');
                this.initA11y();
            });
            this.observer.observe(this.$el, { attributes: true, attributeFilter: ['data-tooltip-label', 'disabled', 'aria-describedby'], subtree: true, childList: true });
        },
        destroy() {
            this.observer.disconnect();
            clearTimeout(this.openDelayTimer);
            clearTimeout(this.closeDelayTimer);
            this.setDescription(this.describedTarget, false);
        }
    }"
    @mouseenter="openWithDelay()"
    @mouseleave="closeTooltip()"
    @focusin="openWithDelay()"
    @focusout="closeTooltip()"
    @keydown.escape="onEscape()"
    @keydown.escape.window="onEscape()"
    @class([
        'tooltip cursor-pointer',
        $attributes->get('class', ''),
        'tooltip-top' => $top || $position === 'top',
        'tooltip-bottom' => $bottom || $position === 'bottom',
        'tooltip-left' => $left || $position === 'left',
        'tooltip-right' => $right || $position === 'right',
        'tooltip-primary' => $primary,
        'tooltip-secondary' => $secondary,
        'tooltip-accent' => $accent,
        'tooltip-info' => $info,
        'tooltip-success' => $success,
        'tooltip-warning' => $warning,
        'tooltip-error' => $error
    ])
    x-bind:class="{ 'tooltip-open': isOpen }"
    x-bind:data-tip="isOpen ? tooltipLabel : ''"
>
    <span x-bind:id="$id('tooltip')" role="tooltip" class="sr-only" x-text="tooltipLabel">{{ $label }}</span>
    {{ $slot }}
</div>
