<?php

declare(strict_types = 1);

use App\Casts\Datetime;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

it('tests get method', function (): void {
    $model = new class () extends Model {};

    $result = new Datetime()->get($model, 'test_key', null, []);

    expect($result)->toBeNull();

    $now    = now()->format('Y-m-d H:i:s');
    $result = new Datetime()->get($model, 'test_key', $now, []);

    expect($result)->toBeInstanceOf(Carbon::class)
        ->and($result->format('Y-m-d H:i:s'))->toBe($now);
});

it('tests set method', function (): void {
    $model = new class () extends Model {};

    $result = new Datetime()->set($model, 'test_key', null, []);

    expect($result)->toBeNull();

    $date   = now();
    $result = new Datetime()->set($model, 'test_key', $date, []);
    expect($result)->toBe($date->format('Y-m-d H:i:s'));

    $date   = now()->seconds(0);
    $result = new Datetime()->set($model, 'test_key', $date->format('d/m/Y H:i'), []);
    expect($result)->toBe($date->format('Y-m-d H:i:s'));

    $date   = now();
    $result = new Datetime()->set($model, 'test_key', $date->format('d/m/Y'), []);
    expect($result)->toBe($date->format('Y-m-d H:i:s'));

    $date   = now()->seconds(0);
    $result = new Datetime()->set($model, 'test_key', $date->format('H:i'), []);
    expect($result)->toBe($date->format('Y-m-d H:i:s'));

    // Invalid datetime format exception
    $date = now();
    expect(fn (): mixed => new Datetime()->set($model, 'test_key', $date->format('Y-m-d'), []))->toThrow(InvalidArgumentException::class);
});
