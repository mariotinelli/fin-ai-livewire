<?php

declare(strict_types = 1);

use App\Traits\Components\WithFormats;

it('formats Brazilian values and rejects invalid lengths', function (): void {
    $formatter = new class () {
        use WithFormats;
    };

    expect($formatter->formatCnpj('12.345.678/0001-90'))->toBe('12.345.678/0001-90')
        ->and($formatter->formatCnpj('00.000.000/e08g-12'))->toBe('00.000.000/E08G-12')
        ->and($formatter->formatCnpj('123'))->toBeNull()
        ->and($formatter->formatCpf('123.456.789-01'))->toBe('123.456.789-01')
        ->and($formatter->formatCpf('123'))->toBeNull()
        ->and($formatter->formatCep('12345-678'))->toBe('12345-678')
        ->and($formatter->formatCep('123'))->toBeNull()
        ->and($formatter->formatPhone('1133334444'))->toBe('(11) 3333-4444')
        ->and($formatter->formatPhone('11999998888'))->toBe('(11) 99999-8888')
        ->and($formatter->formatPhone('123456789'))->toBeNull()
        ->and($formatter->formatPhone('123456789012'))->toBeNull()
        ->and($formatter->formatPlate('ABC1234'))->toBe('ABC-1234')
        ->and($formatter->formatPlate('ABC1D23'))->toBe('ABC1D23')
        ->and($formatter->formatPlate('ABC123'))->toBeNull();
});
