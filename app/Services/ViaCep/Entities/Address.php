<?php

declare(strict_types = 1);

namespace App\Services\ViaCep\Entities;

use App\Models\Address as AddressModel;
use App\Models\City;
use UnexpectedValueException;

class Address
{
    public function __construct(
        public string $cityName,
        public string $stateName,
        public ?int $cityId,
        public string $street,
        public string $number,
        public string $district,
        public ?string $complement,
        public string $postalCode,
    ) {
    }

    /**
     * @param array<array-key, mixed> $data
     */
    public static function createFromApi(array $data): self
    {
        foreach (['localidade', 'uf', 'cep'] as $field) {
            if (!is_string($data[$field] ?? null) || trim($data[$field]) === '') {
                throw new UnexpectedValueException('Resposta inválida do ViaCep.');
            }
        }

        if (!preg_match('/^[A-Z]{2}$/', $data['uf']) || !preg_match('/^[0-9]{5}-?[0-9]{3}$/', $data['cep'])) {
            throw new UnexpectedValueException('Resposta inválida do ViaCep.');
        }

        foreach (['ibge', 'logradouro', 'unidade', 'bairro', 'complemento'] as $field) {
            if (isset($data[$field]) && !is_string($data[$field])) {
                throw new UnexpectedValueException('Resposta inválida do ViaCep.');
            }
        }

        /** @var array{localidade: string, uf: string, cep: string, ibge?: string|null, logradouro?: string|null, unidade?: string|null, bairro?: string|null, complemento?: string|null} $data */
        $city = null;

        if (!empty($data['ibge'])) {
            $city = City::query()->where('ibge_code', $data['ibge'])
                ->whereRelation('state', 'initials', $data['uf'])->first();
        }

        $city ??= City::query()->where('name', $data['localidade'])
            ->whereRelation('state', 'initials', $data['uf'])->first();

        return new self(
            cityName: $data['localidade'],
            stateName: $data['uf'],
            cityId: $city?->id,
            street: $data['logradouro'] ?? '',
            number: $data['unidade'] ?? '',
            district: $data['bairro'] ?? '',
            complement: $data['complemento'] ?? '',
            postalCode: $data['cep'],
        );
    }

    public function toModel(?AddressModel $address = null): AddressModel
    {
        $address ??= new AddressModel();

        $address->city_id     = $this->cityId;
        $address->street      = $this->street;
        $address->number      = $this->number;
        $address->district    = $this->district;
        $address->complement  = $this->complement;
        $address->postal_code = $this->postalCode;

        return $address;
    }
}
