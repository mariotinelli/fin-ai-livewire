<?php

declare(strict_types = 1);

use App\Rules\Cpf;
use Illuminate\Support\Facades\Validator;

it('accepts a valid CPF', function (): void {
    $validator = Validator::make(['document' => '012.345.678-90'], ['document' => [new Cpf()]]);

    expect($validator->passes())->toBeTrue();
});

it('rejects non-string and invalid CPF values with the validation message', function (mixed $cpf): void {
    $validator = Validator::make(['document' => $cpf], ['document' => [new Cpf()]]);

    expect($validator->errors()->first('document'))->toBe('O campo document deve conter um CPF válido.');
})->with([
    'non-string' => 12345678909,
    'invalid'    => '012.345.678-91',
]);
