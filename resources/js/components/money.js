/** Format cents without floating-point rounding or a silent upper limit. */
function formatCents(digits, locale) {
    digits = (digits.replace(/^0+/, '') || '0').padStart(3, '0');
    const decimal = locale === 'pt-BR' ? ',' : '.';
    const group = locale === 'pt-BR' ? '.' : ',';
    return digits.slice(0, -2).replace(/\B(?=(\d{3})+(?!\d))/g, group) + decimal + digits.slice(-2);
}

/** Hydrated values are amounts in currency units, never a stream of typed cents. */
export function formatAmount(value, locale = 'pt-BR') {
    if (value === null || value === undefined || value === '') return '';
    const source = String(value);
    let decimal = source;
    if (/^-?\d{1,3}(\.\d{3})*,\d{1,2}$/.test(source) || /^-?\d+,\d{1,2}$/.test(source)) {
        decimal = source.replaceAll('.', '').replace(',', '.');
    } else if (/^-?\d{1,3}(,\d{3})+\.\d{1,2}$/.test(source)) {
        decimal = source.replaceAll(',', '');
    }
    if (!/^-?\d+(\.\d{1,2})?$/.test(decimal)) return source;
    const negative = decimal.startsWith('-');
    const [units, cents = ''] = decimal.replace('-', '').split('.');
    return (negative ? '-' : '') + formatCents(units + cents.padEnd(2, '0'), locale);
}

/** Typing shifts digits through cents; numeric callers provide currency units. */
export function brlMask(value) {
    if (typeof value === 'number') return formatAmount(value);
    return mask(value, 'pt-BR');
}

export function usdMask(value) {
    if (typeof value === 'number') return formatAmount(value, 'en-US');
    return mask(value, 'en-US');
}

function mask(value, locale) {
    const source = String(value ?? '');
    const digits = source.replace(/\D/g, '');
    if (!digits) return '';
    return (source.startsWith('-') ? '-' : '') + formatCents(digits, locale);
}
