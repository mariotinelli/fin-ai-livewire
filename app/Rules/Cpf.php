<?php

declare(strict_types = 1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Cpf implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) || !\App\Support\Cpf::isValid($value)) {
            $fail('O campo :attribute deve conter um CPF válido.');
        }
    }
}
