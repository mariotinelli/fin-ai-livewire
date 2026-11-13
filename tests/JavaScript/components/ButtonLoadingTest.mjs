import { test } from 'node:test';
import assert from 'node:assert/strict';
import { installButtonLoading } from '../../../resources/js/components/button-loading.js';

function control(tagName = 'BUTTON', spinner = true) {
    const attributes = new Map([['data-ui-loading-control', '']]);
    const classes = new Set();
    const button = {
        tagName,
        disabled: false,
        type: 'button',
        isConnected: true,
        target: '',
        attributes,
        classList: {
            add: (...keys) => keys.forEach((key) => classes.add(key)),
            remove: (...keys) => keys.forEach((key) => classes.delete(key)),
            contains: (key) => classes.has(key),
        },
        clientLeft: 0,
        getBoundingClientRect: () => ({ left: 10, width: 150, height: 32 }),
        getAttribute: (key) => attributes.get(key) ?? null,
        hasAttribute: (key) => attributes.has(key),
        setAttribute: (key, value) => attributes.set(key, value),
        removeAttribute: (key) => attributes.delete(key),
        closest: (selector) =>
            selector === '[data-ui-pagination]'
                ? button.pagination
                    ? button
                    : null
                : attributes.has('data-ui-loading-control')
                  ? button
                  : null,
        querySelector: () => button.spinner,
        querySelectorAll: (selector) => (selector === 'svg' ? (button.icon ? [button.icon] : []) : button.spinner ? [button.spinner] : []),
        prepend: (node) => {
            node.parentElement = button;
            button.spinner = node;
            button.firstElementChild = node;
        },
        append: (node) => {
            node.parentElement = button;
            button.spinner = node;
        },
    };
    function newSpinner() {
        const classes = new Set(['hidden']);
        return {
            style: {},
            parentElement: button,
            classList: { add: (key) => classes.add(key), remove: (key) => classes.delete(key), contains: (key) => classes.has(key) },
            remove() {
                this.parentElement = null;
            },
        };
    }
    button.spinner = spinner ? newSpinner() : null;
    button.newSpinner = newSpinner;
    return button;
}

function setup(fetchImplementation = async () => 'response') {
    const listeners = new Map();
    const hooks = new Map();
    const timers = [];
    let interceptor;
    let observer;
    const window = {
        getComputedStyle: () => ({ visibility: 'visible', color: 'rgb(255, 255, 255)' }),
        setTimeout: (callback) => timers.push(callback),
        queueMicrotask: (callback) => timers.push(callback),
        addEventListener: (name, callback) => listeners.set(name, callback),
        fetch: fetchImplementation,
        MutationObserver: class {
            constructor(callback) {
                observer = callback;
            }
            observe() {}
        },
    };
    const document = {
        defaultView: window,
        documentElement: {},
        baseURI: 'https://example.test/',
        addEventListener: (name, callback) => listeners.set(name, callback),
    };
    const Livewire = {
        interceptAction: (callback) => {
            interceptor = callback;
        },
        hook: (name, callback) => hooks.set(name, callback),
    };
    installButtonLoading(document, Livewire);
    return {
        document,
        window,
        Livewire,
        hooks,
        flush: () => {
            while (timers.length) timers.shift()();
        },
        mutate: (target) => observer([{ target }]),
        emit(name, event) {
            listeners.get(name)(event);
        },
        click(button, extra = {}) {
            const event = {
                target: button,
                button: 0,
                preventDefault() {
                    this.defaultPrevented = true;
                },
                stopImmediatePropagation() {
                    this.stopped = true;
                },
                ...extra,
            };
            listeners.get('click')(event);
            return event;
        },
        action(button, name = 'save', params = [1], elementOrigin = false) {
            const callbacks = {};
            interceptor({
                action: { name, params, origin: button ? (elementOrigin ? { el: button } : { targetEl: button }) : null },
                ...Object.fromEntries(
                    ['onFinish', 'onError', 'onFailure', 'onCancel'].map((key) => [
                        key,
                        (callback) => {
                            callbacks[key] = callback;
                        },
                    ]),
                ),
            });
            return callbacks;
        },
    };
}

const busy = (button) => button.getAttribute('aria-busy');

