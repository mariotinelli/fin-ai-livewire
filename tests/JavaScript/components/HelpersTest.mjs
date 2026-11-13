import { test } from 'node:test';
import assert from 'node:assert/strict';
import {
    converterFloatToString,
    converterIntToFloat,
    converterIntToString,
    converterStringToFloat,
    converterStringToInt,
} from '../../../resources/js/components/helpers.js';

test('converts localized numeric values and preserves values of other types', () => {
    assert.equal(converterStringToFloat('1.234,56'), 1234.56);
    assert.equal(converterStringToFloat('1.23'), '1.23');
    assert.equal(converterStringToFloat(12), 12);
    assert.equal(converterStringToInt('1.234,56'), 123456);
    assert.equal(converterStringToInt(12), 12);
    assert.equal(converterFloatToString(1234.5), '1.234,50');
    assert.equal(converterFloatToString('12'), '12');
    assert.equal(converterIntToString(123450), '1.234,50');
    assert.equal(converterIntToString('12'), '12');
    assert.equal(converterIntToFloat(123), '1.23');
    assert.equal(converterIntToFloat('123'), '123');
});
