import { test } from 'node:test';
import assert from 'node:assert/strict';
import tableTooltips from '../../../resources/js/components/table-tooltips.js';

class FakeClassList {
    constructor(names = []) {
        this.names = new Set(names);
    }
    contains(name) {
        return this.names.has(name);
    }
    toggle(name, enabled) {
        if (enabled) this.names.add(name);
        else this.names.delete(name);
    }
}

class FakeElement {
    constructor({ tag = 'div', classes = [], rect, text = '', attributes = {} } = {}) {
        this.tag = tag;
        this.classList = new FakeClassList(classes);
        this.rect = rect || {
            top: 100,
            bottom: 120,
            left: 100,
            right: 140,
            width: 40,
            height: 20,
        };
        this.clientWidth = this.rect.width || 40;
        this.clientHeight = this.rect.height || 20;
        this.scrollWidth = this.clientWidth;
        this.scrollHeight = this.clientHeight;
        this.textContent = text;
        this.attributes = new Map(Object.entries(attributes));
        this.dataset = { tip: attributes['data-tip'] };
        this.style = {};
        this.listeners = new Map();
        this.children = [];
        this.parentElement = null;
        this.isConnected = true;
        this.popover = false;
    }
    append(child) {
        child.parentElement = this;
        this.children.push(child);
    }
    setAttribute(name, value) {
        this.attributes.set(name, String(value));
        if (name === 'data-tip') this.dataset.tip = String(value);
    }
    getAttribute(name) {
        return this.attributes.get(name) ?? null;
    }
    hasAttribute(name) {
        return this.attributes.has(name);
    }
    removeAttribute(name) {
        this.attributes.delete(name);
        if (name === 'data-tip') delete this.dataset.tip;
    }
    addEventListener(name, callback) {
        this.listeners.set(name, callback);
    }
    removeEventListener(name, callback) {
        assert.equal(this.listeners.get(name), callback);
        this.listeners.delete(name);
    }
    emit(name, event) {
        this.listeners.get(name)(event);
    }
    contains(element) {
        for (let node = element; node; node = node.parentElement) {
            if (node === this) return true;
        }
        return false;
    }
    closest(selector) {
        if (selector === '.sr-only, [aria-hidden=true]') {
            for (let node = this; node; node = node.parentElement) {
                if (node.classList.contains('sr-only') || node.getAttribute('aria-hidden') === 'true') return node;
            }
            return null;
        }
        if (selector === '[data-table-cell-text][data-table-cell-truncated]') {
            for (let node = this; node; node = node.parentElement) {
                if (node.hasAttribute('data-table-cell-text') && node.hasAttribute('data-table-cell-truncated')) return node;
            }
            return null;
        }
        if (selector === '.tooltip[data-tip]') {
            for (let node = this; node; node = node.parentElement) {
                if (node.classList.contains('tooltip') && node.hasAttribute('data-tip')) return node;
            }
            return null;
        }
        if (selector === '[data-table-tooltips]') {
            for (let node = this; node; node = node.parentElement) {
                if (node.hasAttribute('data-table-tooltips')) return node;
            }
        }
        return null;
    }
    matches(selector) {
        if (selector === ':popover-open') return this.popover;
        if (selector === ':disabled') return this.hasAttribute('disabled');
        if (selector === 'button, a, input, [tabindex]') {
            return ['button', 'a', 'input'].includes(this.tag) || this.hasAttribute('tabindex');
        }
        return false;
    }
    querySelector(selector) {
        if (selector.includes('button:not'))
            return (
                this.descendants().find(
                    (item) =>
                        item.matches('button, a, input, [tabindex]') &&
                        !item.hasAttribute('disabled') &&
                        item.getAttribute('tabindex') !== '-1',
                ) || null
            );
        return this.descendants().find((item) => item.matches(selector)) || null;
    }
    querySelectorAll(selector) {
        if (selector === 'button.tooltip[data-tip], a.tooltip[data-tip]') {
            return this.descendants().filter(
                (item) => ['button', 'a'].includes(item.tag) && item.classList.contains('tooltip') && item.hasAttribute('data-tip'),
            );
        }
        if (selector === '*') return this.descendants();
        if (selector === '[data-table-cell-text]') return this.descendants().filter((item) => item.hasAttribute('data-table-cell-text'));
        return [];
    }
    descendants() {
        return this.children.flatMap((child) => [child, ...child.descendants()]);
    }
    replaceChildren(...children) {
        this.children = [];
        this.textContent = '';
        children.forEach((child) => this.append(child));
    }
    cloneNode() {
        const clone = new FakeElement({
            tag: this.tag,
            text: this.textContent,
            attributes: Object.fromEntries(this.attributes),
        });
        this.children.forEach((child) => clone.append(child.cloneNode(true)));
        return clone;
    }
    getBoundingClientRect() {
        return this.rect;
    }
    showPopover() {
        this.popover = true;
    }
    hidePopover() {
        this.popover = false;
    }
    remove() {
        this.isConnected = false;
    }
}

