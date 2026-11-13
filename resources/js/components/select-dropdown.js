function setPopoverOpen(panel, open) {
    if (!panel?.showPopover || !panel.isConnected) return;
    if (open && !panel.matches(':popover-open')) panel.showPopover();
    if (!open && panel.matches(':popover-open')) panel.hidePopover();
}

export function isAnchorClipped(button, rect) {
    for (let parent = button.parentElement; parent; parent = parent.parentElement) {
        const style = window.getComputedStyle(parent);
        const bounds = parent.getBoundingClientRect();
        if (/(auto|scroll|hidden|clip)/.test(style.overflowY) && (rect.bottom <= bounds.top || rect.top >= bounds.bottom)) return true;
        if (/(auto|scroll|hidden|clip)/.test(style.overflowX) && (rect.right <= bounds.left || rect.left >= bounds.right)) return true;
    }
    return false;
}

export function positionSelectDropdown(component, panelName, maximumHeight) {
    const button = component.$refs.button;
    const panel = component.$refs[panelName];
    if (!button || !panel) return;

    const rect = button.getBoundingClientRect();
    const viewport = window.visualViewport;
    const left = viewport?.offsetLeft ?? 0;
    const top = viewport?.offsetTop ?? 0;
    const width = viewport?.width ?? window.innerWidth;
    const height = viewport?.height ?? window.innerHeight;
    const edge = 8;
    const gap = 4;
    if (
        rect.bottom <= top ||
        rect.top >= top + height ||
        rect.right <= left ||
        rect.left >= left + width ||
        isAnchorClipped(button, rect)
    ) {
        component.open = false;
        setPopoverOpen(panel, false);
        return;
    }

    const below = Math.max(0, top + height - rect.bottom - gap - edge);
    const above = Math.max(0, rect.top - top - gap - edge);
    component.dropdownUp = below < maximumHeight && above > below;
    const panelWidth = Math.min(rect.width, Math.max(0, width - edge * 2));
    Object.assign(panel.style, {
        position: 'fixed',
        margin: '0',
        width: panelWidth + 'px',
        maxHeight: Math.min(maximumHeight, component.dropdownUp ? above : below) + 'px',
        left: Math.max(left + edge, Math.min(rect.left, left + width - panelWidth - edge)) + 'px',
        top: (component.dropdownUp ? rect.top - gap : rect.bottom + gap) + 'px',
        right: 'auto',
        bottom: 'auto',
        transform: component.dropdownUp ? 'translateY(-100%)' : 'none',
    });
    setPopoverOpen(panel, component.open);
}

export function attachSelectDropdown(component, panelName) {
    let destroyed = false;
    const viewport = window.visualViewport;
    const reposition = () => {
        if (!destroyed && component.open) component.checkDropdownPosition();
    };
    component.$watch('open', () => {
        if (destroyed) return;
        setPopoverOpen(component.$refs[panelName], component.open);
        if (component.open) component.$nextTick(reposition);
    });
    viewport?.addEventListener('resize', reposition);
    viewport?.addEventListener('scroll', reposition);
    const observer = typeof ResizeObserver === 'undefined' ? null : new ResizeObserver(() => component.$nextTick(reposition));
    for (const element of [component.$refs.button, component.$refs[panelName]]) {
        if (element) observer?.observe(element);
    }

    return () => {
        destroyed = true;
        observer?.disconnect();
        viewport?.removeEventListener('resize', reposition);
        viewport?.removeEventListener('scroll', reposition);
        setPopoverOpen(component.$refs[panelName], false);
    };
}
