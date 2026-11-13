<?php

declare(strict_types = 1);

use App\Support\Cpf;

it('normalizes and formats numeric values while preserving leading zeros', function (): void {
    expect(Cpf::normalize(' 012.345.678-90 '))->toBe('01234567890')
        ->and(Cpf::format('01234567890'))->toBe('012.345.678-90')
        ->and(Cpf::format('123'))->toBeNull();
});

it('rejects unsupported characters during normalization', function (?string $cpf): void {
    expect(Cpf::normalize($cpf))->toBeNull();
})->with([
    'null'        => null,
    'empty'       => '',
    'letters'     => '123abc45678909',
    'punctuation' => '123_456_789-09',
]);

it('validates CPF check digits in raw and formatted values', function (string $cpf): void {
    expect(Cpf::isValid($cpf))->toBeTrue();
})->with([
    'raw with leading zero' => '01234567890',
    'formatted'             => '111.444.777-35',
]);

it('rejects invalid CPF values', function (?string $cpf): void {
    expect(Cpf::isValid($cpf))->toBeFalse();
})->with([
    'null'            => null,
    'short'           => '1234567890',
    'invalid digits'  => '01234567891',
    'repeated digits' => '00000000000',
    'letters'         => '0123456789A',
]);
