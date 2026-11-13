<?php

declare(strict_types = 1);

namespace App\Traits\Components;

use App\Enums\Toast;
use App\Models\Address;
use App\Services\ViaCep\Exceptions\BadRequestException;
use App\Services\ViaCep\Exceptions\CepNotFoundException;
use App\Services\ViaCep\ViaCepService;
use Exception;

trait WithAddress
{
    public ?Address $address = null;

    public ?string $cityName = null;

    public ?string $stateName = null;

    public function updateAddress(?string $postalCode, ?Address $address = null): void
    {
        if (!$this->postalCodeIsValid($postalCode)) {
            return;
        }

        try {
            $this->clearValidation('address.postal_code');
            $this->clearValidation('address.city_id');

            $response = app(ViaCepService::class)->getAddress($postalCode);

            $this->cityName  = $response->cityName;
            $this->stateName = $response->stateName;
            $this->address   = $response->toModel($address);

            if ($response->cityId === null) {
                $this->addError('address.city_id', 'Cidade não encontrada.');
            }
        } catch (BadRequestException) {
            $this->addError('address.postal_code', 'CEP inválido.');
            $this->resetAddress();
        } catch (CepNotFoundException) {
            $this->addError('address.postal_code', 'CEP não encontrado.');
            $this->resetAddress();
        } catch (Exception) {
            $this->toast(title: 'Ocorreu um erro ao buscar o endereço.', type: Toast::Error);
            $this->resetAddress();
        }
    }

    /** @phpstan-assert-if-true string $postalCode */
    public function postalCodeIsValid(?string $postalCode): bool
    {
        if (in_array($postalCode, [null, '', '0'], true)) {
            return false;
        }

        $postalCode = preg_replace('/[^0-9]/', '', $postalCode);

        return strlen((string) $postalCode) === 8;
    }

    public function resetAddress(): void
    {
        $this->cityName  = null;
        $this->stateName = null;

        if ($this->address === null) {
            return;
        }

        $this->address->city_id    = null;
        $this->address->street     = null;
        $this->address->number     = null;
        $this->address->district   = null;
        $this->address->complement = null;
    }
}
