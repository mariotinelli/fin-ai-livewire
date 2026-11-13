import { test } from 'node:test';
import assert from 'node:assert/strict';
import checkboxSelect from '../../../resources/js/components/checkbox-select.js';
import { installWindow, mount } from '../support/component.js';

function setup(t, config = {}) {
    let component;
    t.after(() => component.destroy());
    installWindow(t);
    const mounted = mount(checkboxSelect({ wireModel: 'chosen', ...config }), {
        $refs: { button: { matches: () => false } },
    });
    mounted.component.init();
    component = mounted.component;
    return mounted;
}

test('normalizes local maps searches accents and deduplicates option IDs', (t) => {
    const { component } = setup(t, { items: { 1: 'Ação', 2: 'Outra' } });
    assert.equal(component.filteredItems.length, 2);
    component.search = 'ACAO';
    component.doSearch();
    assert.deepEqual(component.filteredItems, [{ id: '1', name: 'Ação' }]);
    component.items.push({ id: '1', name: 'Duplicate' }, { id: null, name: 'Null' }, { name: 'Missing' });
    assert.equal(component.filteredItems.length, 1);
    assert.equal(component.hasLoaded, true);
    assert.equal(component.loading, false);
});

test('selects only enabled loaded results and preserves choices outside the current filter', (t) => {
    const { component, wireCalls } = setup(t, {
        isLive: true,
        value: ['outside'],
        items: [
            { id: 1, name: 'First' },
            { id: 2, name: 'Second' },
            { id: 3, name: 'Disabled', disabled: true },
        ],
    });
    assert.equal(component.selectionLabel, '1 selecionado');
    assert.equal(component.allFilteredSelected, false);
    assert.equal(component.someFilteredSelected, false);
    component.choose(0);
    assert.equal(component.someFilteredSelected, true);
    component.toggleAll();
    assert.deepEqual(component.selectedItems, ['outside', '1', '2']);
    assert.equal(component.selectionLabel, '3 selecionados');
    assert.equal(component.allFilteredSelected, true);
    assert.equal(component.someFilteredSelected, false);
    component.toggleAll();
    assert.deepEqual(component.selectedItems, ['outside']);
    component.choose(0);
    component.choose(0);
    component.choose(2);
    component.choose(99);
    assert.deepEqual(component.selectedItems, ['outside']);
    assert.deepEqual(wireCalls.at(-1), ['set', 'chosen', ['outside'], true]);
    component.commitSelection([1, '1', 2]);
    assert.deepEqual(component.selectedItems, ['1', '2']);
    component.search = 'First';
    component.toggleAll();
    assert.deepEqual(component.selectedItems, ['2']);
    component.clearSelection();
    assert.equal(component.selectionLabel, component.defaultOptionLabel);
});

test('blocks disabled controls pending or failed requests and empty or unavailable groups', (t) => {
    const { component, wireCalls } = setup(t, { items: [{ id: 1, name: 'One' }] });
    for (const [loading, loadFailed, disabled] of [
        [true, false, false],
        [false, true, false],
        [false, false, true],
    ]) {
        component.loading = loading;
        component.loadFailed = loadFailed;
        component.$refs.button.matches = () => disabled;
        component.choose(0);
        component.toggleAll();
        component.clearSelection();
    }
    assert.deepEqual(wireCalls, []);
    component.loading = false;
    component.loadFailed = false;
    component.$refs = {};
    assert.equal(component.canEdit, true);
    component.$refs.button = {};
    assert.equal(component.canEdit, true);
    component.items = [];
    assert.equal(component.allFilteredSelected, false);
    component.toggleAll();
    assert.deepEqual(component.selectedItems, []);
    component.items = [{ id: 3, name: 'Disabled', disabled: true }];
    assert.equal(component.availableItems.length, 0);
});

test('supports an empty configuration without a request', () => {
    const { component } = mount(checkboxSelect());
    component.loadOptionsWhenReady();
    assert.deepEqual(component.filteredItems, []);
});

test('inherits paginated requests stale response protection and parameter resets', async (t) => {
    const pending = [];
    globalThis.fetch = (url, options) => new Promise((resolve) => pending.push({ url, options, resolve }));
    t.after(() => delete globalThis.fetch);
    const { component } = setup(t, { route: '/options', value: ['9'] });
    assert.equal(pending.length, 1);
    component.search = 'New';
    const current = component.doSearch();
    const response = (data, next = null) => ({ ok: true, json: async () => ({ data, links: { next }, meta: {} }) });
    pending[1].resolve(response([{ id: 1, name: 'New' }], '/options?page=2'));
    await current;
    pending[0].resolve(response([{ id: 99, name: 'Old' }]));
    await new Promise((resolve) => setImmediate(resolve));
    assert.deepEqual(component.items, [{ id: 1, name: 'New' }]);
    component.toggleAll();
    assert.deepEqual(component.selectedItems, ['9', '1']);
    const next = component.loadMore();
    pending[2].resolve(
        response([
            { id: 1, name: 'New' },
            { id: 2, name: 'New second', disabled: true },
        ]),
    );
    await next;
    assert.equal(component.items.length, 2);
    assert.equal(component.availableItems.length, 1);
    const reset = component.syncParams({ region: 2 });
    assert.deepEqual(component.selectedItems, []);
    pending[3].resolve(response([{ id: 3, name: 'Context' }]));
    await reset;
    assert.equal(component.items[0].id, 3);
});
