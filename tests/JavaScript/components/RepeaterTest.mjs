import { test } from 'node:test';
import assert from 'node:assert/strict';
import repeater from '../../../resources/js/components/repeater.js';
import { mount } from '../support/component.js';

test('manages, labels and synchronizes repeated items', (t) => {
    t.mock.method(console, 'log', () => {});
    const { component, watchers, wireCalls } = mount(repeater('contacts', [], { name: '' }));
    component.init();
    assert.equal(component.totalItems, '1 item');
    assert.equal(component.itemTitle(0), 'Item 1');
    component.duplicateItem(0);
    assert.equal(component.totalItems, '2 items');
    watchers.get('items')();
    component.removeItem(0);
    assert.deepEqual(wireCalls, [
        ['set', 'contacts', component.items],
        ['dispatch', 'close-modal', { id: 'repeater-delete-item' }],
    ]);

    const titled = repeater('contacts', [{ name: 'Ana' }], {}, 'name', true);
    assert.equal(titled.itemTitle(0), 'Ana');
});