function environment(t) {
    globalThis.Element = FakeElement;
    const root = new FakeElement({ attributes: { 'data-table-tooltips': '' } });
    const body = new FakeElement();
    const documentListeners = new Map();
    const windowListeners = new Map();
    globalThis.window = {
        addEventListener: (name, fn) => windowListeners.set(name, fn),
        removeEventListener: (name) => windowListeners.delete(name),
    };
    globalThis.document = {
        body,
        createElement: () => new FakeElement({ rect: { width: 80, height: 30 } }),
        addEventListener: (name, callback) => documentListeners.set(name, callback),
        removeEventListener(name, callback) {
            assert.equal(documentListeners.get(name), callback);
            documentListeners.delete(name);
        },
    };
    globalThis.innerWidth = 500;
    globalThis.innerHeight = 400;
    globalThis.getComputedStyle = (element, pseudo) =>
        pseudo
            ? { backgroundColor: 'black', color: 'white', font: '12px sans' }
            : {
                  overflowX: element.overflowX || 'visible',
                  overflowY: element.overflowY || 'visible',
              };
    let observerCallback;
    globalThis.MutationObserver = class {
        constructor(callback) {
            observerCallback = callback;
        }
        observe() {}
        disconnect() {}
    };
    let nextFrame = 0;
    let animation;
    globalThis.requestAnimationFrame = (callback) => {
        nextFrame += 1;
        animation = callback;
        return nextFrame;
    };
    globalThis.cancelAnimationFrame = () => {};
    t.after(() => {
        for (const name of [
            'window',
            'Element',
            'document',
            'innerWidth',
            'innerHeight',
            'getComputedStyle',
            'MutationObserver',
            'requestAnimationFrame',
            'cancelAnimationFrame',
        ])
            delete globalThis[name];
    });
    return { body, documentListeners, windowListeners, root, frame: () => animation(), observer: () => observerCallback };
}

test('names icon-only actions and displays accessible tooltips for pointer and keyboard users', (t) => {
    const { body, documentListeners, root, observer } = environment(t);
    const trigger = new FakeElement({
        tag: 'button',
        classes: ['tooltip'],
        attributes: { 'data-tip': 'Edit', 'aria-describedby': 'existing' },
    });
    const hidden = new FakeElement({
        text: 'Hidden',
        attributes: { 'aria-hidden': 'true' },
    });
    trigger.append(hidden);
    root.append(trigger);
    const component = tableTooltips();
    component.$el = root;
    component.init();
    observer()();
    assert.equal(trigger.getAttribute('aria-label'), 'Edit');
    const overlay = body.children[0];
    root.emit('pointerover', { target: trigger });
    assert.equal(overlay.popover, true);
    assert.match(trigger.getAttribute('aria-describedby'), /table-tooltip/);
    root.emit('pointerout', { relatedTarget: null });
    assert.equal(overlay.popover, false);
    root.emit('focusin', { target: trigger });
    root.emit('keydown', { key: 'Enter' });
    root.emit('keydown', { key: 'Escape' });
    documentListeners.get('livewire:navigating')();
    component.destroy();
    assert.equal(root.listeners.size, 0);
    assert.equal(documentListeners.size, 0);
});

