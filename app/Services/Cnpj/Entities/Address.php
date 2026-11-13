<?php

declare(strict_types = 1);

namespace App\Services\Cnpj\Entities;

use App\Models;

/** @phpstan-import-type Establishment from Customer */
readonly class Address
{
    public function __construct(
        public string $cityName,
        public string $stateName,
        public int $cityId,
        public string $street,
        public string $number,
        public string $district,
        public ?string $complement,
        public string $postalCode,
    ) {
    }

    /** @param array{estabelecimento?: Establishment|null} $data */
    public static function createFromApi(array $data): self
    {
        $cityName = $data['estabelecimento']['cidade']['nome'] ?? '';

        $city = Models\City::query()->firstWhere('name', $cityName);

        return new self(
            cityName: $cityName,
            stateName: $data['estabelecimento']['estado']['nome'] ?? '',
            cityId: $city->id ?? 0,
            street: $data['estabelecimento']['logradouro'] ?? '',
            number: $data['estabelecimento']['numero'] ?? '',
            district: $data['estabelecimento']['bairro'] ?? '',
            complement: $data['estabelecimento']['complemento'] ?? '',
            postalCode: self::getPostalCode($data['estabelecimento']['cep'] ?? ''),
        );
    }

    protected static function getPostalCode(string $postalCode): string
    {
        if ($postalCode === '') {
            return '';
        }

        return str($postalCode)
            ->substrReplace('-', 5, 0)
            ->toString();
    }

    public function toModel(?Models\Address $address): Models\Address
    {
        $address ??= new Models\Address();

        $address->street      = $this->street;
        $address->number      = $this->number;
        $address->district    = $this->district;
        $address->complement  = $this->complement;
        $address->postal_code = $this->postalCode;
        $address->city_id     = $this->cityId;

        return $address;
    }
}
