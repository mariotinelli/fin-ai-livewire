<?php

declare(strict_types = 1);

use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\DB;

it('runs callbacks within a database transaction', function (): void {
    $component        = new BaseComponent();
    $transactionLevel = null;
    $initialLevel     = DB::transactionLevel();

    $component->transaction(function () use (&$transactionLevel): void {
        $transactionLevel = DB::transactionLevel();
    });

    expect($transactionLevel)->toBe($initialLevel + 1);
});

it('adds and clears validation errors received from component events', function (): void {
    $component = new BaseComponent();
    $component->addValidationError('email', 'E-mail inválido.');

    expect($component->getErrorBag()->first('email'))->toBe('E-mail inválido.');

    $component->clearValidationErrors();
    expect($component->getErrorBag()->isEmpty())->toBeTrue();
});