test('positions every variant and hides clipped, disabled or detached triggers', (t) => {
    const { root } = environment(t);
    const parent = new FakeElement({
        rect: { top: 90, bottom: 130, left: 90, right: 150 },
        attributes: { tabindex: '0' },
    });
    parent.overflowX = 'hidden';
    parent.overflowY = 'scroll';
    const trigger = new FakeElement({
        classes: ['tooltip', 'tooltip-bottom'],
        attributes: { 'data-tip': 'Details' },
    });
    parent.append(trigger);
    root.append(parent);
    const component = tableTooltips();
    component.$el = root;
    component.init();
    root.emit('pointerover', { target: trigger });
    trigger.classList = new FakeClassList(['tooltip', 'tooltip-left']);
    root.emit('pointerout', { relatedTarget: null });
    root.emit('pointerover', { target: trigger });
    trigger.classList = new FakeClassList(['tooltip', 'tooltip-right']);
    root.emit('focusout', { relatedTarget: trigger });
    trigger.setAttribute('disabled', '');
    root.emit('pointerout', { relatedTarget: null });
    root.emit('pointerover', { target: trigger });
    trigger.removeAttribute('disabled');
    trigger.rect = {
        top: -100,
        bottom: -80,
        left: -100,
        right: -60,
        width: 40,
        height: 20,
    };
    root.emit('pointerout', { relatedTarget: null });
    root.emit('pointerover', { target: trigger });
    trigger.rect = {
        top: 2,
        bottom: 22,
        left: 100,
        right: 140,
        width: 40,
        height: 20,
    };
    trigger.classList = new FakeClassList(['tooltip']);
    root.emit('pointerout', { relatedTarget: null });
    root.emit('pointerover', { target: trigger });
    trigger.isConnected = false;
    root.emit('pointerout', { relatedTarget: null });
    root.emit('focusin', { target: trigger });
    component.destroy();
});

test('removes the tooltip description when it is the only identifier', (t) => {
    const { root } = environment(t);
    const trigger = new FakeElement({
        tag: 'button',
        classes: ['tooltip'],
        attributes: { 'data-tip': 'Only' },
    });
    root.append(trigger);
    const component = tableTooltips();
    component.$el = root;
    component.init();
    root.emit('pointerover', { target: trigger });
    trigger.removeAttribute('aria-describedby');
    root.emit('pointerout', { relatedTarget: null });
    assert.equal(trigger.hasAttribute('aria-describedby'), false);
    component.destroy();
});

test('rejects invalid and invisible active triggers', (t) => {
    const { root } = environment(t);
    const trigger = new FakeElement({
        classes: ['tooltip'],
        attributes: { 'data-tip': 'Hidden', disabled: '' },
    });
    root.append(trigger);
    const component = tableTooltips();
    component.$el = root;
    component.init();
    root.emit('pointerover', { target: trigger });
    trigger.removeAttribute('disabled');
    trigger.rect = {
        top: 10,
        bottom: 10,
        left: 10,
        right: 10,
        width: 0,
        height: 0,
    };
    root.emit('pointerout', { relatedTarget: null });
    root.emit('pointerover', { target: trigger });
    trigger.rect = {
        top: 2,
        bottom: 22,
        left: 100,
        right: 140,
        width: 40,
        height: 20,
    };
    root.emit('pointerout', { relatedTarget: null });
    root.emit('pointerover', { target: trigger });
    component.destroy();
});

test('supports nested controls, pre-labelled actions and viewport edge fallbacks', (t) => {
    const { root } = environment(t);
    const labelled = new FakeElement({
        tag: 'button',
        classes: ['tooltip'],
        text: 'Visible',
        attributes: { 'data-tip': 'Ignored', 'aria-label': 'Visible' },
    });
    const trigger = new FakeElement({
        classes: ['tooltip', 'tooltip-left'],
        rect: {
            top: 100,
            bottom: 120,
            left: 2,
            right: 42,
            width: 40,
            height: 20,
        },
        attributes: { 'data-tip': 'Nested' },
    });
    const control = new FakeElement({ tag: 'a' });
    trigger.append(control);
    root.append(labelled);
    root.append(trigger);
    const component = tableTooltips();
    component.$el = root;
    component.init();
    root.emit('pointerover', { target: {} });
    root.emit('pointerover', { target: control });
    assert.match(control.getAttribute('aria-describedby'), /table-tooltip/);
    root.emit('pointerover', { target: control });
    root.emit('pointerout', { relatedTarget: control });
    trigger.classList = new FakeClassList(['tooltip', 'tooltip-right']);
    trigger.rect = {
        top: 100,
        bottom: 120,
        left: 470,
        right: 510,
        width: 40,
        height: 20,
    };
    root.emit('pointerout', { relatedTarget: null });
    root.emit('pointerover', { target: trigger });
    trigger.classList = new FakeClassList(['tooltip', 'tooltip-bottom']);
    trigger.rect = {
        top: 370,
        bottom: 390,
        left: 100,
        right: 140,
        width: 40,
        height: 20,
    };
    root.emit('pointerout', { relatedTarget: null });
    root.emit('pointerover', { target: trigger });
    component.destroy();
});

