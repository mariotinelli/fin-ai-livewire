import { test } from 'node:test';
import assert from 'node:assert/strict';
import { formatQuantity, maskQuantity, pasteQuantity } from '../../../resources/js/components/quantity.js';

const empty = { display: '', value: null };

test('formats canonical and local quantities exactly with three places', () => {
    for (const [input, value] of [
        ['0', '0.000'],
        [0, '0.000'],
        ['00012.3', '12.300'],
        [12.5, '12.500'],
        [' 1.234,567 ', '1234.567'],
        ['12,', '12.000'],
        ['12.', '12.000'],
        ['1234,5', '1234.500'],
        ['9007199254740993123456789.123', '9007199254740993123456789.123'],
    ]) {
        assert.deepEqual(formatQuantity(input), { display: value.replace('.', ','), value });
        assert.deepEqual(pasteQuantity(input), formatQuantity(input));
    }
});

test('rejects excess precision ambiguous grouping unsupported signs and unsafe numbers', () => {
    for (const input of [
        null,
        undefined,
        '',
        ' ',
        '1.2345',
        '1,0001',
        '-1',
        '+1',
        '1e3',
        '1,2,3',
        '12.34,567',
        '<script>',
        'Infinity',
        Infinity,
        NaN,
        Number.MAX_SAFE_INTEGER,
    ]) {
        assert.deepEqual(formatQuantity(input), empty);
        assert.deepEqual(pasteQuantity(input), empty);
    }
});

test('edits a stream of thousandths without converting large integers to floating point', () => {
    for (const [input, value] of [
        ['1', '0.001'],
        ['12', '0.012'],
        ['1234', '1.234'],
        ['0,000', '0.000'],
        [0, '0.000'],
        ['0000123', '0.123'],
        ['9007199254740993123456789123', '9007199254740993123456789.123'],
    ]) {
        assert.deepEqual(maskQuantity(input), { display: value.replace('.', ','), value });
    }
    for (const input of [null, undefined, '', '.,', '-1', 'abc', Infinity, Number.MAX_SAFE_INTEGER])
        assert.deepEqual(maskQuantity(input), empty);
});
