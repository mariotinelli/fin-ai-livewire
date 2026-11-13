import { isAnchorClipped } from './select-dropdown.js';

export default (options) => ({
    open: options.open,
    get triggerElement() {
        return this.$refs.trigger?.querySelector('button, a, [role=button]');
    },
    syncTriggerAria() {
        const trigger = this.triggerElement;
        if (!trigger) return;
        trigger.setAttribute('aria-haspopup', options.dialog ? 'dialog' : 'menu');
        trigger.setAttribute('aria-controls', options.panelId);
        trigger.setAttribute('aria-expanded', String(this.open));
    },
    close(restoreFocus = true) {
        if (!this.open) return;
        this.open = false;
        this.$refs.panel.hidePopover?.();
        this.syncTriggerAria();
        this.$dispatch('ui-dropdown-closed');
        if (restoreFocus) this.triggerElement?.focus({ preventScroll: true });
    },
    toggle(event) {
        event.preventDefault();
        if (this.open) this.close();
        else this.openPanel();
    },
    openPanel(last = false, focus = true) {
        this.open = true;
        this.$nextTick(() => {
            if (!this.open) return;
            this.$refs.panel.showPopover?.();
            this.position();
            if (!this.open || !focus) return;
            const controls = this.controls();
            (controls[last ? controls.length - 1 : 0] || this.$refs.panel).focus({ preventScroll: true });
        });
    },
    controls() {
        const elements = [
            ...this.$refs.panel.querySelectorAll(
                options.dialog ? 'button, a[href], input, select, textarea, [tabindex]' : '[role=menuitem], button, a[href]',
            ),
        ].filter((element) => !element.matches(':disabled, [aria-disabled=true], [tabindex="-1"]') && element.getClientRects().length > 0);
        if (!options.dialog) {
            elements.forEach((element) => {
                if (!element.hasAttribute('role')) element.setAttribute('role', 'menuitem');
            });
        }
        return elements;
    },
    keydown(event) {
        if (event.key === 'Escape' && this.open && !event.defaultPrevented) {
            event.preventDefault();
            event.stopPropagation();
            this.close();
        } else if (event.key === 'Tab' && !options.dialog) {
            this.close();
        } else if (!options.dialog && ['ArrowDown', 'ArrowUp', 'Home', 'End'].includes(event.key)) {
            event.preventDefault();
            const controls = this.controls();
            const index = controls.indexOf(document.activeElement);
            const next =
                event.key === 'Home'
                    ? 0
                    : event.key === 'End'
                      ? controls.length - 1
                      : (index + (event.key === 'ArrowDown' ? 1 : -1) + controls.length) % controls.length;
            controls[next]?.focus();
        }
    },
    position() {
        if (!this.open) return;
        const trigger = this.triggerElement;
        const panel = this.$refs.panel;
        if (!trigger || !panel) return;
        const viewport = window.visualViewport;
        const x = viewport?.offsetLeft ?? 0;
        const y = viewport?.offsetTop ?? 0;
        const width = viewport?.width ?? window.innerWidth;
        const height = viewport?.height ?? window.innerHeight;
        const rect = trigger.getBoundingClientRect();
        if (rect.bottom <= y || rect.top >= y + height || rect.right <= x || rect.left >= x + width || isAnchorClipped(trigger, rect)) {
            this.close(false);
            return;
        }
        const edge = 8;
        const gap = 4;
        const above = Math.max(0, rect.top - y - edge - gap);
        const below = Math.max(0, y + height - rect.bottom - edge - gap);
        const up = options.placement === 'top' ? above >= Math.min(panel.scrollHeight, below) : below < Math.min(panel.scrollHeight, above);
        const sideways = ['left', 'right'].includes(options.placement);
        Object.assign(panel.style, {
            position: 'fixed',
            margin: '0',
            maxWidth: Math.max(0, width - edge * 2) + 'px',
            maxHeight: Math.max(0, sideways ? height - edge * 2 : up ? above : below) + 'px',
        });
        let left = options.end ? rect.right - panel.offsetWidth : rect.left;
        if (sideways) {
            const preferLeft = options.placement === 'left';
            left = preferLeft ? rect.left - panel.offsetWidth - gap : rect.right + gap;
            if (left < x + edge) left = rect.right + gap;
            if (left + panel.offsetWidth > x + width - edge) left = rect.left - panel.offsetWidth - gap;
        }
        const top = sideways ? rect.top : up ? rect.top - panel.offsetHeight - gap : rect.bottom + gap;
        panel.style.left = Math.max(x + edge, Math.min(left, x + width - panel.offsetWidth - edge)) + 'px';
        panel.style.top = Math.max(y + edge, Math.min(top, y + height - panel.offsetHeight - edge)) + 'px';
    },
    init() {
        const trigger = this.triggerElement;
        this.syncTriggerAria();
        this.controls();
        this.$watch('open', () => this.syncTriggerAria());
        this.onTriggerClick = (event) => this.toggle(event);
        this.onTriggerKey = (event) => {
            if (['Enter', ' ', 'ArrowDown', 'ArrowUp'].includes(event.key)) {
                event.preventDefault();
                if (['Enter', ' '].includes(event.key)) this.toggle(event);
                else this.openPanel(event.key === 'ArrowUp');
            }
        };
        trigger?.addEventListener('click', this.onTriggerClick);
        trigger?.addEventListener('keydown', this.onTriggerKey);
        this.reposition = () => this.position();
        window.addEventListener('resize', this.reposition);
        document.addEventListener('scroll', this.reposition, true);
        window.visualViewport?.addEventListener('resize', this.reposition);
        window.visualViewport?.addEventListener('scroll', this.reposition);
        this.observer = typeof ResizeObserver === 'undefined' ? null : new ResizeObserver(() => this.$nextTick(this.reposition));
        if (trigger) this.observer?.observe(trigger);
        this.observer?.observe(this.$refs.panel);
        if (this.open) this.openPanel();
    },
    destroy() {
        this.close(false);
        this.observer?.disconnect();
        this.triggerElement?.removeEventListener('click', this.onTriggerClick);
        this.triggerElement?.removeEventListener('keydown', this.onTriggerKey);
        window.removeEventListener('resize', this.reposition);
        document.removeEventListener('scroll', this.reposition, true);
        window.visualViewport?.removeEventListener('resize', this.reposition);
        window.visualViewport?.removeEventListener('scroll', this.reposition);
    },
});