test('enables keyboard reading only for truly clipped cells and removes owned attributes when they fit', (t) => {
    const env = environment(t);
    const cell = new FakeElement({ attributes: { 'data-table-cell-text': '', 'data-tip': '<img src=x onerror=unsafe>' } });
    cell.scrollWidth = 200;
    env.root.append(cell);
    const component = tableTooltips();
    component.$el = env.root;
    component.init();
    assert.equal(cell.getAttribute('tabindex'), '0');
    env.root.emit('focusin', { target: cell });
    const overlay = env.body.children[0];
    assert.equal(overlay.textContent, '<img src=x onerror=unsafe>');
    assert.equal(overlay.classList.contains('table-tooltip-overlay--rich'), true);
    assert.equal(cell.getAttribute('aria-describedby'), overlay.id);
    cell.scrollWidth = cell.clientWidth;
    env.windowListeners.get('resize')();
    assert.equal(overlay.popover, false);
    assert.equal(cell.hasAttribute('tabindex'), false);
    assert.equal(cell.hasAttribute('aria-describedby'), false);
    component.destroy();
    assert.equal(env.windowListeners.size, 0);
});

test('retargets descriptions after child morphs and avoids redundant cell tab stops', (t) => {
    const env = environment(t);
    const cell = new FakeElement({ attributes: { 'data-table-cell-text': '', 'data-tip': 'Full label' } });
    cell.scrollWidth = 200;
    env.root.append(cell);
    const component = tableTooltips();
    component.$el = env.root;
    component.init();
    const child = new FakeElement({ tag: 'button', attributes: { 'aria-describedby': 'existing' } });
    cell.append(child);
    env.observer()();
    assert.equal(cell.hasAttribute('tabindex'), false);
    env.root.emit('focusin', { target: child });
    const overlay = env.body.children[0];
    assert.equal(child.getAttribute('aria-describedby'), `existing ${overlay.id}`);
    const replacement = new FakeElement({ tag: 'button' });
    cell.children = [];
    child.parentElement = null;
    cell.append(replacement);
    env.observer()();
    env.frame();
    assert.equal(child.getAttribute('aria-describedby'), 'existing');
    assert.equal(replacement.getAttribute('aria-describedby'), overlay.id);
    replacement.setAttribute('disabled', '');
    env.observer()();
    env.frame();
    assert.equal(cell.getAttribute('tabindex'), '0');
    assert.equal(replacement.hasAttribute('aria-describedby'), false);
    component.destroy();
});

test('renders rich parts as safe text, caches unchanged content and forwards Escape', (t) => {
    const env = environment(t);
    const trigger = new FakeElement({
        tag: 'button',
        classes: ['tooltip'],
        attributes: {
            'data-tip': 'Summary',
            'data-tooltip-rich': '',
            'data-tooltip-title': '<script>Title</script>',
            'data-tooltip-description': '<img onerror=unsafe>',
            'data-tooltip-eyebrow': 'Record',
        },
    });
    env.root.append(trigger);
    const component = tableTooltips();
    component.$el = env.root;
    component.init();
    env.root.emit('focusin', { target: trigger });
    const overlay = env.body.children[0];
    assert.deepEqual(
        overlay.children.map((element) => element.textContent),
        ['Record', '<script>Title</script>', '<img onerror=unsafe>'],
    );
    trigger.setAttribute('aria-describedby', 'existing');
    env.frame();
    assert.equal(trigger.getAttribute('aria-describedby'), `existing ${overlay.id}`);
    const first = overlay.children[0];
    env.frame();
    assert.equal(overlay.children[0], first);
    trigger.setAttribute('data-tooltip-description', 'New description');
    env.frame();
    assert.equal(overlay.children[2].textContent, 'New description');
    let prevented = false;
    env.root.emit('keydown', {
        key: 'Escape',
        preventDefault() {
            prevented = true;
        },
    });
    assert.equal(prevented, false);
    assert.equal(overlay.popover, false);
    component.destroy();
});

test('keeps automatically generated action labels current while preserving explicit caller names', (t) => {
    const env = environment(t);
    const button = new FakeElement({ tag: 'button', classes: ['tooltip'], attributes: { 'data-tip': 'Old' } });
    env.root.append(button);
    const component = tableTooltips();
    component.$el = env.root;
    component.init();
    button.setAttribute('data-tip', 'New');
    env.observer()();
    assert.equal(button.getAttribute('aria-label'), 'New');
    button.textContent = 'Visible label';
    env.observer()();
    assert.equal(button.hasAttribute('aria-label'), false);
    button.textContent = '';
    env.observer()();
    button.setAttribute('aria-label', 'Caller name');
    env.observer()();
    assert.equal(button.getAttribute('aria-label'), 'Caller name');
    component.destroy();
    assert.equal(button.getAttribute('aria-label'), 'Caller name');
});