test('places the small spinner over the visible icon and restores the button afterwards', () => {
    const env = setup();
    const button = control();
    button.icon = { getBoundingClientRect: () => ({ left: 18, width: 16, height: 16 }) };
    env.click(button);
    const action = env.action(button);
    env.flush();
    assert.equal(button.spinner.style.left, '16px');
    assert.equal(button.classList.contains('ui-button-busy'), true);
    assert.equal(button.classList.contains('ui-button-text-busy'), false);
    action.onFinish();
    assert.equal(button.classList.contains('ui-button-busy'), false);
    assert.equal(button.spinner.classList.contains('hidden'), true);
});

test('puts loading before text and centers it for pagination without moving page numbers', () => {
    const env = setup();
    const text = control();
    env.click(text);
    assert.equal(text.firstElementChild, text.spinner);
    assert.equal(text.classList.contains('ui-button-text-busy'), true);
    const page = control();
    page.pagination = true;
    env.click(page);
    assert.equal(page.classList.contains('ui-pagination-busy'), true);
    assert.equal(page.classList.contains('ui-button-text-busy'), false);
    assert.equal(page.spinner.style.left, '50%');
    assert.equal(page.spinner.style.color, 'rgb(255, 255, 255)');
    env.flush();
    assert.equal(page.classList.contains('ui-pagination-busy'), false);
});

test('isolates identical actions by origin, blocks duplicates and survives morphs', () => {
    const env = setup();
    installButtonLoading(env.document, env.Livewire);
    const first = control();
    const second = control();
    first.setAttribute('aria-busy', 'false');
    first.setAttribute('aria-disabled', 'false');
    env.click(first);
    const action = env.action(first, 'save', [42], true);
    env.flush();
    assert.equal(busy(first), 'true');
    assert.equal(first.disabled, true);
    assert.equal(busy(second), null);
    const duplicate = env.click(first);
    assert.equal(duplicate.defaultPrevented, true);
    assert.equal(duplicate.stopped, true);
    const spinner = first.spinner;
    spinner.parentElement = null;
    first.spinner = first.newSpinner();
    env.hooks.get('morphed')();
    assert.equal(first.spinner, spinner);
    assert.equal(spinner.classList.contains('hidden'), false);
    action.onFinish();
    action.onFinish();
    assert.equal(busy(first), 'false');
    assert.equal(first.getAttribute('aria-disabled'), 'false');
    assert.equal(first.disabled, false);
    assert.equal(spinner.classList.contains('hidden'), true);
});

for (const outcome of ['onError', 'onFailure', 'onCancel']) {
    test(`${outcome} restores original attributes even while operation state remains true`, () => {
        const env = setup();
        const button = control();
        button.setAttribute('data-ui-button-loading', 'true');
        env.click(button);
        const action = env.action(null);
        env.flush();
        action[outcome]();
        action.onFinish();
        assert.equal(busy(button), null);
        assert.equal(button.getAttribute('aria-disabled'), null);
        assert.equal(button.disabled, false);
    });
}

test('waits for every action and bound operation to settle', () => {
    const env = setup();
    const button = control();
    button.setAttribute(':data-ui-button-loading', 'saving');
    let saving = true;
    env.window.Alpine = { evaluate: () => saving };
    env.click(button);
    const first = env.action(button);
    const second = env.action(button, 'followUp');
    env.flush();
    first.onFinish();
    assert.equal(busy(button), 'true');
    second.onFinish();
    assert.equal(busy(button), 'true');
    env.hooks.get('morphed')();
    saving = false;
    env.mutate(button);
    assert.equal(busy(button), null);
});

test('preserves native submit validation and controls without a spinner', () => {
    const env = setup();
    const button = control('BUTTON', false);
    button.type = 'submit';
    button.form = {};
    env.click(button);
    env.flush();
    assert.equal(busy(button), null);
    env.emit('submit', { submitter: button });
    assert.equal(button.disabled, false);
    const action = env.action(button);
    env.flush();
    assert.equal(button.disabled, true);
    action.onFinish();
    assert.equal(button.disabled, false);
    env.emit('submit', {});
});

