import { test } from 'node:test';
import assert from 'node:assert/strict';
import sidepage from '../../../resources/js/components/sidepage.js';
import { mount } from '../support/component.js';

function setup(t, options = {}) {
    const stores = new Map();
    const listeners = new Map();
    const callbacks = {};
    const stops = [];
    let observe;
    globalThis.Alpine = {
        store(name, value) {
            if (arguments.length > 1) stores.set(name, value);
            return stores.get(name);
        },
    };
    globalThis.getComputedStyle = (element) => ({ visibility: element.visibility || 'visible' });
    globalThis.MutationObserver = class {
        constructor(callback) {
            observe = callback;
        }
        observe() {}
        disconnect() {
            stops.push('observer');
        }
    };
    const document = {
        activeElement: null,
        addEventListener: (name, fn) => listeners.set(name, fn),
        removeEventListener: (name) => listeners.delete(name),
    };
    globalThis.document = document;
    t.after(() => {
        delete globalThis.Alpine;
        delete globalThis.document;
        delete globalThis.MutationObserver;
        delete globalThis.getComputedStyle;
    });
    const element = (tagName = 'BUTTON') => ({
        tagName,
        isConnected: true,
        disabled: false,
        visible: true,
        tabIndex: 0,
        matches(selector) {
            return selector === 'input, select, textarea'
                ? this.tagName === 'INPUT'
                : this.disabled || this.hiddenType || this.tabIndex < 0;
        },
        closest(selector) {
            return selector.startsWith('[popover]') ? this.popover : this.inert ? {} : null;
        },
        getClientRects() {
            return this.visible ? [1] : [];
        },
        focus() {
            document.activeElement = this;
        },
    });
    const opener = element();
    document.activeElement = opener;
    const close = element();
    const input = element('INPUT');
    const last = element();
    const controls = [close, input, last];
    const loadingClose = element();
    const popover = {};
    const panel = {
        ...element(),
        querySelectorAll: () => (component.opening ? [loadingClose] : controls),
        contains: (el) => controls.includes(el) || el === popover,
    };
    const mounted = mount(sidepage({ open: false, id: 'editor', blockCloseWhileLoading: 'save', ...options }), {
        $refs: { panel },
        $wire: {
            $interceptAction(fn) {
                callbacks.action = fn;
                return () => stops.push('action');
            },
            $interceptMessage(fn) {
                callbacks.message = fn;
                return () => stops.push('message');
            },
        },
    });
    const { component, watchers } = mounted;
    component.init();
    const visible = () => watchers.get('visible')(component.visible);
    const action = (name) => {
        const hooks = {};
        callbacks.action({
            action: { name },
            ...Object.fromEntries(['onFinish', 'onError', 'onFailure', 'onCancel'].map((key) => [key, (fn) => (hooks[key] = fn)])),
        });
        visible();
        return hooks;
    };
    return {
        component,
        watchers,
        callbacks,
        stores,
        listeners,
        stops,
        opener,
        loadingClose,
        close,
        input,
        last,
        panel,
        controls,
        popover,
        document,
        action,
        visible,
        observe: () => observe(),
    };
}

const key = (shiftKey = false, name = 'Tab') => ({
    key: name,
    shiftKey,
    preventDefault() {
        this.prevented = true;
    },
});

test('opens optimistically then focuses fresh content and restores its opener', (t) => {
    const env = setup(t);
    env.listeners.get('click')({ target: { closest: () => env.opener } });
    const hooks = env.action('openSidepage');
    assert.equal(env.component.visible, true);
    assert.equal(env.component.opening, true);
    assert.equal(env.document.activeElement, env.loadingClose);
    env.component.open = true;
    env.watchers.get('open')(true);
    hooks.onFinish();
    assert.equal(env.component.opening, false);
    assert.equal(env.document.activeElement, env.input);
    env.component.requestClose();
    env.visible();
    assert.equal(env.component.visible, false);
    assert.equal(env.document.activeElement, env.opener);
});

test('does not reopen when the optimistic panel was cancelled before the response', (t) => {
    const env = setup(t);
    const hooks = env.action('openSidepage');
    env.component.requestClose();
    env.visible();
    env.component.open = true;
    assert.equal(env.component.visible, false);
    env.watchers.get('open')(true);
    assert.equal(env.component.open, false);
    hooks.onFinish();
    assert.equal(env.component.visible, false);
});

for (const outcome of ['onError', 'onFailure', 'onCancel']) {
    test(`clears pending state on ${outcome} without interfering with later requests`, (t) => {
        const env = setup(t);
        const opening = env.action('openSidepage');
        opening[outcome]();
        opening.onFinish();
        assert.equal(env.component.visible, false);
        env.component.open = true;
        env.visible();
        const saving = env.action('save');
        assert.equal(env.component.canClose(), false);
        env.component.requestClose();
        assert.equal(env.component.open, true);
        saving[outcome]();
        saving.onFinish();
        assert.equal(env.component.canClose(), true);
        assert.equal(env.component.open, true);
    });
}

