import { test } from 'node:test';
import assert from 'node:assert/strict';
import { attachSelectDropdown, positionSelectDropdown } from '../../../resources/js/components/select-dropdown.js';
import { installWindow, mount } from '../support/component.js';

function setup(t, rect = { top: 20, bottom: 60, left: 0, right: 360, width: 360 }) {
    const { window } = installWindow(t);
    window.innerWidth = 320;
    window.innerHeight = 400;
    let visible = false;
    const panel = {
        isConnected: true,
        style: {},
        matches: () => visible,
        showPopover: t.mock.fn(() => {
            visible = true;
        }),
        hidePopover: t.mock.fn(() => {
            visible = false;
        }),
    };
    const instance = mount(
        {
            open: true,
            checkDropdownPosition() {
                positionSelectDropdown(this, 'panel', 224);
            },
        },
        {
            $refs: { button: { getBoundingClientRect: () => rect }, panel },
        },
    );
    return { ...instance, panel, rect, window };
}

test('clamps width to the viewport and opens below without repeated top-layer calls', (t) => {
    const { component, panel } = setup(t);
    component.checkDropdownPosition();
    component.checkDropdownPosition();
    assert.equal(component.dropdownUp, false);
    assert.equal(panel.style.width, '304px');
    assert.equal(panel.style.left, '8px');
    assert.equal(panel.style.top, '64px');
    assert.equal(panel.style.maxHeight, '224px');
    assert.equal(panel.style.transform, 'none');
    assert.equal(panel.showPopover.mock.callCount(), 1);
    component.open = false;
    component.checkDropdownPosition();
    component.checkDropdownPosition();
    assert.equal(panel.hidePopover.mock.callCount(), 1);
});

test('opens above and uses the visible mobile viewport including offsets', (t) => {
    const { component, panel, window } = setup(t, { top: 320, bottom: 360, left: 10, right: 370, width: 360 });
    window.visualViewport = { offsetLeft: 20, offsetTop: 200, width: 300, height: 180 };
    component.checkDropdownPosition();
    assert.equal(component.dropdownUp, true);
    assert.equal(panel.style.maxHeight, '108px');
    assert.equal(panel.style.width, '284px');
    assert.equal(panel.style.left, '28px');
    assert.equal(panel.style.top, '316px');
    assert.equal(panel.style.transform, 'translateY(-100%)');
});

for (const rect of [
    { top: -50, bottom: 0, left: 10, right: 100 },
    { top: 400, bottom: 440, left: 10, right: 100 },
    { top: 10, bottom: 50, left: -100, right: 0 },
    { top: 10, bottom: 50, left: 320, right: 400 },
]) {
    test(`closes a list whose trigger left the viewport ${JSON.stringify(rect)}`, (t) => {
        const { component, panel } = setup(t, rect);
        panel.showPopover();
        component.checkDropdownPosition();
        assert.equal(component.open, false);
        assert.equal(panel.hidePopover.mock.callCount(), 1);
    });
}

test('tolerates missing nodes during rendering and browsers without popover methods', (t) => {
    const { component } = setup(t);
    component.$refs.panel.isConnected = false;
    component.checkDropdownPosition();
    delete component.$refs.panel.showPopover;
    component.checkDropdownPosition();
    delete component.$refs.panel;
    component.checkDropdownPosition();
    delete component.$refs.button;
    component.checkDropdownPosition();
    const cleanup = attachSelectDropdown(component, 'panel');
    cleanup();
});

for (const bounds of [
    { top: 150, bottom: 200, left: 0, right: 320 },
    { top: 0, bottom: 90, left: 0, right: 320 },
    { top: 0, bottom: 400, left: 210, right: 250 },
    { top: 0, bottom: 400, left: 0, right: 90 },
]) {
    test(`closes when a scrolling ancestor hides the trigger ${JSON.stringify(bounds)}`, (t) => {
        const { component, window } = setup(t, { top: 100, bottom: 140, left: 100, right: 200, width: 100 });
        window.getComputedStyle = () => ({ overflowX: 'hidden', overflowY: 'auto' });
        component.$refs.button.parentElement = { getBoundingClientRect: () => bounds };
        component.checkDropdownPosition();
        assert.equal(component.open, false);
    });
}

test('keeps a trigger connected through visible or partially clipping ancestors', (t) => {
    const { component, window } = setup(t);
    window.getComputedStyle = (element) => element.style;
    component.$refs.button.parentElement = {
        style: { overflowX: 'hidden', overflowY: 'hidden' },
        getBoundingClientRect: () => ({ top: 0, bottom: 70, left: 10, right: 310 }),
        parentElement: { style: { overflowX: 'visible', overflowY: 'visible' }, getBoundingClientRect: () => ({}) },
    };
    component.checkDropdownPosition();
    assert.equal(component.open, true);
});

test('tracks visual viewport changes and cleans up open panels and pending updates', (t) => {
    const { component, panel, window, watchers } = setup(t);
    const listeners = new Map();
    window.visualViewport = {
        width: 320,
        height: 400,
        offsetTop: 0,
        offsetLeft: 0,
        addEventListener: (name, callback) => listeners.set(name, callback),
        removeEventListener: (name, callback) => {
            assert.equal(listeners.get(name), callback);
            listeners.delete(name);
        },
    };
    const cleanup = attachSelectDropdown(component, 'panel');
    watchers.get('open')(true);
    listeners.get('resize')();
    listeners.get('scroll')();
    component.open = false;
    listeners.get('resize')();
    watchers.get('open')(false);
    component.open = true;
    let scheduled;
    component.$nextTick = (callback) => {
        scheduled = callback;
    };
    watchers.get('open')(true);
    cleanup();
    scheduled();
    watchers.get('open')(true);
    assert.equal(listeners.size, 0);
    assert.equal(panel.matches(':popover-open'), false);
});

test('repositions after rendering changes and disconnects resize observation', (t) => {
    let notify;
    const observed = [];
    const disconnect = t.mock.fn();
    globalThis.ResizeObserver = class {
        constructor(callback) {
            notify = callback;
        }
        observe(element) {
            observed.push(element);
        }
        disconnect() {
            disconnect();
        }
    };
    t.after(() => delete globalThis.ResizeObserver);
    const { component, panel } = setup(t);
    const cleanup = attachSelectDropdown(component, 'panel');
    assert.deepEqual(observed, [component.$refs.button, panel]);
    notify();
    assert.equal(panel.style.position, 'fixed');
    panel.style.width = '';
    notify();
    assert.equal(panel.style.width, '304px');
    cleanup();
    notify();
    assert.equal(disconnect.mock.callCount(), 1);
    assert.equal(panel.matches(':popover-open'), false);
});
