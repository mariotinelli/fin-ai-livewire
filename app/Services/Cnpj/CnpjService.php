<?php

declare(strict_types = 1);

namespace App\Services\Cnpj;

use App\Services\Cnpj\Entities\Customer;
use App\Services\Cnpj\Exceptions\CnpjLimitException;
use App\Services\Cnpj\Exceptions\CnpjNotFoundException;
use App\Services\Cnpj\Exceptions\CnpjOutOfServiceException;
use App\Support\Cnpj;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class CnpjService
{
    private readonly PendingRequest $api;

    public function __construct()
    {
        $this->api = Http::baseUrl('https://publica.cnpj.ws/cnpj/')->acceptJson()->connectTimeout(5)->timeout(15);
    }

    /**
     * @throws CnpjNotFoundException
     * @throws CnpjLimitException
     * @throws CnpjOutOfServiceException
     */
    public function getCustomer(string $cnpj): Customer
    {
        $cnpj = Cnpj::normalize($cnpj) ?? $cnpj;

        try {
            $response = $this->api->get("{$cnpj}");
        } catch (ConnectionException $connectionException) {
            throw new CnpjOutOfServiceException(previous: $connectionException);
        }

        if ($response->status() === 404 || $response->status() === 400) {
            throw new CnpjNotFoundException();
        }

        if ($response->status() === 429) {
            throw new CnpjLimitException();
        }

        if (!$response->ok()) {
            throw new CnpjOutOfServiceException();
        }

        $data = $response->json();

        if (!is_array($data)) {
            throw new CnpjOutOfServiceException();
        }

        return Customer::createFromApi($data);
    }
}
