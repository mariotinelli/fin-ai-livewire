<?php

declare(strict_types = 1);

use App\Support\BcMath;

it('creates an instance with default value and scale', function (): void {
    $result = new BcMath()->make();

    expect((string) $result)->toBe('0')
        ->and($result->toFloat())->toBe(0.0)
        ->and($result->toInt())->toBe(0);
});

it('adds, subtracts, multiplies and divides using default scale', function (): void {
    $math = new BcMath()->make(100);

    expect($math->add(25))->toBe($math)
        ->and((string) $math)->toBe('125.00');

    expect($math->sub(24.5))->toBe($math)
        ->and((string) $math)->toBe('100.50');

    expect($math->mul(2))->toBe($math)
        ->and((string) $math)->toBe('201.00');

    expect($math->div(3))->toBe($math)
        ->and((string) $math)->toBe('67.00');
});

it('uses custom scale when provided', function (): void {
    $math = new BcMath()->make(10, 3);

    $math->add('0.555', 3)
        ->sub('0.005', 3)
        ->mul(2, 3)
        ->div(5, 3);

    expect((string) $math)->toBe('4.220');
});

it('falls back to internal scale when zero is provided as scale', function (): void {
    $math = new BcMath()->make('10.123', 3);

    $math->add('0.100', 0)
        ->sub('0.023', 0)
        ->mul(2, 0)
        ->div(2, 0);

    expect((string) $math)->toBe('10.200');
});

it('calculates percentage and tax correctly', function (): void {
    $percentage = new BcMath()->make(200)->percentage(10);
    $tax        = new BcMath()->make(200)->tax(10);

    expect((string) $percentage)->toBe('20.00')
        ->and((string) $tax)->toBe('220.00');
});

it('converts to int using current scale', function (): void {
    $value = new BcMath()->make('10.255', 3)->toInt();

    expect($value)->toBe(10255);
});
