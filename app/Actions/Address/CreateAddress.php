<?php

declare(strict_types = 1);

namespace App\Actions\Address;

use App\Models\Address;

final readonly class CreateAddress
{
    /** @param array{city_id: int|null, street: string|null, number: string|null, district: string|null, postal_code: string, complement: string|null} $data */
    public function handle(array $data): Address
    {
        return Address::query()->create([
            'city_id'     => $data['city_id'],
            'street'      => $data['street'],
            'number'      => $data['number'],
            'district'    => $data['district'],
            'postal_code' => $data['postal_code'],
            'complement'  => $data['complement'],
        ]);
    }
}
