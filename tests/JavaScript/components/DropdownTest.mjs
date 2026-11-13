import { test } from 'node:test';
import assert from 'node:assert/strict';
import dropdown from '../../../resources/js/components/dropdown.js';
import { installWindow, mount } from '../support/component.js';

function setup(t, options = {}, rect = { top: 20, bottom: 40, left: 940, right: 1000 }) {
    const { window, listeners } = installWindow(t);
    window.innerWidth = 1000;
    window.innerHeight = 600;
    const documentListeners = new Map();
    const document = {
        activeElement: null,
        addEventListener: (key, fn) => documentListeners.set(key, fn),
        removeEventListener: (key) => documentListeners.delete(key),
    };
    globalThis.document = document;
    t.after(() => delete globalThis.document);
    const element = () => ({
        attributes: new Map(),
        getClientRects: () => [1],
        matches: () => false,
        hasAttribute(key) {
            return this.attributes.has(key);
        },
        setAttribute(key, value) {
            this.attributes.set(key, value);
        },
        focus() {
            document.activeElement = this;
        },
    });
    const triggerListeners = new Map();
    const trigger = {
        ...element(),
        getBoundingClientRect: () => rect,
        addEventListener: (key, fn) => triggerListeners.set(key, fn),
        removeEventListener: (key) => triggerListeners.delete(key),
    };
    const controls = [element(), element(), element()];
    const panel = {
        style: {},
        scrollHeight: 1200,
        visible: false,
        get offsetWidth() {
            return Math.min(384, parseFloat(this.style.maxWidth) || 384);
        },
        get offsetHeight() {
            return Math.min(1200, parseFloat(this.style.maxHeight) || 1200);
        },
        querySelectorAll: () => controls,
        showPopover() {
            this.visible = true;
        },
        hidePopover() {
            this.visible = false;
        },
        focus() {
            document.activeElement = this;
        },
    };
    const events = [];
    const instance = mount(dropdown({ open: false, dialog: false, placement: 'bottom', end: false, panelId: 'panel', ...options }), {
        $refs: { trigger: { querySelector: () => trigger }, panel },
        $dispatch: (event) => events.push(event),
    });
    return { ...instance, window, document, listeners, documentListeners, triggerListeners, trigger, controls, panel, rect, events };
}

function key(key, defaultPrevented = false) {
    return {
        key,
        defaultPrevented,
        preventDefault() {
            this.defaultPrevented = true;
        },
        stopPropagation() {
            this.stopped = true;
        },
    };
}

test('clamps long panels to the viewport and flips above when necessary', (t) => {
    const { component, panel, rect } = setup(t);
    component.openPanel();
    assert.equal(panel.style.left, '608px');
    assert.equal(panel.style.top, '44px');
    assert.equal(panel.style.maxHeight, '548px');
    rect.top = 520;
    rect.bottom = 550;
    component.position();
    assert.equal(panel.style.top, '8px');
    assert.equal(panel.style.maxHeight, '508px');
    component.close();
    component.position();
    assert.equal(panel.visible, false);
});

test('uses the visual viewport and preserves end alignment', (t) => {
    const { component, panel, window } = setup(t, { end: true }, { top: 200, bottom: 220, left: 300, right: 350 });
    window.visualViewport = { offsetLeft: 20, offsetTop: 100, width: 320, height: 300 };
    component.openPanel();
    assert.equal(panel.style.maxWidth, '304px');
    assert.equal(panel.style.left, '28px');
    assert.equal(panel.style.top, '224px');
});

for (const placement of ['left', 'right', 'top']) {
    test(`honors ${placement} placement while retaining visible bounds`, (t) => {
        const { component, panel } = setup(t, { placement }, { top: 520, bottom: 550, left: 400, right: 440 });
        component.openPanel();
        assert.ok(parseFloat(panel.style.left) >= 8);
        assert.ok(parseFloat(panel.style.top) >= 8);
        assert.ok(parseFloat(panel.style.top) + panel.offsetHeight <= 592);
    });
}

test('flips side panels when their preferred horizontal space is unavailable', (t) => {
    const { component, panel, rect } = setup(t, { placement: 'left' }, { top: 20, bottom: 40, left: 0, right: 40 });
    component.openPanel();
    assert.equal(panel.style.left, '44px');
    rect.left = 980;
    rect.right = 1000;
    component.position();
    assert.equal(panel.style.left, '592px');
});

