<?php

declare(strict_types = 1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Valida somente o formato nacional: 10/11 dígitos ASCII, desconsiderando espaços,
 * parênteses, pontos e hifens. Não verifica DDD atribuído, prefixo ou existência da linha.
 * O consumidor define obrigatoriedade com required/nullable; o valor não é alterado.
 */
class Phone implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)
            || preg_match('/^[0-9()\s.-]+$/uD', $value) !== 1
            || preg_match('/^[0-9]{10,11}$/D', preg_replace('/[()\s.-]/u', '', $value) ?? '') !== 1) {
            $fail('Informe um telefone válido com DDD.');
        }
    }
}
