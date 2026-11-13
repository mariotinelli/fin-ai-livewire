import { test } from 'node:test';
import assert from 'node:assert/strict';
import selectSearch from '../../../resources/js/components/select-search.js';
import { installWindow, listFixture, mount } from '../support/component.js';

test('does not mutate or open a disabled control including disabled fieldsets', (t) => {
    const { component, wireCalls } = setup(t);
    component.items = [{ id: 1, name: 'One' }];
    component.$refs.button.matches = (selector) => selector === ':disabled';
    component.open = true;
    component.choose(0);
    component.remove();

    component.openList();
    assert.equal(component.open, false);
    assert.deepEqual(wireCalls, []);
});

test('cancels a hidden lazy request when the external selection changes', async (t) => {
    const pending = [];
    globalThis.fetch = t.mock.fn((url, options) => new Promise((resolve) => pending.push({ resolve, signal: options.signal })));
    const { component, watchers } = setup(t, { loadOnOpen: true });
    component.init();
    component.openList();
    component.onEscape();
    component.value = 2;
    watchers.get('value')(component.value);
    assert.equal(pending[0].signal.aborted, true);
    assert.equal(component.loading, false);
    pending[0].resolve(payload([{ id: 1, name: 'Stale' }]));
    await new Promise((resolve) => setImmediate(resolve));
    assert.deepEqual(component.items, []);
    component.openList();
    pending[1].resolve(payload([{ id: 2, name: 'Current' }]));
    await new Promise((resolve) => setImmediate(resolve));
    assert.deepEqual(component.items, [{ id: 2, name: 'Current' }]);
});

test('does not repeat pending or failed lazy requests when reopening', async (t) => {
    t.mock.method(console, 'error', () => {});
    const { component } = setup(t, { loadOnOpen: true });
    let release;
    globalThis.fetch = t.mock.fn(
        () =>
            new Promise((resolve) => {
                release = resolve;
            }),
    );
    component.init();
    component.openList();
    component.openList();
    component.openList();
    assert.equal(fetch.mock.callCount(), 1);
    release({ ok: false, status: 503 });
    await new Promise((resolve) => setImmediate(resolve));
    component.openList();
    component.openList();
    assert.equal(fetch.mock.callCount(), 1);
    assert.equal(component.loadFailed, true);
});

test('moves keyboard focus to recovery when a request failed', (t) => {
    const { component, refs } = setup(t);
    const focus = t.mock.fn();
    refs.retryButton = { focus };
    component.loadFailed = true;
    component.selectSearchFocus();
    assert.equal(focus.mock.callCount(), 1);
    delete refs.retryButton;
    component.selectSearchFocus();
    assert.equal(focus.mock.callCount(), 1);
});

test('waits until opening and distinguishes initial loading from a successful empty response', async (t) => {
    globalThis.fetch = t.mock.fn(async () => payload([]));
    const { component } = setup(t, { loadOnOpen: true, value: 1, initialValue: 'Initial label' });
    component.init();
    assert.equal(fetch.mock.callCount(), 0);
    assert.equal(component.loading, false);
    assert.equal(component.showEmptyOptions, false);
    assert.equal(component.selected.name, 'Initial label');
    component.openList();
    assert.equal(component.loading, true);
    assert.equal(component.showEmptyOptions, false);
    await new Promise((resolve) => setImmediate(resolve));
    assert.equal(component.hasLoaded, true);
    assert.equal(component.showEmptyOptions, true);
    component.openList();
    component.openList();
    assert.equal(fetch.mock.callCount(), 1);
    component.destroy();
    component.loadOptionsWhenReady();
    assert.equal(fetch.mock.callCount(), 1);
});

