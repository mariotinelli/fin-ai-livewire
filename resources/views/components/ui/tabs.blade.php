@use(Illuminate\Support\HtmlString)
@use(Illuminate\View\ComponentSlot)

@props([
    'border' => false,
    'lift' => false,
    'box' => false,
    'xs' => false,
    'sm' => false,
    'md' => false,
    'lg' => false,
    'xl' => false,
    'top' => false,
    'bottom' => false,
])

<div
    x-data="{
        tabs() {
            return Array.from(this.$el.querySelectorAll('[data-ui-tab]'));
        },
        panels() {
            return Array.from(this.$el.querySelectorAll('[data-ui-tab-panel]'));
        },
        firstActiveTab() {
            const tabs = this.tabs();

            if (tabs.length === 0) {
                return null;
            }

            return tabs.find((tab) => this.isActive(tab)) ?? tabs[0];
        },
        isActive(tab) {
            return tab?.getAttribute('aria-selected') === 'true';
        },
        setActive(tab) {
            if (!tab) {
                return;
            }

            this.tabs().forEach((tabItem) => {
                tabItem.setAttribute('aria-selected', tabItem === tab ? 'true' : 'false');
                tabItem.setAttribute('tabindex', tabItem === tab ? '0' : '-1');
            });

            tab.focus();
            this.syncA11y();
        },
        syncA11y() {
            const activeTab = this.firstActiveTab();

            this.tabs().forEach((tab) => {
                const active = tab === activeTab;

                tab.setAttribute('tabindex', active ? '0' : '-1');
                tab.setAttribute('aria-selected', active ? 'true' : 'false');
            });

            this.panels().forEach((panel) => {
                const tabId = panel.getAttribute('aria-labelledby');
                const tab = tabId ? this.$el.querySelector(`#${tabId}`) : null;
                const active = tab ? this.isActive(tab) : false;

                panel.hidden = !active;
            });
        },
        focusByOffset(currentTab, offset) {
            const tabs = this.tabs();
            const currentIndex = tabs.indexOf(currentTab);

            if (currentIndex < 0 || tabs.length === 0) {
                return;
            }

            const nextIndex = (currentIndex + offset + tabs.length) % tabs.length;

            this.setActive(tabs[nextIndex]);
        },
        onKeydown(event) {
            const tab = event.target.closest('[data-ui-tab]');

            if (!tab) {
                return;
            }

            if (event.key === 'ArrowRight' || event.key === 'ArrowDown') {
                event.preventDefault();
                this.focusByOffset(tab, 1);
                return;
            }

            if (event.key === 'ArrowLeft' || event.key === 'ArrowUp') {
                event.preventDefault();
                this.focusByOffset(tab, -1);
                return;
            }

            if (event.key === 'Home') {
                event.preventDefault();
                this.setActive(this.tabs()[0]);
                return;
            }

            if (event.key === 'End') {
                event.preventDefault();
                this.setActive(this.tabs()[this.tabs().length - 1]);
            }
        },
        init() {
            this.syncA11y();

            this.$el.addEventListener('click', (event) => {
                const tab = event.target.closest('[data-ui-tab]');

                if (!tab) {
                    return;
                }

                this.setActive(tab);
            });
        },
    }"
    @keydown="onKeydown($event)"
>
    <div
        role="tablist"
        aria-orientation="horizontal"
        @class([
            'tabs w-full',
            'tabs-border' => $border,
            'tabs-lift' => $lift,
            'tabs-box' => $box,
            'tabs-top' => $top,
            'tabs-bottom' => $bottom,
            'tabs-xs' => $xs,
            'tabs-sm' => $sm,
            'tabs-md' => $md,
            'tabs-lg' => $lg,
            'tabs-xl' => $xl
        ])
    >
        {{ $tabs ?? '' }}
    </div>

    {{ $panels ?? '' }}
</div>
