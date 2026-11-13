export default function notificationCenter() {
    let observer;
    let changes;
    let timer;
    let destroyed = false;
    const pending = new Set();
    const confirmed = new Set();
    const inFlight = new Set();
    const failed = new Set();
    const observed = new Set();

    return {
        visible: false,
        init() {
            if (typeof IntersectionObserver === 'undefined') return;
            observer = new IntersectionObserver((entries) => {
                if (!this.visible || destroyed) return;
                for (const entry of entries) {
                    const id = entry.target.dataset.notificationId;
                    if (
                        !entry.isIntersecting ||
                        entry.intersectionRatio <= 0 ||
                        !id ||
                        confirmed.has(id) ||
                        inFlight.has(id) ||
                        failed.has(id)
                    )
                        continue;
                    pending.add(id);
                    observer.unobserve(entry.target);
                    observed.delete(entry.target);
                }
                if (pending.size && !timer)
                    timer = setTimeout(() => {
                        timer = null;
                        this.flush();
                    }, 100);
            });
            changes = new MutationObserver(() => this.scan());
            changes.observe(this.$el, { childList: true, subtree: true });
            this.$watch('visible', (visible) => {
                if (visible) {
                    failed.clear();
                    this.scan();
                } else {
                    pending.clear();
                    clearTimeout(timer);
                    timer = null;
                }
            });
            this.scan();
        },
        scan() {
            if (!this.visible || !observer || destroyed) return;
            for (const node of observed) {
                if (!node.isConnected) {
                    observer.unobserve(node);
                    observed.delete(node);
                }
            }
            for (const node of this.$el.querySelectorAll('[data-notification-id]')) {
                const id = node.dataset.notificationId;
                if (
                    node.dataset.notificationViewed === 'true' ||
                    confirmed.has(id) ||
                    inFlight.has(id) ||
                    pending.has(id) ||
                    failed.has(id)
                )
                    continue;
                observer.observe(node);
                observed.add(node);
            }
        },
        async flush() {
            const ids = [...pending].slice(0, 100);
            pending.clear();
            if (!this.visible || destroyed || ids.length === 0) return;
            ids.forEach((id) => inFlight.add(id));
            try {
                const accepted = await this.$wire.markViewed(ids);
                if (destroyed) return;
                ids.forEach((id) => (accepted === true ? confirmed : failed).add(id));
            } catch {
                ids.forEach((id) => failed.add(id));
            }
            ids.forEach((id) => inFlight.delete(id));
            this.scan();
        },
        destroy() {
            destroyed = true;
            clearTimeout(timer);
            observer?.disconnect();
            changes?.disconnect();
        },
    };
}
