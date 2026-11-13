import { test } from 'node:test';
import assert from 'node:assert/strict';
import notificationCenter from '../../../resources/js/components/notification-center.js';
import { mount } from '../support/component.js';

const node = (id, viewed = 'false') => ({ dataset: { notificationId: id, notificationViewed: viewed }, isConnected: true });

function setup(t, nodes, visible = true) {
    let callback, mutation;
    const timers = [];
    const observer = { observe: t.mock.fn(), unobserve: t.mock.fn(), disconnect: t.mock.fn() };
    const changes = { observe: t.mock.fn(), disconnect: t.mock.fn() };
    globalThis.IntersectionObserver = class {
        constructor(handler) {
            callback = handler;
            return observer;
        }
    };
    globalThis.MutationObserver = class {
        constructor(handler) {
            mutation = handler;
            return changes;
        }
    };
    t.mock.method(globalThis, 'setTimeout', (handler) => {
        timers.push(handler);
        return timers.length;
    });
    t.mock.method(globalThis, 'clearTimeout', () => {});
    t.after(() => {
        delete globalThis.IntersectionObserver;
        delete globalThis.MutationObserver;
    });
    const mounted = mount(notificationCenter(), {
        $el: { querySelectorAll: () => nodes.filter((item) => item.isConnected) },
        $wire: { markViewed: t.mock.fn(async () => true) },
    });
    mounted.component.visible = visible;
    mounted.component.init();
    return { ...mounted, observer, changes, timers, intersect: (entries) => callback(entries), mutate: () => mutation() };
}

const entry = (target, isIntersecting = true, intersectionRatio = 1) => ({ target, isIntersecting, intersectionRatio });

test('batches only intersecting unseen items while open and confirms them once', async (t) => {
    const first = node('one'),
        already = node('already', 'true'),
        second = node('two'),
        missing = node('');
    const { component, watchers, observer, timers, intersect, mutate } = setup(t, [first, already, second, missing], false);
    assert.equal(observer.observe.mock.callCount(), 0);
    intersect([entry(first)]);
    component.visible = true;
    watchers.get('visible')(true);
    intersect([entry(first), entry(first), entry(second, false), entry(second, true, 0), entry(missing)]);
    assert.equal(timers.length, 1);
    mutate();
    timers[0]();
    await new Promise((resolve) => setImmediate(resolve));
    assert.deepEqual(component.$wire.markViewed.mock.calls[0].arguments, [['one']]);
    intersect([entry(first)]);
    await component.flush();
    assert.equal(component.$wire.markViewed.mock.callCount(), 1);
    second.isConnected = false;
    mutate();
    component.destroy();
    assert.equal(observer.disconnect.mock.callCount(), 1);
});

test('does not resend IDs while the acknowledgement is pending or apply DOM work after destroy', async (t) => {
    const first = node('one');
    const { component, intersect, mutate, observer } = setup(t, [first]);
    let release;
    component.$wire.markViewed = t.mock.fn(() => new Promise((resolve) => (release = resolve)));
    intersect([entry(first)]);
    const pending = component.flush();
    intersect([entry(first)]);
    mutate();
    assert.equal(component.$wire.markViewed.mock.callCount(), 1);
    component.destroy();
    release(true);
    await pending;
    const observed = observer.observe.mock.callCount();
    mutate();
    intersect([entry(first)]);
    assert.equal(observer.observe.mock.callCount(), observed);
});

test('suppresses failed batches until reopening and retries validation or network failures', async (t) => {
    const first = node('one');
    const { component, watchers, intersect } = setup(t, [first]);
    component.$wire.markViewed = t.mock.fn(async () => {
        throw new Error('offline');
    });
    intersect([entry(first)]);
    await component.flush();
    intersect([entry(first)]);
    assert.equal(component.$wire.markViewed.mock.callCount(), 1);
    component.visible = false;
    watchers.get('visible')(false);
    component.visible = true;
    watchers.get('visible')(true);
    component.$wire.markViewed = t.mock.fn(async () => false);
    intersect([entry(first)]);
    await component.flush();
    assert.equal(component.$wire.markViewed.mock.callCount(), 1);
    intersect([entry(first)]);
    await component.flush();
    assert.equal(component.$wire.markViewed.mock.callCount(), 1);
});

test('limits each batch and cancels pending exposure when closed', async (t) => {
    const nodes = Array.from({ length: 101 }, (_, index) => node(String(index)));
    const { component, intersect, watchers } = setup(t, nodes);
    intersect(nodes.map((item) => entry(item)));
    await component.flush();
    assert.equal(component.$wire.markViewed.mock.calls[0].arguments[0].length, 100);
    intersect([entry(nodes[100])]);
    component.visible = false;
    watchers.get('visible')(false);
    await component.flush();
    assert.equal(component.$wire.markViewed.mock.callCount(), 1);
    component.visible = true;
    intersect([entry(nodes[100])]);
    component.destroy();
    await component.flush();
    assert.equal(component.$wire.markViewed.mock.callCount(), 1);
});

test('does not infer exposure when the browser lacks IntersectionObserver', async () => {
    const { component } = mount(notificationCenter());
    component.init();
    component.visible = true;
    component.scan();
    await component.flush();
    component.destroy();
});

test('keeps other pending batches protected when an earlier batch completes', async (t) => {
    const first = node('one'),
        second = node('two');
    const { component, intersect } = setup(t, [first, second]);
    const releases = [];
    component.$wire.markViewed = t.mock.fn(() => new Promise((resolve) => releases.push(resolve)));
    intersect([entry(first)]);
    const one = component.flush();
    intersect([entry(second)]);
    const two = component.flush();
    releases[0](true);
    await one;
    intersect([entry(second)]);
    await component.flush();
    assert.equal(component.$wire.markViewed.mock.callCount(), 2);
    releases[1](true);
    await two;
    component.destroy();
});
