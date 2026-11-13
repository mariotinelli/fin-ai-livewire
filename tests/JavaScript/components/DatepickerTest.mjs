import flatpickr from 'flatpickr';
import { test } from 'node:test';
import assert from 'node:assert/strict';
import datepicker from '../../../resources/js/components/datepicker.js';
import { mount } from '../support/component.js';

test('hydrates, synchronizes and opens the date picker', (t) => {
    const pickr = { setDate: t.mock.fn(), open: t.mock.fn(), destroy: t.mock.fn() };
    const factory = t.mock.fn(() => pickr);
    const { component, watchers, wireCalls } = mount(datepicker(true, 'birthday', '2026-09-17', { locale: 'pt' }, factory), {
        $refs: { datepicker: {} },
    });

    component.init();
    component.init();
    watchers.get('model')('2026-09-18');
    component.openCalendar();

    assert.equal(factory.mock.callCount(), 1);
    assert.deepEqual(pickr.setDate.mock.calls[0].arguments, ['2026-09-17', false]);
    assert.deepEqual(wireCalls, [['set', 'birthday', '2026-09-18', true]]);
    assert.equal(pickr.open.mock.callCount(), 1);
    assert.deepEqual(pickr.setDate.mock.calls[1].arguments, ['2026-09-18', false]);
    component.destroy();
    component.destroy();
    assert.equal(pickr.destroy.mock.callCount(), 1);
    watchers.get('model')('2026-09-19');
    assert.equal(wireCalls.length, 1);
});

test('uses the bundled factory and registers the Portuguese locale without a global', () => {
    assert.equal(datepicker(false, 'date', null, {}).model, null);
    assert.equal(flatpickr.l10ns.pt.weekdays.longhand[0], 'Domingo');
    assert.equal(flatpickr.l10ns.pt.months.longhand[8], 'Setembro');
});
