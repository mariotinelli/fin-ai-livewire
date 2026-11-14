export function sidebarLayout() {
    return {
        desktopOpen: true,
        desktop: window.innerWidth >= 1025,
        mobile: window.innerWidth < 768,
        focusedElement: null,
        get asideOpen() {
            return this.desktop && this.desktopOpen;
        },
        init() {
            try {
                this.desktopOpen = localStorage.getItem('asideOpen') !== 'false';
            } catch {
                // Keep navigation available when storage is unavailable.
            }
        },
        resize() {
            const changed = this.mobile !== window.innerWidth < 768 || this.desktop !== window.innerWidth >= 1025;
            const active = globalThis.document?.activeElement;
            const focused = active === globalThis.document?.body ? this.focusedElement : active;
            this.desktop = window.innerWidth >= 1025;
            this.mobile = window.innerWidth < 768;
            if (changed) {
                this.$dispatch('navigation-mode-changed');
                this.restoreNavigationFocus(focused);
            }
        },
        restoreNavigationFocus(focused) {
            if (!focused?.closest('#desktop-sidebar-panel, #mobile-navigation, #mobile-home-link')) return;
            this.$nextTick(() => {
                if (focused.getClientRects().length && !focused.closest('[data-ui-dropdown-panel]')) return;
                const navigation = document.querySelector(this.mobile ? '#mobile-navigation' : '#desktop-sidebar-panel');
                const links = [...(navigation?.querySelectorAll('a[href]') ?? [])];
                const destination = links.find((link) => link.href === focused.href && link.getClientRects().length);
                const fallback = document.getElementById(this.mobile ? 'mobile-home-link' : 'home-link');
                (destination ?? fallback)?.focus({ preventScroll: true });
            });
        },
        toggleSidebar() {
            const focused = globalThis.document?.activeElement;
            this.desktopOpen = !this.desktopOpen;
            this.restoreNavigationFocus(focused);
            try {
                localStorage.setItem('asideOpen', String(this.desktopOpen));
            } catch {
                // The current session can still toggle the sidebar.
            }
        },
    };
}

function read(key) {
    try {
        return sessionStorage.getItem(key);
    } catch {
        return null;
    }
}

function write(key, value) {
    try {
        sessionStorage.setItem(key, String(value));
    } catch {
        // Navigation remains usable when browser storage is unavailable.
    }
}

export function sidebarGroup(key, open = true) {
    return {
        expanded: open,
        init() {
            const saved = read(key);
            if (saved !== null) this.expanded = saved === 'true';
            if (this.$el.querySelector('[aria-current="page"]')) this.expanded = true;
        },
        toggle() {
            this.expanded = !this.expanded;
            write(key, this.expanded);
            this.$dispatch('sidebar-group-changed', { key, expanded: this.expanded });
        },
        sync(detail) {
            if (detail.key === key) this.expanded = detail.expanded;
        },
    };
}

export function sidebarContext(key) {
    return {
        init() {
            this.$watch('mobile', () => this.restore());
            this.$watch('asideOpen', () => this.restore());
            this.restore();
        },
        save() {
            if (this.$el.clientHeight > 0) write(key, this.$el.scrollTop);
        },
        restore() {
            this.$nextTick(() => {
                if (this.$el.clientHeight === 0) return;
                const saved = Number(read(key));
                this.$el.scrollTop = Number.isFinite(saved) && saved >= 0 ? saved : 0;
                const active = this.$el.querySelector('[aria-current="page"]');
                if (!active) return;
                const container = this.$el.getBoundingClientRect();
                const item = active.getBoundingClientRect();
                if (item.top < container.top) this.$el.scrollTop += item.top - container.top;
                else if (item.bottom > container.bottom) this.$el.scrollTop += item.bottom - container.bottom;
            });
        },
    };
}
