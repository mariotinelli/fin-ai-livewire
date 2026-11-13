import { test } from 'node:test';
import assert from 'node:assert/strict';
import alertModal from '../../../resources/js/components/alert-modal.js';
import { mount } from '../support/component.js';

function setup(t, defaults = {}) {
    const stores = new Map();
    const listeners = new Map();
    globalThis.Alpine = {
        store(name, value) {
            if (arguments.length > 1) stores.set(name, value);
            return stores.get(name);
        },
    };
    const document = {
        body: {},
        activeElement: null,
        addEventListener: (name, fn) => listeners.set(name, fn),
        removeEventListener: (name) => listeners.delete(name),
    };
    globalThis.document = document;
    globalThis.Livewire = { find: () => ({ call: t.mock.fn(async () => true) }) };
    t.after(() => {
        delete globalThis.Alpine;
        delete globalThis.document;
        delete globalThis.Livewire;
    });
    const element = () => ({
        isConnected: true,
        disabled: false,
        visible: true,
        matches() {
            return this.disabled;
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
    const cancel = element();
    const confirm = element();
    const controls = [cancel, confirm];
    const dialog = { ...element(), querySelectorAll: () => controls, querySelector: () => confirm };
    const { component } = mount(
        alertModal({
            colors: { secondary: {}, error: {}, info: {}, success: {} },
            icons: ['check-circle', 'exclamation-triangle', 'information-circle', 'x-circle', 'question-mark-circle'],
            defaultColor: null,
            defaultIcon: null,
            ...defaults,
        }),
        {
            $root: {
                querySelector: (selector) => (component.alerts.some((alert) => selector === `#info-modal-${alert.key}`) ? dialog : null),
            },
        },
    );
    component.init();
    const add = (payload = {}) => {
        component.add({
            title: 'Confirm',
            type: 'confirmation',
            actionConfirm: true,
            method: 'save',
            componentId: 'component',
            params: [42],
            ...payload,
        });
        return component.alerts[0];
    };
    return { component, add, stores, listeners, document, opener, cancel, confirm, controls, dialog };
}

const event = (shiftKey = false) => ({
    shiftKey,
    preventDefault() {
        this.prevented = true;
    },
});

test('waits for confirmation and prevents cancel, removal and duplicate execution while pending', async (t) => {
    const { component, add, stores, opener, document } = setup(t);
    let resolve;
    let calls = 0;
    const alert = add({
        onConfirm: () => {
            calls++;
            return new Promise((done) => {
                resolve = done;
            });
        },
    });
    const pending = component.confirm(alert);
    assert.equal(alert.pending, true);
    assert.equal(await component.confirm(alert), false);
    assert.equal(await component.cancel(alert), false);
    assert.equal(await component.dismiss(alert), false);
    component.remove(alert.key);
    assert.equal(component.alerts.length, 1);
    assert.equal(calls, 1);
    resolve(true);
    await pending;
    assert.equal(component.alerts.length, 0);
    assert.equal(document.activeElement, opener);
    assert.deepEqual(stores.get('uiModalStack'), []);
    assert.equal(await component.confirm(alert), false);
    component.remove(alert.key);
});

test('false keeps the alert and returns focus for a successful retry', async (t) => {
    const { component, add, confirm, document } = setup(t);
    const alert = add({ onConfirm: () => false });
    assert.equal(await component.confirm(alert), false);
    assert.equal(component.alerts.length, 1);
    assert.equal(document.activeElement, confirm);
    assert.equal(alert.pending, false);
    alert.onConfirm = () => undefined;
    await component.confirm(alert);
    assert.equal(component.alerts.length, 0);
});

test('rejections show a safe error and do not leak details or disable retries', async (t) => {
    const { component, add } = setup(t);
    const alert = add({
        onConfirm: () => {
            throw new Error('secret');
        },
    });
    await component.confirm(alert);
    assert.match(alert.error, /Tente novamente/);
    assert.ok(!alert.error.includes('secret'));
    assert.equal(alert.pending, false);
    alert.onConfirm = () => true;
    await component.confirm(alert);
    assert.equal(component.alerts.length, 0);
});

test('preserves legacy methods and passes array parameters as one argument', async (t) => {
    const { component, add } = setup(t);
    const calls = [];
    Livewire.find = (id) => ({
        call: async (...args) => {
            calls.push([id, ...args]);
            return true;
        },
    });
    await component.confirm(add());
    await component.cancel(add({ actionConfirm: false }));
    await component.confirm(add({ actionConfirm: false, actionCancel: 'cancel' }));
    await component.cancel(add({ actionCancel: 'cancel' }));
    await component.dismiss(add({ actionCancel: 'cancel' }));
    assert.deepEqual(calls, [
        ['component', 'save', [42]],
        ['component', 'save', [42]],
        ['component', 'cancel', [42]],
        ['component', 'cancel', [42]],
        ['component', 'cancel', [42]],
    ]);
    await component.confirm(add({ actionConfirm: false, method: null }));
    await component.cancel(add({ method: null, actionConfirm: false }));
    await component.dismiss(add({ type: 'alert' }));
});

test('awaits local cancellation and retains the alert on false or rejection', async (t) => {
    const { component, add } = setup(t);
    let resolve;
    const alert = add({
        onCancel: () =>
            new Promise((done) => {
                resolve = done;
            }),
    });
    const pending = component.cancel(alert);
    assert.equal(alert.pending, true);
    resolve(false);
    await pending;
    assert.equal(component.alerts.length, 1);
    alert.onCancel = async () => {
        throw new Error('cancel failed');
    };
    await component.dismiss(alert);
    assert.equal(component.alerts.length, 1);
    alert.onCancel = () => true;
    await component.dismiss(alert);
    assert.equal(component.alerts.length, 0);
});

test('serializes queued alerts with unique keys and preserves the underlying modal stack', async (t) => {
    const { component, add, stores, document, opener } = setup(t);
    stores.set('uiModalStack', ['parent']);
    const first = add();
    component.add({ title: 'Next', type: 'alert' });
    assert.equal(component.alerts.length, 1);
    assert.equal(component.queuedAlerts.length, 1);
    component.remove(first.key);
    assert.equal(component.alerts[0].title, 'Next');
    assert.notEqual(component.alerts[0].key, first.key);
    assert.deepEqual(stores.get('uiModalStack'), ['parent', `alert-${component.alerts[0].key}`]);
    component.remove(component.alerts[0].key);
    assert.deepEqual(stores.get('uiModalStack'), ['parent']);
    assert.equal(document.activeElement, opener);
});

test('preserves defaults and allowlists semantic color and icon choices', (t) => {
    const { component, add } = setup(t);
    let alert = add();
    assert.equal(alert.color, 'error');
    assert.equal(alert.icon, null);
    component.remove(alert.key);
    alert = add({ type: 'alert' });
    assert.equal(alert.color, 'secondary');
    assert.equal(alert.icon, 'exclamation-triangle');
    for (const [color, icon] of [
        ['success', 'check-circle'],
        ['info', 'information-circle'],
        ['error', 'x-circle'],
    ]) {
        component.remove(alert.key);
        alert = add({ color });
        assert.equal(alert.color, color);
        assert.equal(alert.icon, icon);
    }
    component.remove(alert.key);
    alert = add({ color: '__proto__', icon: '<script>' });
    assert.equal(alert.color, 'error');
    assert.equal(alert.icon, 'x-circle');
});

test('uses component visual defaults and splits highlighted text without HTML', (t) => {
    const { component, add } = setup(t, { defaultColor: 'success', defaultIcon: 'question-mark-circle' });
    const alert = add();
    assert.equal(alert.icon, 'question-mark-circle');
    assert.equal(alert.color, 'success');
    assert.deepEqual(component.descriptionParts({}), [{ text: '', bold: false }]);
    assert.deepEqual(component.descriptionParts({ description: 'unchanged', descriptionHighlight: 'absent' }), [
        { text: 'unchanged', bold: false },
    ]);
    assert.deepEqual(component.descriptionParts({ description: 'A <b> B', descriptionHighlight: '<b>' }), [
        { text: 'A ', bold: false },
        { text: '<b>', bold: true },
        { text: ' B', bold: false },
    ]);
});

test('traps focus even when pending actions leave no enabled buttons', (t) => {
    const { component, add, controls, document, dialog, confirm, cancel } = setup(t);
    const alert = add();
    document.activeElement = cancel;
    let tab = event(true);
    component.trapFocus(tab, alert.key);
    assert.equal(document.activeElement, confirm);
    assert.equal(tab.prevented, true);
    tab = event();
    component.trapFocus(tab, alert.key);
    assert.equal(document.activeElement, cancel);
    component.trapFocus(event(), 999);
    document.activeElement = dialog;
    component.trapFocus(event(), alert.key);
    controls.forEach((control) => (control.disabled = true));
    tab = event();
    component.trapFocus(tab, alert.key);
    assert.equal(document.activeElement, dialog);
    assert.equal(tab.prevented, true);
    component.focusFirstAction(alert.key);
    assert.equal(document.activeElement, dialog);
});

test('remembers the opener before native disabled blurs it and cleans up listeners', (t) => {
    const { component, add, listeners, document, opener, stores } = setup(t);
    listeners.get('focusin')({ target: opener });
    listeners.get('click')({ target: { closest: () => opener } });
    document.activeElement = document.body;
    const alert = add();
    listeners.get('focusin')({ target: document.body });
    listeners.get('click')({ target: { closest: () => null } });
    component.remove(alert.key);
    assert.equal(document.activeElement, opener);
    listeners.get('focusin')({ target: document.body });
    component.init();
    opener.isConnected = false;
    add();
    component.remove(component.alerts[0].key);
    add();
    component.destroy();
    assert.deepEqual(stores.get('uiModalStack'), []);
    assert.equal(listeners.size, 0);
});

test('restores tracked focus for programmatic alerts and tolerates no opener', (t) => {
    const { component, add, listeners, document, opener, controls } = setup(t);
    listeners.get('focusin')({ target: opener });
    listeners.get('click')({ target: { closest: () => null } });
    document.activeElement = document.body;
    let alert = add();
    controls[0].visible = false;
    component.focusFirstAction(alert.key);
    assert.equal(document.activeElement, controls[1]);
    component.remove(alert.key);
    assert.equal(document.activeElement, opener);
    component.lastTrigger = null;
    document.activeElement = document.body;
    alert = add();
    component.remove(alert.key);
    assert.equal(component.alerts.length, 0);
});
