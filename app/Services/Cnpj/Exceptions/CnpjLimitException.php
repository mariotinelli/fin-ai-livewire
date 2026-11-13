<?php

declare(strict_types = 1);

namespace App\Services\Cnpj\Exceptions;

use Exception;

class CnpjLimitException extends Exception
{
    protected $message = 'Excedido o limite máximo de consultas por minuto. Aguarde um minuto e tente novamente.';
}