test('counts simultaneous saves and honors explicit close locks and method targets', (t) => {
    const env = setup(t, { open: true, blockCloseWhileLoading: 'save(1), update' });
    const first = env.action('save');
    const second = env.action('update');
    assert.equal(env.component.pendingSaves, 2);
    first.onFinish();
    assert.equal(env.component.canClose(), false);
    second.onFinish();
    assert.equal(env.component.canClose(), true);
    env.component.closeLocked = true;
    env.component.requestClose();
    assert.equal(env.component.open, true);
    env.component.closeLocked = false;
    env.component.requestClose();
    assert.equal(env.component.open, false);
    assert.deepEqual(env.action('unrelated'), {});
});

test('tracks custom event opening using the scoped message lifecycle and ignores stale finishes', (t) => {
    const env = setup(t);
    let finish;
    env.callbacks.message({ onFinish: () => assert.fail('closed panel') });
    env.component.beginOpening();
    env.visible();
    env.callbacks.message({ onFinish: (fn) => (finish = fn) });
    const current = env.component.beginOpening();
    finish();
    assert.equal(env.component.opening, true);
    env.component.open = true;
    env.component.finishOpening(current);
    assert.equal(env.component.opening, false);
    assert.equal(env.component.visible, true);
    env.component.open = false;
    env.action('openSidepage');
    env.callbacks.message({ onFinish: () => assert.fail('action owns this opening') });
});

test('traps focus only for the top sidepage and respects a child modal', (t) => {
    const env = setup(t, { open: true });
    assert.equal(env.document.activeElement, env.input);
    env.document.activeElement = env.close;
    let event = key(true);
    env.component.trapFocus(event);
    assert.equal(env.document.activeElement, env.last);
    event = key();
    env.component.trapFocus(event);
    assert.equal(env.document.activeElement, env.close);
    env.controls.length = 0;
    env.component.focusFirstElement();
    env.component.trapFocus(key());
    assert.equal(env.document.activeElement, env.panel);
    env.stores.set('uiModalStack', ['child']);
    assert.equal(env.component.isActive(), false);
    env.component.requestClose();
    assert.equal(env.component.open, true);
    env.component.trapFocus(key());
    env.stores.set('uiModalStack', []);
    env.component.trapFocus(key(false, 'Enter'));
    const handled = key();
    handled.defaultPrevented = true;
    env.component.trapFocus(handled);
});

test('filters ineligible controls and restores focus after a morph without stealing it from popovers', (t) => {
    const env = setup(t, { open: true });
    env.close.disabled = true;
    env.input.inert = true;
    env.last.visible = false;
    assert.deepEqual(env.component.controls(), []);
    env.input.inert = false;
    env.input.visibility = 'hidden';
    assert.deepEqual(env.component.controls(), []);
    env.input.visibility = 'visible';
    env.document.activeElement = env.opener;
    env.observe();
    assert.equal(env.document.activeElement, env.input);
    env.component.ensureFocus();
    env.document.activeElement = env.panel;
    env.component.ensureFocus();
    const dropdown = { closest: () => env.popover };
    env.document.activeElement = dropdown;
    env.component.ensureFocus();
    assert.equal(env.document.activeElement, dropdown);
    env.watchers.get('open')(false);
    env.watchers.get('open')(true);
});

test('cleans interceptors and pending callbacks when navigating away', (t) => {
    const env = setup(t, { blockCloseWhileLoading: null });
    env.listeners.get('click')({ target: env.opener });
    const opening = env.action('openSidepage');
    env.listeners.get('click')({ target: env.input });
    env.component.destroy();
    env.component.focusFirstElement();
    opening.onFinish();
    env.component.finishOpening(env.component.openingToken);
    env.component.ensureFocus();
    assert.deepEqual(env.stops, ['action', 'message', 'observer']);
    assert.equal(env.listeners.size, 0);
    assert.deepEqual(env.stores.get('uiSidepageStack'), []);
});

test('keeps pending Tab on the loading close control and cycles backwards through controls', (t) => {
    const env = setup(t);
    const hooks = env.action('openSidepage');
    env.component.trapFocus(key());
    assert.equal(env.document.activeElement, env.loadingClose);
    env.component.open = true;
    hooks.onFinish();
    env.document.activeElement = env.last;
    env.component.trapFocus(key(true));
    assert.equal(env.document.activeElement, env.input);
});

test('restores cancelled opening focus after its initiating button is enabled again', (t) => {
    const env = setup(t);
    const hooks = env.action('openSidepage');
    env.opener.disabled = true;
    env.component.requestClose();
    env.visible();
    assert.equal(env.document.activeElement, env.loadingClose);
    env.opener.disabled = false;
    hooks.onFinish();
    assert.equal(env.document.activeElement, env.opener);
    env.component.lastFocusedElement = null;
    env.component.restoreFocus();
});
