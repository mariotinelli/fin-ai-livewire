export default (options) => ({
    alerts: [],
    queuedAlerts: [],
    nextKey: 0,
    lastFocusedElement: null,
    lastTrigger: null,
    colors: options.colors,
    init() {
        this.rootElement = this.$root;
        if (!Alpine.store('uiModalStack')) Alpine.store('uiModalStack', []);
        this.rememberFocus = (event) => {
            if (!this.alerts.length && event.target !== document.body) this.lastTrigger = event.target;
        };
        this.rememberClick = (event) => {
            if (!this.alerts.length) this.lastClicked = event.target.closest('button, a, [role=button]');
        };
        document.addEventListener('focusin', this.rememberFocus);
        document.addEventListener('click', this.rememberClick, true);
    },
    destroy() {
        document.removeEventListener('focusin', this.rememberFocus);
        document.removeEventListener('click', this.rememberClick, true);
        for (const alert of this.alerts) this.removeStackEntry(alert.key);
    },
    removeStackEntry(key) {
        Alpine.store(
            'uiModalStack',
            Alpine.store('uiModalStack').filter((id) => id !== `alert-${key}`),
        );
    },
    getFocusableElements(container) {
        return [...container.querySelectorAll('a[href], button, input, select, textarea, [tabindex]')].filter(
            (element) => !element.matches(':disabled, [aria-disabled=true], [tabindex="-1"]') && element.getClientRects().length > 0,
        );
    },
    focusFirstAction(key, retry = false) {
        const dialog = this.rootElement.querySelector(`#info-modal-${key}`);
        if (!dialog) return;
        const controls = this.getFocusableElements(dialog);
        const confirm = dialog.querySelector('[data-alert-confirm]');
        (retry && controls.includes(confirm) ? confirm : controls[0] || dialog).focus({ preventScroll: true });
    },
    trapFocus(event, key) {
        const dialog = this.rootElement.querySelector(`#info-modal-${key}`);
        if (!dialog) return;
        const controls = this.getFocusableElements(dialog);
        if (!controls.length) {
            event.preventDefault();
            dialog.focus();
        } else if (event.shiftKey && document.activeElement === controls[0]) {
            event.preventDefault();
            controls.at(-1).focus();
        } else if (!event.shiftKey && document.activeElement === controls.at(-1)) {
            event.preventDefault();
            controls[0].focus();
        }
    },
    descriptionParts(alert) {
        const text = alert.description || '';
        const highlight = alert.descriptionHighlight;
        const index = highlight ? text.indexOf(highlight) : -1;
        if (index < 0) return [{ text, bold: false }];
        return [
            { text: text.slice(0, index), bold: false },
            { text: highlight, bold: true },
            { text: text.slice(index + highlight.length), bold: false },
        ];
    },
    add(payload) {
        if (this.alerts.length) {
            this.queuedAlerts.push({ ...payload });
            return;
        }
        const confirmation = payload.type === 'confirmation';
        const requestedColor = payload.color || options.defaultColor;
        const fallbackColor = confirmation ? 'error' : 'secondary';
        const color = Object.hasOwn(this.colors, requestedColor) ? requestedColor : fallbackColor;
        const fallbackIcon =
            confirmation && !requestedColor
                ? null
                : { success: 'check-circle', error: 'x-circle', info: 'information-circle' }[color] || 'exclamation-triangle';
        const requestedIcon = payload.icon || options.defaultIcon || fallbackIcon;
        const alert = {
            ...payload,
            key: ++this.nextKey,
            is_confirmation: confirmation,
            pending: false,
            running: null,
            error: '',
            color,
            icon: options.icons.includes(requestedIcon) ? requestedIcon : fallbackIcon,
        };
        this.lastFocusedElement ||=
            this.lastClicked || (document.activeElement !== document.body ? document.activeElement : this.lastTrigger);
        this.lastClicked = null;
        this.alerts.push(alert);
        Alpine.store('uiModalStack').push(`alert-${alert.key}`);
        this.$nextTick(() => this.focusFirstAction(alert.key));
    },
    remove(key, completed = false) {
        const alert = this.alerts.find((item) => item.key === key);
        if (!alert || (alert.pending && !completed)) return;
        this.alerts = this.alerts.filter((item) => item.key !== key);
        this.removeStackEntry(key);
        if (this.queuedAlerts.length) {
            this.add(this.queuedAlerts.shift());
        } else {
            const trigger = this.lastFocusedElement;
            this.lastFocusedElement = null;
            this.$nextTick(() => {
                if (trigger?.isConnected) trigger.focus({ preventScroll: true });
            });
        }
    },
    async run(alert, callback, action) {
        if (alert.pending || !this.alerts.includes(alert)) return false;
        alert.pending = true;
        alert.running = action;
        alert.error = '';
        let result;
        try {
            result = await callback();
            if (result !== false) this.remove(alert.key, true);
        } catch {
            alert.error = 'Não foi possível concluir a ação. Tente novamente.';
            result = false;
        }
        alert.pending = false;
        alert.running = null;
        this.$nextTick(() => this.focusFirstAction(alert.key, true));

        return result;
    },
    invoke(alert, method) {
        return Livewire.find(alert.componentId).call(method, alert.params);
    },
    confirm(alert) {
        return this.run(
            alert,
            () => {
                if (typeof alert.onConfirm === 'function') return alert.onConfirm();
                if (alert.actionConfirm && alert.method) return this.invoke(alert, alert.method);
                if (alert.actionCancel) return this.invoke(alert, alert.actionCancel);
            },
            'confirm',
        );
    },
    cancel(alert) {
        return this.run(
            alert,
            () => {
                if (typeof alert.onCancel === 'function') return alert.onCancel();
                if (!alert.actionConfirm && alert.method) return this.invoke(alert, alert.method);
                if (alert.actionCancel) return this.invoke(alert, alert.actionCancel);
            },
            'cancel',
        );
    },
    dismiss(alert) {
        return this.run(
            alert,
            () => {
                if (typeof alert.onCancel === 'function') return alert.onCancel();
                if (alert.actionConfirm && alert.actionCancel) return this.invoke(alert, alert.actionCancel);
            },
            'cancel',
        );
    },
});
