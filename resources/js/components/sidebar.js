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
            this.$watch('mobileAsideOpen', () => this.restore());
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