for (const failure of ['http', 'network', 'json']) {
    test(`recovers from ${failure} without reporting empty results or changing selection`, async (t) => {
        t.mock.method(console, 'error', () => {});
        const { component, wireCalls } = setup(t, { value: 1, params: { region: 'A' } });
        globalThis.fetch = t.mock.fn(async () => {
            if (failure === 'network') throw new TypeError('Network unavailable');
            if (failure === 'json')
                return {
                    ok: true,
                    json: async () => {
                        throw new SyntaxError('Invalid JSON');
                    },
                };
            return { ok: false, status: 503 };
        });
        await component.getOptions();
        assert.equal(component.loadFailed, true);
        assert.equal(component.hasLoaded, false);
        assert.equal(component.showEmptyOptions, false);
        assert.deepEqual(component.value, 1);
        globalThis.fetch = t.mock.fn(async () => payload());
        await component.retryLoading();
        assert.equal(component.loadFailed, false);
        assert.equal(component.hasLoaded, true);
        assert.equal(component.items.length, 1);
        assert.deepEqual(component.value, 1);
        assert.deepEqual(wireCalls, []);
        assert.match(fetch.mock.calls[0].arguments[0], /region=A/);
        await component.retryLoading();
        assert.equal(fetch.mock.callCount(), 1);
    });
}

test('retries only the failed page and blocks automatic and concurrent retry requests', async (t) => {
    t.mock.method(console, 'error', () => {});
    const { component } = setup(t);
    globalThis.fetch = t.mock.fn(async () => payload());
    await component.getOptions();
    globalThis.fetch = t.mock.fn(async () => ({ ok: false, status: 503 }));
    await component.getOptions(2, true);
    assert.equal(component.loadFailed, true);
    assert.deepEqual(component.items, [{ id: 1, name: 'One' }]);
    await component.infinityScroll();
    await component.loadMore();
    assert.equal(fetch.mock.callCount(), 1);
    let release;
    globalThis.fetch = t.mock.fn(
        () =>
            new Promise((resolve) => {
                release = resolve;
            }),
    );
    const retry = component.retryLoading();
    await component.retryLoading();
    assert.equal(fetch.mock.callCount(), 1);
    assert.equal(component.showEmptyOptions, false);
    release(payload([{ id: 2, name: 'Two' }]));
    await retry;
    assert.deepEqual(
        component.items.map((item) => item.id),
        [1, 2],
    );
    assert.equal(component.loadFailed, false);
    assert.match(fetch.mock.calls[0].arguments[0], /page=2/);
});

test('drops failures from old contexts and invalidates retry after a context change or destruction', async (t) => {
    t.mock.method(console, 'error', () => {});
    const { component } = setup(t, { loadOnOpen: true, params: { region: 'A' } });
    component.init();
    let reject;
    globalThis.fetch = t.mock.fn(
        () =>
            new Promise((resolve, fail) => {
                reject = fail;
            }),
    );
    const outdated = component.getOptions();
    component.params.region = 'B';
    reject(new TypeError('Old failure'));
    await outdated;
    assert.equal(component.loadFailed, false);
    assert.equal(console.error.mock.callCount(), 0);
    globalThis.fetch = t.mock.fn(async () => ({ ok: false, status: 500 }));
    await component.getOptions();
    component.params.region = 'C';
    await component.retryLoading();
    assert.equal(fetch.mock.callCount(), 1);
    await component.syncParams({ region: 'C' });
    assert.equal(component.loadFailed, false);
    assert.equal(component.hasLoaded, false);
    assert.equal(component.showEmptyOptions, false);
    await component.getOptions();
    component.destroy();
    await component.retryLoading();
    assert.equal(fetch.mock.callCount(), 2);
});

for (const isLive of [false, true]) {
    test(`parameter changes clear selection and pagination once with live=${isLive}`, async (t) => {
        globalThis.fetch = t.mock.fn(async () => payload());
        const { component, watchers, wireCalls } = setup(t, {
            value: 1,
            isLive,
            paramBindings: { state: 'address.state' },
        });
        component.init();
        await component.getOptions();
        assert.equal(fetch.mock.callCount(), 0);

        await component.syncParams({ state: 1 });
        assert.deepEqual(component.value, 1);
        assert.deepEqual(wireCalls, []);
        await component.syncParams({ state: 1 });
        assert.equal(fetch.mock.callCount(), 1);

        component.search = 'Old search';
        component.activeIndex = 0;
        component.open = true;
        component.data = { meta: { current_page: 5 }, links: { next: '/options?page=6' } };
        const changed = component.syncParams({ state: 2 });
        assert.deepEqual(component.items, []);
        assert.equal(component.data.links.next, null);
        assert.equal(component.data.meta.current_page, null);
        assert.equal(component.search, null);
        assert.equal(component.activeIndex, null);
        assert.equal(component.open, false);
        watchers.get('value')(null);
        await changed;
        assert.deepEqual(component.value, null);
        assert.deepEqual(wireCalls, [['set', 'choice', null, isLive]]);
        assert.equal(fetch.mock.callCount(), 2);
        assert.equal(new URL(fetch.mock.calls[1].arguments[0], 'https://test.local').searchParams.has('selected[]'), false);

        await watchers.get('params')({ state: 3 });
        assert.equal(fetch.mock.callCount(), 3);
        assert.equal(wireCalls.length, 1);
        component.destroy();
        await component.syncParams({ state: 4 });
        assert.equal(fetch.mock.callCount(), 3);
    });
}

