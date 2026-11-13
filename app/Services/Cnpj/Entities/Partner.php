<?php

declare(strict_types = 1);

namespace App\Services\Cnpj\Entities;

readonly class Partner
{
    public function __construct(
        public string $name,
        public string $document,
    ) {
    }

    /** @param array{nome?: string|null, cpf_cnpj_socio?: string|null} $data */
    public static function createFromApi(array $data): self
    {
        return new self(
            name: $data['nome'] ?? '',
            document: $data['cpf_cnpj_socio'] ?? '',
        );
    }

    /**
     * @param list<array{nome?: string|null, cpf_cnpj_socio?: string|null}> $data
     * @return list<self>
     */
    public static function createFromList(array $data): array
    {
        $partners = [];

        foreach ($data as $item) {
            $partners[] = self::createFromApi($item);
        }

        return $partners;
    }

    /**
     * @param list<self> $partners
     * @return list<array{name: string, document: string}>
     */
    public static function toArray(array $partners): array
    {
        $result = [];

        foreach ($partners as $partner) {
            $result[] = [
                'name'     => $partner->name,
                'document' => $partner->document,
            ];
        }

        return $result;
    }
}
