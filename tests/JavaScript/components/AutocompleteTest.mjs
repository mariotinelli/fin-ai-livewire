import { test } from 'node:test';
import assert from 'node:assert/strict';
import autocomplete from '../../../resources/js/components/autocomplete.js';
import { listFixture, mount } from '../support/component.js';

function response(data = [{ id: 1, name: 'One' }], overrides = {}) {
    return {
        ok: true,
        async json() {
            return {
                data,
                meta: { current_page: 1 },
                links: { next: '/options?page=2' },
            };
        },
        ...overrides,
    };
}

function setup() {
    const ul = listFixture();
    return mount(autocomplete({ route: '/options', wireModel: 'city' }), {
        $refs: { ul },
        $el: {},
    });
}

test('loads, deduplicates and appends remote suggestions', async (t) => {
    const calls = [];
    globalThis.fetch = t.mock.fn(async (url) => {
        calls.push(String(url));
        return response(
            calls.length === 1
                ? [
                      { id: 1, name: 'One' },
                      { id: 1, name: 'Duplicate' },
                  ]
                : [{ id: 2, name: 'Two' }],
        );
    });
    const { component } = setup();
    component.value = 'ab';
    await component.getOptions();
    await component.getOptions(2, true);
    await component.getOptions(2, true);
    assert.deepEqual(
        component.items.map(({ id }) => id),
        [1, 2],
    );
    assert.match(calls[0], /search=ab/);
    assert.match(calls[1], /page=2/);
    assert.equal(component.loading, false);
});

test('reports HTTP failures but ignores aborts and stale responses', async (t) => {
    t.mock.method(console, 'error', () => {});
    globalThis.fetch = t.mock.fn(async () => response([], { ok: false, status: 503 }));
    const { component } = setup();
    component.value = 'ab';
    await component.getOptions();
    assert.equal(console.error.mock.callCount(), 1);

    let release;
    globalThis.fetch = t.mock.fn(() => new Promise((resolve) => (release = () => resolve(response()))));
    const pending = component.getOptions();
    component.value = 'changed';
    release();
    await pending;
    assert.deepEqual(component.items, []);

    const aborted = component.getOptions();
    component.destroy();
    release();
    await aborted;
});

test('reacts to typing, selection, focus and keyboard navigation', async (t) => {
    globalThis.fetch = t.mock.fn(async () => response());
    const { component, watchers, wireCalls } = setup();
    component.init();
    watchers.get('value')('a');
    watchers.get('value')('ab');
    await new Promise((resolve) => setImmediate(resolve));
    watchers.get('value')('ab');
    component.onFocus();
    assert.equal(component.activeDescendant, null);
    component.items = [
        { id: 1, name: 'One' },
        { id: 2, name: 'Two' },
    ];
    component.loading = false;
    for (const index of [null, 0, 1]) {
        component.activeIndex = index;
        component.onArrowDown();
        component.onArrowUp();
    }
    component.activeIndex = 0;
    component.onOptionSelect();
    component.onOptionSelect();
    component.choose(null);
    component.close();
    component.focus = false;
    component.close();
    component.onEscape();
    assert.deepEqual(wireCalls.at(-1), ['set', 'city', 'One', false]);
});

for (const isLive of [false, true]) {
    test(`uses live=${isLive} for selection and edited text without duplicate synchronization`, () => {
        const { component, wireCalls } = setup();
        component.isLive = isLive;
        component.items = [{ id: 1, name: 'One' }];
        component.onFocus();
        component.activeIndex = 0;

        component.onOptionSelect();
        component.close();
        assert.deepEqual(wireCalls, [['set', 'city', 'One', isLive]]);

        component.value = 'Edited';
        component.close();
        component.close();
        assert.deepEqual(wireCalls.at(-1), ['set', 'city', 'Edited', isLive]);
        assert.equal(wireCalls.length, 2);
    });
}

test('covers loading, empty and duplicate-request boundaries', async (t) => {
    const { component, watchers, wireCalls } = setup();
    const callbacks = [];
    globalThis.fetch = t.mock.fn(() => new Promise((resolve) => callbacks.push(resolve)));
    component.init();
    component.items = [{ id: 1, name: 'One' }];
    component.open = true;
    component.loading = false;
    component.activeIndex = 0;
    assert.match(component.activeDescendant, /option-1/);
    component.loading = true;
    assert.equal(component.activeDescendant, null);
    component.loading = false;
    component.items = [];
    component.onArrowDown();
    component.onArrowUp();
    component.items = [{ id: 1, name: 'One' }];
    component.loading = true;
    component.onArrowDown();
    component.onArrowUp();
    component.loading = false;
    component.activeIndex = null;
    component.onArrowUp();
    component.activeIndex = 5;
    component.scrollActiveOption();

    watchers.get('value')(undefined);
    component.oldValue = 'same';
    watchers.get('value')('same');
    component.value = 'query';
    const pending = component.getOptions();
    const overlapping = component.getOptions();
    watchers.get('value')('a');
    component.value = 'query';
    const restarted = component.getOptions();
    await component.getOptions(2, true);
    component.loading = false;
    await component.getOptions(2, true);
    callbacks.shift()(response());
    await pending;
    callbacks.shift()(response());
    await overlapping;
    callbacks.shift()(response());
    await restarted;

    component.route = '/options?scope=all';
    component.value = 'other';
    const withQuery = component.getOptions(2);
    callbacks.shift()(response());
    await withQuery;
    component.focus = false;
    component.open = true;
    component.close();
    const callsBeforeNoop = wireCalls.length;
    component.oldValue = component.value;
    component.setWireValue();
    assert.equal(wireCalls.length, callsBeforeNoop);
    component.destroy();
    await component.getOptions();
    watchers.get('value')('destroyed');
    component.scrollActiveOption();
});