test('keeps encoded parameters distinct from selection search and pagination controls', async (t) => {
    const calls = [];
    globalThis.fetch = t.mock.fn(async (url) => {
        calls.push(String(url));
        return payload();
    });
    const { component } = setup(t, {
        route: '/options?fixed=kept&region=old&page=9&selected[]=old&search=old',
        value: 'A&B',
        params: {
            region: 'São Paulo & x=1',
            zero: 0,
            enabled: false,
            none: null,
            absent: undefined,
            empty: '',
            groups: [1, 2],
            page: 99,
            selected: 'bad',
            'selected[]': 'bad',
            selectedColumn: 'bad',
            search: 'bad',
        },
    });
    component.search = 'name & other';
    await component.getOptions();
    const first = new URL(calls[0], 'https://test.local').searchParams;
    assert.equal(first.get('fixed'), 'kept');
    assert.equal(first.get('region'), 'São Paulo & x=1');
    assert.equal(first.get('zero'), '0');
    assert.equal(first.get('enabled'), 'false');
    for (const name of ['none', 'absent', 'empty', 'page']) assert.equal(first.has(name), false);
    assert.deepEqual(first.getAll('groups[]'), ['1', '2']);
    assert.deepEqual(first.getAll('selected[]'), ['A&B']);
    assert.equal(first.get('selectedColumn'), 'uuid');
    assert.equal(first.get('search'), 'name & other');
    await component.getOptions(2, true);
    const second = new URL(calls[1], 'https://test.local').searchParams;
    assert.equal(second.get('page'), '2');
    assert.equal(second.get('region'), 'São Paulo & x=1');
    assert.deepEqual(second.getAll('selected[]'), ['A&B']);
});

test('ignores an old page after parameters change and ignores responses after destruction', async (t) => {
    const { component } = setup(t, { value: null });
    globalThis.fetch = t.mock.fn(async () => payload());
    await component.syncParams({ state: 1 });
    const pending = [];
    globalThis.fetch = t.mock.fn((url, options) => new Promise((resolve) => pending.push({ resolve, signal: options.signal })));
    const oldPage = component.getOptions(2, true);
    const current = component.syncParams({ state: 2 });
    assert.equal(pending[0].signal.aborted, true);
    pending[1].resolve(payload([{ id: 20, name: 'Current' }]));
    await current;
    pending[0].resolve(payload([{ id: 10, name: 'Old' }]));
    await oldPage;
    assert.deepEqual(component.items, [{ id: 20, name: 'Current' }]);
    assert.equal(component.loading, false);

    const afterDestroy = component.syncParams({ state: 3 });
    component.destroy();
    pending[2].resolve(payload([{ id: 30, name: 'Destroyed' }]));
    await afterDestroy;
    assert.deepEqual(component.items, []);
});

test('rejects a response when reactive parameters changed before the watcher runs', async (t) => {
    const { component } = setup(t, { params: { state: 1 } });
    let resolve;
    globalThis.fetch = t.mock.fn(
        () =>
            new Promise((done) => {
                resolve = done;
            }),
    );
    const pending = component.getOptions();
    component.params.state = 2;
    resolve(payload([{ id: 1, name: 'Outdated' }]));
    await pending;
    assert.deepEqual(component.items, []);
});

