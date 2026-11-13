const empty = () => ({ display: '', value: null });

function result(integer, fraction) {
    const value = `${integer.replace(/^0+(?=\d)/, '')}.${fraction.padEnd(3, '0')}`;
    return { display: value.replace('.', ','), value };
}

/** Nonnegative quantities, exactly three decimal places; never round or truncate. */
export function formatQuantity(value) {
    if (typeof value === 'number' && (!Number.isFinite(value) || Math.abs(value) > Number.MAX_SAFE_INTEGER / 1000)) return empty();
    const source = String(value ?? '').trim();
    const match = source.includes(',') ? source.match(/^(\d+|\d{1,3}(?:\.\d{3})+),(\d{0,3})$/) : source.match(/^(\d+)(?:\.(\d{0,3}))?$/);
    if (!match) return empty();
    return result(match[1].replaceAll('.', ''), match[2] ?? '');
}

/** Keyboard digits are a right-aligned stream of thousandths, like the money input. */
export function maskQuantity(value) {
    if (typeof value === 'number' && (!Number.isFinite(value) || Math.abs(value) > Number.MAX_SAFE_INTEGER / 1000)) return empty();
    const source = String(value ?? '').trim();
    if (!/^[\d.,]*$/.test(source)) return empty();
    const digits = source.replace(/\D/g, '').padStart(4, '0');
    if (!/\d/.test(source)) return empty();
    return result(digits.slice(0, -3), digits.slice(-3));
}

/** Paste accepts an explicit decimal: canonical dot or Brazilian comma/grouping. */
export function pasteQuantity(value) {
    return formatQuantity(value);
}
