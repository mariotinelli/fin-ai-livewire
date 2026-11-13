<?php

declare(strict_types = 1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('states')->insert([
            0 => [
                'id'        => 1,
                'name'      => 'Acre',
                'initials'  => 'AC',
                'region_id' => 1,
            ],
            1 => [
                'id'        => 2,
                'name'      => 'Alagoas',
                'initials'  => 'AL',
                'region_id' => 2,
            ],
            2 => [
                'id'        => 3,
                'name'      => 'Amazonas',
                'initials'  => 'AM',
                'region_id' => 1,
            ],
            3 => [
                'id'        => 4,
                'name'      => 'Amapá',
                'initials'  => 'AP',
                'region_id' => 1,
            ],
            4 => [
                'id'        => 5,
                'name'      => 'Bahia',
                'initials'  => 'BA',
                'region_id' => 2,
            ],
            5 => [
                'id'        => 6,
                'name'      => 'Ceará',
                'initials'  => 'CE',
                'region_id' => 2,
            ],
            6 => [
                'id'        => 7,
                'name'      => 'Distrito Federal',
                'initials'  => 'DF',
                'region_id' => 3,
            ],
            7 => [
                'id'        => 8,
                'name'      => 'Espírito Santo',
                'initials'  => 'ES',
                'region_id' => 4,
            ],
            8 => [
                'id'        => 9,
                'name'      => 'Goiás',
                'initials'  => 'GO',
                'region_id' => 3,
            ],
            9 => [
                'id'        => 10,
                'name'      => 'Maranhão',
                'initials'  => 'MA',
                'region_id' => 2,
            ],
            10 => [
                'id'        => 11,
                'name'      => 'Minas Gerais',
                'initials'  => 'MG',
                'region_id' => 4,
            ],
            11 => [
                'id'        => 12,
                'name'      => 'Mato Grosso do Sul',
                'initials'  => 'MS',
                'region_id' => 3,
            ],
            12 => [
                'id'        => 13,
                'name'      => 'Mato Grosso',
                'initials'  => 'MT',
                'region_id' => 3,
            ],
            13 => [
                'id'        => 14,
                'name'      => 'Pará',
                'initials'  => 'PA',
                'region_id' => 1,
            ],
            14 => [
                'id'        => 15,
                'name'      => 'Paraiba',
                'initials'  => 'PB',
                'region_id' => 2,
            ],
            15 => [
                'id'        => 16,
                'name'      => 'Pernambuco',
                'initials'  => 'PE',
                'region_id' => 2,
            ],
            16 => [
                'id'        => 17,
                'name'      => 'Piauí',
                'initials'  => 'PI',
                'region_id' => 2,
            ],
            17 => [
                'id'        => 18,
                'name'      => 'Paraná',
                'initials'  => 'PR',
                'region_id' => 5,
            ],
            18 => [
                'id'        => 19,
                'name'      => 'Rio de Janeiro',
                'initials'  => 'RJ',
                'region_id' => 4,
            ],
            19 => [
                'id'        => 20,
                'name'      => 'Rio Grande do Norte',
                'initials'  => 'RN',
                'region_id' => 2,
            ],
            20 => [
                'id'        => 21,
                'name'      => 'Rondônia',
                'initials'  => 'RO',
                'region_id' => 1,
            ],
            21 => [
                'id'        => 22,
                'name'      => 'Roraima',
                'initials'  => 'RR',
                'region_id' => 1,
            ],
            22 => [
                'id'        => 23,
                'name'      => 'Rio Grande do Sul',
                'initials'  => 'RS',
                'region_id' => 5,
            ],
            23 => [
                'id'        => 24,
                'name'      => 'Santa Catarina',
                'initials'  => 'SC',
                'region_id' => 5,
            ],
            24 => [
                'id'        => 25,
                'name'      => 'Sergipe',
                'initials'  => 'SE',
                'region_id' => 2,
            ],
            25 => [
                'id'        => 26,
                'name'      => 'São Paulo',
                'initials'  => 'SP',
                'region_id' => 4,
            ],
            26 => [
                'id'        => 27,
                'name'      => 'Tocantins',
                'initials'  => 'TO',
                'region_id' => 1,
            ],
        ]);
    }
}
