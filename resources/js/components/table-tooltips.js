let nextTooltipId = 0;

export default () => ({
    init() {
        const root = this.$el;
        const overlay = document.createElement('div');
        overlay.id = `table-tooltip-${++nextTooltipId}`;
        overlay.className = 'table-tooltip-overlay';
        overlay.setAttribute('role', 'tooltip');
        overlay.setAttribute('popover', 'manual');
        document.body.append(overlay);
        root.setAttribute('data-table-tooltips-ready', '');

        const autoNames = new Map();
        const nameButtons = () => {
            for (const [button, label] of autoNames) {
                if (!root.contains(button)) {
                    if (button.getAttribute('aria-label') === label) button.removeAttribute('aria-label');
                    autoNames.delete(button);
                } else if (button.getAttribute('aria-label') !== label) autoNames.delete(button);
            }
            root.querySelectorAll('button.tooltip[data-tip], a.tooltip[data-tip]').forEach((button) => {
                if (button.hasAttribute('aria-labelledby') || (button.hasAttribute('aria-label') && !autoNames.has(button))) return;
                const content = button.cloneNode(true);
                content.querySelectorAll('*').forEach((node) => {
                    if (node.hasAttribute('wire:loading') || node.getAttribute('aria-hidden') === 'true') node.remove();
                });
                if (!content.textContent.trim() && button.dataset.tip) {
                    if (button.getAttribute('aria-label') !== button.dataset.tip) button.setAttribute('aria-label', button.dataset.tip);
                    autoNames.set(button, button.dataset.tip);
                } else if (autoNames.has(button)) {
                    button.removeAttribute('aria-label');
                    autoNames.delete(button);
                }
            });
        };
        const cells = new Set();
        const restoreCell = (cell) => {
            cell.removeAttribute('data-table-cell-truncated');
            if (cell.hasAttribute('data-table-cell-text-focusable')) {
                if (cell.getAttribute('tabindex') === '0') cell.removeAttribute('tabindex');
                cell.removeAttribute('data-table-cell-text-focusable');
            }
        };
        const resizeObserver = typeof ResizeObserver === 'undefined' ? null : new ResizeObserver(() => refresh());
        const syncCells = () => {
            for (const cell of cells) {
                if (!root.contains(cell)) {
                    restoreCell(cell);
                    resizeObserver?.unobserve(cell);
                    cells.delete(cell);
                }
            }
            root.querySelectorAll('[data-table-cell-text]').forEach((cell) => {
                if (!cells.has(cell)) {
                    cells.add(cell);
                    resizeObserver?.observe(cell);
                }
                const overflows = (element) =>
                    !element.closest('.sr-only, [aria-hidden=true]') &&
                    element.clientWidth > 0 &&
                    element.clientHeight > 0 &&
                    (element.scrollWidth > element.clientWidth + 1 || element.scrollHeight > element.clientHeight + 1);
                const truncated =
                    Boolean(cell.getAttribute('data-tip')) && (overflows(cell) || [...cell.querySelectorAll('*')].some(overflows));
                if (!truncated) {
                    restoreCell(cell);
                    return;
                }
                cell.setAttribute('data-table-cell-truncated', '');
                const child = cell.querySelector(
                    'button:not([disabled]), a[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])',
                );
                if (!child && !cell.hasAttribute('tabindex')) {
                    cell.setAttribute('tabindex', '0');
                    cell.setAttribute('data-table-cell-text-focusable', '');
                } else if (child && cell.hasAttribute('data-table-cell-text-focusable')) {
                    if (cell.getAttribute('tabindex') === '0') cell.removeAttribute('tabindex');
                    cell.removeAttribute('data-table-cell-text-focusable');
                }
            });
        };
        const refresh = () => {
            nameButtons();
            syncCells();
            if (!initialized || (focused && (!focused.isConnected || !root.contains(focused)))) {
                focused = triggerFor(document.activeElement);
                initialized = true;
            }
            select();
        };
        const observer = new MutationObserver(refresh);
        observer.observe(root, {
            childList: true,
            subtree: true,
            characterData: true,
            attributes: true,
            attributeFilter: [
                'data-tip',
                'data-tooltip-rich',
                'data-tooltip-title',
                'data-tooltip-description',
                'data-tooltip-eyebrow',
                'class',
                'style',
                'disabled',
            ],
        });
        resizeObserver?.observe(root);
        window.addEventListener('resize', refresh);

        let initialized = false;
        let hovered = null;
        let focused = null;
        let active = null;
        let frame = null;
        let described = null;

        const triggerFor = (target) => {
            const trigger =
                target instanceof Element
                    ? target.closest('[data-table-cell-text][data-table-cell-truncated]') || target.closest('.tooltip[data-tip]')
                    : null;
            return trigger?.closest('[data-table-tooltips]') === root ? trigger : null;
        };

        const clearDescription = () => {
            if (described) {
                const ids = (described.getAttribute('aria-describedby') || '').split(/\s+/).filter((id) => id && id !== overlay.id);
                if (ids.length) described.setAttribute('aria-describedby', ids.join(' '));
                else described.removeAttribute('aria-describedby');
                described = null;
            }
        };

        const hide = () => {
            if (overlay.matches(':popover-open')) overlay.hidePopover();
            clearDescription();
        };
        const renderContent = (trigger, label, rich) => {
            const parts = ['eyebrow', 'title', 'description']
                .map((name) => [name, trigger.getAttribute(`data-tooltip-${name}`)])
                .filter(([, text]) => text);
            const contentKey = JSON.stringify([rich, label, parts]);
            if (overlay.dataset.contentKey === contentKey) return;
            overlay.dataset.contentKey = contentKey;
            overlay.classList.toggle('table-tooltip-overlay--rich', rich);
            overlay.replaceChildren();
            if (!rich || !parts.length) overlay.textContent = label;
            else
                overlay.replaceChildren(
                    ...parts.map(([name, text]) => {
                        const element = document.createElement('span');
                        element.setAttribute('data-tooltip-part', name);
                        element.textContent = text;
                        return element;
                    }),
                );
        };
        const update = () => {
            if (
                !active?.isConnected ||
                !root.contains(active) ||
                active.matches(':disabled') ||
                (active.hasAttribute('data-table-cell-text') && !active.hasAttribute('data-table-cell-truncated'))
            ) {
                hide();
                active = null;
                return;
            }
            const label = active.getAttribute('data-tip');
            const rect = active.getBoundingClientRect();
            let visible = !!label && rect.width > 0 && rect.height > 0;
            let left = 0,
                top = 0,
                right = innerWidth,
                bottom = innerHeight;
            for (let parent = active.parentElement; parent; parent = parent.parentElement) {
                const style = getComputedStyle(parent);
                const bounds = parent.getBoundingClientRect();
                if (/(auto|scroll|hidden|clip)/.test(style.overflowX)) {
                    left = Math.max(left, bounds.left);
                    right = Math.min(right, bounds.right);
                }
                if (/(auto|scroll|hidden|clip)/.test(style.overflowY)) {
                    top = Math.max(top, bounds.top);
                    bottom = Math.min(bottom, bounds.bottom);
                }
            }
            visible &&= rect.right > left && rect.left < right && rect.bottom > top && rect.top < bottom;
            if (!visible) {
                hide();
                return;
            }

            // Keep the existing DaisyUI variant colors and typography.
            const appearance = getComputedStyle(active, '::before');
            const rich = active.hasAttribute('data-tooltip-rich') || active.hasAttribute('data-table-cell-text');
            overlay.style.backgroundColor = rich ? '' : appearance.backgroundColor;
            overlay.style.color = rich ? '' : appearance.color;
            overlay.style.font = rich ? '' : appearance.font;
            renderContent(active, label, rich);
            if (!overlay.matches(':popover-open')) overlay.showPopover();
            const nextDescription = active.matches('button, a, input, [tabindex]')
                ? active
                : active.querySelector('button, a, input, [tabindex]');
            if (described !== nextDescription) {
                clearDescription();
                described = nextDescription;
            }
            if (described) {
                const ids = (described.getAttribute('aria-describedby') || '').split(/\s+/).filter(Boolean);
                if (!ids.includes(overlay.id)) described.setAttribute('aria-describedby', [...new Set([...ids, overlay.id])].join(' '));
            }

            const size = overlay.getBoundingClientRect();
            const gap = 8;
            let x = rect.left + (rect.width - size.width) / 2;
            let y = rect.top - size.height - gap;
            if (active.classList.contains('tooltip-bottom')) {
                y = rect.bottom + gap;
                if (y + size.height > innerHeight - gap) y = rect.top - size.height - gap;
            } else if (active.classList.contains('tooltip-left') || active.classList.contains('tooltip-right')) {
                const preferLeft = active.classList.contains('tooltip-left');
                x = preferLeft ? rect.left - size.width - gap : rect.right + gap;
                if (x < gap) x = rect.right + gap;
                if (x + size.width > innerWidth - gap) x = rect.left - size.width - gap;
                y = rect.top + (rect.height - size.height) / 2;
            } else if (y < gap) {
                y = rect.bottom + gap;
            }
            overlay.style.left = `${Math.max(gap, Math.min(x, innerWidth - size.width - gap))}px`;
            overlay.style.top = `${Math.max(gap, Math.min(y, innerHeight - size.height - gap))}px`;
        };

        const tick = () => {
            update();
            frame = active ? requestAnimationFrame(tick) : null;
        };
        const select = () => {
            const next =
                [hovered, focused].find(
                    (element) =>
                        element?.isConnected &&
                        root.contains(element) &&
                        (!element.hasAttribute('data-table-cell-text') || element.hasAttribute('data-table-cell-truncated')),
                ) || null;
            if (active === next) return;
            hide();
            cancelAnimationFrame(frame);
            active = next;
            if (active) tick();
        };
        const onOver = (event) => {
            syncCells();
            hovered = triggerFor(event.target);
            select();
        };
        const onOut = (event) => {
            hovered = triggerFor(event.relatedTarget);
            select();
        };
        const onFocus = (event) => {
            focused = triggerFor(event.target);
            select();
        };
        const onBlur = (event) => {
            focused = triggerFor(event.relatedTarget);
            select();
        };
        const onEscape = (event) => {
            if (event.key === 'Escape') {
                hovered = focused = null;
                select();
            }
        };
        const onNavigate = () => {
            hovered = focused = null;
            select();
        };
        refresh();
        root.addEventListener('pointerover', onOver);
        root.addEventListener('pointerout', onOut);
        root.addEventListener('focusin', onFocus);
        root.addEventListener('focusout', onBlur);
        root.addEventListener('keydown', onEscape);
        document.addEventListener('livewire:navigating', onNavigate);

        this.cleanup = () => {
            hide();
            cancelAnimationFrame(frame);
            overlay.remove();
            observer.disconnect();
            resizeObserver?.disconnect();
            window.removeEventListener('resize', refresh);
            for (const cell of cells) restoreCell(cell);
            for (const [button, label] of autoNames) {
                if (button.getAttribute('aria-label') === label) button.removeAttribute('aria-label');
            }
            root.removeAttribute('data-table-tooltips-ready');
            root.removeEventListener('pointerover', onOver);
            root.removeEventListener('pointerout', onOut);
            root.removeEventListener('focusin', onFocus);
            root.removeEventListener('focusout', onBlur);
            root.removeEventListener('keydown', onEscape);
            document.removeEventListener('livewire:navigating', onNavigate);
        };
    },

    destroy() {
        this.cleanup();
    },
});
