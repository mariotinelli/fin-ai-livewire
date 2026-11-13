<?php

declare(strict_types = 1);

use App\Casts\Money;
use Illuminate\Database\Eloquent\Model;

it('tests get method', function (): void {
    $model = new class () extends Model {};
    $cast  = new Money();

    $result = $cast->get($model, 'test_key', 10000, []);
    expect($result)->toBe(100.00);

    $result = $cast->get($model, 'test_key', 100.00, []);
    expect($result)->toBe(100.00);

    $result = $cast->get($model, 'test_key', null, []);
    expect($result)->toBeNull();
});

it('tests set method', function (): void {
    $model = new class () extends Model {};
    $cast  = new Money();

    $result = $cast->set($model, 'test_key', '100,00', []);
    expect($result)->toBe(10000);

    $result = $cast->set($model, 'test_key', null, []);
    expect($result)->toBeNull();
});

it('treats empty monetary inputs as null while preserving zero', function (?string $value): void {
    $model = new class () extends Model {};
    $cast  = new Money();

    expect($cast->set($model, 'total', $value, []))->toBeNull();
    expect($cast->set($model, 'total', '0,00', []))->toBe(0);
})->with([null, '', '   ']);
