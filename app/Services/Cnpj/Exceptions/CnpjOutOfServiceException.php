<?php

declare(strict_types = 1);

namespace App\Services\Cnpj\Exceptions;

use Exception;

class CnpjOutOfServiceException extends Exception
{
    protected $message = 'Serviço de consulta de CNPJ está temporariamente indisponível. Tente novamente mais tarde.';
}