for (const isLive of [false, true]) {
    test(`forwards live=${isLive} while preserving selected and cleared values`, (t) => {
        const { component, wireCalls } = setup(t);
        component.isLive = isLive;
        component.items = [{ id: 1, name: 'One' }];
        component.selectedIndex = null;

        component.choose(0);
        component.remove();

        assert.deepEqual(wireCalls, [
            ['set', 'choice', 1, isLive],
            ['set', 'choice', null, isLive],
        ]);
    });
}

const payload = (data = [{ id: 1, name: 'One' }], next = '/next') => ({
    ok: true,
    async json() {
        return { data, meta: { current_page: 1 }, links: { next } };
    },
});

function setup(t, overrides = {}) {
    const { listeners } = installWindow(t);
    const ul = listFixture();
    const refs = {
        ul,
        search: { focus: t.mock.fn() },
        searchBox: { style: {} },
        button: {
            focus: t.mock.fn(),
            getBoundingClientRect: () => ({ top: 300, bottom: 580, left: 8, right: 328, width: 320 }),
        },
    };
    const mounted = mount(
        selectSearch({
            route: '/options',
            selectedColumn: 'uuid',
            wireModel: 'choice',
            ...overrides,
        }),
        { $refs: refs },
    );
    mounted.component.element = mounted.component.$el;
    return { ...mounted, refs, listeners };
}

test('loads an external value outside the current search without updating the model', async (t) => {
    globalThis.fetch = t.mock.fn(async () => payload());
    const { component, watchers, wireCalls } = setup(t);
    component.init();
    await new Promise((resolve) => setImmediate(resolve));
    component.search = 'Previous filter';
    component.value = 3;
    globalThis.fetch = t.mock.fn(async () => payload([{ id: 3, name: 'Three' }]));

    watchers.get('value')(3);
    await new Promise((resolve) => setImmediate(resolve));

    assert.equal(component.selected.name, 'Three');
    assert.equal(component.search, null);
    assert.equal(fetch.mock.callCount(), 1);
    assert.deepEqual(wireCalls, []);
});

test('loads, appends and searches remote options', async (t) => {
    const calls = [];
    globalThis.fetch = t.mock.fn(async (url) => {
        calls.push(String(url));
        return payload(
            calls.length === 1
                ? [
                      { id: 1, name: 'One' },
                      { id: 1, name: 'Duplicate' },
                  ]
                : [{ id: 2, name: 'Two' }],
        );
    });
    const { component } = setup(t);
    component.search = 'abc';
    component.value = 1;
    await component.getOptions();
    await component.getOptions(2, true);
    await component.getOptions(2, true);
    component.loading = false;
    component.$refs.ul.scrollTop = 150;
    await component.infinityScroll();
    component.withInfinityScroll = false;
    await component.infinityScroll();
    await component.loadMore();
    component.withInfinityScroll = true;
    component.data.links.next = null;
    await component.loadMore();
    await component.doSearch();
    assert.ok(calls.some((url) => url.includes('selectedColumn=uuid')));
    assert.ok(component.items.length > 0);
});

test('handles failures, stale requests, watchers and destruction', async (t) => {
    t.mock.method(console, 'error', () => {});
    globalThis.fetch = t.mock.fn(async () => ({ ok: false, status: 500 }));
    const { component, watchers, listeners } = setup(t);
    await component.getOptions();
    assert.equal(console.error.mock.callCount(), 1);
    globalThis.fetch = t.mock.fn(async () => payload());
    component.init();
    watchers.get('value')(null);
    await new Promise((resolve) => setImmediate(resolve));
    watchers.get('value')(1);
    component.items = [{ id: 1, name: 'One' }];
    watchers.get('value')(1);
    component.open = true;
    listeners.get('resize')();
    component.destroy();
    watchers.get('value')(null);
    await component.getOptions();
    await component.doSearch();
    assert.equal(listeners.size, 0);
});

