export default (options) => ({
    open: options.open,
    optimisticOpen: false,
    opening: false,
    openingToken: 0,
    openingAction: false,
    cancelledOpening: false,
    pendingSaves: 0,
    closeLocked: false,
    destroyed: false,
    get visible() {
        return Boolean(!this.cancelledOpening && (this.open || this.optimisticOpen));
    },
    isActive() {
        return this.visible && Alpine.store('uiSidepageStack').at(-1) === options.id && !(Alpine.store('uiModalStack') || []).length;
    },
    controls() {
        return [...this.panel.querySelectorAll('a[href], button, input, select, textarea, [tabindex]')].filter(
            (element) =>
                !element.matches(':disabled, [aria-disabled=true], input[type=hidden], [tabindex="-1"]') &&
                !element.closest('[hidden], [inert]') &&
                element.getClientRects().length > 0 &&
                getComputedStyle(element).visibility !== 'hidden',
        );
    },
    focusFirstElement() {
        if (!this.isActive() || this.destroyed) return;
        const controls = this.controls();
        (controls.find((element) => element.matches('input, select, textarea')) || controls[0] || this.panel).focus({
            preventScroll: true,
        });
    },
    ensureFocus() {
        if (!this.isActive() || this.opening || this.destroyed) return;
        const current = document.activeElement;
        if (current === this.panel || this.controls().includes(current) || this.panel.contains(current?.closest('[popover]:popover-open')))
            return;
        this.focusFirstElement();
    },
    trapFocus(event) {
        if (!this.isActive() || event.key !== 'Tab' || event.defaultPrevented) return;
        event.preventDefault();
        const controls = this.controls();
        const index = controls.indexOf(document.activeElement);
        const next = event.shiftKey ? (index <= 0 ? controls.length - 1 : index - 1) : (index + 1) % controls.length;
        (controls[next] || this.panel).focus();
    },
    activate() {
        const stack = Alpine.store('uiSidepageStack');
        if (!stack.includes(options.id)) {
            this.lastFocusedElement = this.lastClicked || document.activeElement;
            stack.push(options.id);
        }
        this.$nextTick(() => this.focusFirstElement());
    },
    deactivate(restore = true) {
        const stack = Alpine.store('uiSidepageStack');
        const wasActive = stack.at(-1) === options.id;
        Alpine.store(
            'uiSidepageStack',
            stack.filter((id) => id !== options.id),
        );
        this.$nextTick(() => {
            if (restore && wasActive && !this.visible) this.restoreFocus();
        });
    },
    restoreFocus() {
        if (this.lastFocusedElement?.isConnected && !this.lastFocusedElement.disabled)
            this.lastFocusedElement.focus({ preventScroll: true });
    },
    canClose() {
        return !this.pendingSaves && !this.closeLocked;
    },
    requestClose() {
        if (!this.isActive() || !this.canClose()) return;
        this.cancelledOpening = this.opening;
        this.optimisticOpen = false;
        this.open = false;
    },
    beginOpening() {
        this.cancelledOpening = false;
        this.opening = true;
        this.optimisticOpen = true;
        return ++this.openingToken;
    },
    finishOpening(token, failed = false) {
        if (this.destroyed || token !== this.openingToken) return;
        if (failed || this.cancelledOpening) this.open = false;
        this.optimisticOpen = false;
        this.opening = false;
        this.openingAction = false;
        this.cancelledOpening = false;
        this.$nextTick(() => (this.visible ? this.focusFirstElement() : this.restoreFocus()));
    },
    init() {
        this.panel = this.$refs.panel;
        if (!Alpine.store('uiSidepageStack')) Alpine.store('uiSidepageStack', []);
        this.$watch('visible', (value) => (value ? this.activate() : this.deactivate()));
        this.$watch('open', (value) => {
            if (value && this.cancelledOpening) this.open = false;
            else if (value && !this.opening) this.$nextTick(() => this.ensureFocus());
        });
        if (this.visible) this.activate();
        this.rememberClick = (event) => {
            if (!this.visible) this.lastClicked = event.target.closest('button, a, [role=button]') || event.target;
        };
        document.addEventListener('click', this.rememberClick, true);
        const methods = (options.blockCloseWhileLoading || '').split(',').map((target) => target.trim().split('(')[0]);
        this.stopActions = this.$wire.$interceptAction(({ action, onFinish, onError, onFailure, onCancel }) => {
            const opens = action.name === 'openSidepage';
            const saves = methods.includes(action.name);
            if (!opens && !saves) return;
            const token = opens ? this.beginOpening() : null;
            if (opens) this.openingAction = true;
            if (saves) this.pendingSaves++;
            let settled = false;
            const finish = (failed = false) => {
                if (settled || this.destroyed) return;
                settled = true;
                if (saves) this.pendingSaves--;
                if (opens) this.finishOpening(token, failed);
                this.$nextTick(() => this.ensureFocus());
            };
            onFinish(() => finish());
            onError(() => finish(true));
            onFailure(() => finish(true));
            onCancel(() => finish(true));
        });
        this.stopMessages = this.$wire.$interceptMessage(({ onFinish }) => {
            if (!this.opening || this.openingAction) return;
            const token = this.openingToken;
            onFinish(() => this.finishOpening(token));
        });
        this.observer = new MutationObserver(() => this.$nextTick(() => this.ensureFocus()));
        this.observer.observe(this.panel, {
            subtree: true,
            childList: true,
            attributes: true,
            attributeFilter: ['disabled', 'hidden', 'inert', 'tabindex', 'class', 'style'],
        });
    },
    destroy() {
        this.destroyed = true;
        this.stopActions();
        this.stopMessages();
        this.observer.disconnect();
        document.removeEventListener('click', this.rememberClick, true);
        this.deactivate(false);
    },
});
