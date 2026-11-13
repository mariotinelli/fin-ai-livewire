const MAX_DECIMAL_PLACES = 10;

export function normalizeDecimalPlaces(value) {
    const decimalPlaces = Number(value);

    if (!Number.isFinite(decimalPlaces)) return 0;

    return Math.min(MAX_DECIMAL_PLACES, Math.max(0, Math.trunc(decimalPlaces)));
}

function expandExponent(value) {
    const match = String(value)
        .toLowerCase()
        .match(/^([+-]?)(\d+)(?:\.(\d*))?e([+-]?\d+)$/);
    if (!match) return String(value);

    const [, sign, integer, fraction = '', exponentSource] = match;
    const digits = integer + fraction;
    const decimalIndex = integer.length + Number(exponentSource);

    if (decimalIndex <= 0) return `${sign}0.${'0'.repeat(-decimalIndex)}${digits}`;
    if (decimalIndex >= digits.length) return `${sign}${digits}${'0'.repeat(decimalIndex - digits.length)}`;

    return `${sign}${digits.slice(0, decimalIndex)}.${digits.slice(decimalIndex)}`;
}

function parseDecimal(value) {
    if (value === null || value === undefined || value === '') return null;
    if (typeof value === 'number' && !Number.isFinite(value)) return null;

    let source = expandExponent(String(value).trim()).replace(/\s/g, '');
    if (!source) return null;

    const comma = source.lastIndexOf(',');
    const dot = source.lastIndexOf('.');

    if (comma >= 0 && dot >= 0) {
        const decimalSeparator = comma > dot ? ',' : '.';
        const groupingSeparator = decimalSeparator === ',' ? '.' : ',';
        source = source.replaceAll(groupingSeparator, '').replace(decimalSeparator, '.');
    } else {
        source = source.replace(',', '.');
    }

    const match = source.match(/^([+-]?)(\d+)(?:\.(\d*))?$/);
    if (!match) return null;

    return { negative: match[1] === '-', integer: match[2], fraction: match[3] ?? '' };
}

function toScaledInteger(value, decimalPlaces) {
    const parsed = parseDecimal(value);
    if (!parsed) return null;

    const keptFraction = parsed.fraction.slice(0, decimalPlaces).padEnd(decimalPlaces, '0');
    let magnitude = BigInt(parsed.integer.replace(/^0+(?=\d)/, '') + keptFraction);
    const discardedFraction = parsed.fraction.slice(decimalPlaces);

    if (discardedFraction[0] >= '5') magnitude += 1n;

    return parsed.negative && magnitude !== 0n ? -magnitude : magnitude;
}

function clamp(value, minimum, maximum) {
    if (minimum !== null && value < minimum) return minimum;
    if (maximum !== null && value > maximum) return maximum;

    return value;
}

function bounds(decimalPlaces, minimum, maximum) {
    const parsedMinimum = toScaledInteger(minimum, decimalPlaces);
    const parsedMaximum = toScaledInteger(maximum, decimalPlaces);

    if (parsedMinimum !== null && parsedMaximum !== null && parsedMinimum > parsedMaximum) {
        return { minimum: parsedMaximum, maximum: parsedMinimum };
    }

    return { minimum: parsedMinimum, maximum: parsedMaximum };
}

function serializeScaled(value, decimalPlaces) {
    const negative = value < 0n;
    const digits = (negative ? -value : value).toString().padStart(decimalPlaces + 1, '0');

    if (decimalPlaces === 0) return `${negative ? '-' : ''}${digits}`;

    return `${negative ? '-' : ''}${digits.slice(0, -decimalPlaces)}.${digits.slice(-decimalPlaces)}`;
}

function result(value, decimalPlaces, minimum, maximum) {
    const precision = normalizeDecimalPlaces(decimalPlaces);
    const scaledValue = toScaledInteger(value, precision);
    if (scaledValue === null) return { display: '', value: null };

    const limits = bounds(precision, minimum, maximum);
    const serialized = serializeScaled(clamp(scaledValue, limits.minimum, limits.maximum), precision);

    return { display: serialized.replace('.', ','), value: serialized };
}

/**
 * Format an existing percentage-point value. Values are rounded half away from zero,
 * constrained to the inclusive bounds, and serialized with a dot decimal separator.
 */
export function formatPercentage(value, decimalPlaces = 2, minimum = 0, maximum = 100) {
    return result(value, decimalPlaces, minimum, maximum);
}

/** Interpret keyboard input as a right-aligned stream of digits at the configured precision. */
export function maskPercentage(value, decimalPlaces = 2, minimum = 0, maximum = 100) {
    const precision = normalizeDecimalPlaces(decimalPlaces);
    const source = String(value ?? '');
    const negative = source.trimStart().startsWith('-');
    const digits = source.replace(/\D/g, '').replace(/^0+(?=\d)/, '');

    if (!digits) return { display: negative ? '-' : '', value: null };

    const scaled = `${negative ? '-' : ''}${serializeScaled(BigInt(digits), precision)}`;

    return result(scaled, precision, minimum, maximum);
}

/** Interpret pasted text as an explicit percentage-point decimal rather than typed digits. */
export function pastePercentage(value, decimalPlaces = 2, minimum = 0, maximum = 100) {
    return result(value, decimalPlaces, minimum, maximum);
}