test('tracks descendant and vertical clipping, resize observers and removed cells', (t) => {
    const env = environment(t);
    let resized;
    const removed = [];
    let disconnected = false;
    globalThis.ResizeObserver = class {
        constructor(callback) {
            resized = callback;
        }
        observe() {}
        unobserve(element) {
            removed.push(element);
        }
        disconnect() {
            disconnected = true;
        }
    };
    t.after(() => delete globalThis.ResizeObserver);
    const cell = new FakeElement({ attributes: { 'data-table-cell-text': '', 'data-tip': 'Details' } });
    const content = new FakeElement();
    content.scrollWidth = 200;
    cell.append(content);
    env.root.append(cell);
    const component = tableTooltips();
    component.$el = env.root;
    component.init();
    assert.equal(cell.hasAttribute('data-table-cell-truncated'), true);
    content.clientWidth = 0;
    resized();
    assert.equal(cell.hasAttribute('data-table-cell-truncated'), false);
    cell.scrollHeight = 100;
    resized();
    assert.equal(cell.hasAttribute('data-table-cell-truncated'), true);
    env.root.children = [];
    cell.parentElement = null;
    resized();
    assert.deepEqual(removed, [cell]);
    assert.equal(cell.hasAttribute('tabindex'), false);
    component.destroy();
    assert.equal(disconnected, true);
});

test('preserves caller tab order and respects external changes to managed attributes', (t) => {
    const env = environment(t);
    const cell = new FakeElement({ attributes: { 'data-table-cell-text': '', 'data-tip': 'Details', tabindex: '5' } });
    cell.scrollWidth = 200;
    env.root.append(cell);
    const component = tableTooltips();
    component.$el = env.root;
    component.init();
    cell.scrollWidth = cell.clientWidth;
    env.observer()();
    assert.equal(cell.getAttribute('tabindex'), '5');
    cell.removeAttribute('tabindex');
    cell.scrollWidth = 200;
    env.observer()();
    cell.setAttribute('tabindex', '3');
    const child = new FakeElement({ tag: 'button' });
    cell.append(child);
    env.observer()();
    assert.equal(cell.getAttribute('tabindex'), '3');
    cell.children = [];
    cell.removeAttribute('tabindex');
    env.observer()();
    cell.setAttribute('tabindex', '2');
    cell.scrollWidth = 0;
    env.observer()();
    assert.equal(cell.getAttribute('tabindex'), '2');
    component.destroy();
});

test('falls back to the focused trigger when the hovered trigger moves out of the table', (t) => {
    const env = environment(t);
    const first = new FakeElement({ tag: 'button', classes: ['tooltip'], attributes: { 'data-tip': 'First' } });
    const second = new FakeElement({ tag: 'button', classes: ['tooltip'], attributes: { 'data-tip': 'Second' } });
    env.root.append(first);
    env.root.append(second);
    const component = tableTooltips();
    component.$el = env.root;
    component.init();
    env.root.emit('pointerover', { target: first });
    env.root.emit('focusin', { target: second });
    env.root.children = [second];
    env.body.append(first);
    env.observer()();
    assert.equal(env.body.children[0].textContent, 'Second');
    assert.equal(first.hasAttribute('aria-label'), false);
    second.setAttribute('aria-label', 'Caller');
    env.root.children = [];
    env.body.append(second);
    env.observer()();
    assert.equal(second.getAttribute('aria-label'), 'Caller');
    assert.equal(env.body.children[0].popover, false);
    component.destroy();
});

test('ignores screen reader descriptions and decorative content when detecting visual clipping', (t) => {
    const env = environment(t);
    const cell = new FakeElement({ attributes: { 'data-table-cell-text': '', 'data-tip': 'Short' } });
    const hidden = new FakeElement({ attributes: { 'aria-hidden': 'true' } });
    hidden.scrollWidth = 200;
    cell.append(hidden);
    env.root.append(cell);
    const component = tableTooltips();
    component.$el = env.root;
    component.init();
    assert.equal(cell.hasAttribute('tabindex'), false);
    hidden.removeAttribute('aria-hidden');
    hidden.classList = new FakeClassList(['sr-only']);
    env.observer()();
    assert.equal(cell.hasAttribute('tabindex'), false);
    component.destroy();
});
