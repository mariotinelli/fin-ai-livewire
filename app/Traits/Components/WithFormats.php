<?php

declare(strict_types = 1);

namespace App\Traits\Components;

use App\Support\Cnpj;
use App\Support\Cpf;

trait WithFormats
{
    public function formatCnpj(string $cnpj): ?string
    {
        return Cnpj::format($cnpj);
    }

    public function formatCpf(string $cpf): ?string
    {
        return Cpf::format($cpf);
    }

    public function formatPhone(string $phone): ?string
    {
        $unformatted = preg_replace('/[^0-9]/', '', $phone);

        if (strlen((string) $unformatted) < 10 || strlen((string) $unformatted) > 11) {
            return null;
        }

        if (strlen((string) $unformatted) === 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', (string) $unformatted);
        }

        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', (string) $unformatted);
    }

    public function formatCep(string $cep): ?string
    {
        $unformatted = preg_replace('/[^0-9]/', '', $cep);

        if (strlen((string) $unformatted) !== 8) {
            return null;
        }

        return preg_replace('/(\d{5})(\d{3})/', '$1-$2', (string) $unformatted);
    }

    public function formatPlate(string $plate): ?string
    {
        $unformatted = preg_replace('/[^A-Z0-9]/', '', $plate);

        if (strlen((string) $unformatted) !== 7) {
            return null;
        }

        return preg_replace('/([A-Z]{3})(\d{4})/', '$1-$2', (string) $unformatted);
    }
}
