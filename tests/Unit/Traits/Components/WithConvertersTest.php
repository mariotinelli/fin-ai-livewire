<?php

declare(strict_types = 1);

use App\Traits\Components\WithConverters;

it('converts date ranges to carbon start and end dates', function (): void {
    $component = new class () {
        use WithConverters;

        public function converterRangeToDatesProxy(string | null $value, string $fromFormat = 'd/m/Y'): ?array
        {
            return $this->converterRangeToDates($value, $fromFormat);
        }
    };

    $range  = $component->converterRangeToDatesProxy('01/01/2024 até 02/01/2024');
    $single = $component->converterRangeToDatesProxy('01/01/2024');

    expect($component->converterRangeToDatesProxy(null))->toBeNull()
        ->and($range[0]->format('Y-m-d H:i:s'))->toBe('2024-01-01 00:00:00')
        ->and($range[1]->format('Y-m-d H:i:s'))->toBe('2024-01-02 23:59:59')
        ->and($single[1]->format('Y-m-d H:i:s'))->toBe('2024-01-01 23:59:59');
});

it('converts int, float and string monetary values', function (): void {
    $component = new class () {
        use WithConverters;

        public function converterIntToFloatProxy(int | float | null $value): ?float
        {
            return $this->converterIntToFloat($value);
        }

        public function converterStringToIntProxy(string | float | int | null $value): ?int
        {
            return $this->converterStringToInt($value);
        }

        public function converterStringToFloatProxy(string | float | int | null $value): ?float
        {
            return $this->converterStringToFloat($value);
        }

        public function converterToFloatProxy(string | float | int $value): float
        {
            return $this->converterToFloat($value);
        }
    };

    expect($component->converterIntToFloatProxy(1234))->toBe(12.34)
        ->and($component->converterIntToFloatProxy(12.34))->toBe(12.34)
        ->and($component->converterStringToIntProxy('1.234,56'))->toBe(123456)
        ->and($component->converterStringToIntProxy(12.34))->toBe(1234)
        ->and($component->converterStringToFloatProxy('1234'))->toBe(12.34)
        ->and($component->converterStringToFloatProxy('1.234,56'))->toBe(1234.56)
        ->and($component->converterToFloatProxy(100))->toBe(1.0)
        ->and($component->converterToFloatProxy(12.34))->toBe(12.34)
        ->and($component->converterToFloatProxy('1.234,56'))->toBe(1234.56);
});

it('preserves every cent when converting money input values', function (string | float $value, int $cents): void {
    $component = new class () {
        use WithConverters;

        public function convert(string | float $value): ?int
        {
            return $this->converterStringToInt($value);
        }
    };

    expect($component->convert($value))->toBe($cents);
})->with([
    ['1,00', 100], ['9,00', 900], ['10,00', 1000], ['0,00', 0], ['0,01', 1],
    ['1,50', 150], ['1.234,56', 123456], ['0,29', 29], ['1,15', 115], [0.29, 29],
]);
