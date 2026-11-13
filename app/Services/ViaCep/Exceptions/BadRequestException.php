<?php

declare(strict_types = 1);

namespace App\Services\ViaCep\Exceptions;

use Exception;

class BadRequestException extends Exception
{
    protected $message = 'Erro ao obter dados do ViaCep.';
}
