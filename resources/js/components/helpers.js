export function converterStringToFloat(value) {
    if (typeof value !== 'string' || (String(value).includes('.') && String(value).length <= 6)) return value;

    return parseFloat(value.replace(/\./g, '').replace(',', '.'));
}

export function converterStringToInt(value) {
    if (typeof value !== 'string') return value;

    return parseInt(value.replace(/\./g, '').replace(',', ''));
}

export function converterFloatToString(value) {
    if (typeof value !== 'number') return value;

    return value.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

export function converterIntToString(value) {
    if (typeof value !== 'number') return value;

    return (value / 100).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

export function converterIntToFloat(value) {
    if (typeof value !== 'number') return value;

    return (value / 100).toFixed(2);
}