test('keeps modified links and inert or unmarked controls untouched', () => {
    const env = setup();
    for (const modifier of ['ctrlKey', 'metaKey', 'shiftKey', 'altKey']) {
        const link = control('A');
        env.click(link, { [modifier]: true });
        assert.equal(busy(link), null);
    }
    for (const configure of [
        (button) => (button.disabled = true),
        (button) => button.setAttribute('aria-disabled', 'true'),
        (button) => button.setAttribute('download', ''),
        (button) => (button.target = '_blank'),
        (button) => button.removeAttribute('data-ui-loading-control'),
    ]) {
        const link = control('A');
        configure(link);
        env.click(link);
        assert.equal(busy(link), null);
    }
    const middle = control('A');
    env.click(middle, { button: 1 });
    assert.equal(busy(middle), null);
});

test('waits for navigation and restores cancelled and failed navigation', async () => {
    const env = setup();
    const link = control('A');
    link.href = 'https://example.test/next';
    env.click(link);
    env.emit('livewire:navigate', { detail: { url: new URL(link.href) } });
    env.flush();
    assert.equal(busy(link), 'true');
    assert.equal(await env.window.fetch('/other'), 'response');
    assert.equal(await env.window.fetch('/next', { headers: { 'X-Livewire-Navigate': '1' } }), 'response');
    assert.equal(busy(link), 'true');
    env.emit('livewire:navigated');
    assert.equal(busy(link), null);
    env.click(link);
    env.emit('livewire:navigate', { detail: { url: new URL(link.href) }, defaultPrevented: true });
    env.flush();
    assert.equal(busy(link), null);
});

test('cleans disconnected elements and restores local actions on the next task or pageshow', () => {
    const env = setup();
    const button = control();
    env.click(button);
    env.flush();
    assert.equal(busy(button), null);
    env.click(button);
    const action = env.action(button);
    button.isConnected = false;
    env.hooks.get('morphed')();
    assert.equal(busy(button), null);
    action.onFinish();
    env.click(button);
    env.emit('pageshow');
    env.flush();
    assert.equal(busy(button), null);
});

test('releases navigation after a rejected fetch and preserves the rejection', async () => {
    const error = new Error('Network failure');
    const env = setup(() => Promise.reject(error));
    const link = control('A');
    link.href = 'https://example.test/next';
    env.click(link);
    env.emit('livewire:navigate', { detail: { url: new URL(link.href) } });
    env.flush();
    await assert.rejects(env.window.fetch('/next', { headers: { 'X-Livewire-Navigate': '1' } }), error);
    assert.equal(busy(link), null);
});

test('keeps a redirecting action busy after its response until navigation completes', () => {
    const env = setup();
    const button = control();
    env.click(button);
    const action = env.action(button);
    env.flush();
    env.emit('livewire:navigate', { detail: { url: new URL('https://example.test/next') } });
    action.onFinish();
    assert.equal(busy(button), 'true');
    env.emit('livewire:navigated');
    assert.equal(busy(button), null);
});

test('blocks repeated submit events and ignores actions without an eligible origin', () => {
    const env = setup();
    const button = control();
    env.emit('submit', { submitter: button });
    const repeated = {
        submitter: button,
        preventDefault() {
            this.prevented = true;
        },
        stopImmediatePropagation() {
            this.stopped = true;
        },
    };
    env.emit('submit', repeated);
    assert.equal(repeated.prevented, true);
    assert.equal(repeated.stopped, true);
    env.flush();
    const disabled = control();
    disabled.disabled = true;
    assert.deepEqual(env.action(disabled), {});
    assert.deepEqual(env.action(null), {});
    env.emit('livewire:navigate', { detail: {} });
});

test('keeps native modifier clicks available while the control is busy', () => {
    const env = setup();
    const link = control('A');
    env.click(link);
    const event = env.click(link, { ctrlKey: true });
    assert.equal(event.defaultPrevented, undefined);
    env.hooks.get('morphed')();
    env.flush();
});

test('settles simultaneous rows independently even with the same action name', () => {
    const env = setup();
    const first = control();
    const second = control();
    env.click(first);
    const one = env.action(first, 'save', [1]);
    env.click(second);
    const two = env.action(second, 'save', [2]);
    env.flush();
    one.onFinish();
    assert.equal(busy(first), null);
    assert.equal(busy(second), 'true');
    two.onFinish();
    assert.equal(busy(second), null);
});
