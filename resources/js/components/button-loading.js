const installed = new WeakSet();
const selector = '[data-ui-loading-control]';

export function installButtonLoading(document, Livewire) {
    if (installed.has(document)) return;
    installed.add(document);
    const window = document.defaultView;
    const states = new Map();
    let origin = null;

    const operationPending = (button) => {
        const expression = button.getAttribute('x-bind:data-ui-button-loading') || button.getAttribute(':data-ui-button-loading');
        return expression && window.Alpine
            ? Boolean(window.Alpine.evaluate(button, expression))
            : button.getAttribute('data-ui-button-loading') === 'true';
    };

    function render(button, state) {
        if (state.spinner) {
            button.querySelectorAll('[data-ui-loading-spinner]').forEach((spinner) => {
                if (spinner !== state.spinner) spinner.remove();
            });
            if (state.spinner.parentElement !== button) {
                if (state.icon || state.pagination) button.append(state.spinner);
                else button.prepend(state.spinner);
            }
            if (!state.icon && !state.pagination && button.firstElementChild !== state.spinner) button.prepend(state.spinner);
            button.classList.add('ui-button-busy');
            if (state.pagination) button.classList.add('ui-pagination-busy');
            else if (!state.icon) button.classList.add('ui-button-text-busy');
            state.spinner.classList.remove('hidden');
        }
        button.setAttribute('aria-busy', 'true');
        button.setAttribute('aria-disabled', 'true');
    }

    function finish(button, force = false) {
        const state = states.get(button);
        if (!state || (!force && (state.pending || state.navigating || operationPending(button)))) return;
        state.spinner?.classList.add('hidden');
        button.classList.remove('ui-button-busy', 'ui-button-text-busy', 'ui-pagination-busy');
        if (button.tagName === 'BUTTON') button.disabled = state.disabled;
        for (const [name, value] of state.attributes) {
            if (value === null) button.removeAttribute(name);
            else button.setAttribute(name, value);
        }
        states.delete(button);
    }

    function start(button) {
        if (states.has(button)) return states.get(button);
        const spinner = button.querySelector('[data-ui-loading-spinner]');
        const pagination = Boolean(button.closest('[data-ui-pagination]'));
        const icon = [...button.querySelectorAll('svg')].find((candidate) => {
            const bounds = candidate.getBoundingClientRect();
            return bounds.width > 0 && bounds.height > 0 && window.getComputedStyle(candidate).visibility === 'visible';
        });
        if (spinner) {
            spinner.classList.add('ui-button-spinner');
            if (pagination) {
                spinner.style.left = '50%';
                spinner.style.color = window.getComputedStyle(button).color;
            } else if (icon) {
                const bounds = button.getBoundingClientRect();
                const anchor = icon.getBoundingClientRect();
                spinner.style.left = `${anchor.left - bounds.left - button.clientLeft + anchor.width / 2}px`;
            }
        }
        const state = {
            pending: 1,
            navigating: false,
            spinner,
            icon,
            pagination,
            disabled: button.disabled,
            attributes: ['aria-busy', 'aria-disabled'].map((name) => [name, button.getAttribute(name)]),
        };
        states.set(button, state);
        render(button, state);
        // Defer disabled so the initiating click can still submit and validate its form.
        window.setTimeout(() => {
            if (states.get(button) !== state) return;
            if (button.tagName === 'BUTTON') button.disabled = true;
            finish(button);
        }, 0);
        window.setTimeout(() => {
            state.pending--;
            finish(button);
        }, 180);
        return state;
    }

    function remember(button) {
        origin = button;
        window.setTimeout(() => {
            if (origin === button) origin = null;
        }, 0);
    }

    document.addEventListener(
        'click',
        (event) => {
            const button = event.target.closest(selector);
            if (!button || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey || event.button !== 0) return;
            if (button.tagName === 'A' && (button.hasAttribute('download') || (button.target && button.target !== '_self'))) return;
            if (states.has(button)) {
                event.preventDefault();
                event.stopImmediatePropagation();
                return;
            }
            if (button.disabled || button.getAttribute('aria-disabled') === 'true') return;
            remember(button);
            // A submit event only fires after native constraint validation succeeds.
            if (button.tagName === 'BUTTON' && button.type === 'submit' && button.form) return;
            start(button);
        },
        true,
    );

    document.addEventListener(
        'submit',
        (event) => {
            const button = event.submitter?.closest(selector);
            if (!button) return;
            if (states.has(button)) {
                event.preventDefault();
                event.stopImmediatePropagation();
                return;
            }
            remember(button);
            start(button);
        },
        true,
    );

    Livewire.interceptAction(({ action, onFinish, onError, onFailure, onCancel }) => {
        const source = action.origin?.targetEl || action.origin?.el;
        const button = source?.closest(selector) || origin;
        if (!button || (button.disabled && !states.has(button))) return;
        const state = start(button);
        state.pending++;
        let settled = false;
        const settle = (failed = false) => {
            if (settled) return;
            settled = true;
            state.pending--;
            finish(button, failed);
        };
        onFinish(() => settle());
        onError(() => settle(true));
        onFailure(() => settle(true));
        onCancel(() => settle(true));
    });

    Livewire.hook('morphed', () => {
        for (const [button, state] of states) {
            if (!button.isConnected) finish(button, true);
            else if (state.pending || state.navigating || operationPending(button)) {
                render(button, state);
                if (button.tagName === 'BUTTON') button.disabled = true;
            }
        }
    });

    const observer = new window.MutationObserver((records) => {
        for (const { target } of records) finish(target);
    });
    observer.observe(document.documentElement, { subtree: true, attributes: true, attributeFilter: ['data-ui-button-loading'] });

    document.addEventListener('livewire:navigate', (event) => {
        const entry = [...states].find(([button]) => button.href === event.detail?.url?.href);
        const pending = [...states].filter(([, state]) => state.pending > 0);
        const button = entry?.[0] || origin || (pending.length === 1 ? pending[0][0] : null);
        const state = states.get(button);
        if (!state) return;
        state.navigating = true;
        state.destination = event.detail?.url?.href;
        window.queueMicrotask(() => {
            if (event.defaultPrevented) finish(button, true);
        });
    });

    // Navigation fetches have no action interceptor. Observe only their failures.
    const fetch = window.fetch;
    window.fetch = function (...args) {
        const result = fetch.apply(this, args);
        if (args[1]?.headers?.['X-Livewire-Navigate'] !== '1') return result;
        return result.catch((error) => {
            const destination = new URL(args[0], document.baseURI).href;
            for (const [button, state] of states) {
                if (state.destination === destination) finish(button, true);
            }
            throw error;
        });
    };

    const reset = () => {
        for (const button of states.keys()) finish(button, true);
        origin = null;
    };
    document.addEventListener('livewire:navigated', reset);
    window.addEventListener('pageshow', reset);
}

export function initializeButtonLoading(document, window) {
    if (window.Livewire) {
        installButtonLoading(document, window.Livewire);
    } else {
        document.addEventListener('livewire:init', () => installButtonLoading(document, window.Livewire), { once: true });
    }
}
