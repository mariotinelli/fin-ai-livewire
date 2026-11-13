<?php

declare(strict_types = 1);

namespace App\Rules;

use App\Rules\Traits\MoneyValidations;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MoneyRule implements ValidationRule
{
    use MoneyValidations;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) && !is_int($value) && !is_float($value) && $value !== null) {
            $fail(trans('validation.numeric'));

            return;
        }

        $this->checkValidations($attribute, $value, $fail);
    }
}
