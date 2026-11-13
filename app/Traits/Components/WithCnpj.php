<?php

declare(strict_types = 1);

namespace App\Traits\Components;

use App\Enums\Toast;
use App\Services\Cnpj\CnpjService;
use App\Services\Cnpj\Exceptions\CnpjLimitException;
use App\Services\Cnpj\Exceptions\CnpjNotFoundException;
use App\Services\Cnpj\Exceptions\CnpjOutOfServiceException;
use App\Support\Cnpj;
use Illuminate\Http\Client\ConnectionException;

trait WithCnpj
{
    use WithAddress;

    /** @var array{name: string, phone: string, email: string, nickname: string} */
    public array $customer = ['name' => '', 'phone' => '', 'email' => '', 'nickname' => ''];

    /** @var list<array{name: string, document: string}> */
    public array $partners = [];

    public function updateCustomerCnpj(?string $cnpj): void
    {
        if (!$this->cnpjIsValid($cnpj)) {
            return;
        }

        try {
            $response = app(CnpjService::class)->getCustomer($cnpj);

            $this->customer = [
                'name'     => $response->name,
                'phone'    => $response->phone,
                'email'    => $response->email,
                'nickname' => $response->nickname,
            ];

            $this->cityName  = $response->address->cityName;
            $this->stateName = $response->address->stateName;

            $this->address = $response->address->toModel($this->address);

            $this->partners = $response->partners;

        } catch (CnpjNotFoundException | ConnectionException | CnpjOutOfServiceException) {
            $this->sendError();

        } catch (CnpjLimitException) {

            $this->toast(title: 'Limite de consultas atingido, tente novamente após alguns minutos.', type: Toast::Error);
        }
    }

    /** @phpstan-assert-if-true string $cnpj */
    private function cnpjIsValid(?string $cnpj): bool
    {
        return Cnpj::isValid($cnpj);
    }

    private function sendError(): void
    {
        $this->toast(title: 'Erro ao buscar o CNPJ, tente novamente mais tarde.', type: Toast::Error);
    }
}
