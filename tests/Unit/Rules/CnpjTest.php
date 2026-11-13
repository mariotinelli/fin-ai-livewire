<?php

declare(strict_types = 1);

use App\Rules\Cnpj;
use Illuminate\Support\Facades\Validator;

it('accepts valid numeric and alphanumeric CNPJ values', function (string $cnpj): void {
    $validator = Validator::make(['document' => $cnpj], ['document' => [new Cnpj()]]);

    expect($validator->passes())->toBeTrue();
})->with([
    'numeric'      => '11.444.777/0001-61',
    'alphanumeric' => '00.000.000/E08G-12',
]);

it('rejects non-string and invalid CNPJ values with the validation message', function (mixed $cnpj): void {
    $validator = Validator::make(['document' => $cnpj], ['document' => [new Cnpj()]]);

    expect($validator->errors()->first('document'))->toBe('O campo document deve conter um CNPJ válido.');
})->with([
    'non-string' => 11444777000161,
    'invalid'    => '12.ABC.345/01DE-34',
]);
