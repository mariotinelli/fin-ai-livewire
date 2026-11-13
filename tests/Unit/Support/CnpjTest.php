<?php

declare(strict_types = 1);

use App\Support\Cnpj;

it('normalizes and formats numeric and alphanumeric values', function (string $input, string $normalized, string $formatted): void {
    expect(Cnpj::normalize($input))->toBe($normalized)
        ->and(Cnpj::format($input))->toBe($formatted);
})->with([
    'numeric'                        => ['11.444.777/0001-61', '11444777000161', '11.444.777/0001-61'],
    'official alphanumeric example'  => [' 12.abc.345/01de-35 ', '12ABC34501DE35', '12.ABC.345/01DE-35'],
    'official leading-zero issuance' => ['00.000.000/e08g-12', '00000000E08G12', '00.000.000/E08G-12'],
]);

it('does not format an incomplete CNPJ', function (): void {
    expect(Cnpj::format('123'))->toBeNull();
});

it('rejects unsupported characters during normalization', function (?string $cnpj): void {
    expect(Cnpj::normalize($cnpj))->toBeNull();
})->with([
    'null'       => null,
    'empty'      => '',
    'underscore' => '12ABC345_01DE35',
    'accented'   => '12ÁBC34501DE35',
]);

it('validates current numeric and alphanumeric CNPJ check digits', function (string $cnpj): void {
    expect(Cnpj::isValid($cnpj))->toBeTrue();
})->with([
    'numeric'                          => '11.444.777/0001-61',
    'manual alphanumeric example'      => '12.ABC.345/01DE-35',
    'first official alphanumeric CNPJ' => '00.000.000/E08G-12',
]);

it('rejects invalid CNPJ values', function (?string $cnpj): void {
    expect(Cnpj::isValid($cnpj))->toBeFalse();
})->with([
    'null'                  => null,
    'short'                 => '12ABC34501DE3',
    'invalid digits'        => '12ABC34501DE34',
    'alphanumeric suffix'   => '12ABC34501DEAA',
    'repeated digits'       => '00000000000000',
    'unsupported character' => '12ABC34501DÉ35',
]);
