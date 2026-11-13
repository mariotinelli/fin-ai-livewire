<?php

declare(strict_types = 1);

namespace App\Services\Cnpj\Exceptions;

use Exception;

class CnpjNotFoundException extends Exception
{
    protected $message = 'CNPJ não encontrado.';
}
