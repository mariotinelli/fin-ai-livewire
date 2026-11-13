<?php

declare(strict_types = 1);

namespace App\Services\ViaCep;

use App\Services\ViaCep\Entities\Address;
use App\Services\ViaCep\Exceptions\BadRequestException;
use App\Services\ViaCep\Exceptions\CepNotFoundException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use UnexpectedValueException;

class ViaCepService
{
    private readonly PendingRequest $api;

    public function __construct()
    {
        $this->api = Http::baseUrl('https://viacep.com.br/ws/')->connectTimeout(3)->timeout(10);
    }

    /**
     * @throws BadRequestException
     * @throws CepNotFoundException
     *
     */
    public function getAddress(string $cep): Address
    {
        $cep = (string) preg_replace('/[^0-9]/', '', $cep);

        if (strlen($cep) !== 8) {
            throw new BadRequestException();
        }

        $response = $this->api->get("{$cep}/json/");

        if ($response->status() === 400) {
            throw new BadRequestException();
        }

        if (!$response->successful()) {
            throw new UnexpectedValueException('Falha na consulta ao ViaCep.');
        }

        $data = $response->json();

        if (!is_array($data)) {
            throw new UnexpectedValueException('Resposta inválida do ViaCep.');
        }

        if (in_array($data['erro'] ?? false, [true, 'true'], true)) {
            throw new CepNotFoundException();
        }

        return Address::createFromApi($data);
    }
}
