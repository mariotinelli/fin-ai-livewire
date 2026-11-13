import assert from 'node:assert/strict';

export function mount(definition, overrides = {}) {
    const watchers = new Map();
    const wireCalls = [];
    const component = Object.assign(definition, {
        $watch(name, callback) {
            watchers.set(name, callback);
        },
        $nextTick(callback) {
            callback();
        },
        $wire: {
            set(...args) {
                wireCalls.push(['set', ...args]);
            },
            dispatch(...args) {
                wireCalls.push(['dispatch', ...args]);
            },
        },
        $refs: {},
        $el: { offsetWidth: 320 },
        ...overrides,
    });

    return { component, watchers, wireCalls };
}

export function installWindow(t) {
    const listeners = new Map();
    const window = {
        innerHeight: 600,
        innerWidth: 1024,
        addEventListener(name, callback) {
            listeners.set(name, callback);
        },
        removeEventListener(name, callback) {
            assert.equal(listeners.get(name), callback);
            listeners.delete(name);
        },
    };
    t.mock.method(globalThis, 'setTimeout', (callback) => {
        callback();
        return 1;
    });
    globalThis.window = window;
    t.after(() => delete globalThis.window);
    return { listeners, window };
}

export function listFixture(count = 3) {
    const elements = Array.from({ length: count }, (_, index) => ({
        scrollIntoView() {},
        getBoundingClientRect() {
            return { top: index * 30, bottom: index * 30 + 20 };
        },
    }));
    return {
        id: 'options',
        children: elements,
        scrollTop: 0,
        scrollHeight: 200,
        clientHeight: 60,
        focus() {},
        querySelectorAll() {
            return elements;
        },
        getBoundingClientRect() {
            return { top: 20, bottom: 80 };
        },
    };
}
