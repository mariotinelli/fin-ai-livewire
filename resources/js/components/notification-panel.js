export default function notificationPanel() {
    let request = 0;
    let destroyed = false;

    return {
        loading: true,
        loadError: false,
        init() {
            this.$watch('$wire.sidepageOpen', (open) => {
                this.loading = true;
                this.loadError = false;
                if (open) {
                    this.load();
                } else {
                    request++;
                }
            });
        },
        async load() {
            const current = ++request;
            this.loading = true;
            this.loadError = false;
            try {
                await this.$wire.loadNotifications();
                await new Promise((resolve) => this.$nextTick(resolve));
            } catch {
                if (!destroyed && current === request) this.loadError = true;
            } finally {
                if (!destroyed && current === request) this.loading = false;
            }
        },
        destroy() {
            destroyed = true;
        },
    };
}
