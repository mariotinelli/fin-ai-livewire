<?php

declare(strict_types = 1);

namespace App\Services\Cnpj\Entities;

use App\Services\Cnpj\Exceptions\CnpjOutOfServiceException;
use Illuminate\Support\Facades\Validator;

/**
 * @phpstan-type Establishment array{cidade?: array{nome?: string|null}|null, estado?: array{nome?: string|null}|null, ddd1?: string|null, telefone1?: string|null, email?: string|null, nome_fantasia?: string|null, logradouro?: string|null, numero?: string|null, bairro?: string|null, complemento?: string|null, cep?: string|null}
 * @phpstan-type CnpjData array{razao_social: string, estabelecimento: Establishment, socios?: list<array{nome?: string|null, cpf_cnpj_socio?: string|null}>|null}
 */
class Customer
{
    /** @param list<array{name: string, document: string}> $partners */
    public function __construct(
        public string $name,
        public string $phone,
        public string $email,
        public string $nickname,
        public array $partners,
        public Address $address,
    ) {
    }

    /** @param array<array-key, mixed> $data */
    public static function createFromApi(array $data): self
    {
        $rules = [
            'razao_social'            => ['required', 'string'],
            'estabelecimento'         => ['required', 'array'],
            'estabelecimento.cidade'  => ['nullable', 'array'],
            'estabelecimento.estado'  => ['nullable', 'array'],
            'socios'                  => ['nullable', 'array', 'list'],
            'socios.*'                => ['array'],
            'socios.*.nome'           => ['nullable', 'string'],
            'socios.*.cpf_cnpj_socio' => ['nullable', 'string'],
        ];

        foreach (['ddd1', 'telefone1', 'email', 'nome_fantasia', 'cidade.nome', 'estado.nome', 'logradouro', 'numero', 'bairro', 'complemento', 'cep'] as $field) {
            $rules['estabelecimento.' . $field] = ['nullable', 'string'];
        }

        if (Validator::make($data, $rules)->fails()) {
            throw new CnpjOutOfServiceException();
        }

        /** @var CnpjData $data */
        $partners = Partner::createFromList($data['socios'] ?? []);

        return new self(
            name: $data['razao_social'],
            phone: self::formatPhone($data),
            email: $data['estabelecimento']['email'] ?? '',
            nickname: $data['estabelecimento']['nome_fantasia'] ?? '',
            partners: Partner::toArray($partners),
            address: Address::createFromApi(['estabelecimento' => $data['estabelecimento']]),
        );
    }

    /** @param CnpjData $data */
    protected static function formatPhone(array $data): string
    {
        $ddd   = $data['estabelecimento']['ddd1'] ?? '';
        $phone = $data['estabelecimento']['telefone1'] ?? '';

        if ($ddd === '' || $phone === '') {
            return '';
        }

        return '(' . $ddd . ') ' . substr($phone, 0, -4) . '-' . substr($phone, -4);
    }
}
