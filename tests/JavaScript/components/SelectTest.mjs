import { test } from 'node:test';
import assert from 'node:assert/strict';
import select from '../../../resources/js/components/select.js';
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

function setup(t, items = { 1: 'One', 2: 'Two', 3: 'Three' }) {
    const { listeners } = installWindow(t);
    const ul = listFixture();
    const livewireListeners = new Map();
    const refs = {
        button: {
            focus: t.mock.fn(),
            getBoundingClientRect: () => ({ top: 300, bottom: 580, left: 8, right: 328, width: 320 }),
        },
        selectBox: { children: [1, 2, 3], style: {} },
        ul,
    };
    const mounted = mount(select({ items, wireModel: 'choice' }), {
        $refs: refs,
    });
    mounted.component.$wire.$el = {
        addEventListener(name, callback) {
            livewireListeners.set(name, callback);
        },
        removeEventListener(name, callback) {
            assert.equal(livewireListeners.get(name), callback);
            livewireListeners.delete(name);
        },
    };
    mounted.component.init();
    return { ...mounted, listeners, livewireListeners, refs, ul };
}

test('formats options, reacts to refreshed values and releases listeners', (t) => {
    const { component, watchers, listeners, livewireListeners } = setup(t);
    assert.deepEqual(
        component.items.map(({ id }) => id),
        ['1', '2', '3'],
    );
    component.formatItems();
    watchers.get('value')(null);
    watchers.get('value')('1');
    livewireListeners.get('refresh::options')({
        detail: { model: 'other', options: [] },
    });
    livewireListeners.get('refresh::options')({
        detail: { model: 'choice', options: { 4: 'Four' } },
    });
    component.open = true;
    listeners.get('resize')();
    component.destroy();
    watchers.get('value')(null);
    assert.equal(listeners.size, 0);
    assert.equal(livewireListeners.size, 0);
});

test('selects, clears and exposes the active option', (t) => {
    const { component, wireCalls, refs } = setup(t);
    assert.equal(component.selected.id, null);
    component.value = '2';
    assert.equal(component.selected.name, 'Two');
    component.value = 'missing';
    assert.equal(component.selected.id, null);
    component.open = true;
    component.activeIndex = 0;
    assert.equal(component.active.name, 'One');
    assert.equal(component.activeDescendant, 'options-option-1');
    component.open = false;
    assert.equal(component.activeDescendant, null);
    component.choose(null);
    component.choose(1);
    component.clearable = false;
    component.choose(1);
    component.clearable = true;
    component.choose(1);
    component.remove();
    assert.equal(refs.button.focus.mock.callCount(), 2);
    assert.deepEqual(
        wireCalls.map((call) => call[2]),
        ['2', null, null],
    );
});

test('opens, positions and navigates every keyboard boundary', (t) => {
    const { component, refs } = setup(t);
    component.checkDropdownPosition();
    assert.equal(component.dropdownUp, true);
    const button = refs.button;
    component.$refs.button = null;
    component.checkDropdownPosition();
    component.$refs.button = button;
    component.onButtonClick();
    assert.equal(component.activeIndex, 0);
    component.openList();
    assert.equal(component.activeIndex, null);
    component.selectedIndex = 2;
    component.openList();
    assert.equal(component.activeIndex, 2);
    component.onOptionSelect();
    component.open = true;
    component.onEscape();
    for (const index of [null, 0, 2, 99]) {
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
    assert.equal(component.activeIndex, null);
});

test('covers closed and downward dropdown positions', (t) => {
    const { component, refs, listeners } = setup(t);
    component.open = false;
    listeners.get('resize')();
    component.activeIndex = null;
    assert.equal(component.activeDescendant, null);
    refs.button.getBoundingClientRect = () => ({ top: 10, bottom: 20, left: 8, right: 328, width: 320 });
    component.checkDropdownPosition();
    assert.equal(component.dropdownUp, false);
    component.$refs.selectBox = null;
    component.checkDropdownPosition();
});

test('does not run a pending list callback after destruction', (t) => {
    const { component } = setup(t);
    let delayed;
    component.$nextTick = (callback) => (delayed = callback);
    component.openList();
    component.destroy();
    delayed();
});