test('exposes selection states and performs real selection actions', (t) => {
    globalThis.fetch = t.mock.fn(async () => payload());
    const { component, wireCalls } = setup(t);
    assert.equal(component.selected.id, null);
    component.value = 1;
    component.loading = true;
    component.initialValue = 'Initial';
    assert.equal(component.selected.name, 'Initial');
    component.initialValue = null;
    component.selectedItem = { id: 1, name: 'Remembered' };
    assert.equal(component.selected.name, 'Remembered');
    component.loading = false;
    component.items = [
        { id: 1, name: 'One' },
        { id: 2, name: 'Two' },
    ];
    assert.equal(component.optionCount, 2);
    assert.equal(component.selected.name, 'One');
    component.value = 9;
    assert.equal(component.selected.name, 'One');
    component.selectedItem = null;
    assert.equal(component.selected.id, 9);
    component.choose(null);
    component.choose(0);
    component.forceUpdate();
    component.remove();
    component.resetState();
    assert.ok(wireCalls.length >= 2);
});

test('opens, positions and navigates keyboard boundaries', (t) => {
    globalThis.fetch = t.mock.fn(async () => payload());
    const { component, refs } = setup(t, { withSearch: true });
    component.items = [
        { id: 1, name: 'One' },
        { id: 2, name: 'Two' },
    ];
    component.selectedItem = { id: 2, name: 'Two' };
    component.checkDropdownPosition();
    assert.equal(component.dropdownUp, true);
    const button = refs.button;
    component.$refs.button = null;
    component.checkDropdownPosition();
    component.$refs.button = button;
    component.openList();
    component.openList();
    component.withSearch = false;
    component.selectedItem = null;
    component.openList();
    component.selectedItem = { id: 2, name: 'Two' };
    component.selectSearchFocus();
    component.selectedItem = null;
    component.selectSearchFocus();
    component.open = true;
    component.activeIndex = 0;
    assert.match(component.activeDescendant, /option/);
    component.onOptionSelect();
    component.activeIndex = null;
    component.onOptionSelect();
    component.onEscape();
    for (const index of [null, 0, 1, 99]) {
        component.activeIndex = index;
        component.onArrowUp();
        component.activeIndex = index;
        component.onArrowDown();
    }
    refs.ul.children[1].getBoundingClientRect = () => ({
        top: 30,
        bottom: 100,
    });
    component.activeIndex = 0;
    component.onArrowDown();
    component.items = [];
    component.onArrowUp();
    component.onArrowDown();
    component.scrollToActiveItem();
});

test('covers empty search, scrolling and dropdown boundaries', async (t) => {
    const { component, refs, listeners } = setup(t, { value: null });
    globalThis.fetch = t.mock.fn(async () => payload([], null));
    assert.equal(component.activeDescendant, null);
    await component.getOptions();
    component.loading = false;
    await component.doSearch();
    assert.equal(component.activeIndex, null);
    component.data.links.next = '/next';
    refs.ul.scrollTop = 0;
    await component.infinityScroll();
    component.loading = true;
    await component.infinityScroll();
    component.loading = false;
    const ul = component.$refs.ul;
    component.$refs.ul = null;
    await component.infinityScroll();
    component.$refs.ul = ul;
    refs.button.getBoundingClientRect = () => ({ top: 10, bottom: 20, left: 8, right: 328, width: 320 });
    component.checkDropdownPosition();
    assert.equal(component.dropdownUp, false);
    component.init();
    await new Promise((resolve) => setImmediate(resolve));
    const position = listeners.get('resize');
    component.destroy();
    position();
});

test('covers fallback labels, query separators and destroyed callbacks', async (t) => {
    const { component } = setup(t, {
        route: '/options?scope=all',
        value: 1,
        initialValue: null,
        defaultOptionLabel: null,
    });
    component.loading = true;
    component.selectedItem = null;
    assert.equal(component.selected.name, 'Selecione uma opção');
    globalThis.fetch = t.mock.fn(async () => payload());
    await component.getOptions(2);
    let nextTick;
    component.$nextTick = (callback) => (nextTick = callback);
    component.openList();
    component.init = () => {};
    component.destroy = () => {};
    // Exercise the callback's destroyed guard with a separate initialized instance.
    const second = setup(t);
    globalThis.fetch = t.mock.fn(() => new Promise(() => {}));
    second.component.init();
    let delayed;
    second.component.$nextTick = (callback) => (delayed = callback);
    second.component.openList();
    second.component.destroy();
    delayed();
    assert.equal(typeof nextTick, 'function');
});
