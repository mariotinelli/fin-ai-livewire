import { test } from 'node:test';
import assert from 'node:assert/strict';
import { sidebarGroup, sidebarContext, sidebarLayout } from '../../../resources/js/components/sidebar.js';
import { mount } from '../support/component.js';

function storage(t, entries = []) {
    const values = new Map(entries);
    globalThis.sessionStorage = {
        getItem: (key) => values.get(key) ?? null,
        setItem: (key, value) => values.set(key, value),
    };
    t.after(() => delete globalThis.sessionStorage);
    return values;
}

test('keeps desktop preference across tablet and mobile boundaries and closes the mobile overlay', (t) => {
    const values = new Map();
    globalThis.window = { innerWidth: 1440 };
    globalThis.localStorage = {
        getItem: (key) => values.get(key) ?? null,
        setItem: (key, value) => values.set(key, value),
    };
    t.after(() => {
        delete globalThis.window;
        delete globalThis.localStorage;
    });
    const layout = sidebarLayout();
    layout.init();
    assert.equal(layout.asideOpen, true);
    layout.toggleSidebar();
    assert.equal(values.get('asideOpen'), 'false');
    for (const width of [1024, 768, 767, 768, 1024, 1025]) {
        window.innerWidth = width;
        layout.mobileAsideOpen = true;
        layout.resize();
        assert.equal(layout.asideOpen, false);
        assert.equal(layout.mobileAsideOpen, width < 768);
    }
    layout.toggleSidebar();
    window.innerWidth = 1024;
    layout.resize();
    assert.equal(layout.asideOpen, false);
    assert.equal(values.get('asideOpen'), 'true');
    window.innerWidth = 1025;
    layout.resize();
    assert.equal(layout.asideOpen, true);
    const restored = sidebarLayout();
    restored.init();
    assert.equal(restored.asideOpen, true);
    layout.toggleSidebar();
    restored.init();
    assert.equal(restored.asideOpen, false);
});

test('allows opening and closing navigation without browser storage', (t) => {
    globalThis.window = { innerWidth: 1025 };
    globalThis.localStorage = {
        getItem() {
            throw new Error('blocked');
        },
        setItem() {
            throw new Error('blocked');
        },
    };
    t.after(() => {
        delete globalThis.window;
        delete globalThis.localStorage;
    });
    const layout = sidebarLayout();
    layout.init();
    assert.equal(layout.asideOpen, true);
    layout.toggleSidebar();
    assert.equal(layout.asideOpen, false);
    layout.toggleSidebar();
    assert.equal(layout.asideOpen, true);
});

test('remembers independent groups and synchronizes desktop with mobile', (t) => {
    const values = storage(t, [['user-1-group', 'false']]);
    const events = [];
    const { component } = mount(sidebarGroup('user-1-group'), {
        $el: { querySelector: () => null },
        $dispatch: (...args) => events.push(args),
    });
    component.init();
    assert.equal(component.expanded, false);
    component.toggle();
    assert.equal(component.expanded, true);
    assert.equal(values.get('user-1-group'), 'true');
    assert.deepEqual(events, [['sidebar-group-changed', { key: 'user-1-group', expanded: true }]]);
    component.sync({ key: 'user-2-group', expanded: false });
    assert.equal(component.expanded, true);
    component.sync({ key: 'user-1-group', expanded: false });
    assert.equal(component.expanded, false);
});

test('opens the active group despite a collapsed preference without modifying siblings', (t) => {
    const values = storage(t, [
        ['active', 'false'],
        ['sibling', 'false'],
    ]);
    const active = mount(sidebarGroup('active'), { $el: { querySelector: () => ({}) } }).component;
    active.init();
    assert.equal(active.expanded, true);
    const sibling = mount(sidebarGroup('sibling'), { $el: { querySelector: () => null } }).component;
    sibling.init();
    assert.equal(sibling.expanded, false);
    assert.equal(values.get('sibling'), 'false');
});

test('uses defaults and remains interactive when storage is blocked', (t) => {
    storage(t);
    sessionStorage.getItem = () => {
        throw new Error('blocked');
    };
    sessionStorage.setItem = () => {
        throw new Error('blocked');
    };
    const { component } = mount(sidebarGroup('group', false), {
        $el: { querySelector: () => null },
        $dispatch() {},
    });
    component.init();
    assert.equal(component.expanded, false);
    component.toggle();
    assert.equal(component.expanded, true);
});

function scroller(key, rect = null, height = 200) {
    return mount(sidebarContext(key), {
        $el: {
            clientHeight: height,
            scrollTop: 0,
            querySelector: () => (rect ? { getBoundingClientRect: () => rect } : null),
            getBoundingClientRect: () => ({ top: 100, bottom: 300 }),
        },
    });
}

test('restores scroll per user and viewport on initialization and visibility changes', (t) => {
    const values = storage(t, [
        ['user-desktop', '150'],
        ['user-mobile', '40'],
    ]);
    const { component, watchers } = scroller('user-desktop');
    component.init();
    assert.equal(component.$el.scrollTop, 150);
    component.$el.scrollTop = 170;
    component.save();
    assert.equal(values.get('user-desktop'), '170');
    watchers.get('mobileAsideOpen')();
    watchers.get('asideOpen')();
    assert.equal(component.$el.scrollTop, 170);
    const mobile = scroller('user-mobile').component;
    mobile.restore();
    assert.equal(mobile.$el.scrollTop, 40);
    const hidden = scroller('user-desktop', null, 0).component;
    hidden.restore();
    hidden.save();
    assert.equal(values.get('user-desktop'), '170');
});

test('moves only the sidebar enough to reveal an active item above or below its viewport', (t) => {
    storage(t, [['scroll', '150']]);
    for (const [rect, expected] of [
        [{ top: 80, bottom: 110 }, 130],
        [{ top: 290, bottom: 330 }, 180],
        [{ top: 150, bottom: 180 }, 150],
    ]) {
        const { component } = scroller('scroll', rect);
        component.restore();
        assert.equal(component.$el.scrollTop, expected);
    }
});

test('ignores invalid scroll state and handles a page without an active link', (t) => {
    storage(t);
    for (const value of [null, '-2', 'invalid', 'Infinity']) {
        sessionStorage.getItem = () => value;
        const { component } = scroller('scroll');
        component.restore();
        assert.equal(component.$el.scrollTop, 0);
    }
});