for (const rect of [
    { top: -40, bottom: 0, left: 10, right: 40 },
    { top: 600, bottom: 620, left: 10, right: 40 },
    { top: 10, bottom: 40, left: -40, right: 0 },
    { top: 10, bottom: 40, left: 1000, right: 1040 },
]) {
    test('closes when the anchor leaves the viewport', (t) => {
        const { component, events } = setup(t, {}, rect);
        component.openPanel();
        assert.equal(component.open, false);
        assert.deepEqual(events, ['ui-dropdown-closed']);
    });
}

test('supports menu keyboard navigation, Escape and focus restoration', (t) => {
    const { component, controls, document, trigger, events } = setup(t);
    component.openPanel();
    assert.equal(document.activeElement, controls[0]);
    component.keydown(key('End'));
    assert.equal(document.activeElement, controls[2]);
    component.keydown(key('ArrowDown'));
    assert.equal(document.activeElement, controls[0]);
    component.keydown(key('ArrowUp'));
    assert.equal(document.activeElement, controls[2]);
    component.keydown(key('Home'));
    assert.equal(document.activeElement, controls[0]);
    component.keydown(key('Escape', true));
    assert.equal(component.open, true);
    const escape = key('Escape');
    component.keydown(escape);
    assert.equal(escape.stopped, true);
    assert.equal(document.activeElement, trigger);
    component.close();
    assert.equal(events.length, 1);
    component.openPanel();
    component.keydown(key('Tab'));
    assert.equal(component.open, false);
});

test('leaves dialog text navigation alone and handles an empty panel', (t) => {
    const { component, controls, panel, document } = setup(t, { dialog: true });
    controls.length = 0;
    component.openPanel();
    assert.equal(document.activeElement, panel);
    component.keydown(key('ArrowDown'));
    component.keydown(key('Tab'));
    assert.equal(component.open, true);
});

test('initializes listeners, ARIA and observers and removes them on destruction', (t) => {
    let resize;
    let disconnected = false;
    globalThis.ResizeObserver = class {
        constructor(callback) {
            resize = callback;
        }
        observe() {}
        disconnect() {
            disconnected = true;
        }
    };
    t.after(() => delete globalThis.ResizeObserver);
    const { component, trigger, triggerListeners, panel, watchers, window, documentListeners, listeners } = setup(t, {
        open: true,
        dialog: true,
    });
    const viewportListeners = new Map();
    window.visualViewport = {
        width: 1000,
        height: 600,
        addEventListener: (key, fn) => viewportListeners.set(key, fn),
        removeEventListener: (key) => viewportListeners.delete(key),
    };
    component.init();
    resize();
    assert.equal(panel.visible, true);
    assert.equal(trigger.attributes.get('aria-haspopup'), 'dialog');
    watchers.get('open')();
    assert.equal(trigger.attributes.get('aria-expanded'), 'true');
    triggerListeners.get('click')(key('click'));
    assert.equal(component.open, false);
    for (const value of ['Enter', ' ', 'ArrowDown', 'ArrowUp']) {
        triggerListeners.get('keydown')(key(value));
    }
    triggerListeners.get('keydown')(key('Other'));
    component.destroy();
    assert.equal(disconnected, true);
    assert.equal(triggerListeners.size, 0);
    assert.equal(documentListeners.size, 0);
    assert.equal(listeners.size, 0);
    assert.equal(viewportListeners.size, 0);
});

test('tolerates missing triggers and panel teardown', (t) => {
    const { component } = setup(t);
    component.$refs.trigger = null;
    component.init();
    component.openPanel();
    component.$refs.panel = null;
    component.position();
    component.open = false;
    component.destroy();
});

test('does not reopen a panel closed before its scheduled focus', (t) => {
    const { component, panel } = setup(t);
    let ready;
    component.$nextTick = (callback) => {
        ready = callback;
    };
    component.openPanel();
    component.close();
    ready();
    assert.equal(panel.visible, false);
});

test('flips a right panel to the left at the screen edge', (t) => {
    const { component, panel } = setup(t, { placement: 'right' });
    component.openPanel();
    assert.equal(panel.style.left, '552px');
});

test('opens hover panels without stealing keyboard focus', (t) => {
    const { component, panel, document, trigger } = setup(t);
    document.activeElement = trigger;
    component.openPanel(false, false);
    assert.equal(panel.visible, true);
    assert.equal(document.activeElement, trigger);
});
