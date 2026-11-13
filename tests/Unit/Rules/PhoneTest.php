<?php

declare(strict_types = 1);

use App\Rules\Phone;
use Illuminate\Support\Facades\Validator;

it('accepts national format with or without separators without changing the original value', function (string $phone): void {
    $validator = Validator::make(['phone' => $phone], ['phone' => [new Phone()]]);

    expect($validator->passes())->toBeTrue()
        ->and($validator->validated()['phone'])->toBe($phone);
})->with([
    'landline raw'                        => '1133334444',
    'mobile raw'                          => '11999998888',
    'landline masked'                     => '(11) 3333-4444',
    'mobile masked'                       => '(11) 99999-8888',
    'spaces'                              => '11 99999 8888',
    'dots'                                => '11.3333.4444',
    'outer whitespace'                    => '  (11) 99999-8888  ',
    'leading zero'                        => '0133334444',
    'shape only without existence claims' => '00000000000',
]);

it('rejects malformed text with a Portuguese validation message', function (string $phone): void {
    $validator = Validator::make(['phone' => $phone], ['phone' => [new Phone()]]);

    expect($validator->errors()->first('phone'))->toBe('Informe um telefone válido com DDD.');
})->with([
    'short'                       => '113333444',
    'long'                        => '119999988880',
    'letters around valid digits' => 'abc11999998888',
    'HTML around valid digits'    => '<b>11999998888</b>',
    'international prefix'        => '+5511999998888',
    'plus sign without prefix'    => '+11999998888',
    'slash'                       => '11/999998888',
    'underscore'                  => '11_999998888',
    'scientific notation'         => '1.1999998888e10',
    'non-ASCII digits'            => '١١٩٩٩٩٩٨٨٨٨',
    'invalid UTF-8'               => "11999998888\xFF",
]);

it('rejects non-text values and empty text when the rule is invoked', function (mixed $phone): void {
    $messages = [];

    new Phone()->validate('phone', $phone, function (string $message) use (&$messages): void {
        $messages[] = $message;
    });

    expect($messages)->toBe(['Informe um telefone válido com DDD.']);
})->with([
    'integer'       => 11999998888,
    'float'         => 11999998888.0,
    'boolean true'  => true,
    'boolean false' => false,
    'null'          => null,
    'array'         => [['11999998888']],
    'object'        => [(object) ['phone' => '11999998888']],
    'empty text'    => '',
    'whitespace'    => '   ',
]);

it('lets the consumer require a value or explicitly allow a nullable phone', function (): void {
    expect(Validator::make(['phone' => ''], ['phone' => ['required', new Phone()]])->fails())->toBeTrue()
        ->and(Validator::make(['phone' => null], ['phone' => ['nullable', new Phone()]])->passes())->toBeTrue();
});
