import { test } from 'node:test';
import assert from 'node:assert/strict';
import multiSelect from '../../../resources/js/components/multi-select.js';
import { installWindow, listFixture, mount } from '../support/component.js';

test('does not mutate or open a disabled control including disabled fieldsets', (t) => {
    const { component, wireCalls } = setup(t);
    component.items = [{ id: 1, name: 'One' }];
    component.$refs.button.matches = (selector) => selector === ':disabled';
    component.open = true;
    component.choose(0);
    component.remove(1);
    component.removeAll();
    component.onButtonClick();
    assert.equal(component.open, false);
    assert.deepEqual(wireCalls, []);
});

for (const isLive of [false, true]) {
    test(`forwards live=${isLive} while preserving selected and cleared values`, (t) => {
        const { component, wireCalls } = setup(t);
        component.isLive = isLive;
        component.items = [{ id: 1, name: 'One' }];
        component.selectedItems = [];

        component.choose(0);
        component.remove(1);

        assert.deepEqual(wireCalls, [
            ['set', 'choices', ['1'], isLive],
            ['set', 'choices', [], isLive],
        ]);
    });
}

function setup(t, value = ['1']) {
    const { listeners } = installWindow(t);
    const ul = listFixture();
    const refs = {
        button: {
            focus: t.mock.fn(),
            getBoundingClientRect: () => ({ top: 300, bottom: 580, left: 8, right: 328, width: 320 }),
        },
        selectMultipleBox: {
            style: {},
            getBoundingClientRect: () => ({ top: 20, bottom: 80 }),
        },
        ul,
    };
    const mounted = mount(
        multiSelect({
            items: { 1: 'One', 2: 'Two', 3: 'Three' },
            value,
            wireModel: 'choices',
        }),
        { $refs: refs },
    );
    mounted.component.init();
    return { ...mounted, listeners, refs };
}

test('formats, selects and synchronizes multiple options', (t) => {
    const { component, watchers, wireCalls, listeners } = setup(t);
    assert.deepEqual(component.selectedItems, ['1']);
    assert.equal(component.selected[0].name, 'One');
    assert.equal(component.filteredItems.length, 2);
    assert.equal(component.optionCount, 2);
    component.open = true;
    component.activeIndex = 0;
    assert.match(component.activeDescendant, /option-2/);
    assert.equal(component.active.name, 'Two');
    component.choose(0);
    component.choose(99);
    component.selectedItems = ['2'];
    component.items = [
        { id: 2, name: 'Two' },
        { id: 3, name: 'Three' },
    ];
    component.choose(0);
    let calls = 0;
    const shiftingId = {
        toString() {
            return ++calls === 1 ? 'new' : 'selected';
        },
    };
    component.items = [{ id: shiftingId, name: 'Shifting' }];
    component.selectedItems = ['selected'];
    component.choose(0);
    component.remove(3);
    component.removeAll();
    assert.equal(component.selected[0].id, null);
    component.items = [
        { id: 1, name: 'One' },
        { id: 2, name: 'Two' },
    ];
    component.selectedItems = ['1'];
    assert.equal(component.isSelected(0), true);
    assert.equal(component.isSelected(1), false);
    assert.equal(component.getSelectedNames(), 'One');
    component.remove(1);
    watchers.get('value')([2]);
    watchers.get('value')(null);
    component.open = true;
    listeners.get('scroll')();
    component.destroy();
    watchers.get('value')([1]);
    assert.ok(wireCalls.length >= 4);
});

test('opens, positions and navigates every keyboard boundary', (t) => {
    const { component, refs } = setup(t, []);
    component.checkDropdownPosition();
    assert.equal(component.dropdownUp, true);
    const button = refs.button;
    component.$refs.button = null;
    component.checkDropdownPosition();
    component.$refs.button = button;
    component.onButtonClick();
    component.onButtonClick();
    component.onOptionSelect();
    component.activeIndex = null;
    component.onOptionSelect();
    component.onEscape();
    for (const index of [null, 0, 2, 99]) {
        component.activeIndex = index;
        component.onArrowUp();
        component.activeIndex = index;
        component.onArrowDown();
    }
    refs.ul.children[0].getBoundingClientRect = () => ({ top: 0, bottom: 100 });
    refs.ul.children[1].getBoundingClientRect = () => ({
        top: 30,
        bottom: 100,
    });
    component.selectedItems = [];
    component.items = [
        { id: 1, name: 'One' },
        { id: 2, name: 'Two' },
    ];
    component.activeIndex = 1;
    component.onArrowUp();
    component.activeIndex = 0;
    component.onArrowDown();
    component.selectedItems = ['1', '2', '3'];
    component.onArrowUp();
    component.onArrowDown();
    assert.equal(component.activeIndex, null);
});

test('preserves arrays and initializes an absent value', (t) => {
    installWindow(t);
    const array = [{ id: 1, name: 'One' }];
    const { component } = mount(multiSelect({ items: array, value: null }));
    component.init();
    component.formatItems();
    assert.equal(component.items, array);
});

test('covers closed, downward and destroyed listener boundaries', (t) => {
    const { component, listeners, refs } = setup(t, null);
    const position = listeners.get('resize');
    component.open = false;
    position();
    component.open = true;
    component.activeIndex = null;
    assert.equal(component.activeDescendant, null);
    refs.button.getBoundingClientRect = () => ({ top: 10, bottom: 20, left: 8, right: 328, width: 320 });
    component.checkDropdownPosition();
    assert.equal(component.dropdownUp, false);
    component.$refs.selectMultipleBox = null;
    component.checkDropdownPosition();
    component.destroy();
    position();
});

test('does not run a pending open callback after destruction', (t) => {
    const { component } = setup(t);
    let delayed;
    component.$nextTick = (callback) => (delayed = callback);
    component.onButtonClick();
    component.destroy();
    delayed();
});
