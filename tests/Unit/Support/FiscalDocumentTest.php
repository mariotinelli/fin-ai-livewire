<?php

declare(strict_types = 1);

use App\Support\FiscalDocument;

it('normalizes and formats supported fiscal documents', function (string $input, string $normalized, string $formatted): void {
    expect(FiscalDocument::normalize($input))->toBe($normalized)
        ->and(FiscalDocument::format($input))->toBe($formatted)
        ->and(FiscalDocument::isValid($input))->toBeTrue();
})->with([
    'CPF with leading zero' => ['012.345.678-90', '01234567890', '012.345.678-90'],
    'numeric CNPJ'          => ['11.444.777/0001-61', '11444777000161', '11.444.777/0001-61'],
    'alphanumeric CNPJ'     => ['00.000.000/E08G-12', '00000000E08G12', '00.000.000/E08G-12'],
]);

it('identifies the fiscal document type', function (): void {
    expect(FiscalDocument::isCpf('111.444.777-35'))->toBeTrue()
        ->and(FiscalDocument::isCpf('11.444.777/0001-61'))->toBeFalse()
        ->and(FiscalDocument::isCnpj('11.444.777/0001-61'))->toBeTrue()
        ->and(FiscalDocument::isCnpj('111.444.777-35'))->toBeFalse();
});

it('rejects unsupported fiscal documents', function (?string $document): void {
    expect(FiscalDocument::isValid($document))->toBeFalse()
        ->and(FiscalDocument::format($document))->toBeNull();
})->with([
    'null'            => null,
    'invalid CPF'     => '012.345.678-91',
    'invalid CNPJ'    => '12.ABC.345/01DE-34',
    'invalid content' => 'documento',
]);
