import assert from 'node:assert/strict';
import test from 'node:test';
import { formatPercentage, maskPercentage, normalizeDecimalPlaces, pastePercentage } from '../../../resources/js/components/percentage.js';

test('normalizes unsupported precision safely', () => {
    assert.equal(normalizeDecimalPlaces(), 0);
    assert.equal(normalizeDecimalPlaces(0), 0);
    assert.equal(normalizeDecimalPlaces(-2), 0);
    assert.equal(normalizeDecimalPlaces('3.9'), 3);
    assert.equal(normalizeDecimalPlaces(100), 10);
    assert.equal(normalizeDecimalPlaces('invalid'), 0);
});

test('uses the documented default precision and bounds', () => {
    assert.deepEqual(formatPercentage(12.5), { display: '12,50', value: '12.50' });
    assert.deepEqual(maskPercentage('125'), { display: '1,25', value: '1.25' });
    assert.deepEqual(pastePercentage('12,5'), { display: '12,50', value: '12.50' });
});

test('expands finite exponential numbers before exact decimal rounding', () => {
    assert.deepEqual(formatPercentage('1e3', 2, null, null), { display: '1000,00', value: '1000.00' });
    assert.deepEqual(formatPercentage('1e+3', 0, null, null), { display: '1000', value: '1000' });
    assert.deepEqual(formatPercentage('1.2e-3', 4, null, null), { display: '0,0012', value: '0.0012' });
    assert.deepEqual(formatPercentage('1.2e1', 2, null, null), { display: '12,00', value: '12.00' });
    assert.deepEqual(formatPercentage('12e-1', 2, null, null), { display: '1,20', value: '1.20' });
    assert.deepEqual(formatPercentage('-12e-3', 4, null, null), { display: '-0,0120', value: '-0.0120' });
    assert.deepEqual(formatPercentage(Number.NaN, 2), { display: '', value: null });
    assert.deepEqual(formatPercentage(Number.POSITIVE_INFINITY, 2), { display: '', value: null });
});

test('handles every empty localized and one-sided-bound parsing branch', () => {
    assert.deepEqual(formatPercentage(undefined, 2), { display: '', value: null });
    assert.deepEqual(formatPercentage('', 2), { display: '', value: null });
    assert.deepEqual(formatPercentage('   ', 2), { display: '', value: null });
    assert.deepEqual(formatPercentage('1,234.56', 2, null, null), { display: '1234,56', value: '1234.56' });
    assert.deepEqual(formatPercentage('12.344', 2, null, null), { display: '12,34', value: '12.34' });
    assert.deepEqual(formatPercentage('-0', 2, null, null), { display: '0,00', value: '0.00' });
    assert.deepEqual(formatPercentage(20, 2, null, 10), { display: '10,00', value: '10.00' });
    assert.deepEqual(formatPercentage(-20, 2, -10, null), { display: '-10,00', value: '-10.00' });
});

for (const [value, decimalPlaces, expected] of [
    [12.5, 2, { display: '12,50', value: '12.50' }],
    [0, 2, { display: '0,00', value: '0.00' }],
    [-12.5, 2, { display: '-12,50', value: '-12.50' }],
    ['12,345', 2, { display: '12,35', value: '12.35' }],
    ['-12.345', 2, { display: '-12,35', value: '-12.35' }],
    ['12.5', 0, { display: '13', value: '13' }],
    ['-2.5', 0, { display: '-3', value: '-3' }],
    ['invalid', 2, { display: '', value: null }],
    [null, 2, { display: '', value: null }],
]) {
    test(`formats hydrated percentage ${String(value)} at precision ${decimalPlaces}`, () => {
        assert.deepEqual(formatPercentage(value, decimalPlaces, -100, 100), expected);
    });
}

test('constrains values to inclusive ordered bounds', () => {
    assert.deepEqual(formatPercentage(101, 2, 0, 100), { display: '100,00', value: '100.00' });
    assert.deepEqual(formatPercentage(-1, 2, 0, 100), { display: '0,00', value: '0.00' });
    assert.deepEqual(formatPercentage(9, 0, 10, -10), { display: '9', value: '9' });
});

test('masks typed digits at the selected precision including zero and negatives', () => {
    assert.deepEqual(maskPercentage('125', 2, -100, 100), { display: '1,25', value: '1.25' });
    assert.deepEqual(maskPercentage('-125', 2, -100, 100), { display: '-1,25', value: '-1.25' });
    assert.deepEqual(maskPercentage('0', 0, -100, 100), { display: '0', value: '0' });
    assert.deepEqual(maskPercentage('', 2, -100, 100), { display: '', value: null });
    assert.deepEqual(maskPercentage('-', 2, -100, 100), { display: '-', value: null });
    assert.deepEqual(maskPercentage(null, 2, -100, 100), { display: '', value: null });
    assert.deepEqual(maskPercentage(undefined, 2, -100, 100), { display: '', value: null });
});

test('interprets pasted decimals as percentage points and rejects invalid data', () => {
    assert.deepEqual(pastePercentage('12,5', 2, 0, 100), { display: '12,50', value: '12.50' });
    assert.deepEqual(pastePercentage('1.234,56', 2, 0, 2000), { display: '1234,56', value: '1234.56' });
    assert.deepEqual(pastePercentage('<script>', 2, 0, 100), { display: '', value: null });
});
