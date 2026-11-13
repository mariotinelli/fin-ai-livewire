<?php

declare(strict_types = 1);

namespace App\Services\ViaCep\Exceptions;

use Exception;

class CepNotFoundException extends Exception
{
    protected $message = 'CEP não encontrado.';
}
