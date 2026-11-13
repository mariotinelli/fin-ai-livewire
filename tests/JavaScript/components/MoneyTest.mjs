import assert from 'node:assert/strict';
import test from 'node:test';
import { brlMask, usdMask, formatAmount } from '../../../resources/js/components/money.js';

for (const [value, brl, usd] of [
    [1, '1,00', '1.00'],
    [9, '9,00', '9.00'],
    [10, '10,00', '10.00'],
    [0, '0,00', '0.00'],
    [0.01, '0,01', '0.01'],
    [0.29, '0,29', '0.29'],
    [1.5, '1,50', '1.50'],
    [1234.56, '1.234,56', '1,234.56'],
    ['1', '1,00', '1.00'],
    ['9.5', '9,50', '9.50'],
    ['1.234,56', '1.234,56', '1,234.56'],
    ['1234,5', '1.234,50', '1,234.50'],
    ['1,234.56', '1.234,56', '1,234.56'],
    [100000000, '100.000.000,00', '100,000,000.00'],
    [-1.5, '-1,50', '-1.50'],
    [null, '', ''],
    [undefined, '', ''],
    ['', '', ''],
    ['invalid', 'invalid', 'invalid'],
    ['1.2345', '1.2345', '1.2345'],
]) {
    test(`hydrates ${String(value)} without changing its amount`, () => {
        assert.equal(formatAmount(value), brl);
        assert.equal(formatAmount(value, 'en-US'), usd);
        if (typeof value === 'number') {
            assert.equal(brlMask(value), brl);
            assert.equal(usdMask(value), usd);
        }
    });
}

for (const [value, brl, usd] of [
    ['1', '0,01', '0.01'],
    ['10', '0,10', '0.10'],
    ['100', '1,00', '1.00'],
    ['000', '0,00', '0.00'],
    ['1,001', '10,01', '10.01'],
    ['-123', '-1,23', '-1.23'],
    ['', '', ''],
    [null, '', ''],
    [undefined, '', ''],
    ['abc', '', ''],
    ['10000000000', '100.000.000,00', '100,000,000.00'],
]) {
    test(`masks typed ${String(value)} as cents`, () => {
        assert.equal(brlMask(value), brl);
        assert.equal(usdMask(value), usd);
    });
}
