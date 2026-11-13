<?php

declare(strict_types = 1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Cadastro de todas as cidades brasileiras
     */
    public function run(): void
    {

        DB::table('cities')->insert([
            0 => [
                'state_id'  => '21',
                'name'      => "Alta Floresta D'oeste",
                'ibge_code' => '1100015',
            ],

            1 => [
                'state_id'  => '21',
                'name'      => 'Ariquemes',
                'ibge_code' => '1100023',
            ],

            2 => [
                'state_id'  => '21',
                'name'      => 'Cabixi',
                'ibge_code' => '1100031',
            ],

            3 => [
                'state_id'  => '21',
                'name'      => 'Cacoal',
                'ibge_code' => '1100049',
            ],

            4 => [
                'state_id'  => '21',
                'name'      => 'Cerejeiras',
                'ibge_code' => '1100056',
            ],

            5 => [
                'state_id'  => '21',
                'name'      => 'Colorado do Oeste',
                'ibge_code' => '1100064',
            ],

            6 => [
                'state_id'  => '21',
                'name'      => 'Corumbiara',
                'ibge_code' => '1100072',
            ],

            7 => [
                'state_id'  => '21',
                'name'      => 'Costa Marques',
                'ibge_code' => '1100080',
            ],

            8 => [
                'state_id'  => '21',
                'name'      => "Espigão D'oeste",
                'ibge_code' => '1100098',
            ],

            9 => [
                'state_id'  => '21',
                'name'      => 'Guajará-Mirim',
                'ibge_code' => '1100106',
            ],

            10 => [
                'state_id'  => '21',
                'name'      => 'Jaru',
                'ibge_code' => '1100114',
            ],

            11 => [
                'state_id'  => '21',
                'name'      => 'Ji-Paraná',
                'ibge_code' => '1100122',
            ],

            12 => [
                'state_id'  => '21',
                'name'      => "Machadinho D'oeste",
                'ibge_code' => '1100130',
            ],

            13 => [
                'state_id'  => '21',
                'name'      => "Nova Brasilândia D'oeste",
                'ibge_code' => '1100148',
            ],

            14 => [
                'state_id'  => '21',
                'name'      => 'Ouro Preto do Oeste',
                'ibge_code' => '1100155',
            ],

            15 => [
                'state_id'  => '21',
                'name'      => 'Pimenta Bueno',
                'ibge_code' => '1100189',
            ],

            16 => [
                'state_id'  => '21',
                'name'      => 'Porto Velho',
                'ibge_code' => '1100205',
            ],

            17 => [
                'state_id'  => '21',
                'name'      => 'Presidente Médici',
                'ibge_code' => '1100254',
            ],

            18 => [
                'state_id'  => '21',
                'name'      => 'Rio Crespo',
                'ibge_code' => '1100262',
            ],

            19 => [
                'state_id'  => '21',
                'name'      => 'Rolim de Moura',
                'ibge_code' => '1100288',
            ],

            20 => [
                'state_id'  => '21',
                'name'      => "Santa Luzia D'oeste",
                'ibge_code' => '1100296',
            ],

            21 => [
                'state_id'  => '21',
                'name'      => 'Vilhena',
                'ibge_code' => '1100304',
            ],

            22 => [
                'state_id'  => '21',
                'name'      => 'São Miguel do Guaporé',
                'ibge_code' => '1100320',
            ],

            23 => [
                'state_id'  => '21',
                'name'      => 'Nova Mamoré',
                'ibge_code' => '1100338',
            ],

            24 => [
                'state_id'  => '21',
                'name'      => "Alvorada D'oeste",
                'ibge_code' => '1100346',
            ],

            25 => [
                'state_id'  => '21',
                'name'      => 'Alto Alegre dos Parecis',
                'ibge_code' => '1100379',
            ],

            26 => [
                'state_id'  => '21',
                'name'      => 'Alto Paraíso',
                'ibge_code' => '1100403',
            ],

            27 => [
                'state_id'  => '21',
                'name'      => 'Buritis',
                'ibge_code' => '1100452',
            ],

            28 => [
                'state_id'  => '21',
                'name'      => 'Novo Horizonte do Oeste',
                'ibge_code' => '1100502',
            ],

            29 => [
                'state_id'  => '21',
                'name'      => 'Cacaulândia',
                'ibge_code' => '1100601',
            ],

            30 => [
                'state_id'  => '21',
                'name'      => 'Campo Novo de Rondônia',
                'ibge_code' => '1100700',
            ],

            31 => [
                'state_id'  => '21',
                'name'      => 'Candeias do Jamari',
                'ibge_code' => '1100809',
            ],

            32 => [
                'state_id'  => '21',
                'name'      => 'Castanheiras',
                'ibge_code' => '1100908',
            ],

            33 => [
                'state_id'  => '21',
                'name'      => 'Chupinguaia',
                'ibge_code' => '1100924',
            ],

            34 => [
                'state_id'  => '21',
                'name'      => 'Cujubim',
                'ibge_code' => '1100940',
            ],

            35 => [
                'state_id'  => '21',
                'name'      => 'Governador Jorge Teixeira',
                'ibge_code' => '1101005',
            ],

            36 => [
                'state_id'  => '21',
                'name'      => 'Itapuã do Oeste',
                'ibge_code' => '1101104',
            ],

            37 => [
                'state_id'  => '21',
                'name'      => 'Ministro Andreazza',
                'ibge_code' => '1101203',
            ],

            38 => [
                'state_id'  => '21',
                'name'      => 'Mirante da Serra',
                'ibge_code' => '1101302',
            ],

            39 => [
                'state_id'  => '21',
                'name'      => 'Monte Negro',
                'ibge_code' => '1101401',
            ],

            40 => [
                'state_id'  => '21',
                'name'      => 'Nova União',
                'ibge_code' => '1101435',
            ],

            41 => [
                'state_id'  => '21',
                'name'      => 'Parecis',
                'ibge_code' => '1101450',
            ],

            42 => [
                'state_id'  => '21',
                'name'      => 'Pimenteiras do Oeste',
                'ibge_code' => '1101468',
            ],

            43 => [
                'state_id'  => '21',
                'name'      => 'Primavera de Rondônia',
                'ibge_code' => '1101476',
            ],

            44 => [
                'state_id'  => '21',
                'name'      => "São Felipe D'oeste",
                'ibge_code' => '1101484',
            ],

            45 => [
                'state_id'  => '21',
                'name'      => 'São Francisco do Guaporé',
                'ibge_code' => '1101492',
            ],

            46 => [
                'state_id'  => '21',
                'name'      => 'Seringueiras',
                'ibge_code' => '1101500',
            ],

            47 => [
                'state_id'  => '21',
                'name'      => 'Teixeirópolis',
                'ibge_code' => '1101559',
            ],

            48 => [
                'state_id'  => '21',
                'name'      => 'Theobroma',
                'ibge_code' => '1101609',
            ],

            49 => [
                'state_id'  => '21',
                'name'      => 'Urupá',
                'ibge_code' => '1101708',
            ],

            50 => [
                'state_id'  => '21',
                'name'      => 'Vale do Anari',
                'ibge_code' => '1101757',
            ],

            51 => [
                'state_id'  => '21',
                'name'      => 'Vale do Paraíso',
                'ibge_code' => '1101807',
            ],

            52 => [
                'state_id'  => '1',
                'name'      => 'Acrelândia',
                'ibge_code' => '1200013',
            ],

            53 => [
                'state_id'  => '1',
                'name'      => 'Assis Brasil',
                'ibge_code' => '1200054',
            ],

            54 => [
                'state_id'  => '1',
                'name'      => 'Brasiléia',
                'ibge_code' => '1200104',
            ],

            55 => [
                'state_id'  => '1',
                'name'      => 'Bujari',
                'ibge_code' => '1200138',
            ],

            56 => [
                'state_id'  => '1',
                'name'      => 'Capixaba',
                'ibge_code' => '1200179',
            ],

            57 => [
                'state_id'  => '1',
                'name'      => 'Cruzeiro do Sul',
                'ibge_code' => '1200203',
            ],

            58 => [
                'state_id'  => '1',
                'name'      => 'Epitaciolândia',
                'ibge_code' => '1200252',
            ],

            59 => [
                'state_id'  => '1',
                'name'      => 'Feijó',
                'ibge_code' => '1200302',
            ],

            60 => [
                'state_id'  => '1',
                'name'      => 'Jordão',
                'ibge_code' => '1200328',
            ],

            61 => [
                'state_id'  => '1',
                'name'      => 'Mâncio Lima',
                'ibge_code' => '1200336',
            ],

            62 => [
                'state_id'  => '1',
                'name'      => 'Manoel Urbano',
                'ibge_code' => '1200344',
            ],

            63 => [
                'state_id'  => '1',
                'name'      => 'Marechal Thaumaturgo',
                'ibge_code' => '1200351',
            ],

            64 => [
                'state_id'  => '1',
                'name'      => 'Plácido de Castro',
                'ibge_code' => '1200385',
            ],

            65 => [
                'state_id'  => '1',
                'name'      => 'Porto Walter',
                'ibge_code' => '1200393',
            ],

            66 => [
                'state_id'  => '1',
                'name'      => 'Rio Branco',
                'ibge_code' => '1200401',
            ],

            67 => [
                'state_id'  => '1',
                'name'      => 'Rodrigues Alves',
                'ibge_code' => '1200427',
            ],

            68 => [
                'state_id'  => '1',
                'name'      => 'Santa Rosa do Purus',
                'ibge_code' => '1200435',
            ],

            69 => [
                'state_id'  => '1',
                'name'      => 'Senador Guiomard',
                'ibge_code' => '1200450',
            ],

            70 => [
                'state_id'  => '1',
                'name'      => 'Sena Madureira',
                'ibge_code' => '1200500',
            ],

            71 => [
                'state_id'  => '1',
                'name'      => 'Tarauacá',
                'ibge_code' => '1200609',
            ],

            72 => [
                'state_id'  => '1',
                'name'      => 'Xapuri',
                'ibge_code' => '1200708',
            ],

            73 => [
                'state_id'  => '1',
                'name'      => 'Porto Acre',
                'ibge_code' => '1200807',
            ],

            74 => [
                'state_id'  => '3',
                'name'      => 'Alvarães',
                'ibge_code' => '1300029',
            ],

            75 => [
                'state_id'  => '3',
                'name'      => 'Amaturá',
                'ibge_code' => '1300060',
            ],

            76 => [
                'state_id'  => '3',
                'name'      => 'Anamã',
                'ibge_code' => '1300086',
            ],

            77 => [
                'state_id'  => '3',
                'name'      => 'Anori',
                'ibge_code' => '1300102',
            ],

            78 => [
                'state_id'  => '3',
                'name'      => 'Apuí',
                'ibge_code' => '1300144',
            ],

            79 => [
                'state_id'  => '3',
                'name'      => 'Atalaia do Norte',
                'ibge_code' => '1300201',
            ],

            80 => [
                'state_id'  => '3',
                'name'      => 'Autazes',
                'ibge_code' => '1300300',
            ],

            81 => [
                'state_id'  => '3',
                'name'      => 'Barcelos',
                'ibge_code' => '1300409',
            ],

            82 => [
                'state_id'  => '3',
                'name'      => 'Barreirinha',
                'ibge_code' => '1300508',
            ],

            83 => [
                'state_id'  => '3',
                'name'      => 'Benjamin Constant',
                'ibge_code' => '1300607',
            ],

            84 => [
                'state_id'  => '3',
                'name'      => 'Beruri',
                'ibge_code' => '1300631',
            ],

            85 => [
                'state_id'  => '3',
                'name'      => 'Boa Vista do Ramos',
                'ibge_code' => '1300680',
            ],

            86 => [
                'state_id'  => '3',
                'name'      => 'Boca do Acre',
                'ibge_code' => '1300706',
            ],

            87 => [
                'state_id'  => '3',
                'name'      => 'Borba',
                'ibge_code' => '1300805',
            ],

            88 => [
                'state_id'  => '3',
                'name'      => 'Caapiranga',
                'ibge_code' => '1300839',
            ],

            89 => [
                'state_id'  => '3',
                'name'      => 'Canutama',
                'ibge_code' => '1300904',
            ],

            90 => [
                'state_id'  => '3',
                'name'      => 'Carauari',
                'ibge_code' => '1301001',
            ],

            91 => [
                'state_id'  => '3',
                'name'      => 'Careiro',
                'ibge_code' => '1301100',
            ],

            92 => [
                'state_id'  => '3',
                'name'      => 'Careiro da Várzea',
                'ibge_code' => '1301159',
            ],

            93 => [
                'state_id'  => '3',
                'name'      => 'Coari',
                'ibge_code' => '1301209',
            ],

            94 => [
                'state_id'  => '3',
                'name'      => 'Codajás',
                'ibge_code' => '1301308',
            ],

            95 => [
                'state_id'  => '3',
                'name'      => 'Eirunepé',
                'ibge_code' => '1301407',
            ],

            96 => [
                'state_id'  => '3',
                'name'      => 'Envira',
                'ibge_code' => '1301506',
            ],

            97 => [
                'state_id'  => '3',
                'name'      => 'Fonte Boa',
                'ibge_code' => '1301605',
            ],

            98 => [
                'state_id'  => '3',
                'name'      => 'Guajará',
                'ibge_code' => '1301654',
            ],

            99 => [
                'state_id'  => '3',
                'name'      => 'Humaitá',
                'ibge_code' => '1301704',
            ],

            100 => [
                'state_id'  => '3',
                'name'      => 'Ipixuna',
                'ibge_code' => '1301803',
            ],

            101 => [
                'state_id'  => '3',
                'name'      => 'Iranduba',
                'ibge_code' => '1301852',
            ],

            102 => [
                'state_id'  => '3',
                'name'      => 'Itacoatiara',
                'ibge_code' => '1301902',
            ],

            103 => [
                'state_id'  => '3',
                'name'      => 'Itamarati',
                'ibge_code' => '1301951',
            ],

            104 => [
                'state_id'  => '3',
                'name'      => 'Itapiranga',
                'ibge_code' => '1302009',
            ],

            105 => [
                'state_id'  => '3',
                'name'      => 'Japurá',
                'ibge_code' => '1302108',
            ],

            106 => [
                'state_id'  => '3',
                'name'      => 'Juruá',
                'ibge_code' => '1302207',
            ],

            107 => [
                'state_id'  => '3',
                'name'      => 'Jutaí',
                'ibge_code' => '1302306',
            ],

            108 => [
                'state_id'  => '3',
                'name'      => 'Lábrea',
                'ibge_code' => '1302405',
            ],

            109 => [
                'state_id'  => '3',
                'name'      => 'Manacapuru',
                'ibge_code' => '1302504',
            ],

            110 => [
                'state_id'  => '3',
                'name'      => 'Manaquiri',
                'ibge_code' => '1302553',
            ],

            111 => [
                'state_id'  => '3',
                'name'      => 'Manaus',
                'ibge_code' => '1302603',
            ],

            112 => [
                'state_id'  => '3',
                'name'      => 'Manicoré',
                'ibge_code' => '1302702',
            ],

            113 => [
                'state_id'  => '3',
                'name'      => 'Maraã',
                'ibge_code' => '1302801',
            ],

            114 => [
                'state_id'  => '3',
                'name'      => 'Maués',
                'ibge_code' => '1302900',
            ],

            115 => [
                'state_id'  => '3',
                'name'      => 'Nhamundá',
                'ibge_code' => '1303007',
            ],

            116 => [
                'state_id'  => '3',
                'name'      => 'Nova Olinda do Norte',
                'ibge_code' => '1303106',
            ],

            117 => [
                'state_id'  => '3',
                'name'      => 'Novo Airão',
                'ibge_code' => '1303205',
            ],

            118 => [
                'state_id'  => '3',
                'name'      => 'Novo Aripuanã',
                'ibge_code' => '1303304',
            ],

            119 => [
                'state_id'  => '3',
                'name'      => 'Parintins',
                'ibge_code' => '1303403',
            ],

            120 => [
                'state_id'  => '3',
                'name'      => 'Pauini',
                'ibge_code' => '1303502',
            ],

            121 => [
                'state_id'  => '3',
                'name'      => 'Presidente Figueiredo',
                'ibge_code' => '1303536',
            ],

            122 => [
                'state_id'  => '3',
                'name'      => 'Rio Preto da Eva',
                'ibge_code' => '1303569',
            ],

            123 => [
                'state_id'  => '3',
                'name'      => 'Santa Isabel do Rio Negro',
                'ibge_code' => '1303601',
            ],

            124 => [
                'state_id'  => '3',
                'name'      => 'Santo Antônio do Içá',
                'ibge_code' => '1303700',
            ],

            125 => [
                'state_id'  => '3',
                'name'      => 'São Gabriel da Cachoeira',
                'ibge_code' => '1303809',
            ],

            126 => [
                'state_id'  => '3',
                'name'      => 'São Paulo de Olivença',
                'ibge_code' => '1303908',
            ],

            127 => [
                'state_id'  => '3',
                'name'      => 'São Sebastião do Uatumã',
                'ibge_code' => '1303957',
            ],

            128 => [
                'state_id'  => '3',
                'name'      => 'Silves',
                'ibge_code' => '1304005',
            ],

            129 => [
                'state_id'  => '3',
                'name'      => 'Tabatinga',
                'ibge_code' => '1304062',
            ],

            130 => [
                'state_id'  => '3',
                'name'      => 'Tapauá',
                'ibge_code' => '1304104',
            ],

            131 => [
                'state_id'  => '3',
                'name'      => 'Tefé',
                'ibge_code' => '1304203',
            ],

            132 => [
                'state_id'  => '3',
                'name'      => 'Tonantins',
                'ibge_code' => '1304237',
            ],

            133 => [
                'state_id'  => '3',
                'name'      => 'Uarini',
                'ibge_code' => '1304260',
            ],

            134 => [
                'state_id'  => '3',
                'name'      => 'Urucará',
                'ibge_code' => '1304302',
            ],

            135 => [
                'state_id'  => '3',
                'name'      => 'Urucurituba',
                'ibge_code' => '1304401',
            ],

            136 => [
                'state_id'  => '22',
                'name'      => 'Amajari',
                'ibge_code' => '1400027',
            ],

            137 => [
                'state_id'  => '22',
                'name'      => 'Alto Alegre',
                'ibge_code' => '1400050',
            ],

            138 => [
                'state_id'  => '22',
                'name'      => 'Boa Vista',
                'ibge_code' => '1400100',
            ],

            139 => [
                'state_id'  => '22',
                'name'      => 'Bonfim',
                'ibge_code' => '1400159',
            ],

            140 => [
                'state_id'  => '22',
                'name'      => 'Cantá',
                'ibge_code' => '1400175',
            ],

            141 => [
                'state_id'  => '22',
                'name'      => 'Caracaraí',
                'ibge_code' => '1400209',
            ],

            142 => [
                'state_id'  => '22',
                'name'      => 'Caroebe',
                'ibge_code' => '1400233',
            ],

            143 => [
                'state_id'  => '22',
                'name'      => 'Iracema',
                'ibge_code' => '1400282',
            ],

            144 => [
                'state_id'  => '22',
                'name'      => 'Mucajaí',
                'ibge_code' => '1400308',
            ],

            145 => [
                'state_id'  => '22',
                'name'      => 'Normandia',
                'ibge_code' => '1400407',
            ],

            146 => [
                'state_id'  => '22',
                'name'      => 'Pacaraima',
                'ibge_code' => '1400456',
            ],

            147 => [
                'state_id'  => '22',
                'name'      => 'Rorainópolis',
                'ibge_code' => '1400472',
            ],

            148 => [
                'state_id'  => '22',
                'name'      => 'São João da Baliza',
                'ibge_code' => '1400506',
            ],

            149 => [
                'state_id'  => '22',
                'name'      => 'São Luiz',
                'ibge_code' => '1400605',
            ],

            150 => [
                'state_id'  => '22',
                'name'      => 'Uiramutã',
                'ibge_code' => '1400704',
            ],

            151 => [
                'state_id'  => '14',
                'name'      => 'Abaetetuba',
                'ibge_code' => '1500107',
            ],

            152 => [
                'state_id'  => '14',
                'name'      => 'Abel Figueiredo',
                'ibge_code' => '1500131',
            ],

            153 => [
                'state_id'  => '14',
                'name'      => 'Acará',
                'ibge_code' => '1500206',
            ],

            154 => [
                'state_id'  => '14',
                'name'      => 'Afuá',
                'ibge_code' => '1500305',
            ],

            155 => [
                'state_id'  => '14',
                'name'      => 'Água Azul do Norte',
                'ibge_code' => '1500347',
            ],

            156 => [
                'state_id'  => '14',
                'name'      => 'Alenquer',
                'ibge_code' => '1500404',
            ],

            157 => [
                'state_id'  => '14',
                'name'      => 'Almeirim',
                'ibge_code' => '1500503',
            ],

            158 => [
                'state_id'  => '14',
                'name'      => 'Altamira',
                'ibge_code' => '1500602',
            ],

            159 => [
                'state_id'  => '14',
                'name'      => 'Anajás',
                'ibge_code' => '1500701',
            ],

            160 => [
                'state_id'  => '14',
                'name'      => 'Ananindeua',
                'ibge_code' => '1500800',
            ],

            161 => [
                'state_id'  => '14',
                'name'      => 'Anapu',
                'ibge_code' => '1500859',
            ],

            162 => [
                'state_id'  => '14',
                'name'      => 'Augusto Corrêa',
                'ibge_code' => '1500909',
            ],

            163 => [
                'state_id'  => '14',
                'name'      => 'Aurora do Pará',
                'ibge_code' => '1500958',
            ],

            164 => [
                'state_id'  => '14',
                'name'      => 'Aveiro',
                'ibge_code' => '1501006',
            ],

            165 => [
                'state_id'  => '14',
                'name'      => 'Bagre',
                'ibge_code' => '1501105',
            ],

            166 => [
                'state_id'  => '14',
                'name'      => 'Baião',
                'ibge_code' => '1501204',
            ],

            167 => [
                'state_id'  => '14',
                'name'      => 'Bannach',
                'ibge_code' => '1501253',
            ],

            168 => [
                'state_id'  => '14',
                'name'      => 'Barcarena',
                'ibge_code' => '1501303',
            ],

            169 => [
                'state_id'  => '14',
                'name'      => 'Belém',
                'ibge_code' => '1501402',
            ],

            170 => [
                'state_id'  => '14',
                'name'      => 'Belterra',
                'ibge_code' => '1501451',
            ],

            171 => [
                'state_id'  => '14',
                'name'      => 'Benevides',
                'ibge_code' => '1501501',
            ],

            172 => [
                'state_id'  => '14',
                'name'      => 'Bom Jesus do Tocantins',
                'ibge_code' => '1501576',
            ],

            173 => [
                'state_id'  => '14',
                'name'      => 'Bonito',
                'ibge_code' => '1501600',
            ],

            174 => [
                'state_id'  => '14',
                'name'      => 'Bragança',
                'ibge_code' => '1501709',
            ],

            175 => [
                'state_id'  => '14',
                'name'      => 'Brasil Novo',
                'ibge_code' => '1501725',
            ],

            176 => [
                'state_id'  => '14',
                'name'      => 'Brejo Grande do Araguaia',
                'ibge_code' => '1501758',
            ],

            177 => [
                'state_id'  => '14',
                'name'      => 'Breu Branco',
                'ibge_code' => '1501782',
            ],

            178 => [
                'state_id'  => '14',
                'name'      => 'Breves',
                'ibge_code' => '1501808',
            ],

            179 => [
                'state_id'  => '14',
                'name'      => 'Bujaru',
                'ibge_code' => '1501907',
            ],

            180 => [
                'state_id'  => '14',
                'name'      => 'Cachoeira do Piriá',
                'ibge_code' => '1501956',
            ],

            181 => [
                'state_id'  => '14',
                'name'      => 'Cachoeira do Arari',
                'ibge_code' => '1502004',
            ],

            182 => [
                'state_id'  => '14',
                'name'      => 'Cametá',
                'ibge_code' => '1502103',
            ],

            183 => [
                'state_id'  => '14',
                'name'      => 'Canaã dos Carajás',
                'ibge_code' => '1502152',
            ],

            184 => [
                'state_id'  => '14',
                'name'      => 'Capanema',
                'ibge_code' => '1502202',
            ],

            185 => [
                'state_id'  => '14',
                'name'      => 'Capitão Poço',
                'ibge_code' => '1502301',
            ],

            186 => [
                'state_id'  => '14',
                'name'      => 'Castanhal',
                'ibge_code' => '1502400',
            ],

            187 => [
                'state_id'  => '14',
                'name'      => 'Chaves',
                'ibge_code' => '1502509',
            ],

            188 => [
                'state_id'  => '14',
                'name'      => 'Colares',
                'ibge_code' => '1502608',
            ],

            189 => [
                'state_id'  => '14',
                'name'      => 'Conceição do Araguaia',
                'ibge_code' => '1502707',
            ],

            190 => [
                'state_id'  => '14',
                'name'      => 'Concórdia do Pará',
                'ibge_code' => '1502756',
            ],

            191 => [
                'state_id'  => '14',
                'name'      => 'Cumaru do Norte',
                'ibge_code' => '1502764',
            ],

            192 => [
                'state_id'  => '14',
                'name'      => 'Curionópolis',
                'ibge_code' => '1502772',
            ],

            193 => [
                'state_id'  => '14',
                'name'      => 'Curralinho',
                'ibge_code' => '1502806',
            ],

            194 => [
                'state_id'  => '14',
                'name'      => 'Curuá',
                'ibge_code' => '1502855',
            ],

            195 => [
                'state_id'  => '14',
                'name'      => 'Curuçá',
                'ibge_code' => '1502905',
            ],

            196 => [
                'state_id'  => '14',
                'name'      => 'Dom Eliseu',
                'ibge_code' => '1502939',
            ],

            197 => [
                'state_id'  => '14',
                'name'      => 'Eldorado dos Carajás',
                'ibge_code' => '1502954',
            ],

            198 => [
                'state_id'  => '14',
                'name'      => 'Faro',
                'ibge_code' => '1503002',
            ],

            199 => [
                'state_id'  => '14',
                'name'      => 'Floresta do Araguaia',
                'ibge_code' => '1503044',
            ],

            200 => [
                'state_id'  => '14',
                'name'      => 'Garrafão do Norte',
                'ibge_code' => '1503077',
            ],

            201 => [
                'state_id'  => '14',
                'name'      => 'Goianésia do Pará',
                'ibge_code' => '1503093',
            ],

            202 => [
                'state_id'  => '14',
                'name'      => 'Gurupá',
                'ibge_code' => '1503101',
            ],

            203 => [
                'state_id'  => '14',
                'name'      => 'Igarapé-Açu',
                'ibge_code' => '1503200',
            ],

            204 => [
                'state_id'  => '14',
                'name'      => 'Igarapé-Miri',
                'ibge_code' => '1503309',
            ],

            205 => [
                'state_id'  => '14',
                'name'      => 'Inhangapi',
                'ibge_code' => '1503408',
            ],

            206 => [
                'state_id'  => '14',
                'name'      => 'Ipixuna do Pará',
                'ibge_code' => '1503457',
            ],

            207 => [
                'state_id'  => '14',
                'name'      => 'Irituia',
                'ibge_code' => '1503507',
            ],

            208 => [
                'state_id'  => '14',
                'name'      => 'Itaituba',
                'ibge_code' => '1503606',
            ],

            209 => [
                'state_id'  => '14',
                'name'      => 'Itupiranga',
                'ibge_code' => '1503705',
            ],

            210 => [
                'state_id'  => '14',
                'name'      => 'Jacareacanga',
                'ibge_code' => '1503754',
            ],

            211 => [
                'state_id'  => '14',
                'name'      => 'Jacundá',
                'ibge_code' => '1503804',
            ],

            212 => [
                'state_id'  => '14',
                'name'      => 'Juruti',
                'ibge_code' => '1503903',
            ],

            213 => [
                'state_id'  => '14',
                'name'      => 'Limoeiro do Ajuru',
                'ibge_code' => '1504000',
            ],

            214 => [
                'state_id'  => '14',
                'name'      => 'Mãe do Rio',
                'ibge_code' => '1504059',
            ],

            215 => [
                'state_id'  => '14',
                'name'      => 'Magalhães Barata',
                'ibge_code' => '1504109',
            ],

            216 => [
                'state_id'  => '14',
                'name'      => 'Marabá',
                'ibge_code' => '1504208',
            ],

            217 => [
                'state_id'  => '14',
                'name'      => 'Maracanã',
                'ibge_code' => '1504307',
            ],

            218 => [
                'state_id'  => '14',
                'name'      => 'Marapanim',
                'ibge_code' => '1504406',
            ],

            219 => [
                'state_id'  => '14',
                'name'      => 'Marituba',
                'ibge_code' => '1504422',
            ],

            220 => [
                'state_id'  => '14',
                'name'      => 'Medicilândia',
                'ibge_code' => '1504455',
            ],

            221 => [
                'state_id'  => '14',
                'name'      => 'Melgaço',
                'ibge_code' => '1504505',
            ],

            222 => [
                'state_id'  => '14',
                'name'      => 'Mocajuba',
                'ibge_code' => '1504604',
            ],

            223 => [
                'state_id'  => '14',
                'name'      => 'Moju',
                'ibge_code' => '1504703',
            ],

            224 => [
                'state_id'  => '14',
                'name'      => 'Monte Alegre',
                'ibge_code' => '1504802',
            ],

            225 => [
                'state_id'  => '14',
                'name'      => 'Muaná',
                'ibge_code' => '1504901',
            ],

            226 => [
                'state_id'  => '14',
                'name'      => 'Nova Esperança do Piriá',
                'ibge_code' => '1504950',
            ],

            227 => [
                'state_id'  => '14',
                'name'      => 'Nova Ipixuna',
                'ibge_code' => '1504976',
            ],

            228 => [
                'state_id'  => '14',
                'name'      => 'Nova Timboteua',
                'ibge_code' => '1505007',
            ],

            229 => [
                'state_id'  => '14',
                'name'      => 'Novo Progresso',
                'ibge_code' => '1505031',
            ],

            230 => [
                'state_id'  => '14',
                'name'      => 'Novo Repartimento',
                'ibge_code' => '1505064',
            ],

            231 => [
                'state_id'  => '14',
                'name'      => 'Óbidos',
                'ibge_code' => '1505106',
            ],

            232 => [
                'state_id'  => '14',
                'name'      => 'Oeiras do Pará',
                'ibge_code' => '1505205',
            ],

            233 => [
                'state_id'  => '14',
                'name'      => 'Oriximiná',
                'ibge_code' => '1505304',
            ],

            234 => [
                'state_id'  => '14',
                'name'      => 'Ourém',
                'ibge_code' => '1505403',
            ],

            235 => [
                'state_id'  => '14',
                'name'      => 'Ourilândia do Norte',
                'ibge_code' => '1505437',
            ],

            236 => [
                'state_id'  => '14',
                'name'      => 'Pacajá',
                'ibge_code' => '1505486',
            ],

            237 => [
                'state_id'  => '14',
                'name'      => 'Palestina do Pará',
                'ibge_code' => '1505494',
            ],

            238 => [
                'state_id'  => '14',
                'name'      => 'Paragominas',
                'ibge_code' => '1505502',
            ],

            239 => [
                'state_id'  => '14',
                'name'      => 'Parauapebas',
                'ibge_code' => '1505536',
            ],

            240 => [
                'state_id'  => '14',
                'name'      => "Pau D'arco",
                'ibge_code' => '1505551',
            ],

            241 => [
                'state_id'  => '14',
                'name'      => 'Peixe-Boi',
                'ibge_code' => '1505601',
            ],

            242 => [
                'state_id'  => '14',
                'name'      => 'Piçarra',
                'ibge_code' => '1505635',
            ],

            243 => [
                'state_id'  => '14',
                'name'      => 'Placas',
                'ibge_code' => '1505650',
            ],

            244 => [
                'state_id'  => '14',
                'name'      => 'Ponta de Pedras',
                'ibge_code' => '1505700',
            ],

            245 => [
                'state_id'  => '14',
                'name'      => 'Portel',
                'ibge_code' => '1505809',
            ],

            246 => [
                'state_id'  => '14',
                'name'      => 'Porto de Moz',
                'ibge_code' => '1505908',
            ],

            247 => [
                'state_id'  => '14',
                'name'      => 'Prainha',
                'ibge_code' => '1506005',
            ],

            248 => [
                'state_id'  => '14',
                'name'      => 'Primavera',
                'ibge_code' => '1506104',
            ],

            249 => [
                'state_id'  => '14',
                'name'      => 'Quatipuru',
                'ibge_code' => '1506112',
            ],

            250 => [
                'state_id'  => '14',
                'name'      => 'Redenção',
                'ibge_code' => '1506138',
            ],

            251 => [
                'state_id'  => '14',
                'name'      => 'Rio Maria',
                'ibge_code' => '1506161',
            ],

            252 => [
                'state_id'  => '14',
                'name'      => 'Rondon do Pará',
                'ibge_code' => '1506187',
            ],

            253 => [
                'state_id'  => '14',
                'name'      => 'Rurópolis',
                'ibge_code' => '1506195',
            ],

            254 => [
                'state_id'  => '14',
                'name'      => 'Salinópolis',
                'ibge_code' => '1506203',
            ],

            255 => [
                'state_id'  => '14',
                'name'      => 'Salvaterra',
                'ibge_code' => '1506302',
            ],

            256 => [
                'state_id'  => '14',
                'name'      => 'Santa Bárbara do Pará',
                'ibge_code' => '1506351',
            ],

            257 => [
                'state_id'  => '14',
                'name'      => 'Santa Cruz do Arari',
                'ibge_code' => '1506401',
            ],

            258 => [
                'state_id'  => '14',
                'name'      => 'Santa Isabel do Pará',
                'ibge_code' => '1506500',
            ],

            259 => [
                'state_id'  => '14',
                'name'      => 'Santa Luzia do Pará',
                'ibge_code' => '1506559',
            ],

            260 => [
                'state_id'  => '14',
                'name'      => 'Santa Maria das Barreiras',
                'ibge_code' => '1506583',
            ],

            261 => [
                'state_id'  => '14',
                'name'      => 'Santa Maria do Pará',
                'ibge_code' => '1506609',
            ],

            262 => [
                'state_id'  => '14',
                'name'      => 'Santana do Araguaia',
                'ibge_code' => '1506708',
            ],

            263 => [
                'state_id'  => '14',
                'name'      => 'Santarém',
                'ibge_code' => '1506807',
            ],

            264 => [
                'state_id'  => '14',
                'name'      => 'Santarém Novo',
                'ibge_code' => '1506906',
            ],

            265 => [
                'state_id'  => '14',
                'name'      => 'Santo Antônio do Tauá',
                'ibge_code' => '1507003',
            ],

            266 => [
                'state_id'  => '14',
                'name'      => 'São Caetano de Odivelas',
                'ibge_code' => '1507102',
            ],

            267 => [
                'state_id'  => '14',
                'name'      => 'São Domingos do Araguaia',
                'ibge_code' => '1507151',
            ],

            268 => [
                'state_id'  => '14',
                'name'      => 'São Domingos do Capim',
                'ibge_code' => '1507201',
            ],

            269 => [
                'state_id'  => '14',
                'name'      => 'São Félix do Xingu',
                'ibge_code' => '1507300',
            ],

            270 => [
                'state_id'  => '14',
                'name'      => 'São Francisco do Pará',
                'ibge_code' => '1507409',
            ],

            271 => [
                'state_id'  => '14',
                'name'      => 'São Geraldo do Araguaia',
                'ibge_code' => '1507458',
            ],

            272 => [
                'state_id'  => '14',
                'name'      => 'São João da Ponta',
                'ibge_code' => '1507466',
            ],

            273 => [
                'state_id'  => '14',
                'name'      => 'São João de Pirabas',
                'ibge_code' => '1507474',
            ],

            274 => [
                'state_id'  => '14',
                'name'      => 'São João do Araguaia',
                'ibge_code' => '1507508',
            ],

            275 => [
                'state_id'  => '14',
                'name'      => 'São Miguel do Guamá',
                'ibge_code' => '1507607',
            ],

            276 => [
                'state_id'  => '14',
                'name'      => 'São Sebastião da Boa Vista',
                'ibge_code' => '1507706',
            ],

            277 => [
                'state_id'  => '14',
                'name'      => 'Sapucaia',
                'ibge_code' => '1507755',
            ],

            278 => [
                'state_id'  => '14',
                'name'      => 'Senador José Porfírio',
                'ibge_code' => '1507805',
            ],

            279 => [
                'state_id'  => '14',
                'name'      => 'Soure',
                'ibge_code' => '1507904',
            ],

            280 => [
                'state_id'  => '14',
                'name'      => 'Tailândia',
                'ibge_code' => '1507953',
            ],

            281 => [
                'state_id'  => '14',
                'name'      => 'Terra Alta',
                'ibge_code' => '1507961',
            ],

            282 => [
                'state_id'  => '14',
                'name'      => 'Terra Santa',
                'ibge_code' => '1507979',
            ],

            283 => [
                'state_id'  => '14',
                'name'      => 'Tomé-Açu',
                'ibge_code' => '1508001',
            ],

            284 => [
                'state_id'  => '14',
                'name'      => 'Tracuateua',
                'ibge_code' => '1508035',
            ],

            285 => [
                'state_id'  => '14',
                'name'      => 'Trairão',
                'ibge_code' => '1508050',
            ],

            286 => [
                'state_id'  => '14',
                'name'      => 'Tucumã',
                'ibge_code' => '1508084',
            ],

            287 => [
                'state_id'  => '14',
                'name'      => 'Tucuruí',
                'ibge_code' => '1508100',
            ],

            288 => [
                'state_id'  => '14',
                'name'      => 'Ulianópolis',
                'ibge_code' => '1508126',
            ],

            289 => [
                'state_id'  => '14',
                'name'      => 'Uruará',
                'ibge_code' => '1508159',
            ],

            290 => [
                'state_id'  => '14',
                'name'      => 'Vigia',
                'ibge_code' => '1508209',
            ],

            291 => [
                'state_id'  => '14',
                'name'      => 'Viseu',
                'ibge_code' => '1508308',
            ],

            292 => [
                'state_id'  => '14',
                'name'      => 'Vitória do Xingu',
                'ibge_code' => '1508357',
            ],

            293 => [
                'state_id'  => '14',
                'name'      => 'Xinguara',
                'ibge_code' => '1508407',
            ],

            294 => [
                'state_id'  => '4',
                'name'      => 'Serra do Navio',
                'ibge_code' => '1600055',
            ],

            295 => [
                'state_id'  => '4',
                'name'      => 'Amapá',
                'ibge_code' => '1600105',
            ],

            296 => [
                'state_id'  => '4',
                'name'      => 'Pedra Branca do Amapari',
                'ibge_code' => '1600154',
            ],

            297 => [
                'state_id'  => '4',
                'name'      => 'Calçoene',
                'ibge_code' => '1600204',
            ],

            298 => [
                'state_id'  => '4',
                'name'      => 'Cutias',
                'ibge_code' => '1600212',
            ],

            299 => [
                'state_id'  => '4',
                'name'      => 'Ferreira Gomes',
                'ibge_code' => '1600238',
            ],

            300 => [
                'state_id'  => '4',
                'name'      => 'Itaubal',
                'ibge_code' => '1600253',
            ],

            301 => [
                'state_id'  => '4',
                'name'      => 'Laranjal do Jari',
                'ibge_code' => '1600279',
            ],

            302 => [
                'state_id'  => '4',
                'name'      => 'Macapá',
                'ibge_code' => '1600303',
            ],

            303 => [
                'state_id'  => '4',
                'name'      => 'Mazagão',
                'ibge_code' => '1600402',
            ],

            304 => [
                'state_id'  => '4',
                'name'      => 'Oiapoque',
                'ibge_code' => '1600501',
            ],

            305 => [
                'state_id'  => '4',
                'name'      => 'Porto Grande',
                'ibge_code' => '1600535',
            ],

            306 => [
                'state_id'  => '4',
                'name'      => 'Pracuúba',
                'ibge_code' => '1600550',
            ],

            307 => [
                'state_id'  => '4',
                'name'      => 'Santana',
                'ibge_code' => '1600600',
            ],

            308 => [
                'state_id'  => '4',
                'name'      => 'Tartarugalzinho',
                'ibge_code' => '1600709',
            ],

            309 => [
                'state_id'  => '4',
                'name'      => 'Vitória do Jari',
                'ibge_code' => '1600808',
            ],

            310 => [
                'state_id'  => '27',
                'name'      => 'Abreulândia',
                'ibge_code' => '1700251',
            ],

            311 => [
                'state_id'  => '27',
                'name'      => 'Aguiarnópolis',
                'ibge_code' => '1700301',
            ],

            312 => [
                'state_id'  => '27',
                'name'      => 'Aliança do Tocantins',
                'ibge_code' => '1700350',
            ],

            313 => [
                'state_id'  => '27',
                'name'      => 'Almas',
                'ibge_code' => '1700400',
            ],

            314 => [
                'state_id'  => '27',
                'name'      => 'Alvorada',
                'ibge_code' => '1700707',
            ],

            315 => [
                'state_id'  => '27',
                'name'      => 'Ananás',
                'ibge_code' => '1701002',
            ],

            316 => [
                'state_id'  => '27',
                'name'      => 'Angico',
                'ibge_code' => '1701051',
            ],

            317 => [
                'state_id'  => '27',
                'name'      => 'Aparecida do Rio Negro',
                'ibge_code' => '1701101',
            ],

            318 => [
                'state_id'  => '27',
                'name'      => 'Aragominas',
                'ibge_code' => '1701309',
            ],

            319 => [
                'state_id'  => '27',
                'name'      => 'Araguacema',
                'ibge_code' => '1701903',
            ],

            320 => [
                'state_id'  => '27',
                'name'      => 'Araguaçu',
                'ibge_code' => '1702000',
            ],

            321 => [
                'state_id'  => '27',
                'name'      => 'Araguaína',
                'ibge_code' => '1702109',
            ],

            322 => [
                'state_id'  => '27',
                'name'      => 'Araguanã',
                'ibge_code' => '1702158',
            ],

            323 => [
                'state_id'  => '27',
                'name'      => 'Araguatins',
                'ibge_code' => '1702208',
            ],

            324 => [
                'state_id'  => '27',
                'name'      => 'Arapoema',
                'ibge_code' => '1702307',
            ],

            325 => [
                'state_id'  => '27',
                'name'      => 'Arraias',
                'ibge_code' => '1702406',
            ],

            326 => [
                'state_id'  => '27',
                'name'      => 'Augustinópolis',
                'ibge_code' => '1702554',
            ],

            327 => [
                'state_id'  => '27',
                'name'      => 'Aurora do Tocantins',
                'ibge_code' => '1702703',
            ],

            328 => [
                'state_id'  => '27',
                'name'      => 'Axixá do Tocantins',
                'ibge_code' => '1702901',
            ],

            329 => [
                'state_id'  => '27',
                'name'      => 'Babaçulândia',
                'ibge_code' => '1703008',
            ],

            330 => [
                'state_id'  => '27',
                'name'      => 'Bandeirantes do Tocantins',
                'ibge_code' => '1703057',
            ],

            331 => [
                'state_id'  => '27',
                'name'      => 'Barra do Ouro',
                'ibge_code' => '1703073',
            ],

            332 => [
                'state_id'  => '27',
                'name'      => 'Barrolândia',
                'ibge_code' => '1703107',
            ],

            333 => [
                'state_id'  => '27',
                'name'      => 'Bernardo Sayão',
                'ibge_code' => '1703206',
            ],

            334 => [
                'state_id'  => '27',
                'name'      => 'Bom Jesus do Tocantins',
                'ibge_code' => '1703305',
            ],

            335 => [
                'state_id'  => '27',
                'name'      => 'Brasilândia do Tocantins',
                'ibge_code' => '1703602',
            ],

            336 => [
                'state_id'  => '27',
                'name'      => 'Brejinho de Nazaré',
                'ibge_code' => '1703701',
            ],

            337 => [
                'state_id'  => '27',
                'name'      => 'Buriti do Tocantins',
                'ibge_code' => '1703800',
            ],

            338 => [
                'state_id'  => '27',
                'name'      => 'Cachoeirinha',
                'ibge_code' => '1703826',
            ],

            339 => [
                'state_id'  => '27',
                'name'      => 'Campos Lindos',
                'ibge_code' => '1703842',
            ],

            340 => [
                'state_id'  => '27',
                'name'      => 'Cariri do Tocantins',
                'ibge_code' => '1703867',
            ],

            341 => [
                'state_id'  => '27',
                'name'      => 'Carmolândia',
                'ibge_code' => '1703883',
            ],

            342 => [
                'state_id'  => '27',
                'name'      => 'Carrasco Bonito',
                'ibge_code' => '1703891',
            ],

            343 => [
                'state_id'  => '27',
                'name'      => 'Caseara',
                'ibge_code' => '1703909',
            ],

            344 => [
                'state_id'  => '27',
                'name'      => 'Centenário',
                'ibge_code' => '1704105',
            ],

            345 => [
                'state_id'  => '27',
                'name'      => 'Chapada de Areia',
                'ibge_code' => '1704600',
            ],

            346 => [
                'state_id'  => '27',
                'name'      => 'Chapada da Natividade',
                'ibge_code' => '1705102',
            ],

            347 => [
                'state_id'  => '27',
                'name'      => 'Colinas do Tocantins',
                'ibge_code' => '1705508',
            ],

            348 => [
                'state_id'  => '27',
                'name'      => 'Combinado',
                'ibge_code' => '1705557',
            ],

            349 => [
                'state_id'  => '27',
                'name'      => 'Conceição do Tocantins',
                'ibge_code' => '1705607',
            ],

            350 => [
                'state_id'  => '27',
                'name'      => 'Couto de Magalhães',
                'ibge_code' => '1706001',
            ],

            351 => [
                'state_id'  => '27',
                'name'      => 'Cristalândia',
                'ibge_code' => '1706100',
            ],

            352 => [
                'state_id'  => '27',
                'name'      => 'Crixás do Tocantins',
                'ibge_code' => '1706258',
            ],

            353 => [
                'state_id'  => '27',
                'name'      => 'Darcinópolis',
                'ibge_code' => '1706506',
            ],

            354 => [
                'state_id'  => '27',
                'name'      => 'Dianópolis',
                'ibge_code' => '1707009',
            ],

            355 => [
                'state_id'  => '27',
                'name'      => 'Divinópolis do Tocantins',
                'ibge_code' => '1707108',
            ],

            356 => [
                'state_id'  => '27',
                'name'      => 'Dois Irmãos do Tocantins',
                'ibge_code' => '1707207',
            ],

            357 => [
                'state_id'  => '27',
                'name'      => 'Dueré',
                'ibge_code' => '1707306',
            ],

            358 => [
                'state_id'  => '27',
                'name'      => 'Esperantina',
                'ibge_code' => '1707405',
            ],

            359 => [
                'state_id'  => '27',
                'name'      => 'Fátima',
                'ibge_code' => '1707553',
            ],

            360 => [
                'state_id'  => '27',
                'name'      => 'Figueirópolis',
                'ibge_code' => '1707652',
            ],

            361 => [
                'state_id'  => '27',
                'name'      => 'Filadélfia',
                'ibge_code' => '1707702',
            ],

            362 => [
                'state_id'  => '27',
                'name'      => 'Formoso do Araguaia',
                'ibge_code' => '1708205',
            ],

            363 => [
                'state_id'  => '27',
                'name'      => 'Fortaleza do Tabocão',
                'ibge_code' => '1708254',
            ],

            364 => [
                'state_id'  => '27',
                'name'      => 'Goianorte',
                'ibge_code' => '1708304',
            ],

            365 => [
                'state_id'  => '27',
                'name'      => 'Goiatins',
                'ibge_code' => '1709005',
            ],

            366 => [
                'state_id'  => '27',
                'name'      => 'Guaraí',
                'ibge_code' => '1709302',
            ],

            367 => [
                'state_id'  => '27',
                'name'      => 'Gurupi',
                'ibge_code' => '1709500',
            ],

            368 => [
                'state_id'  => '27',
                'name'      => 'Ipueiras',
                'ibge_code' => '1709807',
            ],

            369 => [
                'state_id'  => '27',
                'name'      => 'Itacajá',
                'ibge_code' => '1710508',
            ],

            370 => [
                'state_id'  => '27',
                'name'      => 'Itaguatins',
                'ibge_code' => '1710706',
            ],

            371 => [
                'state_id'  => '27',
                'name'      => 'Itapiratins',
                'ibge_code' => '1710904',
            ],

            372 => [
                'state_id'  => '27',
                'name'      => 'Itaporã do Tocantins',
                'ibge_code' => '1711100',
            ],

            373 => [
                'state_id'  => '27',
                'name'      => 'Jaú do Tocantins',
                'ibge_code' => '1711506',
            ],

            374 => [
                'state_id'  => '27',
                'name'      => 'Juarina',
                'ibge_code' => '1711803',
            ],

            375 => [
                'state_id'  => '27',
                'name'      => 'Lagoa da Confusão',
                'ibge_code' => '1711902',
            ],

            376 => [
                'state_id'  => '27',
                'name'      => 'Lagoa do Tocantins',
                'ibge_code' => '1711951',
            ],

            377 => [
                'state_id'  => '27',
                'name'      => 'Lajeado',
                'ibge_code' => '1712009',
            ],

            378 => [
                'state_id'  => '27',
                'name'      => 'Lavandeira',
                'ibge_code' => '1712157',
            ],

            379 => [
                'state_id'  => '27',
                'name'      => 'Lizarda',
                'ibge_code' => '1712405',
            ],

            380 => [
                'state_id'  => '27',
                'name'      => 'Luzinópolis',
                'ibge_code' => '1712454',
            ],

            381 => [
                'state_id'  => '27',
                'name'      => 'Marianópolis do Tocantins',
                'ibge_code' => '1712504',
            ],

            382 => [
                'state_id'  => '27',
                'name'      => 'Mateiros',
                'ibge_code' => '1712702',
            ],

            383 => [
                'state_id'  => '27',
                'name'      => 'Maurilândia do Tocantins',
                'ibge_code' => '1712801',
            ],

            384 => [
                'state_id'  => '27',
                'name'      => 'Miracema do Tocantins',
                'ibge_code' => '1713205',
            ],

            385 => [
                'state_id'  => '27',
                'name'      => 'Miranorte',
                'ibge_code' => '1713304',
            ],

            386 => [
                'state_id'  => '27',
                'name'      => 'Monte do Carmo',
                'ibge_code' => '1713601',
            ],

            387 => [
                'state_id'  => '27',
                'name'      => 'Monte Santo do Tocantins',
                'ibge_code' => '1713700',
            ],

            388 => [
                'state_id'  => '27',
                'name'      => 'Palmeiras do Tocantins',
                'ibge_code' => '1713809',
            ],

            389 => [
                'state_id'  => '27',
                'name'      => 'Muricilândia',
                'ibge_code' => '1713957',
            ],

            390 => [
                'state_id'  => '27',
                'name'      => 'Natividade',
                'ibge_code' => '1714203',
            ],

            391 => [
                'state_id'  => '27',
                'name'      => 'Nazaré',
                'ibge_code' => '1714302',
            ],

            392 => [
                'state_id'  => '27',
                'name'      => 'Nova Olinda',
                'ibge_code' => '1714880',
            ],

            393 => [
                'state_id'  => '27',
                'name'      => 'Nova Rosalândia',
                'ibge_code' => '1715002',
            ],

            394 => [
                'state_id'  => '27',
                'name'      => 'Novo Acordo',
                'ibge_code' => '1715101',
            ],

            395 => [
                'state_id'  => '27',
                'name'      => 'Novo Alegre',
                'ibge_code' => '1715150',
            ],

            396 => [
                'state_id'  => '27',
                'name'      => 'Novo Jardim',
                'ibge_code' => '1715259',
            ],

            397 => [
                'state_id'  => '27',
                'name'      => 'Oliveira de Fátima',
                'ibge_code' => '1715507',
            ],

            398 => [
                'state_id'  => '27',
                'name'      => 'Palmeirante',
                'ibge_code' => '1715705',
            ],

            399 => [
                'state_id'  => '27',
                'name'      => 'Palmeirópolis',
                'ibge_code' => '1715754',
            ],

            400 => [
                'state_id'  => '27',
                'name'      => 'Paraíso do Tocantins',
                'ibge_code' => '1716109',
            ],

            401 => [
                'state_id'  => '27',
                'name'      => 'Paranã',
                'ibge_code' => '1716208',
            ],

            402 => [
                'state_id'  => '27',
                'name'      => "Pau D'arco",
                'ibge_code' => '1716307',
            ],

            403 => [
                'state_id'  => '27',
                'name'      => 'Pedro Afonso',
                'ibge_code' => '1716505',
            ],

            404 => [
                'state_id'  => '27',
                'name'      => 'Peixe',
                'ibge_code' => '1716604',
            ],

            405 => [
                'state_id'  => '27',
                'name'      => 'Pequizeiro',
                'ibge_code' => '1716653',
            ],

            406 => [
                'state_id'  => '27',
                'name'      => 'Colméia',
                'ibge_code' => '1716703',
            ],

            407 => [
                'state_id'  => '27',
                'name'      => 'Pindorama do Tocantins',
                'ibge_code' => '1717008',
            ],

            408 => [
                'state_id'  => '27',
                'name'      => 'Piraquê',
                'ibge_code' => '1717206',
            ],

            409 => [
                'state_id'  => '27',
                'name'      => 'Pium',
                'ibge_code' => '1717503',
            ],

            410 => [
                'state_id'  => '27',
                'name'      => 'Ponte Alta do Bom Jesus',
                'ibge_code' => '1717800',
            ],

            411 => [
                'state_id'  => '27',
                'name'      => 'Ponte Alta do Tocantins',
                'ibge_code' => '1717909',
            ],

            412 => [
                'state_id'  => '27',
                'name'      => 'Porto Alegre do Tocantins',
                'ibge_code' => '1718006',
            ],

            413 => [
                'state_id'  => '27',
                'name'      => 'Porto Nacional',
                'ibge_code' => '1718204',
            ],

            414 => [
                'state_id'  => '27',
                'name'      => 'Praia Norte',
                'ibge_code' => '1718303',
            ],

            415 => [
                'state_id'  => '27',
                'name'      => 'Presidente Kennedy',
                'ibge_code' => '1718402',
            ],

            416 => [
                'state_id'  => '27',
                'name'      => 'Pugmil',
                'ibge_code' => '1718451',
            ],

            417 => [
                'state_id'  => '27',
                'name'      => 'Recursolândia',
                'ibge_code' => '1718501',
            ],

            418 => [
                'state_id'  => '27',
                'name'      => 'Riachinho',
                'ibge_code' => '1718550',
            ],

            419 => [
                'state_id'  => '27',
                'name'      => 'Rio da Conceição',
                'ibge_code' => '1718659',
            ],

            420 => [
                'state_id'  => '27',
                'name'      => 'Rio dos Bois',
                'ibge_code' => '1718709',
            ],

            421 => [
                'state_id'  => '27',
                'name'      => 'Rio Sono',
                'ibge_code' => '1718758',
            ],

            422 => [
                'state_id'  => '27',
                'name'      => 'Sampaio',
                'ibge_code' => '1718808',
            ],

            423 => [
                'state_id'  => '27',
                'name'      => 'Sandolândia',
                'ibge_code' => '1718840',
            ],

            424 => [
                'state_id'  => '27',
                'name'      => 'Santa Fé do Araguaia',
                'ibge_code' => '1718865',
            ],

            425 => [
                'state_id'  => '27',
                'name'      => 'Santa Maria do Tocantins',
                'ibge_code' => '1718881',
            ],

            426 => [
                'state_id'  => '27',
                'name'      => 'Santa Rita do Tocantins',
                'ibge_code' => '1718899',
            ],

            427 => [
                'state_id'  => '27',
                'name'      => 'Santa Rosa do Tocantins',
                'ibge_code' => '1718907',
            ],

            428 => [
                'state_id'  => '27',
                'name'      => 'Santa Tereza do Tocantins',
                'ibge_code' => '1719004',
            ],

            429 => [
                'state_id'  => '27',
                'name'      => 'Santa Terezinha do Tocantins',
                'ibge_code' => '1720002',
            ],

            430 => [
                'state_id'  => '27',
                'name'      => 'São Bento do Tocantins',
                'ibge_code' => '1720101',
            ],

            431 => [
                'state_id'  => '27',
                'name'      => 'São Félix do Tocantins',
                'ibge_code' => '1720150',
            ],

            432 => [
                'state_id'  => '27',
                'name'      => 'São Miguel do Tocantins',
                'ibge_code' => '1720200',
            ],

            433 => [
                'state_id'  => '27',
                'name'      => 'São Salvador do Tocantins',
                'ibge_code' => '1720259',
            ],

            434 => [
                'state_id'  => '27',
                'name'      => 'São Sebastião do Tocantins',
                'ibge_code' => '1720309',
            ],

            435 => [
                'state_id'  => '27',
                'name'      => 'São Valério da Natividade',
                'ibge_code' => '1720499',
            ],

            436 => [
                'state_id'  => '27',
                'name'      => 'Silvanópolis',
                'ibge_code' => '1720655',
            ],

            437 => [
                'state_id'  => '27',
                'name'      => 'Sítio Novo do Tocantins',
                'ibge_code' => '1720804',
            ],

            438 => [
                'state_id'  => '27',
                'name'      => 'Sucupira',
                'ibge_code' => '1720853',
            ],

            439 => [
                'state_id'  => '27',
                'name'      => 'Taguatinga',
                'ibge_code' => '1720903',
            ],

            440 => [
                'state_id'  => '27',
                'name'      => 'Taipas do Tocantins',
                'ibge_code' => '1720937',
            ],

            441 => [
                'state_id'  => '27',
                'name'      => 'Talismã',
                'ibge_code' => '1720978',
            ],

            442 => [
                'state_id'  => '27',
                'name'      => 'Palmas',
                'ibge_code' => '1721000',
            ],

            443 => [
                'state_id'  => '27',
                'name'      => 'Tocantínia',
                'ibge_code' => '1721109',
            ],

            444 => [
                'state_id'  => '27',
                'name'      => 'Tocantinópolis',
                'ibge_code' => '1721208',
            ],

            445 => [
                'state_id'  => '27',
                'name'      => 'Tupirama',
                'ibge_code' => '1721257',
            ],

            446 => [
                'state_id'  => '27',
                'name'      => 'Tupiratins',
                'ibge_code' => '1721307',
            ],

            447 => [
                'state_id'  => '27',
                'name'      => 'Wanderlândia',
                'ibge_code' => '1722081',
            ],

            448 => [
                'state_id'  => '27',
                'name'      => 'Xambioá',
                'ibge_code' => '1722107',
            ],

            449 => [
                'state_id'  => '10',
                'name'      => 'Açailândia',
                'ibge_code' => '2100055',
            ],

            450 => [
                'state_id'  => '10',
                'name'      => 'Afonso Cunha',
                'ibge_code' => '2100105',
            ],

            451 => [
                'state_id'  => '10',
                'name'      => 'Água Doce do Maranhão',
                'ibge_code' => '2100154',
            ],

            452 => [
                'state_id'  => '10',
                'name'      => 'Alcântara',
                'ibge_code' => '2100204',
            ],

            453 => [
                'state_id'  => '10',
                'name'      => 'Aldeias Altas',
                'ibge_code' => '2100303',
            ],

            454 => [
                'state_id'  => '10',
                'name'      => 'Altamira do Maranhão',
                'ibge_code' => '2100402',
            ],

            455 => [
                'state_id'  => '10',
                'name'      => 'Alto Alegre do Maranhão',
                'ibge_code' => '2100436',
            ],

            456 => [
                'state_id'  => '10',
                'name'      => 'Alto Alegre do Pindaré',
                'ibge_code' => '2100477',
            ],

            457 => [
                'state_id'  => '10',
                'name'      => 'Alto Parnaíba',
                'ibge_code' => '2100501',
            ],

            458 => [
                'state_id'  => '10',
                'name'      => 'Amapá do Maranhão',
                'ibge_code' => '2100550',
            ],

            459 => [
                'state_id'  => '10',
                'name'      => 'Amarante do Maranhão',
                'ibge_code' => '2100600',
            ],

            460 => [
                'state_id'  => '10',
                'name'      => 'Anajatuba',
                'ibge_code' => '2100709',
            ],

            461 => [
                'state_id'  => '10',
                'name'      => 'Anapurus',
                'ibge_code' => '2100808',
            ],

            462 => [
                'state_id'  => '10',
                'name'      => 'Apicum-Açu',
                'ibge_code' => '2100832',
            ],

            463 => [
                'state_id'  => '10',
                'name'      => 'Araguanã',
                'ibge_code' => '2100873',
            ],

            464 => [
                'state_id'  => '10',
                'name'      => 'Araioses',
                'ibge_code' => '2100907',
            ],

            465 => [
                'state_id'  => '10',
                'name'      => 'Arame',
                'ibge_code' => '2100956',
            ],

            466 => [
                'state_id'  => '10',
                'name'      => 'Arari',
                'ibge_code' => '2101004',
            ],

            467 => [
                'state_id'  => '10',
                'name'      => 'Axixá',
                'ibge_code' => '2101103',
            ],

            468 => [
                'state_id'  => '10',
                'name'      => 'Bacabal',
                'ibge_code' => '2101202',
            ],

            469 => [
                'state_id'  => '10',
                'name'      => 'Bacabeira',
                'ibge_code' => '2101251',
            ],

            470 => [
                'state_id'  => '10',
                'name'      => 'Bacuri',
                'ibge_code' => '2101301',
            ],

            471 => [
                'state_id'  => '10',
                'name'      => 'Bacurituba',
                'ibge_code' => '2101350',
            ],

            472 => [
                'state_id'  => '10',
                'name'      => 'Balsas',
                'ibge_code' => '2101400',
            ],

            473 => [
                'state_id'  => '10',
                'name'      => 'Barão de Grajaú',
                'ibge_code' => '2101509',
            ],

            474 => [
                'state_id'  => '10',
                'name'      => 'Barra do Corda',
                'ibge_code' => '2101608',
            ],

            475 => [
                'state_id'  => '10',
                'name'      => 'Barreirinhas',
                'ibge_code' => '2101707',
            ],

            476 => [
                'state_id'  => '10',
                'name'      => 'Belágua',
                'ibge_code' => '2101731',
            ],

            477 => [
                'state_id'  => '10',
                'name'      => 'Bela Vista do Maranhão',
                'ibge_code' => '2101772',
            ],

            478 => [
                'state_id'  => '10',
                'name'      => 'Benedito Leite',
                'ibge_code' => '2101806',
            ],

            479 => [
                'state_id'  => '10',
                'name'      => 'Bequimão',
                'ibge_code' => '2101905',
            ],

            480 => [
                'state_id'  => '10',
                'name'      => 'Bernardo do Mearim',
                'ibge_code' => '2101939',
            ],

            481 => [
                'state_id'  => '10',
                'name'      => 'Boa Vista do Gurupi',
                'ibge_code' => '2101970',
            ],

            482 => [
                'state_id'  => '10',
                'name'      => 'Bom Jardim',
                'ibge_code' => '2102002',
            ],

            483 => [
                'state_id'  => '10',
                'name'      => 'Bom Jesus das Selvas',
                'ibge_code' => '2102036',
            ],

            484 => [
                'state_id'  => '10',
                'name'      => 'Bom Lugar',
                'ibge_code' => '2102077',
            ],

            485 => [
                'state_id'  => '10',
                'name'      => 'Brejo',
                'ibge_code' => '2102101',
            ],

            486 => [
                'state_id'  => '10',
                'name'      => 'Brejo de Areia',
                'ibge_code' => '2102150',
            ],

            487 => [
                'state_id'  => '10',
                'name'      => 'Buriti',
                'ibge_code' => '2102200',
            ],

            488 => [
                'state_id'  => '10',
                'name'      => 'Buriti Bravo',
                'ibge_code' => '2102309',
            ],

            489 => [
                'state_id'  => '10',
                'name'      => 'Buriticupu',
                'ibge_code' => '2102325',
            ],

            490 => [
                'state_id'  => '10',
                'name'      => 'Buritirana',
                'ibge_code' => '2102358',
            ],

            491 => [
                'state_id'  => '10',
                'name'      => 'Cachoeira Grande',
                'ibge_code' => '2102374',
            ],

            492 => [
                'state_id'  => '10',
                'name'      => 'Cajapió',
                'ibge_code' => '2102408',
            ],

            493 => [
                'state_id'  => '10',
                'name'      => 'Cajari',
                'ibge_code' => '2102507',
            ],

            494 => [
                'state_id'  => '10',
                'name'      => 'Campestre do Maranhão',
                'ibge_code' => '2102556',
            ],

            495 => [
                'state_id'  => '10',
                'name'      => 'Cândido Mendes',
                'ibge_code' => '2102606',
            ],

            496 => [
                'state_id'  => '10',
                'name'      => 'Cantanhede',
                'ibge_code' => '2102705',
            ],

            497 => [
                'state_id'  => '10',
                'name'      => 'Capinzal do Norte',
                'ibge_code' => '2102754',
            ],

            498 => [
                'state_id'  => '10',
                'name'      => 'Carolina',
                'ibge_code' => '2102804',
            ],

            499 => [
                'state_id'  => '10',
                'name'      => 'Carutapera',
                'ibge_code' => '2102903',
            ],

        ]);
        DB::table('cities')->insert([
            0 => [
                'state_id'  => '10',
                'name'      => 'Caxias',
                'ibge_code' => '2103000',
            ],

            1 => [
                'state_id'  => '10',
                'name'      => 'Cedral',
                'ibge_code' => '2103109',
            ],

            2 => [
                'state_id'  => '10',
                'name'      => 'Central do Maranhão',
                'ibge_code' => '2103125',
            ],

            3 => [
                'state_id'  => '10',
                'name'      => 'Centro do Guilherme',
                'ibge_code' => '2103158',
            ],

            4 => [
                'state_id'  => '10',
                'name'      => 'Centro Novo do Maranhão',
                'ibge_code' => '2103174',
            ],

            5 => [
                'state_id'  => '10',
                'name'      => 'Chapadinha',
                'ibge_code' => '2103208',
            ],

            6 => [
                'state_id'  => '10',
                'name'      => 'Cidelândia',
                'ibge_code' => '2103257',
            ],

            7 => [
                'state_id'  => '10',
                'name'      => 'Codó',
                'ibge_code' => '2103307',
            ],

            8 => [
                'state_id'  => '10',
                'name'      => 'Coelho Neto',
                'ibge_code' => '2103406',
            ],

            9 => [
                'state_id'  => '10',
                'name'      => 'Colinas',
                'ibge_code' => '2103505',
            ],

            10 => [
                'state_id'  => '10',
                'name'      => 'Conceição do Lago-Açu',
                'ibge_code' => '2103554',
            ],

            11 => [
                'state_id'  => '10',
                'name'      => 'Coroatá',
                'ibge_code' => '2103604',
            ],

            12 => [
                'state_id'  => '10',
                'name'      => 'Cururupu',
                'ibge_code' => '2103703',
            ],

            13 => [
                'state_id'  => '10',
                'name'      => 'Davinópolis',
                'ibge_code' => '2103752',
            ],

            14 => [
                'state_id'  => '10',
                'name'      => 'Dom Pedro',
                'ibge_code' => '2103802',
            ],

            15 => [
                'state_id'  => '10',
                'name'      => 'Duque Bacelar',
                'ibge_code' => '2103901',
            ],

            16 => [
                'state_id'  => '10',
                'name'      => 'Esperantinópolis',
                'ibge_code' => '2104008',
            ],

            17 => [
                'state_id'  => '10',
                'name'      => 'Estreito',
                'ibge_code' => '2104057',
            ],

            18 => [
                'state_id'  => '10',
                'name'      => 'Feira Nova do Maranhão',
                'ibge_code' => '2104073',
            ],

            19 => [
                'state_id'  => '10',
                'name'      => 'Fernando Falcão',
                'ibge_code' => '2104081',
            ],

            20 => [
                'state_id'  => '10',
                'name'      => 'Formosa da Serra Negra',
                'ibge_code' => '2104099',
            ],

            21 => [
                'state_id'  => '10',
                'name'      => 'Fortaleza dos Nogueiras',
                'ibge_code' => '2104107',
            ],

            22 => [
                'state_id'  => '10',
                'name'      => 'Fortuna',
                'ibge_code' => '2104206',
            ],

            23 => [
                'state_id'  => '10',
                'name'      => 'Godofredo Viana',
                'ibge_code' => '2104305',
            ],

            24 => [
                'state_id'  => '10',
                'name'      => 'Gonçalves Dias',
                'ibge_code' => '2104404',
            ],

            25 => [
                'state_id'  => '10',
                'name'      => 'Governador Archer',
                'ibge_code' => '2104503',
            ],

            26 => [
                'state_id'  => '10',
                'name'      => 'Governador Edison Lobão',
                'ibge_code' => '2104552',
            ],

            27 => [
                'state_id'  => '10',
                'name'      => 'Governador Eugênio Barros',
                'ibge_code' => '2104602',
            ],

            28 => [
                'state_id'  => '10',
                'name'      => 'Governador Luiz Rocha',
                'ibge_code' => '2104628',
            ],

            29 => [
                'state_id'  => '10',
                'name'      => 'Governador Newton Bello',
                'ibge_code' => '2104651',
            ],

            30 => [
                'state_id'  => '10',
                'name'      => 'Governador Nunes Freire',
                'ibge_code' => '2104677',
            ],

            31 => [
                'state_id'  => '10',
                'name'      => 'Graça Aranha',
                'ibge_code' => '2104701',
            ],

            32 => [
                'state_id'  => '10',
                'name'      => 'Grajaú',
                'ibge_code' => '2104800',
            ],

            33 => [
                'state_id'  => '10',
                'name'      => 'Guimarães',
                'ibge_code' => '2104909',
            ],

            34 => [
                'state_id'  => '10',
                'name'      => 'Humberto de Campos',
                'ibge_code' => '2105005',
            ],

            35 => [
                'state_id'  => '10',
                'name'      => 'Icatu',
                'ibge_code' => '2105104',
            ],

            36 => [
                'state_id'  => '10',
                'name'      => 'Igarapé do Meio',
                'ibge_code' => '2105153',
            ],

            37 => [
                'state_id'  => '10',
                'name'      => 'Igarapé Grande',
                'ibge_code' => '2105203',
            ],

            38 => [
                'state_id'  => '10',
                'name'      => 'Imperatriz',
                'ibge_code' => '2105302',
            ],

            39 => [
                'state_id'  => '10',
                'name'      => 'Itaipava do Grajaú',
                'ibge_code' => '2105351',
            ],

            40 => [
                'state_id'  => '10',
                'name'      => 'Itapecuru Mirim',
                'ibge_code' => '2105401',
            ],

            41 => [
                'state_id'  => '10',
                'name'      => 'Itinga do Maranhão',
                'ibge_code' => '2105427',
            ],

            42 => [
                'state_id'  => '10',
                'name'      => 'Jatobá',
                'ibge_code' => '2105450',
            ],

            43 => [
                'state_id'  => '10',
                'name'      => 'Jenipapo dos Vieiras',
                'ibge_code' => '2105476',
            ],

            44 => [
                'state_id'  => '10',
                'name'      => 'João Lisboa',
                'ibge_code' => '2105500',
            ],

            45 => [
                'state_id'  => '10',
                'name'      => 'Joselândia',
                'ibge_code' => '2105609',
            ],

            46 => [
                'state_id'  => '10',
                'name'      => 'Junco do Maranhão',
                'ibge_code' => '2105658',
            ],

            47 => [
                'state_id'  => '10',
                'name'      => 'Lago da Pedra',
                'ibge_code' => '2105708',
            ],

            48 => [
                'state_id'  => '10',
                'name'      => 'Lago do Junco',
                'ibge_code' => '2105807',
            ],

            49 => [
                'state_id'  => '10',
                'name'      => 'Lago Verde',
                'ibge_code' => '2105906',
            ],

            50 => [
                'state_id'  => '10',
                'name'      => 'Lagoa do Mato',
                'ibge_code' => '2105922',
            ],

            51 => [
                'state_id'  => '10',
                'name'      => 'Lago dos Rodrigues',
                'ibge_code' => '2105948',
            ],

            52 => [
                'state_id'  => '10',
                'name'      => 'Lagoa Grande do Maranhão',
                'ibge_code' => '2105963',
            ],

            53 => [
                'state_id'  => '10',
                'name'      => 'Lajeado Novo',
                'ibge_code' => '2105989',
            ],

            54 => [
                'state_id'  => '10',
                'name'      => 'Lima Campos',
                'ibge_code' => '2106003',
            ],

            55 => [
                'state_id'  => '10',
                'name'      => 'Loreto',
                'ibge_code' => '2106102',
            ],

            56 => [
                'state_id'  => '10',
                'name'      => 'Luís Domingues',
                'ibge_code' => '2106201',
            ],

            57 => [
                'state_id'  => '10',
                'name'      => 'Magalhães de Almeida',
                'ibge_code' => '2106300',
            ],

            58 => [
                'state_id'  => '10',
                'name'      => 'Maracaçumé',
                'ibge_code' => '2106326',
            ],

            59 => [
                'state_id'  => '10',
                'name'      => 'Marajá do Sena',
                'ibge_code' => '2106359',
            ],

            60 => [
                'state_id'  => '10',
                'name'      => 'Maranhãozinho',
                'ibge_code' => '2106375',
            ],

            61 => [
                'state_id'  => '10',
                'name'      => 'Mata Roma',
                'ibge_code' => '2106409',
            ],

            62 => [
                'state_id'  => '10',
                'name'      => 'Matinha',
                'ibge_code' => '2106508',
            ],

            63 => [
                'state_id'  => '10',
                'name'      => 'Matões',
                'ibge_code' => '2106607',
            ],

            64 => [
                'state_id'  => '10',
                'name'      => 'Matões do Norte',
                'ibge_code' => '2106631',
            ],

            65 => [
                'state_id'  => '10',
                'name'      => 'Milagres do Maranhão',
                'ibge_code' => '2106672',
            ],

            66 => [
                'state_id'  => '10',
                'name'      => 'Mirador',
                'ibge_code' => '2106706',
            ],

            67 => [
                'state_id'  => '10',
                'name'      => 'Miranda do Norte',
                'ibge_code' => '2106755',
            ],

            68 => [
                'state_id'  => '10',
                'name'      => 'Mirinzal',
                'ibge_code' => '2106805',
            ],

            69 => [
                'state_id'  => '10',
                'name'      => 'Monção',
                'ibge_code' => '2106904',
            ],

            70 => [
                'state_id'  => '10',
                'name'      => 'Montes Altos',
                'ibge_code' => '2107001',
            ],

            71 => [
                'state_id'  => '10',
                'name'      => 'Morros',
                'ibge_code' => '2107100',
            ],

            72 => [
                'state_id'  => '10',
                'name'      => 'Nina Rodrigues',
                'ibge_code' => '2107209',
            ],

            73 => [
                'state_id'  => '10',
                'name'      => 'Nova Colinas',
                'ibge_code' => '2107258',
            ],

            74 => [
                'state_id'  => '10',
                'name'      => 'Nova Iorque',
                'ibge_code' => '2107308',
            ],

            75 => [
                'state_id'  => '10',
                'name'      => 'Nova Olinda do Maranhão',
                'ibge_code' => '2107357',
            ],

            76 => [
                'state_id'  => '10',
                'name'      => "Olho D'água das Cunhãs",
                'ibge_code' => '2107407',
            ],

            77 => [
                'state_id'  => '10',
                'name'      => 'Olinda Nova do Maranhão',
                'ibge_code' => '2107456',
            ],

            78 => [
                'state_id'  => '10',
                'name'      => 'Paço do Lumiar',
                'ibge_code' => '2107506',
            ],

            79 => [
                'state_id'  => '10',
                'name'      => 'Palmeirândia',
                'ibge_code' => '2107605',
            ],

            80 => [
                'state_id'  => '10',
                'name'      => 'Paraibano',
                'ibge_code' => '2107704',
            ],

            81 => [
                'state_id'  => '10',
                'name'      => 'Parnarama',
                'ibge_code' => '2107803',
            ],

            82 => [
                'state_id'  => '10',
                'name'      => 'Passagem Franca',
                'ibge_code' => '2107902',
            ],

            83 => [
                'state_id'  => '10',
                'name'      => 'Pastos Bons',
                'ibge_code' => '2108009',
            ],

            84 => [
                'state_id'  => '10',
                'name'      => 'Paulino Neves',
                'ibge_code' => '2108058',
            ],

            85 => [
                'state_id'  => '10',
                'name'      => 'Paulo Ramos',
                'ibge_code' => '2108108',
            ],

            86 => [
                'state_id'  => '10',
                'name'      => 'Pedreiras',
                'ibge_code' => '2108207',
            ],

            87 => [
                'state_id'  => '10',
                'name'      => 'Pedro do Rosário',
                'ibge_code' => '2108256',
            ],

            88 => [
                'state_id'  => '10',
                'name'      => 'Penalva',
                'ibge_code' => '2108306',
            ],

            89 => [
                'state_id'  => '10',
                'name'      => 'Peri Mirim',
                'ibge_code' => '2108405',
            ],

            90 => [
                'state_id'  => '10',
                'name'      => 'Peritoró',
                'ibge_code' => '2108454',
            ],

            91 => [
                'state_id'  => '10',
                'name'      => 'Pindaré-Mirim',
                'ibge_code' => '2108504',
            ],

            92 => [
                'state_id'  => '10',
                'name'      => 'Pinheiro',
                'ibge_code' => '2108603',
            ],

            93 => [
                'state_id'  => '10',
                'name'      => 'Pio Xii',
                'ibge_code' => '2108702',
            ],

            94 => [
                'state_id'  => '10',
                'name'      => 'Pirapemas',
                'ibge_code' => '2108801',
            ],

            95 => [
                'state_id'  => '10',
                'name'      => 'Poção de Pedras',
                'ibge_code' => '2108900',
            ],

            96 => [
                'state_id'  => '10',
                'name'      => 'Porto Franco',
                'ibge_code' => '2109007',
            ],

            97 => [
                'state_id'  => '10',
                'name'      => 'Porto Rico do Maranhão',
                'ibge_code' => '2109056',
            ],

            98 => [
                'state_id'  => '10',
                'name'      => 'Presidente Dutra',
                'ibge_code' => '2109106',
            ],

            99 => [
                'state_id'  => '10',
                'name'      => 'Presidente Juscelino',
                'ibge_code' => '2109205',
            ],

            100 => [
                'state_id'  => '10',
                'name'      => 'Presidente Médici',
                'ibge_code' => '2109239',
            ],

            101 => [
                'state_id'  => '10',
                'name'      => 'Presidente Sarney',
                'ibge_code' => '2109270',
            ],

            102 => [
                'state_id'  => '10',
                'name'      => 'Presidente Vargas',
                'ibge_code' => '2109304',
            ],

            103 => [
                'state_id'  => '10',
                'name'      => 'Primeira Cruz',
                'ibge_code' => '2109403',
            ],

            104 => [
                'state_id'  => '10',
                'name'      => 'Raposa',
                'ibge_code' => '2109452',
            ],

            105 => [
                'state_id'  => '10',
                'name'      => 'Riachão',
                'ibge_code' => '2109502',
            ],

            106 => [
                'state_id'  => '10',
                'name'      => 'Ribamar Fiquene',
                'ibge_code' => '2109551',
            ],

            107 => [
                'state_id'  => '10',
                'name'      => 'Rosário',
                'ibge_code' => '2109601',
            ],

            108 => [
                'state_id'  => '10',
                'name'      => 'Sambaíba',
                'ibge_code' => '2109700',
            ],

            109 => [
                'state_id'  => '10',
                'name'      => 'Santa Filomena do Maranhão',
                'ibge_code' => '2109759',
            ],

            110 => [
                'state_id'  => '10',
                'name'      => 'Santa Helena',
                'ibge_code' => '2109809',
            ],

            111 => [
                'state_id'  => '10',
                'name'      => 'Santa Inês',
                'ibge_code' => '2109908',
            ],

            112 => [
                'state_id'  => '10',
                'name'      => 'Santa Luzia',
                'ibge_code' => '2110005',
            ],

            113 => [
                'state_id'  => '10',
                'name'      => 'Santa Luzia do Paruá',
                'ibge_code' => '2110039',
            ],

            114 => [
                'state_id'  => '10',
                'name'      => 'Santa Quitéria do Maranhão',
                'ibge_code' => '2110104',
            ],

            115 => [
                'state_id'  => '10',
                'name'      => 'Santa Rita',
                'ibge_code' => '2110203',
            ],

            116 => [
                'state_id'  => '10',
                'name'      => 'Santana do Maranhão',
                'ibge_code' => '2110237',
            ],

            117 => [
                'state_id'  => '10',
                'name'      => 'Santo Amaro do Maranhão',
                'ibge_code' => '2110278',
            ],

            118 => [
                'state_id'  => '10',
                'name'      => 'Santo Antônio dos Lopes',
                'ibge_code' => '2110302',
            ],

            119 => [
                'state_id'  => '10',
                'name'      => 'São Benedito do Rio Preto',
                'ibge_code' => '2110401',
            ],

            120 => [
                'state_id'  => '10',
                'name'      => 'São Bento',
                'ibge_code' => '2110500',
            ],

            121 => [
                'state_id'  => '10',
                'name'      => 'São Bernardo',
                'ibge_code' => '2110609',
            ],

            122 => [
                'state_id'  => '10',
                'name'      => 'São Domingos do Azeitão',
                'ibge_code' => '2110658',
            ],

            123 => [
                'state_id'  => '10',
                'name'      => 'São Domingos do Maranhão',
                'ibge_code' => '2110708',
            ],

            124 => [
                'state_id'  => '10',
                'name'      => 'São Félix de Balsas',
                'ibge_code' => '2110807',
            ],

            125 => [
                'state_id'  => '10',
                'name'      => 'São Francisco do Brejão',
                'ibge_code' => '2110856',
            ],

            126 => [
                'state_id'  => '10',
                'name'      => 'São Francisco do Maranhão',
                'ibge_code' => '2110906',
            ],

            127 => [
                'state_id'  => '10',
                'name'      => 'São João Batista',
                'ibge_code' => '2111003',
            ],

            128 => [
                'state_id'  => '10',
                'name'      => 'São João do Carú',
                'ibge_code' => '2111029',
            ],

            129 => [
                'state_id'  => '10',
                'name'      => 'São João do Paraíso',
                'ibge_code' => '2111052',
            ],

            130 => [
                'state_id'  => '10',
                'name'      => 'São João do Soter',
                'ibge_code' => '2111078',
            ],

            131 => [
                'state_id'  => '10',
                'name'      => 'São João dos Patos',
                'ibge_code' => '2111102',
            ],

            132 => [
                'state_id'  => '10',
                'name'      => 'São José de Ribamar',
                'ibge_code' => '2111201',
            ],

            133 => [
                'state_id'  => '10',
                'name'      => 'São José dos Basílios',
                'ibge_code' => '2111250',
            ],

            134 => [
                'state_id'  => '10',
                'name'      => 'São Luís',
                'ibge_code' => '2111300',
            ],

            135 => [
                'state_id'  => '10',
                'name'      => 'São Luís Gonzaga do Maranhão',
                'ibge_code' => '2111409',
            ],

            136 => [
                'state_id'  => '10',
                'name'      => 'São Mateus do Maranhão',
                'ibge_code' => '2111508',
            ],

            137 => [
                'state_id'  => '10',
                'name'      => 'São Pedro da Água Branca',
                'ibge_code' => '2111532',
            ],

            138 => [
                'state_id'  => '10',
                'name'      => 'São Pedro dos Crentes',
                'ibge_code' => '2111573',
            ],

            139 => [
                'state_id'  => '10',
                'name'      => 'São Raimundo das Mangabeiras',
                'ibge_code' => '2111607',
            ],

            140 => [
                'state_id'  => '10',
                'name'      => 'São Raimundo do Doca Bezerra',
                'ibge_code' => '2111631',
            ],

            141 => [
                'state_id'  => '10',
                'name'      => 'São Roberto',
                'ibge_code' => '2111672',
            ],

            142 => [
                'state_id'  => '10',
                'name'      => 'São Vicente Ferrer',
                'ibge_code' => '2111706',
            ],

            143 => [
                'state_id'  => '10',
                'name'      => 'Satubinha',
                'ibge_code' => '2111722',
            ],

            144 => [
                'state_id'  => '10',
                'name'      => 'Senador Alexandre Costa',
                'ibge_code' => '2111748',
            ],

            145 => [
                'state_id'  => '10',
                'name'      => 'Senador La Rocque',
                'ibge_code' => '2111763',
            ],

            146 => [
                'state_id'  => '10',
                'name'      => 'Serrano do Maranhão',
                'ibge_code' => '2111789',
            ],

            147 => [
                'state_id'  => '10',
                'name'      => 'Sítio Novo',
                'ibge_code' => '2111805',
            ],

            148 => [
                'state_id'  => '10',
                'name'      => 'Sucupira do Norte',
                'ibge_code' => '2111904',
            ],

            149 => [
                'state_id'  => '10',
                'name'      => 'Sucupira do Riachão',
                'ibge_code' => '2111953',
            ],

            150 => [
                'state_id'  => '10',
                'name'      => 'Tasso Fragoso',
                'ibge_code' => '2112001',
            ],

            151 => [
                'state_id'  => '10',
                'name'      => 'Timbiras',
                'ibge_code' => '2112100',
            ],

            152 => [
                'state_id'  => '10',
                'name'      => 'Timon',
                'ibge_code' => '2112209',
            ],

            153 => [
                'state_id'  => '10',
                'name'      => 'Trizidela do Vale',
                'ibge_code' => '2112233',
            ],

            154 => [
                'state_id'  => '10',
                'name'      => 'Tufilândia',
                'ibge_code' => '2112274',
            ],

            155 => [
                'state_id'  => '10',
                'name'      => 'Tuntum',
                'ibge_code' => '2112308',
            ],

            156 => [
                'state_id'  => '10',
                'name'      => 'Turiaçu',
                'ibge_code' => '2112407',
            ],

            157 => [
                'state_id'  => '10',
                'name'      => 'Turilândia',
                'ibge_code' => '2112456',
            ],

            158 => [
                'state_id'  => '10',
                'name'      => 'Tutóia',
                'ibge_code' => '2112506',
            ],

            159 => [
                'state_id'  => '10',
                'name'      => 'Urbano Santos',
                'ibge_code' => '2112605',
            ],

            160 => [
                'state_id'  => '10',
                'name'      => 'Vargem Grande',
                'ibge_code' => '2112704',
            ],

            161 => [
                'state_id'  => '10',
                'name'      => 'Viana',
                'ibge_code' => '2112803',
            ],

            162 => [
                'state_id'  => '10',
                'name'      => 'Vila Nova dos Martírios',
                'ibge_code' => '2112852',
            ],

            163 => [
                'state_id'  => '10',
                'name'      => 'Vitória do Mearim',
                'ibge_code' => '2112902',
            ],

            164 => [
                'state_id'  => '10',
                'name'      => 'Vitorino Freire',
                'ibge_code' => '2113009',
            ],

            165 => [
                'state_id'  => '10',
                'name'      => 'Zé Doca',
                'ibge_code' => '2114007',
            ],

            166 => [
                'state_id'  => '17',
                'name'      => 'Acauã',
                'ibge_code' => '2200053',
            ],

            167 => [
                'state_id'  => '17',
                'name'      => 'Agricolândia',
                'ibge_code' => '2200103',
            ],

            168 => [
                'state_id'  => '17',
                'name'      => 'Água Branca',
                'ibge_code' => '2200202',
            ],

            169 => [
                'state_id'  => '17',
                'name'      => 'Alagoinha do Piauí',
                'ibge_code' => '2200251',
            ],

            170 => [
                'state_id'  => '17',
                'name'      => 'Alegrete do Piauí',
                'ibge_code' => '2200277',
            ],

            171 => [
                'state_id'  => '17',
                'name'      => 'Alto Longá',
                'ibge_code' => '2200301',
            ],

            172 => [
                'state_id'  => '17',
                'name'      => 'Altos',
                'ibge_code' => '2200400',
            ],

            173 => [
                'state_id'  => '17',
                'name'      => 'Alvorada do Gurguéia',
                'ibge_code' => '2200459',
            ],

            174 => [
                'state_id'  => '17',
                'name'      => 'Amarante',
                'ibge_code' => '2200509',
            ],

            175 => [
                'state_id'  => '17',
                'name'      => 'Angical do Piauí',
                'ibge_code' => '2200608',
            ],

            176 => [
                'state_id'  => '17',
                'name'      => 'Anísio de Abreu',
                'ibge_code' => '2200707',
            ],

            177 => [
                'state_id'  => '17',
                'name'      => 'Antônio Almeida',
                'ibge_code' => '2200806',
            ],

            178 => [
                'state_id'  => '17',
                'name'      => 'Aroazes',
                'ibge_code' => '2200905',
            ],

            179 => [
                'state_id'  => '17',
                'name'      => 'Aroeiras do Itaim',
                'ibge_code' => '2200954',
            ],

            180 => [
                'state_id'  => '17',
                'name'      => 'Arraial',
                'ibge_code' => '2201002',
            ],

            181 => [
                'state_id'  => '17',
                'name'      => 'Assunção do Piauí',
                'ibge_code' => '2201051',
            ],

            182 => [
                'state_id'  => '17',
                'name'      => 'Avelino Lopes',
                'ibge_code' => '2201101',
            ],

            183 => [
                'state_id'  => '17',
                'name'      => 'Baixa Grande do Ribeiro',
                'ibge_code' => '2201150',
            ],

            184 => [
                'state_id'  => '17',
                'name'      => "Barra D'alcântara",
                'ibge_code' => '2201176',
            ],

            185 => [
                'state_id'  => '17',
                'name'      => 'Barras',
                'ibge_code' => '2201200',
            ],

            186 => [
                'state_id'  => '17',
                'name'      => 'Barreiras do Piauí',
                'ibge_code' => '2201309',
            ],

            187 => [
                'state_id'  => '17',
                'name'      => 'Barro Duro',
                'ibge_code' => '2201408',
            ],

            188 => [
                'state_id'  => '17',
                'name'      => 'Batalha',
                'ibge_code' => '2201507',
            ],

            189 => [
                'state_id'  => '17',
                'name'      => 'Bela Vista do Piauí',
                'ibge_code' => '2201556',
            ],

            190 => [
                'state_id'  => '17',
                'name'      => 'Belém do Piauí',
                'ibge_code' => '2201572',
            ],

            191 => [
                'state_id'  => '17',
                'name'      => 'Beneditinos',
                'ibge_code' => '2201606',
            ],

            192 => [
                'state_id'  => '17',
                'name'      => 'Bertolínia',
                'ibge_code' => '2201705',
            ],

            193 => [
                'state_id'  => '17',
                'name'      => 'Betânia do Piauí',
                'ibge_code' => '2201739',
            ],

            194 => [
                'state_id'  => '17',
                'name'      => 'Boa Hora',
                'ibge_code' => '2201770',
            ],

            195 => [
                'state_id'  => '17',
                'name'      => 'Bocaina',
                'ibge_code' => '2201804',
            ],

            196 => [
                'state_id'  => '17',
                'name'      => 'Bom Jesus',
                'ibge_code' => '2201903',
            ],

            197 => [
                'state_id'  => '17',
                'name'      => 'Bom Princípio do Piauí',
                'ibge_code' => '2201919',
            ],

            198 => [
                'state_id'  => '17',
                'name'      => 'Bonfim do Piauí',
                'ibge_code' => '2201929',
            ],

            199 => [
                'state_id'  => '17',
                'name'      => 'Boqueirão do Piauí',
                'ibge_code' => '2201945',
            ],

            200 => [
                'state_id'  => '17',
                'name'      => 'Brasileira',
                'ibge_code' => '2201960',
            ],

            201 => [
                'state_id'  => '17',
                'name'      => 'Brejo do Piauí',
                'ibge_code' => '2201988',
            ],

            202 => [
                'state_id'  => '17',
                'name'      => 'Buriti dos Lopes',
                'ibge_code' => '2202000',
            ],

            203 => [
                'state_id'  => '17',
                'name'      => 'Buriti dos Montes',
                'ibge_code' => '2202026',
            ],

            204 => [
                'state_id'  => '17',
                'name'      => 'Cabeceiras do Piauí',
                'ibge_code' => '2202059',
            ],

            205 => [
                'state_id'  => '17',
                'name'      => 'Cajazeiras do Piauí',
                'ibge_code' => '2202075',
            ],

            206 => [
                'state_id'  => '17',
                'name'      => 'Cajueiro da Praia',
                'ibge_code' => '2202083',
            ],

            207 => [
                'state_id'  => '17',
                'name'      => 'Caldeirão Grande do Piauí',
                'ibge_code' => '2202091',
            ],

            208 => [
                'state_id'  => '17',
                'name'      => 'Campinas do Piauí',
                'ibge_code' => '2202109',
            ],

            209 => [
                'state_id'  => '17',
                'name'      => 'Campo Alegre do Fidalgo',
                'ibge_code' => '2202117',
            ],

            210 => [
                'state_id'  => '17',
                'name'      => 'Campo Grande do Piauí',
                'ibge_code' => '2202133',
            ],

            211 => [
                'state_id'  => '17',
                'name'      => 'Campo Largo do Piauí',
                'ibge_code' => '2202174',
            ],

            212 => [
                'state_id'  => '17',
                'name'      => 'Campo Maior',
                'ibge_code' => '2202208',
            ],

            213 => [
                'state_id'  => '17',
                'name'      => 'Canavieira',
                'ibge_code' => '2202251',
            ],

            214 => [
                'state_id'  => '17',
                'name'      => 'Canto do Buriti',
                'ibge_code' => '2202307',
            ],

            215 => [
                'state_id'  => '17',
                'name'      => 'Capitão de Campos',
                'ibge_code' => '2202406',
            ],

            216 => [
                'state_id'  => '17',
                'name'      => 'Capitão Gervásio Oliveira',
                'ibge_code' => '2202455',
            ],

            217 => [
                'state_id'  => '17',
                'name'      => 'Caracol',
                'ibge_code' => '2202505',
            ],

            218 => [
                'state_id'  => '17',
                'name'      => 'Caraúbas do Piauí',
                'ibge_code' => '2202539',
            ],

            219 => [
                'state_id'  => '17',
                'name'      => 'Caridade do Piauí',
                'ibge_code' => '2202554',
            ],

            220 => [
                'state_id'  => '17',
                'name'      => 'Castelo do Piauí',
                'ibge_code' => '2202604',
            ],

            221 => [
                'state_id'  => '17',
                'name'      => 'Caxingó',
                'ibge_code' => '2202653',
            ],

            222 => [
                'state_id'  => '17',
                'name'      => 'Cocal',
                'ibge_code' => '2202703',
            ],

            223 => [
                'state_id'  => '17',
                'name'      => 'Cocal de Telha',
                'ibge_code' => '2202711',
            ],

            224 => [
                'state_id'  => '17',
                'name'      => 'Cocal dos Alves',
                'ibge_code' => '2202729',
            ],

            225 => [
                'state_id'  => '17',
                'name'      => 'Coivaras',
                'ibge_code' => '2202737',
            ],

            226 => [
                'state_id'  => '17',
                'name'      => 'Colônia do Gurguéia',
                'ibge_code' => '2202752',
            ],

            227 => [
                'state_id'  => '17',
                'name'      => 'Colônia do Piauí',
                'ibge_code' => '2202778',
            ],

            228 => [
                'state_id'  => '17',
                'name'      => 'Conceição do Canindé',
                'ibge_code' => '2202802',
            ],

            229 => [
                'state_id'  => '17',
                'name'      => 'Coronel José Dias',
                'ibge_code' => '2202851',
            ],

            230 => [
                'state_id'  => '17',
                'name'      => 'Corrente',
                'ibge_code' => '2202901',
            ],

            231 => [
                'state_id'  => '17',
                'name'      => 'Cristalândia do Piauí',
                'ibge_code' => '2203008',
            ],

            232 => [
                'state_id'  => '17',
                'name'      => 'Cristino Castro',
                'ibge_code' => '2203107',
            ],

            233 => [
                'state_id'  => '17',
                'name'      => 'Curimatá',
                'ibge_code' => '2203206',
            ],

            234 => [
                'state_id'  => '17',
                'name'      => 'Currais',
                'ibge_code' => '2203230',
            ],

            235 => [
                'state_id'  => '17',
                'name'      => 'Curralinhos',
                'ibge_code' => '2203255',
            ],

            236 => [
                'state_id'  => '17',
                'name'      => 'Curral Novo do Piauí',
                'ibge_code' => '2203271',
            ],

            237 => [
                'state_id'  => '17',
                'name'      => 'Demerval Lobão',
                'ibge_code' => '2203305',
            ],

            238 => [
                'state_id'  => '17',
                'name'      => 'Dirceu Arcoverde',
                'ibge_code' => '2203354',
            ],

            239 => [
                'state_id'  => '17',
                'name'      => 'Dom Expedito Lopes',
                'ibge_code' => '2203404',
            ],

            240 => [
                'state_id'  => '17',
                'name'      => 'Domingos Mourão',
                'ibge_code' => '2203420',
            ],

            241 => [
                'state_id'  => '17',
                'name'      => 'Dom Inocêncio',
                'ibge_code' => '2203453',
            ],

            242 => [
                'state_id'  => '17',
                'name'      => 'Elesbão Veloso',
                'ibge_code' => '2203503',
            ],

            243 => [
                'state_id'  => '17',
                'name'      => 'Eliseu Martins',
                'ibge_code' => '2203602',
            ],

            244 => [
                'state_id'  => '17',
                'name'      => 'Esperantina',
                'ibge_code' => '2203701',
            ],

            245 => [
                'state_id'  => '17',
                'name'      => 'Fartura do Piauí',
                'ibge_code' => '2203750',
            ],

            246 => [
                'state_id'  => '17',
                'name'      => 'Flores do Piauí',
                'ibge_code' => '2203800',
            ],

            247 => [
                'state_id'  => '17',
                'name'      => 'Floresta do Piauí',
                'ibge_code' => '2203859',
            ],

            248 => [
                'state_id'  => '17',
                'name'      => 'Floriano',
                'ibge_code' => '2203909',
            ],

            249 => [
                'state_id'  => '17',
                'name'      => 'Francinópolis',
                'ibge_code' => '2204006',
            ],

            250 => [
                'state_id'  => '17',
                'name'      => 'Francisco Ayres',
                'ibge_code' => '2204105',
            ],

            251 => [
                'state_id'  => '17',
                'name'      => 'Francisco Macedo',
                'ibge_code' => '2204154',
            ],

            252 => [
                'state_id'  => '17',
                'name'      => 'Francisco Santos',
                'ibge_code' => '2204204',
            ],

            253 => [
                'state_id'  => '17',
                'name'      => 'Fronteiras',
                'ibge_code' => '2204303',
            ],

            254 => [
                'state_id'  => '17',
                'name'      => 'Geminiano',
                'ibge_code' => '2204352',
            ],

            255 => [
                'state_id'  => '17',
                'name'      => 'Gilbués',
                'ibge_code' => '2204402',
            ],

            256 => [
                'state_id'  => '17',
                'name'      => 'Guadalupe',
                'ibge_code' => '2204501',
            ],

            257 => [
                'state_id'  => '17',
                'name'      => 'Guaribas',
                'ibge_code' => '2204550',
            ],

            258 => [
                'state_id'  => '17',
                'name'      => 'Hugo Napoleão',
                'ibge_code' => '2204600',
            ],

            259 => [
                'state_id'  => '17',
                'name'      => 'Ilha Grande',
                'ibge_code' => '2204659',
            ],

            260 => [
                'state_id'  => '17',
                'name'      => 'Inhuma',
                'ibge_code' => '2204709',
            ],

            261 => [
                'state_id'  => '17',
                'name'      => 'Ipiranga do Piauí',
                'ibge_code' => '2204808',
            ],

            262 => [
                'state_id'  => '17',
                'name'      => 'Isaías Coelho',
                'ibge_code' => '2204907',
            ],

            263 => [
                'state_id'  => '17',
                'name'      => 'Itainópolis',
                'ibge_code' => '2205003',
            ],

            264 => [
                'state_id'  => '17',
                'name'      => 'Itaueira',
                'ibge_code' => '2205102',
            ],

            265 => [
                'state_id'  => '17',
                'name'      => 'Jacobina do Piauí',
                'ibge_code' => '2205151',
            ],

            266 => [
                'state_id'  => '17',
                'name'      => 'Jaicós',
                'ibge_code' => '2205201',
            ],

            267 => [
                'state_id'  => '17',
                'name'      => 'Jardim do Mulato',
                'ibge_code' => '2205250',
            ],

            268 => [
                'state_id'  => '17',
                'name'      => 'Jatobá do Piauí',
                'ibge_code' => '2205276',
            ],

            269 => [
                'state_id'  => '17',
                'name'      => 'Jerumenha',
                'ibge_code' => '2205300',
            ],

            270 => [
                'state_id'  => '17',
                'name'      => 'João Costa',
                'ibge_code' => '2205359',
            ],

            271 => [
                'state_id'  => '17',
                'name'      => 'Joaquim Pires',
                'ibge_code' => '2205409',
            ],

            272 => [
                'state_id'  => '17',
                'name'      => 'Joca Marques',
                'ibge_code' => '2205458',
            ],

            273 => [
                'state_id'  => '17',
                'name'      => 'José de Freitas',
                'ibge_code' => '2205508',
            ],

            274 => [
                'state_id'  => '17',
                'name'      => 'Juazeiro do Piauí',
                'ibge_code' => '2205516',
            ],

            275 => [
                'state_id'  => '17',
                'name'      => 'Júlio Borges',
                'ibge_code' => '2205524',
            ],

            276 => [
                'state_id'  => '17',
                'name'      => 'Jurema',
                'ibge_code' => '2205532',
            ],

            277 => [
                'state_id'  => '17',
                'name'      => 'Lagoinha do Piauí',
                'ibge_code' => '2205540',
            ],

            278 => [
                'state_id'  => '17',
                'name'      => 'Lagoa Alegre',
                'ibge_code' => '2205557',
            ],

            279 => [
                'state_id'  => '17',
                'name'      => 'Lagoa do Barro do Piauí',
                'ibge_code' => '2205565',
            ],

            280 => [
                'state_id'  => '17',
                'name'      => 'Lagoa de São Francisco',
                'ibge_code' => '2205573',
            ],

            281 => [
                'state_id'  => '17',
                'name'      => 'Lagoa do Piauí',
                'ibge_code' => '2205581',
            ],

            282 => [
                'state_id'  => '17',
                'name'      => 'Lagoa do Sítio',
                'ibge_code' => '2205599',
            ],

            283 => [
                'state_id'  => '17',
                'name'      => 'Landri Sales',
                'ibge_code' => '2205607',
            ],

            284 => [
                'state_id'  => '17',
                'name'      => 'Luís Correia',
                'ibge_code' => '2205706',
            ],

            285 => [
                'state_id'  => '17',
                'name'      => 'Luzilândia',
                'ibge_code' => '2205805',
            ],

            286 => [
                'state_id'  => '17',
                'name'      => 'Madeiro',
                'ibge_code' => '2205854',
            ],

            287 => [
                'state_id'  => '17',
                'name'      => 'Manoel Emídio',
                'ibge_code' => '2205904',
            ],

            288 => [
                'state_id'  => '17',
                'name'      => 'Marcolândia',
                'ibge_code' => '2205953',
            ],

            289 => [
                'state_id'  => '17',
                'name'      => 'Marcos Parente',
                'ibge_code' => '2206001',
            ],

            290 => [
                'state_id'  => '17',
                'name'      => 'Massapê do Piauí',
                'ibge_code' => '2206050',
            ],

            291 => [
                'state_id'  => '17',
                'name'      => 'Matias Olímpio',
                'ibge_code' => '2206100',
            ],

            292 => [
                'state_id'  => '17',
                'name'      => 'Miguel Alves',
                'ibge_code' => '2206209',
            ],

            293 => [
                'state_id'  => '17',
                'name'      => 'Miguel Leão',
                'ibge_code' => '2206308',
            ],

            294 => [
                'state_id'  => '17',
                'name'      => 'Milton Brandão',
                'ibge_code' => '2206357',
            ],

            295 => [
                'state_id'  => '17',
                'name'      => 'Monsenhor Gil',
                'ibge_code' => '2206407',
            ],

            296 => [
                'state_id'  => '17',
                'name'      => 'Monsenhor Hipólito',
                'ibge_code' => '2206506',
            ],

            297 => [
                'state_id'  => '17',
                'name'      => 'Monte Alegre do Piauí',
                'ibge_code' => '2206605',
            ],

            298 => [
                'state_id'  => '17',
                'name'      => 'Morro Cabeça No Tempo',
                'ibge_code' => '2206654',
            ],

            299 => [
                'state_id'  => '17',
                'name'      => 'Morro do Chapéu do Piauí',
                'ibge_code' => '2206670',
            ],

            300 => [
                'state_id'  => '17',
                'name'      => 'Murici dos Portelas',
                'ibge_code' => '2206696',
            ],

            301 => [
                'state_id'  => '17',
                'name'      => 'Nazaré do Piauí',
                'ibge_code' => '2206704',
            ],

            302 => [
                'state_id'  => '17',
                'name'      => 'Nossa Senhora de Nazaré',
                'ibge_code' => '2206753',
            ],

            303 => [
                'state_id'  => '17',
                'name'      => 'Nossa Senhora dos Remédios',
                'ibge_code' => '2206803',
            ],

            304 => [
                'state_id'  => '17',
                'name'      => 'Novo Oriente do Piauí',
                'ibge_code' => '2206902',
            ],

            305 => [
                'state_id'  => '17',
                'name'      => 'Novo Santo Antônio',
                'ibge_code' => '2206951',
            ],

            306 => [
                'state_id'  => '17',
                'name'      => 'Oeiras',
                'ibge_code' => '2207009',
            ],

            307 => [
                'state_id'  => '17',
                'name'      => "Olho D'água do Piauí",
                'ibge_code' => '2207108',
            ],

            308 => [
                'state_id'  => '17',
                'name'      => 'Padre Marcos',
                'ibge_code' => '2207207',
            ],

            309 => [
                'state_id'  => '17',
                'name'      => 'Paes Landim',
                'ibge_code' => '2207306',
            ],

            310 => [
                'state_id'  => '17',
                'name'      => 'Pajeú do Piauí',
                'ibge_code' => '2207355',
            ],

            311 => [
                'state_id'  => '17',
                'name'      => 'Palmeira do Piauí',
                'ibge_code' => '2207405',
            ],

            312 => [
                'state_id'  => '17',
                'name'      => 'Palmeirais',
                'ibge_code' => '2207504',
            ],

            313 => [
                'state_id'  => '17',
                'name'      => 'Paquetá',
                'ibge_code' => '2207553',
            ],

            314 => [
                'state_id'  => '17',
                'name'      => 'Parnaguá',
                'ibge_code' => '2207603',
            ],

            315 => [
                'state_id'  => '17',
                'name'      => 'Parnaíba',
                'ibge_code' => '2207702',
            ],

            316 => [
                'state_id'  => '17',
                'name'      => 'Passagem Franca do Piauí',
                'ibge_code' => '2207751',
            ],

            317 => [
                'state_id'  => '17',
                'name'      => 'Patos do Piauí',
                'ibge_code' => '2207777',
            ],

            318 => [
                'state_id'  => '17',
                'name'      => "Pau D'arco do Piauí",
                'ibge_code' => '2207793',
            ],

            319 => [
                'state_id'  => '17',
                'name'      => 'Paulistana',
                'ibge_code' => '2207801',
            ],

            320 => [
                'state_id'  => '17',
                'name'      => 'Pavussu',
                'ibge_code' => '2207850',
            ],

            321 => [
                'state_id'  => '17',
                'name'      => 'Pedro Ii',
                'ibge_code' => '2207900',
            ],

            322 => [
                'state_id'  => '17',
                'name'      => 'Pedro Laurentino',
                'ibge_code' => '2207934',
            ],

            323 => [
                'state_id'  => '17',
                'name'      => 'Nova Santa Rita',
                'ibge_code' => '2207959',
            ],

            324 => [
                'state_id'  => '17',
                'name'      => 'Picos',
                'ibge_code' => '2208007',
            ],

            325 => [
                'state_id'  => '17',
                'name'      => 'Pimenteiras',
                'ibge_code' => '2208106',
            ],

            326 => [
                'state_id'  => '17',
                'name'      => 'Pio Ix',
                'ibge_code' => '2208205',
            ],

            327 => [
                'state_id'  => '17',
                'name'      => 'Piracuruca',
                'ibge_code' => '2208304',
            ],

            328 => [
                'state_id'  => '17',
                'name'      => 'Piripiri',
                'ibge_code' => '2208403',
            ],

            329 => [
                'state_id'  => '17',
                'name'      => 'Porto',
                'ibge_code' => '2208502',
            ],

            330 => [
                'state_id'  => '17',
                'name'      => 'Porto Alegre do Piauí',
                'ibge_code' => '2208551',
            ],

            331 => [
                'state_id'  => '17',
                'name'      => 'Prata do Piauí',
                'ibge_code' => '2208601',
            ],

            332 => [
                'state_id'  => '17',
                'name'      => 'Queimada Nova',
                'ibge_code' => '2208650',
            ],

            333 => [
                'state_id'  => '17',
                'name'      => 'Redenção do Gurguéia',
                'ibge_code' => '2208700',
            ],

            334 => [
                'state_id'  => '17',
                'name'      => 'Regeneração',
                'ibge_code' => '2208809',
            ],

            335 => [
                'state_id'  => '17',
                'name'      => 'Riacho Frio',
                'ibge_code' => '2208858',
            ],

            336 => [
                'state_id'  => '17',
                'name'      => 'Ribeira do Piauí',
                'ibge_code' => '2208874',
            ],

            337 => [
                'state_id'  => '17',
                'name'      => 'Ribeiro Gonçalves',
                'ibge_code' => '2208908',
            ],

            338 => [
                'state_id'  => '17',
                'name'      => 'Rio Grande do Piauí',
                'ibge_code' => '2209005',
            ],

            339 => [
                'state_id'  => '17',
                'name'      => 'Santa Cruz do Piauí',
                'ibge_code' => '2209104',
            ],

            340 => [
                'state_id'  => '17',
                'name'      => 'Santa Cruz dos Milagres',
                'ibge_code' => '2209153',
            ],

            341 => [
                'state_id'  => '17',
                'name'      => 'Santa Filomena',
                'ibge_code' => '2209203',
            ],

            342 => [
                'state_id'  => '17',
                'name'      => 'Santa Luz',
                'ibge_code' => '2209302',
            ],

            343 => [
                'state_id'  => '17',
                'name'      => 'Santana do Piauí',
                'ibge_code' => '2209351',
            ],

            344 => [
                'state_id'  => '17',
                'name'      => 'Santa Rosa do Piauí',
                'ibge_code' => '2209377',
            ],

            345 => [
                'state_id'  => '17',
                'name'      => 'Santo Antônio de Lisboa',
                'ibge_code' => '2209401',
            ],

            346 => [
                'state_id'  => '17',
                'name'      => 'Santo Antônio dos Milagres',
                'ibge_code' => '2209450',
            ],

            347 => [
                'state_id'  => '17',
                'name'      => 'Santo Inácio do Piauí',
                'ibge_code' => '2209500',
            ],

            348 => [
                'state_id'  => '17',
                'name'      => 'São Braz do Piauí',
                'ibge_code' => '2209559',
            ],

            349 => [
                'state_id'  => '17',
                'name'      => 'São Félix do Piauí',
                'ibge_code' => '2209609',
            ],

            350 => [
                'state_id'  => '17',
                'name'      => 'São Francisco de Assis do Piauí',
                'ibge_code' => '2209658',
            ],

            351 => [
                'state_id'  => '17',
                'name'      => 'São Francisco do Piauí',
                'ibge_code' => '2209708',
            ],

            352 => [
                'state_id'  => '17',
                'name'      => 'São Gonçalo do Gurguéia',
                'ibge_code' => '2209757',
            ],

            353 => [
                'state_id'  => '17',
                'name'      => 'São Gonçalo do Piauí',
                'ibge_code' => '2209807',
            ],

            354 => [
                'state_id'  => '17',
                'name'      => 'São João da Canabrava',
                'ibge_code' => '2209856',
            ],

            355 => [
                'state_id'  => '17',
                'name'      => 'São João da Fronteira',
                'ibge_code' => '2209872',
            ],

            356 => [
                'state_id'  => '17',
                'name'      => 'São João da Serra',
                'ibge_code' => '2209906',
            ],

            357 => [
                'state_id'  => '17',
                'name'      => 'São João da Varjota',
                'ibge_code' => '2209955',
            ],

            358 => [
                'state_id'  => '17',
                'name'      => 'São João do Arraial',
                'ibge_code' => '2209971',
            ],

            359 => [
                'state_id'  => '17',
                'name'      => 'São João do Piauí',
                'ibge_code' => '2210003',
            ],

            360 => [
                'state_id'  => '17',
                'name'      => 'São José do Divino',
                'ibge_code' => '2210052',
            ],

            361 => [
                'state_id'  => '17',
                'name'      => 'São José do Peixe',
                'ibge_code' => '2210102',
            ],

            362 => [
                'state_id'  => '17',
                'name'      => 'São José do Piauí',
                'ibge_code' => '2210201',
            ],

            363 => [
                'state_id'  => '17',
                'name'      => 'São Julião',
                'ibge_code' => '2210300',
            ],

            364 => [
                'state_id'  => '17',
                'name'      => 'São Lourenço do Piauí',
                'ibge_code' => '2210359',
            ],

            365 => [
                'state_id'  => '17',
                'name'      => 'São Luis do Piauí',
                'ibge_code' => '2210375',
            ],

            366 => [
                'state_id'  => '17',
                'name'      => 'São Miguel da Baixa Grande',
                'ibge_code' => '2210383',
            ],

            367 => [
                'state_id'  => '17',
                'name'      => 'São Miguel do Fidalgo',
                'ibge_code' => '2210391',
            ],

            368 => [
                'state_id'  => '17',
                'name'      => 'São Miguel do Tapuio',
                'ibge_code' => '2210409',
            ],

            369 => [
                'state_id'  => '17',
                'name'      => 'São Pedro do Piauí',
                'ibge_code' => '2210508',
            ],

            370 => [
                'state_id'  => '17',
                'name'      => 'São Raimundo Nonato',
                'ibge_code' => '2210607',
            ],

            371 => [
                'state_id'  => '17',
                'name'      => 'Sebastião Barros',
                'ibge_code' => '2210623',
            ],

            372 => [
                'state_id'  => '17',
                'name'      => 'Sebastião Leal',
                'ibge_code' => '2210631',
            ],

            373 => [
                'state_id'  => '17',
                'name'      => 'Sigefredo Pacheco',
                'ibge_code' => '2210656',
            ],

            374 => [
                'state_id'  => '17',
                'name'      => 'Simões',
                'ibge_code' => '2210706',
            ],

            375 => [
                'state_id'  => '17',
                'name'      => 'Simplício Mendes',
                'ibge_code' => '2210805',
            ],

            376 => [
                'state_id'  => '17',
                'name'      => 'Socorro do Piauí',
                'ibge_code' => '2210904',
            ],

            377 => [
                'state_id'  => '17',
                'name'      => 'Sussuapara',
                'ibge_code' => '2210938',
            ],

            378 => [
                'state_id'  => '17',
                'name'      => 'Tamboril do Piauí',
                'ibge_code' => '2210953',
            ],

            379 => [
                'state_id'  => '17',
                'name'      => 'Tanque do Piauí',
                'ibge_code' => '2210979',
            ],

            380 => [
                'state_id'  => '17',
                'name'      => 'Teresina',
                'ibge_code' => '2211001',
            ],

            381 => [
                'state_id'  => '17',
                'name'      => 'União',
                'ibge_code' => '2211100',
            ],

            382 => [
                'state_id'  => '17',
                'name'      => 'Uruçuí',
                'ibge_code' => '2211209',
            ],

            383 => [
                'state_id'  => '17',
                'name'      => 'Valença do Piauí',
                'ibge_code' => '2211308',
            ],

            384 => [
                'state_id'  => '17',
                'name'      => 'Várzea Branca',
                'ibge_code' => '2211357',
            ],

            385 => [
                'state_id'  => '17',
                'name'      => 'Várzea Grande',
                'ibge_code' => '2211407',
            ],

            386 => [
                'state_id'  => '17',
                'name'      => 'Vera Mendes',
                'ibge_code' => '2211506',
            ],

            387 => [
                'state_id'  => '17',
                'name'      => 'Vila Nova do Piauí',
                'ibge_code' => '2211605',
            ],

            388 => [
                'state_id'  => '17',
                'name'      => 'Wall Ferraz',
                'ibge_code' => '2211704',
            ],

            389 => [
                'state_id'  => '6',
                'name'      => 'Abaiara',
                'ibge_code' => '2300101',
            ],

            390 => [
                'state_id'  => '6',
                'name'      => 'Acarape',
                'ibge_code' => '2300150',
            ],

            391 => [
                'state_id'  => '6',
                'name'      => 'Acaraú',
                'ibge_code' => '2300200',
            ],

            392 => [
                'state_id'  => '6',
                'name'      => 'Acopiara',
                'ibge_code' => '2300309',
            ],

            393 => [
                'state_id'  => '6',
                'name'      => 'Aiuaba',
                'ibge_code' => '2300408',
            ],

            394 => [
                'state_id'  => '6',
                'name'      => 'Alcântaras',
                'ibge_code' => '2300507',
            ],

            395 => [
                'state_id'  => '6',
                'name'      => 'Altaneira',
                'ibge_code' => '2300606',
            ],

            396 => [
                'state_id'  => '6',
                'name'      => 'Alto Santo',
                'ibge_code' => '2300705',
            ],

            397 => [
                'state_id'  => '6',
                'name'      => 'Amontada',
                'ibge_code' => '2300754',
            ],

            398 => [
                'state_id'  => '6',
                'name'      => 'Antonina do Norte',
                'ibge_code' => '2300804',
            ],

            399 => [
                'state_id'  => '6',
                'name'      => 'Apuiarés',
                'ibge_code' => '2300903',
            ],

            400 => [
                'state_id'  => '6',
                'name'      => 'Aquiraz',
                'ibge_code' => '2301000',
            ],

            401 => [
                'state_id'  => '6',
                'name'      => 'Aracati',
                'ibge_code' => '2301109',
            ],

            402 => [
                'state_id'  => '6',
                'name'      => 'Aracoiaba',
                'ibge_code' => '2301208',
            ],

            403 => [
                'state_id'  => '6',
                'name'      => 'Ararendá',
                'ibge_code' => '2301257',
            ],

            404 => [
                'state_id'  => '6',
                'name'      => 'Araripe',
                'ibge_code' => '2301307',
            ],

            405 => [
                'state_id'  => '6',
                'name'      => 'Aratuba',
                'ibge_code' => '2301406',
            ],

            406 => [
                'state_id'  => '6',
                'name'      => 'Arneiroz',
                'ibge_code' => '2301505',
            ],

            407 => [
                'state_id'  => '6',
                'name'      => 'Assaré',
                'ibge_code' => '2301604',
            ],

            408 => [
                'state_id'  => '6',
                'name'      => 'Aurora',
                'ibge_code' => '2301703',
            ],

            409 => [
                'state_id'  => '6',
                'name'      => 'Baixio',
                'ibge_code' => '2301802',
            ],

            410 => [
                'state_id'  => '6',
                'name'      => 'Banabuiú',
                'ibge_code' => '2301851',
            ],

            411 => [
                'state_id'  => '6',
                'name'      => 'Barbalha',
                'ibge_code' => '2301901',
            ],

            412 => [
                'state_id'  => '6',
                'name'      => 'Barreira',
                'ibge_code' => '2301950',
            ],

            413 => [
                'state_id'  => '6',
                'name'      => 'Barro',
                'ibge_code' => '2302008',
            ],

            414 => [
                'state_id'  => '6',
                'name'      => 'Barroquinha',
                'ibge_code' => '2302057',
            ],

            415 => [
                'state_id'  => '6',
                'name'      => 'Baturité',
                'ibge_code' => '2302107',
            ],

            416 => [
                'state_id'  => '6',
                'name'      => 'Beberibe',
                'ibge_code' => '2302206',
            ],

            417 => [
                'state_id'  => '6',
                'name'      => 'Bela Cruz',
                'ibge_code' => '2302305',
            ],

            418 => [
                'state_id'  => '6',
                'name'      => 'Boa Viagem',
                'ibge_code' => '2302404',
            ],

            419 => [
                'state_id'  => '6',
                'name'      => 'Brejo Santo',
                'ibge_code' => '2302503',
            ],

            420 => [
                'state_id'  => '6',
                'name'      => 'Camocim',
                'ibge_code' => '2302602',
            ],

            421 => [
                'state_id'  => '6',
                'name'      => 'Campos Sales',
                'ibge_code' => '2302701',
            ],

            422 => [
                'state_id'  => '6',
                'name'      => 'Canindé',
                'ibge_code' => '2302800',
            ],

            423 => [
                'state_id'  => '6',
                'name'      => 'Capistrano',
                'ibge_code' => '2302909',
            ],

            424 => [
                'state_id'  => '6',
                'name'      => 'Caridade',
                'ibge_code' => '2303006',
            ],

            425 => [
                'state_id'  => '6',
                'name'      => 'Cariré',
                'ibge_code' => '2303105',
            ],

            426 => [
                'state_id'  => '6',
                'name'      => 'Caririaçu',
                'ibge_code' => '2303204',
            ],

            427 => [
                'state_id'  => '6',
                'name'      => 'Cariús',
                'ibge_code' => '2303303',
            ],

            428 => [
                'state_id'  => '6',
                'name'      => 'Carnaubal',
                'ibge_code' => '2303402',
            ],

            429 => [
                'state_id'  => '6',
                'name'      => 'Cascavel',
                'ibge_code' => '2303501',
            ],

            430 => [
                'state_id'  => '6',
                'name'      => 'Catarina',
                'ibge_code' => '2303600',
            ],

            431 => [
                'state_id'  => '6',
                'name'      => 'Catunda',
                'ibge_code' => '2303659',
            ],

            432 => [
                'state_id'  => '6',
                'name'      => 'Caucaia',
                'ibge_code' => '2303709',
            ],

            433 => [
                'state_id'  => '6',
                'name'      => 'Cedro',
                'ibge_code' => '2303808',
            ],

            434 => [
                'state_id'  => '6',
                'name'      => 'Chaval',
                'ibge_code' => '2303907',
            ],

            435 => [
                'state_id'  => '6',
                'name'      => 'Choró',
                'ibge_code' => '2303931',
            ],

            436 => [
                'state_id'  => '6',
                'name'      => 'Chorozinho',
                'ibge_code' => '2303956',
            ],

            437 => [
                'state_id'  => '6',
                'name'      => 'Coreaú',
                'ibge_code' => '2304004',
            ],

            438 => [
                'state_id'  => '6',
                'name'      => 'Crateús',
                'ibge_code' => '2304103',
            ],

            439 => [
                'state_id'  => '6',
                'name'      => 'Crato',
                'ibge_code' => '2304202',
            ],

            440 => [
                'state_id'  => '6',
                'name'      => 'Croatá',
                'ibge_code' => '2304236',
            ],

            441 => [
                'state_id'  => '6',
                'name'      => 'Cruz',
                'ibge_code' => '2304251',
            ],

            442 => [
                'state_id'  => '6',
                'name'      => 'Deputado Irapuan Pinheiro',
                'ibge_code' => '2304269',
            ],

            443 => [
                'state_id'  => '6',
                'name'      => 'Ererê',
                'ibge_code' => '2304277',
            ],

            444 => [
                'state_id'  => '6',
                'name'      => 'Eusébio',
                'ibge_code' => '2304285',
            ],

            445 => [
                'state_id'  => '6',
                'name'      => 'Farias Brito',
                'ibge_code' => '2304301',
            ],

            446 => [
                'state_id'  => '6',
                'name'      => 'Forquilha',
                'ibge_code' => '2304350',
            ],

            447 => [
                'state_id'  => '6',
                'name'      => 'Fortaleza',
                'ibge_code' => '2304400',
            ],

            448 => [
                'state_id'  => '6',
                'name'      => 'Fortim',
                'ibge_code' => '2304459',
            ],

            449 => [
                'state_id'  => '6',
                'name'      => 'Frecheirinha',
                'ibge_code' => '2304509',
            ],

            450 => [
                'state_id'  => '6',
                'name'      => 'General Sampaio',
                'ibge_code' => '2304608',
            ],

            451 => [
                'state_id'  => '6',
                'name'      => 'Graça',
                'ibge_code' => '2304657',
            ],

            452 => [
                'state_id'  => '6',
                'name'      => 'Granja',
                'ibge_code' => '2304707',
            ],

            453 => [
                'state_id'  => '6',
                'name'      => 'Granjeiro',
                'ibge_code' => '2304806',
            ],

            454 => [
                'state_id'  => '6',
                'name'      => 'Groaíras',
                'ibge_code' => '2304905',
            ],

            455 => [
                'state_id'  => '6',
                'name'      => 'Guaiúba',
                'ibge_code' => '2304954',
            ],

            456 => [
                'state_id'  => '6',
                'name'      => 'Guaraciaba do Norte',
                'ibge_code' => '2305001',
            ],

            457 => [
                'state_id'  => '6',
                'name'      => 'Guaramiranga',
                'ibge_code' => '2305100',
            ],

            458 => [
                'state_id'  => '6',
                'name'      => 'Hidrolândia',
                'ibge_code' => '2305209',
            ],

            459 => [
                'state_id'  => '6',
                'name'      => 'Horizonte',
                'ibge_code' => '2305233',
            ],

            460 => [
                'state_id'  => '6',
                'name'      => 'Ibaretama',
                'ibge_code' => '2305266',
            ],

            461 => [
                'state_id'  => '6',
                'name'      => 'Ibiapina',
                'ibge_code' => '2305308',
            ],

            462 => [
                'state_id'  => '6',
                'name'      => 'Ibicuitinga',
                'ibge_code' => '2305332',
            ],

            463 => [
                'state_id'  => '6',
                'name'      => 'Icapuí',
                'ibge_code' => '2305357',
            ],

            464 => [
                'state_id'  => '6',
                'name'      => 'Icó',
                'ibge_code' => '2305407',
            ],

            465 => [
                'state_id'  => '6',
                'name'      => 'Iguatu',
                'ibge_code' => '2305506',
            ],

            466 => [
                'state_id'  => '6',
                'name'      => 'Independência',
                'ibge_code' => '2305605',
            ],

            467 => [
                'state_id'  => '6',
                'name'      => 'Ipaporanga',
                'ibge_code' => '2305654',
            ],

            468 => [
                'state_id'  => '6',
                'name'      => 'Ipaumirim',
                'ibge_code' => '2305704',
            ],

            469 => [
                'state_id'  => '6',
                'name'      => 'Ipu',
                'ibge_code' => '2305803',
            ],

            470 => [
                'state_id'  => '6',
                'name'      => 'Ipueiras',
                'ibge_code' => '2305902',
            ],

            471 => [
                'state_id'  => '6',
                'name'      => 'Iracema',
                'ibge_code' => '2306009',
            ],

            472 => [
                'state_id'  => '6',
                'name'      => 'Irauçuba',
                'ibge_code' => '2306108',
            ],

            473 => [
                'state_id'  => '6',
                'name'      => 'Itaiçaba',
                'ibge_code' => '2306207',
            ],

            474 => [
                'state_id'  => '6',
                'name'      => 'Itaitinga',
                'ibge_code' => '2306256',
            ],

            475 => [
                'state_id'  => '6',
                'name'      => 'Itapagé',
                'ibge_code' => '2306306',
            ],

            476 => [
                'state_id'  => '6',
                'name'      => 'Itapipoca',
                'ibge_code' => '2306405',
            ],

            477 => [
                'state_id'  => '6',
                'name'      => 'Itapiúna',
                'ibge_code' => '2306504',
            ],

            478 => [
                'state_id'  => '6',
                'name'      => 'Itarema',
                'ibge_code' => '2306553',
            ],

            479 => [
                'state_id'  => '6',
                'name'      => 'Itatira',
                'ibge_code' => '2306603',
            ],

            480 => [
                'state_id'  => '6',
                'name'      => 'Jaguaretama',
                'ibge_code' => '2306702',
            ],

            481 => [
                'state_id'  => '6',
                'name'      => 'Jaguaribara',
                'ibge_code' => '2306801',
            ],

            482 => [
                'state_id'  => '6',
                'name'      => 'Jaguaribe',
                'ibge_code' => '2306900',
            ],

            483 => [
                'state_id'  => '6',
                'name'      => 'Jaguaruana',
                'ibge_code' => '2307007',
            ],

            484 => [
                'state_id'  => '6',
                'name'      => 'Jardim',
                'ibge_code' => '2307106',
            ],

            485 => [
                'state_id'  => '6',
                'name'      => 'Jati',
                'ibge_code' => '2307205',
            ],

            486 => [
                'state_id'  => '6',
                'name'      => 'Jijoca de Jericoacoara',
                'ibge_code' => '2307254',
            ],

            487 => [
                'state_id'  => '6',
                'name'      => 'Juazeiro do Norte',
                'ibge_code' => '2307304',
            ],

            488 => [
                'state_id'  => '6',
                'name'      => 'Jucás',
                'ibge_code' => '2307403',
            ],

            489 => [
                'state_id'  => '6',
                'name'      => 'Lavras da Mangabeira',
                'ibge_code' => '2307502',
            ],

            490 => [
                'state_id'  => '6',
                'name'      => 'Limoeiro do Norte',
                'ibge_code' => '2307601',
            ],

            491 => [
                'state_id'  => '6',
                'name'      => 'Madalena',
                'ibge_code' => '2307635',
            ],

            492 => [
                'state_id'  => '6',
                'name'      => 'Maracanaú',
                'ibge_code' => '2307650',
            ],

            493 => [
                'state_id'  => '6',
                'name'      => 'Maranguape',
                'ibge_code' => '2307700',
            ],

            494 => [
                'state_id'  => '6',
                'name'      => 'Marco',
                'ibge_code' => '2307809',
            ],

            495 => [
                'state_id'  => '6',
                'name'      => 'Martinópole',
                'ibge_code' => '2307908',
            ],

            496 => [
                'state_id'  => '6',
                'name'      => 'Massapê',
                'ibge_code' => '2308005',
            ],

            497 => [
                'state_id'  => '6',
                'name'      => 'Mauriti',
                'ibge_code' => '2308104',
            ],

            498 => [
                'state_id'  => '6',
                'name'      => 'Meruoca',
                'ibge_code' => '2308203',
            ],

            499 => [
                'state_id'  => '6',
                'name'      => 'Milagres',
                'ibge_code' => '2308302',
            ],

        ]);
        DB::table('cities')->insert([
            0 => [
                'state_id'  => '6',
                'name'      => 'Milhã',
                'ibge_code' => '2308351',
            ],

            1 => [
                'state_id'  => '6',
                'name'      => 'Miraíma',
                'ibge_code' => '2308377',
            ],

            2 => [
                'state_id'  => '6',
                'name'      => 'Missão Velha',
                'ibge_code' => '2308401',
            ],

            3 => [
                'state_id'  => '6',
                'name'      => 'Mombaça',
                'ibge_code' => '2308500',
            ],

            4 => [
                'state_id'  => '6',
                'name'      => 'Monsenhor Tabosa',
                'ibge_code' => '2308609',
            ],

            5 => [
                'state_id'  => '6',
                'name'      => 'Morada Nova',
                'ibge_code' => '2308708',
            ],

            6 => [
                'state_id'  => '6',
                'name'      => 'Moraújo',
                'ibge_code' => '2308807',
            ],

            7 => [
                'state_id'  => '6',
                'name'      => 'Morrinhos',
                'ibge_code' => '2308906',
            ],

            8 => [
                'state_id'  => '6',
                'name'      => 'Mucambo',
                'ibge_code' => '2309003',
            ],

            9 => [
                'state_id'  => '6',
                'name'      => 'Mulungu',
                'ibge_code' => '2309102',
            ],

            10 => [
                'state_id'  => '6',
                'name'      => 'Nova Olinda',
                'ibge_code' => '2309201',
            ],

            11 => [
                'state_id'  => '6',
                'name'      => 'Nova Russas',
                'ibge_code' => '2309300',
            ],

            12 => [
                'state_id'  => '6',
                'name'      => 'Novo Oriente',
                'ibge_code' => '2309409',
            ],

            13 => [
                'state_id'  => '6',
                'name'      => 'Ocara',
                'ibge_code' => '2309458',
            ],

            14 => [
                'state_id'  => '6',
                'name'      => 'Orós',
                'ibge_code' => '2309508',
            ],

            15 => [
                'state_id'  => '6',
                'name'      => 'Pacajus',
                'ibge_code' => '2309607',
            ],

            16 => [
                'state_id'  => '6',
                'name'      => 'Pacatuba',
                'ibge_code' => '2309706',
            ],

            17 => [
                'state_id'  => '6',
                'name'      => 'Pacoti',
                'ibge_code' => '2309805',
            ],

            18 => [
                'state_id'  => '6',
                'name'      => 'Pacujá',
                'ibge_code' => '2309904',
            ],

            19 => [
                'state_id'  => '6',
                'name'      => 'Palhano',
                'ibge_code' => '2310001',
            ],

            20 => [
                'state_id'  => '6',
                'name'      => 'Palmácia',
                'ibge_code' => '2310100',
            ],

            21 => [
                'state_id'  => '6',
                'name'      => 'Paracuru',
                'ibge_code' => '2310209',
            ],

            22 => [
                'state_id'  => '6',
                'name'      => 'Paraipaba',
                'ibge_code' => '2310258',
            ],

            23 => [
                'state_id'  => '6',
                'name'      => 'Parambu',
                'ibge_code' => '2310308',
            ],

            24 => [
                'state_id'  => '6',
                'name'      => 'Paramoti',
                'ibge_code' => '2310407',
            ],

            25 => [
                'state_id'  => '6',
                'name'      => 'Pedra Branca',
                'ibge_code' => '2310506',
            ],

            26 => [
                'state_id'  => '6',
                'name'      => 'Penaforte',
                'ibge_code' => '2310605',
            ],

            27 => [
                'state_id'  => '6',
                'name'      => 'Pentecoste',
                'ibge_code' => '2310704',
            ],

            28 => [
                'state_id'  => '6',
                'name'      => 'Pereiro',
                'ibge_code' => '2310803',
            ],

            29 => [
                'state_id'  => '6',
                'name'      => 'Pindoretama',
                'ibge_code' => '2310852',
            ],

            30 => [
                'state_id'  => '6',
                'name'      => 'Piquet Carneiro',
                'ibge_code' => '2310902',
            ],

            31 => [
                'state_id'  => '6',
                'name'      => 'Pires Ferreira',
                'ibge_code' => '2310951',
            ],

            32 => [
                'state_id'  => '6',
                'name'      => 'Poranga',
                'ibge_code' => '2311009',
            ],

            33 => [
                'state_id'  => '6',
                'name'      => 'Porteiras',
                'ibge_code' => '2311108',
            ],

            34 => [
                'state_id'  => '6',
                'name'      => 'Potengi',
                'ibge_code' => '2311207',
            ],

            35 => [
                'state_id'  => '6',
                'name'      => 'Potiretama',
                'ibge_code' => '2311231',
            ],

            36 => [
                'state_id'  => '6',
                'name'      => 'Quiterianópolis',
                'ibge_code' => '2311264',
            ],

            37 => [
                'state_id'  => '6',
                'name'      => 'Quixadá',
                'ibge_code' => '2311306',
            ],

            38 => [
                'state_id'  => '6',
                'name'      => 'Quixelô',
                'ibge_code' => '2311355',
            ],

            39 => [
                'state_id'  => '6',
                'name'      => 'Quixeramobim',
                'ibge_code' => '2311405',
            ],

            40 => [
                'state_id'  => '6',
                'name'      => 'Quixeré',
                'ibge_code' => '2311504',
            ],

            41 => [
                'state_id'  => '6',
                'name'      => 'Redenção',
                'ibge_code' => '2311603',
            ],

            42 => [
                'state_id'  => '6',
                'name'      => 'Reriutaba',
                'ibge_code' => '2311702',
            ],

            43 => [
                'state_id'  => '6',
                'name'      => 'Russas',
                'ibge_code' => '2311801',
            ],

            44 => [
                'state_id'  => '6',
                'name'      => 'Saboeiro',
                'ibge_code' => '2311900',
            ],

            45 => [
                'state_id'  => '6',
                'name'      => 'Salitre',
                'ibge_code' => '2311959',
            ],

            46 => [
                'state_id'  => '6',
                'name'      => 'Santana do Acaraú',
                'ibge_code' => '2312007',
            ],

            47 => [
                'state_id'  => '6',
                'name'      => 'Santana do Cariri',
                'ibge_code' => '2312106',
            ],

            48 => [
                'state_id'  => '6',
                'name'      => 'Santa Quitéria',
                'ibge_code' => '2312205',
            ],

            49 => [
                'state_id'  => '6',
                'name'      => 'São Benedito',
                'ibge_code' => '2312304',
            ],

            50 => [
                'state_id'  => '6',
                'name'      => 'São Gonçalo do Amarante',
                'ibge_code' => '2312403',
            ],

            51 => [
                'state_id'  => '6',
                'name'      => 'São João do Jaguaribe',
                'ibge_code' => '2312502',
            ],

            52 => [
                'state_id'  => '6',
                'name'      => 'São Luís do Curu',
                'ibge_code' => '2312601',
            ],

            53 => [
                'state_id'  => '6',
                'name'      => 'Senador Pompeu',
                'ibge_code' => '2312700',
            ],

            54 => [
                'state_id'  => '6',
                'name'      => 'Senador Sá',
                'ibge_code' => '2312809',
            ],

            55 => [
                'state_id'  => '6',
                'name'      => 'Sobral',
                'ibge_code' => '2312908',
            ],

            56 => [
                'state_id'  => '6',
                'name'      => 'Solonópole',
                'ibge_code' => '2313005',
            ],

            57 => [
                'state_id'  => '6',
                'name'      => 'Tabuleiro do Norte',
                'ibge_code' => '2313104',
            ],

            58 => [
                'state_id'  => '6',
                'name'      => 'Tamboril',
                'ibge_code' => '2313203',
            ],

            59 => [
                'state_id'  => '6',
                'name'      => 'Tarrafas',
                'ibge_code' => '2313252',
            ],

            60 => [
                'state_id'  => '6',
                'name'      => 'Tauá',
                'ibge_code' => '2313302',
            ],

            61 => [
                'state_id'  => '6',
                'name'      => 'Tejuçuoca',
                'ibge_code' => '2313351',
            ],

            62 => [
                'state_id'  => '6',
                'name'      => 'Tianguá',
                'ibge_code' => '2313401',
            ],

            63 => [
                'state_id'  => '6',
                'name'      => 'Trairi',
                'ibge_code' => '2313500',
            ],

            64 => [
                'state_id'  => '6',
                'name'      => 'Tururu',
                'ibge_code' => '2313559',
            ],

            65 => [
                'state_id'  => '6',
                'name'      => 'Ubajara',
                'ibge_code' => '2313609',
            ],

            66 => [
                'state_id'  => '6',
                'name'      => 'Umari',
                'ibge_code' => '2313708',
            ],

            67 => [
                'state_id'  => '6',
                'name'      => 'Umirim',
                'ibge_code' => '2313757',
            ],

            68 => [
                'state_id'  => '6',
                'name'      => 'Uruburetama',
                'ibge_code' => '2313807',
            ],

            69 => [
                'state_id'  => '6',
                'name'      => 'Uruoca',
                'ibge_code' => '2313906',
            ],

            70 => [
                'state_id'  => '6',
                'name'      => 'Varjota',
                'ibge_code' => '2313955',
            ],

            71 => [
                'state_id'  => '6',
                'name'      => 'Várzea Alegre',
                'ibge_code' => '2314003',
            ],

            72 => [
                'state_id'  => '6',
                'name'      => 'Viçosa do Ceará',
                'ibge_code' => '2314102',
            ],

            73 => [
                'state_id'  => '20',
                'name'      => 'Acari',
                'ibge_code' => '2400109',
            ],

            74 => [
                'state_id'  => '20',
                'name'      => 'Açu',
                'ibge_code' => '2400208',
            ],

            75 => [
                'state_id'  => '20',
                'name'      => 'Afonso Bezerra',
                'ibge_code' => '2400307',
            ],

            76 => [
                'state_id'  => '20',
                'name'      => 'Água Nova',
                'ibge_code' => '2400406',
            ],

            77 => [
                'state_id'  => '20',
                'name'      => 'Alexandria',
                'ibge_code' => '2400505',
            ],

            78 => [
                'state_id'  => '20',
                'name'      => 'Almino Afonso',
                'ibge_code' => '2400604',
            ],

            79 => [
                'state_id'  => '20',
                'name'      => 'Alto do Rodrigues',
                'ibge_code' => '2400703',
            ],

            80 => [
                'state_id'  => '20',
                'name'      => 'Angicos',
                'ibge_code' => '2400802',
            ],

            81 => [
                'state_id'  => '20',
                'name'      => 'Antônio Martins',
                'ibge_code' => '2400901',
            ],

            82 => [
                'state_id'  => '20',
                'name'      => 'Apodi',
                'ibge_code' => '2401008',
            ],

            83 => [
                'state_id'  => '20',
                'name'      => 'Areia Branca',
                'ibge_code' => '2401107',
            ],

            84 => [
                'state_id'  => '20',
                'name'      => 'Arês',
                'ibge_code' => '2401206',
            ],

            85 => [
                'state_id'  => '20',
                'name'      => 'Augusto Severo',
                'ibge_code' => '2401305',
            ],

            86 => [
                'state_id'  => '20',
                'name'      => 'Baía Formosa',
                'ibge_code' => '2401404',
            ],

            87 => [
                'state_id'  => '20',
                'name'      => 'Baraúna',
                'ibge_code' => '2401453',
            ],

            88 => [
                'state_id'  => '20',
                'name'      => 'Barcelona',
                'ibge_code' => '2401503',
            ],

            89 => [
                'state_id'  => '20',
                'name'      => 'Bento Fernandes',
                'ibge_code' => '2401602',
            ],

            90 => [
                'state_id'  => '20',
                'name'      => 'Bodó',
                'ibge_code' => '2401651',
            ],

            91 => [
                'state_id'  => '20',
                'name'      => 'Bom Jesus',
                'ibge_code' => '2401701',
            ],

            92 => [
                'state_id'  => '20',
                'name'      => 'Brejinho',
                'ibge_code' => '2401800',
            ],

            93 => [
                'state_id'  => '20',
                'name'      => 'Caiçara do Norte',
                'ibge_code' => '2401859',
            ],

            94 => [
                'state_id'  => '20',
                'name'      => 'Caiçara do Rio do Vento',
                'ibge_code' => '2401909',
            ],

            95 => [
                'state_id'  => '20',
                'name'      => 'Caicó',
                'ibge_code' => '2402006',
            ],

            96 => [
                'state_id'  => '20',
                'name'      => 'Campo Redondo',
                'ibge_code' => '2402105',
            ],

            97 => [
                'state_id'  => '20',
                'name'      => 'Canguaretama',
                'ibge_code' => '2402204',
            ],

            98 => [
                'state_id'  => '20',
                'name'      => 'Caraúbas',
                'ibge_code' => '2402303',
            ],

            99 => [
                'state_id'  => '20',
                'name'      => 'Carnaúba dos Dantas',
                'ibge_code' => '2402402',
            ],

            100 => [
                'state_id'  => '20',
                'name'      => 'Carnaubais',
                'ibge_code' => '2402501',
            ],

            101 => [
                'state_id'  => '20',
                'name'      => 'Ceará-Mirim',
                'ibge_code' => '2402600',
            ],

            102 => [
                'state_id'  => '20',
                'name'      => 'Cerro Corá',
                'ibge_code' => '2402709',
            ],

            103 => [
                'state_id'  => '20',
                'name'      => 'Coronel Ezequiel',
                'ibge_code' => '2402808',
            ],

            104 => [
                'state_id'  => '20',
                'name'      => 'Coronel João Pessoa',
                'ibge_code' => '2402907',
            ],

            105 => [
                'state_id'  => '20',
                'name'      => 'Cruzeta',
                'ibge_code' => '2403004',
            ],

            106 => [
                'state_id'  => '20',
                'name'      => 'Currais Novos',
                'ibge_code' => '2403103',
            ],

            107 => [
                'state_id'  => '20',
                'name'      => 'Doutor Severiano',
                'ibge_code' => '2403202',
            ],

            108 => [
                'state_id'  => '20',
                'name'      => 'Parnamirim',
                'ibge_code' => '2403251',
            ],

            109 => [
                'state_id'  => '20',
                'name'      => 'Encanto',
                'ibge_code' => '2403301',
            ],

            110 => [
                'state_id'  => '20',
                'name'      => 'Equador',
                'ibge_code' => '2403400',
            ],

            111 => [
                'state_id'  => '20',
                'name'      => 'Espírito Santo',
                'ibge_code' => '2403509',
            ],

            112 => [
                'state_id'  => '20',
                'name'      => 'Extremoz',
                'ibge_code' => '2403608',
            ],

            113 => [
                'state_id'  => '20',
                'name'      => 'Felipe Guerra',
                'ibge_code' => '2403707',
            ],

            114 => [
                'state_id'  => '20',
                'name'      => 'Fernando Pedroza',
                'ibge_code' => '2403756',
            ],

            115 => [
                'state_id'  => '20',
                'name'      => 'Florânia',
                'ibge_code' => '2403806',
            ],

            116 => [
                'state_id'  => '20',
                'name'      => 'Francisco Dantas',
                'ibge_code' => '2403905',
            ],

            117 => [
                'state_id'  => '20',
                'name'      => 'Frutuoso Gomes',
                'ibge_code' => '2404002',
            ],

            118 => [
                'state_id'  => '20',
                'name'      => 'Galinhos',
                'ibge_code' => '2404101',
            ],

            119 => [
                'state_id'  => '20',
                'name'      => 'Goianinha',
                'ibge_code' => '2404200',
            ],

            120 => [
                'state_id'  => '20',
                'name'      => 'Governador Dix-Sept Rosado',
                'ibge_code' => '2404309',
            ],

            121 => [
                'state_id'  => '20',
                'name'      => 'Grossos',
                'ibge_code' => '2404408',
            ],

            122 => [
                'state_id'  => '20',
                'name'      => 'Guamaré',
                'ibge_code' => '2404507',
            ],

            123 => [
                'state_id'  => '20',
                'name'      => 'Ielmo Marinho',
                'ibge_code' => '2404606',
            ],

            124 => [
                'state_id'  => '20',
                'name'      => 'Ipanguaçu',
                'ibge_code' => '2404705',
            ],

            125 => [
                'state_id'  => '20',
                'name'      => 'Ipueira',
                'ibge_code' => '2404804',
            ],

            126 => [
                'state_id'  => '20',
                'name'      => 'Itajá',
                'ibge_code' => '2404853',
            ],

            127 => [
                'state_id'  => '20',
                'name'      => 'Itaú',
                'ibge_code' => '2404903',
            ],

            128 => [
                'state_id'  => '20',
                'name'      => 'Jaçanã',
                'ibge_code' => '2405009',
            ],

            129 => [
                'state_id'  => '20',
                'name'      => 'Jandaíra',
                'ibge_code' => '2405108',
            ],

            130 => [
                'state_id'  => '20',
                'name'      => 'Janduís',
                'ibge_code' => '2405207',
            ],

            131 => [
                'state_id'  => '20',
                'name'      => 'Januário Cicco',
                'ibge_code' => '2405306',
            ],

            132 => [
                'state_id'  => '20',
                'name'      => 'Japi',
                'ibge_code' => '2405405',
            ],

            133 => [
                'state_id'  => '20',
                'name'      => 'Jardim de Angicos',
                'ibge_code' => '2405504',
            ],

            134 => [
                'state_id'  => '20',
                'name'      => 'Jardim de Piranhas',
                'ibge_code' => '2405603',
            ],

            135 => [
                'state_id'  => '20',
                'name'      => 'Jardim do Seridó',
                'ibge_code' => '2405702',
            ],

            136 => [
                'state_id'  => '20',
                'name'      => 'João Câmara',
                'ibge_code' => '2405801',
            ],

            137 => [
                'state_id'  => '20',
                'name'      => 'João Dias',
                'ibge_code' => '2405900',
            ],

            138 => [
                'state_id'  => '20',
                'name'      => 'José da Penha',
                'ibge_code' => '2406007',
            ],

            139 => [
                'state_id'  => '20',
                'name'      => 'Jucurutu',
                'ibge_code' => '2406106',
            ],

            140 => [
                'state_id'  => '20',
                'name'      => 'Jundiá',
                'ibge_code' => '2406155',
            ],

            141 => [
                'state_id'  => '20',
                'name'      => "Lagoa D'anta",
                'ibge_code' => '2406205',
            ],

            142 => [
                'state_id'  => '20',
                'name'      => 'Lagoa de Pedras',
                'ibge_code' => '2406304',
            ],

            143 => [
                'state_id'  => '20',
                'name'      => 'Lagoa de Velhos',
                'ibge_code' => '2406403',
            ],

            144 => [
                'state_id'  => '20',
                'name'      => 'Lagoa Nova',
                'ibge_code' => '2406502',
            ],

            145 => [
                'state_id'  => '20',
                'name'      => 'Lagoa Salgada',
                'ibge_code' => '2406601',
            ],

            146 => [
                'state_id'  => '20',
                'name'      => 'Lajes',
                'ibge_code' => '2406700',
            ],

            147 => [
                'state_id'  => '20',
                'name'      => 'Lajes Pintadas',
                'ibge_code' => '2406809',
            ],

            148 => [
                'state_id'  => '20',
                'name'      => 'Lucrécia',
                'ibge_code' => '2406908',
            ],

            149 => [
                'state_id'  => '20',
                'name'      => 'Luís Gomes',
                'ibge_code' => '2407005',
            ],

            150 => [
                'state_id'  => '20',
                'name'      => 'Macaíba',
                'ibge_code' => '2407104',
            ],

            151 => [
                'state_id'  => '20',
                'name'      => 'Macau',
                'ibge_code' => '2407203',
            ],

            152 => [
                'state_id'  => '20',
                'name'      => 'Major Sales',
                'ibge_code' => '2407252',
            ],

            153 => [
                'state_id'  => '20',
                'name'      => 'Marcelino Vieira',
                'ibge_code' => '2407302',
            ],

            154 => [
                'state_id'  => '20',
                'name'      => 'Martins',
                'ibge_code' => '2407401',
            ],

            155 => [
                'state_id'  => '20',
                'name'      => 'Maxaranguape',
                'ibge_code' => '2407500',
            ],

            156 => [
                'state_id'  => '20',
                'name'      => 'Messias Targino',
                'ibge_code' => '2407609',
            ],

            157 => [
                'state_id'  => '20',
                'name'      => 'Montanhas',
                'ibge_code' => '2407708',
            ],

            158 => [
                'state_id'  => '20',
                'name'      => 'Monte Alegre',
                'ibge_code' => '2407807',
            ],

            159 => [
                'state_id'  => '20',
                'name'      => 'Monte das Gameleiras',
                'ibge_code' => '2407906',
            ],

            160 => [
                'state_id'  => '20',
                'name'      => 'Mossoró',
                'ibge_code' => '2408003',
            ],

            161 => [
                'state_id'  => '20',
                'name'      => 'Natal',
                'ibge_code' => '2408102',
            ],

            162 => [
                'state_id'  => '20',
                'name'      => 'Nísia Floresta',
                'ibge_code' => '2408201',
            ],

            163 => [
                'state_id'  => '20',
                'name'      => 'Nova Cruz',
                'ibge_code' => '2408300',
            ],

            164 => [
                'state_id'  => '20',
                'name'      => "Olho-D'água do Borges",
                'ibge_code' => '2408409',
            ],

            165 => [
                'state_id'  => '20',
                'name'      => 'Ouro Branco',
                'ibge_code' => '2408508',
            ],

            166 => [
                'state_id'  => '20',
                'name'      => 'Paraná',
                'ibge_code' => '2408607',
            ],

            167 => [
                'state_id'  => '20',
                'name'      => 'Paraú',
                'ibge_code' => '2408706',
            ],

            168 => [
                'state_id'  => '20',
                'name'      => 'Parazinho',
                'ibge_code' => '2408805',
            ],

            169 => [
                'state_id'  => '20',
                'name'      => 'Parelhas',
                'ibge_code' => '2408904',
            ],

            170 => [
                'state_id'  => '20',
                'name'      => 'Rio do Fogo',
                'ibge_code' => '2408953',
            ],

            171 => [
                'state_id'  => '20',
                'name'      => 'Passa e Fica',
                'ibge_code' => '2409100',
            ],

            172 => [
                'state_id'  => '20',
                'name'      => 'Passagem',
                'ibge_code' => '2409209',
            ],

            173 => [
                'state_id'  => '20',
                'name'      => 'Patu',
                'ibge_code' => '2409308',
            ],

            174 => [
                'state_id'  => '20',
                'name'      => 'Santa Maria',
                'ibge_code' => '2409332',
            ],

            175 => [
                'state_id'  => '20',
                'name'      => 'Pau dos Ferros',
                'ibge_code' => '2409407',
            ],

            176 => [
                'state_id'  => '20',
                'name'      => 'Pedra Grande',
                'ibge_code' => '2409506',
            ],

            177 => [
                'state_id'  => '20',
                'name'      => 'Pedra Preta',
                'ibge_code' => '2409605',
            ],

            178 => [
                'state_id'  => '20',
                'name'      => 'Pedro Avelino',
                'ibge_code' => '2409704',
            ],

            179 => [
                'state_id'  => '20',
                'name'      => 'Pedro Velho',
                'ibge_code' => '2409803',
            ],

            180 => [
                'state_id'  => '20',
                'name'      => 'Pendências',
                'ibge_code' => '2409902',
            ],

            181 => [
                'state_id'  => '20',
                'name'      => 'Pilões',
                'ibge_code' => '2410009',
            ],

            182 => [
                'state_id'  => '20',
                'name'      => 'Poço Branco',
                'ibge_code' => '2410108',
            ],

            183 => [
                'state_id'  => '20',
                'name'      => 'Portalegre',
                'ibge_code' => '2410207',
            ],

            184 => [
                'state_id'  => '20',
                'name'      => 'Porto do Mangue',
                'ibge_code' => '2410256',
            ],

            185 => [
                'state_id'  => '20',
                'name'      => 'Presidente Juscelino',
                'ibge_code' => '2410306',
            ],

            186 => [
                'state_id'  => '20',
                'name'      => 'Pureza',
                'ibge_code' => '2410405',
            ],

            187 => [
                'state_id'  => '20',
                'name'      => 'Rafael Fernandes',
                'ibge_code' => '2410504',
            ],

            188 => [
                'state_id'  => '20',
                'name'      => 'Rafael Godeiro',
                'ibge_code' => '2410603',
            ],

            189 => [
                'state_id'  => '20',
                'name'      => 'Riacho da Cruz',
                'ibge_code' => '2410702',
            ],

            190 => [
                'state_id'  => '20',
                'name'      => 'Riacho de Santana',
                'ibge_code' => '2410801',
            ],

            191 => [
                'state_id'  => '20',
                'name'      => 'Riachuelo',
                'ibge_code' => '2410900',
            ],

            192 => [
                'state_id'  => '20',
                'name'      => 'Rodolfo Fernandes',
                'ibge_code' => '2411007',
            ],

            193 => [
                'state_id'  => '20',
                'name'      => 'Tibau',
                'ibge_code' => '2411056',
            ],

            194 => [
                'state_id'  => '20',
                'name'      => 'Ruy Barbosa',
                'ibge_code' => '2411106',
            ],

            195 => [
                'state_id'  => '20',
                'name'      => 'Santa Cruz',
                'ibge_code' => '2411205',
            ],

            196 => [
                'state_id'  => '20',
                'name'      => 'Santana do Matos',
                'ibge_code' => '2411403',
            ],

            197 => [
                'state_id'  => '20',
                'name'      => 'Santana do Seridó',
                'ibge_code' => '2411429',
            ],

            198 => [
                'state_id'  => '20',
                'name'      => 'Santo Antônio',
                'ibge_code' => '2411502',
            ],

            199 => [
                'state_id'  => '20',
                'name'      => 'São Bento do Norte',
                'ibge_code' => '2411601',
            ],

            200 => [
                'state_id'  => '20',
                'name'      => 'São Bento do Trairí',
                'ibge_code' => '2411700',
            ],

            201 => [
                'state_id'  => '20',
                'name'      => 'São Fernando',
                'ibge_code' => '2411809',
            ],

            202 => [
                'state_id'  => '20',
                'name'      => 'São Francisco do Oeste',
                'ibge_code' => '2411908',
            ],

            203 => [
                'state_id'  => '20',
                'name'      => 'São Gonçalo do Amarante',
                'ibge_code' => '2412005',
            ],

            204 => [
                'state_id'  => '20',
                'name'      => 'São João do Sabugi',
                'ibge_code' => '2412104',
            ],

            205 => [
                'state_id'  => '20',
                'name'      => 'São José de Mipibu',
                'ibge_code' => '2412203',
            ],

            206 => [
                'state_id'  => '20',
                'name'      => 'São José do Campestre',
                'ibge_code' => '2412302',
            ],

            207 => [
                'state_id'  => '20',
                'name'      => 'São José do Seridó',
                'ibge_code' => '2412401',
            ],

            208 => [
                'state_id'  => '20',
                'name'      => 'São Miguel',
                'ibge_code' => '2412500',
            ],

            209 => [
                'state_id'  => '20',
                'name'      => 'São Miguel do Gostoso',
                'ibge_code' => '2412559',
            ],

            210 => [
                'state_id'  => '20',
                'name'      => 'São Paulo do Potengi',
                'ibge_code' => '2412609',
            ],

            211 => [
                'state_id'  => '20',
                'name'      => 'São Pedro',
                'ibge_code' => '2412708',
            ],

            212 => [
                'state_id'  => '20',
                'name'      => 'São Rafael',
                'ibge_code' => '2412807',
            ],

            213 => [
                'state_id'  => '20',
                'name'      => 'São Tomé',
                'ibge_code' => '2412906',
            ],

            214 => [
                'state_id'  => '20',
                'name'      => 'São Vicente',
                'ibge_code' => '2413003',
            ],

            215 => [
                'state_id'  => '20',
                'name'      => 'Senador Elói de Souza',
                'ibge_code' => '2413102',
            ],

            216 => [
                'state_id'  => '20',
                'name'      => 'Senador Georgino Avelino',
                'ibge_code' => '2413201',
            ],

            217 => [
                'state_id'  => '20',
                'name'      => 'Serra de São Bento',
                'ibge_code' => '2413300',
            ],

            218 => [
                'state_id'  => '20',
                'name'      => 'Serra do Mel',
                'ibge_code' => '2413359',
            ],

            219 => [
                'state_id'  => '20',
                'name'      => 'Serra Negra do Norte',
                'ibge_code' => '2413409',
            ],

            220 => [
                'state_id'  => '20',
                'name'      => 'Serrinha',
                'ibge_code' => '2413508',
            ],

            221 => [
                'state_id'  => '20',
                'name'      => 'Serrinha dos Pintos',
                'ibge_code' => '2413557',
            ],

            222 => [
                'state_id'  => '20',
                'name'      => 'Severiano Melo',
                'ibge_code' => '2413607',
            ],

            223 => [
                'state_id'  => '20',
                'name'      => 'Sítio Novo',
                'ibge_code' => '2413706',
            ],

            224 => [
                'state_id'  => '20',
                'name'      => 'Taboleiro Grande',
                'ibge_code' => '2413805',
            ],

            225 => [
                'state_id'  => '20',
                'name'      => 'Taipu',
                'ibge_code' => '2413904',
            ],

            226 => [
                'state_id'  => '20',
                'name'      => 'Tangará',
                'ibge_code' => '2414001',
            ],

            227 => [
                'state_id'  => '20',
                'name'      => 'Tenente Ananias',
                'ibge_code' => '2414100',
            ],

            228 => [
                'state_id'  => '20',
                'name'      => 'Tenente Laurentino Cruz',
                'ibge_code' => '2414159',
            ],

            229 => [
                'state_id'  => '20',
                'name'      => 'Tibau do Sul',
                'ibge_code' => '2414209',
            ],

            230 => [
                'state_id'  => '20',
                'name'      => 'Timbaúba dos Batistas',
                'ibge_code' => '2414308',
            ],

            231 => [
                'state_id'  => '20',
                'name'      => 'Touros',
                'ibge_code' => '2414407',
            ],

            232 => [
                'state_id'  => '20',
                'name'      => 'Triunfo Potiguar',
                'ibge_code' => '2414456',
            ],

            233 => [
                'state_id'  => '20',
                'name'      => 'Umarizal',
                'ibge_code' => '2414506',
            ],

            234 => [
                'state_id'  => '20',
                'name'      => 'Upanema',
                'ibge_code' => '2414605',
            ],

            235 => [
                'state_id'  => '20',
                'name'      => 'Várzea',
                'ibge_code' => '2414704',
            ],

            236 => [
                'state_id'  => '20',
                'name'      => 'Venha-Ver',
                'ibge_code' => '2414753',
            ],

            237 => [
                'state_id'  => '20',
                'name'      => 'Vera Cruz',
                'ibge_code' => '2414803',
            ],

            238 => [
                'state_id'  => '20',
                'name'      => 'Viçosa',
                'ibge_code' => '2414902',
            ],

            239 => [
                'state_id'  => '20',
                'name'      => 'Vila Flor',
                'ibge_code' => '2415008',
            ],

            240 => [
                'state_id'  => '15',
                'name'      => 'Água Branca',
                'ibge_code' => '2500106',
            ],

            241 => [
                'state_id'  => '15',
                'name'      => 'Aguiar',
                'ibge_code' => '2500205',
            ],

            242 => [
                'state_id'  => '15',
                'name'      => 'Alagoa Grande',
                'ibge_code' => '2500304',
            ],

            243 => [
                'state_id'  => '15',
                'name'      => 'Alagoa Nova',
                'ibge_code' => '2500403',
            ],

            244 => [
                'state_id'  => '15',
                'name'      => 'Alagoinha',
                'ibge_code' => '2500502',
            ],

            245 => [
                'state_id'  => '15',
                'name'      => 'Alcantil',
                'ibge_code' => '2500536',
            ],

            246 => [
                'state_id'  => '15',
                'name'      => 'Algodão de Jandaíra',
                'ibge_code' => '2500577',
            ],

            247 => [
                'state_id'  => '15',
                'name'      => 'Alhandra',
                'ibge_code' => '2500601',
            ],

            248 => [
                'state_id'  => '15',
                'name'      => 'São João do Rio do Peixe',
                'ibge_code' => '2500700',
            ],

            249 => [
                'state_id'  => '15',
                'name'      => 'Amparo',
                'ibge_code' => '2500734',
            ],

            250 => [
                'state_id'  => '15',
                'name'      => 'Aparecida',
                'ibge_code' => '2500775',
            ],

            251 => [
                'state_id'  => '15',
                'name'      => 'Araçagi',
                'ibge_code' => '2500809',
            ],

            252 => [
                'state_id'  => '15',
                'name'      => 'Arara',
                'ibge_code' => '2500908',
            ],

            253 => [
                'state_id'  => '15',
                'name'      => 'Araruna',
                'ibge_code' => '2501005',
            ],

            254 => [
                'state_id'  => '15',
                'name'      => 'Areia',
                'ibge_code' => '2501104',
            ],

            255 => [
                'state_id'  => '15',
                'name'      => 'Areia de Baraúnas',
                'ibge_code' => '2501153',
            ],

            256 => [
                'state_id'  => '15',
                'name'      => 'Areial',
                'ibge_code' => '2501203',
            ],

            257 => [
                'state_id'  => '15',
                'name'      => 'Aroeiras',
                'ibge_code' => '2501302',
            ],

            258 => [
                'state_id'  => '15',
                'name'      => 'Assunção',
                'ibge_code' => '2501351',
            ],

            259 => [
                'state_id'  => '15',
                'name'      => 'Baía da Traição',
                'ibge_code' => '2501401',
            ],

            260 => [
                'state_id'  => '15',
                'name'      => 'Bananeiras',
                'ibge_code' => '2501500',
            ],

            261 => [
                'state_id'  => '15',
                'name'      => 'Baraúna',
                'ibge_code' => '2501534',
            ],

            262 => [
                'state_id'  => '15',
                'name'      => 'Barra de Santana',
                'ibge_code' => '2501575',
            ],

            263 => [
                'state_id'  => '15',
                'name'      => 'Barra de Santa Rosa',
                'ibge_code' => '2501609',
            ],

            264 => [
                'state_id'  => '15',
                'name'      => 'Barra de São Miguel',
                'ibge_code' => '2501708',
            ],

            265 => [
                'state_id'  => '15',
                'name'      => 'Bayeux',
                'ibge_code' => '2501807',
            ],

            266 => [
                'state_id'  => '15',
                'name'      => 'Belém',
                'ibge_code' => '2501906',
            ],

            267 => [
                'state_id'  => '15',
                'name'      => 'Belém do Brejo do Cruz',
                'ibge_code' => '2502003',
            ],

            268 => [
                'state_id'  => '15',
                'name'      => 'Bernardino Batista',
                'ibge_code' => '2502052',
            ],

            269 => [
                'state_id'  => '15',
                'name'      => 'Boa Ventura',
                'ibge_code' => '2502102',
            ],

            270 => [
                'state_id'  => '15',
                'name'      => 'Boa Vista',
                'ibge_code' => '2502151',
            ],

            271 => [
                'state_id'  => '15',
                'name'      => 'Bom Jesus',
                'ibge_code' => '2502201',
            ],

            272 => [
                'state_id'  => '15',
                'name'      => 'Bom Sucesso',
                'ibge_code' => '2502300',
            ],

            273 => [
                'state_id'  => '15',
                'name'      => 'Bonito de Santa Fé',
                'ibge_code' => '2502409',
            ],

            274 => [
                'state_id'  => '15',
                'name'      => 'Boqueirão',
                'ibge_code' => '2502508',
            ],

            275 => [
                'state_id'  => '15',
                'name'      => 'Igaracy',
                'ibge_code' => '2502607',
            ],

            276 => [
                'state_id'  => '15',
                'name'      => 'Borborema',
                'ibge_code' => '2502706',
            ],

            277 => [
                'state_id'  => '15',
                'name'      => 'Brejo do Cruz',
                'ibge_code' => '2502805',
            ],

            278 => [
                'state_id'  => '15',
                'name'      => 'Brejo dos Santos',
                'ibge_code' => '2502904',
            ],

            279 => [
                'state_id'  => '15',
                'name'      => 'Caaporã',
                'ibge_code' => '2503001',
            ],

            280 => [
                'state_id'  => '15',
                'name'      => 'Cabaceiras',
                'ibge_code' => '2503100',
            ],

            281 => [
                'state_id'  => '15',
                'name'      => 'Cabedelo',
                'ibge_code' => '2503209',
            ],

            282 => [
                'state_id'  => '15',
                'name'      => 'Cachoeira dos Índios',
                'ibge_code' => '2503308',
            ],

            283 => [
                'state_id'  => '15',
                'name'      => 'Cacimba de Areia',
                'ibge_code' => '2503407',
            ],

            284 => [
                'state_id'  => '15',
                'name'      => 'Cacimba de Dentro',
                'ibge_code' => '2503506',
            ],

            285 => [
                'state_id'  => '15',
                'name'      => 'Cacimbas',
                'ibge_code' => '2503555',
            ],

            286 => [
                'state_id'  => '15',
                'name'      => 'Caiçara',
                'ibge_code' => '2503605',
            ],

            287 => [
                'state_id'  => '15',
                'name'      => 'Cajazeiras',
                'ibge_code' => '2503704',
            ],

            288 => [
                'state_id'  => '15',
                'name'      => 'Cajazeirinhas',
                'ibge_code' => '2503753',
            ],

            289 => [
                'state_id'  => '15',
                'name'      => 'Caldas Brandão',
                'ibge_code' => '2503803',
            ],

            290 => [
                'state_id'  => '15',
                'name'      => 'Camalaú',
                'ibge_code' => '2503902',
            ],

            291 => [
                'state_id'  => '15',
                'name'      => 'Campina Grande',
                'ibge_code' => '2504009',
            ],

            292 => [
                'state_id'  => '15',
                'name'      => 'Capim',
                'ibge_code' => '2504033',
            ],

            293 => [
                'state_id'  => '15',
                'name'      => 'Caraúbas',
                'ibge_code' => '2504074',
            ],

            294 => [
                'state_id'  => '15',
                'name'      => 'Carrapateira',
                'ibge_code' => '2504108',
            ],

            295 => [
                'state_id'  => '15',
                'name'      => 'Casserengue',
                'ibge_code' => '2504157',
            ],

            296 => [
                'state_id'  => '15',
                'name'      => 'Catingueira',
                'ibge_code' => '2504207',
            ],

            297 => [
                'state_id'  => '15',
                'name'      => 'Catolé do Rocha',
                'ibge_code' => '2504306',
            ],

            298 => [
                'state_id'  => '15',
                'name'      => 'Caturité',
                'ibge_code' => '2504355',
            ],

            299 => [
                'state_id'  => '15',
                'name'      => 'Conceição',
                'ibge_code' => '2504405',
            ],

            300 => [
                'state_id'  => '15',
                'name'      => 'Condado',
                'ibge_code' => '2504504',
            ],

            301 => [
                'state_id'  => '15',
                'name'      => 'Conde',
                'ibge_code' => '2504603',
            ],

            302 => [
                'state_id'  => '15',
                'name'      => 'Congo',
                'ibge_code' => '2504702',
            ],

            303 => [
                'state_id'  => '15',
                'name'      => 'Coremas',
                'ibge_code' => '2504801',
            ],

            304 => [
                'state_id'  => '15',
                'name'      => 'Coxixola',
                'ibge_code' => '2504850',
            ],

            305 => [
                'state_id'  => '15',
                'name'      => 'Cruz do Espírito Santo',
                'ibge_code' => '2504900',
            ],

            306 => [
                'state_id'  => '15',
                'name'      => 'Cubati',
                'ibge_code' => '2505006',
            ],

            307 => [
                'state_id'  => '15',
                'name'      => 'Cuité',
                'ibge_code' => '2505105',
            ],

            308 => [
                'state_id'  => '15',
                'name'      => 'Cuitegi',
                'ibge_code' => '2505204',
            ],

            309 => [
                'state_id'  => '15',
                'name'      => 'Cuité de Mamanguape',
                'ibge_code' => '2505238',
            ],

            310 => [
                'state_id'  => '15',
                'name'      => 'Curral de Cima',
                'ibge_code' => '2505279',
            ],

            311 => [
                'state_id'  => '15',
                'name'      => 'Curral Velho',
                'ibge_code' => '2505303',
            ],

            312 => [
                'state_id'  => '15',
                'name'      => 'Damião',
                'ibge_code' => '2505352',
            ],

            313 => [
                'state_id'  => '15',
                'name'      => 'Desterro',
                'ibge_code' => '2505402',
            ],

            314 => [
                'state_id'  => '15',
                'name'      => 'Vista Serrana',
                'ibge_code' => '2505501',
            ],

            315 => [
                'state_id'  => '15',
                'name'      => 'Diamante',
                'ibge_code' => '2505600',
            ],

            316 => [
                'state_id'  => '15',
                'name'      => 'Dona Inês',
                'ibge_code' => '2505709',
            ],

            317 => [
                'state_id'  => '15',
                'name'      => 'Duas Estradas',
                'ibge_code' => '2505808',
            ],

            318 => [
                'state_id'  => '15',
                'name'      => 'Emas',
                'ibge_code' => '2505907',
            ],

            319 => [
                'state_id'  => '15',
                'name'      => 'Esperança',
                'ibge_code' => '2506004',
            ],

            320 => [
                'state_id'  => '15',
                'name'      => 'Fagundes',
                'ibge_code' => '2506103',
            ],

            321 => [
                'state_id'  => '15',
                'name'      => 'Frei Martinho',
                'ibge_code' => '2506202',
            ],

            322 => [
                'state_id'  => '15',
                'name'      => 'Gado Bravo',
                'ibge_code' => '2506251',
            ],

            323 => [
                'state_id'  => '15',
                'name'      => 'Guarabira',
                'ibge_code' => '2506301',
            ],

            324 => [
                'state_id'  => '15',
                'name'      => 'Gurinhém',
                'ibge_code' => '2506400',
            ],

            325 => [
                'state_id'  => '15',
                'name'      => 'Gurjão',
                'ibge_code' => '2506509',
            ],

            326 => [
                'state_id'  => '15',
                'name'      => 'Ibiara',
                'ibge_code' => '2506608',
            ],

            327 => [
                'state_id'  => '15',
                'name'      => 'Imaculada',
                'ibge_code' => '2506707',
            ],

            328 => [
                'state_id'  => '15',
                'name'      => 'Ingá',
                'ibge_code' => '2506806',
            ],

            329 => [
                'state_id'  => '15',
                'name'      => 'Itabaiana',
                'ibge_code' => '2506905',
            ],

            330 => [
                'state_id'  => '15',
                'name'      => 'Itaporanga',
                'ibge_code' => '2507002',
            ],

            331 => [
                'state_id'  => '15',
                'name'      => 'Itapororoca',
                'ibge_code' => '2507101',
            ],

            332 => [
                'state_id'  => '15',
                'name'      => 'Itatuba',
                'ibge_code' => '2507200',
            ],

            333 => [
                'state_id'  => '15',
                'name'      => 'Jacaraú',
                'ibge_code' => '2507309',
            ],

            334 => [
                'state_id'  => '15',
                'name'      => 'Jericó',
                'ibge_code' => '2507408',
            ],

            335 => [
                'state_id'  => '15',
                'name'      => 'João Pessoa',
                'ibge_code' => '2507507',
            ],

            336 => [
                'state_id'  => '15',
                'name'      => 'Juarez Távora',
                'ibge_code' => '2507606',
            ],

            337 => [
                'state_id'  => '15',
                'name'      => 'Juazeirinho',
                'ibge_code' => '2507705',
            ],

            338 => [
                'state_id'  => '15',
                'name'      => 'Junco do Seridó',
                'ibge_code' => '2507804',
            ],

            339 => [
                'state_id'  => '15',
                'name'      => 'Juripiranga',
                'ibge_code' => '2507903',
            ],

            340 => [
                'state_id'  => '15',
                'name'      => 'Juru',
                'ibge_code' => '2508000',
            ],

            341 => [
                'state_id'  => '15',
                'name'      => 'Lagoa',
                'ibge_code' => '2508109',
            ],

            342 => [
                'state_id'  => '15',
                'name'      => 'Lagoa de Dentro',
                'ibge_code' => '2508208',
            ],

            343 => [
                'state_id'  => '15',
                'name'      => 'Lagoa Seca',
                'ibge_code' => '2508307',
            ],

            344 => [
                'state_id'  => '15',
                'name'      => 'Lastro',
                'ibge_code' => '2508406',
            ],

            345 => [
                'state_id'  => '15',
                'name'      => 'Livramento',
                'ibge_code' => '2508505',
            ],

            346 => [
                'state_id'  => '15',
                'name'      => 'Logradouro',
                'ibge_code' => '2508554',
            ],

            347 => [
                'state_id'  => '15',
                'name'      => 'Lucena',
                'ibge_code' => '2508604',
            ],

            348 => [
                'state_id'  => '15',
                'name'      => "Mãe D'água",
                'ibge_code' => '2508703',
            ],

            349 => [
                'state_id'  => '15',
                'name'      => 'Malta',
                'ibge_code' => '2508802',
            ],

            350 => [
                'state_id'  => '15',
                'name'      => 'Mamanguape',
                'ibge_code' => '2508901',
            ],

            351 => [
                'state_id'  => '15',
                'name'      => 'Manaíra',
                'ibge_code' => '2509008',
            ],

            352 => [
                'state_id'  => '15',
                'name'      => 'Marcação',
                'ibge_code' => '2509057',
            ],

            353 => [
                'state_id'  => '15',
                'name'      => 'Mari',
                'ibge_code' => '2509107',
            ],

            354 => [
                'state_id'  => '15',
                'name'      => 'Marizópolis',
                'ibge_code' => '2509156',
            ],

            355 => [
                'state_id'  => '15',
                'name'      => 'Massaranduba',
                'ibge_code' => '2509206',
            ],

            356 => [
                'state_id'  => '15',
                'name'      => 'Mataraca',
                'ibge_code' => '2509305',
            ],

            357 => [
                'state_id'  => '15',
                'name'      => 'Matinhas',
                'ibge_code' => '2509339',
            ],

            358 => [
                'state_id'  => '15',
                'name'      => 'Mato Grosso',
                'ibge_code' => '2509370',
            ],

            359 => [
                'state_id'  => '15',
                'name'      => 'Maturéia',
                'ibge_code' => '2509396',
            ],

            360 => [
                'state_id'  => '15',
                'name'      => 'Mogeiro',
                'ibge_code' => '2509404',
            ],

            361 => [
                'state_id'  => '15',
                'name'      => 'Montadas',
                'ibge_code' => '2509503',
            ],

            362 => [
                'state_id'  => '15',
                'name'      => 'Monte Horebe',
                'ibge_code' => '2509602',
            ],

            363 => [
                'state_id'  => '15',
                'name'      => 'Monteiro',
                'ibge_code' => '2509701',
            ],

            364 => [
                'state_id'  => '15',
                'name'      => 'Mulungu',
                'ibge_code' => '2509800',
            ],

            365 => [
                'state_id'  => '15',
                'name'      => 'Natuba',
                'ibge_code' => '2509909',
            ],

            366 => [
                'state_id'  => '15',
                'name'      => 'Nazarezinho',
                'ibge_code' => '2510006',
            ],

            367 => [
                'state_id'  => '15',
                'name'      => 'Nova Floresta',
                'ibge_code' => '2510105',
            ],

            368 => [
                'state_id'  => '15',
                'name'      => 'Nova Olinda',
                'ibge_code' => '2510204',
            ],

            369 => [
                'state_id'  => '15',
                'name'      => 'Nova Palmeira',
                'ibge_code' => '2510303',
            ],

            370 => [
                'state_id'  => '15',
                'name'      => "Olho D'água",
                'ibge_code' => '2510402',
            ],

            371 => [
                'state_id'  => '15',
                'name'      => 'Olivedos',
                'ibge_code' => '2510501',
            ],

            372 => [
                'state_id'  => '15',
                'name'      => 'Ouro Velho',
                'ibge_code' => '2510600',
            ],

            373 => [
                'state_id'  => '15',
                'name'      => 'Parari',
                'ibge_code' => '2510659',
            ],

            374 => [
                'state_id'  => '15',
                'name'      => 'Passagem',
                'ibge_code' => '2510709',
            ],

            375 => [
                'state_id'  => '15',
                'name'      => 'Patos',
                'ibge_code' => '2510808',
            ],

            376 => [
                'state_id'  => '15',
                'name'      => 'Paulista',
                'ibge_code' => '2510907',
            ],

            377 => [
                'state_id'  => '15',
                'name'      => 'Pedra Branca',
                'ibge_code' => '2511004',
            ],

            378 => [
                'state_id'  => '15',
                'name'      => 'Pedra Lavrada',
                'ibge_code' => '2511103',
            ],

            379 => [
                'state_id'  => '15',
                'name'      => 'Pedras de Fogo',
                'ibge_code' => '2511202',
            ],

            380 => [
                'state_id'  => '15',
                'name'      => 'Piancó',
                'ibge_code' => '2511301',
            ],

            381 => [
                'state_id'  => '15',
                'name'      => 'Picuí',
                'ibge_code' => '2511400',
            ],

            382 => [
                'state_id'  => '15',
                'name'      => 'Pilar',
                'ibge_code' => '2511509',
            ],

            383 => [
                'state_id'  => '15',
                'name'      => 'Pilões',
                'ibge_code' => '2511608',
            ],

            384 => [
                'state_id'  => '15',
                'name'      => 'Pilõezinhos',
                'ibge_code' => '2511707',
            ],

            385 => [
                'state_id'  => '15',
                'name'      => 'Pirpirituba',
                'ibge_code' => '2511806',
            ],

            386 => [
                'state_id'  => '15',
                'name'      => 'Pitimbu',
                'ibge_code' => '2511905',
            ],

            387 => [
                'state_id'  => '15',
                'name'      => 'Pocinhos',
                'ibge_code' => '2512002',
            ],

            388 => [
                'state_id'  => '15',
                'name'      => 'Poço Dantas',
                'ibge_code' => '2512036',
            ],

            389 => [
                'state_id'  => '15',
                'name'      => 'Poço de José de Moura',
                'ibge_code' => '2512077',
            ],

            390 => [
                'state_id'  => '15',
                'name'      => 'Pombal',
                'ibge_code' => '2512101',
            ],

            391 => [
                'state_id'  => '15',
                'name'      => 'Prata',
                'ibge_code' => '2512200',
            ],

            392 => [
                'state_id'  => '15',
                'name'      => 'Princesa Isabel',
                'ibge_code' => '2512309',
            ],

            393 => [
                'state_id'  => '15',
                'name'      => 'Puxinanã',
                'ibge_code' => '2512408',
            ],

            394 => [
                'state_id'  => '15',
                'name'      => 'Queimadas',
                'ibge_code' => '2512507',
            ],

            395 => [
                'state_id'  => '15',
                'name'      => 'Quixabá',
                'ibge_code' => '2512606',
            ],

            396 => [
                'state_id'  => '15',
                'name'      => 'Remígio',
                'ibge_code' => '2512705',
            ],

            397 => [
                'state_id'  => '15',
                'name'      => 'Pedro Régis',
                'ibge_code' => '2512721',
            ],

            398 => [
                'state_id'  => '15',
                'name'      => 'Riachão',
                'ibge_code' => '2512747',
            ],

            399 => [
                'state_id'  => '15',
                'name'      => 'Riachão do Bacamarte',
                'ibge_code' => '2512754',
            ],

            400 => [
                'state_id'  => '15',
                'name'      => 'Riachão do Poço',
                'ibge_code' => '2512762',
            ],

            401 => [
                'state_id'  => '15',
                'name'      => 'Riacho de Santo Antônio',
                'ibge_code' => '2512788',
            ],

            402 => [
                'state_id'  => '15',
                'name'      => 'Riacho dos Cavalos',
                'ibge_code' => '2512804',
            ],

            403 => [
                'state_id'  => '15',
                'name'      => 'Rio Tinto',
                'ibge_code' => '2512903',
            ],

            404 => [
                'state_id'  => '15',
                'name'      => 'Salgadinho',
                'ibge_code' => '2513000',
            ],

            405 => [
                'state_id'  => '15',
                'name'      => 'Salgado de São Félix',
                'ibge_code' => '2513109',
            ],

            406 => [
                'state_id'  => '15',
                'name'      => 'Santa Cecília',
                'ibge_code' => '2513158',
            ],

            407 => [
                'state_id'  => '15',
                'name'      => 'Santa Cruz',
                'ibge_code' => '2513208',
            ],

            408 => [
                'state_id'  => '15',
                'name'      => 'Santa Helena',
                'ibge_code' => '2513307',
            ],

            409 => [
                'state_id'  => '15',
                'name'      => 'Santa Inês',
                'ibge_code' => '2513356',
            ],

            410 => [
                'state_id'  => '15',
                'name'      => 'Santa Luzia',
                'ibge_code' => '2513406',
            ],

            411 => [
                'state_id'  => '15',
                'name'      => 'Santana de Mangueira',
                'ibge_code' => '2513505',
            ],

            412 => [
                'state_id'  => '15',
                'name'      => 'Santana dos Garrotes',
                'ibge_code' => '2513604',
            ],

            413 => [
                'state_id'  => '15',
                'name'      => 'Santarém',
                'ibge_code' => '2513653',
            ],

            414 => [
                'state_id'  => '15',
                'name'      => 'Santa Rita',
                'ibge_code' => '2513703',
            ],

            415 => [
                'state_id'  => '15',
                'name'      => 'Santa Teresinha',
                'ibge_code' => '2513802',
            ],

            416 => [
                'state_id'  => '15',
                'name'      => 'Santo André',
                'ibge_code' => '2513851',
            ],

            417 => [
                'state_id'  => '15',
                'name'      => 'São Bento',
                'ibge_code' => '2513901',
            ],

            418 => [
                'state_id'  => '15',
                'name'      => 'São Bentinho',
                'ibge_code' => '2513927',
            ],

            419 => [
                'state_id'  => '15',
                'name'      => 'São Domingos do Cariri',
                'ibge_code' => '2513943',
            ],

            420 => [
                'state_id'  => '15',
                'name'      => 'São Domingos de Pombal',
                'ibge_code' => '2513968',
            ],

            421 => [
                'state_id'  => '15',
                'name'      => 'São Francisco',
                'ibge_code' => '2513984',
            ],

            422 => [
                'state_id'  => '15',
                'name'      => 'São João do Cariri',
                'ibge_code' => '2514008',
            ],

            423 => [
                'state_id'  => '15',
                'name'      => 'São João do Tigre',
                'ibge_code' => '2514107',
            ],

            424 => [
                'state_id'  => '15',
                'name'      => 'São José da Lagoa Tapada',
                'ibge_code' => '2514206',
            ],

            425 => [
                'state_id'  => '15',
                'name'      => 'São José de Caiana',
                'ibge_code' => '2514305',
            ],

            426 => [
                'state_id'  => '15',
                'name'      => 'São José de Espinharas',
                'ibge_code' => '2514404',
            ],

            427 => [
                'state_id'  => '15',
                'name'      => 'São José dos Ramos',
                'ibge_code' => '2514453',
            ],

            428 => [
                'state_id'  => '15',
                'name'      => 'São José de Piranhas',
                'ibge_code' => '2514503',
            ],

            429 => [
                'state_id'  => '15',
                'name'      => 'São José de Princesa',
                'ibge_code' => '2514552',
            ],

            430 => [
                'state_id'  => '15',
                'name'      => 'São José do Bonfim',
                'ibge_code' => '2514602',
            ],

            431 => [
                'state_id'  => '15',
                'name'      => 'São José do Brejo do Cruz',
                'ibge_code' => '2514651',
            ],

            432 => [
                'state_id'  => '15',
                'name'      => 'São José do Sabugi',
                'ibge_code' => '2514701',
            ],

            433 => [
                'state_id'  => '15',
                'name'      => 'São José dos Cordeiros',
                'ibge_code' => '2514800',
            ],

            434 => [
                'state_id'  => '15',
                'name'      => 'São Mamede',
                'ibge_code' => '2514909',
            ],

            435 => [
                'state_id'  => '15',
                'name'      => 'São Miguel de Taipu',
                'ibge_code' => '2515005',
            ],

            436 => [
                'state_id'  => '15',
                'name'      => 'São Sebastião de Lagoa de Roça',
                'ibge_code' => '2515104',
            ],

            437 => [
                'state_id'  => '15',
                'name'      => 'São Sebastião do Umbuzeiro',
                'ibge_code' => '2515203',
            ],

            438 => [
                'state_id'  => '15',
                'name'      => 'Sapé',
                'ibge_code' => '2515302',
            ],

            439 => [
                'state_id'  => '15',
                'name'      => 'Seridó',
                'ibge_code' => '2515401',
            ],

            440 => [
                'state_id'  => '15',
                'name'      => 'Serra Branca',
                'ibge_code' => '2515500',
            ],

            441 => [
                'state_id'  => '15',
                'name'      => 'Serra da Raiz',
                'ibge_code' => '2515609',
            ],

            442 => [
                'state_id'  => '15',
                'name'      => 'Serra Grande',
                'ibge_code' => '2515708',
            ],

            443 => [
                'state_id'  => '15',
                'name'      => 'Serra Redonda',
                'ibge_code' => '2515807',
            ],

            444 => [
                'state_id'  => '15',
                'name'      => 'Serraria',
                'ibge_code' => '2515906',
            ],

            445 => [
                'state_id'  => '15',
                'name'      => 'Sertãozinho',
                'ibge_code' => '2515930',
            ],

            446 => [
                'state_id'  => '15',
                'name'      => 'Sobrado',
                'ibge_code' => '2515971',
            ],

            447 => [
                'state_id'  => '15',
                'name'      => 'Solânea',
                'ibge_code' => '2516003',
            ],

            448 => [
                'state_id'  => '15',
                'name'      => 'Soledade',
                'ibge_code' => '2516102',
            ],

            449 => [
                'state_id'  => '15',
                'name'      => 'Sossêgo',
                'ibge_code' => '2516151',
            ],

            450 => [
                'state_id'  => '15',
                'name'      => 'Sousa',
                'ibge_code' => '2516201',
            ],

            451 => [
                'state_id'  => '15',
                'name'      => 'Sumé',
                'ibge_code' => '2516300',
            ],

            452 => [
                'state_id'  => '15',
                'name'      => 'Campo de Santana',
                'ibge_code' => '2516409',
            ],

            453 => [
                'state_id'  => '15',
                'name'      => 'Taperoá',
                'ibge_code' => '2516508',
            ],

            454 => [
                'state_id'  => '15',
                'name'      => 'Tavares',
                'ibge_code' => '2516607',
            ],

            455 => [
                'state_id'  => '15',
                'name'      => 'Teixeira',
                'ibge_code' => '2516706',
            ],

            456 => [
                'state_id'  => '15',
                'name'      => 'Tenório',
                'ibge_code' => '2516755',
            ],

            457 => [
                'state_id'  => '15',
                'name'      => 'Triunfo',
                'ibge_code' => '2516805',
            ],

            458 => [
                'state_id'  => '15',
                'name'      => 'Uiraúna',
                'ibge_code' => '2516904',
            ],

            459 => [
                'state_id'  => '15',
                'name'      => 'Umbuzeiro',
                'ibge_code' => '2517001',
            ],

            460 => [
                'state_id'  => '15',
                'name'      => 'Várzea',
                'ibge_code' => '2517100',
            ],

            461 => [
                'state_id'  => '15',
                'name'      => 'Vieirópolis',
                'ibge_code' => '2517209',
            ],

            462 => [
                'state_id'  => '15',
                'name'      => 'Zabelê',
                'ibge_code' => '2517407',
            ],

            463 => [
                'state_id'  => '16',
                'name'      => 'Abreu e Lima',
                'ibge_code' => '2600054',
            ],

            464 => [
                'state_id'  => '16',
                'name'      => 'Afogados da Ingazeira',
                'ibge_code' => '2600104',
            ],

            465 => [
                'state_id'  => '16',
                'name'      => 'Afrânio',
                'ibge_code' => '2600203',
            ],

            466 => [
                'state_id'  => '16',
                'name'      => 'Agrestina',
                'ibge_code' => '2600302',
            ],

            467 => [
                'state_id'  => '16',
                'name'      => 'Água Preta',
                'ibge_code' => '2600401',
            ],

            468 => [
                'state_id'  => '16',
                'name'      => 'Águas Belas',
                'ibge_code' => '2600500',
            ],

            469 => [
                'state_id'  => '16',
                'name'      => 'Alagoinha',
                'ibge_code' => '2600609',
            ],

            470 => [
                'state_id'  => '16',
                'name'      => 'Aliança',
                'ibge_code' => '2600708',
            ],

            471 => [
                'state_id'  => '16',
                'name'      => 'Altinho',
                'ibge_code' => '2600807',
            ],

            472 => [
                'state_id'  => '16',
                'name'      => 'Amaraji',
                'ibge_code' => '2600906',
            ],

            473 => [
                'state_id'  => '16',
                'name'      => 'Angelim',
                'ibge_code' => '2601003',
            ],

            474 => [
                'state_id'  => '16',
                'name'      => 'Araçoiaba',
                'ibge_code' => '2601052',
            ],

            475 => [
                'state_id'  => '16',
                'name'      => 'Araripina',
                'ibge_code' => '2601102',
            ],

            476 => [
                'state_id'  => '16',
                'name'      => 'Arcoverde',
                'ibge_code' => '2601201',
            ],

            477 => [
                'state_id'  => '16',
                'name'      => 'Barra de Guabiraba',
                'ibge_code' => '2601300',
            ],

            478 => [
                'state_id'  => '16',
                'name'      => 'Barreiros',
                'ibge_code' => '2601409',
            ],

            479 => [
                'state_id'  => '16',
                'name'      => 'Belém de Maria',
                'ibge_code' => '2601508',
            ],

            480 => [
                'state_id'  => '16',
                'name'      => 'Belém de São Francisco',
                'ibge_code' => '2601607',
            ],

            481 => [
                'state_id'  => '16',
                'name'      => 'Belo Jardim',
                'ibge_code' => '2601706',
            ],

            482 => [
                'state_id'  => '16',
                'name'      => 'Betânia',
                'ibge_code' => '2601805',
            ],

            483 => [
                'state_id'  => '16',
                'name'      => 'Bezerros',
                'ibge_code' => '2601904',
            ],

            484 => [
                'state_id'  => '16',
                'name'      => 'Bodocó',
                'ibge_code' => '2602001',
            ],

            485 => [
                'state_id'  => '16',
                'name'      => 'Bom Conselho',
                'ibge_code' => '2602100',
            ],

            486 => [
                'state_id'  => '16',
                'name'      => 'Bom Jardim',
                'ibge_code' => '2602209',
            ],

            487 => [
                'state_id'  => '16',
                'name'      => 'Bonito',
                'ibge_code' => '2602308',
            ],

            488 => [
                'state_id'  => '16',
                'name'      => 'Brejão',
                'ibge_code' => '2602407',
            ],

            489 => [
                'state_id'  => '16',
                'name'      => 'Brejinho',
                'ibge_code' => '2602506',
            ],

            490 => [
                'state_id'  => '16',
                'name'      => 'Brejo da Madre de Deus',
                'ibge_code' => '2602605',
            ],

            491 => [
                'state_id'  => '16',
                'name'      => 'Buenos Aires',
                'ibge_code' => '2602704',
            ],

            492 => [
                'state_id'  => '16',
                'name'      => 'Buíque',
                'ibge_code' => '2602803',
            ],

            493 => [
                'state_id'  => '16',
                'name'      => 'Cabo de Santo Agostinho',
                'ibge_code' => '2602902',
            ],

            494 => [
                'state_id'  => '16',
                'name'      => 'Cabrobó',
                'ibge_code' => '2603009',
            ],

            495 => [
                'state_id'  => '16',
                'name'      => 'Cachoeirinha',
                'ibge_code' => '2603108',
            ],

            496 => [
                'state_id'  => '16',
                'name'      => 'Caetés',
                'ibge_code' => '2603207',
            ],

            497 => [
                'state_id'  => '16',
                'name'      => 'Calçado',
                'ibge_code' => '2603306',
            ],

            498 => [
                'state_id'  => '16',
                'name'      => 'Calumbi',
                'ibge_code' => '2603405',
            ],

            499 => [
                'state_id'  => '16',
                'name'      => 'Camaragibe',
                'ibge_code' => '2603454',
            ],

        ]);
        DB::table('cities')->insert([
            0 => [
                'state_id'  => '16',
                'name'      => 'Camocim de São Félix',
                'ibge_code' => '2603504',
            ],

            1 => [
                'state_id'  => '16',
                'name'      => 'Camutanga',
                'ibge_code' => '2603603',
            ],

            2 => [
                'state_id'  => '16',
                'name'      => 'Canhotinho',
                'ibge_code' => '2603702',
            ],

            3 => [
                'state_id'  => '16',
                'name'      => 'Capoeiras',
                'ibge_code' => '2603801',
            ],

            4 => [
                'state_id'  => '16',
                'name'      => 'Carnaíba',
                'ibge_code' => '2603900',
            ],

            5 => [
                'state_id'  => '16',
                'name'      => 'Carnaubeira da Penha',
                'ibge_code' => '2603926',
            ],

            6 => [
                'state_id'  => '16',
                'name'      => 'Carpina',
                'ibge_code' => '2604007',
            ],

            7 => [
                'state_id'  => '16',
                'name'      => 'Caruaru',
                'ibge_code' => '2604106',
            ],

            8 => [
                'state_id'  => '16',
                'name'      => 'Casinhas',
                'ibge_code' => '2604155',
            ],

            9 => [
                'state_id'  => '16',
                'name'      => 'Catende',
                'ibge_code' => '2604205',
            ],

            10 => [
                'state_id'  => '16',
                'name'      => 'Cedro',
                'ibge_code' => '2604304',
            ],

            11 => [
                'state_id'  => '16',
                'name'      => 'Chã de Alegria',
                'ibge_code' => '2604403',
            ],

            12 => [
                'state_id'  => '16',
                'name'      => 'Chã Grande',
                'ibge_code' => '2604502',
            ],

            13 => [
                'state_id'  => '16',
                'name'      => 'Condado',
                'ibge_code' => '2604601',
            ],

            14 => [
                'state_id'  => '16',
                'name'      => 'Correntes',
                'ibge_code' => '2604700',
            ],

            15 => [
                'state_id'  => '16',
                'name'      => 'Cortês',
                'ibge_code' => '2604809',
            ],

            16 => [
                'state_id'  => '16',
                'name'      => 'Cumaru',
                'ibge_code' => '2604908',
            ],

            17 => [
                'state_id'  => '16',
                'name'      => 'Cupira',
                'ibge_code' => '2605004',
            ],

            18 => [
                'state_id'  => '16',
                'name'      => 'Custódia',
                'ibge_code' => '2605103',
            ],

            19 => [
                'state_id'  => '16',
                'name'      => 'Dormentes',
                'ibge_code' => '2605152',
            ],

            20 => [
                'state_id'  => '16',
                'name'      => 'Escada',
                'ibge_code' => '2605202',
            ],

            21 => [
                'state_id'  => '16',
                'name'      => 'Exu',
                'ibge_code' => '2605301',
            ],

            22 => [
                'state_id'  => '16',
                'name'      => 'Feira Nova',
                'ibge_code' => '2605400',
            ],

            23 => [
                'state_id'  => '16',
                'name'      => 'Fernando de Noronha',
                'ibge_code' => '2605459',
            ],

            24 => [
                'state_id'  => '16',
                'name'      => 'Ferreiros',
                'ibge_code' => '2605509',
            ],

            25 => [
                'state_id'  => '16',
                'name'      => 'Flores',
                'ibge_code' => '2605608',
            ],

            26 => [
                'state_id'  => '16',
                'name'      => 'Floresta',
                'ibge_code' => '2605707',
            ],

            27 => [
                'state_id'  => '16',
                'name'      => 'Frei Miguelinho',
                'ibge_code' => '2605806',
            ],

            28 => [
                'state_id'  => '16',
                'name'      => 'Gameleira',
                'ibge_code' => '2605905',
            ],

            29 => [
                'state_id'  => '16',
                'name'      => 'Garanhuns',
                'ibge_code' => '2606002',
            ],

            30 => [
                'state_id'  => '16',
                'name'      => 'Glória do Goitá',
                'ibge_code' => '2606101',
            ],

            31 => [
                'state_id'  => '16',
                'name'      => 'Goiana',
                'ibge_code' => '2606200',
            ],

            32 => [
                'state_id'  => '16',
                'name'      => 'Granito',
                'ibge_code' => '2606309',
            ],

            33 => [
                'state_id'  => '16',
                'name'      => 'Gravatá',
                'ibge_code' => '2606408',
            ],

            34 => [
                'state_id'  => '16',
                'name'      => 'Iati',
                'ibge_code' => '2606507',
            ],

            35 => [
                'state_id'  => '16',
                'name'      => 'Ibimirim',
                'ibge_code' => '2606606',
            ],

            36 => [
                'state_id'  => '16',
                'name'      => 'Ibirajuba',
                'ibge_code' => '2606705',
            ],

            37 => [
                'state_id'  => '16',
                'name'      => 'Igarassu',
                'ibge_code' => '2606804',
            ],

            38 => [
                'state_id'  => '16',
                'name'      => 'Iguaraci',
                'ibge_code' => '2606903',
            ],

            39 => [
                'state_id'  => '16',
                'name'      => 'Inajá',
                'ibge_code' => '2607000',
            ],

            40 => [
                'state_id'  => '16',
                'name'      => 'Ingazeira',
                'ibge_code' => '2607109',
            ],

            41 => [
                'state_id'  => '16',
                'name'      => 'Ipojuca',
                'ibge_code' => '2607208',
            ],

            42 => [
                'state_id'  => '16',
                'name'      => 'Ipubi',
                'ibge_code' => '2607307',
            ],

            43 => [
                'state_id'  => '16',
                'name'      => 'Itacuruba',
                'ibge_code' => '2607406',
            ],

            44 => [
                'state_id'  => '16',
                'name'      => 'Itaíba',
                'ibge_code' => '2607505',
            ],

            45 => [
                'state_id'  => '16',
                'name'      => 'Ilha de Itamaracá',
                'ibge_code' => '2607604',
            ],

            46 => [
                'state_id'  => '16',
                'name'      => 'Itambé',
                'ibge_code' => '2607653',
            ],

            47 => [
                'state_id'  => '16',
                'name'      => 'Itapetim',
                'ibge_code' => '2607703',
            ],

            48 => [
                'state_id'  => '16',
                'name'      => 'Itapissuma',
                'ibge_code' => '2607752',
            ],

            49 => [
                'state_id'  => '16',
                'name'      => 'Itaquitinga',
                'ibge_code' => '2607802',
            ],

            50 => [
                'state_id'  => '16',
                'name'      => 'Jaboatão dos Guararapes',
                'ibge_code' => '2607901',
            ],

            51 => [
                'state_id'  => '16',
                'name'      => 'Jaqueira',
                'ibge_code' => '2607950',
            ],

            52 => [
                'state_id'  => '16',
                'name'      => 'Jataúba',
                'ibge_code' => '2608008',
            ],

            53 => [
                'state_id'  => '16',
                'name'      => 'Jatobá',
                'ibge_code' => '2608057',
            ],

            54 => [
                'state_id'  => '16',
                'name'      => 'João Alfredo',
                'ibge_code' => '2608107',
            ],

            55 => [
                'state_id'  => '16',
                'name'      => 'Joaquim Nabuco',
                'ibge_code' => '2608206',
            ],

            56 => [
                'state_id'  => '16',
                'name'      => 'Jucati',
                'ibge_code' => '2608255',
            ],

            57 => [
                'state_id'  => '16',
                'name'      => 'Jupi',
                'ibge_code' => '2608305',
            ],

            58 => [
                'state_id'  => '16',
                'name'      => 'Jurema',
                'ibge_code' => '2608404',
            ],

            59 => [
                'state_id'  => '16',
                'name'      => 'Lagoa do Carro',
                'ibge_code' => '2608453',
            ],

            60 => [
                'state_id'  => '16',
                'name'      => 'Lagoa do Itaenga',
                'ibge_code' => '2608503',
            ],

            61 => [
                'state_id'  => '16',
                'name'      => 'Lagoa do Ouro',
                'ibge_code' => '2608602',
            ],

            62 => [
                'state_id'  => '16',
                'name'      => 'Lagoa dos Gatos',
                'ibge_code' => '2608701',
            ],

            63 => [
                'state_id'  => '16',
                'name'      => 'Lagoa Grande',
                'ibge_code' => '2608750',
            ],

            64 => [
                'state_id'  => '16',
                'name'      => 'Lajedo',
                'ibge_code' => '2608800',
            ],

            65 => [
                'state_id'  => '16',
                'name'      => 'Limoeiro',
                'ibge_code' => '2608909',
            ],

            66 => [
                'state_id'  => '16',
                'name'      => 'Macaparana',
                'ibge_code' => '2609006',
            ],

            67 => [
                'state_id'  => '16',
                'name'      => 'Machados',
                'ibge_code' => '2609105',
            ],

            68 => [
                'state_id'  => '16',
                'name'      => 'Manari',
                'ibge_code' => '2609154',
            ],

            69 => [
                'state_id'  => '16',
                'name'      => 'Maraial',
                'ibge_code' => '2609204',
            ],

            70 => [
                'state_id'  => '16',
                'name'      => 'Mirandiba',
                'ibge_code' => '2609303',
            ],

            71 => [
                'state_id'  => '16',
                'name'      => 'Moreno',
                'ibge_code' => '2609402',
            ],

            72 => [
                'state_id'  => '16',
                'name'      => 'Nazaré da Mata',
                'ibge_code' => '2609501',
            ],

            73 => [
                'state_id'  => '16',
                'name'      => 'Olinda',
                'ibge_code' => '2609600',
            ],

            74 => [
                'state_id'  => '16',
                'name'      => 'Orobó',
                'ibge_code' => '2609709',
            ],

            75 => [
                'state_id'  => '16',
                'name'      => 'Orocó',
                'ibge_code' => '2609808',
            ],

            76 => [
                'state_id'  => '16',
                'name'      => 'Ouricuri',
                'ibge_code' => '2609907',
            ],

            77 => [
                'state_id'  => '16',
                'name'      => 'Palmares',
                'ibge_code' => '2610004',
            ],

            78 => [
                'state_id'  => '16',
                'name'      => 'Palmeirina',
                'ibge_code' => '2610103',
            ],

            79 => [
                'state_id'  => '16',
                'name'      => 'Panelas',
                'ibge_code' => '2610202',
            ],

            80 => [
                'state_id'  => '16',
                'name'      => 'Paranatama',
                'ibge_code' => '2610301',
            ],

            81 => [
                'state_id'  => '16',
                'name'      => 'Parnamirim',
                'ibge_code' => '2610400',
            ],

            82 => [
                'state_id'  => '16',
                'name'      => 'Passira',
                'ibge_code' => '2610509',
            ],

            83 => [
                'state_id'  => '16',
                'name'      => 'Paudalho',
                'ibge_code' => '2610608',
            ],

            84 => [
                'state_id'  => '16',
                'name'      => 'Paulista',
                'ibge_code' => '2610707',
            ],

            85 => [
                'state_id'  => '16',
                'name'      => 'Pedra',
                'ibge_code' => '2610806',
            ],

            86 => [
                'state_id'  => '16',
                'name'      => 'Pesqueira',
                'ibge_code' => '2610905',
            ],

            87 => [
                'state_id'  => '16',
                'name'      => 'Petrolândia',
                'ibge_code' => '2611002',
            ],

            88 => [
                'state_id'  => '16',
                'name'      => 'Petrolina',
                'ibge_code' => '2611101',
            ],

            89 => [
                'state_id'  => '16',
                'name'      => 'Poção',
                'ibge_code' => '2611200',
            ],

            90 => [
                'state_id'  => '16',
                'name'      => 'Pombos',
                'ibge_code' => '2611309',
            ],

            91 => [
                'state_id'  => '16',
                'name'      => 'Primavera',
                'ibge_code' => '2611408',
            ],

            92 => [
                'state_id'  => '16',
                'name'      => 'Quipapá',
                'ibge_code' => '2611507',
            ],

            93 => [
                'state_id'  => '16',
                'name'      => 'Quixaba',
                'ibge_code' => '2611533',
            ],

            94 => [
                'state_id'  => '16',
                'name'      => 'Recife',
                'ibge_code' => '2611606',
            ],

            95 => [
                'state_id'  => '16',
                'name'      => 'Riacho das Almas',
                'ibge_code' => '2611705',
            ],

            96 => [
                'state_id'  => '16',
                'name'      => 'Ribeirão',
                'ibge_code' => '2611804',
            ],

            97 => [
                'state_id'  => '16',
                'name'      => 'Rio Formoso',
                'ibge_code' => '2611903',
            ],

            98 => [
                'state_id'  => '16',
                'name'      => 'Sairé',
                'ibge_code' => '2612000',
            ],

            99 => [
                'state_id'  => '16',
                'name'      => 'Salgadinho',
                'ibge_code' => '2612109',
            ],

            100 => [
                'state_id'  => '16',
                'name'      => 'Salgueiro',
                'ibge_code' => '2612208',
            ],

            101 => [
                'state_id'  => '16',
                'name'      => 'Saloá',
                'ibge_code' => '2612307',
            ],

            102 => [
                'state_id'  => '16',
                'name'      => 'Sanharó',
                'ibge_code' => '2612406',
            ],

            103 => [
                'state_id'  => '16',
                'name'      => 'Santa Cruz',
                'ibge_code' => '2612455',
            ],

            104 => [
                'state_id'  => '16',
                'name'      => 'Santa Cruz da Baixa Verde',
                'ibge_code' => '2612471',
            ],

            105 => [
                'state_id'  => '16',
                'name'      => 'Santa Cruz do Capibaribe',
                'ibge_code' => '2612505',
            ],

            106 => [
                'state_id'  => '16',
                'name'      => 'Santa Filomena',
                'ibge_code' => '2612554',
            ],

            107 => [
                'state_id'  => '16',
                'name'      => 'Santa Maria da Boa Vista',
                'ibge_code' => '2612604',
            ],

            108 => [
                'state_id'  => '16',
                'name'      => 'Santa Maria do Cambucá',
                'ibge_code' => '2612703',
            ],

            109 => [
                'state_id'  => '16',
                'name'      => 'Santa Terezinha',
                'ibge_code' => '2612802',
            ],

            110 => [
                'state_id'  => '16',
                'name'      => 'São Benedito do Sul',
                'ibge_code' => '2612901',
            ],

            111 => [
                'state_id'  => '16',
                'name'      => 'São Bento do Una',
                'ibge_code' => '2613008',
            ],

            112 => [
                'state_id'  => '16',
                'name'      => 'São Caitano',
                'ibge_code' => '2613107',
            ],

            113 => [
                'state_id'  => '16',
                'name'      => 'São João',
                'ibge_code' => '2613206',
            ],

            114 => [
                'state_id'  => '16',
                'name'      => 'São Joaquim do Monte',
                'ibge_code' => '2613305',
            ],

            115 => [
                'state_id'  => '16',
                'name'      => 'São José da Coroa Grande',
                'ibge_code' => '2613404',
            ],

            116 => [
                'state_id'  => '16',
                'name'      => 'São José do Belmonte',
                'ibge_code' => '2613503',
            ],

            117 => [
                'state_id'  => '16',
                'name'      => 'São José do Egito',
                'ibge_code' => '2613602',
            ],

            118 => [
                'state_id'  => '16',
                'name'      => 'São Lourenço da Mata',
                'ibge_code' => '2613701',
            ],

            119 => [
                'state_id'  => '16',
                'name'      => 'São Vicente Ferrer',
                'ibge_code' => '2613800',
            ],

            120 => [
                'state_id'  => '16',
                'name'      => 'Serra Talhada',
                'ibge_code' => '2613909',
            ],

            121 => [
                'state_id'  => '16',
                'name'      => 'Serrita',
                'ibge_code' => '2614006',
            ],

            122 => [
                'state_id'  => '16',
                'name'      => 'Sertânia',
                'ibge_code' => '2614105',
            ],

            123 => [
                'state_id'  => '16',
                'name'      => 'Sirinhaém',
                'ibge_code' => '2614204',
            ],

            124 => [
                'state_id'  => '16',
                'name'      => 'Moreilândia',
                'ibge_code' => '2614303',
            ],

            125 => [
                'state_id'  => '16',
                'name'      => 'Solidão',
                'ibge_code' => '2614402',
            ],

            126 => [
                'state_id'  => '16',
                'name'      => 'Surubim',
                'ibge_code' => '2614501',
            ],

            127 => [
                'state_id'  => '16',
                'name'      => 'Tabira',
                'ibge_code' => '2614600',
            ],

            128 => [
                'state_id'  => '16',
                'name'      => 'Tacaimbó',
                'ibge_code' => '2614709',
            ],

            129 => [
                'state_id'  => '16',
                'name'      => 'Tacaratu',
                'ibge_code' => '2614808',
            ],

            130 => [
                'state_id'  => '16',
                'name'      => 'Tamandaré',
                'ibge_code' => '2614857',
            ],

            131 => [
                'state_id'  => '16',
                'name'      => 'Taquaritinga do Norte',
                'ibge_code' => '2615003',
            ],

            132 => [
                'state_id'  => '16',
                'name'      => 'Terezinha',
                'ibge_code' => '2615102',
            ],

            133 => [
                'state_id'  => '16',
                'name'      => 'Terra Nova',
                'ibge_code' => '2615201',
            ],

            134 => [
                'state_id'  => '16',
                'name'      => 'Timbaúba',
                'ibge_code' => '2615300',
            ],

            135 => [
                'state_id'  => '16',
                'name'      => 'Toritama',
                'ibge_code' => '2615409',
            ],

            136 => [
                'state_id'  => '16',
                'name'      => 'Tracunhaém',
                'ibge_code' => '2615508',
            ],

            137 => [
                'state_id'  => '16',
                'name'      => 'Trindade',
                'ibge_code' => '2615607',
            ],

            138 => [
                'state_id'  => '16',
                'name'      => 'Triunfo',
                'ibge_code' => '2615706',
            ],

            139 => [
                'state_id'  => '16',
                'name'      => 'Tupanatinga',
                'ibge_code' => '2615805',
            ],

            140 => [
                'state_id'  => '16',
                'name'      => 'Tuparetama',
                'ibge_code' => '2615904',
            ],

            141 => [
                'state_id'  => '16',
                'name'      => 'Venturosa',
                'ibge_code' => '2616001',
            ],

            142 => [
                'state_id'  => '16',
                'name'      => 'Verdejante',
                'ibge_code' => '2616100',
            ],

            143 => [
                'state_id'  => '16',
                'name'      => 'Vertente do Lério',
                'ibge_code' => '2616183',
            ],

            144 => [
                'state_id'  => '16',
                'name'      => 'Vertentes',
                'ibge_code' => '2616209',
            ],

            145 => [
                'state_id'  => '16',
                'name'      => 'Vicência',
                'ibge_code' => '2616308',
            ],

            146 => [
                'state_id'  => '16',
                'name'      => 'Vitória de Santo Antão',
                'ibge_code' => '2616407',
            ],

            147 => [
                'state_id'  => '16',
                'name'      => 'Xexéu',
                'ibge_code' => '2616506',
            ],

            148 => [
                'state_id'  => '2',
                'name'      => 'Água Branca',
                'ibge_code' => '2700102',
            ],

            149 => [
                'state_id'  => '2',
                'name'      => 'Anadia',
                'ibge_code' => '2700201',
            ],

            150 => [
                'state_id'  => '2',
                'name'      => 'Arapiraca',
                'ibge_code' => '2700300',
            ],

            151 => [
                'state_id'  => '2',
                'name'      => 'Atalaia',
                'ibge_code' => '2700409',
            ],

            152 => [
                'state_id'  => '2',
                'name'      => 'Barra de Santo Antônio',
                'ibge_code' => '2700508',
            ],

            153 => [
                'state_id'  => '2',
                'name'      => 'Barra de São Miguel',
                'ibge_code' => '2700607',
            ],

            154 => [
                'state_id'  => '2',
                'name'      => 'Batalha',
                'ibge_code' => '2700706',
            ],

            155 => [
                'state_id'  => '2',
                'name'      => 'Belém',
                'ibge_code' => '2700805',
            ],

            156 => [
                'state_id'  => '2',
                'name'      => 'Belo Monte',
                'ibge_code' => '2700904',
            ],

            157 => [
                'state_id'  => '2',
                'name'      => 'Boca da Mata',
                'ibge_code' => '2701001',
            ],

            158 => [
                'state_id'  => '2',
                'name'      => 'Branquinha',
                'ibge_code' => '2701100',
            ],

            159 => [
                'state_id'  => '2',
                'name'      => 'Cacimbinhas',
                'ibge_code' => '2701209',
            ],

            160 => [
                'state_id'  => '2',
                'name'      => 'Cajueiro',
                'ibge_code' => '2701308',
            ],

            161 => [
                'state_id'  => '2',
                'name'      => 'Campestre',
                'ibge_code' => '2701357',
            ],

            162 => [
                'state_id'  => '2',
                'name'      => 'Campo Alegre',
                'ibge_code' => '2701407',
            ],

            163 => [
                'state_id'  => '2',
                'name'      => 'Campo Grande',
                'ibge_code' => '2701506',
            ],

            164 => [
                'state_id'  => '2',
                'name'      => 'Canapi',
                'ibge_code' => '2701605',
            ],

            165 => [
                'state_id'  => '2',
                'name'      => 'Capela',
                'ibge_code' => '2701704',
            ],

            166 => [
                'state_id'  => '2',
                'name'      => 'Carneiros',
                'ibge_code' => '2701803',
            ],

            167 => [
                'state_id'  => '2',
                'name'      => 'Chã Preta',
                'ibge_code' => '2701902',
            ],

            168 => [
                'state_id'  => '2',
                'name'      => 'Coité do Nóia',
                'ibge_code' => '2702009',
            ],

            169 => [
                'state_id'  => '2',
                'name'      => 'Colônia Leopoldina',
                'ibge_code' => '2702108',
            ],

            170 => [
                'state_id'  => '2',
                'name'      => 'Coqueiro Seco',
                'ibge_code' => '2702207',
            ],

            171 => [
                'state_id'  => '2',
                'name'      => 'Coruripe',
                'ibge_code' => '2702306',
            ],

            172 => [
                'state_id'  => '2',
                'name'      => 'Craíbas',
                'ibge_code' => '2702355',
            ],

            173 => [
                'state_id'  => '2',
                'name'      => 'Delmiro Gouveia',
                'ibge_code' => '2702405',
            ],

            174 => [
                'state_id'  => '2',
                'name'      => 'Dois Riachos',
                'ibge_code' => '2702504',
            ],

            175 => [
                'state_id'  => '2',
                'name'      => 'Estrela de Alagoas',
                'ibge_code' => '2702553',
            ],

            176 => [
                'state_id'  => '2',
                'name'      => 'Feira Grande',
                'ibge_code' => '2702603',
            ],

            177 => [
                'state_id'  => '2',
                'name'      => 'Feliz Deserto',
                'ibge_code' => '2702702',
            ],

            178 => [
                'state_id'  => '2',
                'name'      => 'Flexeiras',
                'ibge_code' => '2702801',
            ],

            179 => [
                'state_id'  => '2',
                'name'      => 'Girau do Ponciano',
                'ibge_code' => '2702900',
            ],

            180 => [
                'state_id'  => '2',
                'name'      => 'Ibateguara',
                'ibge_code' => '2703007',
            ],

            181 => [
                'state_id'  => '2',
                'name'      => 'Igaci',
                'ibge_code' => '2703106',
            ],

            182 => [
                'state_id'  => '2',
                'name'      => 'Igreja Nova',
                'ibge_code' => '2703205',
            ],

            183 => [
                'state_id'  => '2',
                'name'      => 'Inhapi',
                'ibge_code' => '2703304',
            ],

            184 => [
                'state_id'  => '2',
                'name'      => 'Jacaré dos Homens',
                'ibge_code' => '2703403',
            ],

            185 => [
                'state_id'  => '2',
                'name'      => 'Jacuípe',
                'ibge_code' => '2703502',
            ],

            186 => [
                'state_id'  => '2',
                'name'      => 'Japaratinga',
                'ibge_code' => '2703601',
            ],

            187 => [
                'state_id'  => '2',
                'name'      => 'Jaramataia',
                'ibge_code' => '2703700',
            ],

            188 => [
                'state_id'  => '2',
                'name'      => 'Jequiá da Praia',
                'ibge_code' => '2703759',
            ],

            189 => [
                'state_id'  => '2',
                'name'      => 'Joaquim Gomes',
                'ibge_code' => '2703809',
            ],

            190 => [
                'state_id'  => '2',
                'name'      => 'Jundiá',
                'ibge_code' => '2703908',
            ],

            191 => [
                'state_id'  => '2',
                'name'      => 'Junqueiro',
                'ibge_code' => '2704005',
            ],

            192 => [
                'state_id'  => '2',
                'name'      => 'Lagoa da Canoa',
                'ibge_code' => '2704104',
            ],

            193 => [
                'state_id'  => '2',
                'name'      => 'Limoeiro de Anadia',
                'ibge_code' => '2704203',
            ],

            194 => [
                'state_id'  => '2',
                'name'      => 'Maceió',
                'ibge_code' => '2704302',
            ],

            195 => [
                'state_id'  => '2',
                'name'      => 'Major Isidoro',
                'ibge_code' => '2704401',
            ],

            196 => [
                'state_id'  => '2',
                'name'      => 'Maragogi',
                'ibge_code' => '2704500',
            ],

            197 => [
                'state_id'  => '2',
                'name'      => 'Maravilha',
                'ibge_code' => '2704609',
            ],

            198 => [
                'state_id'  => '2',
                'name'      => 'Marechal Deodoro',
                'ibge_code' => '2704708',
            ],

            199 => [
                'state_id'  => '2',
                'name'      => 'Maribondo',
                'ibge_code' => '2704807',
            ],

            200 => [
                'state_id'  => '2',
                'name'      => 'Mar Vermelho',
                'ibge_code' => '2704906',
            ],

            201 => [
                'state_id'  => '2',
                'name'      => 'Mata Grande',
                'ibge_code' => '2705002',
            ],

            202 => [
                'state_id'  => '2',
                'name'      => 'Matriz de Camaragibe',
                'ibge_code' => '2705101',
            ],

            203 => [
                'state_id'  => '2',
                'name'      => 'Messias',
                'ibge_code' => '2705200',
            ],

            204 => [
                'state_id'  => '2',
                'name'      => 'Minador do Negrão',
                'ibge_code' => '2705309',
            ],

            205 => [
                'state_id'  => '2',
                'name'      => 'Monteirópolis',
                'ibge_code' => '2705408',
            ],

            206 => [
                'state_id'  => '2',
                'name'      => 'Murici',
                'ibge_code' => '2705507',
            ],

            207 => [
                'state_id'  => '2',
                'name'      => 'Novo Lino',
                'ibge_code' => '2705606',
            ],

            208 => [
                'state_id'  => '2',
                'name'      => "Olho D'água das Flores",
                'ibge_code' => '2705705',
            ],

            209 => [
                'state_id'  => '2',
                'name'      => "Olho D'água do Casado",
                'ibge_code' => '2705804',
            ],

            210 => [
                'state_id'  => '2',
                'name'      => "Olho D'água Grande",
                'ibge_code' => '2705903',
            ],

            211 => [
                'state_id'  => '2',
                'name'      => 'Olivença',
                'ibge_code' => '2706000',
            ],

            212 => [
                'state_id'  => '2',
                'name'      => 'Ouro Branco',
                'ibge_code' => '2706109',
            ],

            213 => [
                'state_id'  => '2',
                'name'      => 'Palestina',
                'ibge_code' => '2706208',
            ],

            214 => [
                'state_id'  => '2',
                'name'      => 'Palmeira dos Índios',
                'ibge_code' => '2706307',
            ],

            215 => [
                'state_id'  => '2',
                'name'      => 'Pão de Açúcar',
                'ibge_code' => '2706406',
            ],

            216 => [
                'state_id'  => '2',
                'name'      => 'Pariconha',
                'ibge_code' => '2706422',
            ],

            217 => [
                'state_id'  => '2',
                'name'      => 'Paripueira',
                'ibge_code' => '2706448',
            ],

            218 => [
                'state_id'  => '2',
                'name'      => 'Passo de Camaragibe',
                'ibge_code' => '2706505',
            ],

            219 => [
                'state_id'  => '2',
                'name'      => 'Paulo Jacinto',
                'ibge_code' => '2706604',
            ],

            220 => [
                'state_id'  => '2',
                'name'      => 'Penedo',
                'ibge_code' => '2706703',
            ],

            221 => [
                'state_id'  => '2',
                'name'      => 'Piaçabuçu',
                'ibge_code' => '2706802',
            ],

            222 => [
                'state_id'  => '2',
                'name'      => 'Pilar',
                'ibge_code' => '2706901',
            ],

            223 => [
                'state_id'  => '2',
                'name'      => 'Pindoba',
                'ibge_code' => '2707008',
            ],

            224 => [
                'state_id'  => '2',
                'name'      => 'Piranhas',
                'ibge_code' => '2707107',
            ],

            225 => [
                'state_id'  => '2',
                'name'      => 'Poço das Trincheiras',
                'ibge_code' => '2707206',
            ],

            226 => [
                'state_id'  => '2',
                'name'      => 'Porto Calvo',
                'ibge_code' => '2707305',
            ],

            227 => [
                'state_id'  => '2',
                'name'      => 'Porto de Pedras',
                'ibge_code' => '2707404',
            ],

            228 => [
                'state_id'  => '2',
                'name'      => 'Porto Real do Colégio',
                'ibge_code' => '2707503',
            ],

            229 => [
                'state_id'  => '2',
                'name'      => 'Quebrangulo',
                'ibge_code' => '2707602',
            ],

            230 => [
                'state_id'  => '2',
                'name'      => 'Rio Largo',
                'ibge_code' => '2707701',
            ],

            231 => [
                'state_id'  => '2',
                'name'      => 'Roteiro',
                'ibge_code' => '2707800',
            ],

            232 => [
                'state_id'  => '2',
                'name'      => 'Santa Luzia do Norte',
                'ibge_code' => '2707909',
            ],

            233 => [
                'state_id'  => '2',
                'name'      => 'Santana do Ipanema',
                'ibge_code' => '2708006',
            ],

            234 => [
                'state_id'  => '2',
                'name'      => 'Santana do Mundaú',
                'ibge_code' => '2708105',
            ],

            235 => [
                'state_id'  => '2',
                'name'      => 'São Brás',
                'ibge_code' => '2708204',
            ],

            236 => [
                'state_id'  => '2',
                'name'      => 'São José da Laje',
                'ibge_code' => '2708303',
            ],

            237 => [
                'state_id'  => '2',
                'name'      => 'São José da Tapera',
                'ibge_code' => '2708402',
            ],

            238 => [
                'state_id'  => '2',
                'name'      => 'São Luís do Quitunde',
                'ibge_code' => '2708501',
            ],

            239 => [
                'state_id'  => '2',
                'name'      => 'São Miguel dos Campos',
                'ibge_code' => '2708600',
            ],

            240 => [
                'state_id'  => '2',
                'name'      => 'São Miguel dos Milagres',
                'ibge_code' => '2708709',
            ],

            241 => [
                'state_id'  => '2',
                'name'      => 'São Sebastião',
                'ibge_code' => '2708808',
            ],

            242 => [
                'state_id'  => '2',
                'name'      => 'Satuba',
                'ibge_code' => '2708907',
            ],

            243 => [
                'state_id'  => '2',
                'name'      => 'Senador Rui Palmeira',
                'ibge_code' => '2708956',
            ],

            244 => [
                'state_id'  => '2',
                'name'      => "Tanque D'arca",
                'ibge_code' => '2709004',
            ],

            245 => [
                'state_id'  => '2',
                'name'      => 'Taquarana',
                'ibge_code' => '2709103',
            ],

            246 => [
                'state_id'  => '2',
                'name'      => 'Teotônio Vilela',
                'ibge_code' => '2709152',
            ],

            247 => [
                'state_id'  => '2',
                'name'      => 'Traipu',
                'ibge_code' => '2709202',
            ],

            248 => [
                'state_id'  => '2',
                'name'      => 'União dos Palmares',
                'ibge_code' => '2709301',
            ],

            249 => [
                'state_id'  => '2',
                'name'      => 'Viçosa',
                'ibge_code' => '2709400',
            ],

            250 => [
                'state_id'  => '25',
                'name'      => 'Amparo de São Francisco',
                'ibge_code' => '2800100',
            ],

            251 => [
                'state_id'  => '25',
                'name'      => 'Aquidabã',
                'ibge_code' => '2800209',
            ],

            252 => [
                'state_id'  => '25',
                'name'      => 'Aracaju',
                'ibge_code' => '2800308',
            ],

            253 => [
                'state_id'  => '25',
                'name'      => 'Arauá',
                'ibge_code' => '2800407',
            ],

            254 => [
                'state_id'  => '25',
                'name'      => 'Areia Branca',
                'ibge_code' => '2800506',
            ],

            255 => [
                'state_id'  => '25',
                'name'      => 'Barra dos Coqueiros',
                'ibge_code' => '2800605',
            ],

            256 => [
                'state_id'  => '25',
                'name'      => 'Boquim',
                'ibge_code' => '2800670',
            ],

            257 => [
                'state_id'  => '25',
                'name'      => 'Brejo Grande',
                'ibge_code' => '2800704',
            ],

            258 => [
                'state_id'  => '25',
                'name'      => 'Campo do Brito',
                'ibge_code' => '2801009',
            ],

            259 => [
                'state_id'  => '25',
                'name'      => 'Canhoba',
                'ibge_code' => '2801108',
            ],

            260 => [
                'state_id'  => '25',
                'name'      => 'Canindé de São Francisco',
                'ibge_code' => '2801207',
            ],

            261 => [
                'state_id'  => '25',
                'name'      => 'Capela',
                'ibge_code' => '2801306',
            ],

            262 => [
                'state_id'  => '25',
                'name'      => 'Carira',
                'ibge_code' => '2801405',
            ],

            263 => [
                'state_id'  => '25',
                'name'      => 'Carmópolis',
                'ibge_code' => '2801504',
            ],

            264 => [
                'state_id'  => '25',
                'name'      => 'Cedro de São João',
                'ibge_code' => '2801603',
            ],

            265 => [
                'state_id'  => '25',
                'name'      => 'Cristinápolis',
                'ibge_code' => '2801702',
            ],

            266 => [
                'state_id'  => '25',
                'name'      => 'Cumbe',
                'ibge_code' => '2801900',
            ],

            267 => [
                'state_id'  => '25',
                'name'      => 'Divina Pastora',
                'ibge_code' => '2802007',
            ],

            268 => [
                'state_id'  => '25',
                'name'      => 'Estância',
                'ibge_code' => '2802106',
            ],

            269 => [
                'state_id'  => '25',
                'name'      => 'Feira Nova',
                'ibge_code' => '2802205',
            ],

            270 => [
                'state_id'  => '25',
                'name'      => 'Frei Paulo',
                'ibge_code' => '2802304',
            ],

            271 => [
                'state_id'  => '25',
                'name'      => 'Gararu',
                'ibge_code' => '2802403',
            ],

            272 => [
                'state_id'  => '25',
                'name'      => 'General Maynard',
                'ibge_code' => '2802502',
            ],

            273 => [
                'state_id'  => '25',
                'name'      => 'Gracho Cardoso',
                'ibge_code' => '2802601',
            ],

            274 => [
                'state_id'  => '25',
                'name'      => 'Ilha das Flores',
                'ibge_code' => '2802700',
            ],

            275 => [
                'state_id'  => '25',
                'name'      => 'Indiaroba',
                'ibge_code' => '2802809',
            ],

            276 => [
                'state_id'  => '25',
                'name'      => 'Itabaiana',
                'ibge_code' => '2802908',
            ],

            277 => [
                'state_id'  => '25',
                'name'      => 'Itabaianinha',
                'ibge_code' => '2803005',
            ],

            278 => [
                'state_id'  => '25',
                'name'      => 'Itabi',
                'ibge_code' => '2803104',
            ],

            279 => [
                'state_id'  => '25',
                'name'      => "Itaporanga D'ajuda",
                'ibge_code' => '2803203',
            ],

            280 => [
                'state_id'  => '25',
                'name'      => 'Japaratuba',
                'ibge_code' => '2803302',
            ],

            281 => [
                'state_id'  => '25',
                'name'      => 'Japoatã',
                'ibge_code' => '2803401',
            ],

            282 => [
                'state_id'  => '25',
                'name'      => 'Lagarto',
                'ibge_code' => '2803500',
            ],

            283 => [
                'state_id'  => '25',
                'name'      => 'Laranjeiras',
                'ibge_code' => '2803609',
            ],

            284 => [
                'state_id'  => '25',
                'name'      => 'Macambira',
                'ibge_code' => '2803708',
            ],

            285 => [
                'state_id'  => '25',
                'name'      => 'Malhada dos Bois',
                'ibge_code' => '2803807',
            ],

            286 => [
                'state_id'  => '25',
                'name'      => 'Malhador',
                'ibge_code' => '2803906',
            ],

            287 => [
                'state_id'  => '25',
                'name'      => 'Maruim',
                'ibge_code' => '2804003',
            ],

            288 => [
                'state_id'  => '25',
                'name'      => 'Moita Bonita',
                'ibge_code' => '2804102',
            ],

            289 => [
                'state_id'  => '25',
                'name'      => 'Monte Alegre de Sergipe',
                'ibge_code' => '2804201',
            ],

            290 => [
                'state_id'  => '25',
                'name'      => 'Muribeca',
                'ibge_code' => '2804300',
            ],

            291 => [
                'state_id'  => '25',
                'name'      => 'Neópolis',
                'ibge_code' => '2804409',
            ],

            292 => [
                'state_id'  => '25',
                'name'      => 'Nossa Senhora Aparecida',
                'ibge_code' => '2804458',
            ],

            293 => [
                'state_id'  => '25',
                'name'      => 'Nossa Senhora da Glória',
                'ibge_code' => '2804508',
            ],

            294 => [
                'state_id'  => '25',
                'name'      => 'Nossa Senhora das Dores',
                'ibge_code' => '2804607',
            ],

            295 => [
                'state_id'  => '25',
                'name'      => 'Nossa Senhora de Lourdes',
                'ibge_code' => '2804706',
            ],

            296 => [
                'state_id'  => '25',
                'name'      => 'Nossa Senhora do Socorro',
                'ibge_code' => '2804805',
            ],

            297 => [
                'state_id'  => '25',
                'name'      => 'Pacatuba',
                'ibge_code' => '2804904',
            ],

            298 => [
                'state_id'  => '25',
                'name'      => 'Pedra Mole',
                'ibge_code' => '2805000',
            ],

            299 => [
                'state_id'  => '25',
                'name'      => 'Pedrinhas',
                'ibge_code' => '2805109',
            ],

            300 => [
                'state_id'  => '25',
                'name'      => 'Pinhão',
                'ibge_code' => '2805208',
            ],

            301 => [
                'state_id'  => '25',
                'name'      => 'Pirambu',
                'ibge_code' => '2805307',
            ],

            302 => [
                'state_id'  => '25',
                'name'      => 'Poço Redondo',
                'ibge_code' => '2805406',
            ],

            303 => [
                'state_id'  => '25',
                'name'      => 'Poço Verde',
                'ibge_code' => '2805505',
            ],

            304 => [
                'state_id'  => '25',
                'name'      => 'Porto da Folha',
                'ibge_code' => '2805604',
            ],

            305 => [
                'state_id'  => '25',
                'name'      => 'Propriá',
                'ibge_code' => '2805703',
            ],

            306 => [
                'state_id'  => '25',
                'name'      => 'Riachão do Dantas',
                'ibge_code' => '2805802',
            ],

            307 => [
                'state_id'  => '25',
                'name'      => 'Riachuelo',
                'ibge_code' => '2805901',
            ],

            308 => [
                'state_id'  => '25',
                'name'      => 'Ribeirópolis',
                'ibge_code' => '2806008',
            ],

            309 => [
                'state_id'  => '25',
                'name'      => 'Rosário do Catete',
                'ibge_code' => '2806107',
            ],

            310 => [
                'state_id'  => '25',
                'name'      => 'Salgado',
                'ibge_code' => '2806206',
            ],

            311 => [
                'state_id'  => '25',
                'name'      => 'Santa Luzia do Itanhy',
                'ibge_code' => '2806305',
            ],

            312 => [
                'state_id'  => '25',
                'name'      => 'Santana do São Francisco',
                'ibge_code' => '2806404',
            ],

            313 => [
                'state_id'  => '25',
                'name'      => 'Santa Rosa de Lima',
                'ibge_code' => '2806503',
            ],

            314 => [
                'state_id'  => '25',
                'name'      => 'Santo Amaro das Brotas',
                'ibge_code' => '2806602',
            ],

            315 => [
                'state_id'  => '25',
                'name'      => 'São Cristóvão',
                'ibge_code' => '2806701',
            ],

            316 => [
                'state_id'  => '25',
                'name'      => 'São Domingos',
                'ibge_code' => '2806800',
            ],

            317 => [
                'state_id'  => '25',
                'name'      => 'São Francisco',
                'ibge_code' => '2806909',
            ],

            318 => [
                'state_id'  => '25',
                'name'      => 'São Miguel do Aleixo',
                'ibge_code' => '2807006',
            ],

            319 => [
                'state_id'  => '25',
                'name'      => 'Simão Dias',
                'ibge_code' => '2807105',
            ],

            320 => [
                'state_id'  => '25',
                'name'      => 'Siriri',
                'ibge_code' => '2807204',
            ],

            321 => [
                'state_id'  => '25',
                'name'      => 'Telha',
                'ibge_code' => '2807303',
            ],

            322 => [
                'state_id'  => '25',
                'name'      => 'Tobias Barreto',
                'ibge_code' => '2807402',
            ],

            323 => [
                'state_id'  => '25',
                'name'      => 'Tomar do Geru',
                'ibge_code' => '2807501',
            ],

            324 => [
                'state_id'  => '25',
                'name'      => 'Umbaúba',
                'ibge_code' => '2807600',
            ],

            325 => [
                'state_id'  => '5',
                'name'      => 'Abaíra',
                'ibge_code' => '2900108',
            ],

            326 => [
                'state_id'  => '5',
                'name'      => 'Abaré',
                'ibge_code' => '2900207',
            ],

            327 => [
                'state_id'  => '5',
                'name'      => 'Acajutiba',
                'ibge_code' => '2900306',
            ],

            328 => [
                'state_id'  => '5',
                'name'      => 'Adustina',
                'ibge_code' => '2900355',
            ],

            329 => [
                'state_id'  => '5',
                'name'      => 'Água Fria',
                'ibge_code' => '2900405',
            ],

            330 => [
                'state_id'  => '5',
                'name'      => 'Érico Cardoso',
                'ibge_code' => '2900504',
            ],

            331 => [
                'state_id'  => '5',
                'name'      => 'Aiquara',
                'ibge_code' => '2900603',
            ],

            332 => [
                'state_id'  => '5',
                'name'      => 'Alagoinhas',
                'ibge_code' => '2900702',
            ],

            333 => [
                'state_id'  => '5',
                'name'      => 'Alcobaça',
                'ibge_code' => '2900801',
            ],

            334 => [
                'state_id'  => '5',
                'name'      => 'Almadina',
                'ibge_code' => '2900900',
            ],

            335 => [
                'state_id'  => '5',
                'name'      => 'Amargosa',
                'ibge_code' => '2901007',
            ],

            336 => [
                'state_id'  => '5',
                'name'      => 'Amélia Rodrigues',
                'ibge_code' => '2901106',
            ],

            337 => [
                'state_id'  => '5',
                'name'      => 'América Dourada',
                'ibge_code' => '2901155',
            ],

            338 => [
                'state_id'  => '5',
                'name'      => 'Anagé',
                'ibge_code' => '2901205',
            ],

            339 => [
                'state_id'  => '5',
                'name'      => 'Andaraí',
                'ibge_code' => '2901304',
            ],

            340 => [
                'state_id'  => '5',
                'name'      => 'Andorinha',
                'ibge_code' => '2901353',
            ],

            341 => [
                'state_id'  => '5',
                'name'      => 'Angical',
                'ibge_code' => '2901403',
            ],

            342 => [
                'state_id'  => '5',
                'name'      => 'Anguera',
                'ibge_code' => '2901502',
            ],

            343 => [
                'state_id'  => '5',
                'name'      => 'Antas',
                'ibge_code' => '2901601',
            ],

            344 => [
                'state_id'  => '5',
                'name'      => 'Antônio Cardoso',
                'ibge_code' => '2901700',
            ],

            345 => [
                'state_id'  => '5',
                'name'      => 'Antônio Gonçalves',
                'ibge_code' => '2901809',
            ],

            346 => [
                'state_id'  => '5',
                'name'      => 'Aporá',
                'ibge_code' => '2901908',
            ],

            347 => [
                'state_id'  => '5',
                'name'      => 'Apuarema',
                'ibge_code' => '2901957',
            ],

            348 => [
                'state_id'  => '5',
                'name'      => 'Aracatu',
                'ibge_code' => '2902005',
            ],

            349 => [
                'state_id'  => '5',
                'name'      => 'Araças',
                'ibge_code' => '2902054',
            ],

            350 => [
                'state_id'  => '5',
                'name'      => 'Araci',
                'ibge_code' => '2902104',
            ],

            351 => [
                'state_id'  => '5',
                'name'      => 'Aramari',
                'ibge_code' => '2902203',
            ],

            352 => [
                'state_id'  => '5',
                'name'      => 'Arataca',
                'ibge_code' => '2902252',
            ],

            353 => [
                'state_id'  => '5',
                'name'      => 'Aratuípe',
                'ibge_code' => '2902302',
            ],

            354 => [
                'state_id'  => '5',
                'name'      => 'Aurelino Leal',
                'ibge_code' => '2902401',
            ],

            355 => [
                'state_id'  => '5',
                'name'      => 'Baianópolis',
                'ibge_code' => '2902500',
            ],

            356 => [
                'state_id'  => '5',
                'name'      => 'Baixa Grande',
                'ibge_code' => '2902609',
            ],

            357 => [
                'state_id'  => '5',
                'name'      => 'Banzaê',
                'ibge_code' => '2902658',
            ],

            358 => [
                'state_id'  => '5',
                'name'      => 'Barra',
                'ibge_code' => '2902708',
            ],

            359 => [
                'state_id'  => '5',
                'name'      => 'Barra da Estiva',
                'ibge_code' => '2902807',
            ],

            360 => [
                'state_id'  => '5',
                'name'      => 'Barra do Choça',
                'ibge_code' => '2902906',
            ],

            361 => [
                'state_id'  => '5',
                'name'      => 'Barra do Mendes',
                'ibge_code' => '2903003',
            ],

            362 => [
                'state_id'  => '5',
                'name'      => 'Barra do Rocha',
                'ibge_code' => '2903102',
            ],

            363 => [
                'state_id'  => '5',
                'name'      => 'Barreiras',
                'ibge_code' => '2903201',
            ],

            364 => [
                'state_id'  => '5',
                'name'      => 'Barro Alto',
                'ibge_code' => '2903235',
            ],

            365 => [
                'state_id'  => '5',
                'name'      => 'Barrocas',
                'ibge_code' => '2903276',
            ],

            366 => [
                'state_id'  => '5',
                'name'      => 'Barro Preto',
                'ibge_code' => '2903300',
            ],

            367 => [
                'state_id'  => '5',
                'name'      => 'Belmonte',
                'ibge_code' => '2903409',
            ],

            368 => [
                'state_id'  => '5',
                'name'      => 'Belo Campo',
                'ibge_code' => '2903508',
            ],

            369 => [
                'state_id'  => '5',
                'name'      => 'Biritinga',
                'ibge_code' => '2903607',
            ],

            370 => [
                'state_id'  => '5',
                'name'      => 'Boa Nova',
                'ibge_code' => '2903706',
            ],

            371 => [
                'state_id'  => '5',
                'name'      => 'Boa Vista do Tupim',
                'ibge_code' => '2903805',
            ],

            372 => [
                'state_id'  => '5',
                'name'      => 'Bom Jesus da Lapa',
                'ibge_code' => '2903904',
            ],

            373 => [
                'state_id'  => '5',
                'name'      => 'Bom Jesus da Serra',
                'ibge_code' => '2903953',
            ],

            374 => [
                'state_id'  => '5',
                'name'      => 'Boninal',
                'ibge_code' => '2904001',
            ],

            375 => [
                'state_id'  => '5',
                'name'      => 'Bonito',
                'ibge_code' => '2904050',
            ],

            376 => [
                'state_id'  => '5',
                'name'      => 'Boquira',
                'ibge_code' => '2904100',
            ],

            377 => [
                'state_id'  => '5',
                'name'      => 'Botuporã',
                'ibge_code' => '2904209',
            ],

            378 => [
                'state_id'  => '5',
                'name'      => 'Brejões',
                'ibge_code' => '2904308',
            ],

            379 => [
                'state_id'  => '5',
                'name'      => 'Brejolândia',
                'ibge_code' => '2904407',
            ],

            380 => [
                'state_id'  => '5',
                'name'      => 'Brotas de Macaúbas',
                'ibge_code' => '2904506',
            ],

            381 => [
                'state_id'  => '5',
                'name'      => 'Brumado',
                'ibge_code' => '2904605',
            ],

            382 => [
                'state_id'  => '5',
                'name'      => 'Buerarema',
                'ibge_code' => '2904704',
            ],

            383 => [
                'state_id'  => '5',
                'name'      => 'Buritirama',
                'ibge_code' => '2904753',
            ],

            384 => [
                'state_id'  => '5',
                'name'      => 'Caatiba',
                'ibge_code' => '2904803',
            ],

            385 => [
                'state_id'  => '5',
                'name'      => 'Cabaceiras do Paraguaçu',
                'ibge_code' => '2904852',
            ],

            386 => [
                'state_id'  => '5',
                'name'      => 'Cachoeira',
                'ibge_code' => '2904902',
            ],

            387 => [
                'state_id'  => '5',
                'name'      => 'Caculé',
                'ibge_code' => '2905008',
            ],

            388 => [
                'state_id'  => '5',
                'name'      => 'Caém',
                'ibge_code' => '2905107',
            ],

            389 => [
                'state_id'  => '5',
                'name'      => 'Caetanos',
                'ibge_code' => '2905156',
            ],

            390 => [
                'state_id'  => '5',
                'name'      => 'Caetité',
                'ibge_code' => '2905206',
            ],

            391 => [
                'state_id'  => '5',
                'name'      => 'Cafarnaum',
                'ibge_code' => '2905305',
            ],

            392 => [
                'state_id'  => '5',
                'name'      => 'Cairu',
                'ibge_code' => '2905404',
            ],

            393 => [
                'state_id'  => '5',
                'name'      => 'Caldeirão Grande',
                'ibge_code' => '2905503',
            ],

            394 => [
                'state_id'  => '5',
                'name'      => 'Camacan',
                'ibge_code' => '2905602',
            ],

            395 => [
                'state_id'  => '5',
                'name'      => 'Camaçari',
                'ibge_code' => '2905701',
            ],

            396 => [
                'state_id'  => '5',
                'name'      => 'Camamu',
                'ibge_code' => '2905800',
            ],

            397 => [
                'state_id'  => '5',
                'name'      => 'Campo Alegre de Lourdes',
                'ibge_code' => '2905909',
            ],

            398 => [
                'state_id'  => '5',
                'name'      => 'Campo Formoso',
                'ibge_code' => '2906006',
            ],

            399 => [
                'state_id'  => '5',
                'name'      => 'Canápolis',
                'ibge_code' => '2906105',
            ],

            400 => [
                'state_id'  => '5',
                'name'      => 'Canarana',
                'ibge_code' => '2906204',
            ],

            401 => [
                'state_id'  => '5',
                'name'      => 'Canavieiras',
                'ibge_code' => '2906303',
            ],

            402 => [
                'state_id'  => '5',
                'name'      => 'Candeal',
                'ibge_code' => '2906402',
            ],

            403 => [
                'state_id'  => '5',
                'name'      => 'Candeias',
                'ibge_code' => '2906501',
            ],

            404 => [
                'state_id'  => '5',
                'name'      => 'Candiba',
                'ibge_code' => '2906600',
            ],

            405 => [
                'state_id'  => '5',
                'name'      => 'Cândido Sales',
                'ibge_code' => '2906709',
            ],

            406 => [
                'state_id'  => '5',
                'name'      => 'Cansanção',
                'ibge_code' => '2906808',
            ],

            407 => [
                'state_id'  => '5',
                'name'      => 'Canudos',
                'ibge_code' => '2906824',
            ],

            408 => [
                'state_id'  => '5',
                'name'      => 'Capela do Alto Alegre',
                'ibge_code' => '2906857',
            ],

            409 => [
                'state_id'  => '5',
                'name'      => 'Capim Grosso',
                'ibge_code' => '2906873',
            ],

            410 => [
                'state_id'  => '5',
                'name'      => 'Caraíbas',
                'ibge_code' => '2906899',
            ],

            411 => [
                'state_id'  => '5',
                'name'      => 'Caravelas',
                'ibge_code' => '2906907',
            ],

            412 => [
                'state_id'  => '5',
                'name'      => 'Cardeal da Silva',
                'ibge_code' => '2907004',
            ],

            413 => [
                'state_id'  => '5',
                'name'      => 'Carinhanha',
                'ibge_code' => '2907103',
            ],

            414 => [
                'state_id'  => '5',
                'name'      => 'Casa Nova',
                'ibge_code' => '2907202',
            ],

            415 => [
                'state_id'  => '5',
                'name'      => 'Castro Alves',
                'ibge_code' => '2907301',
            ],

            416 => [
                'state_id'  => '5',
                'name'      => 'Catolândia',
                'ibge_code' => '2907400',
            ],

            417 => [
                'state_id'  => '5',
                'name'      => 'Catu',
                'ibge_code' => '2907509',
            ],

            418 => [
                'state_id'  => '5',
                'name'      => 'Caturama',
                'ibge_code' => '2907558',
            ],

            419 => [
                'state_id'  => '5',
                'name'      => 'Central',
                'ibge_code' => '2907608',
            ],

            420 => [
                'state_id'  => '5',
                'name'      => 'Chorrochó',
                'ibge_code' => '2907707',
            ],

            421 => [
                'state_id'  => '5',
                'name'      => 'Cícero Dantas',
                'ibge_code' => '2907806',
            ],

            422 => [
                'state_id'  => '5',
                'name'      => 'Cipó',
                'ibge_code' => '2907905',
            ],

            423 => [
                'state_id'  => '5',
                'name'      => 'Coaraci',
                'ibge_code' => '2908002',
            ],

            424 => [
                'state_id'  => '5',
                'name'      => 'Cocos',
                'ibge_code' => '2908101',
            ],

            425 => [
                'state_id'  => '5',
                'name'      => 'Conceição da Feira',
                'ibge_code' => '2908200',
            ],

            426 => [
                'state_id'  => '5',
                'name'      => 'Conceição do Almeida',
                'ibge_code' => '2908309',
            ],

            427 => [
                'state_id'  => '5',
                'name'      => 'Conceição do Coité',
                'ibge_code' => '2908408',
            ],

            428 => [
                'state_id'  => '5',
                'name'      => 'Conceição do Jacuípe',
                'ibge_code' => '2908507',
            ],

            429 => [
                'state_id'  => '5',
                'name'      => 'Conde',
                'ibge_code' => '2908606',
            ],

            430 => [
                'state_id'  => '5',
                'name'      => 'Condeúba',
                'ibge_code' => '2908705',
            ],

            431 => [
                'state_id'  => '5',
                'name'      => 'Contendas do Sincorá',
                'ibge_code' => '2908804',
            ],

            432 => [
                'state_id'  => '5',
                'name'      => 'Coração de Maria',
                'ibge_code' => '2908903',
            ],

            433 => [
                'state_id'  => '5',
                'name'      => 'Cordeiros',
                'ibge_code' => '2909000',
            ],

            434 => [
                'state_id'  => '5',
                'name'      => 'Coribe',
                'ibge_code' => '2909109',
            ],

            435 => [
                'state_id'  => '5',
                'name'      => 'Coronel João Sá',
                'ibge_code' => '2909208',
            ],

            436 => [
                'state_id'  => '5',
                'name'      => 'Correntina',
                'ibge_code' => '2909307',
            ],

            437 => [
                'state_id'  => '5',
                'name'      => 'Cotegipe',
                'ibge_code' => '2909406',
            ],

            438 => [
                'state_id'  => '5',
                'name'      => 'Cravolândia',
                'ibge_code' => '2909505',
            ],

            439 => [
                'state_id'  => '5',
                'name'      => 'Crisópolis',
                'ibge_code' => '2909604',
            ],

            440 => [
                'state_id'  => '5',
                'name'      => 'Cristópolis',
                'ibge_code' => '2909703',
            ],

            441 => [
                'state_id'  => '5',
                'name'      => 'Cruz das Almas',
                'ibge_code' => '2909802',
            ],

            442 => [
                'state_id'  => '5',
                'name'      => 'Curaçá',
                'ibge_code' => '2909901',
            ],

            443 => [
                'state_id'  => '5',
                'name'      => 'Dário Meira',
                'ibge_code' => '2910008',
            ],

            444 => [
                'state_id'  => '5',
                'name'      => "Dias D'ávila",
                'ibge_code' => '2910057',
            ],

            445 => [
                'state_id'  => '5',
                'name'      => 'Dom Basílio',
                'ibge_code' => '2910107',
            ],

            446 => [
                'state_id'  => '5',
                'name'      => 'Dom Macedo Costa',
                'ibge_code' => '2910206',
            ],

            447 => [
                'state_id'  => '5',
                'name'      => 'Elísio Medrado',
                'ibge_code' => '2910305',
            ],

            448 => [
                'state_id'  => '5',
                'name'      => 'Encruzilhada',
                'ibge_code' => '2910404',
            ],

            449 => [
                'state_id'  => '5',
                'name'      => 'Entre Rios',
                'ibge_code' => '2910503',
            ],

            450 => [
                'state_id'  => '5',
                'name'      => 'Esplanada',
                'ibge_code' => '2910602',
            ],

            451 => [
                'state_id'  => '5',
                'name'      => 'Euclides da Cunha',
                'ibge_code' => '2910701',
            ],

            452 => [
                'state_id'  => '5',
                'name'      => 'Eunápolis',
                'ibge_code' => '2910727',
            ],

            453 => [
                'state_id'  => '5',
                'name'      => 'Fátima',
                'ibge_code' => '2910750',
            ],

            454 => [
                'state_id'  => '5',
                'name'      => 'Feira da Mata',
                'ibge_code' => '2910776',
            ],

            455 => [
                'state_id'  => '5',
                'name'      => 'Feira de Santana',
                'ibge_code' => '2910800',
            ],

            456 => [
                'state_id'  => '5',
                'name'      => 'Filadélfia',
                'ibge_code' => '2910859',
            ],

            457 => [
                'state_id'  => '5',
                'name'      => 'Firmino Alves',
                'ibge_code' => '2910909',
            ],

            458 => [
                'state_id'  => '5',
                'name'      => 'Floresta Azul',
                'ibge_code' => '2911006',
            ],

            459 => [
                'state_id'  => '5',
                'name'      => 'Formosa do Rio Preto',
                'ibge_code' => '2911105',
            ],

            460 => [
                'state_id'  => '5',
                'name'      => 'Gandu',
                'ibge_code' => '2911204',
            ],

            461 => [
                'state_id'  => '5',
                'name'      => 'Gavião',
                'ibge_code' => '2911253',
            ],

            462 => [
                'state_id'  => '5',
                'name'      => 'Gentio do Ouro',
                'ibge_code' => '2911303',
            ],

            463 => [
                'state_id'  => '5',
                'name'      => 'Glória',
                'ibge_code' => '2911402',
            ],

            464 => [
                'state_id'  => '5',
                'name'      => 'Gongogi',
                'ibge_code' => '2911501',
            ],

            465 => [
                'state_id'  => '5',
                'name'      => 'Governador Mangabeira',
                'ibge_code' => '2911600',
            ],

            466 => [
                'state_id'  => '5',
                'name'      => 'Guajeru',
                'ibge_code' => '2911659',
            ],

            467 => [
                'state_id'  => '5',
                'name'      => 'Guanambi',
                'ibge_code' => '2911709',
            ],

            468 => [
                'state_id'  => '5',
                'name'      => 'Guaratinga',
                'ibge_code' => '2911808',
            ],

            469 => [
                'state_id'  => '5',
                'name'      => 'Heliópolis',
                'ibge_code' => '2911857',
            ],

            470 => [
                'state_id'  => '5',
                'name'      => 'Iaçu',
                'ibge_code' => '2911907',
            ],

            471 => [
                'state_id'  => '5',
                'name'      => 'Ibiassucê',
                'ibge_code' => '2912004',
            ],

            472 => [
                'state_id'  => '5',
                'name'      => 'Ibicaraí',
                'ibge_code' => '2912103',
            ],

            473 => [
                'state_id'  => '5',
                'name'      => 'Ibicoara',
                'ibge_code' => '2912202',
            ],

            474 => [
                'state_id'  => '5',
                'name'      => 'Ibicuí',
                'ibge_code' => '2912301',
            ],

            475 => [
                'state_id'  => '5',
                'name'      => 'Ibipeba',
                'ibge_code' => '2912400',
            ],

            476 => [
                'state_id'  => '5',
                'name'      => 'Ibipitanga',
                'ibge_code' => '2912509',
            ],

            477 => [
                'state_id'  => '5',
                'name'      => 'Ibiquera',
                'ibge_code' => '2912608',
            ],

            478 => [
                'state_id'  => '5',
                'name'      => 'Ibirapitanga',
                'ibge_code' => '2912707',
            ],

            479 => [
                'state_id'  => '5',
                'name'      => 'Ibirapuã',
                'ibge_code' => '2912806',
            ],

            480 => [
                'state_id'  => '5',
                'name'      => 'Ibirataia',
                'ibge_code' => '2912905',
            ],

            481 => [
                'state_id'  => '5',
                'name'      => 'Ibitiara',
                'ibge_code' => '2913002',
            ],

            482 => [
                'state_id'  => '5',
                'name'      => 'Ibititá',
                'ibge_code' => '2913101',
            ],

            483 => [
                'state_id'  => '5',
                'name'      => 'Ibotirama',
                'ibge_code' => '2913200',
            ],

            484 => [
                'state_id'  => '5',
                'name'      => 'Ichu',
                'ibge_code' => '2913309',
            ],

            485 => [
                'state_id'  => '5',
                'name'      => 'Igaporã',
                'ibge_code' => '2913408',
            ],

            486 => [
                'state_id'  => '5',
                'name'      => 'Igrapiúna',
                'ibge_code' => '2913457',
            ],

            487 => [
                'state_id'  => '5',
                'name'      => 'Iguaí',
                'ibge_code' => '2913507',
            ],

            488 => [
                'state_id'  => '5',
                'name'      => 'Ilhéus',
                'ibge_code' => '2913606',
            ],

            489 => [
                'state_id'  => '5',
                'name'      => 'Inhambupe',
                'ibge_code' => '2913705',
            ],

            490 => [
                'state_id'  => '5',
                'name'      => 'Ipecaetá',
                'ibge_code' => '2913804',
            ],

            491 => [
                'state_id'  => '5',
                'name'      => 'Ipiaú',
                'ibge_code' => '2913903',
            ],

            492 => [
                'state_id'  => '5',
                'name'      => 'Ipirá',
                'ibge_code' => '2914000',
            ],

            493 => [
                'state_id'  => '5',
                'name'      => 'Ipupiara',
                'ibge_code' => '2914109',
            ],

            494 => [
                'state_id'  => '5',
                'name'      => 'Irajuba',
                'ibge_code' => '2914208',
            ],

            495 => [
                'state_id'  => '5',
                'name'      => 'Iramaia',
                'ibge_code' => '2914307',
            ],

            496 => [
                'state_id'  => '5',
                'name'      => 'Iraquara',
                'ibge_code' => '2914406',
            ],

            497 => [
                'state_id'  => '5',
                'name'      => 'Irará',
                'ibge_code' => '2914505',
            ],

            498 => [
                'state_id'  => '5',
                'name'      => 'Irecê',
                'ibge_code' => '2914604',
            ],

            499 => [
                'state_id'  => '5',
                'name'      => 'Itabela',
                'ibge_code' => '2914653',
            ],

        ]);
        DB::table('cities')->insert([
            0 => [
                'state_id'  => '5',
                'name'      => 'Itaberaba',
                'ibge_code' => '2914703',
            ],

            1 => [
                'state_id'  => '5',
                'name'      => 'Itabuna',
                'ibge_code' => '2914802',
            ],

            2 => [
                'state_id'  => '5',
                'name'      => 'Itacaré',
                'ibge_code' => '2914901',
            ],

            3 => [
                'state_id'  => '5',
                'name'      => 'Itaeté',
                'ibge_code' => '2915007',
            ],

            4 => [
                'state_id'  => '5',
                'name'      => 'Itagi',
                'ibge_code' => '2915106',
            ],

            5 => [
                'state_id'  => '5',
                'name'      => 'Itagibá',
                'ibge_code' => '2915205',
            ],

            6 => [
                'state_id'  => '5',
                'name'      => 'Itagimirim',
                'ibge_code' => '2915304',
            ],

            7 => [
                'state_id'  => '5',
                'name'      => 'Itaguaçu da Bahia',
                'ibge_code' => '2915353',
            ],

            8 => [
                'state_id'  => '5',
                'name'      => 'Itaju do Colônia',
                'ibge_code' => '2915403',
            ],

            9 => [
                'state_id'  => '5',
                'name'      => 'Itajuípe',
                'ibge_code' => '2915502',
            ],

            10 => [
                'state_id'  => '5',
                'name'      => 'Itamaraju',
                'ibge_code' => '2915601',
            ],

            11 => [
                'state_id'  => '5',
                'name'      => 'Itamari',
                'ibge_code' => '2915700',
            ],

            12 => [
                'state_id'  => '5',
                'name'      => 'Itambé',
                'ibge_code' => '2915809',
            ],

            13 => [
                'state_id'  => '5',
                'name'      => 'Itanagra',
                'ibge_code' => '2915908',
            ],

            14 => [
                'state_id'  => '5',
                'name'      => 'Itanhém',
                'ibge_code' => '2916005',
            ],

            15 => [
                'state_id'  => '5',
                'name'      => 'Itaparica',
                'ibge_code' => '2916104',
            ],

            16 => [
                'state_id'  => '5',
                'name'      => 'Itapé',
                'ibge_code' => '2916203',
            ],

            17 => [
                'state_id'  => '5',
                'name'      => 'Itapebi',
                'ibge_code' => '2916302',
            ],

            18 => [
                'state_id'  => '5',
                'name'      => 'Itapetinga',
                'ibge_code' => '2916401',
            ],

            19 => [
                'state_id'  => '5',
                'name'      => 'Itapicuru',
                'ibge_code' => '2916500',
            ],

            20 => [
                'state_id'  => '5',
                'name'      => 'Itapitanga',
                'ibge_code' => '2916609',
            ],

            21 => [
                'state_id'  => '5',
                'name'      => 'Itaquara',
                'ibge_code' => '2916708',
            ],

            22 => [
                'state_id'  => '5',
                'name'      => 'Itarantim',
                'ibge_code' => '2916807',
            ],

            23 => [
                'state_id'  => '5',
                'name'      => 'Itatim',
                'ibge_code' => '2916856',
            ],

            24 => [
                'state_id'  => '5',
                'name'      => 'Itiruçu',
                'ibge_code' => '2916906',
            ],

            25 => [
                'state_id'  => '5',
                'name'      => 'Itiúba',
                'ibge_code' => '2917003',
            ],

            26 => [
                'state_id'  => '5',
                'name'      => 'Itororó',
                'ibge_code' => '2917102',
            ],

            27 => [
                'state_id'  => '5',
                'name'      => 'Ituaçu',
                'ibge_code' => '2917201',
            ],

            28 => [
                'state_id'  => '5',
                'name'      => 'Ituberá',
                'ibge_code' => '2917300',
            ],

            29 => [
                'state_id'  => '5',
                'name'      => 'Iuiú',
                'ibge_code' => '2917334',
            ],

            30 => [
                'state_id'  => '5',
                'name'      => 'Jaborandi',
                'ibge_code' => '2917359',
            ],

            31 => [
                'state_id'  => '5',
                'name'      => 'Jacaraci',
                'ibge_code' => '2917409',
            ],

            32 => [
                'state_id'  => '5',
                'name'      => 'Jacobina',
                'ibge_code' => '2917508',
            ],

            33 => [
                'state_id'  => '5',
                'name'      => 'Jaguaquara',
                'ibge_code' => '2917607',
            ],

            34 => [
                'state_id'  => '5',
                'name'      => 'Jaguarari',
                'ibge_code' => '2917706',
            ],

            35 => [
                'state_id'  => '5',
                'name'      => 'Jaguaripe',
                'ibge_code' => '2917805',
            ],

            36 => [
                'state_id'  => '5',
                'name'      => 'Jandaíra',
                'ibge_code' => '2917904',
            ],

            37 => [
                'state_id'  => '5',
                'name'      => 'Jequié',
                'ibge_code' => '2918001',
            ],

            38 => [
                'state_id'  => '5',
                'name'      => 'Jeremoabo',
                'ibge_code' => '2918100',
            ],

            39 => [
                'state_id'  => '5',
                'name'      => 'Jiquiriçá',
                'ibge_code' => '2918209',
            ],

            40 => [
                'state_id'  => '5',
                'name'      => 'Jitaúna',
                'ibge_code' => '2918308',
            ],

            41 => [
                'state_id'  => '5',
                'name'      => 'João Dourado',
                'ibge_code' => '2918357',
            ],

            42 => [
                'state_id'  => '5',
                'name'      => 'Juazeiro',
                'ibge_code' => '2918407',
            ],

            43 => [
                'state_id'  => '5',
                'name'      => 'Jucuruçu',
                'ibge_code' => '2918456',
            ],

            44 => [
                'state_id'  => '5',
                'name'      => 'Jussara',
                'ibge_code' => '2918506',
            ],

            45 => [
                'state_id'  => '5',
                'name'      => 'Jussari',
                'ibge_code' => '2918555',
            ],

            46 => [
                'state_id'  => '5',
                'name'      => 'Jussiape',
                'ibge_code' => '2918605',
            ],

            47 => [
                'state_id'  => '5',
                'name'      => 'Lafaiete Coutinho',
                'ibge_code' => '2918704',
            ],

            48 => [
                'state_id'  => '5',
                'name'      => 'Lagoa Real',
                'ibge_code' => '2918753',
            ],

            49 => [
                'state_id'  => '5',
                'name'      => 'Laje',
                'ibge_code' => '2918803',
            ],

            50 => [
                'state_id'  => '5',
                'name'      => 'Lajedão',
                'ibge_code' => '2918902',
            ],

            51 => [
                'state_id'  => '5',
                'name'      => 'Lajedinho',
                'ibge_code' => '2919009',
            ],

            52 => [
                'state_id'  => '5',
                'name'      => 'Lajedo do Tabocal',
                'ibge_code' => '2919058',
            ],

            53 => [
                'state_id'  => '5',
                'name'      => 'Lamarão',
                'ibge_code' => '2919108',
            ],

            54 => [
                'state_id'  => '5',
                'name'      => 'Lapão',
                'ibge_code' => '2919157',
            ],

            55 => [
                'state_id'  => '5',
                'name'      => 'Lauro de Freitas',
                'ibge_code' => '2919207',
            ],

            56 => [
                'state_id'  => '5',
                'name'      => 'Lençóis',
                'ibge_code' => '2919306',
            ],

            57 => [
                'state_id'  => '5',
                'name'      => 'Licínio de Almeida',
                'ibge_code' => '2919405',
            ],

            58 => [
                'state_id'  => '5',
                'name'      => 'Livramento de Nossa Senhora',
                'ibge_code' => '2919504',
            ],

            59 => [
                'state_id'  => '5',
                'name'      => 'Luís Eduardo Magalhães',
                'ibge_code' => '2919553',
            ],

            60 => [
                'state_id'  => '5',
                'name'      => 'Macajuba',
                'ibge_code' => '2919603',
            ],

            61 => [
                'state_id'  => '5',
                'name'      => 'Macarani',
                'ibge_code' => '2919702',
            ],

            62 => [
                'state_id'  => '5',
                'name'      => 'Macaúbas',
                'ibge_code' => '2919801',
            ],

            63 => [
                'state_id'  => '5',
                'name'      => 'Macururé',
                'ibge_code' => '2919900',
            ],

            64 => [
                'state_id'  => '5',
                'name'      => 'Madre de Deus',
                'ibge_code' => '2919926',
            ],

            65 => [
                'state_id'  => '5',
                'name'      => 'Maetinga',
                'ibge_code' => '2919959',
            ],

            66 => [
                'state_id'  => '5',
                'name'      => 'Maiquinique',
                'ibge_code' => '2920007',
            ],

            67 => [
                'state_id'  => '5',
                'name'      => 'Mairi',
                'ibge_code' => '2920106',
            ],

            68 => [
                'state_id'  => '5',
                'name'      => 'Malhada',
                'ibge_code' => '2920205',
            ],

            69 => [
                'state_id'  => '5',
                'name'      => 'Malhada de Pedras',
                'ibge_code' => '2920304',
            ],

            70 => [
                'state_id'  => '5',
                'name'      => 'Manoel Vitorino',
                'ibge_code' => '2920403',
            ],

            71 => [
                'state_id'  => '5',
                'name'      => 'Mansidão',
                'ibge_code' => '2920452',
            ],

            72 => [
                'state_id'  => '5',
                'name'      => 'Maracás',
                'ibge_code' => '2920502',
            ],

            73 => [
                'state_id'  => '5',
                'name'      => 'Maragogipe',
                'ibge_code' => '2920601',
            ],

            74 => [
                'state_id'  => '5',
                'name'      => 'Maraú',
                'ibge_code' => '2920700',
            ],

            75 => [
                'state_id'  => '5',
                'name'      => 'Marcionílio Souza',
                'ibge_code' => '2920809',
            ],

            76 => [
                'state_id'  => '5',
                'name'      => 'Mascote',
                'ibge_code' => '2920908',
            ],

            77 => [
                'state_id'  => '5',
                'name'      => 'Mata de São João',
                'ibge_code' => '2921005',
            ],

            78 => [
                'state_id'  => '5',
                'name'      => 'Matina',
                'ibge_code' => '2921054',
            ],

            79 => [
                'state_id'  => '5',
                'name'      => 'Medeiros Neto',
                'ibge_code' => '2921104',
            ],

            80 => [
                'state_id'  => '5',
                'name'      => 'Miguel Calmon',
                'ibge_code' => '2921203',
            ],

            81 => [
                'state_id'  => '5',
                'name'      => 'Milagres',
                'ibge_code' => '2921302',
            ],

            82 => [
                'state_id'  => '5',
                'name'      => 'Mirangaba',
                'ibge_code' => '2921401',
            ],

            83 => [
                'state_id'  => '5',
                'name'      => 'Mirante',
                'ibge_code' => '2921450',
            ],

            84 => [
                'state_id'  => '5',
                'name'      => 'Monte Santo',
                'ibge_code' => '2921500',
            ],

            85 => [
                'state_id'  => '5',
                'name'      => 'Morpará',
                'ibge_code' => '2921609',
            ],

            86 => [
                'state_id'  => '5',
                'name'      => 'Morro do Chapéu',
                'ibge_code' => '2921708',
            ],

            87 => [
                'state_id'  => '5',
                'name'      => 'Mortugaba',
                'ibge_code' => '2921807',
            ],

            88 => [
                'state_id'  => '5',
                'name'      => 'Mucugê',
                'ibge_code' => '2921906',
            ],

            89 => [
                'state_id'  => '5',
                'name'      => 'Mucuri',
                'ibge_code' => '2922003',
            ],

            90 => [
                'state_id'  => '5',
                'name'      => 'Mulungu do Morro',
                'ibge_code' => '2922052',
            ],

            91 => [
                'state_id'  => '5',
                'name'      => 'Mundo Novo',
                'ibge_code' => '2922102',
            ],

            92 => [
                'state_id'  => '5',
                'name'      => 'Muniz Ferreira',
                'ibge_code' => '2922201',
            ],

            93 => [
                'state_id'  => '5',
                'name'      => 'Muquém de São Francisco',
                'ibge_code' => '2922250',
            ],

            94 => [
                'state_id'  => '5',
                'name'      => 'Muritiba',
                'ibge_code' => '2922300',
            ],

            95 => [
                'state_id'  => '5',
                'name'      => 'Mutuípe',
                'ibge_code' => '2922409',
            ],

            96 => [
                'state_id'  => '5',
                'name'      => 'Nazaré',
                'ibge_code' => '2922508',
            ],

            97 => [
                'state_id'  => '5',
                'name'      => 'Nilo Peçanha',
                'ibge_code' => '2922607',
            ],

            98 => [
                'state_id'  => '5',
                'name'      => 'Nordestina',
                'ibge_code' => '2922656',
            ],

            99 => [
                'state_id'  => '5',
                'name'      => 'Nova Canaã',
                'ibge_code' => '2922706',
            ],

            100 => [
                'state_id'  => '5',
                'name'      => 'Nova Fátima',
                'ibge_code' => '2922730',
            ],

            101 => [
                'state_id'  => '5',
                'name'      => 'Nova Ibiá',
                'ibge_code' => '2922755',
            ],

            102 => [
                'state_id'  => '5',
                'name'      => 'Nova Itarana',
                'ibge_code' => '2922805',
            ],

            103 => [
                'state_id'  => '5',
                'name'      => 'Nova Redenção',
                'ibge_code' => '2922854',
            ],

            104 => [
                'state_id'  => '5',
                'name'      => 'Nova Soure',
                'ibge_code' => '2922904',
            ],

            105 => [
                'state_id'  => '5',
                'name'      => 'Nova Viçosa',
                'ibge_code' => '2923001',
            ],

            106 => [
                'state_id'  => '5',
                'name'      => 'Novo Horizonte',
                'ibge_code' => '2923035',
            ],

            107 => [
                'state_id'  => '5',
                'name'      => 'Novo Triunfo',
                'ibge_code' => '2923050',
            ],

            108 => [
                'state_id'  => '5',
                'name'      => 'Olindina',
                'ibge_code' => '2923100',
            ],

            109 => [
                'state_id'  => '5',
                'name'      => 'Oliveira dos Brejinhos',
                'ibge_code' => '2923209',
            ],

            110 => [
                'state_id'  => '5',
                'name'      => 'Ouriçangas',
                'ibge_code' => '2923308',
            ],

            111 => [
                'state_id'  => '5',
                'name'      => 'Ourolândia',
                'ibge_code' => '2923357',
            ],

            112 => [
                'state_id'  => '5',
                'name'      => 'Palmas de Monte Alto',
                'ibge_code' => '2923407',
            ],

            113 => [
                'state_id'  => '5',
                'name'      => 'Palmeiras',
                'ibge_code' => '2923506',
            ],

            114 => [
                'state_id'  => '5',
                'name'      => 'Paramirim',
                'ibge_code' => '2923605',
            ],

            115 => [
                'state_id'  => '5',
                'name'      => 'Paratinga',
                'ibge_code' => '2923704',
            ],

            116 => [
                'state_id'  => '5',
                'name'      => 'Paripiranga',
                'ibge_code' => '2923803',
            ],

            117 => [
                'state_id'  => '5',
                'name'      => 'Pau Brasil',
                'ibge_code' => '2923902',
            ],

            118 => [
                'state_id'  => '5',
                'name'      => 'Paulo Afonso',
                'ibge_code' => '2924009',
            ],

            119 => [
                'state_id'  => '5',
                'name'      => 'Pé de Serra',
                'ibge_code' => '2924058',
            ],

            120 => [
                'state_id'  => '5',
                'name'      => 'Pedrão',
                'ibge_code' => '2924108',
            ],

            121 => [
                'state_id'  => '5',
                'name'      => 'Pedro Alexandre',
                'ibge_code' => '2924207',
            ],

            122 => [
                'state_id'  => '5',
                'name'      => 'Piatã',
                'ibge_code' => '2924306',
            ],

            123 => [
                'state_id'  => '5',
                'name'      => 'Pilão Arcado',
                'ibge_code' => '2924405',
            ],

            124 => [
                'state_id'  => '5',
                'name'      => 'Pindaí',
                'ibge_code' => '2924504',
            ],

            125 => [
                'state_id'  => '5',
                'name'      => 'Pindobaçu',
                'ibge_code' => '2924603',
            ],

            126 => [
                'state_id'  => '5',
                'name'      => 'Pintadas',
                'ibge_code' => '2924652',
            ],

            127 => [
                'state_id'  => '5',
                'name'      => 'Piraí do Norte',
                'ibge_code' => '2924678',
            ],

            128 => [
                'state_id'  => '5',
                'name'      => 'Piripá',
                'ibge_code' => '2924702',
            ],

            129 => [
                'state_id'  => '5',
                'name'      => 'Piritiba',
                'ibge_code' => '2924801',
            ],

            130 => [
                'state_id'  => '5',
                'name'      => 'Planaltino',
                'ibge_code' => '2924900',
            ],

            131 => [
                'state_id'  => '5',
                'name'      => 'Planalto',
                'ibge_code' => '2925006',
            ],

            132 => [
                'state_id'  => '5',
                'name'      => 'Poções',
                'ibge_code' => '2925105',
            ],

            133 => [
                'state_id'  => '5',
                'name'      => 'Pojuca',
                'ibge_code' => '2925204',
            ],

            134 => [
                'state_id'  => '5',
                'name'      => 'Ponto Novo',
                'ibge_code' => '2925253',
            ],

            135 => [
                'state_id'  => '5',
                'name'      => 'Porto Seguro',
                'ibge_code' => '2925303',
            ],

            136 => [
                'state_id'  => '5',
                'name'      => 'Potiraguá',
                'ibge_code' => '2925402',
            ],

            137 => [
                'state_id'  => '5',
                'name'      => 'Prado',
                'ibge_code' => '2925501',
            ],

            138 => [
                'state_id'  => '5',
                'name'      => 'Presidente Dutra',
                'ibge_code' => '2925600',
            ],

            139 => [
                'state_id'  => '5',
                'name'      => 'Presidente Jânio Quadros',
                'ibge_code' => '2925709',
            ],

            140 => [
                'state_id'  => '5',
                'name'      => 'Presidente Tancredo Neves',
                'ibge_code' => '2925758',
            ],

            141 => [
                'state_id'  => '5',
                'name'      => 'Queimadas',
                'ibge_code' => '2925808',
            ],

            142 => [
                'state_id'  => '5',
                'name'      => 'Quijingue',
                'ibge_code' => '2925907',
            ],

            143 => [
                'state_id'  => '5',
                'name'      => 'Quixabeira',
                'ibge_code' => '2925931',
            ],

            144 => [
                'state_id'  => '5',
                'name'      => 'Rafael Jambeiro',
                'ibge_code' => '2925956',
            ],

            145 => [
                'state_id'  => '5',
                'name'      => 'Remanso',
                'ibge_code' => '2926004',
            ],

            146 => [
                'state_id'  => '5',
                'name'      => 'Retirolândia',
                'ibge_code' => '2926103',
            ],

            147 => [
                'state_id'  => '5',
                'name'      => 'Riachão das Neves',
                'ibge_code' => '2926202',
            ],

            148 => [
                'state_id'  => '5',
                'name'      => 'Riachão do Jacuípe',
                'ibge_code' => '2926301',
            ],

            149 => [
                'state_id'  => '5',
                'name'      => 'Riacho de Santana',
                'ibge_code' => '2926400',
            ],

            150 => [
                'state_id'  => '5',
                'name'      => 'Ribeira do Amparo',
                'ibge_code' => '2926509',
            ],

            151 => [
                'state_id'  => '5',
                'name'      => 'Ribeira do Pombal',
                'ibge_code' => '2926608',
            ],

            152 => [
                'state_id'  => '5',
                'name'      => 'Ribeirão do Largo',
                'ibge_code' => '2926657',
            ],

            153 => [
                'state_id'  => '5',
                'name'      => 'Rio de Contas',
                'ibge_code' => '2926707',
            ],

            154 => [
                'state_id'  => '5',
                'name'      => 'Rio do Antônio',
                'ibge_code' => '2926806',
            ],

            155 => [
                'state_id'  => '5',
                'name'      => 'Rio do Pires',
                'ibge_code' => '2926905',
            ],

            156 => [
                'state_id'  => '5',
                'name'      => 'Rio Real',
                'ibge_code' => '2927002',
            ],

            157 => [
                'state_id'  => '5',
                'name'      => 'Rodelas',
                'ibge_code' => '2927101',
            ],

            158 => [
                'state_id'  => '5',
                'name'      => 'Ruy Barbosa',
                'ibge_code' => '2927200',
            ],

            159 => [
                'state_id'  => '5',
                'name'      => 'Salinas da Margarida',
                'ibge_code' => '2927309',
            ],

            160 => [
                'state_id'  => '5',
                'name'      => 'Salvador',
                'ibge_code' => '2927408',
            ],

            161 => [
                'state_id'  => '5',
                'name'      => 'Santa Bárbara',
                'ibge_code' => '2927507',
            ],

            162 => [
                'state_id'  => '5',
                'name'      => 'Santa Brígida',
                'ibge_code' => '2927606',
            ],

            163 => [
                'state_id'  => '5',
                'name'      => 'Santa Cruz Cabrália',
                'ibge_code' => '2927705',
            ],

            164 => [
                'state_id'  => '5',
                'name'      => 'Santa Cruz da Vitória',
                'ibge_code' => '2927804',
            ],

            165 => [
                'state_id'  => '5',
                'name'      => 'Santa Inês',
                'ibge_code' => '2927903',
            ],

            166 => [
                'state_id'  => '5',
                'name'      => 'Santaluz',
                'ibge_code' => '2928000',
            ],

            167 => [
                'state_id'  => '5',
                'name'      => 'Santa Luzia',
                'ibge_code' => '2928059',
            ],

            168 => [
                'state_id'  => '5',
                'name'      => 'Santa Maria da Vitória',
                'ibge_code' => '2928109',
            ],

            169 => [
                'state_id'  => '5',
                'name'      => 'Santana',
                'ibge_code' => '2928208',
            ],

            170 => [
                'state_id'  => '5',
                'name'      => 'Santanópolis',
                'ibge_code' => '2928307',
            ],

            171 => [
                'state_id'  => '5',
                'name'      => 'Santa Rita de Cássia',
                'ibge_code' => '2928406',
            ],

            172 => [
                'state_id'  => '5',
                'name'      => 'Santa Teresinha',
                'ibge_code' => '2928505',
            ],

            173 => [
                'state_id'  => '5',
                'name'      => 'Santo Amaro',
                'ibge_code' => '2928604',
            ],

            174 => [
                'state_id'  => '5',
                'name'      => 'Santo Antônio de Jesus',
                'ibge_code' => '2928703',
            ],

            175 => [
                'state_id'  => '5',
                'name'      => 'Santo Estêvão',
                'ibge_code' => '2928802',
            ],

            176 => [
                'state_id'  => '5',
                'name'      => 'São Desidério',
                'ibge_code' => '2928901',
            ],

            177 => [
                'state_id'  => '5',
                'name'      => 'São Domingos',
                'ibge_code' => '2928950',
            ],

            178 => [
                'state_id'  => '5',
                'name'      => 'São Félix',
                'ibge_code' => '2929008',
            ],

            179 => [
                'state_id'  => '5',
                'name'      => 'São Félix do Coribe',
                'ibge_code' => '2929057',
            ],

            180 => [
                'state_id'  => '5',
                'name'      => 'São Felipe',
                'ibge_code' => '2929107',
            ],

            181 => [
                'state_id'  => '5',
                'name'      => 'São Francisco do Conde',
                'ibge_code' => '2929206',
            ],

            182 => [
                'state_id'  => '5',
                'name'      => 'São Gabriel',
                'ibge_code' => '2929255',
            ],

            183 => [
                'state_id'  => '5',
                'name'      => 'São Gonçalo dos Campos',
                'ibge_code' => '2929305',
            ],

            184 => [
                'state_id'  => '5',
                'name'      => 'São José da Vitória',
                'ibge_code' => '2929354',
            ],

            185 => [
                'state_id'  => '5',
                'name'      => 'São José do Jacuípe',
                'ibge_code' => '2929370',
            ],

            186 => [
                'state_id'  => '5',
                'name'      => 'São Miguel das Matas',
                'ibge_code' => '2929404',
            ],

            187 => [
                'state_id'  => '5',
                'name'      => 'São Sebastião do Passé',
                'ibge_code' => '2929503',
            ],

            188 => [
                'state_id'  => '5',
                'name'      => 'Sapeaçu',
                'ibge_code' => '2929602',
            ],

            189 => [
                'state_id'  => '5',
                'name'      => 'Sátiro Dias',
                'ibge_code' => '2929701',
            ],

            190 => [
                'state_id'  => '5',
                'name'      => 'Saubara',
                'ibge_code' => '2929750',
            ],

            191 => [
                'state_id'  => '5',
                'name'      => 'Saúde',
                'ibge_code' => '2929800',
            ],

            192 => [
                'state_id'  => '5',
                'name'      => 'Seabra',
                'ibge_code' => '2929909',
            ],

            193 => [
                'state_id'  => '5',
                'name'      => 'Sebastião Laranjeiras',
                'ibge_code' => '2930006',
            ],

            194 => [
                'state_id'  => '5',
                'name'      => 'Senhor do Bonfim',
                'ibge_code' => '2930105',
            ],

            195 => [
                'state_id'  => '5',
                'name'      => 'Serra do Ramalho',
                'ibge_code' => '2930154',
            ],

            196 => [
                'state_id'  => '5',
                'name'      => 'Sento Sé',
                'ibge_code' => '2930204',
            ],

            197 => [
                'state_id'  => '5',
                'name'      => 'Serra Dourada',
                'ibge_code' => '2930303',
            ],

            198 => [
                'state_id'  => '5',
                'name'      => 'Serra Preta',
                'ibge_code' => '2930402',
            ],

            199 => [
                'state_id'  => '5',
                'name'      => 'Serrinha',
                'ibge_code' => '2930501',
            ],

            200 => [
                'state_id'  => '5',
                'name'      => 'Serrolândia',
                'ibge_code' => '2930600',
            ],

            201 => [
                'state_id'  => '5',
                'name'      => 'Simões Filho',
                'ibge_code' => '2930709',
            ],

            202 => [
                'state_id'  => '5',
                'name'      => 'Sítio do Mato',
                'ibge_code' => '2930758',
            ],

            203 => [
                'state_id'  => '5',
                'name'      => 'Sítio do Quinto',
                'ibge_code' => '2930766',
            ],

            204 => [
                'state_id'  => '5',
                'name'      => 'Sobradinho',
                'ibge_code' => '2930774',
            ],

            205 => [
                'state_id'  => '5',
                'name'      => 'Souto Soares',
                'ibge_code' => '2930808',
            ],

            206 => [
                'state_id'  => '5',
                'name'      => 'Tabocas do Brejo Velho',
                'ibge_code' => '2930907',
            ],

            207 => [
                'state_id'  => '5',
                'name'      => 'Tanhaçu',
                'ibge_code' => '2931004',
            ],

            208 => [
                'state_id'  => '5',
                'name'      => 'Tanque Novo',
                'ibge_code' => '2931053',
            ],

            209 => [
                'state_id'  => '5',
                'name'      => 'Tanquinho',
                'ibge_code' => '2931103',
            ],

            210 => [
                'state_id'  => '5',
                'name'      => 'Taperoá',
                'ibge_code' => '2931202',
            ],

            211 => [
                'state_id'  => '5',
                'name'      => 'Tapiramutá',
                'ibge_code' => '2931301',
            ],

            212 => [
                'state_id'  => '5',
                'name'      => 'Teixeira de Freitas',
                'ibge_code' => '2931350',
            ],

            213 => [
                'state_id'  => '5',
                'name'      => 'Teodoro Sampaio',
                'ibge_code' => '2931400',
            ],

            214 => [
                'state_id'  => '5',
                'name'      => 'Teofilândia',
                'ibge_code' => '2931509',
            ],

            215 => [
                'state_id'  => '5',
                'name'      => 'Teolândia',
                'ibge_code' => '2931608',
            ],

            216 => [
                'state_id'  => '5',
                'name'      => 'Terra Nova',
                'ibge_code' => '2931707',
            ],

            217 => [
                'state_id'  => '5',
                'name'      => 'Tremedal',
                'ibge_code' => '2931806',
            ],

            218 => [
                'state_id'  => '5',
                'name'      => 'Tucano',
                'ibge_code' => '2931905',
            ],

            219 => [
                'state_id'  => '5',
                'name'      => 'Uauá',
                'ibge_code' => '2932002',
            ],

            220 => [
                'state_id'  => '5',
                'name'      => 'Ubaíra',
                'ibge_code' => '2932101',
            ],

            221 => [
                'state_id'  => '5',
                'name'      => 'Ubaitaba',
                'ibge_code' => '2932200',
            ],

            222 => [
                'state_id'  => '5',
                'name'      => 'Ubatã',
                'ibge_code' => '2932309',
            ],

            223 => [
                'state_id'  => '5',
                'name'      => 'Uibaí',
                'ibge_code' => '2932408',
            ],

            224 => [
                'state_id'  => '5',
                'name'      => 'Umburanas',
                'ibge_code' => '2932457',
            ],

            225 => [
                'state_id'  => '5',
                'name'      => 'Una',
                'ibge_code' => '2932507',
            ],

            226 => [
                'state_id'  => '5',
                'name'      => 'Urandi',
                'ibge_code' => '2932606',
            ],

            227 => [
                'state_id'  => '5',
                'name'      => 'Uruçuca',
                'ibge_code' => '2932705',
            ],

            228 => [
                'state_id'  => '5',
                'name'      => 'Utinga',
                'ibge_code' => '2932804',
            ],

            229 => [
                'state_id'  => '5',
                'name'      => 'Valença',
                'ibge_code' => '2932903',
            ],

            230 => [
                'state_id'  => '5',
                'name'      => 'Valente',
                'ibge_code' => '2933000',
            ],

            231 => [
                'state_id'  => '5',
                'name'      => 'Várzea da Roça',
                'ibge_code' => '2933059',
            ],

            232 => [
                'state_id'  => '5',
                'name'      => 'Várzea do Poço',
                'ibge_code' => '2933109',
            ],

            233 => [
                'state_id'  => '5',
                'name'      => 'Várzea Nova',
                'ibge_code' => '2933158',
            ],

            234 => [
                'state_id'  => '5',
                'name'      => 'Varzedo',
                'ibge_code' => '2933174',
            ],

            235 => [
                'state_id'  => '5',
                'name'      => 'Vera Cruz',
                'ibge_code' => '2933208',
            ],

            236 => [
                'state_id'  => '5',
                'name'      => 'Vereda',
                'ibge_code' => '2933257',
            ],

            237 => [
                'state_id'  => '5',
                'name'      => 'Vitória da Conquista',
                'ibge_code' => '2933307',
            ],

            238 => [
                'state_id'  => '5',
                'name'      => 'Wagner',
                'ibge_code' => '2933406',
            ],

            239 => [
                'state_id'  => '5',
                'name'      => 'Wanderley',
                'ibge_code' => '2933455',
            ],

            240 => [
                'state_id'  => '5',
                'name'      => 'Wenceslau Guimarães',
                'ibge_code' => '2933505',
            ],

            241 => [
                'state_id'  => '5',
                'name'      => 'Xique-Xique',
                'ibge_code' => '2933604',
            ],

            242 => [
                'state_id'  => '11',
                'name'      => 'Abadia dos Dourados',
                'ibge_code' => '3100104',
            ],

            243 => [
                'state_id'  => '11',
                'name'      => 'Abaeté',
                'ibge_code' => '3100203',
            ],

            244 => [
                'state_id'  => '11',
                'name'      => 'Abre Campo',
                'ibge_code' => '3100302',
            ],

            245 => [
                'state_id'  => '11',
                'name'      => 'Acaiaca',
                'ibge_code' => '3100401',
            ],

            246 => [
                'state_id'  => '11',
                'name'      => 'Açucena',
                'ibge_code' => '3100500',
            ],

            247 => [
                'state_id'  => '11',
                'name'      => 'Água Boa',
                'ibge_code' => '3100609',
            ],

            248 => [
                'state_id'  => '11',
                'name'      => 'Água Comprida',
                'ibge_code' => '3100708',
            ],

            249 => [
                'state_id'  => '11',
                'name'      => 'Aguanil',
                'ibge_code' => '3100807',
            ],

            250 => [
                'state_id'  => '11',
                'name'      => 'Águas Formosas',
                'ibge_code' => '3100906',
            ],

            251 => [
                'state_id'  => '11',
                'name'      => 'Águas Vermelhas',
                'ibge_code' => '3101003',
            ],

            252 => [
                'state_id'  => '11',
                'name'      => 'Aimorés',
                'ibge_code' => '3101102',
            ],

            253 => [
                'state_id'  => '11',
                'name'      => 'Aiuruoca',
                'ibge_code' => '3101201',
            ],

            254 => [
                'state_id'  => '11',
                'name'      => 'Alagoa',
                'ibge_code' => '3101300',
            ],

            255 => [
                'state_id'  => '11',
                'name'      => 'Albertina',
                'ibge_code' => '3101409',
            ],

            256 => [
                'state_id'  => '11',
                'name'      => 'Além Paraíba',
                'ibge_code' => '3101508',
            ],

            257 => [
                'state_id'  => '11',
                'name'      => 'Alfenas',
                'ibge_code' => '3101607',
            ],

            258 => [
                'state_id'  => '11',
                'name'      => 'Alfredo Vasconcelos',
                'ibge_code' => '3101631',
            ],

            259 => [
                'state_id'  => '11',
                'name'      => 'Almenara',
                'ibge_code' => '3101706',
            ],

            260 => [
                'state_id'  => '11',
                'name'      => 'Alpercata',
                'ibge_code' => '3101805',
            ],

            261 => [
                'state_id'  => '11',
                'name'      => 'Alpinópolis',
                'ibge_code' => '3101904',
            ],

            262 => [
                'state_id'  => '11',
                'name'      => 'Alterosa',
                'ibge_code' => '3102001',
            ],

            263 => [
                'state_id'  => '11',
                'name'      => 'Alto Caparaó',
                'ibge_code' => '3102050',
            ],

            264 => [
                'state_id'  => '11',
                'name'      => 'Alto Rio Doce',
                'ibge_code' => '3102100',
            ],

            265 => [
                'state_id'  => '11',
                'name'      => 'Alvarenga',
                'ibge_code' => '3102209',
            ],

            266 => [
                'state_id'  => '11',
                'name'      => 'Alvinópolis',
                'ibge_code' => '3102308',
            ],

            267 => [
                'state_id'  => '11',
                'name'      => 'Alvorada de Minas',
                'ibge_code' => '3102407',
            ],

            268 => [
                'state_id'  => '11',
                'name'      => 'Amparo do Serra',
                'ibge_code' => '3102506',
            ],

            269 => [
                'state_id'  => '11',
                'name'      => 'Andradas',
                'ibge_code' => '3102605',
            ],

            270 => [
                'state_id'  => '11',
                'name'      => 'Cachoeira de Pajeú',
                'ibge_code' => '3102704',
            ],

            271 => [
                'state_id'  => '11',
                'name'      => 'Andrelândia',
                'ibge_code' => '3102803',
            ],

            272 => [
                'state_id'  => '11',
                'name'      => 'Angelândia',
                'ibge_code' => '3102852',
            ],

            273 => [
                'state_id'  => '11',
                'name'      => 'Antônio Carlos',
                'ibge_code' => '3102902',
            ],

            274 => [
                'state_id'  => '11',
                'name'      => 'Antônio Dias',
                'ibge_code' => '3103009',
            ],

            275 => [
                'state_id'  => '11',
                'name'      => 'Antônio Prado de Minas',
                'ibge_code' => '3103108',
            ],

            276 => [
                'state_id'  => '11',
                'name'      => 'Araçaí',
                'ibge_code' => '3103207',
            ],

            277 => [
                'state_id'  => '11',
                'name'      => 'Aracitaba',
                'ibge_code' => '3103306',
            ],

            278 => [
                'state_id'  => '11',
                'name'      => 'Araçuaí',
                'ibge_code' => '3103405',
            ],

            279 => [
                'state_id'  => '11',
                'name'      => 'Araguari',
                'ibge_code' => '3103504',
            ],

            280 => [
                'state_id'  => '11',
                'name'      => 'Arantina',
                'ibge_code' => '3103603',
            ],

            281 => [
                'state_id'  => '11',
                'name'      => 'Araponga',
                'ibge_code' => '3103702',
            ],

            282 => [
                'state_id'  => '11',
                'name'      => 'Araporã',
                'ibge_code' => '3103751',
            ],

            283 => [
                'state_id'  => '11',
                'name'      => 'Arapuá',
                'ibge_code' => '3103801',
            ],

            284 => [
                'state_id'  => '11',
                'name'      => 'Araújos',
                'ibge_code' => '3103900',
            ],

            285 => [
                'state_id'  => '11',
                'name'      => 'Araxá',
                'ibge_code' => '3104007',
            ],

            286 => [
                'state_id'  => '11',
                'name'      => 'Arceburgo',
                'ibge_code' => '3104106',
            ],

            287 => [
                'state_id'  => '11',
                'name'      => 'Arcos',
                'ibge_code' => '3104205',
            ],

            288 => [
                'state_id'  => '11',
                'name'      => 'Areado',
                'ibge_code' => '3104304',
            ],

            289 => [
                'state_id'  => '11',
                'name'      => 'Argirita',
                'ibge_code' => '3104403',
            ],

            290 => [
                'state_id'  => '11',
                'name'      => 'Aricanduva',
                'ibge_code' => '3104452',
            ],

            291 => [
                'state_id'  => '11',
                'name'      => 'Arinos',
                'ibge_code' => '3104502',
            ],

            292 => [
                'state_id'  => '11',
                'name'      => 'Astolfo Dutra',
                'ibge_code' => '3104601',
            ],

            293 => [
                'state_id'  => '11',
                'name'      => 'Ataléia',
                'ibge_code' => '3104700',
            ],

            294 => [
                'state_id'  => '11',
                'name'      => 'Augusto de Lima',
                'ibge_code' => '3104809',
            ],

            295 => [
                'state_id'  => '11',
                'name'      => 'Baependi',
                'ibge_code' => '3104908',
            ],

            296 => [
                'state_id'  => '11',
                'name'      => 'Baldim',
                'ibge_code' => '3105004',
            ],

            297 => [
                'state_id'  => '11',
                'name'      => 'Bambuí',
                'ibge_code' => '3105103',
            ],

            298 => [
                'state_id'  => '11',
                'name'      => 'Bandeira',
                'ibge_code' => '3105202',
            ],

            299 => [
                'state_id'  => '11',
                'name'      => 'Bandeira do Sul',
                'ibge_code' => '3105301',
            ],

            300 => [
                'state_id'  => '11',
                'name'      => 'Barão de Cocais',
                'ibge_code' => '3105400',
            ],

            301 => [
                'state_id'  => '11',
                'name'      => 'Barão de Monte Alto',
                'ibge_code' => '3105509',
            ],

            302 => [
                'state_id'  => '11',
                'name'      => 'Barbacena',
                'ibge_code' => '3105608',
            ],

            303 => [
                'state_id'  => '11',
                'name'      => 'Barra Longa',
                'ibge_code' => '3105707',
            ],

            304 => [
                'state_id'  => '11',
                'name'      => 'Barroso',
                'ibge_code' => '3105905',
            ],

            305 => [
                'state_id'  => '11',
                'name'      => 'Bela Vista de Minas',
                'ibge_code' => '3106002',
            ],

            306 => [
                'state_id'  => '11',
                'name'      => 'Belmiro Braga',
                'ibge_code' => '3106101',
            ],

            307 => [
                'state_id'  => '11',
                'name'      => 'Belo Horizonte',
                'ibge_code' => '3106200',
            ],

            308 => [
                'state_id'  => '11',
                'name'      => 'Belo Oriente',
                'ibge_code' => '3106309',
            ],

            309 => [
                'state_id'  => '11',
                'name'      => 'Belo Vale',
                'ibge_code' => '3106408',
            ],

            310 => [
                'state_id'  => '11',
                'name'      => 'Berilo',
                'ibge_code' => '3106507',
            ],

            311 => [
                'state_id'  => '11',
                'name'      => 'Bertópolis',
                'ibge_code' => '3106606',
            ],

            312 => [
                'state_id'  => '11',
                'name'      => 'Berizal',
                'ibge_code' => '3106655',
            ],

            313 => [
                'state_id'  => '11',
                'name'      => 'Betim',
                'ibge_code' => '3106705',
            ],

            314 => [
                'state_id'  => '11',
                'name'      => 'Bias Fortes',
                'ibge_code' => '3106804',
            ],

            315 => [
                'state_id'  => '11',
                'name'      => 'Bicas',
                'ibge_code' => '3106903',
            ],

            316 => [
                'state_id'  => '11',
                'name'      => 'Biquinhas',
                'ibge_code' => '3107000',
            ],

            317 => [
                'state_id'  => '11',
                'name'      => 'Boa Esperança',
                'ibge_code' => '3107109',
            ],

            318 => [
                'state_id'  => '11',
                'name'      => 'Bocaina de Minas',
                'ibge_code' => '3107208',
            ],

            319 => [
                'state_id'  => '11',
                'name'      => 'Bocaiúva',
                'ibge_code' => '3107307',
            ],

            320 => [
                'state_id'  => '11',
                'name'      => 'Bom Despacho',
                'ibge_code' => '3107406',
            ],

            321 => [
                'state_id'  => '11',
                'name'      => 'Bom Jardim de Minas',
                'ibge_code' => '3107505',
            ],

            322 => [
                'state_id'  => '11',
                'name'      => 'Bom Jesus da Penha',
                'ibge_code' => '3107604',
            ],

            323 => [
                'state_id'  => '11',
                'name'      => 'Bom Jesus do Amparo',
                'ibge_code' => '3107703',
            ],

            324 => [
                'state_id'  => '11',
                'name'      => 'Bom Jesus do Galho',
                'ibge_code' => '3107802',
            ],

            325 => [
                'state_id'  => '11',
                'name'      => 'Bom Repouso',
                'ibge_code' => '3107901',
            ],

            326 => [
                'state_id'  => '11',
                'name'      => 'Bom Sucesso',
                'ibge_code' => '3108008',
            ],

            327 => [
                'state_id'  => '11',
                'name'      => 'Bonfim',
                'ibge_code' => '3108107',
            ],

            328 => [
                'state_id'  => '11',
                'name'      => 'Bonfinópolis de Minas',
                'ibge_code' => '3108206',
            ],

            329 => [
                'state_id'  => '11',
                'name'      => 'Bonito de Minas',
                'ibge_code' => '3108255',
            ],

            330 => [
                'state_id'  => '11',
                'name'      => 'Borda da Mata',
                'ibge_code' => '3108305',
            ],

            331 => [
                'state_id'  => '11',
                'name'      => 'Botelhos',
                'ibge_code' => '3108404',
            ],

            332 => [
                'state_id'  => '11',
                'name'      => 'Botumirim',
                'ibge_code' => '3108503',
            ],

            333 => [
                'state_id'  => '11',
                'name'      => 'Brasilândia de Minas',
                'ibge_code' => '3108552',
            ],

            334 => [
                'state_id'  => '11',
                'name'      => 'Brasília de Minas',
                'ibge_code' => '3108602',
            ],

            335 => [
                'state_id'  => '11',
                'name'      => 'Brás Pires',
                'ibge_code' => '3108701',
            ],

            336 => [
                'state_id'  => '11',
                'name'      => 'Braúnas',
                'ibge_code' => '3108800',
            ],

            337 => [
                'state_id'  => '11',
                'name'      => 'Brasópolis',
                'ibge_code' => '3108909',
            ],

            338 => [
                'state_id'  => '11',
                'name'      => 'Brumadinho',
                'ibge_code' => '3109006',
            ],

            339 => [
                'state_id'  => '11',
                'name'      => 'Bueno Brandão',
                'ibge_code' => '3109105',
            ],

            340 => [
                'state_id'  => '11',
                'name'      => 'Buenópolis',
                'ibge_code' => '3109204',
            ],

            341 => [
                'state_id'  => '11',
                'name'      => 'Bugre',
                'ibge_code' => '3109253',
            ],

            342 => [
                'state_id'  => '11',
                'name'      => 'Buritis',
                'ibge_code' => '3109303',
            ],

            343 => [
                'state_id'  => '11',
                'name'      => 'Buritizeiro',
                'ibge_code' => '3109402',
            ],

            344 => [
                'state_id'  => '11',
                'name'      => 'Cabeceira Grande',
                'ibge_code' => '3109451',
            ],

            345 => [
                'state_id'  => '11',
                'name'      => 'Cabo Verde',
                'ibge_code' => '3109501',
            ],

            346 => [
                'state_id'  => '11',
                'name'      => 'Cachoeira da Prata',
                'ibge_code' => '3109600',
            ],

            347 => [
                'state_id'  => '11',
                'name'      => 'Cachoeira de Minas',
                'ibge_code' => '3109709',
            ],

            348 => [
                'state_id'  => '11',
                'name'      => 'Cachoeira Dourada',
                'ibge_code' => '3109808',
            ],

            349 => [
                'state_id'  => '11',
                'name'      => 'Caetanópolis',
                'ibge_code' => '3109907',
            ],

            350 => [
                'state_id'  => '11',
                'name'      => 'Caeté',
                'ibge_code' => '3110004',
            ],

            351 => [
                'state_id'  => '11',
                'name'      => 'Caiana',
                'ibge_code' => '3110103',
            ],

            352 => [
                'state_id'  => '11',
                'name'      => 'Cajuri',
                'ibge_code' => '3110202',
            ],

            353 => [
                'state_id'  => '11',
                'name'      => 'Caldas',
                'ibge_code' => '3110301',
            ],

            354 => [
                'state_id'  => '11',
                'name'      => 'Camacho',
                'ibge_code' => '3110400',
            ],

            355 => [
                'state_id'  => '11',
                'name'      => 'Camanducaia',
                'ibge_code' => '3110509',
            ],

            356 => [
                'state_id'  => '11',
                'name'      => 'Cambuí',
                'ibge_code' => '3110608',
            ],

            357 => [
                'state_id'  => '11',
                'name'      => 'Cambuquira',
                'ibge_code' => '3110707',
            ],

            358 => [
                'state_id'  => '11',
                'name'      => 'Campanário',
                'ibge_code' => '3110806',
            ],

            359 => [
                'state_id'  => '11',
                'name'      => 'Campanha',
                'ibge_code' => '3110905',
            ],

            360 => [
                'state_id'  => '11',
                'name'      => 'Campestre',
                'ibge_code' => '3111002',
            ],

            361 => [
                'state_id'  => '11',
                'name'      => 'Campina Verde',
                'ibge_code' => '3111101',
            ],

            362 => [
                'state_id'  => '11',
                'name'      => 'Campo Azul',
                'ibge_code' => '3111150',
            ],

            363 => [
                'state_id'  => '11',
                'name'      => 'Campo Belo',
                'ibge_code' => '3111200',
            ],

            364 => [
                'state_id'  => '11',
                'name'      => 'Campo do Meio',
                'ibge_code' => '3111309',
            ],

            365 => [
                'state_id'  => '11',
                'name'      => 'Campo Florido',
                'ibge_code' => '3111408',
            ],

            366 => [
                'state_id'  => '11',
                'name'      => 'Campos Altos',
                'ibge_code' => '3111507',
            ],

            367 => [
                'state_id'  => '11',
                'name'      => 'Campos Gerais',
                'ibge_code' => '3111606',
            ],

            368 => [
                'state_id'  => '11',
                'name'      => 'Canaã',
                'ibge_code' => '3111705',
            ],

            369 => [
                'state_id'  => '11',
                'name'      => 'Canápolis',
                'ibge_code' => '3111804',
            ],

            370 => [
                'state_id'  => '11',
                'name'      => 'Cana Verde',
                'ibge_code' => '3111903',
            ],

            371 => [
                'state_id'  => '11',
                'name'      => 'Candeias',
                'ibge_code' => '3112000',
            ],

            372 => [
                'state_id'  => '11',
                'name'      => 'Cantagalo',
                'ibge_code' => '3112059',
            ],

            373 => [
                'state_id'  => '11',
                'name'      => 'Caparaó',
                'ibge_code' => '3112109',
            ],

            374 => [
                'state_id'  => '11',
                'name'      => 'Capela Nova',
                'ibge_code' => '3112208',
            ],

            375 => [
                'state_id'  => '11',
                'name'      => 'Capelinha',
                'ibge_code' => '3112307',
            ],

            376 => [
                'state_id'  => '11',
                'name'      => 'Capetinga',
                'ibge_code' => '3112406',
            ],

            377 => [
                'state_id'  => '11',
                'name'      => 'Capim Branco',
                'ibge_code' => '3112505',
            ],

            378 => [
                'state_id'  => '11',
                'name'      => 'Capinópolis',
                'ibge_code' => '3112604',
            ],

            379 => [
                'state_id'  => '11',
                'name'      => 'Capitão Andrade',
                'ibge_code' => '3112653',
            ],

            380 => [
                'state_id'  => '11',
                'name'      => 'Capitão Enéas',
                'ibge_code' => '3112703',
            ],

            381 => [
                'state_id'  => '11',
                'name'      => 'Capitólio',
                'ibge_code' => '3112802',
            ],

            382 => [
                'state_id'  => '11',
                'name'      => 'Caputira',
                'ibge_code' => '3112901',
            ],

            383 => [
                'state_id'  => '11',
                'name'      => 'Caraí',
                'ibge_code' => '3113008',
            ],

            384 => [
                'state_id'  => '11',
                'name'      => 'Caranaíba',
                'ibge_code' => '3113107',
            ],

            385 => [
                'state_id'  => '11',
                'name'      => 'Carandaí',
                'ibge_code' => '3113206',
            ],

            386 => [
                'state_id'  => '11',
                'name'      => 'Carangola',
                'ibge_code' => '3113305',
            ],

            387 => [
                'state_id'  => '11',
                'name'      => 'Caratinga',
                'ibge_code' => '3113404',
            ],

            388 => [
                'state_id'  => '11',
                'name'      => 'Carbonita',
                'ibge_code' => '3113503',
            ],

            389 => [
                'state_id'  => '11',
                'name'      => 'Careaçu',
                'ibge_code' => '3113602',
            ],

            390 => [
                'state_id'  => '11',
                'name'      => 'Carlos Chagas',
                'ibge_code' => '3113701',
            ],

            391 => [
                'state_id'  => '11',
                'name'      => 'Carmésia',
                'ibge_code' => '3113800',
            ],

            392 => [
                'state_id'  => '11',
                'name'      => 'Carmo da Cachoeira',
                'ibge_code' => '3113909',
            ],

            393 => [
                'state_id'  => '11',
                'name'      => 'Carmo da Mata',
                'ibge_code' => '3114006',
            ],

            394 => [
                'state_id'  => '11',
                'name'      => 'Carmo de Minas',
                'ibge_code' => '3114105',
            ],

            395 => [
                'state_id'  => '11',
                'name'      => 'Carmo do Cajuru',
                'ibge_code' => '3114204',
            ],

            396 => [
                'state_id'  => '11',
                'name'      => 'Carmo do Paranaíba',
                'ibge_code' => '3114303',
            ],

            397 => [
                'state_id'  => '11',
                'name'      => 'Carmo do Rio Claro',
                'ibge_code' => '3114402',
            ],

            398 => [
                'state_id'  => '11',
                'name'      => 'Carmópolis de Minas',
                'ibge_code' => '3114501',
            ],

            399 => [
                'state_id'  => '11',
                'name'      => 'Carneirinho',
                'ibge_code' => '3114550',
            ],

            400 => [
                'state_id'  => '11',
                'name'      => 'Carrancas',
                'ibge_code' => '3114600',
            ],

            401 => [
                'state_id'  => '11',
                'name'      => 'Carvalhópolis',
                'ibge_code' => '3114709',
            ],

            402 => [
                'state_id'  => '11',
                'name'      => 'Carvalhos',
                'ibge_code' => '3114808',
            ],

            403 => [
                'state_id'  => '11',
                'name'      => 'Casa Grande',
                'ibge_code' => '3114907',
            ],

            404 => [
                'state_id'  => '11',
                'name'      => 'Cascalho Rico',
                'ibge_code' => '3115003',
            ],

            405 => [
                'state_id'  => '11',
                'name'      => 'Cássia',
                'ibge_code' => '3115102',
            ],

            406 => [
                'state_id'  => '11',
                'name'      => 'Conceição da Barra de Minas',
                'ibge_code' => '3115201',
            ],

            407 => [
                'state_id'  => '11',
                'name'      => 'Cataguases',
                'ibge_code' => '3115300',
            ],

            408 => [
                'state_id'  => '11',
                'name'      => 'Catas Altas',
                'ibge_code' => '3115359',
            ],

            409 => [
                'state_id'  => '11',
                'name'      => 'Catas Altas da Noruega',
                'ibge_code' => '3115409',
            ],

            410 => [
                'state_id'  => '11',
                'name'      => 'Catuji',
                'ibge_code' => '3115458',
            ],

            411 => [
                'state_id'  => '11',
                'name'      => 'Catuti',
                'ibge_code' => '3115474',
            ],

            412 => [
                'state_id'  => '11',
                'name'      => 'Caxambu',
                'ibge_code' => '3115508',
            ],

            413 => [
                'state_id'  => '11',
                'name'      => 'Cedro do Abaeté',
                'ibge_code' => '3115607',
            ],

            414 => [
                'state_id'  => '11',
                'name'      => 'Central de Minas',
                'ibge_code' => '3115706',
            ],

            415 => [
                'state_id'  => '11',
                'name'      => 'Centralina',
                'ibge_code' => '3115805',
            ],

            416 => [
                'state_id'  => '11',
                'name'      => 'Chácara',
                'ibge_code' => '3115904',
            ],

            417 => [
                'state_id'  => '11',
                'name'      => 'Chalé',
                'ibge_code' => '3116001',
            ],

            418 => [
                'state_id'  => '11',
                'name'      => 'Chapada do Norte',
                'ibge_code' => '3116100',
            ],

            419 => [
                'state_id'  => '11',
                'name'      => 'Chapada Gaúcha',
                'ibge_code' => '3116159',
            ],

            420 => [
                'state_id'  => '11',
                'name'      => 'Chiador',
                'ibge_code' => '3116209',
            ],

            421 => [
                'state_id'  => '11',
                'name'      => 'Cipotânea',
                'ibge_code' => '3116308',
            ],

            422 => [
                'state_id'  => '11',
                'name'      => 'Claraval',
                'ibge_code' => '3116407',
            ],

            423 => [
                'state_id'  => '11',
                'name'      => 'Claro dos Poções',
                'ibge_code' => '3116506',
            ],

            424 => [
                'state_id'  => '11',
                'name'      => 'Cláudio',
                'ibge_code' => '3116605',
            ],

            425 => [
                'state_id'  => '11',
                'name'      => 'Coimbra',
                'ibge_code' => '3116704',
            ],

            426 => [
                'state_id'  => '11',
                'name'      => 'Coluna',
                'ibge_code' => '3116803',
            ],

            427 => [
                'state_id'  => '11',
                'name'      => 'Comendador Gomes',
                'ibge_code' => '3116902',
            ],

            428 => [
                'state_id'  => '11',
                'name'      => 'Comercinho',
                'ibge_code' => '3117009',
            ],

            429 => [
                'state_id'  => '11',
                'name'      => 'Conceição da Aparecida',
                'ibge_code' => '3117108',
            ],

            430 => [
                'state_id'  => '11',
                'name'      => 'Conceição das Pedras',
                'ibge_code' => '3117207',
            ],

            431 => [
                'state_id'  => '11',
                'name'      => 'Conceição das Alagoas',
                'ibge_code' => '3117306',
            ],

            432 => [
                'state_id'  => '11',
                'name'      => 'Conceição de Ipanema',
                'ibge_code' => '3117405',
            ],

            433 => [
                'state_id'  => '11',
                'name'      => 'Conceição do Mato Dentro',
                'ibge_code' => '3117504',
            ],

            434 => [
                'state_id'  => '11',
                'name'      => 'Conceição do Pará',
                'ibge_code' => '3117603',
            ],

            435 => [
                'state_id'  => '11',
                'name'      => 'Conceição do Rio Verde',
                'ibge_code' => '3117702',
            ],

            436 => [
                'state_id'  => '11',
                'name'      => 'Conceição dos Ouros',
                'ibge_code' => '3117801',
            ],

            437 => [
                'state_id'  => '11',
                'name'      => 'Cônego Marinho',
                'ibge_code' => '3117836',
            ],

            438 => [
                'state_id'  => '11',
                'name'      => 'Confins',
                'ibge_code' => '3117876',
            ],

            439 => [
                'state_id'  => '11',
                'name'      => 'Congonhal',
                'ibge_code' => '3117900',
            ],

            440 => [
                'state_id'  => '11',
                'name'      => 'Congonhas',
                'ibge_code' => '3118007',
            ],

            441 => [
                'state_id'  => '11',
                'name'      => 'Congonhas do Norte',
                'ibge_code' => '3118106',
            ],

            442 => [
                'state_id'  => '11',
                'name'      => 'Conquista',
                'ibge_code' => '3118205',
            ],

            443 => [
                'state_id'  => '11',
                'name'      => 'Conselheiro Lafaiete',
                'ibge_code' => '3118304',
            ],

            444 => [
                'state_id'  => '11',
                'name'      => 'Conselheiro Pena',
                'ibge_code' => '3118403',
            ],

            445 => [
                'state_id'  => '11',
                'name'      => 'Consolação',
                'ibge_code' => '3118502',
            ],

            446 => [
                'state_id'  => '11',
                'name'      => 'Contagem',
                'ibge_code' => '3118601',
            ],

            447 => [
                'state_id'  => '11',
                'name'      => 'Coqueiral',
                'ibge_code' => '3118700',
            ],

            448 => [
                'state_id'  => '11',
                'name'      => 'Coração de Jesus',
                'ibge_code' => '3118809',
            ],

            449 => [
                'state_id'  => '11',
                'name'      => 'Cordisburgo',
                'ibge_code' => '3118908',
            ],

            450 => [
                'state_id'  => '11',
                'name'      => 'Cordislândia',
                'ibge_code' => '3119005',
            ],

            451 => [
                'state_id'  => '11',
                'name'      => 'Corinto',
                'ibge_code' => '3119104',
            ],

            452 => [
                'state_id'  => '11',
                'name'      => 'Coroaci',
                'ibge_code' => '3119203',
            ],

            453 => [
                'state_id'  => '11',
                'name'      => 'Coromandel',
                'ibge_code' => '3119302',
            ],

            454 => [
                'state_id'  => '11',
                'name'      => 'Coronel Fabriciano',
                'ibge_code' => '3119401',
            ],

            455 => [
                'state_id'  => '11',
                'name'      => 'Coronel Murta',
                'ibge_code' => '3119500',
            ],

            456 => [
                'state_id'  => '11',
                'name'      => 'Coronel Pacheco',
                'ibge_code' => '3119609',
            ],

            457 => [
                'state_id'  => '11',
                'name'      => 'Coronel Xavier Chaves',
                'ibge_code' => '3119708',
            ],

            458 => [
                'state_id'  => '11',
                'name'      => 'Córrego Danta',
                'ibge_code' => '3119807',
            ],

            459 => [
                'state_id'  => '11',
                'name'      => 'Córrego do Bom Jesus',
                'ibge_code' => '3119906',
            ],

            460 => [
                'state_id'  => '11',
                'name'      => 'Córrego Fundo',
                'ibge_code' => '3119955',
            ],

            461 => [
                'state_id'  => '11',
                'name'      => 'Córrego Novo',
                'ibge_code' => '3120003',
            ],

            462 => [
                'state_id'  => '11',
                'name'      => 'Couto de Magalhães de Minas',
                'ibge_code' => '3120102',
            ],

            463 => [
                'state_id'  => '11',
                'name'      => 'Crisólita',
                'ibge_code' => '3120151',
            ],

            464 => [
                'state_id'  => '11',
                'name'      => 'Cristais',
                'ibge_code' => '3120201',
            ],

            465 => [
                'state_id'  => '11',
                'name'      => 'Cristália',
                'ibge_code' => '3120300',
            ],

            466 => [
                'state_id'  => '11',
                'name'      => 'Cristiano Otoni',
                'ibge_code' => '3120409',
            ],

            467 => [
                'state_id'  => '11',
                'name'      => 'Cristina',
                'ibge_code' => '3120508',
            ],

            468 => [
                'state_id'  => '11',
                'name'      => 'Crucilândia',
                'ibge_code' => '3120607',
            ],

            469 => [
                'state_id'  => '11',
                'name'      => 'Cruzeiro da Fortaleza',
                'ibge_code' => '3120706',
            ],

            470 => [
                'state_id'  => '11',
                'name'      => 'Cruzília',
                'ibge_code' => '3120805',
            ],

            471 => [
                'state_id'  => '11',
                'name'      => 'Cuparaque',
                'ibge_code' => '3120839',
            ],

            472 => [
                'state_id'  => '11',
                'name'      => 'Curral de Dentro',
                'ibge_code' => '3120870',
            ],

            473 => [
                'state_id'  => '11',
                'name'      => 'Curvelo',
                'ibge_code' => '3120904',
            ],

            474 => [
                'state_id'  => '11',
                'name'      => 'Datas',
                'ibge_code' => '3121001',
            ],

            475 => [
                'state_id'  => '11',
                'name'      => 'Delfim Moreira',
                'ibge_code' => '3121100',
            ],

            476 => [
                'state_id'  => '11',
                'name'      => 'Delfinópolis',
                'ibge_code' => '3121209',
            ],

            477 => [
                'state_id'  => '11',
                'name'      => 'Delta',
                'ibge_code' => '3121258',
            ],

            478 => [
                'state_id'  => '11',
                'name'      => 'Descoberto',
                'ibge_code' => '3121308',
            ],

            479 => [
                'state_id'  => '11',
                'name'      => 'Desterro de Entre Rios',
                'ibge_code' => '3121407',
            ],

            480 => [
                'state_id'  => '11',
                'name'      => 'Desterro do Melo',
                'ibge_code' => '3121506',
            ],

            481 => [
                'state_id'  => '11',
                'name'      => 'Diamantina',
                'ibge_code' => '3121605',
            ],

            482 => [
                'state_id'  => '11',
                'name'      => 'Diogo de Vasconcelos',
                'ibge_code' => '3121704',
            ],

            483 => [
                'state_id'  => '11',
                'name'      => 'Dionísio',
                'ibge_code' => '3121803',
            ],

            484 => [
                'state_id'  => '11',
                'name'      => 'Divinésia',
                'ibge_code' => '3121902',
            ],

            485 => [
                'state_id'  => '11',
                'name'      => 'Divino',
                'ibge_code' => '3122009',
            ],

            486 => [
                'state_id'  => '11',
                'name'      => 'Divino das Laranjeiras',
                'ibge_code' => '3122108',
            ],

            487 => [
                'state_id'  => '11',
                'name'      => 'Divinolândia de Minas',
                'ibge_code' => '3122207',
            ],

            488 => [
                'state_id'  => '11',
                'name'      => 'Divinópolis',
                'ibge_code' => '3122306',
            ],

            489 => [
                'state_id'  => '11',
                'name'      => 'Divisa Alegre',
                'ibge_code' => '3122355',
            ],

            490 => [
                'state_id'  => '11',
                'name'      => 'Divisa Nova',
                'ibge_code' => '3122405',
            ],

            491 => [
                'state_id'  => '11',
                'name'      => 'Divisópolis',
                'ibge_code' => '3122454',
            ],

            492 => [
                'state_id'  => '11',
                'name'      => 'Dom Bosco',
                'ibge_code' => '3122470',
            ],

            493 => [
                'state_id'  => '11',
                'name'      => 'Dom Cavati',
                'ibge_code' => '3122504',
            ],

            494 => [
                'state_id'  => '11',
                'name'      => 'Dom Joaquim',
                'ibge_code' => '3122603',
            ],

            495 => [
                'state_id'  => '11',
                'name'      => 'Dom Silvério',
                'ibge_code' => '3122702',
            ],

            496 => [
                'state_id'  => '11',
                'name'      => 'Dom Viçoso',
                'ibge_code' => '3122801',
            ],

            497 => [
                'state_id'  => '11',
                'name'      => 'Dona Eusébia',
                'ibge_code' => '3122900',
            ],

            498 => [
                'state_id'  => '11',
                'name'      => 'Dores de Campos',
                'ibge_code' => '3123007',
            ],

            499 => [
                'state_id'  => '11',
                'name'      => 'Dores de Guanhães',
                'ibge_code' => '3123106',
            ],

        ]);
        DB::table('cities')->insert([
            0 => [
                'state_id'  => '11',
                'name'      => 'Dores do Indaiá',
                'ibge_code' => '3123205',
            ],

            1 => [
                'state_id'  => '11',
                'name'      => 'Dores do Turvo',
                'ibge_code' => '3123304',
            ],

            2 => [
                'state_id'  => '11',
                'name'      => 'Doresópolis',
                'ibge_code' => '3123403',
            ],

            3 => [
                'state_id'  => '11',
                'name'      => 'Douradoquara',
                'ibge_code' => '3123502',
            ],

            4 => [
                'state_id'  => '11',
                'name'      => 'Durandé',
                'ibge_code' => '3123528',
            ],

            5 => [
                'state_id'  => '11',
                'name'      => 'Elói Mendes',
                'ibge_code' => '3123601',
            ],

            6 => [
                'state_id'  => '11',
                'name'      => 'Engenheiro Caldas',
                'ibge_code' => '3123700',
            ],

            7 => [
                'state_id'  => '11',
                'name'      => 'Engenheiro Navarro',
                'ibge_code' => '3123809',
            ],

            8 => [
                'state_id'  => '11',
                'name'      => 'Entre Folhas',
                'ibge_code' => '3123858',
            ],

            9 => [
                'state_id'  => '11',
                'name'      => 'Entre Rios de Minas',
                'ibge_code' => '3123908',
            ],

            10 => [
                'state_id'  => '11',
                'name'      => 'Ervália',
                'ibge_code' => '3124005',
            ],

            11 => [
                'state_id'  => '11',
                'name'      => 'Esmeraldas',
                'ibge_code' => '3124104',
            ],

            12 => [
                'state_id'  => '11',
                'name'      => 'Espera Feliz',
                'ibge_code' => '3124203',
            ],

            13 => [
                'state_id'  => '11',
                'name'      => 'Espinosa',
                'ibge_code' => '3124302',
            ],

            14 => [
                'state_id'  => '11',
                'name'      => 'Espírito Santo do Dourado',
                'ibge_code' => '3124401',
            ],

            15 => [
                'state_id'  => '11',
                'name'      => 'Estiva',
                'ibge_code' => '3124500',
            ],

            16 => [
                'state_id'  => '11',
                'name'      => 'Estrela Dalva',
                'ibge_code' => '3124609',
            ],

            17 => [
                'state_id'  => '11',
                'name'      => 'Estrela do Indaiá',
                'ibge_code' => '3124708',
            ],

            18 => [
                'state_id'  => '11',
                'name'      => 'Estrela do Sul',
                'ibge_code' => '3124807',
            ],

            19 => [
                'state_id'  => '11',
                'name'      => 'Eugenópolis',
                'ibge_code' => '3124906',
            ],

            20 => [
                'state_id'  => '11',
                'name'      => 'Ewbank da Câmara',
                'ibge_code' => '3125002',
            ],

            21 => [
                'state_id'  => '11',
                'name'      => 'Extrema',
                'ibge_code' => '3125101',
            ],

            22 => [
                'state_id'  => '11',
                'name'      => 'Fama',
                'ibge_code' => '3125200',
            ],

            23 => [
                'state_id'  => '11',
                'name'      => 'Faria Lemos',
                'ibge_code' => '3125309',
            ],

            24 => [
                'state_id'  => '11',
                'name'      => 'Felício dos Santos',
                'ibge_code' => '3125408',
            ],

            25 => [
                'state_id'  => '11',
                'name'      => 'São Gonçalo do Rio Preto',
                'ibge_code' => '3125507',
            ],

            26 => [
                'state_id'  => '11',
                'name'      => 'Felisburgo',
                'ibge_code' => '3125606',
            ],

            27 => [
                'state_id'  => '11',
                'name'      => 'Felixlândia',
                'ibge_code' => '3125705',
            ],

            28 => [
                'state_id'  => '11',
                'name'      => 'Fernandes Tourinho',
                'ibge_code' => '3125804',
            ],

            29 => [
                'state_id'  => '11',
                'name'      => 'Ferros',
                'ibge_code' => '3125903',
            ],

            30 => [
                'state_id'  => '11',
                'name'      => 'Fervedouro',
                'ibge_code' => '3125952',
            ],

            31 => [
                'state_id'  => '11',
                'name'      => 'Florestal',
                'ibge_code' => '3126000',
            ],

            32 => [
                'state_id'  => '11',
                'name'      => 'Formiga',
                'ibge_code' => '3126109',
            ],

            33 => [
                'state_id'  => '11',
                'name'      => 'Formoso',
                'ibge_code' => '3126208',
            ],

            34 => [
                'state_id'  => '11',
                'name'      => 'Fortaleza de Minas',
                'ibge_code' => '3126307',
            ],

            35 => [
                'state_id'  => '11',
                'name'      => 'Fortuna de Minas',
                'ibge_code' => '3126406',
            ],

            36 => [
                'state_id'  => '11',
                'name'      => 'Francisco Badaró',
                'ibge_code' => '3126505',
            ],

            37 => [
                'state_id'  => '11',
                'name'      => 'Francisco Dumont',
                'ibge_code' => '3126604',
            ],

            38 => [
                'state_id'  => '11',
                'name'      => 'Francisco Sá',
                'ibge_code' => '3126703',
            ],

            39 => [
                'state_id'  => '11',
                'name'      => 'Franciscópolis',
                'ibge_code' => '3126752',
            ],

            40 => [
                'state_id'  => '11',
                'name'      => 'Frei Gaspar',
                'ibge_code' => '3126802',
            ],

            41 => [
                'state_id'  => '11',
                'name'      => 'Frei Inocêncio',
                'ibge_code' => '3126901',
            ],

            42 => [
                'state_id'  => '11',
                'name'      => 'Frei Lagonegro',
                'ibge_code' => '3126950',
            ],

            43 => [
                'state_id'  => '11',
                'name'      => 'Fronteira',
                'ibge_code' => '3127008',
            ],

            44 => [
                'state_id'  => '11',
                'name'      => 'Fronteira dos Vales',
                'ibge_code' => '3127057',
            ],

            45 => [
                'state_id'  => '11',
                'name'      => 'Fruta de Leite',
                'ibge_code' => '3127073',
            ],

            46 => [
                'state_id'  => '11',
                'name'      => 'Frutal',
                'ibge_code' => '3127107',
            ],

            47 => [
                'state_id'  => '11',
                'name'      => 'Funilândia',
                'ibge_code' => '3127206',
            ],

            48 => [
                'state_id'  => '11',
                'name'      => 'Galiléia',
                'ibge_code' => '3127305',
            ],

            49 => [
                'state_id'  => '11',
                'name'      => 'Gameleiras',
                'ibge_code' => '3127339',
            ],

            50 => [
                'state_id'  => '11',
                'name'      => 'Glaucilândia',
                'ibge_code' => '3127354',
            ],

            51 => [
                'state_id'  => '11',
                'name'      => 'Goiabeira',
                'ibge_code' => '3127370',
            ],

            52 => [
                'state_id'  => '11',
                'name'      => 'Goianá',
                'ibge_code' => '3127388',
            ],

            53 => [
                'state_id'  => '11',
                'name'      => 'Gonçalves',
                'ibge_code' => '3127404',
            ],

            54 => [
                'state_id'  => '11',
                'name'      => 'Gonzaga',
                'ibge_code' => '3127503',
            ],

            55 => [
                'state_id'  => '11',
                'name'      => 'Gouveia',
                'ibge_code' => '3127602',
            ],

            56 => [
                'state_id'  => '11',
                'name'      => 'Governador Valadares',
                'ibge_code' => '3127701',
            ],

            57 => [
                'state_id'  => '11',
                'name'      => 'Grão Mogol',
                'ibge_code' => '3127800',
            ],

            58 => [
                'state_id'  => '11',
                'name'      => 'Grupiara',
                'ibge_code' => '3127909',
            ],

            59 => [
                'state_id'  => '11',
                'name'      => 'Guanhães',
                'ibge_code' => '3128006',
            ],

            60 => [
                'state_id'  => '11',
                'name'      => 'Guapé',
                'ibge_code' => '3128105',
            ],

            61 => [
                'state_id'  => '11',
                'name'      => 'Guaraciaba',
                'ibge_code' => '3128204',
            ],

            62 => [
                'state_id'  => '11',
                'name'      => 'Guaraciama',
                'ibge_code' => '3128253',
            ],

            63 => [
                'state_id'  => '11',
                'name'      => 'Guaranésia',
                'ibge_code' => '3128303',
            ],

            64 => [
                'state_id'  => '11',
                'name'      => 'Guarani',
                'ibge_code' => '3128402',
            ],

            65 => [
                'state_id'  => '11',
                'name'      => 'Guarará',
                'ibge_code' => '3128501',
            ],

            66 => [
                'state_id'  => '11',
                'name'      => 'Guarda-Mor',
                'ibge_code' => '3128600',
            ],

            67 => [
                'state_id'  => '11',
                'name'      => 'Guaxupé',
                'ibge_code' => '3128709',
            ],

            68 => [
                'state_id'  => '11',
                'name'      => 'Guidoval',
                'ibge_code' => '3128808',
            ],

            69 => [
                'state_id'  => '11',
                'name'      => 'Guimarânia',
                'ibge_code' => '3128907',
            ],

            70 => [
                'state_id'  => '11',
                'name'      => 'Guiricema',
                'ibge_code' => '3129004',
            ],

            71 => [
                'state_id'  => '11',
                'name'      => 'Gurinhatã',
                'ibge_code' => '3129103',
            ],

            72 => [
                'state_id'  => '11',
                'name'      => 'Heliodora',
                'ibge_code' => '3129202',
            ],

            73 => [
                'state_id'  => '11',
                'name'      => 'Iapu',
                'ibge_code' => '3129301',
            ],

            74 => [
                'state_id'  => '11',
                'name'      => 'Ibertioga',
                'ibge_code' => '3129400',
            ],

            75 => [
                'state_id'  => '11',
                'name'      => 'Ibiá',
                'ibge_code' => '3129509',
            ],

            76 => [
                'state_id'  => '11',
                'name'      => 'Ibiaí',
                'ibge_code' => '3129608',
            ],

            77 => [
                'state_id'  => '11',
                'name'      => 'Ibiracatu',
                'ibge_code' => '3129657',
            ],

            78 => [
                'state_id'  => '11',
                'name'      => 'Ibiraci',
                'ibge_code' => '3129707',
            ],

            79 => [
                'state_id'  => '11',
                'name'      => 'Ibirité',
                'ibge_code' => '3129806',
            ],

            80 => [
                'state_id'  => '11',
                'name'      => 'Ibitiúra de Minas',
                'ibge_code' => '3129905',
            ],

            81 => [
                'state_id'  => '11',
                'name'      => 'Ibituruna',
                'ibge_code' => '3130002',
            ],

            82 => [
                'state_id'  => '11',
                'name'      => 'Icaraí de Minas',
                'ibge_code' => '3130051',
            ],

            83 => [
                'state_id'  => '11',
                'name'      => 'Igarapé',
                'ibge_code' => '3130101',
            ],

            84 => [
                'state_id'  => '11',
                'name'      => 'Igaratinga',
                'ibge_code' => '3130200',
            ],

            85 => [
                'state_id'  => '11',
                'name'      => 'Iguatama',
                'ibge_code' => '3130309',
            ],

            86 => [
                'state_id'  => '11',
                'name'      => 'Ijaci',
                'ibge_code' => '3130408',
            ],

            87 => [
                'state_id'  => '11',
                'name'      => 'Ilicínea',
                'ibge_code' => '3130507',
            ],

            88 => [
                'state_id'  => '11',
                'name'      => 'Imbé de Minas',
                'ibge_code' => '3130556',
            ],

            89 => [
                'state_id'  => '11',
                'name'      => 'Inconfidentes',
                'ibge_code' => '3130606',
            ],

            90 => [
                'state_id'  => '11',
                'name'      => 'Indaiabira',
                'ibge_code' => '3130655',
            ],

            91 => [
                'state_id'  => '11',
                'name'      => 'Indianópolis',
                'ibge_code' => '3130705',
            ],

            92 => [
                'state_id'  => '11',
                'name'      => 'Ingaí',
                'ibge_code' => '3130804',
            ],

            93 => [
                'state_id'  => '11',
                'name'      => 'Inhapim',
                'ibge_code' => '3130903',
            ],

            94 => [
                'state_id'  => '11',
                'name'      => 'Inhaúma',
                'ibge_code' => '3131000',
            ],

            95 => [
                'state_id'  => '11',
                'name'      => 'Inimutaba',
                'ibge_code' => '3131109',
            ],

            96 => [
                'state_id'  => '11',
                'name'      => 'Ipaba',
                'ibge_code' => '3131158',
            ],

            97 => [
                'state_id'  => '11',
                'name'      => 'Ipanema',
                'ibge_code' => '3131208',
            ],

            98 => [
                'state_id'  => '11',
                'name'      => 'Ipatinga',
                'ibge_code' => '3131307',
            ],

            99 => [
                'state_id'  => '11',
                'name'      => 'Ipiaçu',
                'ibge_code' => '3131406',
            ],

            100 => [
                'state_id'  => '11',
                'name'      => 'Ipuiúna',
                'ibge_code' => '3131505',
            ],

            101 => [
                'state_id'  => '11',
                'name'      => 'Iraí de Minas',
                'ibge_code' => '3131604',
            ],

            102 => [
                'state_id'  => '11',
                'name'      => 'Itabira',
                'ibge_code' => '3131703',
            ],

            103 => [
                'state_id'  => '11',
                'name'      => 'Itabirinha',
                'ibge_code' => '3131802',
            ],

            104 => [
                'state_id'  => '11',
                'name'      => 'Itabirito',
                'ibge_code' => '3131901',
            ],

            105 => [
                'state_id'  => '11',
                'name'      => 'Itacambira',
                'ibge_code' => '3132008',
            ],

            106 => [
                'state_id'  => '11',
                'name'      => 'Itacarambi',
                'ibge_code' => '3132107',
            ],

            107 => [
                'state_id'  => '11',
                'name'      => 'Itaguara',
                'ibge_code' => '3132206',
            ],

            108 => [
                'state_id'  => '11',
                'name'      => 'Itaipé',
                'ibge_code' => '3132305',
            ],

            109 => [
                'state_id'  => '11',
                'name'      => 'Itajubá',
                'ibge_code' => '3132404',
            ],

            110 => [
                'state_id'  => '11',
                'name'      => 'Itamarandiba',
                'ibge_code' => '3132503',
            ],

            111 => [
                'state_id'  => '11',
                'name'      => 'Itamarati de Minas',
                'ibge_code' => '3132602',
            ],

            112 => [
                'state_id'  => '11',
                'name'      => 'Itambacuri',
                'ibge_code' => '3132701',
            ],

            113 => [
                'state_id'  => '11',
                'name'      => 'Itambé do Mato Dentro',
                'ibge_code' => '3132800',
            ],

            114 => [
                'state_id'  => '11',
                'name'      => 'Itamogi',
                'ibge_code' => '3132909',
            ],

            115 => [
                'state_id'  => '11',
                'name'      => 'Itamonte',
                'ibge_code' => '3133006',
            ],

            116 => [
                'state_id'  => '11',
                'name'      => 'Itanhandu',
                'ibge_code' => '3133105',
            ],

            117 => [
                'state_id'  => '11',
                'name'      => 'Itanhomi',
                'ibge_code' => '3133204',
            ],

            118 => [
                'state_id'  => '11',
                'name'      => 'Itaobim',
                'ibge_code' => '3133303',
            ],

            119 => [
                'state_id'  => '11',
                'name'      => 'Itapagipe',
                'ibge_code' => '3133402',
            ],

            120 => [
                'state_id'  => '11',
                'name'      => 'Itapecerica',
                'ibge_code' => '3133501',
            ],

            121 => [
                'state_id'  => '11',
                'name'      => 'Itapeva',
                'ibge_code' => '3133600',
            ],

            122 => [
                'state_id'  => '11',
                'name'      => 'Itatiaiuçu',
                'ibge_code' => '3133709',
            ],

            123 => [
                'state_id'  => '11',
                'name'      => 'Itaú de Minas',
                'ibge_code' => '3133758',
            ],

            124 => [
                'state_id'  => '11',
                'name'      => 'Itaúna',
                'ibge_code' => '3133808',
            ],

            125 => [
                'state_id'  => '11',
                'name'      => 'Itaverava',
                'ibge_code' => '3133907',
            ],

            126 => [
                'state_id'  => '11',
                'name'      => 'Itinga',
                'ibge_code' => '3134004',
            ],

            127 => [
                'state_id'  => '11',
                'name'      => 'Itueta',
                'ibge_code' => '3134103',
            ],

            128 => [
                'state_id'  => '11',
                'name'      => 'Ituiutaba',
                'ibge_code' => '3134202',
            ],

            129 => [
                'state_id'  => '11',
                'name'      => 'Itumirim',
                'ibge_code' => '3134301',
            ],

            130 => [
                'state_id'  => '11',
                'name'      => 'Iturama',
                'ibge_code' => '3134400',
            ],

            131 => [
                'state_id'  => '11',
                'name'      => 'Itutinga',
                'ibge_code' => '3134509',
            ],

            132 => [
                'state_id'  => '11',
                'name'      => 'Jaboticatubas',
                'ibge_code' => '3134608',
            ],

            133 => [
                'state_id'  => '11',
                'name'      => 'Jacinto',
                'ibge_code' => '3134707',
            ],

            134 => [
                'state_id'  => '11',
                'name'      => 'Jacuí',
                'ibge_code' => '3134806',
            ],

            135 => [
                'state_id'  => '11',
                'name'      => 'Jacutinga',
                'ibge_code' => '3134905',
            ],

            136 => [
                'state_id'  => '11',
                'name'      => 'Jaguaraçu',
                'ibge_code' => '3135001',
            ],

            137 => [
                'state_id'  => '11',
                'name'      => 'Jaíba',
                'ibge_code' => '3135050',
            ],

            138 => [
                'state_id'  => '11',
                'name'      => 'Jampruca',
                'ibge_code' => '3135076',
            ],

            139 => [
                'state_id'  => '11',
                'name'      => 'Janaúba',
                'ibge_code' => '3135100',
            ],

            140 => [
                'state_id'  => '11',
                'name'      => 'Januária',
                'ibge_code' => '3135209',
            ],

            141 => [
                'state_id'  => '11',
                'name'      => 'Japaraíba',
                'ibge_code' => '3135308',
            ],

            142 => [
                'state_id'  => '11',
                'name'      => 'Japonvar',
                'ibge_code' => '3135357',
            ],

            143 => [
                'state_id'  => '11',
                'name'      => 'Jeceaba',
                'ibge_code' => '3135407',
            ],

            144 => [
                'state_id'  => '11',
                'name'      => 'Jenipapo de Minas',
                'ibge_code' => '3135456',
            ],

            145 => [
                'state_id'  => '11',
                'name'      => 'Jequeri',
                'ibge_code' => '3135506',
            ],

            146 => [
                'state_id'  => '11',
                'name'      => 'Jequitaí',
                'ibge_code' => '3135605',
            ],

            147 => [
                'state_id'  => '11',
                'name'      => 'Jequitibá',
                'ibge_code' => '3135704',
            ],

            148 => [
                'state_id'  => '11',
                'name'      => 'Jequitinhonha',
                'ibge_code' => '3135803',
            ],

            149 => [
                'state_id'  => '11',
                'name'      => 'Jesuânia',
                'ibge_code' => '3135902',
            ],

            150 => [
                'state_id'  => '11',
                'name'      => 'Joaíma',
                'ibge_code' => '3136009',
            ],

            151 => [
                'state_id'  => '11',
                'name'      => 'Joanésia',
                'ibge_code' => '3136108',
            ],

            152 => [
                'state_id'  => '11',
                'name'      => 'João Monlevade',
                'ibge_code' => '3136207',
            ],

            153 => [
                'state_id'  => '11',
                'name'      => 'João Pinheiro',
                'ibge_code' => '3136306',
            ],

            154 => [
                'state_id'  => '11',
                'name'      => 'Joaquim Felício',
                'ibge_code' => '3136405',
            ],

            155 => [
                'state_id'  => '11',
                'name'      => 'Jordânia',
                'ibge_code' => '3136504',
            ],

            156 => [
                'state_id'  => '11',
                'name'      => 'José Gonçalves de Minas',
                'ibge_code' => '3136520',
            ],

            157 => [
                'state_id'  => '11',
                'name'      => 'José Raydan',
                'ibge_code' => '3136553',
            ],

            158 => [
                'state_id'  => '11',
                'name'      => 'Josenópolis',
                'ibge_code' => '3136579',
            ],

            159 => [
                'state_id'  => '11',
                'name'      => 'Nova União',
                'ibge_code' => '3136603',
            ],

            160 => [
                'state_id'  => '11',
                'name'      => 'Juatuba',
                'ibge_code' => '3136652',
            ],

            161 => [
                'state_id'  => '11',
                'name'      => 'Juiz de Fora',
                'ibge_code' => '3136702',
            ],

            162 => [
                'state_id'  => '11',
                'name'      => 'Juramento',
                'ibge_code' => '3136801',
            ],

            163 => [
                'state_id'  => '11',
                'name'      => 'Juruaia',
                'ibge_code' => '3136900',
            ],

            164 => [
                'state_id'  => '11',
                'name'      => 'Juvenília',
                'ibge_code' => '3136959',
            ],

            165 => [
                'state_id'  => '11',
                'name'      => 'Ladainha',
                'ibge_code' => '3137007',
            ],

            166 => [
                'state_id'  => '11',
                'name'      => 'Lagamar',
                'ibge_code' => '3137106',
            ],

            167 => [
                'state_id'  => '11',
                'name'      => 'Lagoa da Prata',
                'ibge_code' => '3137205',
            ],

            168 => [
                'state_id'  => '11',
                'name'      => 'Lagoa dos Patos',
                'ibge_code' => '3137304',
            ],

            169 => [
                'state_id'  => '11',
                'name'      => 'Lagoa Dourada',
                'ibge_code' => '3137403',
            ],

            170 => [
                'state_id'  => '11',
                'name'      => 'Lagoa Formosa',
                'ibge_code' => '3137502',
            ],

            171 => [
                'state_id'  => '11',
                'name'      => 'Lagoa Grande',
                'ibge_code' => '3137536',
            ],

            172 => [
                'state_id'  => '11',
                'name'      => 'Lagoa Santa',
                'ibge_code' => '3137601',
            ],

            173 => [
                'state_id'  => '11',
                'name'      => 'Lajinha',
                'ibge_code' => '3137700',
            ],

            174 => [
                'state_id'  => '11',
                'name'      => 'Lambari',
                'ibge_code' => '3137809',
            ],

            175 => [
                'state_id'  => '11',
                'name'      => 'Lamim',
                'ibge_code' => '3137908',
            ],

            176 => [
                'state_id'  => '11',
                'name'      => 'Laranjal',
                'ibge_code' => '3138005',
            ],

            177 => [
                'state_id'  => '11',
                'name'      => 'Lassance',
                'ibge_code' => '3138104',
            ],

            178 => [
                'state_id'  => '11',
                'name'      => 'Lavras',
                'ibge_code' => '3138203',
            ],

            179 => [
                'state_id'  => '11',
                'name'      => 'Leandro Ferreira',
                'ibge_code' => '3138302',
            ],

            180 => [
                'state_id'  => '11',
                'name'      => 'Leme do Prado',
                'ibge_code' => '3138351',
            ],

            181 => [
                'state_id'  => '11',
                'name'      => 'Leopoldina',
                'ibge_code' => '3138401',
            ],

            182 => [
                'state_id'  => '11',
                'name'      => 'Liberdade',
                'ibge_code' => '3138500',
            ],

            183 => [
                'state_id'  => '11',
                'name'      => 'Lima Duarte',
                'ibge_code' => '3138609',
            ],

            184 => [
                'state_id'  => '11',
                'name'      => 'Limeira do Oeste',
                'ibge_code' => '3138625',
            ],

            185 => [
                'state_id'  => '11',
                'name'      => 'Lontra',
                'ibge_code' => '3138658',
            ],

            186 => [
                'state_id'  => '11',
                'name'      => 'Luisburgo',
                'ibge_code' => '3138674',
            ],

            187 => [
                'state_id'  => '11',
                'name'      => 'Luislândia',
                'ibge_code' => '3138682',
            ],

            188 => [
                'state_id'  => '11',
                'name'      => 'Luminárias',
                'ibge_code' => '3138708',
            ],

            189 => [
                'state_id'  => '11',
                'name'      => 'Luz',
                'ibge_code' => '3138807',
            ],

            190 => [
                'state_id'  => '11',
                'name'      => 'Machacalis',
                'ibge_code' => '3138906',
            ],

            191 => [
                'state_id'  => '11',
                'name'      => 'Machado',
                'ibge_code' => '3139003',
            ],

            192 => [
                'state_id'  => '11',
                'name'      => 'Madre de Deus de Minas',
                'ibge_code' => '3139102',
            ],

            193 => [
                'state_id'  => '11',
                'name'      => 'Malacacheta',
                'ibge_code' => '3139201',
            ],

            194 => [
                'state_id'  => '11',
                'name'      => 'Mamonas',
                'ibge_code' => '3139250',
            ],

            195 => [
                'state_id'  => '11',
                'name'      => 'Manga',
                'ibge_code' => '3139300',
            ],

            196 => [
                'state_id'  => '11',
                'name'      => 'Manhuaçu',
                'ibge_code' => '3139409',
            ],

            197 => [
                'state_id'  => '11',
                'name'      => 'Manhumirim',
                'ibge_code' => '3139508',
            ],

            198 => [
                'state_id'  => '11',
                'name'      => 'Mantena',
                'ibge_code' => '3139607',
            ],

            199 => [
                'state_id'  => '11',
                'name'      => 'Maravilhas',
                'ibge_code' => '3139706',
            ],

            200 => [
                'state_id'  => '11',
                'name'      => 'Mar de Espanha',
                'ibge_code' => '3139805',
            ],

            201 => [
                'state_id'  => '11',
                'name'      => 'Maria da Fé',
                'ibge_code' => '3139904',
            ],

            202 => [
                'state_id'  => '11',
                'name'      => 'Mariana',
                'ibge_code' => '3140001',
            ],

            203 => [
                'state_id'  => '11',
                'name'      => 'Marilac',
                'ibge_code' => '3140100',
            ],

            204 => [
                'state_id'  => '11',
                'name'      => 'Mário Campos',
                'ibge_code' => '3140159',
            ],

            205 => [
                'state_id'  => '11',
                'name'      => 'Maripá de Minas',
                'ibge_code' => '3140209',
            ],

            206 => [
                'state_id'  => '11',
                'name'      => 'Marliéria',
                'ibge_code' => '3140308',
            ],

            207 => [
                'state_id'  => '11',
                'name'      => 'Marmelópolis',
                'ibge_code' => '3140407',
            ],

            208 => [
                'state_id'  => '11',
                'name'      => 'Martinho Campos',
                'ibge_code' => '3140506',
            ],

            209 => [
                'state_id'  => '11',
                'name'      => 'Martins Soares',
                'ibge_code' => '3140530',
            ],

            210 => [
                'state_id'  => '11',
                'name'      => 'Mata Verde',
                'ibge_code' => '3140555',
            ],

            211 => [
                'state_id'  => '11',
                'name'      => 'Materlândia',
                'ibge_code' => '3140605',
            ],

            212 => [
                'state_id'  => '11',
                'name'      => 'Mateus Leme',
                'ibge_code' => '3140704',
            ],

            213 => [
                'state_id'  => '11',
                'name'      => 'Matias Barbosa',
                'ibge_code' => '3140803',
            ],

            214 => [
                'state_id'  => '11',
                'name'      => 'Matias Cardoso',
                'ibge_code' => '3140852',
            ],

            215 => [
                'state_id'  => '11',
                'name'      => 'Matipó',
                'ibge_code' => '3140902',
            ],

            216 => [
                'state_id'  => '11',
                'name'      => 'Mato Verde',
                'ibge_code' => '3141009',
            ],

            217 => [
                'state_id'  => '11',
                'name'      => 'Matozinhos',
                'ibge_code' => '3141108',
            ],

            218 => [
                'state_id'  => '11',
                'name'      => 'Matutina',
                'ibge_code' => '3141207',
            ],

            219 => [
                'state_id'  => '11',
                'name'      => 'Medeiros',
                'ibge_code' => '3141306',
            ],

            220 => [
                'state_id'  => '11',
                'name'      => 'Medina',
                'ibge_code' => '3141405',
            ],

            221 => [
                'state_id'  => '11',
                'name'      => 'Mendes Pimentel',
                'ibge_code' => '3141504',
            ],

            222 => [
                'state_id'  => '11',
                'name'      => 'Mercês',
                'ibge_code' => '3141603',
            ],

            223 => [
                'state_id'  => '11',
                'name'      => 'Mesquita',
                'ibge_code' => '3141702',
            ],

            224 => [
                'state_id'  => '11',
                'name'      => 'Minas Novas',
                'ibge_code' => '3141801',
            ],

            225 => [
                'state_id'  => '11',
                'name'      => 'Minduri',
                'ibge_code' => '3141900',
            ],

            226 => [
                'state_id'  => '11',
                'name'      => 'Mirabela',
                'ibge_code' => '3142007',
            ],

            227 => [
                'state_id'  => '11',
                'name'      => 'Miradouro',
                'ibge_code' => '3142106',
            ],

            228 => [
                'state_id'  => '11',
                'name'      => 'Miraí',
                'ibge_code' => '3142205',
            ],

            229 => [
                'state_id'  => '11',
                'name'      => 'Miravânia',
                'ibge_code' => '3142254',
            ],

            230 => [
                'state_id'  => '11',
                'name'      => 'Moeda',
                'ibge_code' => '3142304',
            ],

            231 => [
                'state_id'  => '11',
                'name'      => 'Moema',
                'ibge_code' => '3142403',
            ],

            232 => [
                'state_id'  => '11',
                'name'      => 'Monjolos',
                'ibge_code' => '3142502',
            ],

            233 => [
                'state_id'  => '11',
                'name'      => 'Monsenhor Paulo',
                'ibge_code' => '3142601',
            ],

            234 => [
                'state_id'  => '11',
                'name'      => 'Montalvânia',
                'ibge_code' => '3142700',
            ],

            235 => [
                'state_id'  => '11',
                'name'      => 'Monte Alegre de Minas',
                'ibge_code' => '3142809',
            ],

            236 => [
                'state_id'  => '11',
                'name'      => 'Monte Azul',
                'ibge_code' => '3142908',
            ],

            237 => [
                'state_id'  => '11',
                'name'      => 'Monte Belo',
                'ibge_code' => '3143005',
            ],

            238 => [
                'state_id'  => '11',
                'name'      => 'Monte Carmelo',
                'ibge_code' => '3143104',
            ],

            239 => [
                'state_id'  => '11',
                'name'      => 'Monte Formoso',
                'ibge_code' => '3143153',
            ],

            240 => [
                'state_id'  => '11',
                'name'      => 'Monte Santo de Minas',
                'ibge_code' => '3143203',
            ],

            241 => [
                'state_id'  => '11',
                'name'      => 'Montes Claros',
                'ibge_code' => '3143302',
            ],

            242 => [
                'state_id'  => '11',
                'name'      => 'Monte Sião',
                'ibge_code' => '3143401',
            ],

            243 => [
                'state_id'  => '11',
                'name'      => 'Montezuma',
                'ibge_code' => '3143450',
            ],

            244 => [
                'state_id'  => '11',
                'name'      => 'Morada Nova de Minas',
                'ibge_code' => '3143500',
            ],

            245 => [
                'state_id'  => '11',
                'name'      => 'Morro da Garça',
                'ibge_code' => '3143609',
            ],

            246 => [
                'state_id'  => '11',
                'name'      => 'Morro do Pilar',
                'ibge_code' => '3143708',
            ],

            247 => [
                'state_id'  => '11',
                'name'      => 'Munhoz',
                'ibge_code' => '3143807',
            ],

            248 => [
                'state_id'  => '11',
                'name'      => 'Muriaé',
                'ibge_code' => '3143906',
            ],

            249 => [
                'state_id'  => '11',
                'name'      => 'Mutum',
                'ibge_code' => '3144003',
            ],

            250 => [
                'state_id'  => '11',
                'name'      => 'Muzambinho',
                'ibge_code' => '3144102',
            ],

            251 => [
                'state_id'  => '11',
                'name'      => 'Nacip Raydan',
                'ibge_code' => '3144201',
            ],

            252 => [
                'state_id'  => '11',
                'name'      => 'Nanuque',
                'ibge_code' => '3144300',
            ],

            253 => [
                'state_id'  => '11',
                'name'      => 'Naque',
                'ibge_code' => '3144359',
            ],

            254 => [
                'state_id'  => '11',
                'name'      => 'Natalândia',
                'ibge_code' => '3144375',
            ],

            255 => [
                'state_id'  => '11',
                'name'      => 'Natércia',
                'ibge_code' => '3144409',
            ],

            256 => [
                'state_id'  => '11',
                'name'      => 'Nazareno',
                'ibge_code' => '3144508',
            ],

            257 => [
                'state_id'  => '11',
                'name'      => 'Nepomuceno',
                'ibge_code' => '3144607',
            ],

            258 => [
                'state_id'  => '11',
                'name'      => 'Ninheira',
                'ibge_code' => '3144656',
            ],

            259 => [
                'state_id'  => '11',
                'name'      => 'Nova Belém',
                'ibge_code' => '3144672',
            ],

            260 => [
                'state_id'  => '11',
                'name'      => 'Nova Era',
                'ibge_code' => '3144706',
            ],

            261 => [
                'state_id'  => '11',
                'name'      => 'Nova Lima',
                'ibge_code' => '3144805',
            ],

            262 => [
                'state_id'  => '11',
                'name'      => 'Nova Módica',
                'ibge_code' => '3144904',
            ],

            263 => [
                'state_id'  => '11',
                'name'      => 'Nova Ponte',
                'ibge_code' => '3145000',
            ],

            264 => [
                'state_id'  => '11',
                'name'      => 'Nova Porteirinha',
                'ibge_code' => '3145059',
            ],

            265 => [
                'state_id'  => '11',
                'name'      => 'Nova Resende',
                'ibge_code' => '3145109',
            ],

            266 => [
                'state_id'  => '11',
                'name'      => 'Nova Serrana',
                'ibge_code' => '3145208',
            ],

            267 => [
                'state_id'  => '11',
                'name'      => 'Novo Cruzeiro',
                'ibge_code' => '3145307',
            ],

            268 => [
                'state_id'  => '11',
                'name'      => 'Novo Oriente de Minas',
                'ibge_code' => '3145356',
            ],

            269 => [
                'state_id'  => '11',
                'name'      => 'Novorizonte',
                'ibge_code' => '3145372',
            ],

            270 => [
                'state_id'  => '11',
                'name'      => 'Olaria',
                'ibge_code' => '3145406',
            ],

            271 => [
                'state_id'  => '11',
                'name'      => "Olhos-D'água",
                'ibge_code' => '3145455',
            ],

            272 => [
                'state_id'  => '11',
                'name'      => 'Olímpio Noronha',
                'ibge_code' => '3145505',
            ],

            273 => [
                'state_id'  => '11',
                'name'      => 'Oliveira',
                'ibge_code' => '3145604',
            ],

            274 => [
                'state_id'  => '11',
                'name'      => 'Oliveira Fortes',
                'ibge_code' => '3145703',
            ],

            275 => [
                'state_id'  => '11',
                'name'      => 'Onça de Pitangui',
                'ibge_code' => '3145802',
            ],

            276 => [
                'state_id'  => '11',
                'name'      => 'Oratórios',
                'ibge_code' => '3145851',
            ],

            277 => [
                'state_id'  => '11',
                'name'      => 'Orizânia',
                'ibge_code' => '3145877',
            ],

            278 => [
                'state_id'  => '11',
                'name'      => 'Ouro Branco',
                'ibge_code' => '3145901',
            ],

            279 => [
                'state_id'  => '11',
                'name'      => 'Ouro Fino',
                'ibge_code' => '3146008',
            ],

            280 => [
                'state_id'  => '11',
                'name'      => 'Ouro Preto',
                'ibge_code' => '3146107',
            ],

            281 => [
                'state_id'  => '11',
                'name'      => 'Ouro Verde de Minas',
                'ibge_code' => '3146206',
            ],

            282 => [
                'state_id'  => '11',
                'name'      => 'Padre Carvalho',
                'ibge_code' => '3146255',
            ],

            283 => [
                'state_id'  => '11',
                'name'      => 'Padre Paraíso',
                'ibge_code' => '3146305',
            ],

            284 => [
                'state_id'  => '11',
                'name'      => 'Paineiras',
                'ibge_code' => '3146404',
            ],

            285 => [
                'state_id'  => '11',
                'name'      => 'Pains',
                'ibge_code' => '3146503',
            ],

            286 => [
                'state_id'  => '11',
                'name'      => 'Pai Pedro',
                'ibge_code' => '3146552',
            ],

            287 => [
                'state_id'  => '11',
                'name'      => 'Paiva',
                'ibge_code' => '3146602',
            ],

            288 => [
                'state_id'  => '11',
                'name'      => 'Palma',
                'ibge_code' => '3146701',
            ],

            289 => [
                'state_id'  => '11',
                'name'      => 'Palmópolis',
                'ibge_code' => '3146750',
            ],

            290 => [
                'state_id'  => '11',
                'name'      => 'Papagaios',
                'ibge_code' => '3146909',
            ],

            291 => [
                'state_id'  => '11',
                'name'      => 'Paracatu',
                'ibge_code' => '3147006',
            ],

            292 => [
                'state_id'  => '11',
                'name'      => 'Pará de Minas',
                'ibge_code' => '3147105',
            ],

            293 => [
                'state_id'  => '11',
                'name'      => 'Paraguaçu',
                'ibge_code' => '3147204',
            ],

            294 => [
                'state_id'  => '11',
                'name'      => 'Paraisópolis',
                'ibge_code' => '3147303',
            ],

            295 => [
                'state_id'  => '11',
                'name'      => 'Paraopeba',
                'ibge_code' => '3147402',
            ],

            296 => [
                'state_id'  => '11',
                'name'      => 'Passabém',
                'ibge_code' => '3147501',
            ],

            297 => [
                'state_id'  => '11',
                'name'      => 'Passa Quatro',
                'ibge_code' => '3147600',
            ],

            298 => [
                'state_id'  => '11',
                'name'      => 'Passa Tempo',
                'ibge_code' => '3147709',
            ],

            299 => [
                'state_id'  => '11',
                'name'      => 'Passa-Vinte',
                'ibge_code' => '3147808',
            ],

            300 => [
                'state_id'  => '11',
                'name'      => 'Passos',
                'ibge_code' => '3147907',
            ],

            301 => [
                'state_id'  => '11',
                'name'      => 'Patis',
                'ibge_code' => '3147956',
            ],

            302 => [
                'state_id'  => '11',
                'name'      => 'Patos de Minas',
                'ibge_code' => '3148004',
            ],

            303 => [
                'state_id'  => '11',
                'name'      => 'Patrocínio',
                'ibge_code' => '3148103',
            ],

            304 => [
                'state_id'  => '11',
                'name'      => 'Patrocínio do Muriaé',
                'ibge_code' => '3148202',
            ],

            305 => [
                'state_id'  => '11',
                'name'      => 'Paula Cândido',
                'ibge_code' => '3148301',
            ],

            306 => [
                'state_id'  => '11',
                'name'      => 'Paulistas',
                'ibge_code' => '3148400',
            ],

            307 => [
                'state_id'  => '11',
                'name'      => 'Pavão',
                'ibge_code' => '3148509',
            ],

            308 => [
                'state_id'  => '11',
                'name'      => 'Peçanha',
                'ibge_code' => '3148608',
            ],

            309 => [
                'state_id'  => '11',
                'name'      => 'Pedra Azul',
                'ibge_code' => '3148707',
            ],

            310 => [
                'state_id'  => '11',
                'name'      => 'Pedra Bonita',
                'ibge_code' => '3148756',
            ],

            311 => [
                'state_id'  => '11',
                'name'      => 'Pedra do Anta',
                'ibge_code' => '3148806',
            ],

            312 => [
                'state_id'  => '11',
                'name'      => 'Pedra do Indaiá',
                'ibge_code' => '3148905',
            ],

            313 => [
                'state_id'  => '11',
                'name'      => 'Pedra Dourada',
                'ibge_code' => '3149002',
            ],

            314 => [
                'state_id'  => '11',
                'name'      => 'Pedralva',
                'ibge_code' => '3149101',
            ],

            315 => [
                'state_id'  => '11',
                'name'      => 'Pedras de Maria da Cruz',
                'ibge_code' => '3149150',
            ],

            316 => [
                'state_id'  => '11',
                'name'      => 'Pedrinópolis',
                'ibge_code' => '3149200',
            ],

            317 => [
                'state_id'  => '11',
                'name'      => 'Pedro Leopoldo',
                'ibge_code' => '3149309',
            ],

            318 => [
                'state_id'  => '11',
                'name'      => 'Pedro Teixeira',
                'ibge_code' => '3149408',
            ],

            319 => [
                'state_id'  => '11',
                'name'      => 'Pequeri',
                'ibge_code' => '3149507',
            ],

            320 => [
                'state_id'  => '11',
                'name'      => 'Pequi',
                'ibge_code' => '3149606',
            ],

            321 => [
                'state_id'  => '11',
                'name'      => 'Perdigão',
                'ibge_code' => '3149705',
            ],

            322 => [
                'state_id'  => '11',
                'name'      => 'Perdizes',
                'ibge_code' => '3149804',
            ],

            323 => [
                'state_id'  => '11',
                'name'      => 'Perdões',
                'ibge_code' => '3149903',
            ],

            324 => [
                'state_id'  => '11',
                'name'      => 'Periquito',
                'ibge_code' => '3149952',
            ],

            325 => [
                'state_id'  => '11',
                'name'      => 'Pescador',
                'ibge_code' => '3150000',
            ],

            326 => [
                'state_id'  => '11',
                'name'      => 'Piau',
                'ibge_code' => '3150109',
            ],

            327 => [
                'state_id'  => '11',
                'name'      => 'Piedade de Caratinga',
                'ibge_code' => '3150158',
            ],

            328 => [
                'state_id'  => '11',
                'name'      => 'Piedade de Ponte Nova',
                'ibge_code' => '3150208',
            ],

            329 => [
                'state_id'  => '11',
                'name'      => 'Piedade do Rio Grande',
                'ibge_code' => '3150307',
            ],

            330 => [
                'state_id'  => '11',
                'name'      => 'Piedade dos Gerais',
                'ibge_code' => '3150406',
            ],

            331 => [
                'state_id'  => '11',
                'name'      => 'Pimenta',
                'ibge_code' => '3150505',
            ],

            332 => [
                'state_id'  => '11',
                'name'      => "Pingo-D'água",
                'ibge_code' => '3150539',
            ],

            333 => [
                'state_id'  => '11',
                'name'      => 'Pintópolis',
                'ibge_code' => '3150570',
            ],

            334 => [
                'state_id'  => '11',
                'name'      => 'Piracema',
                'ibge_code' => '3150604',
            ],

            335 => [
                'state_id'  => '11',
                'name'      => 'Pirajuba',
                'ibge_code' => '3150703',
            ],

            336 => [
                'state_id'  => '11',
                'name'      => 'Piranga',
                'ibge_code' => '3150802',
            ],

            337 => [
                'state_id'  => '11',
                'name'      => 'Piranguçu',
                'ibge_code' => '3150901',
            ],

            338 => [
                'state_id'  => '11',
                'name'      => 'Piranguinho',
                'ibge_code' => '3151008',
            ],

            339 => [
                'state_id'  => '11',
                'name'      => 'Pirapetinga',
                'ibge_code' => '3151107',
            ],

            340 => [
                'state_id'  => '11',
                'name'      => 'Pirapora',
                'ibge_code' => '3151206',
            ],

            341 => [
                'state_id'  => '11',
                'name'      => 'Piraúba',
                'ibge_code' => '3151305',
            ],

            342 => [
                'state_id'  => '11',
                'name'      => 'Pitangui',
                'ibge_code' => '3151404',
            ],

            343 => [
                'state_id'  => '11',
                'name'      => 'Piumhi',
                'ibge_code' => '3151503',
            ],

            344 => [
                'state_id'  => '11',
                'name'      => 'Planura',
                'ibge_code' => '3151602',
            ],

            345 => [
                'state_id'  => '11',
                'name'      => 'Poço Fundo',
                'ibge_code' => '3151701',
            ],

            346 => [
                'state_id'  => '11',
                'name'      => 'Poços de Caldas',
                'ibge_code' => '3151800',
            ],

            347 => [
                'state_id'  => '11',
                'name'      => 'Pocrane',
                'ibge_code' => '3151909',
            ],

            348 => [
                'state_id'  => '11',
                'name'      => 'Pompéu',
                'ibge_code' => '3152006',
            ],

            349 => [
                'state_id'  => '11',
                'name'      => 'Ponte Nova',
                'ibge_code' => '3152105',
            ],

            350 => [
                'state_id'  => '11',
                'name'      => 'Ponto Chique',
                'ibge_code' => '3152131',
            ],

            351 => [
                'state_id'  => '11',
                'name'      => 'Ponto dos Volantes',
                'ibge_code' => '3152170',
            ],

            352 => [
                'state_id'  => '11',
                'name'      => 'Porteirinha',
                'ibge_code' => '3152204',
            ],

            353 => [
                'state_id'  => '11',
                'name'      => 'Porto Firme',
                'ibge_code' => '3152303',
            ],

            354 => [
                'state_id'  => '11',
                'name'      => 'Poté',
                'ibge_code' => '3152402',
            ],

            355 => [
                'state_id'  => '11',
                'name'      => 'Pouso Alegre',
                'ibge_code' => '3152501',
            ],

            356 => [
                'state_id'  => '11',
                'name'      => 'Pouso Alto',
                'ibge_code' => '3152600',
            ],

            357 => [
                'state_id'  => '11',
                'name'      => 'Prados',
                'ibge_code' => '3152709',
            ],

            358 => [
                'state_id'  => '11',
                'name'      => 'Prata',
                'ibge_code' => '3152808',
            ],

            359 => [
                'state_id'  => '11',
                'name'      => 'Pratápolis',
                'ibge_code' => '3152907',
            ],

            360 => [
                'state_id'  => '11',
                'name'      => 'Pratinha',
                'ibge_code' => '3153004',
            ],

            361 => [
                'state_id'  => '11',
                'name'      => 'Presidente Bernardes',
                'ibge_code' => '3153103',
            ],

            362 => [
                'state_id'  => '11',
                'name'      => 'Presidente Juscelino',
                'ibge_code' => '3153202',
            ],

            363 => [
                'state_id'  => '11',
                'name'      => 'Presidente Kubitschek',
                'ibge_code' => '3153301',
            ],

            364 => [
                'state_id'  => '11',
                'name'      => 'Presidente Olegário',
                'ibge_code' => '3153400',
            ],

            365 => [
                'state_id'  => '11',
                'name'      => 'Alto Jequitibá',
                'ibge_code' => '3153509',
            ],

            366 => [
                'state_id'  => '11',
                'name'      => 'Prudente de Morais',
                'ibge_code' => '3153608',
            ],

            367 => [
                'state_id'  => '11',
                'name'      => 'Quartel Geral',
                'ibge_code' => '3153707',
            ],

            368 => [
                'state_id'  => '11',
                'name'      => 'Queluzito',
                'ibge_code' => '3153806',
            ],

            369 => [
                'state_id'  => '11',
                'name'      => 'Raposos',
                'ibge_code' => '3153905',
            ],

            370 => [
                'state_id'  => '11',
                'name'      => 'Raul Soares',
                'ibge_code' => '3154002',
            ],

            371 => [
                'state_id'  => '11',
                'name'      => 'Recreio',
                'ibge_code' => '3154101',
            ],

            372 => [
                'state_id'  => '11',
                'name'      => 'Reduto',
                'ibge_code' => '3154150',
            ],

            373 => [
                'state_id'  => '11',
                'name'      => 'Resende Costa',
                'ibge_code' => '3154200',
            ],

            374 => [
                'state_id'  => '11',
                'name'      => 'Resplendor',
                'ibge_code' => '3154309',
            ],

            375 => [
                'state_id'  => '11',
                'name'      => 'Ressaquinha',
                'ibge_code' => '3154408',
            ],

            376 => [
                'state_id'  => '11',
                'name'      => 'Riachinho',
                'ibge_code' => '3154457',
            ],

            377 => [
                'state_id'  => '11',
                'name'      => 'Riacho dos Machados',
                'ibge_code' => '3154507',
            ],

            378 => [
                'state_id'  => '11',
                'name'      => 'Ribeirão das Neves',
                'ibge_code' => '3154606',
            ],

            379 => [
                'state_id'  => '11',
                'name'      => 'Ribeirão Vermelho',
                'ibge_code' => '3154705',
            ],

            380 => [
                'state_id'  => '11',
                'name'      => 'Rio Acima',
                'ibge_code' => '3154804',
            ],

            381 => [
                'state_id'  => '11',
                'name'      => 'Rio Casca',
                'ibge_code' => '3154903',
            ],

            382 => [
                'state_id'  => '11',
                'name'      => 'Rio Doce',
                'ibge_code' => '3155009',
            ],

            383 => [
                'state_id'  => '11',
                'name'      => 'Rio do Prado',
                'ibge_code' => '3155108',
            ],

            384 => [
                'state_id'  => '11',
                'name'      => 'Rio Espera',
                'ibge_code' => '3155207',
            ],

            385 => [
                'state_id'  => '11',
                'name'      => 'Rio Manso',
                'ibge_code' => '3155306',
            ],

            386 => [
                'state_id'  => '11',
                'name'      => 'Rio Novo',
                'ibge_code' => '3155405',
            ],

            387 => [
                'state_id'  => '11',
                'name'      => 'Rio Paranaíba',
                'ibge_code' => '3155504',
            ],

            388 => [
                'state_id'  => '11',
                'name'      => 'Rio Pardo de Minas',
                'ibge_code' => '3155603',
            ],

            389 => [
                'state_id'  => '11',
                'name'      => 'Rio Piracicaba',
                'ibge_code' => '3155702',
            ],

            390 => [
                'state_id'  => '11',
                'name'      => 'Rio Pomba',
                'ibge_code' => '3155801',
            ],

            391 => [
                'state_id'  => '11',
                'name'      => 'Rio Preto',
                'ibge_code' => '3155900',
            ],

            392 => [
                'state_id'  => '11',
                'name'      => 'Rio Vermelho',
                'ibge_code' => '3156007',
            ],

            393 => [
                'state_id'  => '11',
                'name'      => 'Ritápolis',
                'ibge_code' => '3156106',
            ],

            394 => [
                'state_id'  => '11',
                'name'      => 'Rochedo de Minas',
                'ibge_code' => '3156205',
            ],

            395 => [
                'state_id'  => '11',
                'name'      => 'Rodeiro',
                'ibge_code' => '3156304',
            ],

            396 => [
                'state_id'  => '11',
                'name'      => 'Romaria',
                'ibge_code' => '3156403',
            ],

            397 => [
                'state_id'  => '11',
                'name'      => 'Rosário da Limeira',
                'ibge_code' => '3156452',
            ],

            398 => [
                'state_id'  => '11',
                'name'      => 'Rubelita',
                'ibge_code' => '3156502',
            ],

            399 => [
                'state_id'  => '11',
                'name'      => 'Rubim',
                'ibge_code' => '3156601',
            ],

            400 => [
                'state_id'  => '11',
                'name'      => 'Sabará',
                'ibge_code' => '3156700',
            ],

            401 => [
                'state_id'  => '11',
                'name'      => 'Sabinópolis',
                'ibge_code' => '3156809',
            ],

            402 => [
                'state_id'  => '11',
                'name'      => 'Sacramento',
                'ibge_code' => '3156908',
            ],

            403 => [
                'state_id'  => '11',
                'name'      => 'Salinas',
                'ibge_code' => '3157005',
            ],

            404 => [
                'state_id'  => '11',
                'name'      => 'Salto da Divisa',
                'ibge_code' => '3157104',
            ],

            405 => [
                'state_id'  => '11',
                'name'      => 'Santa Bárbara',
                'ibge_code' => '3157203',
            ],

            406 => [
                'state_id'  => '11',
                'name'      => 'Santa Bárbara do Leste',
                'ibge_code' => '3157252',
            ],

            407 => [
                'state_id'  => '11',
                'name'      => 'Santa Bárbara do Monte Verde',
                'ibge_code' => '3157278',
            ],

            408 => [
                'state_id'  => '11',
                'name'      => 'Santa Bárbara do Tugúrio',
                'ibge_code' => '3157302',
            ],

            409 => [
                'state_id'  => '11',
                'name'      => 'Santa Cruz de Minas',
                'ibge_code' => '3157336',
            ],

            410 => [
                'state_id'  => '11',
                'name'      => 'Santa Cruz de Salinas',
                'ibge_code' => '3157377',
            ],

            411 => [
                'state_id'  => '11',
                'name'      => 'Santa Cruz do Escalvado',
                'ibge_code' => '3157401',
            ],

            412 => [
                'state_id'  => '11',
                'name'      => 'Santa Efigênia de Minas',
                'ibge_code' => '3157500',
            ],

            413 => [
                'state_id'  => '11',
                'name'      => 'Santa Fé de Minas',
                'ibge_code' => '3157609',
            ],

            414 => [
                'state_id'  => '11',
                'name'      => 'Santa Helena de Minas',
                'ibge_code' => '3157658',
            ],

            415 => [
                'state_id'  => '11',
                'name'      => 'Santa Juliana',
                'ibge_code' => '3157708',
            ],

            416 => [
                'state_id'  => '11',
                'name'      => 'Santa Luzia',
                'ibge_code' => '3157807',
            ],

            417 => [
                'state_id'  => '11',
                'name'      => 'Santa Margarida',
                'ibge_code' => '3157906',
            ],

            418 => [
                'state_id'  => '11',
                'name'      => 'Santa Maria de Itabira',
                'ibge_code' => '3158003',
            ],

            419 => [
                'state_id'  => '11',
                'name'      => 'Santa Maria do Salto',
                'ibge_code' => '3158102',
            ],

            420 => [
                'state_id'  => '11',
                'name'      => 'Santa Maria do Suaçuí',
                'ibge_code' => '3158201',
            ],

            421 => [
                'state_id'  => '11',
                'name'      => 'Santana da Vargem',
                'ibge_code' => '3158300',
            ],

            422 => [
                'state_id'  => '11',
                'name'      => 'Santana de Cataguases',
                'ibge_code' => '3158409',
            ],

            423 => [
                'state_id'  => '11',
                'name'      => 'Santana de Pirapama',
                'ibge_code' => '3158508',
            ],

            424 => [
                'state_id'  => '11',
                'name'      => 'Santana do Deserto',
                'ibge_code' => '3158607',
            ],

            425 => [
                'state_id'  => '11',
                'name'      => 'Santana do Garambéu',
                'ibge_code' => '3158706',
            ],

            426 => [
                'state_id'  => '11',
                'name'      => 'Santana do Jacaré',
                'ibge_code' => '3158805',
            ],

            427 => [
                'state_id'  => '11',
                'name'      => 'Santana do Manhuaçu',
                'ibge_code' => '3158904',
            ],

            428 => [
                'state_id'  => '11',
                'name'      => 'Santana do Paraíso',
                'ibge_code' => '3158953',
            ],

            429 => [
                'state_id'  => '11',
                'name'      => 'Santana do Riacho',
                'ibge_code' => '3159001',
            ],

            430 => [
                'state_id'  => '11',
                'name'      => 'Santana dos Montes',
                'ibge_code' => '3159100',
            ],

            431 => [
                'state_id'  => '11',
                'name'      => 'Santa Rita de Caldas',
                'ibge_code' => '3159209',
            ],

            432 => [
                'state_id'  => '11',
                'name'      => 'Santa Rita de Jacutinga',
                'ibge_code' => '3159308',
            ],

            433 => [
                'state_id'  => '11',
                'name'      => 'Santa Rita de Minas',
                'ibge_code' => '3159357',
            ],

            434 => [
                'state_id'  => '11',
                'name'      => 'Santa Rita de Ibitipoca',
                'ibge_code' => '3159407',
            ],

            435 => [
                'state_id'  => '11',
                'name'      => 'Santa Rita do Itueto',
                'ibge_code' => '3159506',
            ],

            436 => [
                'state_id'  => '11',
                'name'      => 'Santa Rita do Sapucaí',
                'ibge_code' => '3159605',
            ],

            437 => [
                'state_id'  => '11',
                'name'      => 'Santa Rosa da Serra',
                'ibge_code' => '3159704',
            ],

            438 => [
                'state_id'  => '11',
                'name'      => 'Santa Vitória',
                'ibge_code' => '3159803',
            ],

            439 => [
                'state_id'  => '11',
                'name'      => 'Santo Antônio do Amparo',
                'ibge_code' => '3159902',
            ],

            440 => [
                'state_id'  => '11',
                'name'      => 'Santo Antônio do Aventureiro',
                'ibge_code' => '3160009',
            ],

            441 => [
                'state_id'  => '11',
                'name'      => 'Santo Antônio do Grama',
                'ibge_code' => '3160108',
            ],

            442 => [
                'state_id'  => '11',
                'name'      => 'Santo Antônio do Itambé',
                'ibge_code' => '3160207',
            ],

            443 => [
                'state_id'  => '11',
                'name'      => 'Santo Antônio do Jacinto',
                'ibge_code' => '3160306',
            ],

            444 => [
                'state_id'  => '11',
                'name'      => 'Santo Antônio do Monte',
                'ibge_code' => '3160405',
            ],

            445 => [
                'state_id'  => '11',
                'name'      => 'Santo Antônio do Retiro',
                'ibge_code' => '3160454',
            ],

            446 => [
                'state_id'  => '11',
                'name'      => 'Santo Antônio do Rio Abaixo',
                'ibge_code' => '3160504',
            ],

            447 => [
                'state_id'  => '11',
                'name'      => 'Santo Hipólito',
                'ibge_code' => '3160603',
            ],

            448 => [
                'state_id'  => '11',
                'name'      => 'Santos Dumont',
                'ibge_code' => '3160702',
            ],

            449 => [
                'state_id'  => '11',
                'name'      => 'São Bento Abade',
                'ibge_code' => '3160801',
            ],

            450 => [
                'state_id'  => '11',
                'name'      => 'São Brás do Suaçuí',
                'ibge_code' => '3160900',
            ],

            451 => [
                'state_id'  => '11',
                'name'      => 'São Domingos das Dores',
                'ibge_code' => '3160959',
            ],

            452 => [
                'state_id'  => '11',
                'name'      => 'São Domingos do Prata',
                'ibge_code' => '3161007',
            ],

            453 => [
                'state_id'  => '11',
                'name'      => 'São Félix de Minas',
                'ibge_code' => '3161056',
            ],

            454 => [
                'state_id'  => '11',
                'name'      => 'São Francisco',
                'ibge_code' => '3161106',
            ],

            455 => [
                'state_id'  => '11',
                'name'      => 'São Francisco de Paula',
                'ibge_code' => '3161205',
            ],

            456 => [
                'state_id'  => '11',
                'name'      => 'São Francisco de Sales',
                'ibge_code' => '3161304',
            ],

            457 => [
                'state_id'  => '11',
                'name'      => 'São Francisco do Glória',
                'ibge_code' => '3161403',
            ],

            458 => [
                'state_id'  => '11',
                'name'      => 'São Geraldo',
                'ibge_code' => '3161502',
            ],

            459 => [
                'state_id'  => '11',
                'name'      => 'São Geraldo da Piedade',
                'ibge_code' => '3161601',
            ],

            460 => [
                'state_id'  => '11',
                'name'      => 'São Geraldo do Baixio',
                'ibge_code' => '3161650',
            ],

            461 => [
                'state_id'  => '11',
                'name'      => 'São Gonçalo do Abaeté',
                'ibge_code' => '3161700',
            ],

            462 => [
                'state_id'  => '11',
                'name'      => 'São Gonçalo do Pará',
                'ibge_code' => '3161809',
            ],

            463 => [
                'state_id'  => '11',
                'name'      => 'São Gonçalo do Rio Abaixo',
                'ibge_code' => '3161908',
            ],

            464 => [
                'state_id'  => '11',
                'name'      => 'São Gonçalo do Sapucaí',
                'ibge_code' => '3162005',
            ],

            465 => [
                'state_id'  => '11',
                'name'      => 'São Gotardo',
                'ibge_code' => '3162104',
            ],

            466 => [
                'state_id'  => '11',
                'name'      => 'São João Batista do Glória',
                'ibge_code' => '3162203',
            ],

            467 => [
                'state_id'  => '11',
                'name'      => 'São João da Lagoa',
                'ibge_code' => '3162252',
            ],

            468 => [
                'state_id'  => '11',
                'name'      => 'São João da Mata',
                'ibge_code' => '3162302',
            ],

            469 => [
                'state_id'  => '11',
                'name'      => 'São João da Ponte',
                'ibge_code' => '3162401',
            ],

            470 => [
                'state_id'  => '11',
                'name'      => 'São João das Missões',
                'ibge_code' => '3162450',
            ],

            471 => [
                'state_id'  => '11',
                'name'      => 'São João Del Rei',
                'ibge_code' => '3162500',
            ],

            472 => [
                'state_id'  => '11',
                'name'      => 'São João do Manhuaçu',
                'ibge_code' => '3162559',
            ],

            473 => [
                'state_id'  => '11',
                'name'      => 'São João do Manteninha',
                'ibge_code' => '3162575',
            ],

            474 => [
                'state_id'  => '11',
                'name'      => 'São João do Oriente',
                'ibge_code' => '3162609',
            ],

            475 => [
                'state_id'  => '11',
                'name'      => 'São João do Pacuí',
                'ibge_code' => '3162658',
            ],

            476 => [
                'state_id'  => '11',
                'name'      => 'São João do Paraíso',
                'ibge_code' => '3162708',
            ],

            477 => [
                'state_id'  => '11',
                'name'      => 'São João Evangelista',
                'ibge_code' => '3162807',
            ],

            478 => [
                'state_id'  => '11',
                'name'      => 'São João Nepomuceno',
                'ibge_code' => '3162906',
            ],

            479 => [
                'state_id'  => '11',
                'name'      => 'São Joaquim de Bicas',
                'ibge_code' => '3162922',
            ],

            480 => [
                'state_id'  => '11',
                'name'      => 'São José da Barra',
                'ibge_code' => '3162948',
            ],

            481 => [
                'state_id'  => '11',
                'name'      => 'São José da Lapa',
                'ibge_code' => '3162955',
            ],

            482 => [
                'state_id'  => '11',
                'name'      => 'São José da Safira',
                'ibge_code' => '3163003',
            ],

            483 => [
                'state_id'  => '11',
                'name'      => 'São José da Varginha',
                'ibge_code' => '3163102',
            ],

            484 => [
                'state_id'  => '11',
                'name'      => 'São José do Alegre',
                'ibge_code' => '3163201',
            ],

            485 => [
                'state_id'  => '11',
                'name'      => 'São José do Divino',
                'ibge_code' => '3163300',
            ],

            486 => [
                'state_id'  => '11',
                'name'      => 'São José do Goiabal',
                'ibge_code' => '3163409',
            ],

            487 => [
                'state_id'  => '11',
                'name'      => 'São José do Jacuri',
                'ibge_code' => '3163508',
            ],

            488 => [
                'state_id'  => '11',
                'name'      => 'São José do Mantimento',
                'ibge_code' => '3163607',
            ],

            489 => [
                'state_id'  => '11',
                'name'      => 'São Lourenço',
                'ibge_code' => '3163706',
            ],

            490 => [
                'state_id'  => '11',
                'name'      => 'São Miguel do Anta',
                'ibge_code' => '3163805',
            ],

            491 => [
                'state_id'  => '11',
                'name'      => 'São Pedro da União',
                'ibge_code' => '3163904',
            ],

            492 => [
                'state_id'  => '11',
                'name'      => 'São Pedro dos Ferros',
                'ibge_code' => '3164001',
            ],

            493 => [
                'state_id'  => '11',
                'name'      => 'São Pedro do Suaçuí',
                'ibge_code' => '3164100',
            ],

            494 => [
                'state_id'  => '11',
                'name'      => 'São Romão',
                'ibge_code' => '3164209',
            ],

            495 => [
                'state_id'  => '11',
                'name'      => 'São Roque de Minas',
                'ibge_code' => '3164308',
            ],

            496 => [
                'state_id'  => '11',
                'name'      => 'São Sebastião da Bela Vista',
                'ibge_code' => '3164407',
            ],

            497 => [
                'state_id'  => '11',
                'name'      => 'São Sebastião da Vargem Alegre',
                'ibge_code' => '3164431',
            ],

            498 => [
                'state_id'  => '11',
                'name'      => 'São Sebastião do Anta',
                'ibge_code' => '3164472',
            ],

            499 => [
                'state_id'  => '11',
                'name'      => 'São Sebastião do Maranhão',
                'ibge_code' => '3164506',
            ],

        ]);
        DB::table('cities')->insert([
            0 => [
                'state_id'  => '11',
                'name'      => 'São Sebastião do Oeste',
                'ibge_code' => '3164605',
            ],

            1 => [
                'state_id'  => '11',
                'name'      => 'São Sebastião do Paraíso',
                'ibge_code' => '3164704',
            ],

            2 => [
                'state_id'  => '11',
                'name'      => 'São Sebastião do Rio Preto',
                'ibge_code' => '3164803',
            ],

            3 => [
                'state_id'  => '11',
                'name'      => 'São Sebastião do Rio Verde',
                'ibge_code' => '3164902',
            ],

            4 => [
                'state_id'  => '11',
                'name'      => 'São Tiago',
                'ibge_code' => '3165008',
            ],

            5 => [
                'state_id'  => '11',
                'name'      => 'São Tomás de Aquino',
                'ibge_code' => '3165107',
            ],

            6 => [
                'state_id'  => '11',
                'name'      => 'São Thomé das Letras',
                'ibge_code' => '3165206',
            ],

            7 => [
                'state_id'  => '11',
                'name'      => 'São Vicente de Minas',
                'ibge_code' => '3165305',
            ],

            8 => [
                'state_id'  => '11',
                'name'      => 'Sapucaí-Mirim',
                'ibge_code' => '3165404',
            ],

            9 => [
                'state_id'  => '11',
                'name'      => 'Sardoá',
                'ibge_code' => '3165503',
            ],

            10 => [
                'state_id'  => '11',
                'name'      => 'Sarzedo',
                'ibge_code' => '3165537',
            ],

            11 => [
                'state_id'  => '11',
                'name'      => 'Setubinha',
                'ibge_code' => '3165552',
            ],

            12 => [
                'state_id'  => '11',
                'name'      => 'Sem-Peixe',
                'ibge_code' => '3165560',
            ],

            13 => [
                'state_id'  => '11',
                'name'      => 'Senador Amaral',
                'ibge_code' => '3165578',
            ],

            14 => [
                'state_id'  => '11',
                'name'      => 'Senador Cortes',
                'ibge_code' => '3165602',
            ],

            15 => [
                'state_id'  => '11',
                'name'      => 'Senador Firmino',
                'ibge_code' => '3165701',
            ],

            16 => [
                'state_id'  => '11',
                'name'      => 'Senador José Bento',
                'ibge_code' => '3165800',
            ],

            17 => [
                'state_id'  => '11',
                'name'      => 'Senador Modestino Gonçalves',
                'ibge_code' => '3165909',
            ],

            18 => [
                'state_id'  => '11',
                'name'      => 'Senhora de Oliveira',
                'ibge_code' => '3166006',
            ],

            19 => [
                'state_id'  => '11',
                'name'      => 'Senhora do Porto',
                'ibge_code' => '3166105',
            ],

            20 => [
                'state_id'  => '11',
                'name'      => 'Senhora dos Remédios',
                'ibge_code' => '3166204',
            ],

            21 => [
                'state_id'  => '11',
                'name'      => 'Sericita',
                'ibge_code' => '3166303',
            ],

            22 => [
                'state_id'  => '11',
                'name'      => 'Seritinga',
                'ibge_code' => '3166402',
            ],

            23 => [
                'state_id'  => '11',
                'name'      => 'Serra Azul de Minas',
                'ibge_code' => '3166501',
            ],

            24 => [
                'state_id'  => '11',
                'name'      => 'Serra da Saudade',
                'ibge_code' => '3166600',
            ],

            25 => [
                'state_id'  => '11',
                'name'      => 'Serra dos Aimorés',
                'ibge_code' => '3166709',
            ],

            26 => [
                'state_id'  => '11',
                'name'      => 'Serra do Salitre',
                'ibge_code' => '3166808',
            ],

            27 => [
                'state_id'  => '11',
                'name'      => 'Serrania',
                'ibge_code' => '3166907',
            ],

            28 => [
                'state_id'  => '11',
                'name'      => 'Serranópolis de Minas',
                'ibge_code' => '3166956',
            ],

            29 => [
                'state_id'  => '11',
                'name'      => 'Serranos',
                'ibge_code' => '3167004',
            ],

            30 => [
                'state_id'  => '11',
                'name'      => 'Serro',
                'ibge_code' => '3167103',
            ],

            31 => [
                'state_id'  => '11',
                'name'      => 'Sete Lagoas',
                'ibge_code' => '3167202',
            ],

            32 => [
                'state_id'  => '11',
                'name'      => 'Silveirânia',
                'ibge_code' => '3167301',
            ],

            33 => [
                'state_id'  => '11',
                'name'      => 'Silvianópolis',
                'ibge_code' => '3167400',
            ],

            34 => [
                'state_id'  => '11',
                'name'      => 'Simão Pereira',
                'ibge_code' => '3167509',
            ],

            35 => [
                'state_id'  => '11',
                'name'      => 'Simonésia',
                'ibge_code' => '3167608',
            ],

            36 => [
                'state_id'  => '11',
                'name'      => 'Sobrália',
                'ibge_code' => '3167707',
            ],

            37 => [
                'state_id'  => '11',
                'name'      => 'Soledade de Minas',
                'ibge_code' => '3167806',
            ],

            38 => [
                'state_id'  => '11',
                'name'      => 'Tabuleiro',
                'ibge_code' => '3167905',
            ],

            39 => [
                'state_id'  => '11',
                'name'      => 'Taiobeiras',
                'ibge_code' => '3168002',
            ],

            40 => [
                'state_id'  => '11',
                'name'      => 'Taparuba',
                'ibge_code' => '3168051',
            ],

            41 => [
                'state_id'  => '11',
                'name'      => 'Tapira',
                'ibge_code' => '3168101',
            ],

            42 => [
                'state_id'  => '11',
                'name'      => 'Tapiraí',
                'ibge_code' => '3168200',
            ],

            43 => [
                'state_id'  => '11',
                'name'      => 'Taquaraçu de Minas',
                'ibge_code' => '3168309',
            ],

            44 => [
                'state_id'  => '11',
                'name'      => 'Tarumirim',
                'ibge_code' => '3168408',
            ],

            45 => [
                'state_id'  => '11',
                'name'      => 'Teixeiras',
                'ibge_code' => '3168507',
            ],

            46 => [
                'state_id'  => '11',
                'name'      => 'Teófilo Otoni',
                'ibge_code' => '3168606',
            ],

            47 => [
                'state_id'  => '11',
                'name'      => 'Timóteo',
                'ibge_code' => '3168705',
            ],

            48 => [
                'state_id'  => '11',
                'name'      => 'Tiradentes',
                'ibge_code' => '3168804',
            ],

            49 => [
                'state_id'  => '11',
                'name'      => 'Tiros',
                'ibge_code' => '3168903',
            ],

            50 => [
                'state_id'  => '11',
                'name'      => 'Tocantins',
                'ibge_code' => '3169000',
            ],

            51 => [
                'state_id'  => '11',
                'name'      => 'Tocos do Moji',
                'ibge_code' => '3169059',
            ],

            52 => [
                'state_id'  => '11',
                'name'      => 'Toledo',
                'ibge_code' => '3169109',
            ],

            53 => [
                'state_id'  => '11',
                'name'      => 'Tombos',
                'ibge_code' => '3169208',
            ],

            54 => [
                'state_id'  => '11',
                'name'      => 'Três Corações',
                'ibge_code' => '3169307',
            ],

            55 => [
                'state_id'  => '11',
                'name'      => 'Três Marias',
                'ibge_code' => '3169356',
            ],

            56 => [
                'state_id'  => '11',
                'name'      => 'Três Pontas',
                'ibge_code' => '3169406',
            ],

            57 => [
                'state_id'  => '11',
                'name'      => 'Tumiritinga',
                'ibge_code' => '3169505',
            ],

            58 => [
                'state_id'  => '11',
                'name'      => 'Tupaciguara',
                'ibge_code' => '3169604',
            ],

            59 => [
                'state_id'  => '11',
                'name'      => 'Turmalina',
                'ibge_code' => '3169703',
            ],

            60 => [
                'state_id'  => '11',
                'name'      => 'Turvolândia',
                'ibge_code' => '3169802',
            ],

            61 => [
                'state_id'  => '11',
                'name'      => 'Ubá',
                'ibge_code' => '3169901',
            ],

            62 => [
                'state_id'  => '11',
                'name'      => 'Ubaí',
                'ibge_code' => '3170008',
            ],

            63 => [
                'state_id'  => '11',
                'name'      => 'Ubaporanga',
                'ibge_code' => '3170057',
            ],

            64 => [
                'state_id'  => '11',
                'name'      => 'Uberaba',
                'ibge_code' => '3170107',
            ],

            65 => [
                'state_id'  => '11',
                'name'      => 'Uberlândia',
                'ibge_code' => '3170206',
            ],

            66 => [
                'state_id'  => '11',
                'name'      => 'Umburatiba',
                'ibge_code' => '3170305',
            ],

            67 => [
                'state_id'  => '11',
                'name'      => 'Unaí',
                'ibge_code' => '3170404',
            ],

            68 => [
                'state_id'  => '11',
                'name'      => 'União de Minas',
                'ibge_code' => '3170438',
            ],

            69 => [
                'state_id'  => '11',
                'name'      => 'Uruana de Minas',
                'ibge_code' => '3170479',
            ],

            70 => [
                'state_id'  => '11',
                'name'      => 'Urucânia',
                'ibge_code' => '3170503',
            ],

            71 => [
                'state_id'  => '11',
                'name'      => 'Urucuia',
                'ibge_code' => '3170529',
            ],

            72 => [
                'state_id'  => '11',
                'name'      => 'Vargem Alegre',
                'ibge_code' => '3170578',
            ],

            73 => [
                'state_id'  => '11',
                'name'      => 'Vargem Bonita',
                'ibge_code' => '3170602',
            ],

            74 => [
                'state_id'  => '11',
                'name'      => 'Vargem Grande do Rio Pardo',
                'ibge_code' => '3170651',
            ],

            75 => [
                'state_id'  => '11',
                'name'      => 'Varginha',
                'ibge_code' => '3170701',
            ],

            76 => [
                'state_id'  => '11',
                'name'      => 'Varjão de Minas',
                'ibge_code' => '3170750',
            ],

            77 => [
                'state_id'  => '11',
                'name'      => 'Várzea da Palma',
                'ibge_code' => '3170800',
            ],

            78 => [
                'state_id'  => '11',
                'name'      => 'Varzelândia',
                'ibge_code' => '3170909',
            ],

            79 => [
                'state_id'  => '11',
                'name'      => 'Vazante',
                'ibge_code' => '3171006',
            ],

            80 => [
                'state_id'  => '11',
                'name'      => 'Verdelândia',
                'ibge_code' => '3171030',
            ],

            81 => [
                'state_id'  => '11',
                'name'      => 'Veredinha',
                'ibge_code' => '3171071',
            ],

            82 => [
                'state_id'  => '11',
                'name'      => 'Veríssimo',
                'ibge_code' => '3171105',
            ],

            83 => [
                'state_id'  => '11',
                'name'      => 'Vermelho Novo',
                'ibge_code' => '3171154',
            ],

            84 => [
                'state_id'  => '11',
                'name'      => 'Vespasiano',
                'ibge_code' => '3171204',
            ],

            85 => [
                'state_id'  => '11',
                'name'      => 'Viçosa',
                'ibge_code' => '3171303',
            ],

            86 => [
                'state_id'  => '11',
                'name'      => 'Vieiras',
                'ibge_code' => '3171402',
            ],

            87 => [
                'state_id'  => '11',
                'name'      => 'Mathias Lobato',
                'ibge_code' => '3171501',
            ],

            88 => [
                'state_id'  => '11',
                'name'      => 'Virgem da Lapa',
                'ibge_code' => '3171600',
            ],

            89 => [
                'state_id'  => '11',
                'name'      => 'Virgínia',
                'ibge_code' => '3171709',
            ],

            90 => [
                'state_id'  => '11',
                'name'      => 'Virginópolis',
                'ibge_code' => '3171808',
            ],

            91 => [
                'state_id'  => '11',
                'name'      => 'Virgolândia',
                'ibge_code' => '3171907',
            ],

            92 => [
                'state_id'  => '11',
                'name'      => 'Visconde do Rio Branco',
                'ibge_code' => '3172004',
            ],

            93 => [
                'state_id'  => '11',
                'name'      => 'Volta Grande',
                'ibge_code' => '3172103',
            ],

            94 => [
                'state_id'  => '11',
                'name'      => 'Wenceslau Braz',
                'ibge_code' => '3172202',
            ],

            95 => [
                'state_id'  => '8',
                'name'      => 'Afonso Cláudio',
                'ibge_code' => '3200102',
            ],

            96 => [
                'state_id'  => '8',
                'name'      => 'Águia Branca',
                'ibge_code' => '3200136',
            ],

            97 => [
                'state_id'  => '8',
                'name'      => 'Água Doce do Norte',
                'ibge_code' => '3200169',
            ],

            98 => [
                'state_id'  => '8',
                'name'      => 'Alegre',
                'ibge_code' => '3200201',
            ],

            99 => [
                'state_id'  => '8',
                'name'      => 'Alfredo Chaves',
                'ibge_code' => '3200300',
            ],

            100 => [
                'state_id'  => '8',
                'name'      => 'Alto Rio Novo',
                'ibge_code' => '3200359',
            ],

            101 => [
                'state_id'  => '8',
                'name'      => 'Anchieta',
                'ibge_code' => '3200409',
            ],

            102 => [
                'state_id'  => '8',
                'name'      => 'Apiacá',
                'ibge_code' => '3200508',
            ],

            103 => [
                'state_id'  => '8',
                'name'      => 'Aracruz',
                'ibge_code' => '3200607',
            ],

            104 => [
                'state_id'  => '8',
                'name'      => 'Atilio Vivacqua',
                'ibge_code' => '3200706',
            ],

            105 => [
                'state_id'  => '8',
                'name'      => 'Baixo Guandu',
                'ibge_code' => '3200805',
            ],

            106 => [
                'state_id'  => '8',
                'name'      => 'Barra de São Francisco',
                'ibge_code' => '3200904',
            ],

            107 => [
                'state_id'  => '8',
                'name'      => 'Boa Esperança',
                'ibge_code' => '3201001',
            ],

            108 => [
                'state_id'  => '8',
                'name'      => 'Bom Jesus do Norte',
                'ibge_code' => '3201100',
            ],

            109 => [
                'state_id'  => '8',
                'name'      => 'Brejetuba',
                'ibge_code' => '3201159',
            ],

            110 => [
                'state_id'  => '8',
                'name'      => 'Cachoeiro de Itapemirim',
                'ibge_code' => '3201209',
            ],

            111 => [
                'state_id'  => '8',
                'name'      => 'Cariacica',
                'ibge_code' => '3201308',
            ],

            112 => [
                'state_id'  => '8',
                'name'      => 'Castelo',
                'ibge_code' => '3201407',
            ],

            113 => [
                'state_id'  => '8',
                'name'      => 'Colatina',
                'ibge_code' => '3201506',
            ],

            114 => [
                'state_id'  => '8',
                'name'      => 'Conceição da Barra',
                'ibge_code' => '3201605',
            ],

            115 => [
                'state_id'  => '8',
                'name'      => 'Conceição do Castelo',
                'ibge_code' => '3201704',
            ],

            116 => [
                'state_id'  => '8',
                'name'      => 'Divino de São Lourenço',
                'ibge_code' => '3201803',
            ],

            117 => [
                'state_id'  => '8',
                'name'      => 'Domingos Martins',
                'ibge_code' => '3201902',
            ],

            118 => [
                'state_id'  => '8',
                'name'      => 'Dores do Rio Preto',
                'ibge_code' => '3202009',
            ],

            119 => [
                'state_id'  => '8',
                'name'      => 'Ecoporanga',
                'ibge_code' => '3202108',
            ],

            120 => [
                'state_id'  => '8',
                'name'      => 'Fundão',
                'ibge_code' => '3202207',
            ],

            121 => [
                'state_id'  => '8',
                'name'      => 'Governador Lindenberg',
                'ibge_code' => '3202256',
            ],

            122 => [
                'state_id'  => '8',
                'name'      => 'Guaçuí',
                'ibge_code' => '3202306',
            ],

            123 => [
                'state_id'  => '8',
                'name'      => 'Guarapari',
                'ibge_code' => '3202405',
            ],

            124 => [
                'state_id'  => '8',
                'name'      => 'Ibatiba',
                'ibge_code' => '3202454',
            ],

            125 => [
                'state_id'  => '8',
                'name'      => 'Ibiraçu',
                'ibge_code' => '3202504',
            ],

            126 => [
                'state_id'  => '8',
                'name'      => 'Ibitirama',
                'ibge_code' => '3202553',
            ],

            127 => [
                'state_id'  => '8',
                'name'      => 'Iconha',
                'ibge_code' => '3202603',
            ],

            128 => [
                'state_id'  => '8',
                'name'      => 'Irupi',
                'ibge_code' => '3202652',
            ],

            129 => [
                'state_id'  => '8',
                'name'      => 'Itaguaçu',
                'ibge_code' => '3202702',
            ],

            130 => [
                'state_id'  => '8',
                'name'      => 'Itapemirim',
                'ibge_code' => '3202801',
            ],

            131 => [
                'state_id'  => '8',
                'name'      => 'Itarana',
                'ibge_code' => '3202900',
            ],

            132 => [
                'state_id'  => '8',
                'name'      => 'Iúna',
                'ibge_code' => '3203007',
            ],

            133 => [
                'state_id'  => '8',
                'name'      => 'Jaguaré',
                'ibge_code' => '3203056',
            ],

            134 => [
                'state_id'  => '8',
                'name'      => 'Jerônimo Monteiro',
                'ibge_code' => '3203106',
            ],

            135 => [
                'state_id'  => '8',
                'name'      => 'João Neiva',
                'ibge_code' => '3203130',
            ],

            136 => [
                'state_id'  => '8',
                'name'      => 'Laranja da Terra',
                'ibge_code' => '3203163',
            ],

            137 => [
                'state_id'  => '8',
                'name'      => 'Linhares',
                'ibge_code' => '3203205',
            ],

            138 => [
                'state_id'  => '8',
                'name'      => 'Mantenópolis',
                'ibge_code' => '3203304',
            ],

            139 => [
                'state_id'  => '8',
                'name'      => 'Marataízes',
                'ibge_code' => '3203320',
            ],

            140 => [
                'state_id'  => '8',
                'name'      => 'Marechal Floriano',
                'ibge_code' => '3203346',
            ],

            141 => [
                'state_id'  => '8',
                'name'      => 'Marilândia',
                'ibge_code' => '3203353',
            ],

            142 => [
                'state_id'  => '8',
                'name'      => 'Mimoso do Sul',
                'ibge_code' => '3203403',
            ],

            143 => [
                'state_id'  => '8',
                'name'      => 'Montanha',
                'ibge_code' => '3203502',
            ],

            144 => [
                'state_id'  => '8',
                'name'      => 'Mucurici',
                'ibge_code' => '3203601',
            ],

            145 => [
                'state_id'  => '8',
                'name'      => 'Muniz Freire',
                'ibge_code' => '3203700',
            ],

            146 => [
                'state_id'  => '8',
                'name'      => 'Muqui',
                'ibge_code' => '3203809',
            ],

            147 => [
                'state_id'  => '8',
                'name'      => 'Nova Venécia',
                'ibge_code' => '3203908',
            ],

            148 => [
                'state_id'  => '8',
                'name'      => 'Pancas',
                'ibge_code' => '3204005',
            ],

            149 => [
                'state_id'  => '8',
                'name'      => 'Pedro Canário',
                'ibge_code' => '3204054',
            ],

            150 => [
                'state_id'  => '8',
                'name'      => 'Pinheiros',
                'ibge_code' => '3204104',
            ],

            151 => [
                'state_id'  => '8',
                'name'      => 'Piúma',
                'ibge_code' => '3204203',
            ],

            152 => [
                'state_id'  => '8',
                'name'      => 'Ponto Belo',
                'ibge_code' => '3204252',
            ],

            153 => [
                'state_id'  => '8',
                'name'      => 'Presidente Kennedy',
                'ibge_code' => '3204302',
            ],

            154 => [
                'state_id'  => '8',
                'name'      => 'Rio Bananal',
                'ibge_code' => '3204351',
            ],

            155 => [
                'state_id'  => '8',
                'name'      => 'Rio Novo do Sul',
                'ibge_code' => '3204401',
            ],

            156 => [
                'state_id'  => '8',
                'name'      => 'Santa Leopoldina',
                'ibge_code' => '3204500',
            ],

            157 => [
                'state_id'  => '8',
                'name'      => 'Santa Maria de Jetibá',
                'ibge_code' => '3204559',
            ],

            158 => [
                'state_id'  => '8',
                'name'      => 'Santa Teresa',
                'ibge_code' => '3204609',
            ],

            159 => [
                'state_id'  => '8',
                'name'      => 'São Domingos do Norte',
                'ibge_code' => '3204658',
            ],

            160 => [
                'state_id'  => '8',
                'name'      => 'São Gabriel da Palha',
                'ibge_code' => '3204708',
            ],

            161 => [
                'state_id'  => '8',
                'name'      => 'São José do Calçado',
                'ibge_code' => '3204807',
            ],

            162 => [
                'state_id'  => '8',
                'name'      => 'São Mateus',
                'ibge_code' => '3204906',
            ],

            163 => [
                'state_id'  => '8',
                'name'      => 'São Roque do Canaã',
                'ibge_code' => '3204955',
            ],

            164 => [
                'state_id'  => '8',
                'name'      => 'Serra',
                'ibge_code' => '3205002',
            ],

            165 => [
                'state_id'  => '8',
                'name'      => 'Sooretama',
                'ibge_code' => '3205010',
            ],

            166 => [
                'state_id'  => '8',
                'name'      => 'Vargem Alta',
                'ibge_code' => '3205036',
            ],

            167 => [
                'state_id'  => '8',
                'name'      => 'Venda Nova do Imigrante',
                'ibge_code' => '3205069',
            ],

            168 => [
                'state_id'  => '8',
                'name'      => 'Viana',
                'ibge_code' => '3205101',
            ],

            169 => [
                'state_id'  => '8',
                'name'      => 'Vila Pavão',
                'ibge_code' => '3205150',
            ],

            170 => [
                'state_id'  => '8',
                'name'      => 'Vila Valério',
                'ibge_code' => '3205176',
            ],

            171 => [
                'state_id'  => '8',
                'name'      => 'Vila Velha',
                'ibge_code' => '3205200',
            ],

            172 => [
                'state_id'  => '8',
                'name'      => 'Vitória',
                'ibge_code' => '3205309',
            ],

            173 => [
                'state_id'  => '19',
                'name'      => 'Angra dos Reis',
                'ibge_code' => '3300100',
            ],

            174 => [
                'state_id'  => '19',
                'name'      => 'Aperibé',
                'ibge_code' => '3300159',
            ],

            175 => [
                'state_id'  => '19',
                'name'      => 'Araruama',
                'ibge_code' => '3300209',
            ],

            176 => [
                'state_id'  => '19',
                'name'      => 'Areal',
                'ibge_code' => '3300225',
            ],

            177 => [
                'state_id'  => '19',
                'name'      => 'Armação dos Búzios',
                'ibge_code' => '3300233',
            ],

            178 => [
                'state_id'  => '19',
                'name'      => 'Arraial do Cabo',
                'ibge_code' => '3300258',
            ],

            179 => [
                'state_id'  => '19',
                'name'      => 'Barra do Piraí',
                'ibge_code' => '3300308',
            ],

            180 => [
                'state_id'  => '19',
                'name'      => 'Barra Mansa',
                'ibge_code' => '3300407',
            ],

            181 => [
                'state_id'  => '19',
                'name'      => 'Belford Roxo',
                'ibge_code' => '3300456',
            ],

            182 => [
                'state_id'  => '19',
                'name'      => 'Bom Jardim',
                'ibge_code' => '3300506',
            ],

            183 => [
                'state_id'  => '19',
                'name'      => 'Bom Jesus do Itabapoana',
                'ibge_code' => '3300605',
            ],

            184 => [
                'state_id'  => '19',
                'name'      => 'Cabo Frio',
                'ibge_code' => '3300704',
            ],

            185 => [
                'state_id'  => '19',
                'name'      => 'Cachoeiras de Macacu',
                'ibge_code' => '3300803',
            ],

            186 => [
                'state_id'  => '19',
                'name'      => 'Cambuci',
                'ibge_code' => '3300902',
            ],

            187 => [
                'state_id'  => '19',
                'name'      => 'Carapebus',
                'ibge_code' => '3300936',
            ],

            188 => [
                'state_id'  => '19',
                'name'      => 'Comendador Levy Gasparian',
                'ibge_code' => '3300951',
            ],

            189 => [
                'state_id'  => '19',
                'name'      => 'Campos dos Goytacazes',
                'ibge_code' => '3301009',
            ],

            190 => [
                'state_id'  => '19',
                'name'      => 'Cantagalo',
                'ibge_code' => '3301108',
            ],

            191 => [
                'state_id'  => '19',
                'name'      => 'Cardoso Moreira',
                'ibge_code' => '3301157',
            ],

            192 => [
                'state_id'  => '19',
                'name'      => 'Carmo',
                'ibge_code' => '3301207',
            ],

            193 => [
                'state_id'  => '19',
                'name'      => 'Casimiro de Abreu',
                'ibge_code' => '3301306',
            ],

            194 => [
                'state_id'  => '19',
                'name'      => 'Conceição de Macabu',
                'ibge_code' => '3301405',
            ],

            195 => [
                'state_id'  => '19',
                'name'      => 'Cordeiro',
                'ibge_code' => '3301504',
            ],

            196 => [
                'state_id'  => '19',
                'name'      => 'Duas Barras',
                'ibge_code' => '3301603',
            ],

            197 => [
                'state_id'  => '19',
                'name'      => 'Duque de Caxias',
                'ibge_code' => '3301702',
            ],

            198 => [
                'state_id'  => '19',
                'name'      => 'Engenheiro Paulo de Frontin',
                'ibge_code' => '3301801',
            ],

            199 => [
                'state_id'  => '19',
                'name'      => 'Guapimirim',
                'ibge_code' => '3301850',
            ],

            200 => [
                'state_id'  => '19',
                'name'      => 'Iguaba Grande',
                'ibge_code' => '3301876',
            ],

            201 => [
                'state_id'  => '19',
                'name'      => 'Itaboraí',
                'ibge_code' => '3301900',
            ],

            202 => [
                'state_id'  => '19',
                'name'      => 'Itaguaí',
                'ibge_code' => '3302007',
            ],

            203 => [
                'state_id'  => '19',
                'name'      => 'Italva',
                'ibge_code' => '3302056',
            ],

            204 => [
                'state_id'  => '19',
                'name'      => 'Itaocara',
                'ibge_code' => '3302106',
            ],

            205 => [
                'state_id'  => '19',
                'name'      => 'Itaperuna',
                'ibge_code' => '3302205',
            ],

            206 => [
                'state_id'  => '19',
                'name'      => 'Itatiaia',
                'ibge_code' => '3302254',
            ],

            207 => [
                'state_id'  => '19',
                'name'      => 'Japeri',
                'ibge_code' => '3302270',
            ],

            208 => [
                'state_id'  => '19',
                'name'      => 'Laje do Muriaé',
                'ibge_code' => '3302304',
            ],

            209 => [
                'state_id'  => '19',
                'name'      => 'Macaé',
                'ibge_code' => '3302403',
            ],

            210 => [
                'state_id'  => '19',
                'name'      => 'Macuco',
                'ibge_code' => '3302452',
            ],

            211 => [
                'state_id'  => '19',
                'name'      => 'Magé',
                'ibge_code' => '3302502',
            ],

            212 => [
                'state_id'  => '19',
                'name'      => 'Mangaratiba',
                'ibge_code' => '3302601',
            ],

            213 => [
                'state_id'  => '19',
                'name'      => 'Maricá',
                'ibge_code' => '3302700',
            ],

            214 => [
                'state_id'  => '19',
                'name'      => 'Mendes',
                'ibge_code' => '3302809',
            ],

            215 => [
                'state_id'  => '19',
                'name'      => 'Mesquita',
                'ibge_code' => '3302858',
            ],

            216 => [
                'state_id'  => '19',
                'name'      => 'Miguel Pereira',
                'ibge_code' => '3302908',
            ],

            217 => [
                'state_id'  => '19',
                'name'      => 'Miracema',
                'ibge_code' => '3303005',
            ],

            218 => [
                'state_id'  => '19',
                'name'      => 'Natividade',
                'ibge_code' => '3303104',
            ],

            219 => [
                'state_id'  => '19',
                'name'      => 'Nilópolis',
                'ibge_code' => '3303203',
            ],

            220 => [
                'state_id'  => '19',
                'name'      => 'Niterói',
                'ibge_code' => '3303302',
            ],

            221 => [
                'state_id'  => '19',
                'name'      => 'Nova Friburgo',
                'ibge_code' => '3303401',
            ],

            222 => [
                'state_id'  => '19',
                'name'      => 'Nova Iguaçu',
                'ibge_code' => '3303500',
            ],

            223 => [
                'state_id'  => '19',
                'name'      => 'Paracambi',
                'ibge_code' => '3303609',
            ],

            224 => [
                'state_id'  => '19',
                'name'      => 'Paraíba do Sul',
                'ibge_code' => '3303708',
            ],

            225 => [
                'state_id'  => '19',
                'name'      => 'Paraty',
                'ibge_code' => '3303807',
            ],

            226 => [
                'state_id'  => '19',
                'name'      => 'Paty do Alferes',
                'ibge_code' => '3303856',
            ],

            227 => [
                'state_id'  => '19',
                'name'      => 'Petrópolis',
                'ibge_code' => '3303906',
            ],

            228 => [
                'state_id'  => '19',
                'name'      => 'Pinheiral',
                'ibge_code' => '3303955',
            ],

            229 => [
                'state_id'  => '19',
                'name'      => 'Piraí',
                'ibge_code' => '3304003',
            ],

            230 => [
                'state_id'  => '19',
                'name'      => 'Porciúncula',
                'ibge_code' => '3304102',
            ],

            231 => [
                'state_id'  => '19',
                'name'      => 'Porto Real',
                'ibge_code' => '3304110',
            ],

            232 => [
                'state_id'  => '19',
                'name'      => 'Quatis',
                'ibge_code' => '3304128',
            ],

            233 => [
                'state_id'  => '19',
                'name'      => 'Queimados',
                'ibge_code' => '3304144',
            ],

            234 => [
                'state_id'  => '19',
                'name'      => 'Quissamã',
                'ibge_code' => '3304151',
            ],

            235 => [
                'state_id'  => '19',
                'name'      => 'Resende',
                'ibge_code' => '3304201',
            ],

            236 => [
                'state_id'  => '19',
                'name'      => 'Rio Bonito',
                'ibge_code' => '3304300',
            ],

            237 => [
                'state_id'  => '19',
                'name'      => 'Rio Claro',
                'ibge_code' => '3304409',
            ],

            238 => [
                'state_id'  => '19',
                'name'      => 'Rio das Flores',
                'ibge_code' => '3304508',
            ],

            239 => [
                'state_id'  => '19',
                'name'      => 'Rio das Ostras',
                'ibge_code' => '3304524',
            ],

            240 => [
                'state_id'  => '19',
                'name'      => 'Rio de Janeiro',
                'ibge_code' => '3304557',
            ],

            241 => [
                'state_id'  => '19',
                'name'      => 'Santa Maria Madalena',
                'ibge_code' => '3304607',
            ],

            242 => [
                'state_id'  => '19',
                'name'      => 'Santo Antônio de Pádua',
                'ibge_code' => '3304706',
            ],

            243 => [
                'state_id'  => '19',
                'name'      => 'São Francisco de Itabapoana',
                'ibge_code' => '3304755',
            ],

            244 => [
                'state_id'  => '19',
                'name'      => 'São Fidélis',
                'ibge_code' => '3304805',
            ],

            245 => [
                'state_id'  => '19',
                'name'      => 'São Gonçalo',
                'ibge_code' => '3304904',
            ],

            246 => [
                'state_id'  => '19',
                'name'      => 'São João da Barra',
                'ibge_code' => '3305000',
            ],

            247 => [
                'state_id'  => '19',
                'name'      => 'São João de Meriti',
                'ibge_code' => '3305109',
            ],

            248 => [
                'state_id'  => '19',
                'name'      => 'São José de Ubá',
                'ibge_code' => '3305133',
            ],

            249 => [
                'state_id'  => '19',
                'name'      => 'São José do Vale do Rio Preto',
                'ibge_code' => '3305158',
            ],

            250 => [
                'state_id'  => '19',
                'name'      => 'São Pedro da Aldeia',
                'ibge_code' => '3305208',
            ],

            251 => [
                'state_id'  => '19',
                'name'      => 'São Sebastião do Alto',
                'ibge_code' => '3305307',
            ],

            252 => [
                'state_id'  => '19',
                'name'      => 'Sapucaia',
                'ibge_code' => '3305406',
            ],

            253 => [
                'state_id'  => '19',
                'name'      => 'Saquarema',
                'ibge_code' => '3305505',
            ],

            254 => [
                'state_id'  => '19',
                'name'      => 'Seropédica',
                'ibge_code' => '3305554',
            ],

            255 => [
                'state_id'  => '19',
                'name'      => 'Silva Jardim',
                'ibge_code' => '3305604',
            ],

            256 => [
                'state_id'  => '19',
                'name'      => 'Sumidouro',
                'ibge_code' => '3305703',
            ],

            257 => [
                'state_id'  => '19',
                'name'      => 'Tanguá',
                'ibge_code' => '3305752',
            ],

            258 => [
                'state_id'  => '19',
                'name'      => 'Teresópolis',
                'ibge_code' => '3305802',
            ],

            259 => [
                'state_id'  => '19',
                'name'      => 'Trajano de Morais',
                'ibge_code' => '3305901',
            ],

            260 => [
                'state_id'  => '19',
                'name'      => 'Três Rios',
                'ibge_code' => '3306008',
            ],

            261 => [
                'state_id'  => '19',
                'name'      => 'Valença',
                'ibge_code' => '3306107',
            ],

            262 => [
                'state_id'  => '19',
                'name'      => 'Varre-Sai',
                'ibge_code' => '3306156',
            ],

            263 => [
                'state_id'  => '19',
                'name'      => 'Vassouras',
                'ibge_code' => '3306206',
            ],

            264 => [
                'state_id'  => '19',
                'name'      => 'Volta Redonda',
                'ibge_code' => '3306305',
            ],

            265 => [
                'state_id'  => '26',
                'name'      => 'Adamantina',
                'ibge_code' => '3500105',
            ],

            266 => [
                'state_id'  => '26',
                'name'      => 'Adolfo',
                'ibge_code' => '3500204',
            ],

            267 => [
                'state_id'  => '26',
                'name'      => 'Aguaí',
                'ibge_code' => '3500303',
            ],

            268 => [
                'state_id'  => '26',
                'name'      => 'Águas da Prata',
                'ibge_code' => '3500402',
            ],

            269 => [
                'state_id'  => '26',
                'name'      => 'Águas de Lindóia',
                'ibge_code' => '3500501',
            ],

            270 => [
                'state_id'  => '26',
                'name'      => 'Águas de Santa Bárbara',
                'ibge_code' => '3500550',
            ],

            271 => [
                'state_id'  => '26',
                'name'      => 'Águas de São Pedro',
                'ibge_code' => '3500600',
            ],

            272 => [
                'state_id'  => '26',
                'name'      => 'Agudos',
                'ibge_code' => '3500709',
            ],

            273 => [
                'state_id'  => '26',
                'name'      => 'Alambari',
                'ibge_code' => '3500758',
            ],

            274 => [
                'state_id'  => '26',
                'name'      => 'Alfredo Marcondes',
                'ibge_code' => '3500808',
            ],

            275 => [
                'state_id'  => '26',
                'name'      => 'Altair',
                'ibge_code' => '3500907',
            ],

            276 => [
                'state_id'  => '26',
                'name'      => 'Altinópolis',
                'ibge_code' => '3501004',
            ],

            277 => [
                'state_id'  => '26',
                'name'      => 'Alto Alegre',
                'ibge_code' => '3501103',
            ],

            278 => [
                'state_id'  => '26',
                'name'      => 'Alumínio',
                'ibge_code' => '3501152',
            ],

            279 => [
                'state_id'  => '26',
                'name'      => 'Álvares Florence',
                'ibge_code' => '3501202',
            ],

            280 => [
                'state_id'  => '26',
                'name'      => 'Álvares Machado',
                'ibge_code' => '3501301',
            ],

            281 => [
                'state_id'  => '26',
                'name'      => 'Álvaro de Carvalho',
                'ibge_code' => '3501400',
            ],

            282 => [
                'state_id'  => '26',
                'name'      => 'Alvinlândia',
                'ibge_code' => '3501509',
            ],

            283 => [
                'state_id'  => '26',
                'name'      => 'Americana',
                'ibge_code' => '3501608',
            ],

            284 => [
                'state_id'  => '26',
                'name'      => 'Américo Brasiliense',
                'ibge_code' => '3501707',
            ],

            285 => [
                'state_id'  => '26',
                'name'      => 'Américo de Campos',
                'ibge_code' => '3501806',
            ],

            286 => [
                'state_id'  => '26',
                'name'      => 'Amparo',
                'ibge_code' => '3501905',
            ],

            287 => [
                'state_id'  => '26',
                'name'      => 'Analândia',
                'ibge_code' => '3502002',
            ],

            288 => [
                'state_id'  => '26',
                'name'      => 'Andradina',
                'ibge_code' => '3502101',
            ],

            289 => [
                'state_id'  => '26',
                'name'      => 'Angatuba',
                'ibge_code' => '3502200',
            ],

            290 => [
                'state_id'  => '26',
                'name'      => 'Anhembi',
                'ibge_code' => '3502309',
            ],

            291 => [
                'state_id'  => '26',
                'name'      => 'Anhumas',
                'ibge_code' => '3502408',
            ],

            292 => [
                'state_id'  => '26',
                'name'      => 'Aparecida',
                'ibge_code' => '3502507',
            ],

            293 => [
                'state_id'  => '26',
                'name'      => "Aparecida D'oeste",
                'ibge_code' => '3502606',
            ],

            294 => [
                'state_id'  => '26',
                'name'      => 'Apiaí',
                'ibge_code' => '3502705',
            ],

            295 => [
                'state_id'  => '26',
                'name'      => 'Araçariguama',
                'ibge_code' => '3502754',
            ],

            296 => [
                'state_id'  => '26',
                'name'      => 'Araçatuba',
                'ibge_code' => '3502804',
            ],

            297 => [
                'state_id'  => '26',
                'name'      => 'Araçoiaba da Serra',
                'ibge_code' => '3502903',
            ],

            298 => [
                'state_id'  => '26',
                'name'      => 'Aramina',
                'ibge_code' => '3503000',
            ],

            299 => [
                'state_id'  => '26',
                'name'      => 'Arandu',
                'ibge_code' => '3503109',
            ],

            300 => [
                'state_id'  => '26',
                'name'      => 'Arapeí',
                'ibge_code' => '3503158',
            ],

            301 => [
                'state_id'  => '26',
                'name'      => 'Araraquara',
                'ibge_code' => '3503208',
            ],

            302 => [
                'state_id'  => '26',
                'name'      => 'Araras',
                'ibge_code' => '3503307',
            ],

            303 => [
                'state_id'  => '26',
                'name'      => 'Arco-Íris',
                'ibge_code' => '3503356',
            ],

            304 => [
                'state_id'  => '26',
                'name'      => 'Arealva',
                'ibge_code' => '3503406',
            ],

            305 => [
                'state_id'  => '26',
                'name'      => 'Areias',
                'ibge_code' => '3503505',
            ],

            306 => [
                'state_id'  => '26',
                'name'      => 'Areiópolis',
                'ibge_code' => '3503604',
            ],

            307 => [
                'state_id'  => '26',
                'name'      => 'Ariranha',
                'ibge_code' => '3503703',
            ],

            308 => [
                'state_id'  => '26',
                'name'      => 'Artur Nogueira',
                'ibge_code' => '3503802',
            ],

            309 => [
                'state_id'  => '26',
                'name'      => 'Arujá',
                'ibge_code' => '3503901',
            ],

            310 => [
                'state_id'  => '26',
                'name'      => 'Aspásia',
                'ibge_code' => '3503950',
            ],

            311 => [
                'state_id'  => '26',
                'name'      => 'Assis',
                'ibge_code' => '3504008',
            ],

            312 => [
                'state_id'  => '26',
                'name'      => 'Atibaia',
                'ibge_code' => '3504107',
            ],

            313 => [
                'state_id'  => '26',
                'name'      => 'Auriflama',
                'ibge_code' => '3504206',
            ],

            314 => [
                'state_id'  => '26',
                'name'      => 'Avaí',
                'ibge_code' => '3504305',
            ],

            315 => [
                'state_id'  => '26',
                'name'      => 'Avanhandava',
                'ibge_code' => '3504404',
            ],

            316 => [
                'state_id'  => '26',
                'name'      => 'Avaré',
                'ibge_code' => '3504503',
            ],

            317 => [
                'state_id'  => '26',
                'name'      => 'Bady Bassitt',
                'ibge_code' => '3504602',
            ],

            318 => [
                'state_id'  => '26',
                'name'      => 'Balbinos',
                'ibge_code' => '3504701',
            ],

            319 => [
                'state_id'  => '26',
                'name'      => 'Bálsamo',
                'ibge_code' => '3504800',
            ],

            320 => [
                'state_id'  => '26',
                'name'      => 'Bananal',
                'ibge_code' => '3504909',
            ],

            321 => [
                'state_id'  => '26',
                'name'      => 'Barão de Antonina',
                'ibge_code' => '3505005',
            ],

            322 => [
                'state_id'  => '26',
                'name'      => 'Barbosa',
                'ibge_code' => '3505104',
            ],

            323 => [
                'state_id'  => '26',
                'name'      => 'Bariri',
                'ibge_code' => '3505203',
            ],

            324 => [
                'state_id'  => '26',
                'name'      => 'Barra Bonita',
                'ibge_code' => '3505302',
            ],

            325 => [
                'state_id'  => '26',
                'name'      => 'Barra do Chapéu',
                'ibge_code' => '3505351',
            ],

            326 => [
                'state_id'  => '26',
                'name'      => 'Barra do Turvo',
                'ibge_code' => '3505401',
            ],

            327 => [
                'state_id'  => '26',
                'name'      => 'Barretos',
                'ibge_code' => '3505500',
            ],

            328 => [
                'state_id'  => '26',
                'name'      => 'Barrinha',
                'ibge_code' => '3505609',
            ],

            329 => [
                'state_id'  => '26',
                'name'      => 'Barueri',
                'ibge_code' => '3505708',
            ],

            330 => [
                'state_id'  => '26',
                'name'      => 'Bastos',
                'ibge_code' => '3505807',
            ],

            331 => [
                'state_id'  => '26',
                'name'      => 'Batatais',
                'ibge_code' => '3505906',
            ],

            332 => [
                'state_id'  => '26',
                'name'      => 'Bauru',
                'ibge_code' => '3506003',
            ],

            333 => [
                'state_id'  => '26',
                'name'      => 'Bebedouro',
                'ibge_code' => '3506102',
            ],

            334 => [
                'state_id'  => '26',
                'name'      => 'Bento de Abreu',
                'ibge_code' => '3506201',
            ],

            335 => [
                'state_id'  => '26',
                'name'      => 'Bernardino de Campos',
                'ibge_code' => '3506300',
            ],

            336 => [
                'state_id'  => '26',
                'name'      => 'Bertioga',
                'ibge_code' => '3506359',
            ],

            337 => [
                'state_id'  => '26',
                'name'      => 'Bilac',
                'ibge_code' => '3506409',
            ],

            338 => [
                'state_id'  => '26',
                'name'      => 'Birigui',
                'ibge_code' => '3506508',
            ],

            339 => [
                'state_id'  => '26',
                'name'      => 'Biritiba-Mirim',
                'ibge_code' => '3506607',
            ],

            340 => [
                'state_id'  => '26',
                'name'      => 'Boa Esperança do Sul',
                'ibge_code' => '3506706',
            ],

            341 => [
                'state_id'  => '26',
                'name'      => 'Bocaina',
                'ibge_code' => '3506805',
            ],

            342 => [
                'state_id'  => '26',
                'name'      => 'Bofete',
                'ibge_code' => '3506904',
            ],

            343 => [
                'state_id'  => '26',
                'name'      => 'Boituva',
                'ibge_code' => '3507001',
            ],

            344 => [
                'state_id'  => '26',
                'name'      => 'Bom Jesus dos Perdões',
                'ibge_code' => '3507100',
            ],

            345 => [
                'state_id'  => '26',
                'name'      => 'Bom Sucesso de Itararé',
                'ibge_code' => '3507159',
            ],

            346 => [
                'state_id'  => '26',
                'name'      => 'Borá',
                'ibge_code' => '3507209',
            ],

            347 => [
                'state_id'  => '26',
                'name'      => 'Boracéia',
                'ibge_code' => '3507308',
            ],

            348 => [
                'state_id'  => '26',
                'name'      => 'Borborema',
                'ibge_code' => '3507407',
            ],

            349 => [
                'state_id'  => '26',
                'name'      => 'Borebi',
                'ibge_code' => '3507456',
            ],

            350 => [
                'state_id'  => '26',
                'name'      => 'Botucatu',
                'ibge_code' => '3507506',
            ],

            351 => [
                'state_id'  => '26',
                'name'      => 'Bragança Paulista',
                'ibge_code' => '3507605',
            ],

            352 => [
                'state_id'  => '26',
                'name'      => 'Braúna',
                'ibge_code' => '3507704',
            ],

            353 => [
                'state_id'  => '26',
                'name'      => 'Brejo Alegre',
                'ibge_code' => '3507753',
            ],

            354 => [
                'state_id'  => '26',
                'name'      => 'Brodowski',
                'ibge_code' => '3507803',
            ],

            355 => [
                'state_id'  => '26',
                'name'      => 'Brotas',
                'ibge_code' => '3507902',
            ],

            356 => [
                'state_id'  => '26',
                'name'      => 'Buri',
                'ibge_code' => '3508009',
            ],

            357 => [
                'state_id'  => '26',
                'name'      => 'Buritama',
                'ibge_code' => '3508108',
            ],

            358 => [
                'state_id'  => '26',
                'name'      => 'Buritizal',
                'ibge_code' => '3508207',
            ],

            359 => [
                'state_id'  => '26',
                'name'      => 'Cabrália Paulista',
                'ibge_code' => '3508306',
            ],

            360 => [
                'state_id'  => '26',
                'name'      => 'Cabreúva',
                'ibge_code' => '3508405',
            ],

            361 => [
                'state_id'  => '26',
                'name'      => 'Caçapava',
                'ibge_code' => '3508504',
            ],

            362 => [
                'state_id'  => '26',
                'name'      => 'Cachoeira Paulista',
                'ibge_code' => '3508603',
            ],

            363 => [
                'state_id'  => '26',
                'name'      => 'Caconde',
                'ibge_code' => '3508702',
            ],

            364 => [
                'state_id'  => '26',
                'name'      => 'Cafelândia',
                'ibge_code' => '3508801',
            ],

            365 => [
                'state_id'  => '26',
                'name'      => 'Caiabu',
                'ibge_code' => '3508900',
            ],

            366 => [
                'state_id'  => '26',
                'name'      => 'Caieiras',
                'ibge_code' => '3509007',
            ],

            367 => [
                'state_id'  => '26',
                'name'      => 'Caiuá',
                'ibge_code' => '3509106',
            ],

            368 => [
                'state_id'  => '26',
                'name'      => 'Cajamar',
                'ibge_code' => '3509205',
            ],

            369 => [
                'state_id'  => '26',
                'name'      => 'Cajati',
                'ibge_code' => '3509254',
            ],

            370 => [
                'state_id'  => '26',
                'name'      => 'Cajobi',
                'ibge_code' => '3509304',
            ],

            371 => [
                'state_id'  => '26',
                'name'      => 'Cajuru',
                'ibge_code' => '3509403',
            ],

            372 => [
                'state_id'  => '26',
                'name'      => 'Campina do Monte Alegre',
                'ibge_code' => '3509452',
            ],

            373 => [
                'state_id'  => '26',
                'name'      => 'Campinas',
                'ibge_code' => '3509502',
            ],

            374 => [
                'state_id'  => '26',
                'name'      => 'Campo Limpo Paulista',
                'ibge_code' => '3509601',
            ],

            375 => [
                'state_id'  => '26',
                'name'      => 'Campos do Jordão',
                'ibge_code' => '3509700',
            ],

            376 => [
                'state_id'  => '26',
                'name'      => 'Campos Novos Paulista',
                'ibge_code' => '3509809',
            ],

            377 => [
                'state_id'  => '26',
                'name'      => 'Cananéia',
                'ibge_code' => '3509908',
            ],

            378 => [
                'state_id'  => '26',
                'name'      => 'Canas',
                'ibge_code' => '3509957',
            ],

            379 => [
                'state_id'  => '26',
                'name'      => 'Cândido Mota',
                'ibge_code' => '3510005',
            ],

            380 => [
                'state_id'  => '26',
                'name'      => 'Cândido Rodrigues',
                'ibge_code' => '3510104',
            ],

            381 => [
                'state_id'  => '26',
                'name'      => 'Canitar',
                'ibge_code' => '3510153',
            ],

            382 => [
                'state_id'  => '26',
                'name'      => 'Capão Bonito',
                'ibge_code' => '3510203',
            ],

            383 => [
                'state_id'  => '26',
                'name'      => 'Capela do Alto',
                'ibge_code' => '3510302',
            ],

            384 => [
                'state_id'  => '26',
                'name'      => 'Capivari',
                'ibge_code' => '3510401',
            ],

            385 => [
                'state_id'  => '26',
                'name'      => 'Caraguatatuba',
                'ibge_code' => '3510500',
            ],

            386 => [
                'state_id'  => '26',
                'name'      => 'Carapicuíba',
                'ibge_code' => '3510609',
            ],

            387 => [
                'state_id'  => '26',
                'name'      => 'Cardoso',
                'ibge_code' => '3510708',
            ],

            388 => [
                'state_id'  => '26',
                'name'      => 'Casa Branca',
                'ibge_code' => '3510807',
            ],

            389 => [
                'state_id'  => '26',
                'name'      => 'Cássia dos Coqueiros',
                'ibge_code' => '3510906',
            ],

            390 => [
                'state_id'  => '26',
                'name'      => 'Castilho',
                'ibge_code' => '3511003',
            ],

            391 => [
                'state_id'  => '26',
                'name'      => 'Catanduva',
                'ibge_code' => '3511102',
            ],

            392 => [
                'state_id'  => '26',
                'name'      => 'Catiguá',
                'ibge_code' => '3511201',
            ],

            393 => [
                'state_id'  => '26',
                'name'      => 'Cedral',
                'ibge_code' => '3511300',
            ],

            394 => [
                'state_id'  => '26',
                'name'      => 'Cerqueira César',
                'ibge_code' => '3511409',
            ],

            395 => [
                'state_id'  => '26',
                'name'      => 'Cerquilho',
                'ibge_code' => '3511508',
            ],

            396 => [
                'state_id'  => '26',
                'name'      => 'Cesário Lange',
                'ibge_code' => '3511607',
            ],

            397 => [
                'state_id'  => '26',
                'name'      => 'Charqueada',
                'ibge_code' => '3511706',
            ],

            398 => [
                'state_id'  => '26',
                'name'      => 'Clementina',
                'ibge_code' => '3511904',
            ],

            399 => [
                'state_id'  => '26',
                'name'      => 'Colina',
                'ibge_code' => '3512001',
            ],

            400 => [
                'state_id'  => '26',
                'name'      => 'Colômbia',
                'ibge_code' => '3512100',
            ],

            401 => [
                'state_id'  => '26',
                'name'      => 'Conchal',
                'ibge_code' => '3512209',
            ],

            402 => [
                'state_id'  => '26',
                'name'      => 'Conchas',
                'ibge_code' => '3512308',
            ],

            403 => [
                'state_id'  => '26',
                'name'      => 'Cordeirópolis',
                'ibge_code' => '3512407',
            ],

            404 => [
                'state_id'  => '26',
                'name'      => 'Coroados',
                'ibge_code' => '3512506',
            ],

            405 => [
                'state_id'  => '26',
                'name'      => 'Coronel Macedo',
                'ibge_code' => '3512605',
            ],

            406 => [
                'state_id'  => '26',
                'name'      => 'Corumbataí',
                'ibge_code' => '3512704',
            ],

            407 => [
                'state_id'  => '26',
                'name'      => 'Cosmópolis',
                'ibge_code' => '3512803',
            ],

            408 => [
                'state_id'  => '26',
                'name'      => 'Cosmorama',
                'ibge_code' => '3512902',
            ],

            409 => [
                'state_id'  => '26',
                'name'      => 'Cotia',
                'ibge_code' => '3513009',
            ],

            410 => [
                'state_id'  => '26',
                'name'      => 'Cravinhos',
                'ibge_code' => '3513108',
            ],

            411 => [
                'state_id'  => '26',
                'name'      => 'Cristais Paulista',
                'ibge_code' => '3513207',
            ],

            412 => [
                'state_id'  => '26',
                'name'      => 'Cruzália',
                'ibge_code' => '3513306',
            ],

            413 => [
                'state_id'  => '26',
                'name'      => 'Cruzeiro',
                'ibge_code' => '3513405',
            ],

            414 => [
                'state_id'  => '26',
                'name'      => 'Cubatão',
                'ibge_code' => '3513504',
            ],

            415 => [
                'state_id'  => '26',
                'name'      => 'Cunha',
                'ibge_code' => '3513603',
            ],

            416 => [
                'state_id'  => '26',
                'name'      => 'Descalvado',
                'ibge_code' => '3513702',
            ],

            417 => [
                'state_id'  => '26',
                'name'      => 'Diadema',
                'ibge_code' => '3513801',
            ],

            418 => [
                'state_id'  => '26',
                'name'      => 'Dirce Reis',
                'ibge_code' => '3513850',
            ],

            419 => [
                'state_id'  => '26',
                'name'      => 'Divinolândia',
                'ibge_code' => '3513900',
            ],

            420 => [
                'state_id'  => '26',
                'name'      => 'Dobrada',
                'ibge_code' => '3514007',
            ],

            421 => [
                'state_id'  => '26',
                'name'      => 'Dois Córregos',
                'ibge_code' => '3514106',
            ],

            422 => [
                'state_id'  => '26',
                'name'      => 'Dolcinópolis',
                'ibge_code' => '3514205',
            ],

            423 => [
                'state_id'  => '26',
                'name'      => 'Dourado',
                'ibge_code' => '3514304',
            ],

            424 => [
                'state_id'  => '26',
                'name'      => 'Dracena',
                'ibge_code' => '3514403',
            ],

            425 => [
                'state_id'  => '26',
                'name'      => 'Duartina',
                'ibge_code' => '3514502',
            ],

            426 => [
                'state_id'  => '26',
                'name'      => 'Dumont',
                'ibge_code' => '3514601',
            ],

            427 => [
                'state_id'  => '26',
                'name'      => 'Echaporã',
                'ibge_code' => '3514700',
            ],

            428 => [
                'state_id'  => '26',
                'name'      => 'Eldorado',
                'ibge_code' => '3514809',
            ],

            429 => [
                'state_id'  => '26',
                'name'      => 'Elias Fausto',
                'ibge_code' => '3514908',
            ],

            430 => [
                'state_id'  => '26',
                'name'      => 'Elisiário',
                'ibge_code' => '3514924',
            ],

            431 => [
                'state_id'  => '26',
                'name'      => 'Embaúba',
                'ibge_code' => '3514957',
            ],

            432 => [
                'state_id'  => '26',
                'name'      => 'Embu',
                'ibge_code' => '3515004',
            ],

            433 => [
                'state_id'  => '26',
                'name'      => 'Embu-Guaçu',
                'ibge_code' => '3515103',
            ],

            434 => [
                'state_id'  => '26',
                'name'      => 'Emilianópolis',
                'ibge_code' => '3515129',
            ],

            435 => [
                'state_id'  => '26',
                'name'      => 'Engenheiro Coelho',
                'ibge_code' => '3515152',
            ],

            436 => [
                'state_id'  => '26',
                'name'      => 'Espírito Santo do Pinhal',
                'ibge_code' => '3515186',
            ],

            437 => [
                'state_id'  => '26',
                'name'      => 'Espírito Santo do Turvo',
                'ibge_code' => '3515194',
            ],

            438 => [
                'state_id'  => '26',
                'name'      => "Estrela D'oeste",
                'ibge_code' => '3515202',
            ],

            439 => [
                'state_id'  => '26',
                'name'      => 'Estrela do Norte',
                'ibge_code' => '3515301',
            ],

            440 => [
                'state_id'  => '26',
                'name'      => 'Euclides da Cunha Paulista',
                'ibge_code' => '3515350',
            ],

            441 => [
                'state_id'  => '26',
                'name'      => 'Fartura',
                'ibge_code' => '3515400',
            ],

            442 => [
                'state_id'  => '26',
                'name'      => 'Fernandópolis',
                'ibge_code' => '3515509',
            ],

            443 => [
                'state_id'  => '26',
                'name'      => 'Fernando Prestes',
                'ibge_code' => '3515608',
            ],

            444 => [
                'state_id'  => '26',
                'name'      => 'Fernão',
                'ibge_code' => '3515657',
            ],

            445 => [
                'state_id'  => '26',
                'name'      => 'Ferraz de Vasconcelos',
                'ibge_code' => '3515707',
            ],

            446 => [
                'state_id'  => '26',
                'name'      => 'Flora Rica',
                'ibge_code' => '3515806',
            ],

            447 => [
                'state_id'  => '26',
                'name'      => 'Floreal',
                'ibge_code' => '3515905',
            ],

            448 => [
                'state_id'  => '26',
                'name'      => 'Flórida Paulista',
                'ibge_code' => '3516002',
            ],

            449 => [
                'state_id'  => '26',
                'name'      => 'Florínia',
                'ibge_code' => '3516101',
            ],

            450 => [
                'state_id'  => '26',
                'name'      => 'Franca',
                'ibge_code' => '3516200',
            ],

            451 => [
                'state_id'  => '26',
                'name'      => 'Francisco Morato',
                'ibge_code' => '3516309',
            ],

            452 => [
                'state_id'  => '26',
                'name'      => 'Franco da Rocha',
                'ibge_code' => '3516408',
            ],

            453 => [
                'state_id'  => '26',
                'name'      => 'Gabriel Monteiro',
                'ibge_code' => '3516507',
            ],

            454 => [
                'state_id'  => '26',
                'name'      => 'Gália',
                'ibge_code' => '3516606',
            ],

            455 => [
                'state_id'  => '26',
                'name'      => 'Garça',
                'ibge_code' => '3516705',
            ],

            456 => [
                'state_id'  => '26',
                'name'      => 'Gastão Vidigal',
                'ibge_code' => '3516804',
            ],

            457 => [
                'state_id'  => '26',
                'name'      => 'Gavião Peixoto',
                'ibge_code' => '3516853',
            ],

            458 => [
                'state_id'  => '26',
                'name'      => 'General Salgado',
                'ibge_code' => '3516903',
            ],

            459 => [
                'state_id'  => '26',
                'name'      => 'Getulina',
                'ibge_code' => '3517000',
            ],

            460 => [
                'state_id'  => '26',
                'name'      => 'Glicério',
                'ibge_code' => '3517109',
            ],

            461 => [
                'state_id'  => '26',
                'name'      => 'Guaiçara',
                'ibge_code' => '3517208',
            ],

            462 => [
                'state_id'  => '26',
                'name'      => 'Guaimbê',
                'ibge_code' => '3517307',
            ],

            463 => [
                'state_id'  => '26',
                'name'      => 'Guaíra',
                'ibge_code' => '3517406',
            ],

            464 => [
                'state_id'  => '26',
                'name'      => 'Guapiaçu',
                'ibge_code' => '3517505',
            ],

            465 => [
                'state_id'  => '26',
                'name'      => 'Guapiara',
                'ibge_code' => '3517604',
            ],

            466 => [
                'state_id'  => '26',
                'name'      => 'Guará',
                'ibge_code' => '3517703',
            ],

            467 => [
                'state_id'  => '26',
                'name'      => 'Guaraçaí',
                'ibge_code' => '3517802',
            ],

            468 => [
                'state_id'  => '26',
                'name'      => 'Guaraci',
                'ibge_code' => '3517901',
            ],

            469 => [
                'state_id'  => '26',
                'name'      => "Guarani D'oeste",
                'ibge_code' => '3518008',
            ],

            470 => [
                'state_id'  => '26',
                'name'      => 'Guarantã',
                'ibge_code' => '3518107',
            ],

            471 => [
                'state_id'  => '26',
                'name'      => 'Guararapes',
                'ibge_code' => '3518206',
            ],

            472 => [
                'state_id'  => '26',
                'name'      => 'Guararema',
                'ibge_code' => '3518305',
            ],

            473 => [
                'state_id'  => '26',
                'name'      => 'Guaratinguetá',
                'ibge_code' => '3518404',
            ],

            474 => [
                'state_id'  => '26',
                'name'      => 'Guareí',
                'ibge_code' => '3518503',
            ],

            475 => [
                'state_id'  => '26',
                'name'      => 'Guariba',
                'ibge_code' => '3518602',
            ],

            476 => [
                'state_id'  => '26',
                'name'      => 'Guarujá',
                'ibge_code' => '3518701',
            ],

            477 => [
                'state_id'  => '26',
                'name'      => 'Guarulhos',
                'ibge_code' => '3518800',
            ],

            478 => [
                'state_id'  => '26',
                'name'      => 'Guatapará',
                'ibge_code' => '3518859',
            ],

            479 => [
                'state_id'  => '26',
                'name'      => 'Guzolândia',
                'ibge_code' => '3518909',
            ],

            480 => [
                'state_id'  => '26',
                'name'      => 'Herculândia',
                'ibge_code' => '3519006',
            ],

            481 => [
                'state_id'  => '26',
                'name'      => 'Holambra',
                'ibge_code' => '3519055',
            ],

            482 => [
                'state_id'  => '26',
                'name'      => 'Hortolândia',
                'ibge_code' => '3519071',
            ],

            483 => [
                'state_id'  => '26',
                'name'      => 'Iacanga',
                'ibge_code' => '3519105',
            ],

            484 => [
                'state_id'  => '26',
                'name'      => 'Iacri',
                'ibge_code' => '3519204',
            ],

            485 => [
                'state_id'  => '26',
                'name'      => 'Iaras',
                'ibge_code' => '3519253',
            ],

            486 => [
                'state_id'  => '26',
                'name'      => 'Ibaté',
                'ibge_code' => '3519303',
            ],

            487 => [
                'state_id'  => '26',
                'name'      => 'Ibirá',
                'ibge_code' => '3519402',
            ],

            488 => [
                'state_id'  => '26',
                'name'      => 'Ibirarema',
                'ibge_code' => '3519501',
            ],

            489 => [
                'state_id'  => '26',
                'name'      => 'Ibitinga',
                'ibge_code' => '3519600',
            ],

            490 => [
                'state_id'  => '26',
                'name'      => 'Ibiúna',
                'ibge_code' => '3519709',
            ],

            491 => [
                'state_id'  => '26',
                'name'      => 'Icém',
                'ibge_code' => '3519808',
            ],

            492 => [
                'state_id'  => '26',
                'name'      => 'Iepê',
                'ibge_code' => '3519907',
            ],

            493 => [
                'state_id'  => '26',
                'name'      => 'Igaraçu do Tietê',
                'ibge_code' => '3520004',
            ],

            494 => [
                'state_id'  => '26',
                'name'      => 'Igarapava',
                'ibge_code' => '3520103',
            ],

            495 => [
                'state_id'  => '26',
                'name'      => 'Igaratá',
                'ibge_code' => '3520202',
            ],

            496 => [
                'state_id'  => '26',
                'name'      => 'Iguape',
                'ibge_code' => '3520301',
            ],

            497 => [
                'state_id'  => '26',
                'name'      => 'Ilhabela',
                'ibge_code' => '3520400',
            ],

            498 => [
                'state_id'  => '26',
                'name'      => 'Ilha Comprida',
                'ibge_code' => '3520426',
            ],

            499 => [
                'state_id'  => '26',
                'name'      => 'Ilha Solteira',
                'ibge_code' => '3520442',
            ],

        ]);
        DB::table('cities')->insert([
            0 => [
                'state_id'  => '26',
                'name'      => 'Indaiatuba',
                'ibge_code' => '3520509',
            ],

            1 => [
                'state_id'  => '26',
                'name'      => 'Indiana',
                'ibge_code' => '3520608',
            ],

            2 => [
                'state_id'  => '26',
                'name'      => 'Indiaporã',
                'ibge_code' => '3520707',
            ],

            3 => [
                'state_id'  => '26',
                'name'      => 'Inúbia Paulista',
                'ibge_code' => '3520806',
            ],

            4 => [
                'state_id'  => '26',
                'name'      => 'Ipaussu',
                'ibge_code' => '3520905',
            ],

            5 => [
                'state_id'  => '26',
                'name'      => 'Iperó',
                'ibge_code' => '3521002',
            ],

            6 => [
                'state_id'  => '26',
                'name'      => 'Ipeúna',
                'ibge_code' => '3521101',
            ],

            7 => [
                'state_id'  => '26',
                'name'      => 'Ipiguá',
                'ibge_code' => '3521150',
            ],

            8 => [
                'state_id'  => '26',
                'name'      => 'Iporanga',
                'ibge_code' => '3521200',
            ],

            9 => [
                'state_id'  => '26',
                'name'      => 'Ipuã',
                'ibge_code' => '3521309',
            ],

            10 => [
                'state_id'  => '26',
                'name'      => 'Iracemápolis',
                'ibge_code' => '3521408',
            ],

            11 => [
                'state_id'  => '26',
                'name'      => 'Irapuã',
                'ibge_code' => '3521507',
            ],

            12 => [
                'state_id'  => '26',
                'name'      => 'Irapuru',
                'ibge_code' => '3521606',
            ],

            13 => [
                'state_id'  => '26',
                'name'      => 'Itaberá',
                'ibge_code' => '3521705',
            ],

            14 => [
                'state_id'  => '26',
                'name'      => 'Itaí',
                'ibge_code' => '3521804',
            ],

            15 => [
                'state_id'  => '26',
                'name'      => 'Itajobi',
                'ibge_code' => '3521903',
            ],

            16 => [
                'state_id'  => '26',
                'name'      => 'Itaju',
                'ibge_code' => '3522000',
            ],

            17 => [
                'state_id'  => '26',
                'name'      => 'Itanhaém',
                'ibge_code' => '3522109',
            ],

            18 => [
                'state_id'  => '26',
                'name'      => 'Itaóca',
                'ibge_code' => '3522158',
            ],

            19 => [
                'state_id'  => '26',
                'name'      => 'Itapecerica da Serra',
                'ibge_code' => '3522208',
            ],

            20 => [
                'state_id'  => '26',
                'name'      => 'Itapetininga',
                'ibge_code' => '3522307',
            ],

            21 => [
                'state_id'  => '26',
                'name'      => 'Itapeva',
                'ibge_code' => '3522406',
            ],

            22 => [
                'state_id'  => '26',
                'name'      => 'Itapevi',
                'ibge_code' => '3522505',
            ],

            23 => [
                'state_id'  => '26',
                'name'      => 'Itapira',
                'ibge_code' => '3522604',
            ],

            24 => [
                'state_id'  => '26',
                'name'      => 'Itapirapuã Paulista',
                'ibge_code' => '3522653',
            ],

            25 => [
                'state_id'  => '26',
                'name'      => 'Itápolis',
                'ibge_code' => '3522703',
            ],

            26 => [
                'state_id'  => '26',
                'name'      => 'Itaporanga',
                'ibge_code' => '3522802',
            ],

            27 => [
                'state_id'  => '26',
                'name'      => 'Itapuí',
                'ibge_code' => '3522901',
            ],

            28 => [
                'state_id'  => '26',
                'name'      => 'Itapura',
                'ibge_code' => '3523008',
            ],

            29 => [
                'state_id'  => '26',
                'name'      => 'Itaquaquecetuba',
                'ibge_code' => '3523107',
            ],

            30 => [
                'state_id'  => '26',
                'name'      => 'Itararé',
                'ibge_code' => '3523206',
            ],

            31 => [
                'state_id'  => '26',
                'name'      => 'Itariri',
                'ibge_code' => '3523305',
            ],

            32 => [
                'state_id'  => '26',
                'name'      => 'Itatiba',
                'ibge_code' => '3523404',
            ],

            33 => [
                'state_id'  => '26',
                'name'      => 'Itatinga',
                'ibge_code' => '3523503',
            ],

            34 => [
                'state_id'  => '26',
                'name'      => 'Itirapina',
                'ibge_code' => '3523602',
            ],

            35 => [
                'state_id'  => '26',
                'name'      => 'Itirapuã',
                'ibge_code' => '3523701',
            ],

            36 => [
                'state_id'  => '26',
                'name'      => 'Itobi',
                'ibge_code' => '3523800',
            ],

            37 => [
                'state_id'  => '26',
                'name'      => 'Itu',
                'ibge_code' => '3523909',
            ],

            38 => [
                'state_id'  => '26',
                'name'      => 'Itupeva',
                'ibge_code' => '3524006',
            ],

            39 => [
                'state_id'  => '26',
                'name'      => 'Ituverava',
                'ibge_code' => '3524105',
            ],

            40 => [
                'state_id'  => '26',
                'name'      => 'Jaborandi',
                'ibge_code' => '3524204',
            ],

            41 => [
                'state_id'  => '26',
                'name'      => 'Jaboticabal',
                'ibge_code' => '3524303',
            ],

            42 => [
                'state_id'  => '26',
                'name'      => 'Jacareí',
                'ibge_code' => '3524402',
            ],

            43 => [
                'state_id'  => '26',
                'name'      => 'Jaci',
                'ibge_code' => '3524501',
            ],

            44 => [
                'state_id'  => '26',
                'name'      => 'Jacupiranga',
                'ibge_code' => '3524600',
            ],

            45 => [
                'state_id'  => '26',
                'name'      => 'Jaguariúna',
                'ibge_code' => '3524709',
            ],

            46 => [
                'state_id'  => '26',
                'name'      => 'Jales',
                'ibge_code' => '3524808',
            ],

            47 => [
                'state_id'  => '26',
                'name'      => 'Jambeiro',
                'ibge_code' => '3524907',
            ],

            48 => [
                'state_id'  => '26',
                'name'      => 'Jandira',
                'ibge_code' => '3525003',
            ],

            49 => [
                'state_id'  => '26',
                'name'      => 'Jardinópolis',
                'ibge_code' => '3525102',
            ],

            50 => [
                'state_id'  => '26',
                'name'      => 'Jarinu',
                'ibge_code' => '3525201',
            ],

            51 => [
                'state_id'  => '26',
                'name'      => 'Jaú',
                'ibge_code' => '3525300',
            ],

            52 => [
                'state_id'  => '26',
                'name'      => 'Jeriquara',
                'ibge_code' => '3525409',
            ],

            53 => [
                'state_id'  => '26',
                'name'      => 'Joanópolis',
                'ibge_code' => '3525508',
            ],

            54 => [
                'state_id'  => '26',
                'name'      => 'João Ramalho',
                'ibge_code' => '3525607',
            ],

            55 => [
                'state_id'  => '26',
                'name'      => 'José Bonifácio',
                'ibge_code' => '3525706',
            ],

            56 => [
                'state_id'  => '26',
                'name'      => 'Júlio Mesquita',
                'ibge_code' => '3525805',
            ],

            57 => [
                'state_id'  => '26',
                'name'      => 'Jumirim',
                'ibge_code' => '3525854',
            ],

            58 => [
                'state_id'  => '26',
                'name'      => 'Jundiaí',
                'ibge_code' => '3525904',
            ],

            59 => [
                'state_id'  => '26',
                'name'      => 'Junqueirópolis',
                'ibge_code' => '3526001',
            ],

            60 => [
                'state_id'  => '26',
                'name'      => 'Juquiá',
                'ibge_code' => '3526100',
            ],

            61 => [
                'state_id'  => '26',
                'name'      => 'Juquitiba',
                'ibge_code' => '3526209',
            ],

            62 => [
                'state_id'  => '26',
                'name'      => 'Lagoinha',
                'ibge_code' => '3526308',
            ],

            63 => [
                'state_id'  => '26',
                'name'      => 'Laranjal Paulista',
                'ibge_code' => '3526407',
            ],

            64 => [
                'state_id'  => '26',
                'name'      => 'Lavínia',
                'ibge_code' => '3526506',
            ],

            65 => [
                'state_id'  => '26',
                'name'      => 'Lavrinhas',
                'ibge_code' => '3526605',
            ],

            66 => [
                'state_id'  => '26',
                'name'      => 'Leme',
                'ibge_code' => '3526704',
            ],

            67 => [
                'state_id'  => '26',
                'name'      => 'Lençóis Paulista',
                'ibge_code' => '3526803',
            ],

            68 => [
                'state_id'  => '26',
                'name'      => 'Limeira',
                'ibge_code' => '3526902',
            ],

            69 => [
                'state_id'  => '26',
                'name'      => 'Lindóia',
                'ibge_code' => '3527009',
            ],

            70 => [
                'state_id'  => '26',
                'name'      => 'Lins',
                'ibge_code' => '3527108',
            ],

            71 => [
                'state_id'  => '26',
                'name'      => 'Lorena',
                'ibge_code' => '3527207',
            ],

            72 => [
                'state_id'  => '26',
                'name'      => 'Lourdes',
                'ibge_code' => '3527256',
            ],

            73 => [
                'state_id'  => '26',
                'name'      => 'Louveira',
                'ibge_code' => '3527306',
            ],

            74 => [
                'state_id'  => '26',
                'name'      => 'Lucélia',
                'ibge_code' => '3527405',
            ],

            75 => [
                'state_id'  => '26',
                'name'      => 'Lucianópolis',
                'ibge_code' => '3527504',
            ],

            76 => [
                'state_id'  => '26',
                'name'      => 'Luís Antônio',
                'ibge_code' => '3527603',
            ],

            77 => [
                'state_id'  => '26',
                'name'      => 'Luiziânia',
                'ibge_code' => '3527702',
            ],

            78 => [
                'state_id'  => '26',
                'name'      => 'Lupércio',
                'ibge_code' => '3527801',
            ],

            79 => [
                'state_id'  => '26',
                'name'      => 'Lutécia',
                'ibge_code' => '3527900',
            ],

            80 => [
                'state_id'  => '26',
                'name'      => 'Macatuba',
                'ibge_code' => '3528007',
            ],

            81 => [
                'state_id'  => '26',
                'name'      => 'Macaubal',
                'ibge_code' => '3528106',
            ],

            82 => [
                'state_id'  => '26',
                'name'      => 'Macedônia',
                'ibge_code' => '3528205',
            ],

            83 => [
                'state_id'  => '26',
                'name'      => 'Magda',
                'ibge_code' => '3528304',
            ],

            84 => [
                'state_id'  => '26',
                'name'      => 'Mairinque',
                'ibge_code' => '3528403',
            ],

            85 => [
                'state_id'  => '26',
                'name'      => 'Mairiporã',
                'ibge_code' => '3528502',
            ],

            86 => [
                'state_id'  => '26',
                'name'      => 'Manduri',
                'ibge_code' => '3528601',
            ],

            87 => [
                'state_id'  => '26',
                'name'      => 'Marabá Paulista',
                'ibge_code' => '3528700',
            ],

            88 => [
                'state_id'  => '26',
                'name'      => 'Maracaí',
                'ibge_code' => '3528809',
            ],

            89 => [
                'state_id'  => '26',
                'name'      => 'Marapoama',
                'ibge_code' => '3528858',
            ],

            90 => [
                'state_id'  => '26',
                'name'      => 'Mariápolis',
                'ibge_code' => '3528908',
            ],

            91 => [
                'state_id'  => '26',
                'name'      => 'Marília',
                'ibge_code' => '3529005',
            ],

            92 => [
                'state_id'  => '26',
                'name'      => 'Marinópolis',
                'ibge_code' => '3529104',
            ],

            93 => [
                'state_id'  => '26',
                'name'      => 'Martinópolis',
                'ibge_code' => '3529203',
            ],

            94 => [
                'state_id'  => '26',
                'name'      => 'Matão',
                'ibge_code' => '3529302',
            ],

            95 => [
                'state_id'  => '26',
                'name'      => 'Mauá',
                'ibge_code' => '3529401',
            ],

            96 => [
                'state_id'  => '26',
                'name'      => 'Mendonça',
                'ibge_code' => '3529500',
            ],

            97 => [
                'state_id'  => '26',
                'name'      => 'Meridiano',
                'ibge_code' => '3529609',
            ],

            98 => [
                'state_id'  => '26',
                'name'      => 'Mesópolis',
                'ibge_code' => '3529658',
            ],

            99 => [
                'state_id'  => '26',
                'name'      => 'Miguelópolis',
                'ibge_code' => '3529708',
            ],

            100 => [
                'state_id'  => '26',
                'name'      => 'Mineiros do Tietê',
                'ibge_code' => '3529807',
            ],

            101 => [
                'state_id'  => '26',
                'name'      => 'Miracatu',
                'ibge_code' => '3529906',
            ],

            102 => [
                'state_id'  => '26',
                'name'      => 'Mira Estrela',
                'ibge_code' => '3530003',
            ],

            103 => [
                'state_id'  => '26',
                'name'      => 'Mirandópolis',
                'ibge_code' => '3530102',
            ],

            104 => [
                'state_id'  => '26',
                'name'      => 'Mirante do Paranapanema',
                'ibge_code' => '3530201',
            ],

            105 => [
                'state_id'  => '26',
                'name'      => 'Mirassol',
                'ibge_code' => '3530300',
            ],

            106 => [
                'state_id'  => '26',
                'name'      => 'Mirassolândia',
                'ibge_code' => '3530409',
            ],

            107 => [
                'state_id'  => '26',
                'name'      => 'Mococa',
                'ibge_code' => '3530508',
            ],

            108 => [
                'state_id'  => '26',
                'name'      => 'Mogi das Cruzes',
                'ibge_code' => '3530607',
            ],

            109 => [
                'state_id'  => '26',
                'name'      => 'Mogi Guaçu',
                'ibge_code' => '3530706',
            ],

            110 => [
                'state_id'  => '26',
                'name'      => 'Mogi Mirim',
                'ibge_code' => '3530805',
            ],

            111 => [
                'state_id'  => '26',
                'name'      => 'Mombuca',
                'ibge_code' => '3530904',
            ],

            112 => [
                'state_id'  => '26',
                'name'      => 'Monções',
                'ibge_code' => '3531001',
            ],

            113 => [
                'state_id'  => '26',
                'name'      => 'Mongaguá',
                'ibge_code' => '3531100',
            ],

            114 => [
                'state_id'  => '26',
                'name'      => 'Monte Alegre do Sul',
                'ibge_code' => '3531209',
            ],

            115 => [
                'state_id'  => '26',
                'name'      => 'Monte Alto',
                'ibge_code' => '3531308',
            ],

            116 => [
                'state_id'  => '26',
                'name'      => 'Monte Aprazível',
                'ibge_code' => '3531407',
            ],

            117 => [
                'state_id'  => '26',
                'name'      => 'Monte Azul Paulista',
                'ibge_code' => '3531506',
            ],

            118 => [
                'state_id'  => '26',
                'name'      => 'Monte Castelo',
                'ibge_code' => '3531605',
            ],

            119 => [
                'state_id'  => '26',
                'name'      => 'Monteiro Lobato',
                'ibge_code' => '3531704',
            ],

            120 => [
                'state_id'  => '26',
                'name'      => 'Monte Mor',
                'ibge_code' => '3531803',
            ],

            121 => [
                'state_id'  => '26',
                'name'      => 'Morro Agudo',
                'ibge_code' => '3531902',
            ],

            122 => [
                'state_id'  => '26',
                'name'      => 'Morungaba',
                'ibge_code' => '3532009',
            ],

            123 => [
                'state_id'  => '26',
                'name'      => 'Motuca',
                'ibge_code' => '3532058',
            ],

            124 => [
                'state_id'  => '26',
                'name'      => 'Murutinga do Sul',
                'ibge_code' => '3532108',
            ],

            125 => [
                'state_id'  => '26',
                'name'      => 'Nantes',
                'ibge_code' => '3532157',
            ],

            126 => [
                'state_id'  => '26',
                'name'      => 'Narandiba',
                'ibge_code' => '3532207',
            ],

            127 => [
                'state_id'  => '26',
                'name'      => 'Natividade da Serra',
                'ibge_code' => '3532306',
            ],

            128 => [
                'state_id'  => '26',
                'name'      => 'Nazaré Paulista',
                'ibge_code' => '3532405',
            ],

            129 => [
                'state_id'  => '26',
                'name'      => 'Neves Paulista',
                'ibge_code' => '3532504',
            ],

            130 => [
                'state_id'  => '26',
                'name'      => 'Nhandeara',
                'ibge_code' => '3532603',
            ],

            131 => [
                'state_id'  => '26',
                'name'      => 'Nipoã',
                'ibge_code' => '3532702',
            ],

            132 => [
                'state_id'  => '26',
                'name'      => 'Nova Aliança',
                'ibge_code' => '3532801',
            ],

            133 => [
                'state_id'  => '26',
                'name'      => 'Nova Campina',
                'ibge_code' => '3532827',
            ],

            134 => [
                'state_id'  => '26',
                'name'      => 'Nova Canaã Paulista',
                'ibge_code' => '3532843',
            ],

            135 => [
                'state_id'  => '26',
                'name'      => 'Nova Castilho',
                'ibge_code' => '3532868',
            ],

            136 => [
                'state_id'  => '26',
                'name'      => 'Nova Europa',
                'ibge_code' => '3532900',
            ],

            137 => [
                'state_id'  => '26',
                'name'      => 'Nova Granada',
                'ibge_code' => '3533007',
            ],

            138 => [
                'state_id'  => '26',
                'name'      => 'Nova Guataporanga',
                'ibge_code' => '3533106',
            ],

            139 => [
                'state_id'  => '26',
                'name'      => 'Nova Independência',
                'ibge_code' => '3533205',
            ],

            140 => [
                'state_id'  => '26',
                'name'      => 'Novais',
                'ibge_code' => '3533254',
            ],

            141 => [
                'state_id'  => '26',
                'name'      => 'Nova Luzitânia',
                'ibge_code' => '3533304',
            ],

            142 => [
                'state_id'  => '26',
                'name'      => 'Nova Odessa',
                'ibge_code' => '3533403',
            ],

            143 => [
                'state_id'  => '26',
                'name'      => 'Novo Horizonte',
                'ibge_code' => '3533502',
            ],

            144 => [
                'state_id'  => '26',
                'name'      => 'Nuporanga',
                'ibge_code' => '3533601',
            ],

            145 => [
                'state_id'  => '26',
                'name'      => 'Ocauçu',
                'ibge_code' => '3533700',
            ],

            146 => [
                'state_id'  => '26',
                'name'      => 'Óleo',
                'ibge_code' => '3533809',
            ],

            147 => [
                'state_id'  => '26',
                'name'      => 'Olímpia',
                'ibge_code' => '3533908',
            ],

            148 => [
                'state_id'  => '26',
                'name'      => 'Onda Verde',
                'ibge_code' => '3534005',
            ],

            149 => [
                'state_id'  => '26',
                'name'      => 'Oriente',
                'ibge_code' => '3534104',
            ],

            150 => [
                'state_id'  => '26',
                'name'      => 'Orindiúva',
                'ibge_code' => '3534203',
            ],

            151 => [
                'state_id'  => '26',
                'name'      => 'Orlândia',
                'ibge_code' => '3534302',
            ],

            152 => [
                'state_id'  => '26',
                'name'      => 'Osasco',
                'ibge_code' => '3534401',
            ],

            153 => [
                'state_id'  => '26',
                'name'      => 'Oscar Bressane',
                'ibge_code' => '3534500',
            ],

            154 => [
                'state_id'  => '26',
                'name'      => 'Osvaldo Cruz',
                'ibge_code' => '3534609',
            ],

            155 => [
                'state_id'  => '26',
                'name'      => 'Ourinhos',
                'ibge_code' => '3534708',
            ],

            156 => [
                'state_id'  => '26',
                'name'      => 'Ouroeste',
                'ibge_code' => '3534757',
            ],

            157 => [
                'state_id'  => '26',
                'name'      => 'Ouro Verde',
                'ibge_code' => '3534807',
            ],

            158 => [
                'state_id'  => '26',
                'name'      => 'Pacaembu',
                'ibge_code' => '3534906',
            ],

            159 => [
                'state_id'  => '26',
                'name'      => 'Palestina',
                'ibge_code' => '3535002',
            ],

            160 => [
                'state_id'  => '26',
                'name'      => 'Palmares Paulista',
                'ibge_code' => '3535101',
            ],

            161 => [
                'state_id'  => '26',
                'name'      => "Palmeira D'oeste",
                'ibge_code' => '3535200',
            ],

            162 => [
                'state_id'  => '26',
                'name'      => 'Palmital',
                'ibge_code' => '3535309',
            ],

            163 => [
                'state_id'  => '26',
                'name'      => 'Panorama',
                'ibge_code' => '3535408',
            ],

            164 => [
                'state_id'  => '26',
                'name'      => 'Paraguaçu Paulista',
                'ibge_code' => '3535507',
            ],

            165 => [
                'state_id'  => '26',
                'name'      => 'Paraibuna',
                'ibge_code' => '3535606',
            ],

            166 => [
                'state_id'  => '26',
                'name'      => 'Paraíso',
                'ibge_code' => '3535705',
            ],

            167 => [
                'state_id'  => '26',
                'name'      => 'Paranapanema',
                'ibge_code' => '3535804',
            ],

            168 => [
                'state_id'  => '26',
                'name'      => 'Paranapuã',
                'ibge_code' => '3535903',
            ],

            169 => [
                'state_id'  => '26',
                'name'      => 'Parapuã',
                'ibge_code' => '3536000',
            ],

            170 => [
                'state_id'  => '26',
                'name'      => 'Pardinho',
                'ibge_code' => '3536109',
            ],

            171 => [
                'state_id'  => '26',
                'name'      => 'Pariquera-Açu',
                'ibge_code' => '3536208',
            ],

            172 => [
                'state_id'  => '26',
                'name'      => 'Parisi',
                'ibge_code' => '3536257',
            ],

            173 => [
                'state_id'  => '26',
                'name'      => 'Patrocínio Paulista',
                'ibge_code' => '3536307',
            ],

            174 => [
                'state_id'  => '26',
                'name'      => 'Paulicéia',
                'ibge_code' => '3536406',
            ],

            175 => [
                'state_id'  => '26',
                'name'      => 'Paulínia',
                'ibge_code' => '3536505',
            ],

            176 => [
                'state_id'  => '26',
                'name'      => 'Paulistânia',
                'ibge_code' => '3536570',
            ],

            177 => [
                'state_id'  => '26',
                'name'      => 'Paulo de Faria',
                'ibge_code' => '3536604',
            ],

            178 => [
                'state_id'  => '26',
                'name'      => 'Pederneiras',
                'ibge_code' => '3536703',
            ],

            179 => [
                'state_id'  => '26',
                'name'      => 'Pedra Bela',
                'ibge_code' => '3536802',
            ],

            180 => [
                'state_id'  => '26',
                'name'      => 'Pedranópolis',
                'ibge_code' => '3536901',
            ],

            181 => [
                'state_id'  => '26',
                'name'      => 'Pedregulho',
                'ibge_code' => '3537008',
            ],

            182 => [
                'state_id'  => '26',
                'name'      => 'Pedreira',
                'ibge_code' => '3537107',
            ],

            183 => [
                'state_id'  => '26',
                'name'      => 'Pedrinhas Paulista',
                'ibge_code' => '3537156',
            ],

            184 => [
                'state_id'  => '26',
                'name'      => 'Pedro de Toledo',
                'ibge_code' => '3537206',
            ],

            185 => [
                'state_id'  => '26',
                'name'      => 'Penápolis',
                'ibge_code' => '3537305',
            ],

            186 => [
                'state_id'  => '26',
                'name'      => 'Pereira Barreto',
                'ibge_code' => '3537404',
            ],

            187 => [
                'state_id'  => '26',
                'name'      => 'Pereiras',
                'ibge_code' => '3537503',
            ],

            188 => [
                'state_id'  => '26',
                'name'      => 'Peruíbe',
                'ibge_code' => '3537602',
            ],

            189 => [
                'state_id'  => '26',
                'name'      => 'Piacatu',
                'ibge_code' => '3537701',
            ],

            190 => [
                'state_id'  => '26',
                'name'      => 'Piedade',
                'ibge_code' => '3537800',
            ],

            191 => [
                'state_id'  => '26',
                'name'      => 'Pilar do Sul',
                'ibge_code' => '3537909',
            ],

            192 => [
                'state_id'  => '26',
                'name'      => 'Pindamonhangaba',
                'ibge_code' => '3538006',
            ],

            193 => [
                'state_id'  => '26',
                'name'      => 'Pindorama',
                'ibge_code' => '3538105',
            ],

            194 => [
                'state_id'  => '26',
                'name'      => 'Pinhalzinho',
                'ibge_code' => '3538204',
            ],

            195 => [
                'state_id'  => '26',
                'name'      => 'Piquerobi',
                'ibge_code' => '3538303',
            ],

            196 => [
                'state_id'  => '26',
                'name'      => 'Piquete',
                'ibge_code' => '3538501',
            ],

            197 => [
                'state_id'  => '26',
                'name'      => 'Piracaia',
                'ibge_code' => '3538600',
            ],

            198 => [
                'state_id'  => '26',
                'name'      => 'Piracicaba',
                'ibge_code' => '3538709',
            ],

            199 => [
                'state_id'  => '26',
                'name'      => 'Piraju',
                'ibge_code' => '3538808',
            ],

            200 => [
                'state_id'  => '26',
                'name'      => 'Pirajuí',
                'ibge_code' => '3538907',
            ],

            201 => [
                'state_id'  => '26',
                'name'      => 'Pirangi',
                'ibge_code' => '3539004',
            ],

            202 => [
                'state_id'  => '26',
                'name'      => 'Pirapora do Bom Jesus',
                'ibge_code' => '3539103',
            ],

            203 => [
                'state_id'  => '26',
                'name'      => 'Pirapozinho',
                'ibge_code' => '3539202',
            ],

            204 => [
                'state_id'  => '26',
                'name'      => 'Pirassununga',
                'ibge_code' => '3539301',
            ],

            205 => [
                'state_id'  => '26',
                'name'      => 'Piratininga',
                'ibge_code' => '3539400',
            ],

            206 => [
                'state_id'  => '26',
                'name'      => 'Pitangueiras',
                'ibge_code' => '3539509',
            ],

            207 => [
                'state_id'  => '26',
                'name'      => 'Planalto',
                'ibge_code' => '3539608',
            ],

            208 => [
                'state_id'  => '26',
                'name'      => 'Platina',
                'ibge_code' => '3539707',
            ],

            209 => [
                'state_id'  => '26',
                'name'      => 'Poá',
                'ibge_code' => '3539806',
            ],

            210 => [
                'state_id'  => '26',
                'name'      => 'Poloni',
                'ibge_code' => '3539905',
            ],

            211 => [
                'state_id'  => '26',
                'name'      => 'Pompéia',
                'ibge_code' => '3540002',
            ],

            212 => [
                'state_id'  => '26',
                'name'      => 'Pongaí',
                'ibge_code' => '3540101',
            ],

            213 => [
                'state_id'  => '26',
                'name'      => 'Pontal',
                'ibge_code' => '3540200',
            ],

            214 => [
                'state_id'  => '26',
                'name'      => 'Pontalinda',
                'ibge_code' => '3540259',
            ],

            215 => [
                'state_id'  => '26',
                'name'      => 'Pontes Gestal',
                'ibge_code' => '3540309',
            ],

            216 => [
                'state_id'  => '26',
                'name'      => 'Populina',
                'ibge_code' => '3540408',
            ],

            217 => [
                'state_id'  => '26',
                'name'      => 'Porangaba',
                'ibge_code' => '3540507',
            ],

            218 => [
                'state_id'  => '26',
                'name'      => 'Porto Feliz',
                'ibge_code' => '3540606',
            ],

            219 => [
                'state_id'  => '26',
                'name'      => 'Porto Ferreira',
                'ibge_code' => '3540705',
            ],

            220 => [
                'state_id'  => '26',
                'name'      => 'Potim',
                'ibge_code' => '3540754',
            ],

            221 => [
                'state_id'  => '26',
                'name'      => 'Potirendaba',
                'ibge_code' => '3540804',
            ],

            222 => [
                'state_id'  => '26',
                'name'      => 'Pracinha',
                'ibge_code' => '3540853',
            ],

            223 => [
                'state_id'  => '26',
                'name'      => 'Pradópolis',
                'ibge_code' => '3540903',
            ],

            224 => [
                'state_id'  => '26',
                'name'      => 'Praia Grande',
                'ibge_code' => '3541000',
            ],

            225 => [
                'state_id'  => '26',
                'name'      => 'Pratânia',
                'ibge_code' => '3541059',
            ],

            226 => [
                'state_id'  => '26',
                'name'      => 'Presidente Alves',
                'ibge_code' => '3541109',
            ],

            227 => [
                'state_id'  => '26',
                'name'      => 'Presidente Bernardes',
                'ibge_code' => '3541208',
            ],

            228 => [
                'state_id'  => '26',
                'name'      => 'Presidente Epitácio',
                'ibge_code' => '3541307',
            ],

            229 => [
                'state_id'  => '26',
                'name'      => 'Presidente Prudente',
                'ibge_code' => '3541406',
            ],

            230 => [
                'state_id'  => '26',
                'name'      => 'Presidente Venceslau',
                'ibge_code' => '3541505',
            ],

            231 => [
                'state_id'  => '26',
                'name'      => 'Promissão',
                'ibge_code' => '3541604',
            ],

            232 => [
                'state_id'  => '26',
                'name'      => 'Quadra',
                'ibge_code' => '3541653',
            ],

            233 => [
                'state_id'  => '26',
                'name'      => 'Quatá',
                'ibge_code' => '3541703',
            ],

            234 => [
                'state_id'  => '26',
                'name'      => 'Queiroz',
                'ibge_code' => '3541802',
            ],

            235 => [
                'state_id'  => '26',
                'name'      => 'Queluz',
                'ibge_code' => '3541901',
            ],

            236 => [
                'state_id'  => '26',
                'name'      => 'Quintana',
                'ibge_code' => '3542008',
            ],

            237 => [
                'state_id'  => '26',
                'name'      => 'Rafard',
                'ibge_code' => '3542107',
            ],

            238 => [
                'state_id'  => '26',
                'name'      => 'Rancharia',
                'ibge_code' => '3542206',
            ],

            239 => [
                'state_id'  => '26',
                'name'      => 'Redenção da Serra',
                'ibge_code' => '3542305',
            ],

            240 => [
                'state_id'  => '26',
                'name'      => 'Regente Feijó',
                'ibge_code' => '3542404',
            ],

            241 => [
                'state_id'  => '26',
                'name'      => 'Reginópolis',
                'ibge_code' => '3542503',
            ],

            242 => [
                'state_id'  => '26',
                'name'      => 'Registro',
                'ibge_code' => '3542602',
            ],

            243 => [
                'state_id'  => '26',
                'name'      => 'Restinga',
                'ibge_code' => '3542701',
            ],

            244 => [
                'state_id'  => '26',
                'name'      => 'Ribeira',
                'ibge_code' => '3542800',
            ],

            245 => [
                'state_id'  => '26',
                'name'      => 'Ribeirão Bonito',
                'ibge_code' => '3542909',
            ],

            246 => [
                'state_id'  => '26',
                'name'      => 'Ribeirão Branco',
                'ibge_code' => '3543006',
            ],

            247 => [
                'state_id'  => '26',
                'name'      => 'Ribeirão Corrente',
                'ibge_code' => '3543105',
            ],

            248 => [
                'state_id'  => '26',
                'name'      => 'Ribeirão do Sul',
                'ibge_code' => '3543204',
            ],

            249 => [
                'state_id'  => '26',
                'name'      => 'Ribeirão dos Índios',
                'ibge_code' => '3543238',
            ],

            250 => [
                'state_id'  => '26',
                'name'      => 'Ribeirão Grande',
                'ibge_code' => '3543253',
            ],

            251 => [
                'state_id'  => '26',
                'name'      => 'Ribeirão Pires',
                'ibge_code' => '3543303',
            ],

            252 => [
                'state_id'  => '26',
                'name'      => 'Ribeirão Preto',
                'ibge_code' => '3543402',
            ],

            253 => [
                'state_id'  => '26',
                'name'      => 'Riversul',
                'ibge_code' => '3543501',
            ],

            254 => [
                'state_id'  => '26',
                'name'      => 'Rifaina',
                'ibge_code' => '3543600',
            ],

            255 => [
                'state_id'  => '26',
                'name'      => 'Rincão',
                'ibge_code' => '3543709',
            ],

            256 => [
                'state_id'  => '26',
                'name'      => 'Rinópolis',
                'ibge_code' => '3543808',
            ],

            257 => [
                'state_id'  => '26',
                'name'      => 'Rio Claro',
                'ibge_code' => '3543907',
            ],

            258 => [
                'state_id'  => '26',
                'name'      => 'Rio das Pedras',
                'ibge_code' => '3544004',
            ],

            259 => [
                'state_id'  => '26',
                'name'      => 'Rio Grande da Serra',
                'ibge_code' => '3544103',
            ],

            260 => [
                'state_id'  => '26',
                'name'      => 'Riolândia',
                'ibge_code' => '3544202',
            ],

            261 => [
                'state_id'  => '26',
                'name'      => 'Rosana',
                'ibge_code' => '3544251',
            ],

            262 => [
                'state_id'  => '26',
                'name'      => 'Roseira',
                'ibge_code' => '3544301',
            ],

            263 => [
                'state_id'  => '26',
                'name'      => 'Rubiácea',
                'ibge_code' => '3544400',
            ],

            264 => [
                'state_id'  => '26',
                'name'      => 'Rubinéia',
                'ibge_code' => '3544509',
            ],

            265 => [
                'state_id'  => '26',
                'name'      => 'Sabino',
                'ibge_code' => '3544608',
            ],

            266 => [
                'state_id'  => '26',
                'name'      => 'Sagres',
                'ibge_code' => '3544707',
            ],

            267 => [
                'state_id'  => '26',
                'name'      => 'Sales',
                'ibge_code' => '3544806',
            ],

            268 => [
                'state_id'  => '26',
                'name'      => 'Sales Oliveira',
                'ibge_code' => '3544905',
            ],

            269 => [
                'state_id'  => '26',
                'name'      => 'Salesópolis',
                'ibge_code' => '3545001',
            ],

            270 => [
                'state_id'  => '26',
                'name'      => 'Salmourão',
                'ibge_code' => '3545100',
            ],

            271 => [
                'state_id'  => '26',
                'name'      => 'Saltinho',
                'ibge_code' => '3545159',
            ],

            272 => [
                'state_id'  => '26',
                'name'      => 'Salto',
                'ibge_code' => '3545209',
            ],

            273 => [
                'state_id'  => '26',
                'name'      => 'Salto de Pirapora',
                'ibge_code' => '3545308',
            ],

            274 => [
                'state_id'  => '26',
                'name'      => 'Salto Grande',
                'ibge_code' => '3545407',
            ],

            275 => [
                'state_id'  => '26',
                'name'      => 'Sandovalina',
                'ibge_code' => '3545506',
            ],

            276 => [
                'state_id'  => '26',
                'name'      => 'Santa Adélia',
                'ibge_code' => '3545605',
            ],

            277 => [
                'state_id'  => '26',
                'name'      => 'Santa Albertina',
                'ibge_code' => '3545704',
            ],

            278 => [
                'state_id'  => '26',
                'name'      => "Santa Bárbara D'oeste",
                'ibge_code' => '3545803',
            ],

            279 => [
                'state_id'  => '26',
                'name'      => 'Santa Branca',
                'ibge_code' => '3546009',
            ],

            280 => [
                'state_id'  => '26',
                'name'      => "Santa Clara D'oeste",
                'ibge_code' => '3546108',
            ],

            281 => [
                'state_id'  => '26',
                'name'      => 'Santa Cruz da Conceição',
                'ibge_code' => '3546207',
            ],

            282 => [
                'state_id'  => '26',
                'name'      => 'Santa Cruz da Esperança',
                'ibge_code' => '3546256',
            ],

            283 => [
                'state_id'  => '26',
                'name'      => 'Santa Cruz das Palmeiras',
                'ibge_code' => '3546306',
            ],

            284 => [
                'state_id'  => '26',
                'name'      => 'Santa Cruz do Rio Pardo',
                'ibge_code' => '3546405',
            ],

            285 => [
                'state_id'  => '26',
                'name'      => 'Santa Ernestina',
                'ibge_code' => '3546504',
            ],

            286 => [
                'state_id'  => '26',
                'name'      => 'Santa Fé do Sul',
                'ibge_code' => '3546603',
            ],

            287 => [
                'state_id'  => '26',
                'name'      => 'Santa Gertrudes',
                'ibge_code' => '3546702',
            ],

            288 => [
                'state_id'  => '26',
                'name'      => 'Santa Isabel',
                'ibge_code' => '3546801',
            ],

            289 => [
                'state_id'  => '26',
                'name'      => 'Santa Lúcia',
                'ibge_code' => '3546900',
            ],

            290 => [
                'state_id'  => '26',
                'name'      => 'Santa Maria da Serra',
                'ibge_code' => '3547007',
            ],

            291 => [
                'state_id'  => '26',
                'name'      => 'Santa Mercedes',
                'ibge_code' => '3547106',
            ],

            292 => [
                'state_id'  => '26',
                'name'      => 'Santana da Ponte Pensa',
                'ibge_code' => '3547205',
            ],

            293 => [
                'state_id'  => '26',
                'name'      => 'Santana de Parnaíba',
                'ibge_code' => '3547304',
            ],

            294 => [
                'state_id'  => '26',
                'name'      => "Santa Rita D'oeste",
                'ibge_code' => '3547403',
            ],

            295 => [
                'state_id'  => '26',
                'name'      => 'Santa Rita do Passa Quatro',
                'ibge_code' => '3547502',
            ],

            296 => [
                'state_id'  => '26',
                'name'      => 'Santa Rosa de Viterbo',
                'ibge_code' => '3547601',
            ],

            297 => [
                'state_id'  => '26',
                'name'      => 'Santa Salete',
                'ibge_code' => '3547650',
            ],

            298 => [
                'state_id'  => '26',
                'name'      => 'Santo Anastácio',
                'ibge_code' => '3547700',
            ],

            299 => [
                'state_id'  => '26',
                'name'      => 'Santo André',
                'ibge_code' => '3547809',
            ],

            300 => [
                'state_id'  => '26',
                'name'      => 'Santo Antônio da Alegria',
                'ibge_code' => '3547908',
            ],

            301 => [
                'state_id'  => '26',
                'name'      => 'Santo Antônio de Posse',
                'ibge_code' => '3548005',
            ],

            302 => [
                'state_id'  => '26',
                'name'      => 'Santo Antônio do Aracanguá',
                'ibge_code' => '3548054',
            ],

            303 => [
                'state_id'  => '26',
                'name'      => 'Santo Antônio do Jardim',
                'ibge_code' => '3548104',
            ],

            304 => [
                'state_id'  => '26',
                'name'      => 'Santo Antônio do Pinhal',
                'ibge_code' => '3548203',
            ],

            305 => [
                'state_id'  => '26',
                'name'      => 'Santo Expedito',
                'ibge_code' => '3548302',
            ],

            306 => [
                'state_id'  => '26',
                'name'      => 'Santópolis do Aguapeí',
                'ibge_code' => '3548401',
            ],

            307 => [
                'state_id'  => '26',
                'name'      => 'Santos',
                'ibge_code' => '3548500',
            ],

            308 => [
                'state_id'  => '26',
                'name'      => 'São Bento do Sapucaí',
                'ibge_code' => '3548609',
            ],

            309 => [
                'state_id'  => '26',
                'name'      => 'São Bernardo do Campo',
                'ibge_code' => '3548708',
            ],

            310 => [
                'state_id'  => '26',
                'name'      => 'São Caetano do Sul',
                'ibge_code' => '3548807',
            ],

            311 => [
                'state_id'  => '26',
                'name'      => 'São Carlos',
                'ibge_code' => '3548906',
            ],

            312 => [
                'state_id'  => '26',
                'name'      => 'São Francisco',
                'ibge_code' => '3549003',
            ],

            313 => [
                'state_id'  => '26',
                'name'      => 'São João da Boa Vista',
                'ibge_code' => '3549102',
            ],

            314 => [
                'state_id'  => '26',
                'name'      => 'São João das Duas Pontes',
                'ibge_code' => '3549201',
            ],

            315 => [
                'state_id'  => '26',
                'name'      => 'São João de Iracema',
                'ibge_code' => '3549250',
            ],

            316 => [
                'state_id'  => '26',
                'name'      => "São João do Pau D'alho",
                'ibge_code' => '3549300',
            ],

            317 => [
                'state_id'  => '26',
                'name'      => 'São Joaquim da Barra',
                'ibge_code' => '3549409',
            ],

            318 => [
                'state_id'  => '26',
                'name'      => 'São José da Bela Vista',
                'ibge_code' => '3549508',
            ],

            319 => [
                'state_id'  => '26',
                'name'      => 'São José do Barreiro',
                'ibge_code' => '3549607',
            ],

            320 => [
                'state_id'  => '26',
                'name'      => 'São José do Rio Pardo',
                'ibge_code' => '3549706',
            ],

            321 => [
                'state_id'  => '26',
                'name'      => 'São José do Rio Preto',
                'ibge_code' => '3549805',
            ],

            322 => [
                'state_id'  => '26',
                'name'      => 'São José dos Campos',
                'ibge_code' => '3549904',
            ],

            323 => [
                'state_id'  => '26',
                'name'      => 'São Lourenço da Serra',
                'ibge_code' => '3549953',
            ],

            324 => [
                'state_id'  => '26',
                'name'      => 'São Luís do Paraitinga',
                'ibge_code' => '3550001',
            ],

            325 => [
                'state_id'  => '26',
                'name'      => 'São Manuel',
                'ibge_code' => '3550100',
            ],

            326 => [
                'state_id'  => '26',
                'name'      => 'São Miguel Arcanjo',
                'ibge_code' => '3550209',
            ],

            327 => [
                'state_id'  => '26',
                'name'      => 'São Paulo',
                'ibge_code' => '3550308',
            ],

            328 => [
                'state_id'  => '26',
                'name'      => 'São Pedro',
                'ibge_code' => '3550407',
            ],

            329 => [
                'state_id'  => '26',
                'name'      => 'São Pedro do Turvo',
                'ibge_code' => '3550506',
            ],

            330 => [
                'state_id'  => '26',
                'name'      => 'São Roque',
                'ibge_code' => '3550605',
            ],

            331 => [
                'state_id'  => '26',
                'name'      => 'São Sebastião',
                'ibge_code' => '3550704',
            ],

            332 => [
                'state_id'  => '26',
                'name'      => 'São Sebastião da Grama',
                'ibge_code' => '3550803',
            ],

            333 => [
                'state_id'  => '26',
                'name'      => 'São Simão',
                'ibge_code' => '3550902',
            ],

            334 => [
                'state_id'  => '26',
                'name'      => 'São Vicente',
                'ibge_code' => '3551009',
            ],

            335 => [
                'state_id'  => '26',
                'name'      => 'Sarapuí',
                'ibge_code' => '3551108',
            ],

            336 => [
                'state_id'  => '26',
                'name'      => 'Sarutaiá',
                'ibge_code' => '3551207',
            ],

            337 => [
                'state_id'  => '26',
                'name'      => 'Sebastianópolis do Sul',
                'ibge_code' => '3551306',
            ],

            338 => [
                'state_id'  => '26',
                'name'      => 'Serra Azul',
                'ibge_code' => '3551405',
            ],

            339 => [
                'state_id'  => '26',
                'name'      => 'Serrana',
                'ibge_code' => '3551504',
            ],

            340 => [
                'state_id'  => '26',
                'name'      => 'Serra Negra',
                'ibge_code' => '3551603',
            ],

            341 => [
                'state_id'  => '26',
                'name'      => 'Sertãozinho',
                'ibge_code' => '3551702',
            ],

            342 => [
                'state_id'  => '26',
                'name'      => 'Sete Barras',
                'ibge_code' => '3551801',
            ],

            343 => [
                'state_id'  => '26',
                'name'      => 'Severínia',
                'ibge_code' => '3551900',
            ],

            344 => [
                'state_id'  => '26',
                'name'      => 'Silveiras',
                'ibge_code' => '3552007',
            ],

            345 => [
                'state_id'  => '26',
                'name'      => 'Socorro',
                'ibge_code' => '3552106',
            ],

            346 => [
                'state_id'  => '26',
                'name'      => 'Sorocaba',
                'ibge_code' => '3552205',
            ],

            347 => [
                'state_id'  => '26',
                'name'      => 'Sud Mennucci',
                'ibge_code' => '3552304',
            ],

            348 => [
                'state_id'  => '26',
                'name'      => 'Sumaré',
                'ibge_code' => '3552403',
            ],

            349 => [
                'state_id'  => '26',
                'name'      => 'Suzano',
                'ibge_code' => '3552502',
            ],

            350 => [
                'state_id'  => '26',
                'name'      => 'Suzanápolis',
                'ibge_code' => '3552551',
            ],

            351 => [
                'state_id'  => '26',
                'name'      => 'Tabapuã',
                'ibge_code' => '3552601',
            ],

            352 => [
                'state_id'  => '26',
                'name'      => 'Tabatinga',
                'ibge_code' => '3552700',
            ],

            353 => [
                'state_id'  => '26',
                'name'      => 'Taboão da Serra',
                'ibge_code' => '3552809',
            ],

            354 => [
                'state_id'  => '26',
                'name'      => 'Taciba',
                'ibge_code' => '3552908',
            ],

            355 => [
                'state_id'  => '26',
                'name'      => 'Taguaí',
                'ibge_code' => '3553005',
            ],

            356 => [
                'state_id'  => '26',
                'name'      => 'Taiaçu',
                'ibge_code' => '3553104',
            ],

            357 => [
                'state_id'  => '26',
                'name'      => 'Taiúva',
                'ibge_code' => '3553203',
            ],

            358 => [
                'state_id'  => '26',
                'name'      => 'Tambaú',
                'ibge_code' => '3553302',
            ],

            359 => [
                'state_id'  => '26',
                'name'      => 'Tanabi',
                'ibge_code' => '3553401',
            ],

            360 => [
                'state_id'  => '26',
                'name'      => 'Tapiraí',
                'ibge_code' => '3553500',
            ],

            361 => [
                'state_id'  => '26',
                'name'      => 'Tapiratiba',
                'ibge_code' => '3553609',
            ],

            362 => [
                'state_id'  => '26',
                'name'      => 'Taquaral',
                'ibge_code' => '3553658',
            ],

            363 => [
                'state_id'  => '26',
                'name'      => 'Taquaritinga',
                'ibge_code' => '3553708',
            ],

            364 => [
                'state_id'  => '26',
                'name'      => 'Taquarituba',
                'ibge_code' => '3553807',
            ],

            365 => [
                'state_id'  => '26',
                'name'      => 'Taquarivaí',
                'ibge_code' => '3553856',
            ],

            366 => [
                'state_id'  => '26',
                'name'      => 'Tarabai',
                'ibge_code' => '3553906',
            ],

            367 => [
                'state_id'  => '26',
                'name'      => 'Tarumã',
                'ibge_code' => '3553955',
            ],

            368 => [
                'state_id'  => '26',
                'name'      => 'Tatuí',
                'ibge_code' => '3554003',
            ],

            369 => [
                'state_id'  => '26',
                'name'      => 'Taubaté',
                'ibge_code' => '3554102',
            ],

            370 => [
                'state_id'  => '26',
                'name'      => 'Tejupá',
                'ibge_code' => '3554201',
            ],

            371 => [
                'state_id'  => '26',
                'name'      => 'Teodoro Sampaio',
                'ibge_code' => '3554300',
            ],

            372 => [
                'state_id'  => '26',
                'name'      => 'Terra Roxa',
                'ibge_code' => '3554409',
            ],

            373 => [
                'state_id'  => '26',
                'name'      => 'Tietê',
                'ibge_code' => '3554508',
            ],

            374 => [
                'state_id'  => '26',
                'name'      => 'Timburi',
                'ibge_code' => '3554607',
            ],

            375 => [
                'state_id'  => '26',
                'name'      => 'Torre de Pedra',
                'ibge_code' => '3554656',
            ],

            376 => [
                'state_id'  => '26',
                'name'      => 'Torrinha',
                'ibge_code' => '3554706',
            ],

            377 => [
                'state_id'  => '26',
                'name'      => 'Trabiju',
                'ibge_code' => '3554755',
            ],

            378 => [
                'state_id'  => '26',
                'name'      => 'Tremembé',
                'ibge_code' => '3554805',
            ],

            379 => [
                'state_id'  => '26',
                'name'      => 'Três Fronteiras',
                'ibge_code' => '3554904',
            ],

            380 => [
                'state_id'  => '26',
                'name'      => 'Tuiuti',
                'ibge_code' => '3554953',
            ],

            381 => [
                'state_id'  => '26',
                'name'      => 'Tupã',
                'ibge_code' => '3555000',
            ],

            382 => [
                'state_id'  => '26',
                'name'      => 'Tupi Paulista',
                'ibge_code' => '3555109',
            ],

            383 => [
                'state_id'  => '26',
                'name'      => 'Turiúba',
                'ibge_code' => '3555208',
            ],

            384 => [
                'state_id'  => '26',
                'name'      => 'Turmalina',
                'ibge_code' => '3555307',
            ],

            385 => [
                'state_id'  => '26',
                'name'      => 'Ubarana',
                'ibge_code' => '3555356',
            ],

            386 => [
                'state_id'  => '26',
                'name'      => 'Ubatuba',
                'ibge_code' => '3555406',
            ],

            387 => [
                'state_id'  => '26',
                'name'      => 'Ubirajara',
                'ibge_code' => '3555505',
            ],

            388 => [
                'state_id'  => '26',
                'name'      => 'Uchoa',
                'ibge_code' => '3555604',
            ],

            389 => [
                'state_id'  => '26',
                'name'      => 'União Paulista',
                'ibge_code' => '3555703',
            ],

            390 => [
                'state_id'  => '26',
                'name'      => 'Urânia',
                'ibge_code' => '3555802',
            ],

            391 => [
                'state_id'  => '26',
                'name'      => 'Uru',
                'ibge_code' => '3555901',
            ],

            392 => [
                'state_id'  => '26',
                'name'      => 'Urupês',
                'ibge_code' => '3556008',
            ],

            393 => [
                'state_id'  => '26',
                'name'      => 'Valentim Gentil',
                'ibge_code' => '3556107',
            ],

            394 => [
                'state_id'  => '26',
                'name'      => 'Valinhos',
                'ibge_code' => '3556206',
            ],

            395 => [
                'state_id'  => '26',
                'name'      => 'Valparaíso',
                'ibge_code' => '3556305',
            ],

            396 => [
                'state_id'  => '26',
                'name'      => 'Vargem',
                'ibge_code' => '3556354',
            ],

            397 => [
                'state_id'  => '26',
                'name'      => 'Vargem Grande do Sul',
                'ibge_code' => '3556404',
            ],

            398 => [
                'state_id'  => '26',
                'name'      => 'Vargem Grande Paulista',
                'ibge_code' => '3556453',
            ],

            399 => [
                'state_id'  => '26',
                'name'      => 'Várzea Paulista',
                'ibge_code' => '3556503',
            ],

            400 => [
                'state_id'  => '26',
                'name'      => 'Vera Cruz',
                'ibge_code' => '3556602',
            ],

            401 => [
                'state_id'  => '26',
                'name'      => 'Vinhedo',
                'ibge_code' => '3556701',
            ],

            402 => [
                'state_id'  => '26',
                'name'      => 'Viradouro',
                'ibge_code' => '3556800',
            ],

            403 => [
                'state_id'  => '26',
                'name'      => 'Vista Alegre do Alto',
                'ibge_code' => '3556909',
            ],

            404 => [
                'state_id'  => '26',
                'name'      => 'Vitória Brasil',
                'ibge_code' => '3556958',
            ],

            405 => [
                'state_id'  => '26',
                'name'      => 'Votorantim',
                'ibge_code' => '3557006',
            ],

            406 => [
                'state_id'  => '26',
                'name'      => 'Votuporanga',
                'ibge_code' => '3557105',
            ],

            407 => [
                'state_id'  => '26',
                'name'      => 'Zacarias',
                'ibge_code' => '3557154',
            ],

            408 => [
                'state_id'  => '26',
                'name'      => 'Chavantes',
                'ibge_code' => '3557204',
            ],

            409 => [
                'state_id'  => '26',
                'name'      => 'Estiva Gerbi',
                'ibge_code' => '3557303',
            ],

            410 => [
                'state_id'  => '18',
                'name'      => 'Abatiá',
                'ibge_code' => '4100103',
            ],

            411 => [
                'state_id'  => '18',
                'name'      => 'Adrianópolis',
                'ibge_code' => '4100202',
            ],

            412 => [
                'state_id'  => '18',
                'name'      => 'Agudos do Sul',
                'ibge_code' => '4100301',
            ],

            413 => [
                'state_id'  => '18',
                'name'      => 'Almirante Tamandaré',
                'ibge_code' => '4100400',
            ],

            414 => [
                'state_id'  => '18',
                'name'      => 'Altamira do Paraná',
                'ibge_code' => '4100459',
            ],

            415 => [
                'state_id'  => '18',
                'name'      => 'Altônia',
                'ibge_code' => '4100509',
            ],

            416 => [
                'state_id'  => '18',
                'name'      => 'Alto Paraná',
                'ibge_code' => '4100608',
            ],

            417 => [
                'state_id'  => '18',
                'name'      => 'Alto Piquiri',
                'ibge_code' => '4100707',
            ],

            418 => [
                'state_id'  => '18',
                'name'      => 'Alvorada do Sul',
                'ibge_code' => '4100806',
            ],

            419 => [
                'state_id'  => '18',
                'name'      => 'Amaporã',
                'ibge_code' => '4100905',
            ],

            420 => [
                'state_id'  => '18',
                'name'      => 'Ampére',
                'ibge_code' => '4101002',
            ],

            421 => [
                'state_id'  => '18',
                'name'      => 'Anahy',
                'ibge_code' => '4101051',
            ],

            422 => [
                'state_id'  => '18',
                'name'      => 'Andirá',
                'ibge_code' => '4101101',
            ],

            423 => [
                'state_id'  => '18',
                'name'      => 'Ângulo',
                'ibge_code' => '4101150',
            ],

            424 => [
                'state_id'  => '18',
                'name'      => 'Antonina',
                'ibge_code' => '4101200',
            ],

            425 => [
                'state_id'  => '18',
                'name'      => 'Antônio Olinto',
                'ibge_code' => '4101309',
            ],

            426 => [
                'state_id'  => '18',
                'name'      => 'Apucarana',
                'ibge_code' => '4101408',
            ],

            427 => [
                'state_id'  => '18',
                'name'      => 'Arapongas',
                'ibge_code' => '4101507',
            ],

            428 => [
                'state_id'  => '18',
                'name'      => 'Arapoti',
                'ibge_code' => '4101606',
            ],

            429 => [
                'state_id'  => '18',
                'name'      => 'Arapuã',
                'ibge_code' => '4101655',
            ],

            430 => [
                'state_id'  => '18',
                'name'      => 'Araruna',
                'ibge_code' => '4101705',
            ],

            431 => [
                'state_id'  => '18',
                'name'      => 'Araucária',
                'ibge_code' => '4101804',
            ],

            432 => [
                'state_id'  => '18',
                'name'      => 'Ariranha do Ivaí',
                'ibge_code' => '4101853',
            ],

            433 => [
                'state_id'  => '18',
                'name'      => 'Assaí',
                'ibge_code' => '4101903',
            ],

            434 => [
                'state_id'  => '18',
                'name'      => 'Assis Chateaubriand',
                'ibge_code' => '4102000',
            ],

            435 => [
                'state_id'  => '18',
                'name'      => 'Astorga',
                'ibge_code' => '4102109',
            ],

            436 => [
                'state_id'  => '18',
                'name'      => 'Atalaia',
                'ibge_code' => '4102208',
            ],

            437 => [
                'state_id'  => '18',
                'name'      => 'Balsa Nova',
                'ibge_code' => '4102307',
            ],

            438 => [
                'state_id'  => '18',
                'name'      => 'Bandeirantes',
                'ibge_code' => '4102406',
            ],

            439 => [
                'state_id'  => '18',
                'name'      => 'Barbosa Ferraz',
                'ibge_code' => '4102505',
            ],

            440 => [
                'state_id'  => '18',
                'name'      => 'Barracão',
                'ibge_code' => '4102604',
            ],

            441 => [
                'state_id'  => '18',
                'name'      => 'Barra do Jacaré',
                'ibge_code' => '4102703',
            ],

            442 => [
                'state_id'  => '18',
                'name'      => 'Bela Vista da Caroba',
                'ibge_code' => '4102752',
            ],

            443 => [
                'state_id'  => '18',
                'name'      => 'Bela Vista do Paraíso',
                'ibge_code' => '4102802',
            ],

            444 => [
                'state_id'  => '18',
                'name'      => 'Bituruna',
                'ibge_code' => '4102901',
            ],

            445 => [
                'state_id'  => '18',
                'name'      => 'Boa Esperança',
                'ibge_code' => '4103008',
            ],

            446 => [
                'state_id'  => '18',
                'name'      => 'Boa Esperança do Iguaçu',
                'ibge_code' => '4103024',
            ],

            447 => [
                'state_id'  => '18',
                'name'      => 'Boa Ventura de São Roque',
                'ibge_code' => '4103040',
            ],

            448 => [
                'state_id'  => '18',
                'name'      => 'Boa Vista da Aparecida',
                'ibge_code' => '4103057',
            ],

            449 => [
                'state_id'  => '18',
                'name'      => 'Bocaiúva do Sul',
                'ibge_code' => '4103107',
            ],

            450 => [
                'state_id'  => '18',
                'name'      => 'Bom Jesus do Sul',
                'ibge_code' => '4103156',
            ],

            451 => [
                'state_id'  => '18',
                'name'      => 'Bom Sucesso',
                'ibge_code' => '4103206',
            ],

            452 => [
                'state_id'  => '18',
                'name'      => 'Bom Sucesso do Sul',
                'ibge_code' => '4103222',
            ],

            453 => [
                'state_id'  => '18',
                'name'      => 'Borrazópolis',
                'ibge_code' => '4103305',
            ],

            454 => [
                'state_id'  => '18',
                'name'      => 'Braganey',
                'ibge_code' => '4103354',
            ],

            455 => [
                'state_id'  => '18',
                'name'      => 'Brasilândia do Sul',
                'ibge_code' => '4103370',
            ],

            456 => [
                'state_id'  => '18',
                'name'      => 'Cafeara',
                'ibge_code' => '4103404',
            ],

            457 => [
                'state_id'  => '18',
                'name'      => 'Cafelândia',
                'ibge_code' => '4103453',
            ],

            458 => [
                'state_id'  => '18',
                'name'      => 'Cafezal do Sul',
                'ibge_code' => '4103479',
            ],

            459 => [
                'state_id'  => '18',
                'name'      => 'Califórnia',
                'ibge_code' => '4103503',
            ],

            460 => [
                'state_id'  => '18',
                'name'      => 'Cambará',
                'ibge_code' => '4103602',
            ],

            461 => [
                'state_id'  => '18',
                'name'      => 'Cambé',
                'ibge_code' => '4103701',
            ],

            462 => [
                'state_id'  => '18',
                'name'      => 'Cambira',
                'ibge_code' => '4103800',
            ],

            463 => [
                'state_id'  => '18',
                'name'      => 'Campina da Lagoa',
                'ibge_code' => '4103909',
            ],

            464 => [
                'state_id'  => '18',
                'name'      => 'Campina do Simão',
                'ibge_code' => '4103958',
            ],

            465 => [
                'state_id'  => '18',
                'name'      => 'Campina Grande do Sul',
                'ibge_code' => '4104006',
            ],

            466 => [
                'state_id'  => '18',
                'name'      => 'Campo Bonito',
                'ibge_code' => '4104055',
            ],

            467 => [
                'state_id'  => '18',
                'name'      => 'Campo do Tenente',
                'ibge_code' => '4104105',
            ],

            468 => [
                'state_id'  => '18',
                'name'      => 'Campo Largo',
                'ibge_code' => '4104204',
            ],

            469 => [
                'state_id'  => '18',
                'name'      => 'Campo Magro',
                'ibge_code' => '4104253',
            ],

            470 => [
                'state_id'  => '18',
                'name'      => 'Campo Mourão',
                'ibge_code' => '4104303',
            ],

            471 => [
                'state_id'  => '18',
                'name'      => 'Cândido de Abreu',
                'ibge_code' => '4104402',
            ],

            472 => [
                'state_id'  => '18',
                'name'      => 'Candói',
                'ibge_code' => '4104428',
            ],

            473 => [
                'state_id'  => '18',
                'name'      => 'Cantagalo',
                'ibge_code' => '4104451',
            ],

            474 => [
                'state_id'  => '18',
                'name'      => 'Capanema',
                'ibge_code' => '4104501',
            ],

            475 => [
                'state_id'  => '18',
                'name'      => 'Capitão Leônidas Marques',
                'ibge_code' => '4104600',
            ],

            476 => [
                'state_id'  => '18',
                'name'      => 'Carambeí',
                'ibge_code' => '4104659',
            ],

            477 => [
                'state_id'  => '18',
                'name'      => 'Carlópolis',
                'ibge_code' => '4104709',
            ],

            478 => [
                'state_id'  => '18',
                'name'      => 'Cascavel',
                'ibge_code' => '4104808',
            ],

            479 => [
                'state_id'  => '18',
                'name'      => 'Castro',
                'ibge_code' => '4104907',
            ],

            480 => [
                'state_id'  => '18',
                'name'      => 'Catanduvas',
                'ibge_code' => '4105003',
            ],

            481 => [
                'state_id'  => '18',
                'name'      => 'Centenário do Sul',
                'ibge_code' => '4105102',
            ],

            482 => [
                'state_id'  => '18',
                'name'      => 'Cerro Azul',
                'ibge_code' => '4105201',
            ],

            483 => [
                'state_id'  => '18',
                'name'      => 'Céu Azul',
                'ibge_code' => '4105300',
            ],

            484 => [
                'state_id'  => '18',
                'name'      => 'Chopinzinho',
                'ibge_code' => '4105409',
            ],

            485 => [
                'state_id'  => '18',
                'name'      => 'Cianorte',
                'ibge_code' => '4105508',
            ],

            486 => [
                'state_id'  => '18',
                'name'      => 'Cidade Gaúcha',
                'ibge_code' => '4105607',
            ],

            487 => [
                'state_id'  => '18',
                'name'      => 'Clevelândia',
                'ibge_code' => '4105706',
            ],

            488 => [
                'state_id'  => '18',
                'name'      => 'Colombo',
                'ibge_code' => '4105805',
            ],

            489 => [
                'state_id'  => '18',
                'name'      => 'Colorado',
                'ibge_code' => '4105904',
            ],

            490 => [
                'state_id'  => '18',
                'name'      => 'Congonhinhas',
                'ibge_code' => '4106001',
            ],

            491 => [
                'state_id'  => '18',
                'name'      => 'Conselheiro Mairinck',
                'ibge_code' => '4106100',
            ],

            492 => [
                'state_id'  => '18',
                'name'      => 'Contenda',
                'ibge_code' => '4106209',
            ],

            493 => [
                'state_id'  => '18',
                'name'      => 'Corbélia',
                'ibge_code' => '4106308',
            ],

            494 => [
                'state_id'  => '18',
                'name'      => 'Cornélio Procópio',
                'ibge_code' => '4106407',
            ],

            495 => [
                'state_id'  => '18',
                'name'      => 'Coronel Domingos Soares',
                'ibge_code' => '4106456',
            ],

            496 => [
                'state_id'  => '18',
                'name'      => 'Coronel Vivida',
                'ibge_code' => '4106506',
            ],

            497 => [
                'state_id'  => '18',
                'name'      => 'Corumbataí do Sul',
                'ibge_code' => '4106555',
            ],

            498 => [
                'state_id'  => '18',
                'name'      => 'Cruzeiro do Iguaçu',
                'ibge_code' => '4106571',
            ],

            499 => [
                'state_id'  => '18',
                'name'      => 'Cruzeiro do Oeste',
                'ibge_code' => '4106605',
            ],

        ]);
        DB::table('cities')->insert([
            0 => [
                'state_id'  => '18',
                'name'      => 'Cruzeiro do Sul',
                'ibge_code' => '4106704',
            ],

            1 => [
                'state_id'  => '18',
                'name'      => 'Cruz Machado',
                'ibge_code' => '4106803',
            ],

            2 => [
                'state_id'  => '18',
                'name'      => 'Cruzmaltina',
                'ibge_code' => '4106852',
            ],

            3 => [
                'state_id'  => '18',
                'name'      => 'Curitiba',
                'ibge_code' => '4106902',
            ],

            4 => [
                'state_id'  => '18',
                'name'      => 'Curiúva',
                'ibge_code' => '4107009',
            ],

            5 => [
                'state_id'  => '18',
                'name'      => 'Diamante do Norte',
                'ibge_code' => '4107108',
            ],

            6 => [
                'state_id'  => '18',
                'name'      => 'Diamante do Sul',
                'ibge_code' => '4107124',
            ],

            7 => [
                'state_id'  => '18',
                'name'      => "Diamante D'oeste",
                'ibge_code' => '4107157',
            ],

            8 => [
                'state_id'  => '18',
                'name'      => 'Dois Vizinhos',
                'ibge_code' => '4107207',
            ],

            9 => [
                'state_id'  => '18',
                'name'      => 'Douradina',
                'ibge_code' => '4107256',
            ],

            10 => [
                'state_id'  => '18',
                'name'      => 'Doutor Camargo',
                'ibge_code' => '4107306',
            ],

            11 => [
                'state_id'  => '18',
                'name'      => 'Enéas Marques',
                'ibge_code' => '4107405',
            ],

            12 => [
                'state_id'  => '18',
                'name'      => 'Engenheiro Beltrão',
                'ibge_code' => '4107504',
            ],

            13 => [
                'state_id'  => '18',
                'name'      => 'Esperança Nova',
                'ibge_code' => '4107520',
            ],

            14 => [
                'state_id'  => '18',
                'name'      => 'Entre Rios do Oeste',
                'ibge_code' => '4107538',
            ],

            15 => [
                'state_id'  => '18',
                'name'      => 'Espigão Alto do Iguaçu',
                'ibge_code' => '4107546',
            ],

            16 => [
                'state_id'  => '18',
                'name'      => 'Farol',
                'ibge_code' => '4107553',
            ],

            17 => [
                'state_id'  => '18',
                'name'      => 'Faxinal',
                'ibge_code' => '4107603',
            ],

            18 => [
                'state_id'  => '18',
                'name'      => 'Fazenda Rio Grande',
                'ibge_code' => '4107652',
            ],

            19 => [
                'state_id'  => '18',
                'name'      => 'Fênix',
                'ibge_code' => '4107702',
            ],

            20 => [
                'state_id'  => '18',
                'name'      => 'Fernandes Pinheiro',
                'ibge_code' => '4107736',
            ],

            21 => [
                'state_id'  => '18',
                'name'      => 'Figueira',
                'ibge_code' => '4107751',
            ],

            22 => [
                'state_id'  => '18',
                'name'      => 'Floraí',
                'ibge_code' => '4107801',
            ],

            23 => [
                'state_id'  => '18',
                'name'      => 'Flor da Serra do Sul',
                'ibge_code' => '4107850',
            ],

            24 => [
                'state_id'  => '18',
                'name'      => 'Floresta',
                'ibge_code' => '4107900',
            ],

            25 => [
                'state_id'  => '18',
                'name'      => 'Florestópolis',
                'ibge_code' => '4108007',
            ],

            26 => [
                'state_id'  => '18',
                'name'      => 'Flórida',
                'ibge_code' => '4108106',
            ],

            27 => [
                'state_id'  => '18',
                'name'      => 'Formosa do Oeste',
                'ibge_code' => '4108205',
            ],

            28 => [
                'state_id'  => '18',
                'name'      => 'Foz do Iguaçu',
                'ibge_code' => '4108304',
            ],

            29 => [
                'state_id'  => '18',
                'name'      => 'Francisco Alves',
                'ibge_code' => '4108320',
            ],

            30 => [
                'state_id'  => '18',
                'name'      => 'Francisco Beltrão',
                'ibge_code' => '4108403',
            ],

            31 => [
                'state_id'  => '18',
                'name'      => 'Foz do Jordão',
                'ibge_code' => '4108452',
            ],

            32 => [
                'state_id'  => '18',
                'name'      => 'General Carneiro',
                'ibge_code' => '4108502',
            ],

            33 => [
                'state_id'  => '18',
                'name'      => 'Godoy Moreira',
                'ibge_code' => '4108551',
            ],

            34 => [
                'state_id'  => '18',
                'name'      => 'Goioerê',
                'ibge_code' => '4108601',
            ],

            35 => [
                'state_id'  => '18',
                'name'      => 'Goioxim',
                'ibge_code' => '4108650',
            ],

            36 => [
                'state_id'  => '18',
                'name'      => 'Grandes Rios',
                'ibge_code' => '4108700',
            ],

            37 => [
                'state_id'  => '18',
                'name'      => 'Guaíra',
                'ibge_code' => '4108809',
            ],

            38 => [
                'state_id'  => '18',
                'name'      => 'Guairaçá',
                'ibge_code' => '4108908',
            ],

            39 => [
                'state_id'  => '18',
                'name'      => 'Guamiranga',
                'ibge_code' => '4108957',
            ],

            40 => [
                'state_id'  => '18',
                'name'      => 'Guapirama',
                'ibge_code' => '4109005',
            ],

            41 => [
                'state_id'  => '18',
                'name'      => 'Guaporema',
                'ibge_code' => '4109104',
            ],

            42 => [
                'state_id'  => '18',
                'name'      => 'Guaraci',
                'ibge_code' => '4109203',
            ],

            43 => [
                'state_id'  => '18',
                'name'      => 'Guaraniaçu',
                'ibge_code' => '4109302',
            ],

            44 => [
                'state_id'  => '18',
                'name'      => 'Guarapuava',
                'ibge_code' => '4109401',
            ],

            45 => [
                'state_id'  => '18',
                'name'      => 'Guaraqueçaba',
                'ibge_code' => '4109500',
            ],

            46 => [
                'state_id'  => '18',
                'name'      => 'Guaratuba',
                'ibge_code' => '4109609',
            ],

            47 => [
                'state_id'  => '18',
                'name'      => 'Honório Serpa',
                'ibge_code' => '4109658',
            ],

            48 => [
                'state_id'  => '18',
                'name'      => 'Ibaiti',
                'ibge_code' => '4109708',
            ],

            49 => [
                'state_id'  => '18',
                'name'      => 'Ibema',
                'ibge_code' => '4109757',
            ],

            50 => [
                'state_id'  => '18',
                'name'      => 'Ibiporã',
                'ibge_code' => '4109807',
            ],

            51 => [
                'state_id'  => '18',
                'name'      => 'Icaraíma',
                'ibge_code' => '4109906',
            ],

            52 => [
                'state_id'  => '18',
                'name'      => 'Iguaraçu',
                'ibge_code' => '4110003',
            ],

            53 => [
                'state_id'  => '18',
                'name'      => 'Iguatu',
                'ibge_code' => '4110052',
            ],

            54 => [
                'state_id'  => '18',
                'name'      => 'Imbaú',
                'ibge_code' => '4110078',
            ],

            55 => [
                'state_id'  => '18',
                'name'      => 'Imbituva',
                'ibge_code' => '4110102',
            ],

            56 => [
                'state_id'  => '18',
                'name'      => 'Inácio Martins',
                'ibge_code' => '4110201',
            ],

            57 => [
                'state_id'  => '18',
                'name'      => 'Inajá',
                'ibge_code' => '4110300',
            ],

            58 => [
                'state_id'  => '18',
                'name'      => 'Indianópolis',
                'ibge_code' => '4110409',
            ],

            59 => [
                'state_id'  => '18',
                'name'      => 'Ipiranga',
                'ibge_code' => '4110508',
            ],

            60 => [
                'state_id'  => '18',
                'name'      => 'Iporã',
                'ibge_code' => '4110607',
            ],

            61 => [
                'state_id'  => '18',
                'name'      => 'Iracema do Oeste',
                'ibge_code' => '4110656',
            ],

            62 => [
                'state_id'  => '18',
                'name'      => 'Irati',
                'ibge_code' => '4110706',
            ],

            63 => [
                'state_id'  => '18',
                'name'      => 'Iretama',
                'ibge_code' => '4110805',
            ],

            64 => [
                'state_id'  => '18',
                'name'      => 'Itaguajé',
                'ibge_code' => '4110904',
            ],

            65 => [
                'state_id'  => '18',
                'name'      => 'Itaipulândia',
                'ibge_code' => '4110953',
            ],

            66 => [
                'state_id'  => '18',
                'name'      => 'Itambaracá',
                'ibge_code' => '4111001',
            ],

            67 => [
                'state_id'  => '18',
                'name'      => 'Itambé',
                'ibge_code' => '4111100',
            ],

            68 => [
                'state_id'  => '18',
                'name'      => "Itapejara D'oeste",
                'ibge_code' => '4111209',
            ],

            69 => [
                'state_id'  => '18',
                'name'      => 'Itaperuçu',
                'ibge_code' => '4111258',
            ],

            70 => [
                'state_id'  => '18',
                'name'      => 'Itaúna do Sul',
                'ibge_code' => '4111308',
            ],

            71 => [
                'state_id'  => '18',
                'name'      => 'Ivaí',
                'ibge_code' => '4111407',
            ],

            72 => [
                'state_id'  => '18',
                'name'      => 'Ivaiporã',
                'ibge_code' => '4111506',
            ],

            73 => [
                'state_id'  => '18',
                'name'      => 'Ivaté',
                'ibge_code' => '4111555',
            ],

            74 => [
                'state_id'  => '18',
                'name'      => 'Ivatuba',
                'ibge_code' => '4111605',
            ],

            75 => [
                'state_id'  => '18',
                'name'      => 'Jaboti',
                'ibge_code' => '4111704',
            ],

            76 => [
                'state_id'  => '18',
                'name'      => 'Jacarezinho',
                'ibge_code' => '4111803',
            ],

            77 => [
                'state_id'  => '18',
                'name'      => 'Jaguapitã',
                'ibge_code' => '4111902',
            ],

            78 => [
                'state_id'  => '18',
                'name'      => 'Jaguariaíva',
                'ibge_code' => '4112009',
            ],

            79 => [
                'state_id'  => '18',
                'name'      => 'Jandaia do Sul',
                'ibge_code' => '4112108',
            ],

            80 => [
                'state_id'  => '18',
                'name'      => 'Janiópolis',
                'ibge_code' => '4112207',
            ],

            81 => [
                'state_id'  => '18',
                'name'      => 'Japira',
                'ibge_code' => '4112306',
            ],

            82 => [
                'state_id'  => '18',
                'name'      => 'Japurá',
                'ibge_code' => '4112405',
            ],

            83 => [
                'state_id'  => '18',
                'name'      => 'Jardim Alegre',
                'ibge_code' => '4112504',
            ],

            84 => [
                'state_id'  => '18',
                'name'      => 'Jardim Olinda',
                'ibge_code' => '4112603',
            ],

            85 => [
                'state_id'  => '18',
                'name'      => 'Jataizinho',
                'ibge_code' => '4112702',
            ],

            86 => [
                'state_id'  => '18',
                'name'      => 'Jesuítas',
                'ibge_code' => '4112751',
            ],

            87 => [
                'state_id'  => '18',
                'name'      => 'Joaquim Távora',
                'ibge_code' => '4112801',
            ],

            88 => [
                'state_id'  => '18',
                'name'      => 'Jundiaí do Sul',
                'ibge_code' => '4112900',
            ],

            89 => [
                'state_id'  => '18',
                'name'      => 'Juranda',
                'ibge_code' => '4112959',
            ],

            90 => [
                'state_id'  => '18',
                'name'      => 'Jussara',
                'ibge_code' => '4113007',
            ],

            91 => [
                'state_id'  => '18',
                'name'      => 'Kaloré',
                'ibge_code' => '4113106',
            ],

            92 => [
                'state_id'  => '18',
                'name'      => 'Lapa',
                'ibge_code' => '4113205',
            ],

            93 => [
                'state_id'  => '18',
                'name'      => 'Laranjal',
                'ibge_code' => '4113254',
            ],

            94 => [
                'state_id'  => '18',
                'name'      => 'Laranjeiras do Sul',
                'ibge_code' => '4113304',
            ],

            95 => [
                'state_id'  => '18',
                'name'      => 'Leópolis',
                'ibge_code' => '4113403',
            ],

            96 => [
                'state_id'  => '18',
                'name'      => 'Lidianópolis',
                'ibge_code' => '4113429',
            ],

            97 => [
                'state_id'  => '18',
                'name'      => 'Lindoeste',
                'ibge_code' => '4113452',
            ],

            98 => [
                'state_id'  => '18',
                'name'      => 'Loanda',
                'ibge_code' => '4113502',
            ],

            99 => [
                'state_id'  => '18',
                'name'      => 'Lobato',
                'ibge_code' => '4113601',
            ],

            100 => [
                'state_id'  => '18',
                'name'      => 'Londrina',
                'ibge_code' => '4113700',
            ],

            101 => [
                'state_id'  => '18',
                'name'      => 'Luiziana',
                'ibge_code' => '4113734',
            ],

            102 => [
                'state_id'  => '18',
                'name'      => 'Lunardelli',
                'ibge_code' => '4113759',
            ],

            103 => [
                'state_id'  => '18',
                'name'      => 'Lupionópolis',
                'ibge_code' => '4113809',
            ],

            104 => [
                'state_id'  => '18',
                'name'      => 'Mallet',
                'ibge_code' => '4113908',
            ],

            105 => [
                'state_id'  => '18',
                'name'      => 'Mamborê',
                'ibge_code' => '4114005',
            ],

            106 => [
                'state_id'  => '18',
                'name'      => 'Mandaguaçu',
                'ibge_code' => '4114104',
            ],

            107 => [
                'state_id'  => '18',
                'name'      => 'Mandaguari',
                'ibge_code' => '4114203',
            ],

            108 => [
                'state_id'  => '18',
                'name'      => 'Mandirituba',
                'ibge_code' => '4114302',
            ],

            109 => [
                'state_id'  => '18',
                'name'      => 'Manfrinópolis',
                'ibge_code' => '4114351',
            ],

            110 => [
                'state_id'  => '18',
                'name'      => 'Mangueirinha',
                'ibge_code' => '4114401',
            ],

            111 => [
                'state_id'  => '18',
                'name'      => 'Manoel Ribas',
                'ibge_code' => '4114500',
            ],

            112 => [
                'state_id'  => '18',
                'name'      => 'Marechal Cândido Rondon',
                'ibge_code' => '4114609',
            ],

            113 => [
                'state_id'  => '18',
                'name'      => 'Maria Helena',
                'ibge_code' => '4114708',
            ],

            114 => [
                'state_id'  => '18',
                'name'      => 'Marialva',
                'ibge_code' => '4114807',
            ],

            115 => [
                'state_id'  => '18',
                'name'      => 'Marilândia do Sul',
                'ibge_code' => '4114906',
            ],

            116 => [
                'state_id'  => '18',
                'name'      => 'Marilena',
                'ibge_code' => '4115002',
            ],

            117 => [
                'state_id'  => '18',
                'name'      => 'Mariluz',
                'ibge_code' => '4115101',
            ],

            118 => [
                'state_id'  => '18',
                'name'      => 'Maringá',
                'ibge_code' => '4115200',
            ],

            119 => [
                'state_id'  => '18',
                'name'      => 'Mariópolis',
                'ibge_code' => '4115309',
            ],

            120 => [
                'state_id'  => '18',
                'name'      => 'Maripá',
                'ibge_code' => '4115358',
            ],

            121 => [
                'state_id'  => '18',
                'name'      => 'Marmeleiro',
                'ibge_code' => '4115408',
            ],

            122 => [
                'state_id'  => '18',
                'name'      => 'Marquinho',
                'ibge_code' => '4115457',
            ],

            123 => [
                'state_id'  => '18',
                'name'      => 'Marumbi',
                'ibge_code' => '4115507',
            ],

            124 => [
                'state_id'  => '18',
                'name'      => 'Matelândia',
                'ibge_code' => '4115606',
            ],

            125 => [
                'state_id'  => '18',
                'name'      => 'Matinhos',
                'ibge_code' => '4115705',
            ],

            126 => [
                'state_id'  => '18',
                'name'      => 'Mato Rico',
                'ibge_code' => '4115739',
            ],

            127 => [
                'state_id'  => '18',
                'name'      => 'Mauá da Serra',
                'ibge_code' => '4115754',
            ],

            128 => [
                'state_id'  => '18',
                'name'      => 'Medianeira',
                'ibge_code' => '4115804',
            ],

            129 => [
                'state_id'  => '18',
                'name'      => 'Mercedes',
                'ibge_code' => '4115853',
            ],

            130 => [
                'state_id'  => '18',
                'name'      => 'Mirador',
                'ibge_code' => '4115903',
            ],

            131 => [
                'state_id'  => '18',
                'name'      => 'Miraselva',
                'ibge_code' => '4116000',
            ],

            132 => [
                'state_id'  => '18',
                'name'      => 'Missal',
                'ibge_code' => '4116059',
            ],

            133 => [
                'state_id'  => '18',
                'name'      => 'Moreira Sales',
                'ibge_code' => '4116109',
            ],

            134 => [
                'state_id'  => '18',
                'name'      => 'Morretes',
                'ibge_code' => '4116208',
            ],

            135 => [
                'state_id'  => '18',
                'name'      => 'Munhoz de Melo',
                'ibge_code' => '4116307',
            ],

            136 => [
                'state_id'  => '18',
                'name'      => 'Nossa Senhora das Graças',
                'ibge_code' => '4116406',
            ],

            137 => [
                'state_id'  => '18',
                'name'      => 'Nova Aliança do Ivaí',
                'ibge_code' => '4116505',
            ],

            138 => [
                'state_id'  => '18',
                'name'      => 'Nova América da Colina',
                'ibge_code' => '4116604',
            ],

            139 => [
                'state_id'  => '18',
                'name'      => 'Nova Aurora',
                'ibge_code' => '4116703',
            ],

            140 => [
                'state_id'  => '18',
                'name'      => 'Nova Cantu',
                'ibge_code' => '4116802',
            ],

            141 => [
                'state_id'  => '18',
                'name'      => 'Nova Esperança',
                'ibge_code' => '4116901',
            ],

            142 => [
                'state_id'  => '18',
                'name'      => 'Nova Esperança do Sudoeste',
                'ibge_code' => '4116950',
            ],

            143 => [
                'state_id'  => '18',
                'name'      => 'Nova Fátima',
                'ibge_code' => '4117008',
            ],

            144 => [
                'state_id'  => '18',
                'name'      => 'Nova Laranjeiras',
                'ibge_code' => '4117057',
            ],

            145 => [
                'state_id'  => '18',
                'name'      => 'Nova Londrina',
                'ibge_code' => '4117107',
            ],

            146 => [
                'state_id'  => '18',
                'name'      => 'Nova Olímpia',
                'ibge_code' => '4117206',
            ],

            147 => [
                'state_id'  => '18',
                'name'      => 'Nova Santa Bárbara',
                'ibge_code' => '4117214',
            ],

            148 => [
                'state_id'  => '18',
                'name'      => 'Nova Santa Rosa',
                'ibge_code' => '4117222',
            ],

            149 => [
                'state_id'  => '18',
                'name'      => 'Nova Prata do Iguaçu',
                'ibge_code' => '4117255',
            ],

            150 => [
                'state_id'  => '18',
                'name'      => 'Nova Tebas',
                'ibge_code' => '4117271',
            ],

            151 => [
                'state_id'  => '18',
                'name'      => 'Novo Itacolomi',
                'ibge_code' => '4117297',
            ],

            152 => [
                'state_id'  => '18',
                'name'      => 'Ortigueira',
                'ibge_code' => '4117305',
            ],

            153 => [
                'state_id'  => '18',
                'name'      => 'Ourizona',
                'ibge_code' => '4117404',
            ],

            154 => [
                'state_id'  => '18',
                'name'      => 'Ouro Verde do Oeste',
                'ibge_code' => '4117453',
            ],

            155 => [
                'state_id'  => '18',
                'name'      => 'Paiçandu',
                'ibge_code' => '4117503',
            ],

            156 => [
                'state_id'  => '18',
                'name'      => 'Palmas',
                'ibge_code' => '4117602',
            ],

            157 => [
                'state_id'  => '18',
                'name'      => 'Palmeira',
                'ibge_code' => '4117701',
            ],

            158 => [
                'state_id'  => '18',
                'name'      => 'Palmital',
                'ibge_code' => '4117800',
            ],

            159 => [
                'state_id'  => '18',
                'name'      => 'Palotina',
                'ibge_code' => '4117909',
            ],

            160 => [
                'state_id'  => '18',
                'name'      => 'Paraíso do Norte',
                'ibge_code' => '4118006',
            ],

            161 => [
                'state_id'  => '18',
                'name'      => 'Paranacity',
                'ibge_code' => '4118105',
            ],

            162 => [
                'state_id'  => '18',
                'name'      => 'Paranaguá',
                'ibge_code' => '4118204',
            ],

            163 => [
                'state_id'  => '18',
                'name'      => 'Paranapoema',
                'ibge_code' => '4118303',
            ],

            164 => [
                'state_id'  => '18',
                'name'      => 'Paranavaí',
                'ibge_code' => '4118402',
            ],

            165 => [
                'state_id'  => '18',
                'name'      => 'Pato Bragado',
                'ibge_code' => '4118451',
            ],

            166 => [
                'state_id'  => '18',
                'name'      => 'Pato Branco',
                'ibge_code' => '4118501',
            ],

            167 => [
                'state_id'  => '18',
                'name'      => 'Paula Freitas',
                'ibge_code' => '4118600',
            ],

            168 => [
                'state_id'  => '18',
                'name'      => 'Paulo Frontin',
                'ibge_code' => '4118709',
            ],

            169 => [
                'state_id'  => '18',
                'name'      => 'Peabiru',
                'ibge_code' => '4118808',
            ],

            170 => [
                'state_id'  => '18',
                'name'      => 'Perobal',
                'ibge_code' => '4118857',
            ],

            171 => [
                'state_id'  => '18',
                'name'      => 'Pérola',
                'ibge_code' => '4118907',
            ],

            172 => [
                'state_id'  => '18',
                'name'      => "Pérola D'oeste",
                'ibge_code' => '4119004',
            ],

            173 => [
                'state_id'  => '18',
                'name'      => 'Piên',
                'ibge_code' => '4119103',
            ],

            174 => [
                'state_id'  => '18',
                'name'      => 'Pinhais',
                'ibge_code' => '4119152',
            ],

            175 => [
                'state_id'  => '18',
                'name'      => 'Pinhalão',
                'ibge_code' => '4119202',
            ],

            176 => [
                'state_id'  => '18',
                'name'      => 'Pinhal de São Bento',
                'ibge_code' => '4119251',
            ],

            177 => [
                'state_id'  => '18',
                'name'      => 'Pinhão',
                'ibge_code' => '4119301',
            ],

            178 => [
                'state_id'  => '18',
                'name'      => 'Piraí do Sul',
                'ibge_code' => '4119400',
            ],

            179 => [
                'state_id'  => '18',
                'name'      => 'Piraquara',
                'ibge_code' => '4119509',
            ],

            180 => [
                'state_id'  => '18',
                'name'      => 'Pitanga',
                'ibge_code' => '4119608',
            ],

            181 => [
                'state_id'  => '18',
                'name'      => 'Pitangueiras',
                'ibge_code' => '4119657',
            ],

            182 => [
                'state_id'  => '18',
                'name'      => 'Planaltina do Paraná',
                'ibge_code' => '4119707',
            ],

            183 => [
                'state_id'  => '18',
                'name'      => 'Planalto',
                'ibge_code' => '4119806',
            ],

            184 => [
                'state_id'  => '18',
                'name'      => 'Ponta Grossa',
                'ibge_code' => '4119905',
            ],

            185 => [
                'state_id'  => '18',
                'name'      => 'Pontal do Paraná',
                'ibge_code' => '4119954',
            ],

            186 => [
                'state_id'  => '18',
                'name'      => 'Porecatu',
                'ibge_code' => '4120002',
            ],

            187 => [
                'state_id'  => '18',
                'name'      => 'Porto Amazonas',
                'ibge_code' => '4120101',
            ],

            188 => [
                'state_id'  => '18',
                'name'      => 'Porto Barreiro',
                'ibge_code' => '4120150',
            ],

            189 => [
                'state_id'  => '18',
                'name'      => 'Porto Rico',
                'ibge_code' => '4120200',
            ],

            190 => [
                'state_id'  => '18',
                'name'      => 'Porto Vitória',
                'ibge_code' => '4120309',
            ],

            191 => [
                'state_id'  => '18',
                'name'      => 'Prado Ferreira',
                'ibge_code' => '4120333',
            ],

            192 => [
                'state_id'  => '18',
                'name'      => 'Pranchita',
                'ibge_code' => '4120358',
            ],

            193 => [
                'state_id'  => '18',
                'name'      => 'Presidente Castelo Branco',
                'ibge_code' => '4120408',
            ],

            194 => [
                'state_id'  => '18',
                'name'      => 'Primeiro de Maio',
                'ibge_code' => '4120507',
            ],

            195 => [
                'state_id'  => '18',
                'name'      => 'Prudentópolis',
                'ibge_code' => '4120606',
            ],

            196 => [
                'state_id'  => '18',
                'name'      => 'Quarto Centenário',
                'ibge_code' => '4120655',
            ],

            197 => [
                'state_id'  => '18',
                'name'      => 'Quatiguá',
                'ibge_code' => '4120705',
            ],

            198 => [
                'state_id'  => '18',
                'name'      => 'Quatro Barras',
                'ibge_code' => '4120804',
            ],

            199 => [
                'state_id'  => '18',
                'name'      => 'Quatro Pontes',
                'ibge_code' => '4120853',
            ],

            200 => [
                'state_id'  => '18',
                'name'      => 'Quedas do Iguaçu',
                'ibge_code' => '4120903',
            ],

            201 => [
                'state_id'  => '18',
                'name'      => 'Querência do Norte',
                'ibge_code' => '4121000',
            ],

            202 => [
                'state_id'  => '18',
                'name'      => 'Quinta do Sol',
                'ibge_code' => '4121109',
            ],

            203 => [
                'state_id'  => '18',
                'name'      => 'Quitandinha',
                'ibge_code' => '4121208',
            ],

            204 => [
                'state_id'  => '18',
                'name'      => 'Ramilândia',
                'ibge_code' => '4121257',
            ],

            205 => [
                'state_id'  => '18',
                'name'      => 'Rancho Alegre',
                'ibge_code' => '4121307',
            ],

            206 => [
                'state_id'  => '18',
                'name'      => "Rancho Alegre D'oeste",
                'ibge_code' => '4121356',
            ],

            207 => [
                'state_id'  => '18',
                'name'      => 'Realeza',
                'ibge_code' => '4121406',
            ],

            208 => [
                'state_id'  => '18',
                'name'      => 'Rebouças',
                'ibge_code' => '4121505',
            ],

            209 => [
                'state_id'  => '18',
                'name'      => 'Renascença',
                'ibge_code' => '4121604',
            ],

            210 => [
                'state_id'  => '18',
                'name'      => 'Reserva',
                'ibge_code' => '4121703',
            ],

            211 => [
                'state_id'  => '18',
                'name'      => 'Reserva do Iguaçu',
                'ibge_code' => '4121752',
            ],

            212 => [
                'state_id'  => '18',
                'name'      => 'Ribeirão Claro',
                'ibge_code' => '4121802',
            ],

            213 => [
                'state_id'  => '18',
                'name'      => 'Ribeirão do Pinhal',
                'ibge_code' => '4121901',
            ],

            214 => [
                'state_id'  => '18',
                'name'      => 'Rio Azul',
                'ibge_code' => '4122008',
            ],

            215 => [
                'state_id'  => '18',
                'name'      => 'Rio Bom',
                'ibge_code' => '4122107',
            ],

            216 => [
                'state_id'  => '18',
                'name'      => 'Rio Bonito do Iguaçu',
                'ibge_code' => '4122156',
            ],

            217 => [
                'state_id'  => '18',
                'name'      => 'Rio Branco do Ivaí',
                'ibge_code' => '4122172',
            ],

            218 => [
                'state_id'  => '18',
                'name'      => 'Rio Branco do Sul',
                'ibge_code' => '4122206',
            ],

            219 => [
                'state_id'  => '18',
                'name'      => 'Rio Negro',
                'ibge_code' => '4122305',
            ],

            220 => [
                'state_id'  => '18',
                'name'      => 'Rolândia',
                'ibge_code' => '4122404',
            ],

            221 => [
                'state_id'  => '18',
                'name'      => 'Roncador',
                'ibge_code' => '4122503',
            ],

            222 => [
                'state_id'  => '18',
                'name'      => 'Rondon',
                'ibge_code' => '4122602',
            ],

            223 => [
                'state_id'  => '18',
                'name'      => 'Rosário do Ivaí',
                'ibge_code' => '4122651',
            ],

            224 => [
                'state_id'  => '18',
                'name'      => 'Sabáudia',
                'ibge_code' => '4122701',
            ],

            225 => [
                'state_id'  => '18',
                'name'      => 'Salgado Filho',
                'ibge_code' => '4122800',
            ],

            226 => [
                'state_id'  => '18',
                'name'      => 'Salto do Itararé',
                'ibge_code' => '4122909',
            ],

            227 => [
                'state_id'  => '18',
                'name'      => 'Salto do Lontra',
                'ibge_code' => '4123006',
            ],

            228 => [
                'state_id'  => '18',
                'name'      => 'Santa Amélia',
                'ibge_code' => '4123105',
            ],

            229 => [
                'state_id'  => '18',
                'name'      => 'Santa Cecília do Pavão',
                'ibge_code' => '4123204',
            ],

            230 => [
                'state_id'  => '18',
                'name'      => 'Santa Cruz de Monte Castelo',
                'ibge_code' => '4123303',
            ],

            231 => [
                'state_id'  => '18',
                'name'      => 'Santa Fé',
                'ibge_code' => '4123402',
            ],

            232 => [
                'state_id'  => '18',
                'name'      => 'Santa Helena',
                'ibge_code' => '4123501',
            ],

            233 => [
                'state_id'  => '18',
                'name'      => 'Santa Inês',
                'ibge_code' => '4123600',
            ],

            234 => [
                'state_id'  => '18',
                'name'      => 'Santa Isabel do Ivaí',
                'ibge_code' => '4123709',
            ],

            235 => [
                'state_id'  => '18',
                'name'      => 'Santa Izabel do Oeste',
                'ibge_code' => '4123808',
            ],

            236 => [
                'state_id'  => '18',
                'name'      => 'Santa Lúcia',
                'ibge_code' => '4123824',
            ],

            237 => [
                'state_id'  => '18',
                'name'      => 'Santa Maria do Oeste',
                'ibge_code' => '4123857',
            ],

            238 => [
                'state_id'  => '18',
                'name'      => 'Santa Mariana',
                'ibge_code' => '4123907',
            ],

            239 => [
                'state_id'  => '18',
                'name'      => 'Santa Mônica',
                'ibge_code' => '4123956',
            ],

            240 => [
                'state_id'  => '18',
                'name'      => 'Santana do Itararé',
                'ibge_code' => '4124004',
            ],

            241 => [
                'state_id'  => '18',
                'name'      => 'Santa Tereza do Oeste',
                'ibge_code' => '4124020',
            ],

            242 => [
                'state_id'  => '18',
                'name'      => 'Santa Terezinha de Itaipu',
                'ibge_code' => '4124053',
            ],

            243 => [
                'state_id'  => '18',
                'name'      => 'Santo Antônio da Platina',
                'ibge_code' => '4124103',
            ],

            244 => [
                'state_id'  => '18',
                'name'      => 'Santo Antônio do Caiuá',
                'ibge_code' => '4124202',
            ],

            245 => [
                'state_id'  => '18',
                'name'      => 'Santo Antônio do Paraíso',
                'ibge_code' => '4124301',
            ],

            246 => [
                'state_id'  => '18',
                'name'      => 'Santo Antônio do Sudoeste',
                'ibge_code' => '4124400',
            ],

            247 => [
                'state_id'  => '18',
                'name'      => 'Santo Inácio',
                'ibge_code' => '4124509',
            ],

            248 => [
                'state_id'  => '18',
                'name'      => 'São Carlos do Ivaí',
                'ibge_code' => '4124608',
            ],

            249 => [
                'state_id'  => '18',
                'name'      => 'São Jerônimo da Serra',
                'ibge_code' => '4124707',
            ],

            250 => [
                'state_id'  => '18',
                'name'      => 'São João',
                'ibge_code' => '4124806',
            ],

            251 => [
                'state_id'  => '18',
                'name'      => 'São João do Caiuá',
                'ibge_code' => '4124905',
            ],

            252 => [
                'state_id'  => '18',
                'name'      => 'São João do Ivaí',
                'ibge_code' => '4125001',
            ],

            253 => [
                'state_id'  => '18',
                'name'      => 'São João do Triunfo',
                'ibge_code' => '4125100',
            ],

            254 => [
                'state_id'  => '18',
                'name'      => "São Jorge D'oeste",
                'ibge_code' => '4125209',
            ],

            255 => [
                'state_id'  => '18',
                'name'      => 'São Jorge do Ivaí',
                'ibge_code' => '4125308',
            ],

            256 => [
                'state_id'  => '18',
                'name'      => 'São Jorge do Patrocínio',
                'ibge_code' => '4125357',
            ],

            257 => [
                'state_id'  => '18',
                'name'      => 'São José da Boa Vista',
                'ibge_code' => '4125407',
            ],

            258 => [
                'state_id'  => '18',
                'name'      => 'São José das Palmeiras',
                'ibge_code' => '4125456',
            ],

            259 => [
                'state_id'  => '18',
                'name'      => 'São José dos Pinhais',
                'ibge_code' => '4125506',
            ],

            260 => [
                'state_id'  => '18',
                'name'      => 'São Manoel do Paraná',
                'ibge_code' => '4125555',
            ],

            261 => [
                'state_id'  => '18',
                'name'      => 'São Mateus do Sul',
                'ibge_code' => '4125605',
            ],

            262 => [
                'state_id'  => '18',
                'name'      => 'São Miguel do Iguaçu',
                'ibge_code' => '4125704',
            ],

            263 => [
                'state_id'  => '18',
                'name'      => 'São Pedro do Iguaçu',
                'ibge_code' => '4125753',
            ],

            264 => [
                'state_id'  => '18',
                'name'      => 'São Pedro do Ivaí',
                'ibge_code' => '4125803',
            ],

            265 => [
                'state_id'  => '18',
                'name'      => 'São Pedro do Paraná',
                'ibge_code' => '4125902',
            ],

            266 => [
                'state_id'  => '18',
                'name'      => 'São Sebastião da Amoreira',
                'ibge_code' => '4126009',
            ],

            267 => [
                'state_id'  => '18',
                'name'      => 'São Tomé',
                'ibge_code' => '4126108',
            ],

            268 => [
                'state_id'  => '18',
                'name'      => 'Sapopema',
                'ibge_code' => '4126207',
            ],

            269 => [
                'state_id'  => '18',
                'name'      => 'Sarandi',
                'ibge_code' => '4126256',
            ],

            270 => [
                'state_id'  => '18',
                'name'      => 'Saudade do Iguaçu',
                'ibge_code' => '4126272',
            ],

            271 => [
                'state_id'  => '18',
                'name'      => 'Sengés',
                'ibge_code' => '4126306',
            ],

            272 => [
                'state_id'  => '18',
                'name'      => 'Serranópolis do Iguaçu',
                'ibge_code' => '4126355',
            ],

            273 => [
                'state_id'  => '18',
                'name'      => 'Sertaneja',
                'ibge_code' => '4126405',
            ],

            274 => [
                'state_id'  => '18',
                'name'      => 'Sertanópolis',
                'ibge_code' => '4126504',
            ],

            275 => [
                'state_id'  => '18',
                'name'      => 'Siqueira Campos',
                'ibge_code' => '4126603',
            ],

            276 => [
                'state_id'  => '18',
                'name'      => 'Sulina',
                'ibge_code' => '4126652',
            ],

            277 => [
                'state_id'  => '18',
                'name'      => 'Tamarana',
                'ibge_code' => '4126678',
            ],

            278 => [
                'state_id'  => '18',
                'name'      => 'Tamboara',
                'ibge_code' => '4126702',
            ],

            279 => [
                'state_id'  => '18',
                'name'      => 'Tapejara',
                'ibge_code' => '4126801',
            ],

            280 => [
                'state_id'  => '18',
                'name'      => 'Tapira',
                'ibge_code' => '4126900',
            ],

            281 => [
                'state_id'  => '18',
                'name'      => 'Teixeira Soares',
                'ibge_code' => '4127007',
            ],

            282 => [
                'state_id'  => '18',
                'name'      => 'Telêmaco Borba',
                'ibge_code' => '4127106',
            ],

            283 => [
                'state_id'  => '18',
                'name'      => 'Terra Boa',
                'ibge_code' => '4127205',
            ],

            284 => [
                'state_id'  => '18',
                'name'      => 'Terra Rica',
                'ibge_code' => '4127304',
            ],

            285 => [
                'state_id'  => '18',
                'name'      => 'Terra Roxa',
                'ibge_code' => '4127403',
            ],

            286 => [
                'state_id'  => '18',
                'name'      => 'Tibagi',
                'ibge_code' => '4127502',
            ],

            287 => [
                'state_id'  => '18',
                'name'      => 'Tijucas do Sul',
                'ibge_code' => '4127601',
            ],

            288 => [
                'state_id'  => '18',
                'name'      => 'Toledo',
                'ibge_code' => '4127700',
            ],

            289 => [
                'state_id'  => '18',
                'name'      => 'Tomazina',
                'ibge_code' => '4127809',
            ],

            290 => [
                'state_id'  => '18',
                'name'      => 'Três Barras do Paraná',
                'ibge_code' => '4127858',
            ],

            291 => [
                'state_id'  => '18',
                'name'      => 'Tunas do Paraná',
                'ibge_code' => '4127882',
            ],

            292 => [
                'state_id'  => '18',
                'name'      => 'Tuneiras do Oeste',
                'ibge_code' => '4127908',
            ],

            293 => [
                'state_id'  => '18',
                'name'      => 'Tupãssi',
                'ibge_code' => '4127957',
            ],

            294 => [
                'state_id'  => '18',
                'name'      => 'Turvo',
                'ibge_code' => '4127965',
            ],

            295 => [
                'state_id'  => '18',
                'name'      => 'Ubiratã',
                'ibge_code' => '4128005',
            ],

            296 => [
                'state_id'  => '18',
                'name'      => 'Umuarama',
                'ibge_code' => '4128104',
            ],

            297 => [
                'state_id'  => '18',
                'name'      => 'União da Vitória',
                'ibge_code' => '4128203',
            ],

            298 => [
                'state_id'  => '18',
                'name'      => 'Uniflor',
                'ibge_code' => '4128302',
            ],

            299 => [
                'state_id'  => '18',
                'name'      => 'Uraí',
                'ibge_code' => '4128401',
            ],

            300 => [
                'state_id'  => '18',
                'name'      => 'Wenceslau Braz',
                'ibge_code' => '4128500',
            ],

            301 => [
                'state_id'  => '18',
                'name'      => 'Ventania',
                'ibge_code' => '4128534',
            ],

            302 => [
                'state_id'  => '18',
                'name'      => 'Vera Cruz do Oeste',
                'ibge_code' => '4128559',
            ],

            303 => [
                'state_id'  => '18',
                'name'      => 'Verê',
                'ibge_code' => '4128609',
            ],

            304 => [
                'state_id'  => '18',
                'name'      => 'Alto Paraíso',
                'ibge_code' => '4128625',
            ],

            305 => [
                'state_id'  => '18',
                'name'      => 'Doutor Ulysses',
                'ibge_code' => '4128633',
            ],

            306 => [
                'state_id'  => '18',
                'name'      => 'Virmond',
                'ibge_code' => '4128658',
            ],

            307 => [
                'state_id'  => '18',
                'name'      => 'Vitorino',
                'ibge_code' => '4128708',
            ],

            308 => [
                'state_id'  => '18',
                'name'      => 'Xambrê',
                'ibge_code' => '4128807',
            ],

            309 => [
                'state_id'  => '24',
                'name'      => 'Abdon Batista',
                'ibge_code' => '4200051',
            ],

            310 => [
                'state_id'  => '24',
                'name'      => 'Abelardo Luz',
                'ibge_code' => '4200101',
            ],

            311 => [
                'state_id'  => '24',
                'name'      => 'Agrolândia',
                'ibge_code' => '4200200',
            ],

            312 => [
                'state_id'  => '24',
                'name'      => 'Agronômica',
                'ibge_code' => '4200309',
            ],

            313 => [
                'state_id'  => '24',
                'name'      => 'Água Doce',
                'ibge_code' => '4200408',
            ],

            314 => [
                'state_id'  => '24',
                'name'      => 'Águas de Chapecó',
                'ibge_code' => '4200507',
            ],

            315 => [
                'state_id'  => '24',
                'name'      => 'Águas Frias',
                'ibge_code' => '4200556',
            ],

            316 => [
                'state_id'  => '24',
                'name'      => 'Águas Mornas',
                'ibge_code' => '4200606',
            ],

            317 => [
                'state_id'  => '24',
                'name'      => 'Alfredo Wagner',
                'ibge_code' => '4200705',
            ],

            318 => [
                'state_id'  => '24',
                'name'      => 'Alto Bela Vista',
                'ibge_code' => '4200754',
            ],

            319 => [
                'state_id'  => '24',
                'name'      => 'Anchieta',
                'ibge_code' => '4200804',
            ],

            320 => [
                'state_id'  => '24',
                'name'      => 'Angelina',
                'ibge_code' => '4200903',
            ],

            321 => [
                'state_id'  => '24',
                'name'      => 'Anita Garibaldi',
                'ibge_code' => '4201000',
            ],

            322 => [
                'state_id'  => '24',
                'name'      => 'Anitápolis',
                'ibge_code' => '4201109',
            ],

            323 => [
                'state_id'  => '24',
                'name'      => 'Antônio Carlos',
                'ibge_code' => '4201208',
            ],

            324 => [
                'state_id'  => '24',
                'name'      => 'Apiúna',
                'ibge_code' => '4201257',
            ],

            325 => [
                'state_id'  => '24',
                'name'      => 'Arabutã',
                'ibge_code' => '4201273',
            ],

            326 => [
                'state_id'  => '24',
                'name'      => 'Araquari',
                'ibge_code' => '4201307',
            ],

            327 => [
                'state_id'  => '24',
                'name'      => 'Araranguá',
                'ibge_code' => '4201406',
            ],

            328 => [
                'state_id'  => '24',
                'name'      => 'Armazém',
                'ibge_code' => '4201505',
            ],

            329 => [
                'state_id'  => '24',
                'name'      => 'Arroio Trinta',
                'ibge_code' => '4201604',
            ],

            330 => [
                'state_id'  => '24',
                'name'      => 'Arvoredo',
                'ibge_code' => '4201653',
            ],

            331 => [
                'state_id'  => '24',
                'name'      => 'Ascurra',
                'ibge_code' => '4201703',
            ],

            332 => [
                'state_id'  => '24',
                'name'      => 'Atalanta',
                'ibge_code' => '4201802',
            ],

            333 => [
                'state_id'  => '24',
                'name'      => 'Aurora',
                'ibge_code' => '4201901',
            ],

            334 => [
                'state_id'  => '24',
                'name'      => 'Balneário Arroio do Silva',
                'ibge_code' => '4201950',
            ],

            335 => [
                'state_id'  => '24',
                'name'      => 'Balneário Camboriú',
                'ibge_code' => '4202008',
            ],

            336 => [
                'state_id'  => '24',
                'name'      => 'Balneário Barra do Sul',
                'ibge_code' => '4202057',
            ],

            337 => [
                'state_id'  => '24',
                'name'      => 'Balneário Gaivota',
                'ibge_code' => '4202073',
            ],

            338 => [
                'state_id'  => '24',
                'name'      => 'Bandeirante',
                'ibge_code' => '4202081',
            ],

            339 => [
                'state_id'  => '24',
                'name'      => 'Barra Bonita',
                'ibge_code' => '4202099',
            ],

            340 => [
                'state_id'  => '24',
                'name'      => 'Barra Velha',
                'ibge_code' => '4202107',
            ],

            341 => [
                'state_id'  => '24',
                'name'      => 'Bela Vista do Toldo',
                'ibge_code' => '4202131',
            ],

            342 => [
                'state_id'  => '24',
                'name'      => 'Belmonte',
                'ibge_code' => '4202156',
            ],

            343 => [
                'state_id'  => '24',
                'name'      => 'Benedito Novo',
                'ibge_code' => '4202206',
            ],

            344 => [
                'state_id'  => '24',
                'name'      => 'Biguaçu',
                'ibge_code' => '4202305',
            ],

            345 => [
                'state_id'  => '24',
                'name'      => 'Blumenau',
                'ibge_code' => '4202404',
            ],

            346 => [
                'state_id'  => '24',
                'name'      => 'Bocaina do Sul',
                'ibge_code' => '4202438',
            ],

            347 => [
                'state_id'  => '24',
                'name'      => 'Bombinhas',
                'ibge_code' => '4202453',
            ],

            348 => [
                'state_id'  => '24',
                'name'      => 'Bom Jardim da Serra',
                'ibge_code' => '4202503',
            ],

            349 => [
                'state_id'  => '24',
                'name'      => 'Bom Jesus',
                'ibge_code' => '4202537',
            ],

            350 => [
                'state_id'  => '24',
                'name'      => 'Bom Jesus do Oeste',
                'ibge_code' => '4202578',
            ],

            351 => [
                'state_id'  => '24',
                'name'      => 'Bom Retiro',
                'ibge_code' => '4202602',
            ],

            352 => [
                'state_id'  => '24',
                'name'      => 'Botuverá',
                'ibge_code' => '4202701',
            ],

            353 => [
                'state_id'  => '24',
                'name'      => 'Braço do Norte',
                'ibge_code' => '4202800',
            ],

            354 => [
                'state_id'  => '24',
                'name'      => 'Braço do Trombudo',
                'ibge_code' => '4202859',
            ],

            355 => [
                'state_id'  => '24',
                'name'      => 'Brunópolis',
                'ibge_code' => '4202875',
            ],

            356 => [
                'state_id'  => '24',
                'name'      => 'Brusque',
                'ibge_code' => '4202909',
            ],

            357 => [
                'state_id'  => '24',
                'name'      => 'Caçador',
                'ibge_code' => '4203006',
            ],

            358 => [
                'state_id'  => '24',
                'name'      => 'Caibi',
                'ibge_code' => '4203105',
            ],

            359 => [
                'state_id'  => '24',
                'name'      => 'Calmon',
                'ibge_code' => '4203154',
            ],

            360 => [
                'state_id'  => '24',
                'name'      => 'Camboriú',
                'ibge_code' => '4203204',
            ],

            361 => [
                'state_id'  => '24',
                'name'      => 'Capão Alto',
                'ibge_code' => '4203253',
            ],

            362 => [
                'state_id'  => '24',
                'name'      => 'Campo Alegre',
                'ibge_code' => '4203303',
            ],

            363 => [
                'state_id'  => '24',
                'name'      => 'Campo Belo do Sul',
                'ibge_code' => '4203402',
            ],

            364 => [
                'state_id'  => '24',
                'name'      => 'Campo Erê',
                'ibge_code' => '4203501',
            ],

            365 => [
                'state_id'  => '24',
                'name'      => 'Campos Novos',
                'ibge_code' => '4203600',
            ],

            366 => [
                'state_id'  => '24',
                'name'      => 'Canelinha',
                'ibge_code' => '4203709',
            ],

            367 => [
                'state_id'  => '24',
                'name'      => 'Canoinhas',
                'ibge_code' => '4203808',
            ],

            368 => [
                'state_id'  => '24',
                'name'      => 'Capinzal',
                'ibge_code' => '4203907',
            ],

            369 => [
                'state_id'  => '24',
                'name'      => 'Capivari de Baixo',
                'ibge_code' => '4203956',
            ],

            370 => [
                'state_id'  => '24',
                'name'      => 'Catanduvas',
                'ibge_code' => '4204004',
            ],

            371 => [
                'state_id'  => '24',
                'name'      => 'Caxambu do Sul',
                'ibge_code' => '4204103',
            ],

            372 => [
                'state_id'  => '24',
                'name'      => 'Celso Ramos',
                'ibge_code' => '4204152',
            ],

            373 => [
                'state_id'  => '24',
                'name'      => 'Cerro Negro',
                'ibge_code' => '4204178',
            ],

            374 => [
                'state_id'  => '24',
                'name'      => 'Chapadão do Lageado',
                'ibge_code' => '4204194',
            ],

            375 => [
                'state_id'  => '24',
                'name'      => 'Chapecó',
                'ibge_code' => '4204202',
            ],

            376 => [
                'state_id'  => '24',
                'name'      => 'Cocal do Sul',
                'ibge_code' => '4204251',
            ],

            377 => [
                'state_id'  => '24',
                'name'      => 'Concórdia',
                'ibge_code' => '4204301',
            ],

            378 => [
                'state_id'  => '24',
                'name'      => 'Cordilheira Alta',
                'ibge_code' => '4204350',
            ],

            379 => [
                'state_id'  => '24',
                'name'      => 'Coronel Freitas',
                'ibge_code' => '4204400',
            ],

            380 => [
                'state_id'  => '24',
                'name'      => 'Coronel Martins',
                'ibge_code' => '4204459',
            ],

            381 => [
                'state_id'  => '24',
                'name'      => 'Corupá',
                'ibge_code' => '4204509',
            ],

            382 => [
                'state_id'  => '24',
                'name'      => 'Correia Pinto',
                'ibge_code' => '4204558',
            ],

            383 => [
                'state_id'  => '24',
                'name'      => 'Criciúma',
                'ibge_code' => '4204608',
            ],

            384 => [
                'state_id'  => '24',
                'name'      => 'Cunha Porã',
                'ibge_code' => '4204707',
            ],

            385 => [
                'state_id'  => '24',
                'name'      => 'Cunhataí',
                'ibge_code' => '4204756',
            ],

            386 => [
                'state_id'  => '24',
                'name'      => 'Curitibanos',
                'ibge_code' => '4204806',
            ],

            387 => [
                'state_id'  => '24',
                'name'      => 'Descanso',
                'ibge_code' => '4204905',
            ],

            388 => [
                'state_id'  => '24',
                'name'      => 'Dionísio Cerqueira',
                'ibge_code' => '4205001',
            ],

            389 => [
                'state_id'  => '24',
                'name'      => 'Dona Emma',
                'ibge_code' => '4205100',
            ],

            390 => [
                'state_id'  => '24',
                'name'      => 'Doutor Pedrinho',
                'ibge_code' => '4205159',
            ],

            391 => [
                'state_id'  => '24',
                'name'      => 'Entre Rios',
                'ibge_code' => '4205175',
            ],

            392 => [
                'state_id'  => '24',
                'name'      => 'Ermo',
                'ibge_code' => '4205191',
            ],

            393 => [
                'state_id'  => '24',
                'name'      => 'Erval Velho',
                'ibge_code' => '4205209',
            ],

            394 => [
                'state_id'  => '24',
                'name'      => 'Faxinal dos Guedes',
                'ibge_code' => '4205308',
            ],

            395 => [
                'state_id'  => '24',
                'name'      => 'Flor do Sertão',
                'ibge_code' => '4205357',
            ],

            396 => [
                'state_id'  => '24',
                'name'      => 'Florianópolis',
                'ibge_code' => '4205407',
            ],

            397 => [
                'state_id'  => '24',
                'name'      => 'Formosa do Sul',
                'ibge_code' => '4205431',
            ],

            398 => [
                'state_id'  => '24',
                'name'      => 'Forquilhinha',
                'ibge_code' => '4205456',
            ],

            399 => [
                'state_id'  => '24',
                'name'      => 'Fraiburgo',
                'ibge_code' => '4205506',
            ],

            400 => [
                'state_id'  => '24',
                'name'      => 'Frei Rogério',
                'ibge_code' => '4205555',
            ],

            401 => [
                'state_id'  => '24',
                'name'      => 'Galvão',
                'ibge_code' => '4205605',
            ],

            402 => [
                'state_id'  => '24',
                'name'      => 'Garopaba',
                'ibge_code' => '4205704',
            ],

            403 => [
                'state_id'  => '24',
                'name'      => 'Garuva',
                'ibge_code' => '4205803',
            ],

            404 => [
                'state_id'  => '24',
                'name'      => 'Gaspar',
                'ibge_code' => '4205902',
            ],

            405 => [
                'state_id'  => '24',
                'name'      => 'Governador Celso Ramos',
                'ibge_code' => '4206009',
            ],

            406 => [
                'state_id'  => '24',
                'name'      => 'Grão Pará',
                'ibge_code' => '4206108',
            ],

            407 => [
                'state_id'  => '24',
                'name'      => 'Gravatal',
                'ibge_code' => '4206207',
            ],

            408 => [
                'state_id'  => '24',
                'name'      => 'Guabiruba',
                'ibge_code' => '4206306',
            ],

            409 => [
                'state_id'  => '24',
                'name'      => 'Guaraciaba',
                'ibge_code' => '4206405',
            ],

            410 => [
                'state_id'  => '24',
                'name'      => 'Guaramirim',
                'ibge_code' => '4206504',
            ],

            411 => [
                'state_id'  => '24',
                'name'      => 'Guarujá do Sul',
                'ibge_code' => '4206603',
            ],

            412 => [
                'state_id'  => '24',
                'name'      => 'Guatambú',
                'ibge_code' => '4206652',
            ],

            413 => [
                'state_id'  => '24',
                'name'      => "Herval D'oeste",
                'ibge_code' => '4206702',
            ],

            414 => [
                'state_id'  => '24',
                'name'      => 'Ibiam',
                'ibge_code' => '4206751',
            ],

            415 => [
                'state_id'  => '24',
                'name'      => 'Ibicaré',
                'ibge_code' => '4206801',
            ],

            416 => [
                'state_id'  => '24',
                'name'      => 'Ibirama',
                'ibge_code' => '4206900',
            ],

            417 => [
                'state_id'  => '24',
                'name'      => 'Içara',
                'ibge_code' => '4207007',
            ],

            418 => [
                'state_id'  => '24',
                'name'      => 'Ilhota',
                'ibge_code' => '4207106',
            ],

            419 => [
                'state_id'  => '24',
                'name'      => 'Imaruí',
                'ibge_code' => '4207205',
            ],

            420 => [
                'state_id'  => '24',
                'name'      => 'Imbituba',
                'ibge_code' => '4207304',
            ],

            421 => [
                'state_id'  => '24',
                'name'      => 'Imbuia',
                'ibge_code' => '4207403',
            ],

            422 => [
                'state_id'  => '24',
                'name'      => 'Indaial',
                'ibge_code' => '4207502',
            ],

            423 => [
                'state_id'  => '24',
                'name'      => 'Iomerê',
                'ibge_code' => '4207577',
            ],

            424 => [
                'state_id'  => '24',
                'name'      => 'Ipira',
                'ibge_code' => '4207601',
            ],

            425 => [
                'state_id'  => '24',
                'name'      => 'Iporã do Oeste',
                'ibge_code' => '4207650',
            ],

            426 => [
                'state_id'  => '24',
                'name'      => 'Ipuaçu',
                'ibge_code' => '4207684',
            ],

            427 => [
                'state_id'  => '24',
                'name'      => 'Ipumirim',
                'ibge_code' => '4207700',
            ],

            428 => [
                'state_id'  => '24',
                'name'      => 'Iraceminha',
                'ibge_code' => '4207759',
            ],

            429 => [
                'state_id'  => '24',
                'name'      => 'Irani',
                'ibge_code' => '4207809',
            ],

            430 => [
                'state_id'  => '24',
                'name'      => 'Irati',
                'ibge_code' => '4207858',
            ],

            431 => [
                'state_id'  => '24',
                'name'      => 'Irineópolis',
                'ibge_code' => '4207908',
            ],

            432 => [
                'state_id'  => '24',
                'name'      => 'Itá',
                'ibge_code' => '4208005',
            ],

            433 => [
                'state_id'  => '24',
                'name'      => 'Itaiópolis',
                'ibge_code' => '4208104',
            ],

            434 => [
                'state_id'  => '24',
                'name'      => 'Itajaí',
                'ibge_code' => '4208203',
            ],

            435 => [
                'state_id'  => '24',
                'name'      => 'Itapema',
                'ibge_code' => '4208302',
            ],

            436 => [
                'state_id'  => '24',
                'name'      => 'Itapiranga',
                'ibge_code' => '4208401',
            ],

            437 => [
                'state_id'  => '24',
                'name'      => 'Itapoá',
                'ibge_code' => '4208450',
            ],

            438 => [
                'state_id'  => '24',
                'name'      => 'Ituporanga',
                'ibge_code' => '4208500',
            ],

            439 => [
                'state_id'  => '24',
                'name'      => 'Jaborá',
                'ibge_code' => '4208609',
            ],

            440 => [
                'state_id'  => '24',
                'name'      => 'Jacinto Machado',
                'ibge_code' => '4208708',
            ],

            441 => [
                'state_id'  => '24',
                'name'      => 'Jaguaruna',
                'ibge_code' => '4208807',
            ],

            442 => [
                'state_id'  => '24',
                'name'      => 'Jaraguá do Sul',
                'ibge_code' => '4208906',
            ],

            443 => [
                'state_id'  => '24',
                'name'      => 'Jardinópolis',
                'ibge_code' => '4208955',
            ],

            444 => [
                'state_id'  => '24',
                'name'      => 'Joaçaba',
                'ibge_code' => '4209003',
            ],

            445 => [
                'state_id'  => '24',
                'name'      => 'Joinville',
                'ibge_code' => '4209102',
            ],

            446 => [
                'state_id'  => '24',
                'name'      => 'José Boiteux',
                'ibge_code' => '4209151',
            ],

            447 => [
                'state_id'  => '24',
                'name'      => 'Jupiá',
                'ibge_code' => '4209177',
            ],

            448 => [
                'state_id'  => '24',
                'name'      => 'Lacerdópolis',
                'ibge_code' => '4209201',
            ],

            449 => [
                'state_id'  => '24',
                'name'      => 'Lages',
                'ibge_code' => '4209300',
            ],

            450 => [
                'state_id'  => '24',
                'name'      => 'Laguna',
                'ibge_code' => '4209409',
            ],

            451 => [
                'state_id'  => '24',
                'name'      => 'Lajeado Grande',
                'ibge_code' => '4209458',
            ],

            452 => [
                'state_id'  => '24',
                'name'      => 'Laurentino',
                'ibge_code' => '4209508',
            ],

            453 => [
                'state_id'  => '24',
                'name'      => 'Lauro Muller',
                'ibge_code' => '4209607',
            ],

            454 => [
                'state_id'  => '24',
                'name'      => 'Lebon Régis',
                'ibge_code' => '4209706',
            ],

            455 => [
                'state_id'  => '24',
                'name'      => 'Leoberto Leal',
                'ibge_code' => '4209805',
            ],

            456 => [
                'state_id'  => '24',
                'name'      => 'Lindóia do Sul',
                'ibge_code' => '4209854',
            ],

            457 => [
                'state_id'  => '24',
                'name'      => 'Lontras',
                'ibge_code' => '4209904',
            ],

            458 => [
                'state_id'  => '24',
                'name'      => 'Luiz Alves',
                'ibge_code' => '4210001',
            ],

            459 => [
                'state_id'  => '24',
                'name'      => 'Luzerna',
                'ibge_code' => '4210035',
            ],

            460 => [
                'state_id'  => '24',
                'name'      => 'Macieira',
                'ibge_code' => '4210050',
            ],

            461 => [
                'state_id'  => '24',
                'name'      => 'Mafra',
                'ibge_code' => '4210100',
            ],

            462 => [
                'state_id'  => '24',
                'name'      => 'Major Gercino',
                'ibge_code' => '4210209',
            ],

            463 => [
                'state_id'  => '24',
                'name'      => 'Major Vieira',
                'ibge_code' => '4210308',
            ],

            464 => [
                'state_id'  => '24',
                'name'      => 'Maracajá',
                'ibge_code' => '4210407',
            ],

            465 => [
                'state_id'  => '24',
                'name'      => 'Maravilha',
                'ibge_code' => '4210506',
            ],

            466 => [
                'state_id'  => '24',
                'name'      => 'Marema',
                'ibge_code' => '4210555',
            ],

            467 => [
                'state_id'  => '24',
                'name'      => 'Massaranduba',
                'ibge_code' => '4210605',
            ],

            468 => [
                'state_id'  => '24',
                'name'      => 'Matos Costa',
                'ibge_code' => '4210704',
            ],

            469 => [
                'state_id'  => '24',
                'name'      => 'Meleiro',
                'ibge_code' => '4210803',
            ],

            470 => [
                'state_id'  => '24',
                'name'      => 'Mirim Doce',
                'ibge_code' => '4210852',
            ],

            471 => [
                'state_id'  => '24',
                'name'      => 'Modelo',
                'ibge_code' => '4210902',
            ],

            472 => [
                'state_id'  => '24',
                'name'      => 'Mondaí',
                'ibge_code' => '4211009',
            ],

            473 => [
                'state_id'  => '24',
                'name'      => 'Monte Carlo',
                'ibge_code' => '4211058',
            ],

            474 => [
                'state_id'  => '24',
                'name'      => 'Monte Castelo',
                'ibge_code' => '4211108',
            ],

            475 => [
                'state_id'  => '24',
                'name'      => 'Morro da Fumaça',
                'ibge_code' => '4211207',
            ],

            476 => [
                'state_id'  => '24',
                'name'      => 'Morro Grande',
                'ibge_code' => '4211256',
            ],

            477 => [
                'state_id'  => '24',
                'name'      => 'Navegantes',
                'ibge_code' => '4211306',
            ],

            478 => [
                'state_id'  => '24',
                'name'      => 'Nova Erechim',
                'ibge_code' => '4211405',
            ],

            479 => [
                'state_id'  => '24',
                'name'      => 'Nova Itaberaba',
                'ibge_code' => '4211454',
            ],

            480 => [
                'state_id'  => '24',
                'name'      => 'Nova Trento',
                'ibge_code' => '4211504',
            ],

            481 => [
                'state_id'  => '24',
                'name'      => 'Nova Veneza',
                'ibge_code' => '4211603',
            ],

            482 => [
                'state_id'  => '24',
                'name'      => 'Novo Horizonte',
                'ibge_code' => '4211652',
            ],

            483 => [
                'state_id'  => '24',
                'name'      => 'Orleans',
                'ibge_code' => '4211702',
            ],

            484 => [
                'state_id'  => '24',
                'name'      => 'Otacílio Costa',
                'ibge_code' => '4211751',
            ],

            485 => [
                'state_id'  => '24',
                'name'      => 'Ouro',
                'ibge_code' => '4211801',
            ],

            486 => [
                'state_id'  => '24',
                'name'      => 'Ouro Verde',
                'ibge_code' => '4211850',
            ],

            487 => [
                'state_id'  => '24',
                'name'      => 'Paial',
                'ibge_code' => '4211876',
            ],

            488 => [
                'state_id'  => '24',
                'name'      => 'Painel',
                'ibge_code' => '4211892',
            ],

            489 => [
                'state_id'  => '24',
                'name'      => 'Palhoça',
                'ibge_code' => '4211900',
            ],

            490 => [
                'state_id'  => '24',
                'name'      => 'Palma Sola',
                'ibge_code' => '4212007',
            ],

            491 => [
                'state_id'  => '24',
                'name'      => 'Palmeira',
                'ibge_code' => '4212056',
            ],

            492 => [
                'state_id'  => '24',
                'name'      => 'Palmitos',
                'ibge_code' => '4212106',
            ],

            493 => [
                'state_id'  => '24',
                'name'      => 'Papanduva',
                'ibge_code' => '4212205',
            ],

            494 => [
                'state_id'  => '24',
                'name'      => 'Paraíso',
                'ibge_code' => '4212239',
            ],

            495 => [
                'state_id'  => '24',
                'name'      => 'Passo de Torres',
                'ibge_code' => '4212254',
            ],

            496 => [
                'state_id'  => '24',
                'name'      => 'Passos Maia',
                'ibge_code' => '4212270',
            ],

            497 => [
                'state_id'  => '24',
                'name'      => 'Paulo Lopes',
                'ibge_code' => '4212304',
            ],

            498 => [
                'state_id'  => '24',
                'name'      => 'Pedras Grandes',
                'ibge_code' => '4212403',
            ],

            499 => [
                'state_id'  => '24',
                'name'      => 'Penha',
                'ibge_code' => '4212502',
            ],

        ]);
        DB::table('cities')->insert([
            0 => [
                'state_id'  => '24',
                'name'      => 'Peritiba',
                'ibge_code' => '4212601',
            ],

            1 => [
                'state_id'  => '24',
                'name'      => 'Petrolândia',
                'ibge_code' => '4212700',
            ],

            2 => [
                'state_id'  => '24',
                'name'      => 'Balneário Piçarras',
                'ibge_code' => '4212809',
            ],

            3 => [
                'state_id'  => '24',
                'name'      => 'Pinhalzinho',
                'ibge_code' => '4212908',
            ],

            4 => [
                'state_id'  => '24',
                'name'      => 'Pinheiro Preto',
                'ibge_code' => '4213005',
            ],

            5 => [
                'state_id'  => '24',
                'name'      => 'Piratuba',
                'ibge_code' => '4213104',
            ],

            6 => [
                'state_id'  => '24',
                'name'      => 'Planalto Alegre',
                'ibge_code' => '4213153',
            ],

            7 => [
                'state_id'  => '24',
                'name'      => 'Pomerode',
                'ibge_code' => '4213203',
            ],

            8 => [
                'state_id'  => '24',
                'name'      => 'Ponte Alta',
                'ibge_code' => '4213302',
            ],

            9 => [
                'state_id'  => '24',
                'name'      => 'Ponte Alta do Norte',
                'ibge_code' => '4213351',
            ],

            10 => [
                'state_id'  => '24',
                'name'      => 'Ponte Serrada',
                'ibge_code' => '4213401',
            ],

            11 => [
                'state_id'  => '24',
                'name'      => 'Porto Belo',
                'ibge_code' => '4213500',
            ],

            12 => [
                'state_id'  => '24',
                'name'      => 'Porto União',
                'ibge_code' => '4213609',
            ],

            13 => [
                'state_id'  => '24',
                'name'      => 'Pouso Redondo',
                'ibge_code' => '4213708',
            ],

            14 => [
                'state_id'  => '24',
                'name'      => 'Praia Grande',
                'ibge_code' => '4213807',
            ],

            15 => [
                'state_id'  => '24',
                'name'      => 'Presidente Castello Branco',
                'ibge_code' => '4213906',
            ],

            16 => [
                'state_id'  => '24',
                'name'      => 'Presidente Getúlio',
                'ibge_code' => '4214003',
            ],

            17 => [
                'state_id'  => '24',
                'name'      => 'Presidente Nereu',
                'ibge_code' => '4214102',
            ],

            18 => [
                'state_id'  => '24',
                'name'      => 'Princesa',
                'ibge_code' => '4214151',
            ],

            19 => [
                'state_id'  => '24',
                'name'      => 'Quilombo',
                'ibge_code' => '4214201',
            ],

            20 => [
                'state_id'  => '24',
                'name'      => 'Rancho Queimado',
                'ibge_code' => '4214300',
            ],

            21 => [
                'state_id'  => '24',
                'name'      => 'Rio das Antas',
                'ibge_code' => '4214409',
            ],

            22 => [
                'state_id'  => '24',
                'name'      => 'Rio do Campo',
                'ibge_code' => '4214508',
            ],

            23 => [
                'state_id'  => '24',
                'name'      => 'Rio do Oeste',
                'ibge_code' => '4214607',
            ],

            24 => [
                'state_id'  => '24',
                'name'      => 'Rio dos Cedros',
                'ibge_code' => '4214706',
            ],

            25 => [
                'state_id'  => '24',
                'name'      => 'Rio do Sul',
                'ibge_code' => '4214805',
            ],

            26 => [
                'state_id'  => '24',
                'name'      => 'Rio Fortuna',
                'ibge_code' => '4214904',
            ],

            27 => [
                'state_id'  => '24',
                'name'      => 'Rio Negrinho',
                'ibge_code' => '4215000',
            ],

            28 => [
                'state_id'  => '24',
                'name'      => 'Rio Rufino',
                'ibge_code' => '4215059',
            ],

            29 => [
                'state_id'  => '24',
                'name'      => 'Riqueza',
                'ibge_code' => '4215075',
            ],

            30 => [
                'state_id'  => '24',
                'name'      => 'Rodeio',
                'ibge_code' => '4215109',
            ],

            31 => [
                'state_id'  => '24',
                'name'      => 'Romelândia',
                'ibge_code' => '4215208',
            ],

            32 => [
                'state_id'  => '24',
                'name'      => 'Salete',
                'ibge_code' => '4215307',
            ],

            33 => [
                'state_id'  => '24',
                'name'      => 'Saltinho',
                'ibge_code' => '4215356',
            ],

            34 => [
                'state_id'  => '24',
                'name'      => 'Salto Veloso',
                'ibge_code' => '4215406',
            ],

            35 => [
                'state_id'  => '24',
                'name'      => 'Sangão',
                'ibge_code' => '4215455',
            ],

            36 => [
                'state_id'  => '24',
                'name'      => 'Santa Cecília',
                'ibge_code' => '4215505',
            ],

            37 => [
                'state_id'  => '24',
                'name'      => 'Santa Helena',
                'ibge_code' => '4215554',
            ],

            38 => [
                'state_id'  => '24',
                'name'      => 'Santa Rosa de Lima',
                'ibge_code' => '4215604',
            ],

            39 => [
                'state_id'  => '24',
                'name'      => 'Santa Rosa do Sul',
                'ibge_code' => '4215653',
            ],

            40 => [
                'state_id'  => '24',
                'name'      => 'Santa Terezinha',
                'ibge_code' => '4215679',
            ],

            41 => [
                'state_id'  => '24',
                'name'      => 'Santa Terezinha do Progresso',
                'ibge_code' => '4215687',
            ],

            42 => [
                'state_id'  => '24',
                'name'      => 'Santiago do Sul',
                'ibge_code' => '4215695',
            ],

            43 => [
                'state_id'  => '24',
                'name'      => 'Santo Amaro da Imperatriz',
                'ibge_code' => '4215703',
            ],

            44 => [
                'state_id'  => '24',
                'name'      => 'São Bernardino',
                'ibge_code' => '4215752',
            ],

            45 => [
                'state_id'  => '24',
                'name'      => 'São Bento do Sul',
                'ibge_code' => '4215802',
            ],

            46 => [
                'state_id'  => '24',
                'name'      => 'São Bonifácio',
                'ibge_code' => '4215901',
            ],

            47 => [
                'state_id'  => '24',
                'name'      => 'São Carlos',
                'ibge_code' => '4216008',
            ],

            48 => [
                'state_id'  => '24',
                'name'      => 'São Cristovão do Sul',
                'ibge_code' => '4216057',
            ],

            49 => [
                'state_id'  => '24',
                'name'      => 'São Domingos',
                'ibge_code' => '4216107',
            ],

            50 => [
                'state_id'  => '24',
                'name'      => 'São Francisco do Sul',
                'ibge_code' => '4216206',
            ],

            51 => [
                'state_id'  => '24',
                'name'      => 'São João do Oeste',
                'ibge_code' => '4216255',
            ],

            52 => [
                'state_id'  => '24',
                'name'      => 'São João Batista',
                'ibge_code' => '4216305',
            ],

            53 => [
                'state_id'  => '24',
                'name'      => 'São João do Itaperiú',
                'ibge_code' => '4216354',
            ],

            54 => [
                'state_id'  => '24',
                'name'      => 'São João do Sul',
                'ibge_code' => '4216404',
            ],

            55 => [
                'state_id'  => '24',
                'name'      => 'São Joaquim',
                'ibge_code' => '4216503',
            ],

            56 => [
                'state_id'  => '24',
                'name'      => 'São José',
                'ibge_code' => '4216602',
            ],

            57 => [
                'state_id'  => '24',
                'name'      => 'São José do Cedro',
                'ibge_code' => '4216701',
            ],

            58 => [
                'state_id'  => '24',
                'name'      => 'São José do Cerrito',
                'ibge_code' => '4216800',
            ],

            59 => [
                'state_id'  => '24',
                'name'      => 'São Lourenço do Oeste',
                'ibge_code' => '4216909',
            ],

            60 => [
                'state_id'  => '24',
                'name'      => 'São Ludgero',
                'ibge_code' => '4217006',
            ],

            61 => [
                'state_id'  => '24',
                'name'      => 'São Martinho',
                'ibge_code' => '4217105',
            ],

            62 => [
                'state_id'  => '24',
                'name'      => 'São Miguel da Boa Vista',
                'ibge_code' => '4217154',
            ],

            63 => [
                'state_id'  => '24',
                'name'      => 'São Miguel do Oeste',
                'ibge_code' => '4217204',
            ],

            64 => [
                'state_id'  => '24',
                'name'      => 'São Pedro de Alcântara',
                'ibge_code' => '4217253',
            ],

            65 => [
                'state_id'  => '24',
                'name'      => 'Saudades',
                'ibge_code' => '4217303',
            ],

            66 => [
                'state_id'  => '24',
                'name'      => 'Schroeder',
                'ibge_code' => '4217402',
            ],

            67 => [
                'state_id'  => '24',
                'name'      => 'Seara',
                'ibge_code' => '4217501',
            ],

            68 => [
                'state_id'  => '24',
                'name'      => 'Serra Alta',
                'ibge_code' => '4217550',
            ],

            69 => [
                'state_id'  => '24',
                'name'      => 'Siderópolis',
                'ibge_code' => '4217600',
            ],

            70 => [
                'state_id'  => '24',
                'name'      => 'Sombrio',
                'ibge_code' => '4217709',
            ],

            71 => [
                'state_id'  => '24',
                'name'      => 'Sul Brasil',
                'ibge_code' => '4217758',
            ],

            72 => [
                'state_id'  => '24',
                'name'      => 'Taió',
                'ibge_code' => '4217808',
            ],

            73 => [
                'state_id'  => '24',
                'name'      => 'Tangará',
                'ibge_code' => '4217907',
            ],

            74 => [
                'state_id'  => '24',
                'name'      => 'Tigrinhos',
                'ibge_code' => '4217956',
            ],

            75 => [
                'state_id'  => '24',
                'name'      => 'Tijucas',
                'ibge_code' => '4218004',
            ],

            76 => [
                'state_id'  => '24',
                'name'      => 'Timbé do Sul',
                'ibge_code' => '4218103',
            ],

            77 => [
                'state_id'  => '24',
                'name'      => 'Timbó',
                'ibge_code' => '4218202',
            ],

            78 => [
                'state_id'  => '24',
                'name'      => 'Timbó Grande',
                'ibge_code' => '4218251',
            ],

            79 => [
                'state_id'  => '24',
                'name'      => 'Três Barras',
                'ibge_code' => '4218301',
            ],

            80 => [
                'state_id'  => '24',
                'name'      => 'Treviso',
                'ibge_code' => '4218350',
            ],

            81 => [
                'state_id'  => '24',
                'name'      => 'Treze de Maio',
                'ibge_code' => '4218400',
            ],

            82 => [
                'state_id'  => '24',
                'name'      => 'Treze Tílias',
                'ibge_code' => '4218509',
            ],

            83 => [
                'state_id'  => '24',
                'name'      => 'Trombudo Central',
                'ibge_code' => '4218608',
            ],

            84 => [
                'state_id'  => '24',
                'name'      => 'Tubarão',
                'ibge_code' => '4218707',
            ],

            85 => [
                'state_id'  => '24',
                'name'      => 'Tunápolis',
                'ibge_code' => '4218756',
            ],

            86 => [
                'state_id'  => '24',
                'name'      => 'Turvo',
                'ibge_code' => '4218806',
            ],

            87 => [
                'state_id'  => '24',
                'name'      => 'União do Oeste',
                'ibge_code' => '4218855',
            ],

            88 => [
                'state_id'  => '24',
                'name'      => 'Urubici',
                'ibge_code' => '4218905',
            ],

            89 => [
                'state_id'  => '24',
                'name'      => 'Urupema',
                'ibge_code' => '4218954',
            ],

            90 => [
                'state_id'  => '24',
                'name'      => 'Urussanga',
                'ibge_code' => '4219002',
            ],

            91 => [
                'state_id'  => '24',
                'name'      => 'Vargeão',
                'ibge_code' => '4219101',
            ],

            92 => [
                'state_id'  => '24',
                'name'      => 'Vargem',
                'ibge_code' => '4219150',
            ],

            93 => [
                'state_id'  => '24',
                'name'      => 'Vargem Bonita',
                'ibge_code' => '4219176',
            ],

            94 => [
                'state_id'  => '24',
                'name'      => 'Vidal Ramos',
                'ibge_code' => '4219200',
            ],

            95 => [
                'state_id'  => '24',
                'name'      => 'Videira',
                'ibge_code' => '4219309',
            ],

            96 => [
                'state_id'  => '24',
                'name'      => 'Vitor Meireles',
                'ibge_code' => '4219358',
            ],

            97 => [
                'state_id'  => '24',
                'name'      => 'Witmarsum',
                'ibge_code' => '4219408',
            ],

            98 => [
                'state_id'  => '24',
                'name'      => 'Xanxerê',
                'ibge_code' => '4219507',
            ],

            99 => [
                'state_id'  => '24',
                'name'      => 'Xavantina',
                'ibge_code' => '4219606',
            ],

            100 => [
                'state_id'  => '24',
                'name'      => 'Xaxim',
                'ibge_code' => '4219705',
            ],

            101 => [
                'state_id'  => '24',
                'name'      => 'Zortéa',
                'ibge_code' => '4219853',
            ],

            102 => [
                'state_id'  => '23',
                'name'      => 'Aceguá',
                'ibge_code' => '4300034',
            ],

            103 => [
                'state_id'  => '23',
                'name'      => 'Água Santa',
                'ibge_code' => '4300059',
            ],

            104 => [
                'state_id'  => '23',
                'name'      => 'Agudo',
                'ibge_code' => '4300109',
            ],

            105 => [
                'state_id'  => '23',
                'name'      => 'Ajuricaba',
                'ibge_code' => '4300208',
            ],

            106 => [
                'state_id'  => '23',
                'name'      => 'Alecrim',
                'ibge_code' => '4300307',
            ],

            107 => [
                'state_id'  => '23',
                'name'      => 'Alegrete',
                'ibge_code' => '4300406',
            ],

            108 => [
                'state_id'  => '23',
                'name'      => 'Alegria',
                'ibge_code' => '4300455',
            ],

            109 => [
                'state_id'  => '23',
                'name'      => 'Almirante Tamandaré do Sul',
                'ibge_code' => '4300471',
            ],

            110 => [
                'state_id'  => '23',
                'name'      => 'Alpestre',
                'ibge_code' => '4300505',
            ],

            111 => [
                'state_id'  => '23',
                'name'      => 'Alto Alegre',
                'ibge_code' => '4300554',
            ],

            112 => [
                'state_id'  => '23',
                'name'      => 'Alto Feliz',
                'ibge_code' => '4300570',
            ],

            113 => [
                'state_id'  => '23',
                'name'      => 'Alvorada',
                'ibge_code' => '4300604',
            ],

            114 => [
                'state_id'  => '23',
                'name'      => 'Amaral Ferrador',
                'ibge_code' => '4300638',
            ],

            115 => [
                'state_id'  => '23',
                'name'      => 'Ametista do Sul',
                'ibge_code' => '4300646',
            ],

            116 => [
                'state_id'  => '23',
                'name'      => 'André da Rocha',
                'ibge_code' => '4300661',
            ],

            117 => [
                'state_id'  => '23',
                'name'      => 'Anta Gorda',
                'ibge_code' => '4300703',
            ],

            118 => [
                'state_id'  => '23',
                'name'      => 'Antônio Prado',
                'ibge_code' => '4300802',
            ],

            119 => [
                'state_id'  => '23',
                'name'      => 'Arambaré',
                'ibge_code' => '4300851',
            ],

            120 => [
                'state_id'  => '23',
                'name'      => 'Araricá',
                'ibge_code' => '4300877',
            ],

            121 => [
                'state_id'  => '23',
                'name'      => 'Aratiba',
                'ibge_code' => '4300901',
            ],

            122 => [
                'state_id'  => '23',
                'name'      => 'Arroio do Meio',
                'ibge_code' => '4301008',
            ],

            123 => [
                'state_id'  => '23',
                'name'      => 'Arroio do Sal',
                'ibge_code' => '4301057',
            ],

            124 => [
                'state_id'  => '23',
                'name'      => 'Arroio do Padre',
                'ibge_code' => '4301073',
            ],

            125 => [
                'state_id'  => '23',
                'name'      => 'Arroio dos Ratos',
                'ibge_code' => '4301107',
            ],

            126 => [
                'state_id'  => '23',
                'name'      => 'Arroio do Tigre',
                'ibge_code' => '4301206',
            ],

            127 => [
                'state_id'  => '23',
                'name'      => 'Arroio Grande',
                'ibge_code' => '4301305',
            ],

            128 => [
                'state_id'  => '23',
                'name'      => 'Arvorezinha',
                'ibge_code' => '4301404',
            ],

            129 => [
                'state_id'  => '23',
                'name'      => 'Augusto Pestana',
                'ibge_code' => '4301503',
            ],

            130 => [
                'state_id'  => '23',
                'name'      => 'Áurea',
                'ibge_code' => '4301552',
            ],

            131 => [
                'state_id'  => '23',
                'name'      => 'Bagé',
                'ibge_code' => '4301602',
            ],

            132 => [
                'state_id'  => '23',
                'name'      => 'Balneário Pinhal',
                'ibge_code' => '4301636',
            ],

            133 => [
                'state_id'  => '23',
                'name'      => 'Barão',
                'ibge_code' => '4301651',
            ],

            134 => [
                'state_id'  => '23',
                'name'      => 'Barão de Cotegipe',
                'ibge_code' => '4301701',
            ],

            135 => [
                'state_id'  => '23',
                'name'      => 'Barão do Triunfo',
                'ibge_code' => '4301750',
            ],

            136 => [
                'state_id'  => '23',
                'name'      => 'Barracão',
                'ibge_code' => '4301800',
            ],

            137 => [
                'state_id'  => '23',
                'name'      => 'Barra do Guarita',
                'ibge_code' => '4301859',
            ],

            138 => [
                'state_id'  => '23',
                'name'      => 'Barra do Quaraí',
                'ibge_code' => '4301875',
            ],

            139 => [
                'state_id'  => '23',
                'name'      => 'Barra do Ribeiro',
                'ibge_code' => '4301909',
            ],

            140 => [
                'state_id'  => '23',
                'name'      => 'Barra do Rio Azul',
                'ibge_code' => '4301925',
            ],

            141 => [
                'state_id'  => '23',
                'name'      => 'Barra Funda',
                'ibge_code' => '4301958',
            ],

            142 => [
                'state_id'  => '23',
                'name'      => 'Barros Cassal',
                'ibge_code' => '4302006',
            ],

            143 => [
                'state_id'  => '23',
                'name'      => 'Benjamin Constant do Sul',
                'ibge_code' => '4302055',
            ],

            144 => [
                'state_id'  => '23',
                'name'      => 'Bento Gonçalves',
                'ibge_code' => '4302105',
            ],

            145 => [
                'state_id'  => '23',
                'name'      => 'Boa Vista das Missões',
                'ibge_code' => '4302154',
            ],

            146 => [
                'state_id'  => '23',
                'name'      => 'Boa Vista do Buricá',
                'ibge_code' => '4302204',
            ],

            147 => [
                'state_id'  => '23',
                'name'      => 'Boa Vista do Cadeado',
                'ibge_code' => '4302220',
            ],

            148 => [
                'state_id'  => '23',
                'name'      => 'Boa Vista do Incra',
                'ibge_code' => '4302238',
            ],

            149 => [
                'state_id'  => '23',
                'name'      => 'Boa Vista do Sul',
                'ibge_code' => '4302253',
            ],

            150 => [
                'state_id'  => '23',
                'name'      => 'Bom Jesus',
                'ibge_code' => '4302303',
            ],

            151 => [
                'state_id'  => '23',
                'name'      => 'Bom Princípio',
                'ibge_code' => '4302352',
            ],

            152 => [
                'state_id'  => '23',
                'name'      => 'Bom Progresso',
                'ibge_code' => '4302378',
            ],

            153 => [
                'state_id'  => '23',
                'name'      => 'Bom Retiro do Sul',
                'ibge_code' => '4302402',
            ],

            154 => [
                'state_id'  => '23',
                'name'      => 'Boqueirão do Leão',
                'ibge_code' => '4302451',
            ],

            155 => [
                'state_id'  => '23',
                'name'      => 'Bossoroca',
                'ibge_code' => '4302501',
            ],

            156 => [
                'state_id'  => '23',
                'name'      => 'Bozano',
                'ibge_code' => '4302584',
            ],

            157 => [
                'state_id'  => '23',
                'name'      => 'Braga',
                'ibge_code' => '4302600',
            ],

            158 => [
                'state_id'  => '23',
                'name'      => 'Brochier',
                'ibge_code' => '4302659',
            ],

            159 => [
                'state_id'  => '23',
                'name'      => 'Butiá',
                'ibge_code' => '4302709',
            ],

            160 => [
                'state_id'  => '23',
                'name'      => 'Caçapava do Sul',
                'ibge_code' => '4302808',
            ],

            161 => [
                'state_id'  => '23',
                'name'      => 'Cacequi',
                'ibge_code' => '4302907',
            ],

            162 => [
                'state_id'  => '23',
                'name'      => 'Cachoeira do Sul',
                'ibge_code' => '4303004',
            ],

            163 => [
                'state_id'  => '23',
                'name'      => 'Cachoeirinha',
                'ibge_code' => '4303103',
            ],

            164 => [
                'state_id'  => '23',
                'name'      => 'Cacique Doble',
                'ibge_code' => '4303202',
            ],

            165 => [
                'state_id'  => '23',
                'name'      => 'Caibaté',
                'ibge_code' => '4303301',
            ],

            166 => [
                'state_id'  => '23',
                'name'      => 'Caiçara',
                'ibge_code' => '4303400',
            ],

            167 => [
                'state_id'  => '23',
                'name'      => 'Camaquã',
                'ibge_code' => '4303509',
            ],

            168 => [
                'state_id'  => '23',
                'name'      => 'Camargo',
                'ibge_code' => '4303558',
            ],

            169 => [
                'state_id'  => '23',
                'name'      => 'Cambará do Sul',
                'ibge_code' => '4303608',
            ],

            170 => [
                'state_id'  => '23',
                'name'      => 'Campestre da Serra',
                'ibge_code' => '4303673',
            ],

            171 => [
                'state_id'  => '23',
                'name'      => 'Campina das Missões',
                'ibge_code' => '4303707',
            ],

            172 => [
                'state_id'  => '23',
                'name'      => 'Campinas do Sul',
                'ibge_code' => '4303806',
            ],

            173 => [
                'state_id'  => '23',
                'name'      => 'Campo Bom',
                'ibge_code' => '4303905',
            ],

            174 => [
                'state_id'  => '23',
                'name'      => 'Campo Novo',
                'ibge_code' => '4304002',
            ],

            175 => [
                'state_id'  => '23',
                'name'      => 'Campos Borges',
                'ibge_code' => '4304101',
            ],

            176 => [
                'state_id'  => '23',
                'name'      => 'Candelária',
                'ibge_code' => '4304200',
            ],

            177 => [
                'state_id'  => '23',
                'name'      => 'Cândido Godói',
                'ibge_code' => '4304309',
            ],

            178 => [
                'state_id'  => '23',
                'name'      => 'Candiota',
                'ibge_code' => '4304358',
            ],

            179 => [
                'state_id'  => '23',
                'name'      => 'Canela',
                'ibge_code' => '4304408',
            ],

            180 => [
                'state_id'  => '23',
                'name'      => 'Canguçu',
                'ibge_code' => '4304507',
            ],

            181 => [
                'state_id'  => '23',
                'name'      => 'Canoas',
                'ibge_code' => '4304606',
            ],

            182 => [
                'state_id'  => '23',
                'name'      => 'Canudos do Vale',
                'ibge_code' => '4304614',
            ],

            183 => [
                'state_id'  => '23',
                'name'      => 'Capão Bonito do Sul',
                'ibge_code' => '4304622',
            ],

            184 => [
                'state_id'  => '23',
                'name'      => 'Capão da Canoa',
                'ibge_code' => '4304630',
            ],

            185 => [
                'state_id'  => '23',
                'name'      => 'Capão do Cipó',
                'ibge_code' => '4304655',
            ],

            186 => [
                'state_id'  => '23',
                'name'      => 'Capão do Leão',
                'ibge_code' => '4304663',
            ],

            187 => [
                'state_id'  => '23',
                'name'      => 'Capivari do Sul',
                'ibge_code' => '4304671',
            ],

            188 => [
                'state_id'  => '23',
                'name'      => 'Capela de Santana',
                'ibge_code' => '4304689',
            ],

            189 => [
                'state_id'  => '23',
                'name'      => 'Capitão',
                'ibge_code' => '4304697',
            ],

            190 => [
                'state_id'  => '23',
                'name'      => 'Carazinho',
                'ibge_code' => '4304705',
            ],

            191 => [
                'state_id'  => '23',
                'name'      => 'Caraá',
                'ibge_code' => '4304713',
            ],

            192 => [
                'state_id'  => '23',
                'name'      => 'Carlos Barbosa',
                'ibge_code' => '4304804',
            ],

            193 => [
                'state_id'  => '23',
                'name'      => 'Carlos Gomes',
                'ibge_code' => '4304853',
            ],

            194 => [
                'state_id'  => '23',
                'name'      => 'Casca',
                'ibge_code' => '4304903',
            ],

            195 => [
                'state_id'  => '23',
                'name'      => 'Caseiros',
                'ibge_code' => '4304952',
            ],

            196 => [
                'state_id'  => '23',
                'name'      => 'Catuípe',
                'ibge_code' => '4305009',
            ],

            197 => [
                'state_id'  => '23',
                'name'      => 'Caxias do Sul',
                'ibge_code' => '4305108',
            ],

            198 => [
                'state_id'  => '23',
                'name'      => 'Centenário',
                'ibge_code' => '4305116',
            ],

            199 => [
                'state_id'  => '23',
                'name'      => 'Cerrito',
                'ibge_code' => '4305124',
            ],

            200 => [
                'state_id'  => '23',
                'name'      => 'Cerro Branco',
                'ibge_code' => '4305132',
            ],

            201 => [
                'state_id'  => '23',
                'name'      => 'Cerro Grande',
                'ibge_code' => '4305157',
            ],

            202 => [
                'state_id'  => '23',
                'name'      => 'Cerro Grande do Sul',
                'ibge_code' => '4305173',
            ],

            203 => [
                'state_id'  => '23',
                'name'      => 'Cerro Largo',
                'ibge_code' => '4305207',
            ],

            204 => [
                'state_id'  => '23',
                'name'      => 'Chapada',
                'ibge_code' => '4305306',
            ],

            205 => [
                'state_id'  => '23',
                'name'      => 'Charqueadas',
                'ibge_code' => '4305355',
            ],

            206 => [
                'state_id'  => '23',
                'name'      => 'Charrua',
                'ibge_code' => '4305371',
            ],

            207 => [
                'state_id'  => '23',
                'name'      => 'Chiapetta',
                'ibge_code' => '4305405',
            ],

            208 => [
                'state_id'  => '23',
                'name'      => 'Chuí',
                'ibge_code' => '4305439',
            ],

            209 => [
                'state_id'  => '23',
                'name'      => 'Chuvisca',
                'ibge_code' => '4305447',
            ],

            210 => [
                'state_id'  => '23',
                'name'      => 'Cidreira',
                'ibge_code' => '4305454',
            ],

            211 => [
                'state_id'  => '23',
                'name'      => 'Ciríaco',
                'ibge_code' => '4305504',
            ],

            212 => [
                'state_id'  => '23',
                'name'      => 'Colinas',
                'ibge_code' => '4305587',
            ],

            213 => [
                'state_id'  => '23',
                'name'      => 'Colorado',
                'ibge_code' => '4305603',
            ],

            214 => [
                'state_id'  => '23',
                'name'      => 'Condor',
                'ibge_code' => '4305702',
            ],

            215 => [
                'state_id'  => '23',
                'name'      => 'Constantina',
                'ibge_code' => '4305801',
            ],

            216 => [
                'state_id'  => '23',
                'name'      => 'Coqueiro Baixo',
                'ibge_code' => '4305835',
            ],

            217 => [
                'state_id'  => '23',
                'name'      => 'Coqueiros do Sul',
                'ibge_code' => '4305850',
            ],

            218 => [
                'state_id'  => '23',
                'name'      => 'Coronel Barros',
                'ibge_code' => '4305871',
            ],

            219 => [
                'state_id'  => '23',
                'name'      => 'Coronel Bicaco',
                'ibge_code' => '4305900',
            ],

            220 => [
                'state_id'  => '23',
                'name'      => 'Coronel Pilar',
                'ibge_code' => '4305934',
            ],

            221 => [
                'state_id'  => '23',
                'name'      => 'Cotiporã',
                'ibge_code' => '4305959',
            ],

            222 => [
                'state_id'  => '23',
                'name'      => 'Coxilha',
                'ibge_code' => '4305975',
            ],

            223 => [
                'state_id'  => '23',
                'name'      => 'Crissiumal',
                'ibge_code' => '4306007',
            ],

            224 => [
                'state_id'  => '23',
                'name'      => 'Cristal',
                'ibge_code' => '4306056',
            ],

            225 => [
                'state_id'  => '23',
                'name'      => 'Cristal do Sul',
                'ibge_code' => '4306072',
            ],

            226 => [
                'state_id'  => '23',
                'name'      => 'Cruz Alta',
                'ibge_code' => '4306106',
            ],

            227 => [
                'state_id'  => '23',
                'name'      => 'Cruzaltense',
                'ibge_code' => '4306130',
            ],

            228 => [
                'state_id'  => '23',
                'name'      => 'Cruzeiro do Sul',
                'ibge_code' => '4306205',
            ],

            229 => [
                'state_id'  => '23',
                'name'      => 'David Canabarro',
                'ibge_code' => '4306304',
            ],

            230 => [
                'state_id'  => '23',
                'name'      => 'Derrubadas',
                'ibge_code' => '4306320',
            ],

            231 => [
                'state_id'  => '23',
                'name'      => 'Dezesseis de Novembro',
                'ibge_code' => '4306353',
            ],

            232 => [
                'state_id'  => '23',
                'name'      => 'Dilermando de Aguiar',
                'ibge_code' => '4306379',
            ],

            233 => [
                'state_id'  => '23',
                'name'      => 'Dois Irmãos',
                'ibge_code' => '4306403',
            ],

            234 => [
                'state_id'  => '23',
                'name'      => 'Dois Irmãos das Missões',
                'ibge_code' => '4306429',
            ],

            235 => [
                'state_id'  => '23',
                'name'      => 'Dois Lajeados',
                'ibge_code' => '4306452',
            ],

            236 => [
                'state_id'  => '23',
                'name'      => 'Dom Feliciano',
                'ibge_code' => '4306502',
            ],

            237 => [
                'state_id'  => '23',
                'name'      => 'Dom Pedro de Alcântara',
                'ibge_code' => '4306551',
            ],

            238 => [
                'state_id'  => '23',
                'name'      => 'Dom Pedrito',
                'ibge_code' => '4306601',
            ],

            239 => [
                'state_id'  => '23',
                'name'      => 'Dona Francisca',
                'ibge_code' => '4306700',
            ],

            240 => [
                'state_id'  => '23',
                'name'      => 'Doutor Maurício Cardoso',
                'ibge_code' => '4306734',
            ],

            241 => [
                'state_id'  => '23',
                'name'      => 'Doutor Ricardo',
                'ibge_code' => '4306759',
            ],

            242 => [
                'state_id'  => '23',
                'name'      => 'Eldorado do Sul',
                'ibge_code' => '4306767',
            ],

            243 => [
                'state_id'  => '23',
                'name'      => 'Encantado',
                'ibge_code' => '4306809',
            ],

            244 => [
                'state_id'  => '23',
                'name'      => 'Encruzilhada do Sul',
                'ibge_code' => '4306908',
            ],

            245 => [
                'state_id'  => '23',
                'name'      => 'Engenho Velho',
                'ibge_code' => '4306924',
            ],

            246 => [
                'state_id'  => '23',
                'name'      => 'Entre-Ijuís',
                'ibge_code' => '4306932',
            ],

            247 => [
                'state_id'  => '23',
                'name'      => 'Entre Rios do Sul',
                'ibge_code' => '4306957',
            ],

            248 => [
                'state_id'  => '23',
                'name'      => 'Erebango',
                'ibge_code' => '4306973',
            ],

            249 => [
                'state_id'  => '23',
                'name'      => 'Erechim',
                'ibge_code' => '4307005',
            ],

            250 => [
                'state_id'  => '23',
                'name'      => 'Ernestina',
                'ibge_code' => '4307054',
            ],

            251 => [
                'state_id'  => '23',
                'name'      => 'Herval',
                'ibge_code' => '4307104',
            ],

            252 => [
                'state_id'  => '23',
                'name'      => 'Erval Grande',
                'ibge_code' => '4307203',
            ],

            253 => [
                'state_id'  => '23',
                'name'      => 'Erval Seco',
                'ibge_code' => '4307302',
            ],

            254 => [
                'state_id'  => '23',
                'name'      => 'Esmeralda',
                'ibge_code' => '4307401',
            ],

            255 => [
                'state_id'  => '23',
                'name'      => 'Esperança do Sul',
                'ibge_code' => '4307450',
            ],

            256 => [
                'state_id'  => '23',
                'name'      => 'Espumoso',
                'ibge_code' => '4307500',
            ],

            257 => [
                'state_id'  => '23',
                'name'      => 'Estação',
                'ibge_code' => '4307559',
            ],

            258 => [
                'state_id'  => '23',
                'name'      => 'Estância Velha',
                'ibge_code' => '4307609',
            ],

            259 => [
                'state_id'  => '23',
                'name'      => 'Esteio',
                'ibge_code' => '4307708',
            ],

            260 => [
                'state_id'  => '23',
                'name'      => 'Estrela',
                'ibge_code' => '4307807',
            ],

            261 => [
                'state_id'  => '23',
                'name'      => 'Estrela Velha',
                'ibge_code' => '4307815',
            ],

            262 => [
                'state_id'  => '23',
                'name'      => 'Eugênio de Castro',
                'ibge_code' => '4307831',
            ],

            263 => [
                'state_id'  => '23',
                'name'      => 'Fagundes Varela',
                'ibge_code' => '4307864',
            ],

            264 => [
                'state_id'  => '23',
                'name'      => 'Farroupilha',
                'ibge_code' => '4307906',
            ],

            265 => [
                'state_id'  => '23',
                'name'      => 'Faxinal do Soturno',
                'ibge_code' => '4308003',
            ],

            266 => [
                'state_id'  => '23',
                'name'      => 'Faxinalzinho',
                'ibge_code' => '4308052',
            ],

            267 => [
                'state_id'  => '23',
                'name'      => 'Fazenda Vilanova',
                'ibge_code' => '4308078',
            ],

            268 => [
                'state_id'  => '23',
                'name'      => 'Feliz',
                'ibge_code' => '4308102',
            ],

            269 => [
                'state_id'  => '23',
                'name'      => 'Flores da Cunha',
                'ibge_code' => '4308201',
            ],

            270 => [
                'state_id'  => '23',
                'name'      => 'Floriano Peixoto',
                'ibge_code' => '4308250',
            ],

            271 => [
                'state_id'  => '23',
                'name'      => 'Fontoura Xavier',
                'ibge_code' => '4308300',
            ],

            272 => [
                'state_id'  => '23',
                'name'      => 'Formigueiro',
                'ibge_code' => '4308409',
            ],

            273 => [
                'state_id'  => '23',
                'name'      => 'Forquetinha',
                'ibge_code' => '4308433',
            ],

            274 => [
                'state_id'  => '23',
                'name'      => 'Fortaleza dos Valos',
                'ibge_code' => '4308458',
            ],

            275 => [
                'state_id'  => '23',
                'name'      => 'Frederico Westphalen',
                'ibge_code' => '4308508',
            ],

            276 => [
                'state_id'  => '23',
                'name'      => 'Garibaldi',
                'ibge_code' => '4308607',
            ],

            277 => [
                'state_id'  => '23',
                'name'      => 'Garruchos',
                'ibge_code' => '4308656',
            ],

            278 => [
                'state_id'  => '23',
                'name'      => 'Gaurama',
                'ibge_code' => '4308706',
            ],

            279 => [
                'state_id'  => '23',
                'name'      => 'General Câmara',
                'ibge_code' => '4308805',
            ],

            280 => [
                'state_id'  => '23',
                'name'      => 'Gentil',
                'ibge_code' => '4308854',
            ],

            281 => [
                'state_id'  => '23',
                'name'      => 'Getúlio Vargas',
                'ibge_code' => '4308904',
            ],

            282 => [
                'state_id'  => '23',
                'name'      => 'Giruá',
                'ibge_code' => '4309001',
            ],

            283 => [
                'state_id'  => '23',
                'name'      => 'Glorinha',
                'ibge_code' => '4309050',
            ],

            284 => [
                'state_id'  => '23',
                'name'      => 'Gramado',
                'ibge_code' => '4309100',
            ],

            285 => [
                'state_id'  => '23',
                'name'      => 'Gramado dos Loureiros',
                'ibge_code' => '4309126',
            ],

            286 => [
                'state_id'  => '23',
                'name'      => 'Gramado Xavier',
                'ibge_code' => '4309159',
            ],

            287 => [
                'state_id'  => '23',
                'name'      => 'Gravataí',
                'ibge_code' => '4309209',
            ],

            288 => [
                'state_id'  => '23',
                'name'      => 'Guabiju',
                'ibge_code' => '4309258',
            ],

            289 => [
                'state_id'  => '23',
                'name'      => 'Guaíba',
                'ibge_code' => '4309308',
            ],

            290 => [
                'state_id'  => '23',
                'name'      => 'Guaporé',
                'ibge_code' => '4309407',
            ],

            291 => [
                'state_id'  => '23',
                'name'      => 'Guarani das Missões',
                'ibge_code' => '4309506',
            ],

            292 => [
                'state_id'  => '23',
                'name'      => 'Harmonia',
                'ibge_code' => '4309555',
            ],

            293 => [
                'state_id'  => '23',
                'name'      => 'Herveiras',
                'ibge_code' => '4309571',
            ],

            294 => [
                'state_id'  => '23',
                'name'      => 'Horizontina',
                'ibge_code' => '4309605',
            ],

            295 => [
                'state_id'  => '23',
                'name'      => 'Hulha Negra',
                'ibge_code' => '4309654',
            ],

            296 => [
                'state_id'  => '23',
                'name'      => 'Humaitá',
                'ibge_code' => '4309704',
            ],

            297 => [
                'state_id'  => '23',
                'name'      => 'Ibarama',
                'ibge_code' => '4309753',
            ],

            298 => [
                'state_id'  => '23',
                'name'      => 'Ibiaçá',
                'ibge_code' => '4309803',
            ],

            299 => [
                'state_id'  => '23',
                'name'      => 'Ibiraiaras',
                'ibge_code' => '4309902',
            ],

            300 => [
                'state_id'  => '23',
                'name'      => 'Ibirapuitã',
                'ibge_code' => '4309951',
            ],

            301 => [
                'state_id'  => '23',
                'name'      => 'Ibirubá',
                'ibge_code' => '4310009',
            ],

            302 => [
                'state_id'  => '23',
                'name'      => 'Igrejinha',
                'ibge_code' => '4310108',
            ],

            303 => [
                'state_id'  => '23',
                'name'      => 'Ijuí',
                'ibge_code' => '4310207',
            ],

            304 => [
                'state_id'  => '23',
                'name'      => 'Ilópolis',
                'ibge_code' => '4310306',
            ],

            305 => [
                'state_id'  => '23',
                'name'      => 'Imbé',
                'ibge_code' => '4310330',
            ],

            306 => [
                'state_id'  => '23',
                'name'      => 'Imigrante',
                'ibge_code' => '4310363',
            ],

            307 => [
                'state_id'  => '23',
                'name'      => 'Independência',
                'ibge_code' => '4310405',
            ],

            308 => [
                'state_id'  => '23',
                'name'      => 'Inhacorá',
                'ibge_code' => '4310413',
            ],

            309 => [
                'state_id'  => '23',
                'name'      => 'Ipê',
                'ibge_code' => '4310439',
            ],

            310 => [
                'state_id'  => '23',
                'name'      => 'Ipiranga do Sul',
                'ibge_code' => '4310462',
            ],

            311 => [
                'state_id'  => '23',
                'name'      => 'Iraí',
                'ibge_code' => '4310504',
            ],

            312 => [
                'state_id'  => '23',
                'name'      => 'Itaara',
                'ibge_code' => '4310538',
            ],

            313 => [
                'state_id'  => '23',
                'name'      => 'Itacurubi',
                'ibge_code' => '4310553',
            ],

            314 => [
                'state_id'  => '23',
                'name'      => 'Itapuca',
                'ibge_code' => '4310579',
            ],

            315 => [
                'state_id'  => '23',
                'name'      => 'Itaqui',
                'ibge_code' => '4310603',
            ],

            316 => [
                'state_id'  => '23',
                'name'      => 'Itati',
                'ibge_code' => '4310652',
            ],

            317 => [
                'state_id'  => '23',
                'name'      => 'Itatiba do Sul',
                'ibge_code' => '4310702',
            ],

            318 => [
                'state_id'  => '23',
                'name'      => 'Ivorá',
                'ibge_code' => '4310751',
            ],

            319 => [
                'state_id'  => '23',
                'name'      => 'Ivoti',
                'ibge_code' => '4310801',
            ],

            320 => [
                'state_id'  => '23',
                'name'      => 'Jaboticaba',
                'ibge_code' => '4310850',
            ],

            321 => [
                'state_id'  => '23',
                'name'      => 'Jacuizinho',
                'ibge_code' => '4310876',
            ],

            322 => [
                'state_id'  => '23',
                'name'      => 'Jacutinga',
                'ibge_code' => '4310900',
            ],

            323 => [
                'state_id'  => '23',
                'name'      => 'Jaguarão',
                'ibge_code' => '4311007',
            ],

            324 => [
                'state_id'  => '23',
                'name'      => 'Jaguari',
                'ibge_code' => '4311106',
            ],

            325 => [
                'state_id'  => '23',
                'name'      => 'Jaquirana',
                'ibge_code' => '4311122',
            ],

            326 => [
                'state_id'  => '23',
                'name'      => 'Jari',
                'ibge_code' => '4311130',
            ],

            327 => [
                'state_id'  => '23',
                'name'      => 'Jóia',
                'ibge_code' => '4311155',
            ],

            328 => [
                'state_id'  => '23',
                'name'      => 'Júlio de Castilhos',
                'ibge_code' => '4311205',
            ],

            329 => [
                'state_id'  => '23',
                'name'      => 'Lagoa Bonita do Sul',
                'ibge_code' => '4311239',
            ],

            330 => [
                'state_id'  => '23',
                'name'      => 'Lagoão',
                'ibge_code' => '4311254',
            ],

            331 => [
                'state_id'  => '23',
                'name'      => 'Lagoa dos Três Cantos',
                'ibge_code' => '4311270',
            ],

            332 => [
                'state_id'  => '23',
                'name'      => 'Lagoa Vermelha',
                'ibge_code' => '4311304',
            ],

            333 => [
                'state_id'  => '23',
                'name'      => 'Lajeado',
                'ibge_code' => '4311403',
            ],

            334 => [
                'state_id'  => '23',
                'name'      => 'Lajeado do Bugre',
                'ibge_code' => '4311429',
            ],

            335 => [
                'state_id'  => '23',
                'name'      => 'Lavras do Sul',
                'ibge_code' => '4311502',
            ],

            336 => [
                'state_id'  => '23',
                'name'      => 'Liberato Salzano',
                'ibge_code' => '4311601',
            ],

            337 => [
                'state_id'  => '23',
                'name'      => 'Lindolfo Collor',
                'ibge_code' => '4311627',
            ],

            338 => [
                'state_id'  => '23',
                'name'      => 'Linha Nova',
                'ibge_code' => '4311643',
            ],

            339 => [
                'state_id'  => '23',
                'name'      => 'Machadinho',
                'ibge_code' => '4311700',
            ],

            340 => [
                'state_id'  => '23',
                'name'      => 'Maçambara',
                'ibge_code' => '4311718',
            ],

            341 => [
                'state_id'  => '23',
                'name'      => 'Mampituba',
                'ibge_code' => '4311734',
            ],

            342 => [
                'state_id'  => '23',
                'name'      => 'Manoel Viana',
                'ibge_code' => '4311759',
            ],

            343 => [
                'state_id'  => '23',
                'name'      => 'Maquiné',
                'ibge_code' => '4311775',
            ],

            344 => [
                'state_id'  => '23',
                'name'      => 'Maratá',
                'ibge_code' => '4311791',
            ],

            345 => [
                'state_id'  => '23',
                'name'      => 'Marau',
                'ibge_code' => '4311809',
            ],

            346 => [
                'state_id'  => '23',
                'name'      => 'Marcelino Ramos',
                'ibge_code' => '4311908',
            ],

            347 => [
                'state_id'  => '23',
                'name'      => 'Mariana Pimentel',
                'ibge_code' => '4311981',
            ],

            348 => [
                'state_id'  => '23',
                'name'      => 'Mariano Moro',
                'ibge_code' => '4312005',
            ],

            349 => [
                'state_id'  => '23',
                'name'      => 'Marques de Souza',
                'ibge_code' => '4312054',
            ],

            350 => [
                'state_id'  => '23',
                'name'      => 'Mata',
                'ibge_code' => '4312104',
            ],

            351 => [
                'state_id'  => '23',
                'name'      => 'Mato Castelhano',
                'ibge_code' => '4312138',
            ],

            352 => [
                'state_id'  => '23',
                'name'      => 'Mato Leitão',
                'ibge_code' => '4312153',
            ],

            353 => [
                'state_id'  => '23',
                'name'      => 'Mato Queimado',
                'ibge_code' => '4312179',
            ],

            354 => [
                'state_id'  => '23',
                'name'      => 'Maximiliano de Almeida',
                'ibge_code' => '4312203',
            ],

            355 => [
                'state_id'  => '23',
                'name'      => 'Minas do Leão',
                'ibge_code' => '4312252',
            ],

            356 => [
                'state_id'  => '23',
                'name'      => 'Miraguaí',
                'ibge_code' => '4312302',
            ],

            357 => [
                'state_id'  => '23',
                'name'      => 'Montauri',
                'ibge_code' => '4312351',
            ],

            358 => [
                'state_id'  => '23',
                'name'      => 'Monte Alegre dos Campos',
                'ibge_code' => '4312377',
            ],

            359 => [
                'state_id'  => '23',
                'name'      => 'Monte Belo do Sul',
                'ibge_code' => '4312385',
            ],

            360 => [
                'state_id'  => '23',
                'name'      => 'Montenegro',
                'ibge_code' => '4312401',
            ],

            361 => [
                'state_id'  => '23',
                'name'      => 'Mormaço',
                'ibge_code' => '4312427',
            ],

            362 => [
                'state_id'  => '23',
                'name'      => 'Morrinhos do Sul',
                'ibge_code' => '4312443',
            ],

            363 => [
                'state_id'  => '23',
                'name'      => 'Morro Redondo',
                'ibge_code' => '4312450',
            ],

            364 => [
                'state_id'  => '23',
                'name'      => 'Morro Reuter',
                'ibge_code' => '4312476',
            ],

            365 => [
                'state_id'  => '23',
                'name'      => 'Mostardas',
                'ibge_code' => '4312500',
            ],

            366 => [
                'state_id'  => '23',
                'name'      => 'Muçum',
                'ibge_code' => '4312609',
            ],

            367 => [
                'state_id'  => '23',
                'name'      => 'Muitos Capões',
                'ibge_code' => '4312617',
            ],

            368 => [
                'state_id'  => '23',
                'name'      => 'Muliterno',
                'ibge_code' => '4312625',
            ],

            369 => [
                'state_id'  => '23',
                'name'      => 'Não-Me-Toque',
                'ibge_code' => '4312658',
            ],

            370 => [
                'state_id'  => '23',
                'name'      => 'Nicolau Vergueiro',
                'ibge_code' => '4312674',
            ],

            371 => [
                'state_id'  => '23',
                'name'      => 'Nonoai',
                'ibge_code' => '4312708',
            ],

            372 => [
                'state_id'  => '23',
                'name'      => 'Nova Alvorada',
                'ibge_code' => '4312757',
            ],

            373 => [
                'state_id'  => '23',
                'name'      => 'Nova Araçá',
                'ibge_code' => '4312807',
            ],

            374 => [
                'state_id'  => '23',
                'name'      => 'Nova Bassano',
                'ibge_code' => '4312906',
            ],

            375 => [
                'state_id'  => '23',
                'name'      => 'Nova Boa Vista',
                'ibge_code' => '4312955',
            ],

            376 => [
                'state_id'  => '23',
                'name'      => 'Nova Bréscia',
                'ibge_code' => '4313003',
            ],

            377 => [
                'state_id'  => '23',
                'name'      => 'Nova Candelária',
                'ibge_code' => '4313011',
            ],

            378 => [
                'state_id'  => '23',
                'name'      => 'Nova Esperança do Sul',
                'ibge_code' => '4313037',
            ],

            379 => [
                'state_id'  => '23',
                'name'      => 'Nova Hartz',
                'ibge_code' => '4313060',
            ],

            380 => [
                'state_id'  => '23',
                'name'      => 'Nova Pádua',
                'ibge_code' => '4313086',
            ],

            381 => [
                'state_id'  => '23',
                'name'      => 'Nova Palma',
                'ibge_code' => '4313102',
            ],

            382 => [
                'state_id'  => '23',
                'name'      => 'Nova Petrópolis',
                'ibge_code' => '4313201',
            ],

            383 => [
                'state_id'  => '23',
                'name'      => 'Nova Prata',
                'ibge_code' => '4313300',
            ],

            384 => [
                'state_id'  => '23',
                'name'      => 'Nova Ramada',
                'ibge_code' => '4313334',
            ],

            385 => [
                'state_id'  => '23',
                'name'      => 'Nova Roma do Sul',
                'ibge_code' => '4313359',
            ],

            386 => [
                'state_id'  => '23',
                'name'      => 'Nova Santa Rita',
                'ibge_code' => '4313375',
            ],

            387 => [
                'state_id'  => '23',
                'name'      => 'Novo Cabrais',
                'ibge_code' => '4313391',
            ],

            388 => [
                'state_id'  => '23',
                'name'      => 'Novo Hamburgo',
                'ibge_code' => '4313409',
            ],

            389 => [
                'state_id'  => '23',
                'name'      => 'Novo Machado',
                'ibge_code' => '4313425',
            ],

            390 => [
                'state_id'  => '23',
                'name'      => 'Novo Tiradentes',
                'ibge_code' => '4313441',
            ],

            391 => [
                'state_id'  => '23',
                'name'      => 'Novo Xingu',
                'ibge_code' => '4313466',
            ],

            392 => [
                'state_id'  => '23',
                'name'      => 'Novo Barreiro',
                'ibge_code' => '4313490',
            ],

            393 => [
                'state_id'  => '23',
                'name'      => 'Osório',
                'ibge_code' => '4313508',
            ],

            394 => [
                'state_id'  => '23',
                'name'      => 'Paim Filho',
                'ibge_code' => '4313607',
            ],

            395 => [
                'state_id'  => '23',
                'name'      => 'Palmares do Sul',
                'ibge_code' => '4313656',
            ],

            396 => [
                'state_id'  => '23',
                'name'      => 'Palmeira das Missões',
                'ibge_code' => '4313706',
            ],

            397 => [
                'state_id'  => '23',
                'name'      => 'Palmitinho',
                'ibge_code' => '4313805',
            ],

            398 => [
                'state_id'  => '23',
                'name'      => 'Panambi',
                'ibge_code' => '4313904',
            ],

            399 => [
                'state_id'  => '23',
                'name'      => 'Pantano Grande',
                'ibge_code' => '4313953',
            ],

            400 => [
                'state_id'  => '23',
                'name'      => 'Paraí',
                'ibge_code' => '4314001',
            ],

            401 => [
                'state_id'  => '23',
                'name'      => 'Paraíso do Sul',
                'ibge_code' => '4314027',
            ],

            402 => [
                'state_id'  => '23',
                'name'      => 'Pareci Novo',
                'ibge_code' => '4314035',
            ],

            403 => [
                'state_id'  => '23',
                'name'      => 'Parobé',
                'ibge_code' => '4314050',
            ],

            404 => [
                'state_id'  => '23',
                'name'      => 'Passa Sete',
                'ibge_code' => '4314068',
            ],

            405 => [
                'state_id'  => '23',
                'name'      => 'Passo do Sobrado',
                'ibge_code' => '4314076',
            ],

            406 => [
                'state_id'  => '23',
                'name'      => 'Passo Fundo',
                'ibge_code' => '4314100',
            ],

            407 => [
                'state_id'  => '23',
                'name'      => 'Paulo Bento',
                'ibge_code' => '4314134',
            ],

            408 => [
                'state_id'  => '23',
                'name'      => 'Paverama',
                'ibge_code' => '4314159',
            ],

            409 => [
                'state_id'  => '23',
                'name'      => 'Pedras Altas',
                'ibge_code' => '4314175',
            ],

            410 => [
                'state_id'  => '23',
                'name'      => 'Pedro Osório',
                'ibge_code' => '4314209',
            ],

            411 => [
                'state_id'  => '23',
                'name'      => 'Pejuçara',
                'ibge_code' => '4314308',
            ],

            412 => [
                'state_id'  => '23',
                'name'      => 'Pelotas',
                'ibge_code' => '4314407',
            ],

            413 => [
                'state_id'  => '23',
                'name'      => 'Picada Café',
                'ibge_code' => '4314423',
            ],

            414 => [
                'state_id'  => '23',
                'name'      => 'Pinhal',
                'ibge_code' => '4314456',
            ],

            415 => [
                'state_id'  => '23',
                'name'      => 'Pinhal da Serra',
                'ibge_code' => '4314464',
            ],

            416 => [
                'state_id'  => '23',
                'name'      => 'Pinhal Grande',
                'ibge_code' => '4314472',
            ],

            417 => [
                'state_id'  => '23',
                'name'      => 'Pinheirinho do Vale',
                'ibge_code' => '4314498',
            ],

            418 => [
                'state_id'  => '23',
                'name'      => 'Pinheiro Machado',
                'ibge_code' => '4314506',
            ],

            419 => [
                'state_id'  => '23',
                'name'      => 'Pirapó',
                'ibge_code' => '4314555',
            ],

            420 => [
                'state_id'  => '23',
                'name'      => 'Piratini',
                'ibge_code' => '4314605',
            ],

            421 => [
                'state_id'  => '23',
                'name'      => 'Planalto',
                'ibge_code' => '4314704',
            ],

            422 => [
                'state_id'  => '23',
                'name'      => 'Poço das Antas',
                'ibge_code' => '4314753',
            ],

            423 => [
                'state_id'  => '23',
                'name'      => 'Pontão',
                'ibge_code' => '4314779',
            ],

            424 => [
                'state_id'  => '23',
                'name'      => 'Ponte Preta',
                'ibge_code' => '4314787',
            ],

            425 => [
                'state_id'  => '23',
                'name'      => 'Portão',
                'ibge_code' => '4314803',
            ],

            426 => [
                'state_id'  => '23',
                'name'      => 'Porto Alegre',
                'ibge_code' => '4314902',
            ],

            427 => [
                'state_id'  => '23',
                'name'      => 'Porto Lucena',
                'ibge_code' => '4315008',
            ],

            428 => [
                'state_id'  => '23',
                'name'      => 'Porto Mauá',
                'ibge_code' => '4315057',
            ],

            429 => [
                'state_id'  => '23',
                'name'      => 'Porto Vera Cruz',
                'ibge_code' => '4315073',
            ],

            430 => [
                'state_id'  => '23',
                'name'      => 'Porto Xavier',
                'ibge_code' => '4315107',
            ],

            431 => [
                'state_id'  => '23',
                'name'      => 'Pouso Novo',
                'ibge_code' => '4315131',
            ],

            432 => [
                'state_id'  => '23',
                'name'      => 'Presidente Lucena',
                'ibge_code' => '4315149',
            ],

            433 => [
                'state_id'  => '23',
                'name'      => 'Progresso',
                'ibge_code' => '4315156',
            ],

            434 => [
                'state_id'  => '23',
                'name'      => 'Protásio Alves',
                'ibge_code' => '4315172',
            ],

            435 => [
                'state_id'  => '23',
                'name'      => 'Putinga',
                'ibge_code' => '4315206',
            ],

            436 => [
                'state_id'  => '23',
                'name'      => 'Quaraí',
                'ibge_code' => '4315305',
            ],

            437 => [
                'state_id'  => '23',
                'name'      => 'Quatro Irmãos',
                'ibge_code' => '4315313',
            ],

            438 => [
                'state_id'  => '23',
                'name'      => 'Quevedos',
                'ibge_code' => '4315321',
            ],

            439 => [
                'state_id'  => '23',
                'name'      => 'Quinze de Novembro',
                'ibge_code' => '4315354',
            ],

            440 => [
                'state_id'  => '23',
                'name'      => 'Redentora',
                'ibge_code' => '4315404',
            ],

            441 => [
                'state_id'  => '23',
                'name'      => 'Relvado',
                'ibge_code' => '4315453',
            ],

            442 => [
                'state_id'  => '23',
                'name'      => 'Restinga Seca',
                'ibge_code' => '4315503',
            ],

            443 => [
                'state_id'  => '23',
                'name'      => 'Rio dos Índios',
                'ibge_code' => '4315552',
            ],

            444 => [
                'state_id'  => '23',
                'name'      => 'Rio Grande',
                'ibge_code' => '4315602',
            ],

            445 => [
                'state_id'  => '23',
                'name'      => 'Rio Pardo',
                'ibge_code' => '4315701',
            ],

            446 => [
                'state_id'  => '23',
                'name'      => 'Riozinho',
                'ibge_code' => '4315750',
            ],

            447 => [
                'state_id'  => '23',
                'name'      => 'Roca Sales',
                'ibge_code' => '4315800',
            ],

            448 => [
                'state_id'  => '23',
                'name'      => 'Rodeio Bonito',
                'ibge_code' => '4315909',
            ],

            449 => [
                'state_id'  => '23',
                'name'      => 'Rolador',
                'ibge_code' => '4315958',
            ],

            450 => [
                'state_id'  => '23',
                'name'      => 'Rolante',
                'ibge_code' => '4316006',
            ],

            451 => [
                'state_id'  => '23',
                'name'      => 'Ronda Alta',
                'ibge_code' => '4316105',
            ],

            452 => [
                'state_id'  => '23',
                'name'      => 'Rondinha',
                'ibge_code' => '4316204',
            ],

            453 => [
                'state_id'  => '23',
                'name'      => 'Roque Gonzales',
                'ibge_code' => '4316303',
            ],

            454 => [
                'state_id'  => '23',
                'name'      => 'Rosário do Sul',
                'ibge_code' => '4316402',
            ],

            455 => [
                'state_id'  => '23',
                'name'      => 'Sagrada Família',
                'ibge_code' => '4316428',
            ],

            456 => [
                'state_id'  => '23',
                'name'      => 'Saldanha Marinho',
                'ibge_code' => '4316436',
            ],

            457 => [
                'state_id'  => '23',
                'name'      => 'Salto do Jacuí',
                'ibge_code' => '4316451',
            ],

            458 => [
                'state_id'  => '23',
                'name'      => 'Salvador das Missões',
                'ibge_code' => '4316477',
            ],

            459 => [
                'state_id'  => '23',
                'name'      => 'Salvador do Sul',
                'ibge_code' => '4316501',
            ],

            460 => [
                'state_id'  => '23',
                'name'      => 'Sananduva',
                'ibge_code' => '4316600',
            ],

            461 => [
                'state_id'  => '23',
                'name'      => 'Santa Bárbara do Sul',
                'ibge_code' => '4316709',
            ],

            462 => [
                'state_id'  => '23',
                'name'      => 'Santa Cecília do Sul',
                'ibge_code' => '4316733',
            ],

            463 => [
                'state_id'  => '23',
                'name'      => 'Santa Clara do Sul',
                'ibge_code' => '4316758',
            ],

            464 => [
                'state_id'  => '23',
                'name'      => 'Santa Cruz do Sul',
                'ibge_code' => '4316808',
            ],

            465 => [
                'state_id'  => '23',
                'name'      => 'Santa Maria',
                'ibge_code' => '4316907',
            ],

            466 => [
                'state_id'  => '23',
                'name'      => 'Santa Maria do Herval',
                'ibge_code' => '4316956',
            ],

            467 => [
                'state_id'  => '23',
                'name'      => 'Santa Margarida do Sul',
                'ibge_code' => '4316972',
            ],

            468 => [
                'state_id'  => '23',
                'name'      => 'Santana da Boa Vista',
                'ibge_code' => '4317004',
            ],

            469 => [
                'state_id'  => '23',
                'name'      => 'Santana do Livramento',
                'ibge_code' => '4317103',
            ],

            470 => [
                'state_id'  => '23',
                'name'      => 'Santa Rosa',
                'ibge_code' => '4317202',
            ],

            471 => [
                'state_id'  => '23',
                'name'      => 'Santa Tereza',
                'ibge_code' => '4317251',
            ],

            472 => [
                'state_id'  => '23',
                'name'      => 'Santa Vitória do Palmar',
                'ibge_code' => '4317301',
            ],

            473 => [
                'state_id'  => '23',
                'name'      => 'Santiago',
                'ibge_code' => '4317400',
            ],

            474 => [
                'state_id'  => '23',
                'name'      => 'Santo Ângelo',
                'ibge_code' => '4317509',
            ],

            475 => [
                'state_id'  => '23',
                'name'      => 'Santo Antônio do Palma',
                'ibge_code' => '4317558',
            ],

            476 => [
                'state_id'  => '23',
                'name'      => 'Santo Antônio da Patrulha',
                'ibge_code' => '4317608',
            ],

            477 => [
                'state_id'  => '23',
                'name'      => 'Santo Antônio das Missões',
                'ibge_code' => '4317707',
            ],

            478 => [
                'state_id'  => '23',
                'name'      => 'Santo Antônio do Planalto',
                'ibge_code' => '4317756',
            ],

            479 => [
                'state_id'  => '23',
                'name'      => 'Santo Augusto',
                'ibge_code' => '4317806',
            ],

            480 => [
                'state_id'  => '23',
                'name'      => 'Santo Cristo',
                'ibge_code' => '4317905',
            ],

            481 => [
                'state_id'  => '23',
                'name'      => 'Santo Expedito do Sul',
                'ibge_code' => '4317954',
            ],

            482 => [
                'state_id'  => '23',
                'name'      => 'São Borja',
                'ibge_code' => '4318002',
            ],

            483 => [
                'state_id'  => '23',
                'name'      => 'São Domingos do Sul',
                'ibge_code' => '4318051',
            ],

            484 => [
                'state_id'  => '23',
                'name'      => 'São Francisco de Assis',
                'ibge_code' => '4318101',
            ],

            485 => [
                'state_id'  => '23',
                'name'      => 'São Francisco de Paula',
                'ibge_code' => '4318200',
            ],

            486 => [
                'state_id'  => '23',
                'name'      => 'São Gabriel',
                'ibge_code' => '4318309',
            ],

            487 => [
                'state_id'  => '23',
                'name'      => 'São Jerônimo',
                'ibge_code' => '4318408',
            ],

            488 => [
                'state_id'  => '23',
                'name'      => 'São João da Urtiga',
                'ibge_code' => '4318424',
            ],

            489 => [
                'state_id'  => '23',
                'name'      => 'São João do Polêsine',
                'ibge_code' => '4318432',
            ],

            490 => [
                'state_id'  => '23',
                'name'      => 'São Jorge',
                'ibge_code' => '4318440',
            ],

            491 => [
                'state_id'  => '23',
                'name'      => 'São José das Missões',
                'ibge_code' => '4318457',
            ],

            492 => [
                'state_id'  => '23',
                'name'      => 'São José do Herval',
                'ibge_code' => '4318465',
            ],

            493 => [
                'state_id'  => '23',
                'name'      => 'São José do Hortêncio',
                'ibge_code' => '4318481',
            ],

            494 => [
                'state_id'  => '23',
                'name'      => 'São José do Inhacorá',
                'ibge_code' => '4318499',
            ],

            495 => [
                'state_id'  => '23',
                'name'      => 'São José do Norte',
                'ibge_code' => '4318507',
            ],

            496 => [
                'state_id'  => '23',
                'name'      => 'São José do Ouro',
                'ibge_code' => '4318606',
            ],

            497 => [
                'state_id'  => '23',
                'name'      => 'São José do Sul',
                'ibge_code' => '4318614',
            ],

            498 => [
                'state_id'  => '23',
                'name'      => 'São José dos Ausentes',
                'ibge_code' => '4318622',
            ],

            499 => [
                'state_id'  => '23',
                'name'      => 'São Leopoldo',
                'ibge_code' => '4318705',
            ],

        ]);
        DB::table('cities')->insert([
            0 => [
                'state_id'  => '23',
                'name'      => 'São Lourenço do Sul',
                'ibge_code' => '4318804',
            ],

            1 => [
                'state_id'  => '23',
                'name'      => 'São Luiz Gonzaga',
                'ibge_code' => '4318903',
            ],

            2 => [
                'state_id'  => '23',
                'name'      => 'São Marcos',
                'ibge_code' => '4319000',
            ],

            3 => [
                'state_id'  => '23',
                'name'      => 'São Martinho',
                'ibge_code' => '4319109',
            ],

            4 => [
                'state_id'  => '23',
                'name'      => 'São Martinho da Serra',
                'ibge_code' => '4319125',
            ],

            5 => [
                'state_id'  => '23',
                'name'      => 'São Miguel das Missões',
                'ibge_code' => '4319158',
            ],

            6 => [
                'state_id'  => '23',
                'name'      => 'São Nicolau',
                'ibge_code' => '4319208',
            ],

            7 => [
                'state_id'  => '23',
                'name'      => 'São Paulo das Missões',
                'ibge_code' => '4319307',
            ],

            8 => [
                'state_id'  => '23',
                'name'      => 'São Pedro da Serra',
                'ibge_code' => '4319356',
            ],

            9 => [
                'state_id'  => '23',
                'name'      => 'São Pedro das Missões',
                'ibge_code' => '4319364',
            ],

            10 => [
                'state_id'  => '23',
                'name'      => 'São Pedro do Butiá',
                'ibge_code' => '4319372',
            ],

            11 => [
                'state_id'  => '23',
                'name'      => 'São Pedro do Sul',
                'ibge_code' => '4319406',
            ],

            12 => [
                'state_id'  => '23',
                'name'      => 'São Sebastião do Caí',
                'ibge_code' => '4319505',
            ],

            13 => [
                'state_id'  => '23',
                'name'      => 'São Sepé',
                'ibge_code' => '4319604',
            ],

            14 => [
                'state_id'  => '23',
                'name'      => 'São Valentim',
                'ibge_code' => '4319703',
            ],

            15 => [
                'state_id'  => '23',
                'name'      => 'São Valentim do Sul',
                'ibge_code' => '4319711',
            ],

            16 => [
                'state_id'  => '23',
                'name'      => 'São Valério do Sul',
                'ibge_code' => '4319737',
            ],

            17 => [
                'state_id'  => '23',
                'name'      => 'São Vendelino',
                'ibge_code' => '4319752',
            ],

            18 => [
                'state_id'  => '23',
                'name'      => 'São Vicente do Sul',
                'ibge_code' => '4319802',
            ],

            19 => [
                'state_id'  => '23',
                'name'      => 'Sapiranga',
                'ibge_code' => '4319901',
            ],

            20 => [
                'state_id'  => '23',
                'name'      => 'Sapucaia do Sul',
                'ibge_code' => '4320008',
            ],

            21 => [
                'state_id'  => '23',
                'name'      => 'Sarandi',
                'ibge_code' => '4320107',
            ],

            22 => [
                'state_id'  => '23',
                'name'      => 'Seberi',
                'ibge_code' => '4320206',
            ],

            23 => [
                'state_id'  => '23',
                'name'      => 'Sede Nova',
                'ibge_code' => '4320230',
            ],

            24 => [
                'state_id'  => '23',
                'name'      => 'Segredo',
                'ibge_code' => '4320263',
            ],

            25 => [
                'state_id'  => '23',
                'name'      => 'Selbach',
                'ibge_code' => '4320305',
            ],

            26 => [
                'state_id'  => '23',
                'name'      => 'Senador Salgado Filho',
                'ibge_code' => '4320321',
            ],

            27 => [
                'state_id'  => '23',
                'name'      => 'Sentinela do Sul',
                'ibge_code' => '4320354',
            ],

            28 => [
                'state_id'  => '23',
                'name'      => 'Serafina Corrêa',
                'ibge_code' => '4320404',
            ],

            29 => [
                'state_id'  => '23',
                'name'      => 'Sério',
                'ibge_code' => '4320453',
            ],

            30 => [
                'state_id'  => '23',
                'name'      => 'Sertão',
                'ibge_code' => '4320503',
            ],

            31 => [
                'state_id'  => '23',
                'name'      => 'Sertão Santana',
                'ibge_code' => '4320552',
            ],

            32 => [
                'state_id'  => '23',
                'name'      => 'Sete de Setembro',
                'ibge_code' => '4320578',
            ],

            33 => [
                'state_id'  => '23',
                'name'      => 'Severiano de Almeida',
                'ibge_code' => '4320602',
            ],

            34 => [
                'state_id'  => '23',
                'name'      => 'Silveira Martins',
                'ibge_code' => '4320651',
            ],

            35 => [
                'state_id'  => '23',
                'name'      => 'Sinimbu',
                'ibge_code' => '4320677',
            ],

            36 => [
                'state_id'  => '23',
                'name'      => 'Sobradinho',
                'ibge_code' => '4320701',
            ],

            37 => [
                'state_id'  => '23',
                'name'      => 'Soledade',
                'ibge_code' => '4320800',
            ],

            38 => [
                'state_id'  => '23',
                'name'      => 'Tabaí',
                'ibge_code' => '4320859',
            ],

            39 => [
                'state_id'  => '23',
                'name'      => 'Tapejara',
                'ibge_code' => '4320909',
            ],

            40 => [
                'state_id'  => '23',
                'name'      => 'Tapera',
                'ibge_code' => '4321006',
            ],

            41 => [
                'state_id'  => '23',
                'name'      => 'Tapes',
                'ibge_code' => '4321105',
            ],

            42 => [
                'state_id'  => '23',
                'name'      => 'Taquara',
                'ibge_code' => '4321204',
            ],

            43 => [
                'state_id'  => '23',
                'name'      => 'Taquari',
                'ibge_code' => '4321303',
            ],

            44 => [
                'state_id'  => '23',
                'name'      => 'Taquaruçu do Sul',
                'ibge_code' => '4321329',
            ],

            45 => [
                'state_id'  => '23',
                'name'      => 'Tavares',
                'ibge_code' => '4321352',
            ],

            46 => [
                'state_id'  => '23',
                'name'      => 'Tenente Portela',
                'ibge_code' => '4321402',
            ],

            47 => [
                'state_id'  => '23',
                'name'      => 'Terra de Areia',
                'ibge_code' => '4321436',
            ],

            48 => [
                'state_id'  => '23',
                'name'      => 'Teutônia',
                'ibge_code' => '4321451',
            ],

            49 => [
                'state_id'  => '23',
                'name'      => 'Tio Hugo',
                'ibge_code' => '4321469',
            ],

            50 => [
                'state_id'  => '23',
                'name'      => 'Tiradentes do Sul',
                'ibge_code' => '4321477',
            ],

            51 => [
                'state_id'  => '23',
                'name'      => 'Toropi',
                'ibge_code' => '4321493',
            ],

            52 => [
                'state_id'  => '23',
                'name'      => 'Torres',
                'ibge_code' => '4321501',
            ],

            53 => [
                'state_id'  => '23',
                'name'      => 'Tramandaí',
                'ibge_code' => '4321600',
            ],

            54 => [
                'state_id'  => '23',
                'name'      => 'Travesseiro',
                'ibge_code' => '4321626',
            ],

            55 => [
                'state_id'  => '23',
                'name'      => 'Três Arroios',
                'ibge_code' => '4321634',
            ],

            56 => [
                'state_id'  => '23',
                'name'      => 'Três Cachoeiras',
                'ibge_code' => '4321667',
            ],

            57 => [
                'state_id'  => '23',
                'name'      => 'Três Coroas',
                'ibge_code' => '4321709',
            ],

            58 => [
                'state_id'  => '23',
                'name'      => 'Três de Maio',
                'ibge_code' => '4321808',
            ],

            59 => [
                'state_id'  => '23',
                'name'      => 'Três Forquilhas',
                'ibge_code' => '4321832',
            ],

            60 => [
                'state_id'  => '23',
                'name'      => 'Três Palmeiras',
                'ibge_code' => '4321857',
            ],

            61 => [
                'state_id'  => '23',
                'name'      => 'Três Passos',
                'ibge_code' => '4321907',
            ],

            62 => [
                'state_id'  => '23',
                'name'      => 'Trindade do Sul',
                'ibge_code' => '4321956',
            ],

            63 => [
                'state_id'  => '23',
                'name'      => 'Triunfo',
                'ibge_code' => '4322004',
            ],

            64 => [
                'state_id'  => '23',
                'name'      => 'Tucunduva',
                'ibge_code' => '4322103',
            ],

            65 => [
                'state_id'  => '23',
                'name'      => 'Tunas',
                'ibge_code' => '4322152',
            ],

            66 => [
                'state_id'  => '23',
                'name'      => 'Tupanci do Sul',
                'ibge_code' => '4322186',
            ],

            67 => [
                'state_id'  => '23',
                'name'      => 'Tupanciretã',
                'ibge_code' => '4322202',
            ],

            68 => [
                'state_id'  => '23',
                'name'      => 'Tupandi',
                'ibge_code' => '4322251',
            ],

            69 => [
                'state_id'  => '23',
                'name'      => 'Tuparendi',
                'ibge_code' => '4322301',
            ],

            70 => [
                'state_id'  => '23',
                'name'      => 'Turuçu',
                'ibge_code' => '4322327',
            ],

            71 => [
                'state_id'  => '23',
                'name'      => 'Ubiretama',
                'ibge_code' => '4322343',
            ],

            72 => [
                'state_id'  => '23',
                'name'      => 'União da Serra',
                'ibge_code' => '4322350',
            ],

            73 => [
                'state_id'  => '23',
                'name'      => 'Unistalda',
                'ibge_code' => '4322376',
            ],

            74 => [
                'state_id'  => '23',
                'name'      => 'Uruguaiana',
                'ibge_code' => '4322400',
            ],

            75 => [
                'state_id'  => '23',
                'name'      => 'Vacaria',
                'ibge_code' => '4322509',
            ],

            76 => [
                'state_id'  => '23',
                'name'      => 'Vale Verde',
                'ibge_code' => '4322525',
            ],

            77 => [
                'state_id'  => '23',
                'name'      => 'Vale do Sol',
                'ibge_code' => '4322533',
            ],

            78 => [
                'state_id'  => '23',
                'name'      => 'Vale Real',
                'ibge_code' => '4322541',
            ],

            79 => [
                'state_id'  => '23',
                'name'      => 'Vanini',
                'ibge_code' => '4322558',
            ],

            80 => [
                'state_id'  => '23',
                'name'      => 'Venâncio Aires',
                'ibge_code' => '4322608',
            ],

            81 => [
                'state_id'  => '23',
                'name'      => 'Vera Cruz',
                'ibge_code' => '4322707',
            ],

            82 => [
                'state_id'  => '23',
                'name'      => 'Veranópolis',
                'ibge_code' => '4322806',
            ],

            83 => [
                'state_id'  => '23',
                'name'      => 'Vespasiano Correa',
                'ibge_code' => '4322855',
            ],

            84 => [
                'state_id'  => '23',
                'name'      => 'Viadutos',
                'ibge_code' => '4322905',
            ],

            85 => [
                'state_id'  => '23',
                'name'      => 'Viamão',
                'ibge_code' => '4323002',
            ],

            86 => [
                'state_id'  => '23',
                'name'      => 'Vicente Dutra',
                'ibge_code' => '4323101',
            ],

            87 => [
                'state_id'  => '23',
                'name'      => 'Victor Graeff',
                'ibge_code' => '4323200',
            ],

            88 => [
                'state_id'  => '23',
                'name'      => 'Vila Flores',
                'ibge_code' => '4323309',
            ],

            89 => [
                'state_id'  => '23',
                'name'      => 'Vila Lângaro',
                'ibge_code' => '4323358',
            ],

            90 => [
                'state_id'  => '23',
                'name'      => 'Vila Maria',
                'ibge_code' => '4323408',
            ],

            91 => [
                'state_id'  => '23',
                'name'      => 'Vila Nova do Sul',
                'ibge_code' => '4323457',
            ],

            92 => [
                'state_id'  => '23',
                'name'      => 'Vista Alegre',
                'ibge_code' => '4323507',
            ],

            93 => [
                'state_id'  => '23',
                'name'      => 'Vista Alegre do Prata',
                'ibge_code' => '4323606',
            ],

            94 => [
                'state_id'  => '23',
                'name'      => 'Vista Gaúcha',
                'ibge_code' => '4323705',
            ],

            95 => [
                'state_id'  => '23',
                'name'      => 'Vitória das Missões',
                'ibge_code' => '4323754',
            ],

            96 => [
                'state_id'  => '23',
                'name'      => 'Westfalia',
                'ibge_code' => '4323770',
            ],

            97 => [
                'state_id'  => '23',
                'name'      => 'Xangri-Lá',
                'ibge_code' => '4323804',
            ],

            98 => [
                'state_id'  => '12',
                'name'      => 'Água Clara',
                'ibge_code' => '5000203',
            ],

            99 => [
                'state_id'  => '12',
                'name'      => 'Alcinópolis',
                'ibge_code' => '5000252',
            ],

            100 => [
                'state_id'  => '12',
                'name'      => 'Amambaí',
                'ibge_code' => '5000609',
            ],

            101 => [
                'state_id'  => '12',
                'name'      => 'Anastácio',
                'ibge_code' => '5000708',
            ],

            102 => [
                'state_id'  => '12',
                'name'      => 'Anaurilândia',
                'ibge_code' => '5000807',
            ],

            103 => [
                'state_id'  => '12',
                'name'      => 'Angélica',
                'ibge_code' => '5000856',
            ],

            104 => [
                'state_id'  => '12',
                'name'      => 'Antônio João',
                'ibge_code' => '5000906',
            ],

            105 => [
                'state_id'  => '12',
                'name'      => 'Aparecida do Taboado',
                'ibge_code' => '5001003',
            ],

            106 => [
                'state_id'  => '12',
                'name'      => 'Aquidauana',
                'ibge_code' => '5001102',
            ],

            107 => [
                'state_id'  => '12',
                'name'      => 'Aral Moreira',
                'ibge_code' => '5001243',
            ],

            108 => [
                'state_id'  => '12',
                'name'      => 'Bandeirantes',
                'ibge_code' => '5001508',
            ],

            109 => [
                'state_id'  => '12',
                'name'      => 'Bataguassu',
                'ibge_code' => '5001904',
            ],

            110 => [
                'state_id'  => '12',
                'name'      => 'Batayporã',
                'ibge_code' => '5002001',
            ],

            111 => [
                'state_id'  => '12',
                'name'      => 'Bela Vista',
                'ibge_code' => '5002100',
            ],

            112 => [
                'state_id'  => '12',
                'name'      => 'Bodoquena',
                'ibge_code' => '5002159',
            ],

            113 => [
                'state_id'  => '12',
                'name'      => 'Bonito',
                'ibge_code' => '5002209',
            ],

            114 => [
                'state_id'  => '12',
                'name'      => 'Brasilândia',
                'ibge_code' => '5002308',
            ],

            115 => [
                'state_id'  => '12',
                'name'      => 'Caarapó',
                'ibge_code' => '5002407',
            ],

            116 => [
                'state_id'  => '12',
                'name'      => 'Camapuã',
                'ibge_code' => '5002605',
            ],

            117 => [
                'state_id'  => '12',
                'name'      => 'Campo Grande',
                'ibge_code' => '5002704',
            ],

            118 => [
                'state_id'  => '12',
                'name'      => 'Caracol',
                'ibge_code' => '5002803',
            ],

            119 => [
                'state_id'  => '12',
                'name'      => 'Cassilândia',
                'ibge_code' => '5002902',
            ],

            120 => [
                'state_id'  => '12',
                'name'      => 'Chapadão do Sul',
                'ibge_code' => '5002951',
            ],

            121 => [
                'state_id'  => '12',
                'name'      => 'Corguinho',
                'ibge_code' => '5003108',
            ],

            122 => [
                'state_id'  => '12',
                'name'      => 'Coronel Sapucaia',
                'ibge_code' => '5003157',
            ],

            123 => [
                'state_id'  => '12',
                'name'      => 'Corumbá',
                'ibge_code' => '5003207',
            ],

            124 => [
                'state_id'  => '12',
                'name'      => 'Costa Rica',
                'ibge_code' => '5003256',
            ],

            125 => [
                'state_id'  => '12',
                'name'      => 'Coxim',
                'ibge_code' => '5003306',
            ],

            126 => [
                'state_id'  => '12',
                'name'      => 'Deodápolis',
                'ibge_code' => '5003454',
            ],

            127 => [
                'state_id'  => '12',
                'name'      => 'Dois Irmãos do Buriti',
                'ibge_code' => '5003488',
            ],

            128 => [
                'state_id'  => '12',
                'name'      => 'Douradina',
                'ibge_code' => '5003504',
            ],

            129 => [
                'state_id'  => '12',
                'name'      => 'Dourados',
                'ibge_code' => '5003702',
            ],

            130 => [
                'state_id'  => '12',
                'name'      => 'Eldorado',
                'ibge_code' => '5003751',
            ],

            131 => [
                'state_id'  => '12',
                'name'      => 'Fátima do Sul',
                'ibge_code' => '5003801',
            ],

            132 => [
                'state_id'  => '12',
                'name'      => 'Figueirão',
                'ibge_code' => '5003900',
            ],

            133 => [
                'state_id'  => '12',
                'name'      => 'Glória de Dourados',
                'ibge_code' => '5004007',
            ],

            134 => [
                'state_id'  => '12',
                'name'      => 'Guia Lopes da Laguna',
                'ibge_code' => '5004106',
            ],

            135 => [
                'state_id'  => '12',
                'name'      => 'Iguatemi',
                'ibge_code' => '5004304',
            ],

            136 => [
                'state_id'  => '12',
                'name'      => 'Inocência',
                'ibge_code' => '5004403',
            ],

            137 => [
                'state_id'  => '12',
                'name'      => 'Itaporã',
                'ibge_code' => '5004502',
            ],

            138 => [
                'state_id'  => '12',
                'name'      => 'Itaquiraí',
                'ibge_code' => '5004601',
            ],

            139 => [
                'state_id'  => '12',
                'name'      => 'Ivinhema',
                'ibge_code' => '5004700',
            ],

            140 => [
                'state_id'  => '12',
                'name'      => 'Japorã',
                'ibge_code' => '5004809',
            ],

            141 => [
                'state_id'  => '12',
                'name'      => 'Jaraguari',
                'ibge_code' => '5004908',
            ],

            142 => [
                'state_id'  => '12',
                'name'      => 'Jardim',
                'ibge_code' => '5005004',
            ],

            143 => [
                'state_id'  => '12',
                'name'      => 'Jateí',
                'ibge_code' => '5005103',
            ],

            144 => [
                'state_id'  => '12',
                'name'      => 'Juti',
                'ibge_code' => '5005152',
            ],

            145 => [
                'state_id'  => '12',
                'name'      => 'Ladário',
                'ibge_code' => '5005202',
            ],

            146 => [
                'state_id'  => '12',
                'name'      => 'Laguna Carapã',
                'ibge_code' => '5005251',
            ],

            147 => [
                'state_id'  => '12',
                'name'      => 'Maracaju',
                'ibge_code' => '5005400',
            ],

            148 => [
                'state_id'  => '12',
                'name'      => 'Miranda',
                'ibge_code' => '5005608',
            ],

            149 => [
                'state_id'  => '12',
                'name'      => 'Mundo Novo',
                'ibge_code' => '5005681',
            ],

            150 => [
                'state_id'  => '12',
                'name'      => 'Naviraí',
                'ibge_code' => '5005707',
            ],

            151 => [
                'state_id'  => '12',
                'name'      => 'Nioaque',
                'ibge_code' => '5005806',
            ],

            152 => [
                'state_id'  => '12',
                'name'      => 'Nova Alvorada do Sul',
                'ibge_code' => '5006002',
            ],

            153 => [
                'state_id'  => '12',
                'name'      => 'Nova Andradina',
                'ibge_code' => '5006200',
            ],

            154 => [
                'state_id'  => '12',
                'name'      => 'Novo Horizonte do Sul',
                'ibge_code' => '5006259',
            ],

            155 => [
                'state_id'  => '12',
                'name'      => 'Paranaíba',
                'ibge_code' => '5006309',
            ],

            156 => [
                'state_id'  => '12',
                'name'      => 'Paranhos',
                'ibge_code' => '5006358',
            ],

            157 => [
                'state_id'  => '12',
                'name'      => 'Pedro Gomes',
                'ibge_code' => '5006408',
            ],

            158 => [
                'state_id'  => '12',
                'name'      => 'Ponta Porã',
                'ibge_code' => '5006606',
            ],

            159 => [
                'state_id'  => '12',
                'name'      => 'Porto Murtinho',
                'ibge_code' => '5006903',
            ],

            160 => [
                'state_id'  => '12',
                'name'      => 'Ribas do Rio Pardo',
                'ibge_code' => '5007109',
            ],

            161 => [
                'state_id'  => '12',
                'name'      => 'Rio Brilhante',
                'ibge_code' => '5007208',
            ],

            162 => [
                'state_id'  => '12',
                'name'      => 'Rio Negro',
                'ibge_code' => '5007307',
            ],

            163 => [
                'state_id'  => '12',
                'name'      => 'Rio Verde de Mato Grosso',
                'ibge_code' => '5007406',
            ],

            164 => [
                'state_id'  => '12',
                'name'      => 'Rochedo',
                'ibge_code' => '5007505',
            ],

            165 => [
                'state_id'  => '12',
                'name'      => 'Santa Rita do Pardo',
                'ibge_code' => '5007554',
            ],

            166 => [
                'state_id'  => '12',
                'name'      => 'São Gabriel do Oeste',
                'ibge_code' => '5007695',
            ],

            167 => [
                'state_id'  => '12',
                'name'      => 'Sete Quedas',
                'ibge_code' => '5007703',
            ],

            168 => [
                'state_id'  => '12',
                'name'      => 'Selvíria',
                'ibge_code' => '5007802',
            ],

            169 => [
                'state_id'  => '12',
                'name'      => 'Sidrolândia',
                'ibge_code' => '5007901',
            ],

            170 => [
                'state_id'  => '12',
                'name'      => 'Sonora',
                'ibge_code' => '5007935',
            ],

            171 => [
                'state_id'  => '12',
                'name'      => 'Tacuru',
                'ibge_code' => '5007950',
            ],

            172 => [
                'state_id'  => '12',
                'name'      => 'Taquarussu',
                'ibge_code' => '5007976',
            ],

            173 => [
                'state_id'  => '12',
                'name'      => 'Terenos',
                'ibge_code' => '5008008',
            ],

            174 => [
                'state_id'  => '12',
                'name'      => 'Três Lagoas',
                'ibge_code' => '5008305',
            ],

            175 => [
                'state_id'  => '12',
                'name'      => 'Vicentina',
                'ibge_code' => '5008404',
            ],

            176 => [
                'state_id'  => '13',
                'name'      => 'Acorizal',
                'ibge_code' => '5100102',
            ],

            177 => [
                'state_id'  => '13',
                'name'      => 'Água Boa',
                'ibge_code' => '5100201',
            ],

            178 => [
                'state_id'  => '13',
                'name'      => 'Alta Floresta',
                'ibge_code' => '5100250',
            ],

            179 => [
                'state_id'  => '13',
                'name'      => 'Alto Araguaia',
                'ibge_code' => '5100300',
            ],

            180 => [
                'state_id'  => '13',
                'name'      => 'Alto Boa Vista',
                'ibge_code' => '5100359',
            ],

            181 => [
                'state_id'  => '13',
                'name'      => 'Alto Garças',
                'ibge_code' => '5100409',
            ],

            182 => [
                'state_id'  => '13',
                'name'      => 'Alto Paraguai',
                'ibge_code' => '5100508',
            ],

            183 => [
                'state_id'  => '13',
                'name'      => 'Alto Taquari',
                'ibge_code' => '5100607',
            ],

            184 => [
                'state_id'  => '13',
                'name'      => 'Apiacás',
                'ibge_code' => '5100805',
            ],

            185 => [
                'state_id'  => '13',
                'name'      => 'Araguaiana',
                'ibge_code' => '5101001',
            ],

            186 => [
                'state_id'  => '13',
                'name'      => 'Araguainha',
                'ibge_code' => '5101209',
            ],

            187 => [
                'state_id'  => '13',
                'name'      => 'Araputanga',
                'ibge_code' => '5101258',
            ],

            188 => [
                'state_id'  => '13',
                'name'      => 'Arenápolis',
                'ibge_code' => '5101308',
            ],

            189 => [
                'state_id'  => '13',
                'name'      => 'Aripuanã',
                'ibge_code' => '5101407',
            ],

            190 => [
                'state_id'  => '13',
                'name'      => 'Barão de Melgaço',
                'ibge_code' => '5101605',
            ],

            191 => [
                'state_id'  => '13',
                'name'      => 'Barra do Bugres',
                'ibge_code' => '5101704',
            ],

            192 => [
                'state_id'  => '13',
                'name'      => 'Barra do Garças',
                'ibge_code' => '5101803',
            ],

            193 => [
                'state_id'  => '13',
                'name'      => 'Bom Jesus do Araguaia',
                'ibge_code' => '5101852',
            ],

            194 => [
                'state_id'  => '13',
                'name'      => 'Brasnorte',
                'ibge_code' => '5101902',
            ],

            195 => [
                'state_id'  => '13',
                'name'      => 'Cáceres',
                'ibge_code' => '5102504',
            ],

            196 => [
                'state_id'  => '13',
                'name'      => 'Campinápolis',
                'ibge_code' => '5102603',
            ],

            197 => [
                'state_id'  => '13',
                'name'      => 'Campo Novo do Parecis',
                'ibge_code' => '5102637',
            ],

            198 => [
                'state_id'  => '13',
                'name'      => 'Campo Verde',
                'ibge_code' => '5102678',
            ],

            199 => [
                'state_id'  => '13',
                'name'      => 'Campos de Júlio',
                'ibge_code' => '5102686',
            ],

            200 => [
                'state_id'  => '13',
                'name'      => 'Canabrava do Norte',
                'ibge_code' => '5102694',
            ],

            201 => [
                'state_id'  => '13',
                'name'      => 'Canarana',
                'ibge_code' => '5102702',
            ],

            202 => [
                'state_id'  => '13',
                'name'      => 'Carlinda',
                'ibge_code' => '5102793',
            ],

            203 => [
                'state_id'  => '13',
                'name'      => 'Castanheira',
                'ibge_code' => '5102850',
            ],

            204 => [
                'state_id'  => '13',
                'name'      => 'Chapada dos Guimarães',
                'ibge_code' => '5103007',
            ],

            205 => [
                'state_id'  => '13',
                'name'      => 'Cláudia',
                'ibge_code' => '5103056',
            ],

            206 => [
                'state_id'  => '13',
                'name'      => 'Cocalinho',
                'ibge_code' => '5103106',
            ],

            207 => [
                'state_id'  => '13',
                'name'      => 'Colíder',
                'ibge_code' => '5103205',
            ],

            208 => [
                'state_id'  => '13',
                'name'      => 'Colniza',
                'ibge_code' => '5103254',
            ],

            209 => [
                'state_id'  => '13',
                'name'      => 'Comodoro',
                'ibge_code' => '5103304',
            ],

            210 => [
                'state_id'  => '13',
                'name'      => 'Confresa',
                'ibge_code' => '5103353',
            ],

            211 => [
                'state_id'  => '13',
                'name'      => "Conquista D'oeste",
                'ibge_code' => '5103361',
            ],

            212 => [
                'state_id'  => '13',
                'name'      => 'Cotriguaçu',
                'ibge_code' => '5103379',
            ],

            213 => [
                'state_id'  => '13',
                'name'      => 'Cuiabá',
                'ibge_code' => '5103403',
            ],

            214 => [
                'state_id'  => '13',
                'name'      => 'Curvelândia',
                'ibge_code' => '5103437',
            ],

            215 => [
                'state_id'  => '13',
                'name'      => 'Denise',
                'ibge_code' => '5103452',
            ],

            216 => [
                'state_id'  => '13',
                'name'      => 'Diamantino',
                'ibge_code' => '5103502',
            ],

            217 => [
                'state_id'  => '13',
                'name'      => 'Dom Aquino',
                'ibge_code' => '5103601',
            ],

            218 => [
                'state_id'  => '13',
                'name'      => 'Feliz Natal',
                'ibge_code' => '5103700',
            ],

            219 => [
                'state_id'  => '13',
                'name'      => "Figueirópolis D'oeste",
                'ibge_code' => '5103809',
            ],

            220 => [
                'state_id'  => '13',
                'name'      => 'Gaúcha do Norte',
                'ibge_code' => '5103858',
            ],

            221 => [
                'state_id'  => '13',
                'name'      => 'General Carneiro',
                'ibge_code' => '5103908',
            ],

            222 => [
                'state_id'  => '13',
                'name'      => "Glória D'oeste",
                'ibge_code' => '5103957',
            ],

            223 => [
                'state_id'  => '13',
                'name'      => 'Guarantã do Norte',
                'ibge_code' => '5104104',
            ],

            224 => [
                'state_id'  => '13',
                'name'      => 'Guiratinga',
                'ibge_code' => '5104203',
            ],

            225 => [
                'state_id'  => '13',
                'name'      => 'Indiavaí',
                'ibge_code' => '5104500',
            ],

            226 => [
                'state_id'  => '13',
                'name'      => 'Ipiranga do Norte',
                'ibge_code' => '5104526',
            ],

            227 => [
                'state_id'  => '13',
                'name'      => 'Itanhangá',
                'ibge_code' => '5104542',
            ],

            228 => [
                'state_id'  => '13',
                'name'      => 'Itaúba',
                'ibge_code' => '5104559',
            ],

            229 => [
                'state_id'  => '13',
                'name'      => 'Itiquira',
                'ibge_code' => '5104609',
            ],

            230 => [
                'state_id'  => '13',
                'name'      => 'Jaciara',
                'ibge_code' => '5104807',
            ],

            231 => [
                'state_id'  => '13',
                'name'      => 'Jangada',
                'ibge_code' => '5104906',
            ],

            232 => [
                'state_id'  => '13',
                'name'      => 'Jauru',
                'ibge_code' => '5105002',
            ],

            233 => [
                'state_id'  => '13',
                'name'      => 'Juara',
                'ibge_code' => '5105101',
            ],

            234 => [
                'state_id'  => '13',
                'name'      => 'Juína',
                'ibge_code' => '5105150',
            ],

            235 => [
                'state_id'  => '13',
                'name'      => 'Juruena',
                'ibge_code' => '5105176',
            ],

            236 => [
                'state_id'  => '13',
                'name'      => 'Juscimeira',
                'ibge_code' => '5105200',
            ],

            237 => [
                'state_id'  => '13',
                'name'      => "Lambari D'oeste",
                'ibge_code' => '5105234',
            ],

            238 => [
                'state_id'  => '13',
                'name'      => 'Lucas do Rio Verde',
                'ibge_code' => '5105259',
            ],

            239 => [
                'state_id'  => '13',
                'name'      => 'Luciára',
                'ibge_code' => '5105309',
            ],

            240 => [
                'state_id'  => '13',
                'name'      => 'Vila Bela da Santíssima Trindade',
                'ibge_code' => '5105507',
            ],

            241 => [
                'state_id'  => '13',
                'name'      => 'Marcelândia',
                'ibge_code' => '5105580',
            ],

            242 => [
                'state_id'  => '13',
                'name'      => 'Matupá',
                'ibge_code' => '5105606',
            ],

            243 => [
                'state_id'  => '13',
                'name'      => "Mirassol D'oeste",
                'ibge_code' => '5105622',
            ],

            244 => [
                'state_id'  => '13',
                'name'      => 'Nobres',
                'ibge_code' => '5105903',
            ],

            245 => [
                'state_id'  => '13',
                'name'      => 'Nortelândia',
                'ibge_code' => '5106000',
            ],

            246 => [
                'state_id'  => '13',
                'name'      => 'Nossa Senhora do Livramento',
                'ibge_code' => '5106109',
            ],

            247 => [
                'state_id'  => '13',
                'name'      => 'Nova Bandeirantes',
                'ibge_code' => '5106158',
            ],

            248 => [
                'state_id'  => '13',
                'name'      => 'Nova Nazaré',
                'ibge_code' => '5106174',
            ],

            249 => [
                'state_id'  => '13',
                'name'      => 'Nova Lacerda',
                'ibge_code' => '5106182',
            ],

            250 => [
                'state_id'  => '13',
                'name'      => 'Nova Santa Helena',
                'ibge_code' => '5106190',
            ],

            251 => [
                'state_id'  => '13',
                'name'      => 'Nova Brasilândia',
                'ibge_code' => '5106208',
            ],

            252 => [
                'state_id'  => '13',
                'name'      => 'Nova Canaã do Norte',
                'ibge_code' => '5106216',
            ],

            253 => [
                'state_id'  => '13',
                'name'      => 'Nova Mutum',
                'ibge_code' => '5106224',
            ],

            254 => [
                'state_id'  => '13',
                'name'      => 'Nova Olímpia',
                'ibge_code' => '5106232',
            ],

            255 => [
                'state_id'  => '13',
                'name'      => 'Nova Ubiratã',
                'ibge_code' => '5106240',
            ],

            256 => [
                'state_id'  => '13',
                'name'      => 'Nova Xavantina',
                'ibge_code' => '5106257',
            ],

            257 => [
                'state_id'  => '13',
                'name'      => 'Novo Mundo',
                'ibge_code' => '5106265',
            ],

            258 => [
                'state_id'  => '13',
                'name'      => 'Novo Horizonte do Norte',
                'ibge_code' => '5106273',
            ],

            259 => [
                'state_id'  => '13',
                'name'      => 'Novo São Joaquim',
                'ibge_code' => '5106281',
            ],

            260 => [
                'state_id'  => '13',
                'name'      => 'Paranaíta',
                'ibge_code' => '5106299',
            ],

            261 => [
                'state_id'  => '13',
                'name'      => 'Paranatinga',
                'ibge_code' => '5106307',
            ],

            262 => [
                'state_id'  => '13',
                'name'      => 'Novo Santo Antônio',
                'ibge_code' => '5106315',
            ],

            263 => [
                'state_id'  => '13',
                'name'      => 'Pedra Preta',
                'ibge_code' => '5106372',
            ],

            264 => [
                'state_id'  => '13',
                'name'      => 'Peixoto de Azevedo',
                'ibge_code' => '5106422',
            ],

            265 => [
                'state_id'  => '13',
                'name'      => 'Planalto da Serra',
                'ibge_code' => '5106455',
            ],

            266 => [
                'state_id'  => '13',
                'name'      => 'Poconé',
                'ibge_code' => '5106505',
            ],

            267 => [
                'state_id'  => '13',
                'name'      => 'Pontal do Araguaia',
                'ibge_code' => '5106653',
            ],

            268 => [
                'state_id'  => '13',
                'name'      => 'Ponte Branca',
                'ibge_code' => '5106703',
            ],

            269 => [
                'state_id'  => '13',
                'name'      => 'Pontes e Lacerda',
                'ibge_code' => '5106752',
            ],

            270 => [
                'state_id'  => '13',
                'name'      => 'Porto Alegre do Norte',
                'ibge_code' => '5106778',
            ],

            271 => [
                'state_id'  => '13',
                'name'      => 'Porto dos Gaúchos',
                'ibge_code' => '5106802',
            ],

            272 => [
                'state_id'  => '13',
                'name'      => 'Porto Esperidião',
                'ibge_code' => '5106828',
            ],

            273 => [
                'state_id'  => '13',
                'name'      => 'Porto Estrela',
                'ibge_code' => '5106851',
            ],

            274 => [
                'state_id'  => '13',
                'name'      => 'Poxoréo',
                'ibge_code' => '5107008',
            ],

            275 => [
                'state_id'  => '13',
                'name'      => 'Primavera do Leste',
                'ibge_code' => '5107040',
            ],

            276 => [
                'state_id'  => '13',
                'name'      => 'Querência',
                'ibge_code' => '5107065',
            ],

            277 => [
                'state_id'  => '13',
                'name'      => 'São José dos Quatro Marcos',
                'ibge_code' => '5107107',
            ],

            278 => [
                'state_id'  => '13',
                'name'      => 'Reserva do Cabaçal',
                'ibge_code' => '5107156',
            ],

            279 => [
                'state_id'  => '13',
                'name'      => 'Ribeirão Cascalheira',
                'ibge_code' => '5107180',
            ],

            280 => [
                'state_id'  => '13',
                'name'      => 'Ribeirãozinho',
                'ibge_code' => '5107198',
            ],

            281 => [
                'state_id'  => '13',
                'name'      => 'Rio Branco',
                'ibge_code' => '5107206',
            ],

            282 => [
                'state_id'  => '13',
                'name'      => 'Santa Carmem',
                'ibge_code' => '5107248',
            ],

            283 => [
                'state_id'  => '13',
                'name'      => 'Santo Afonso',
                'ibge_code' => '5107263',
            ],

            284 => [
                'state_id'  => '13',
                'name'      => 'São José do Povo',
                'ibge_code' => '5107297',
            ],

            285 => [
                'state_id'  => '13',
                'name'      => 'São José do Rio Claro',
                'ibge_code' => '5107305',
            ],

            286 => [
                'state_id'  => '13',
                'name'      => 'São José do Xingu',
                'ibge_code' => '5107354',
            ],

            287 => [
                'state_id'  => '13',
                'name'      => 'São Pedro da Cipa',
                'ibge_code' => '5107404',
            ],

            288 => [
                'state_id'  => '13',
                'name'      => 'Rondolândia',
                'ibge_code' => '5107578',
            ],

            289 => [
                'state_id'  => '13',
                'name'      => 'Rondonópolis',
                'ibge_code' => '5107602',
            ],

            290 => [
                'state_id'  => '13',
                'name'      => 'Rosário Oeste',
                'ibge_code' => '5107701',
            ],

            291 => [
                'state_id'  => '13',
                'name'      => 'Santa Cruz do Xingu',
                'ibge_code' => '5107743',
            ],

            292 => [
                'state_id'  => '13',
                'name'      => 'Salto do Céu',
                'ibge_code' => '5107750',
            ],

            293 => [
                'state_id'  => '13',
                'name'      => 'Santa Rita do Trivelato',
                'ibge_code' => '5107768',
            ],

            294 => [
                'state_id'  => '13',
                'name'      => 'Santa Terezinha',
                'ibge_code' => '5107776',
            ],

            295 => [
                'state_id'  => '13',
                'name'      => 'Santo Antônio do Leste',
                'ibge_code' => '5107792',
            ],

            296 => [
                'state_id'  => '13',
                'name'      => 'Santo Antônio do Leverger',
                'ibge_code' => '5107800',
            ],

            297 => [
                'state_id'  => '13',
                'name'      => 'São Félix do Araguaia',
                'ibge_code' => '5107859',
            ],

            298 => [
                'state_id'  => '13',
                'name'      => 'Sapezal',
                'ibge_code' => '5107875',
            ],

            299 => [
                'state_id'  => '13',
                'name'      => 'Serra Nova Dourada',
                'ibge_code' => '5107883',
            ],

            300 => [
                'state_id'  => '13',
                'name'      => 'Sinop',
                'ibge_code' => '5107909',
            ],

            301 => [
                'state_id'  => '13',
                'name'      => 'Sorriso',
                'ibge_code' => '5107925',
            ],

            302 => [
                'state_id'  => '13',
                'name'      => 'Tabaporã',
                'ibge_code' => '5107941',
            ],

            303 => [
                'state_id'  => '13',
                'name'      => 'Tangará da Serra',
                'ibge_code' => '5107958',
            ],

            304 => [
                'state_id'  => '13',
                'name'      => 'Tapurah',
                'ibge_code' => '5108006',
            ],

            305 => [
                'state_id'  => '13',
                'name'      => 'Terra Nova do Norte',
                'ibge_code' => '5108055',
            ],

            306 => [
                'state_id'  => '13',
                'name'      => 'Tesouro',
                'ibge_code' => '5108105',
            ],

            307 => [
                'state_id'  => '13',
                'name'      => 'Torixoréu',
                'ibge_code' => '5108204',
            ],

            308 => [
                'state_id'  => '13',
                'name'      => 'União do Sul',
                'ibge_code' => '5108303',
            ],

            309 => [
                'state_id'  => '13',
                'name'      => 'Vale de São Domingos',
                'ibge_code' => '5108352',
            ],

            310 => [
                'state_id'  => '13',
                'name'      => 'Várzea Grande',
                'ibge_code' => '5108402',
            ],

            311 => [
                'state_id'  => '13',
                'name'      => 'Vera',
                'ibge_code' => '5108501',
            ],

            312 => [
                'state_id'  => '13',
                'name'      => 'Vila Rica',
                'ibge_code' => '5108600',
            ],

            313 => [
                'state_id'  => '13',
                'name'      => 'Nova Guarita',
                'ibge_code' => '5108808',
            ],

            314 => [
                'state_id'  => '13',
                'name'      => 'Nova Marilândia',
                'ibge_code' => '5108857',
            ],

            315 => [
                'state_id'  => '13',
                'name'      => 'Nova Maringá',
                'ibge_code' => '5108907',
            ],

            316 => [
                'state_id'  => '13',
                'name'      => 'Nova Monte Verde',
                'ibge_code' => '5108956',
            ],

            317 => [
                'state_id'  => '9',
                'name'      => 'Abadia de Goiás',
                'ibge_code' => '5200050',
            ],

            318 => [
                'state_id'  => '9',
                'name'      => 'Abadiânia',
                'ibge_code' => '5200100',
            ],

            319 => [
                'state_id'  => '9',
                'name'      => 'Acreúna',
                'ibge_code' => '5200134',
            ],

            320 => [
                'state_id'  => '9',
                'name'      => 'Adelândia',
                'ibge_code' => '5200159',
            ],

            321 => [
                'state_id'  => '9',
                'name'      => 'Água Fria de Goiás',
                'ibge_code' => '5200175',
            ],

            322 => [
                'state_id'  => '9',
                'name'      => 'Água Limpa',
                'ibge_code' => '5200209',
            ],

            323 => [
                'state_id'  => '9',
                'name'      => 'Águas Lindas de Goiás',
                'ibge_code' => '5200258',
            ],

            324 => [
                'state_id'  => '9',
                'name'      => 'Alexânia',
                'ibge_code' => '5200308',
            ],

            325 => [
                'state_id'  => '9',
                'name'      => 'Aloândia',
                'ibge_code' => '5200506',
            ],

            326 => [
                'state_id'  => '9',
                'name'      => 'Alto Horizonte',
                'ibge_code' => '5200555',
            ],

            327 => [
                'state_id'  => '9',
                'name'      => 'Alto Paraíso de Goiás',
                'ibge_code' => '5200605',
            ],

            328 => [
                'state_id'  => '9',
                'name'      => 'Alvorada do Norte',
                'ibge_code' => '5200803',
            ],

            329 => [
                'state_id'  => '9',
                'name'      => 'Amaralina',
                'ibge_code' => '5200829',
            ],

            330 => [
                'state_id'  => '9',
                'name'      => 'Americano do Brasil',
                'ibge_code' => '5200852',
            ],

            331 => [
                'state_id'  => '9',
                'name'      => 'Amorinópolis',
                'ibge_code' => '5200902',
            ],

            332 => [
                'state_id'  => '9',
                'name'      => 'Anápolis',
                'ibge_code' => '5201108',
            ],

            333 => [
                'state_id'  => '9',
                'name'      => 'Anhanguera',
                'ibge_code' => '5201207',
            ],

            334 => [
                'state_id'  => '9',
                'name'      => 'Anicuns',
                'ibge_code' => '5201306',
            ],

            335 => [
                'state_id'  => '9',
                'name'      => 'Aparecida de Goiânia',
                'ibge_code' => '5201405',
            ],

            336 => [
                'state_id'  => '9',
                'name'      => 'Aparecida do Rio Doce',
                'ibge_code' => '5201454',
            ],

            337 => [
                'state_id'  => '9',
                'name'      => 'Aporé',
                'ibge_code' => '5201504',
            ],

            338 => [
                'state_id'  => '9',
                'name'      => 'Araçu',
                'ibge_code' => '5201603',
            ],

            339 => [
                'state_id'  => '9',
                'name'      => 'Aragarças',
                'ibge_code' => '5201702',
            ],

            340 => [
                'state_id'  => '9',
                'name'      => 'Aragoiânia',
                'ibge_code' => '5201801',
            ],

            341 => [
                'state_id'  => '9',
                'name'      => 'Araguapaz',
                'ibge_code' => '5202155',
            ],

            342 => [
                'state_id'  => '9',
                'name'      => 'Arenópolis',
                'ibge_code' => '5202353',
            ],

            343 => [
                'state_id'  => '9',
                'name'      => 'Aruanã',
                'ibge_code' => '5202502',
            ],

            344 => [
                'state_id'  => '9',
                'name'      => 'Aurilândia',
                'ibge_code' => '5202601',
            ],

            345 => [
                'state_id'  => '9',
                'name'      => 'Avelinópolis',
                'ibge_code' => '5202809',
            ],

            346 => [
                'state_id'  => '9',
                'name'      => 'Baliza',
                'ibge_code' => '5203104',
            ],

            347 => [
                'state_id'  => '9',
                'name'      => 'Barro Alto',
                'ibge_code' => '5203203',
            ],

            348 => [
                'state_id'  => '9',
                'name'      => 'Bela Vista de Goiás',
                'ibge_code' => '5203302',
            ],

            349 => [
                'state_id'  => '9',
                'name'      => 'Bom Jardim de Goiás',
                'ibge_code' => '5203401',
            ],

            350 => [
                'state_id'  => '9',
                'name'      => 'Bom Jesus de Goiás',
                'ibge_code' => '5203500',
            ],

            351 => [
                'state_id'  => '9',
                'name'      => 'Bonfinópolis',
                'ibge_code' => '5203559',
            ],

            352 => [
                'state_id'  => '9',
                'name'      => 'Bonópolis',
                'ibge_code' => '5203575',
            ],

            353 => [
                'state_id'  => '9',
                'name'      => 'Brazabrantes',
                'ibge_code' => '5203609',
            ],

            354 => [
                'state_id'  => '9',
                'name'      => 'Britânia',
                'ibge_code' => '5203807',
            ],

            355 => [
                'state_id'  => '9',
                'name'      => 'Buriti Alegre',
                'ibge_code' => '5203906',
            ],

            356 => [
                'state_id'  => '9',
                'name'      => 'Buriti de Goiás',
                'ibge_code' => '5203939',
            ],

            357 => [
                'state_id'  => '9',
                'name'      => 'Buritinópolis',
                'ibge_code' => '5203962',
            ],

            358 => [
                'state_id'  => '9',
                'name'      => 'Cabeceiras',
                'ibge_code' => '5204003',
            ],

            359 => [
                'state_id'  => '9',
                'name'      => 'Cachoeira Alta',
                'ibge_code' => '5204102',
            ],

            360 => [
                'state_id'  => '9',
                'name'      => 'Cachoeira de Goiás',
                'ibge_code' => '5204201',
            ],

            361 => [
                'state_id'  => '9',
                'name'      => 'Cachoeira Dourada',
                'ibge_code' => '5204250',
            ],

            362 => [
                'state_id'  => '9',
                'name'      => 'Caçu',
                'ibge_code' => '5204300',
            ],

            363 => [
                'state_id'  => '9',
                'name'      => 'Caiapônia',
                'ibge_code' => '5204409',
            ],

            364 => [
                'state_id'  => '9',
                'name'      => 'Caldas Novas',
                'ibge_code' => '5204508',
            ],

            365 => [
                'state_id'  => '9',
                'name'      => 'Caldazinha',
                'ibge_code' => '5204557',
            ],

            366 => [
                'state_id'  => '9',
                'name'      => 'Campestre de Goiás',
                'ibge_code' => '5204607',
            ],

            367 => [
                'state_id'  => '9',
                'name'      => 'Campinaçu',
                'ibge_code' => '5204656',
            ],

            368 => [
                'state_id'  => '9',
                'name'      => 'Campinorte',
                'ibge_code' => '5204706',
            ],

            369 => [
                'state_id'  => '9',
                'name'      => 'Campo Alegre de Goiás',
                'ibge_code' => '5204805',
            ],

            370 => [
                'state_id'  => '9',
                'name'      => 'Campo Limpo de Goiás',
                'ibge_code' => '5204854',
            ],

            371 => [
                'state_id'  => '9',
                'name'      => 'Campos Belos',
                'ibge_code' => '5204904',
            ],

            372 => [
                'state_id'  => '9',
                'name'      => 'Campos Verdes',
                'ibge_code' => '5204953',
            ],

            373 => [
                'state_id'  => '9',
                'name'      => 'Carmo do Rio Verde',
                'ibge_code' => '5205000',
            ],

            374 => [
                'state_id'  => '9',
                'name'      => 'Castelândia',
                'ibge_code' => '5205059',
            ],

            375 => [
                'state_id'  => '9',
                'name'      => 'Catalão',
                'ibge_code' => '5205109',
            ],

            376 => [
                'state_id'  => '9',
                'name'      => 'Caturaí',
                'ibge_code' => '5205208',
            ],

            377 => [
                'state_id'  => '9',
                'name'      => 'Cavalcante',
                'ibge_code' => '5205307',
            ],

            378 => [
                'state_id'  => '9',
                'name'      => 'Ceres',
                'ibge_code' => '5205406',
            ],

            379 => [
                'state_id'  => '9',
                'name'      => 'Cezarina',
                'ibge_code' => '5205455',
            ],

            380 => [
                'state_id'  => '9',
                'name'      => 'Chapadão do Céu',
                'ibge_code' => '5205471',
            ],

            381 => [
                'state_id'  => '9',
                'name'      => 'Cidade Ocidental',
                'ibge_code' => '5205497',
            ],

            382 => [
                'state_id'  => '9',
                'name'      => 'Cocalzinho de Goiás',
                'ibge_code' => '5205513',
            ],

            383 => [
                'state_id'  => '9',
                'name'      => 'Colinas do Sul',
                'ibge_code' => '5205521',
            ],

            384 => [
                'state_id'  => '9',
                'name'      => 'Córrego do Ouro',
                'ibge_code' => '5205703',
            ],

            385 => [
                'state_id'  => '9',
                'name'      => 'Corumbá de Goiás',
                'ibge_code' => '5205802',
            ],

            386 => [
                'state_id'  => '9',
                'name'      => 'Corumbaíba',
                'ibge_code' => '5205901',
            ],

            387 => [
                'state_id'  => '9',
                'name'      => 'Cristalina',
                'ibge_code' => '5206206',
            ],

            388 => [
                'state_id'  => '9',
                'name'      => 'Cristianópolis',
                'ibge_code' => '5206305',
            ],

            389 => [
                'state_id'  => '9',
                'name'      => 'Crixás',
                'ibge_code' => '5206404',
            ],

            390 => [
                'state_id'  => '9',
                'name'      => 'Cromínia',
                'ibge_code' => '5206503',
            ],

            391 => [
                'state_id'  => '9',
                'name'      => 'Cumari',
                'ibge_code' => '5206602',
            ],

            392 => [
                'state_id'  => '9',
                'name'      => 'Damianópolis',
                'ibge_code' => '5206701',
            ],

            393 => [
                'state_id'  => '9',
                'name'      => 'Damolândia',
                'ibge_code' => '5206800',
            ],

            394 => [
                'state_id'  => '9',
                'name'      => 'Davinópolis',
                'ibge_code' => '5206909',
            ],

            395 => [
                'state_id'  => '9',
                'name'      => 'Diorama',
                'ibge_code' => '5207105',
            ],

            396 => [
                'state_id'  => '9',
                'name'      => 'Doverlândia',
                'ibge_code' => '5207253',
            ],

            397 => [
                'state_id'  => '9',
                'name'      => 'Edealina',
                'ibge_code' => '5207352',
            ],

            398 => [
                'state_id'  => '9',
                'name'      => 'Edéia',
                'ibge_code' => '5207402',
            ],

            399 => [
                'state_id'  => '9',
                'name'      => 'Estrela do Norte',
                'ibge_code' => '5207501',
            ],

            400 => [
                'state_id'  => '9',
                'name'      => 'Faina',
                'ibge_code' => '5207535',
            ],

            401 => [
                'state_id'  => '9',
                'name'      => 'Fazenda Nova',
                'ibge_code' => '5207600',
            ],

            402 => [
                'state_id'  => '9',
                'name'      => 'Firminópolis',
                'ibge_code' => '5207808',
            ],

            403 => [
                'state_id'  => '9',
                'name'      => 'Flores de Goiás',
                'ibge_code' => '5207907',
            ],

            404 => [
                'state_id'  => '9',
                'name'      => 'Formosa',
                'ibge_code' => '5208004',
            ],

            405 => [
                'state_id'  => '9',
                'name'      => 'Formoso',
                'ibge_code' => '5208103',
            ],

            406 => [
                'state_id'  => '9',
                'name'      => 'Gameleira de Goiás',
                'ibge_code' => '5208152',
            ],

            407 => [
                'state_id'  => '9',
                'name'      => 'Divinópolis de Goiás',
                'ibge_code' => '5208301',
            ],

            408 => [
                'state_id'  => '9',
                'name'      => 'Goianápolis',
                'ibge_code' => '5208400',
            ],

            409 => [
                'state_id'  => '9',
                'name'      => 'Goiandira',
                'ibge_code' => '5208509',
            ],

            410 => [
                'state_id'  => '9',
                'name'      => 'Goianésia',
                'ibge_code' => '5208608',
            ],

            411 => [
                'state_id'  => '9',
                'name'      => 'Goiânia',
                'ibge_code' => '5208707',
            ],

            412 => [
                'state_id'  => '9',
                'name'      => 'Goianira',
                'ibge_code' => '5208806',
            ],

            413 => [
                'state_id'  => '9',
                'name'      => 'Goiás',
                'ibge_code' => '5208905',
            ],

            414 => [
                'state_id'  => '9',
                'name'      => 'Goiatuba',
                'ibge_code' => '5209101',
            ],

            415 => [
                'state_id'  => '9',
                'name'      => 'Gouvelândia',
                'ibge_code' => '5209150',
            ],

            416 => [
                'state_id'  => '9',
                'name'      => 'Guapó',
                'ibge_code' => '5209200',
            ],

            417 => [
                'state_id'  => '9',
                'name'      => 'Guaraíta',
                'ibge_code' => '5209291',
            ],

            418 => [
                'state_id'  => '9',
                'name'      => 'Guarani de Goiás',
                'ibge_code' => '5209408',
            ],

            419 => [
                'state_id'  => '9',
                'name'      => 'Guarinos',
                'ibge_code' => '5209457',
            ],

            420 => [
                'state_id'  => '9',
                'name'      => 'Heitoraí',
                'ibge_code' => '5209606',
            ],

            421 => [
                'state_id'  => '9',
                'name'      => 'Hidrolândia',
                'ibge_code' => '5209705',
            ],

            422 => [
                'state_id'  => '9',
                'name'      => 'Hidrolina',
                'ibge_code' => '5209804',
            ],

            423 => [
                'state_id'  => '9',
                'name'      => 'Iaciara',
                'ibge_code' => '5209903',
            ],

            424 => [
                'state_id'  => '9',
                'name'      => 'Inaciolândia',
                'ibge_code' => '5209937',
            ],

            425 => [
                'state_id'  => '9',
                'name'      => 'Indiara',
                'ibge_code' => '5209952',
            ],

            426 => [
                'state_id'  => '9',
                'name'      => 'Inhumas',
                'ibge_code' => '5210000',
            ],

            427 => [
                'state_id'  => '9',
                'name'      => 'Ipameri',
                'ibge_code' => '5210109',
            ],

            428 => [
                'state_id'  => '9',
                'name'      => 'Ipiranga de Goiás',
                'ibge_code' => '5210158',
            ],

            429 => [
                'state_id'  => '9',
                'name'      => 'Iporá',
                'ibge_code' => '5210208',
            ],

            430 => [
                'state_id'  => '9',
                'name'      => 'Israelândia',
                'ibge_code' => '5210307',
            ],

            431 => [
                'state_id'  => '9',
                'name'      => 'Itaberaí',
                'ibge_code' => '5210406',
            ],

            432 => [
                'state_id'  => '9',
                'name'      => 'Itaguari',
                'ibge_code' => '5210562',
            ],

            433 => [
                'state_id'  => '9',
                'name'      => 'Itaguaru',
                'ibge_code' => '5210604',
            ],

            434 => [
                'state_id'  => '9',
                'name'      => 'Itajá',
                'ibge_code' => '5210802',
            ],

            435 => [
                'state_id'  => '9',
                'name'      => 'Itapaci',
                'ibge_code' => '5210901',
            ],

            436 => [
                'state_id'  => '9',
                'name'      => 'Itapirapuã',
                'ibge_code' => '5211008',
            ],

            437 => [
                'state_id'  => '9',
                'name'      => 'Itapuranga',
                'ibge_code' => '5211206',
            ],

            438 => [
                'state_id'  => '9',
                'name'      => 'Itarumã',
                'ibge_code' => '5211305',
            ],

            439 => [
                'state_id'  => '9',
                'name'      => 'Itauçu',
                'ibge_code' => '5211404',
            ],

            440 => [
                'state_id'  => '9',
                'name'      => 'Itumbiara',
                'ibge_code' => '5211503',
            ],

            441 => [
                'state_id'  => '9',
                'name'      => 'Ivolândia',
                'ibge_code' => '5211602',
            ],

            442 => [
                'state_id'  => '9',
                'name'      => 'Jandaia',
                'ibge_code' => '5211701',
            ],

            443 => [
                'state_id'  => '9',
                'name'      => 'Jaraguá',
                'ibge_code' => '5211800',
            ],

            444 => [
                'state_id'  => '9',
                'name'      => 'Jataí',
                'ibge_code' => '5211909',
            ],

            445 => [
                'state_id'  => '9',
                'name'      => 'Jaupaci',
                'ibge_code' => '5212006',
            ],

            446 => [
                'state_id'  => '9',
                'name'      => 'Jesúpolis',
                'ibge_code' => '5212055',
            ],

            447 => [
                'state_id'  => '9',
                'name'      => 'Joviânia',
                'ibge_code' => '5212105',
            ],

            448 => [
                'state_id'  => '9',
                'name'      => 'Jussara',
                'ibge_code' => '5212204',
            ],

            449 => [
                'state_id'  => '9',
                'name'      => 'Lagoa Santa',
                'ibge_code' => '5212253',
            ],

            450 => [
                'state_id'  => '9',
                'name'      => 'Leopoldo de Bulhões',
                'ibge_code' => '5212303',
            ],

            451 => [
                'state_id'  => '9',
                'name'      => 'Luziânia',
                'ibge_code' => '5212501',
            ],

            452 => [
                'state_id'  => '9',
                'name'      => 'Mairipotaba',
                'ibge_code' => '5212600',
            ],

            453 => [
                'state_id'  => '9',
                'name'      => 'Mambaí',
                'ibge_code' => '5212709',
            ],

            454 => [
                'state_id'  => '9',
                'name'      => 'Mara Rosa',
                'ibge_code' => '5212808',
            ],

            455 => [
                'state_id'  => '9',
                'name'      => 'Marzagão',
                'ibge_code' => '5212907',
            ],

            456 => [
                'state_id'  => '9',
                'name'      => 'Matrinchã',
                'ibge_code' => '5212956',
            ],

            457 => [
                'state_id'  => '9',
                'name'      => 'Maurilândia',
                'ibge_code' => '5213004',
            ],

            458 => [
                'state_id'  => '9',
                'name'      => 'Mimoso de Goiás',
                'ibge_code' => '5213053',
            ],

            459 => [
                'state_id'  => '9',
                'name'      => 'Minaçu',
                'ibge_code' => '5213087',
            ],

            460 => [
                'state_id'  => '9',
                'name'      => 'Mineiros',
                'ibge_code' => '5213103',
            ],

            461 => [
                'state_id'  => '9',
                'name'      => 'Moiporá',
                'ibge_code' => '5213400',
            ],

            462 => [
                'state_id'  => '9',
                'name'      => 'Monte Alegre de Goiás',
                'ibge_code' => '5213509',
            ],

            463 => [
                'state_id'  => '9',
                'name'      => 'Montes Claros de Goiás',
                'ibge_code' => '5213707',
            ],

            464 => [
                'state_id'  => '9',
                'name'      => 'Montividiu',
                'ibge_code' => '5213756',
            ],

            465 => [
                'state_id'  => '9',
                'name'      => 'Montividiu do Norte',
                'ibge_code' => '5213772',
            ],

            466 => [
                'state_id'  => '9',
                'name'      => 'Morrinhos',
                'ibge_code' => '5213806',
            ],

            467 => [
                'state_id'  => '9',
                'name'      => 'Morro Agudo de Goiás',
                'ibge_code' => '5213855',
            ],

            468 => [
                'state_id'  => '9',
                'name'      => 'Mossâmedes',
                'ibge_code' => '5213905',
            ],

            469 => [
                'state_id'  => '9',
                'name'      => 'Mozarlândia',
                'ibge_code' => '5214002',
            ],

            470 => [
                'state_id'  => '9',
                'name'      => 'Mundo Novo',
                'ibge_code' => '5214051',
            ],

            471 => [
                'state_id'  => '9',
                'name'      => 'Mutunópolis',
                'ibge_code' => '5214101',
            ],

            472 => [
                'state_id'  => '9',
                'name'      => 'Nazário',
                'ibge_code' => '5214408',
            ],

            473 => [
                'state_id'  => '9',
                'name'      => 'Nerópolis',
                'ibge_code' => '5214507',
            ],

            474 => [
                'state_id'  => '9',
                'name'      => 'Niquelândia',
                'ibge_code' => '5214606',
            ],

            475 => [
                'state_id'  => '9',
                'name'      => 'Nova América',
                'ibge_code' => '5214705',
            ],

            476 => [
                'state_id'  => '9',
                'name'      => 'Nova Aurora',
                'ibge_code' => '5214804',
            ],

            477 => [
                'state_id'  => '9',
                'name'      => 'Nova Crixás',
                'ibge_code' => '5214838',
            ],

            478 => [
                'state_id'  => '9',
                'name'      => 'Nova Glória',
                'ibge_code' => '5214861',
            ],

            479 => [
                'state_id'  => '9',
                'name'      => 'Nova Iguaçu de Goiás',
                'ibge_code' => '5214879',
            ],

            480 => [
                'state_id'  => '9',
                'name'      => 'Nova Roma',
                'ibge_code' => '5214903',
            ],

            481 => [
                'state_id'  => '9',
                'name'      => 'Nova Veneza',
                'ibge_code' => '5215009',
            ],

            482 => [
                'state_id'  => '9',
                'name'      => 'Novo Brasil',
                'ibge_code' => '5215207',
            ],

            483 => [
                'state_id'  => '9',
                'name'      => 'Novo Gama',
                'ibge_code' => '5215231',
            ],

            484 => [
                'state_id'  => '9',
                'name'      => 'Novo Planalto',
                'ibge_code' => '5215256',
            ],

            485 => [
                'state_id'  => '9',
                'name'      => 'Orizona',
                'ibge_code' => '5215306',
            ],

            486 => [
                'state_id'  => '9',
                'name'      => 'Ouro Verde de Goiás',
                'ibge_code' => '5215405',
            ],

            487 => [
                'state_id'  => '9',
                'name'      => 'Ouvidor',
                'ibge_code' => '5215504',
            ],

            488 => [
                'state_id'  => '9',
                'name'      => 'Padre Bernardo',
                'ibge_code' => '5215603',
            ],

            489 => [
                'state_id'  => '9',
                'name'      => 'Palestina de Goiás',
                'ibge_code' => '5215652',
            ],

            490 => [
                'state_id'  => '9',
                'name'      => 'Palmeiras de Goiás',
                'ibge_code' => '5215702',
            ],

            491 => [
                'state_id'  => '9',
                'name'      => 'Palmelo',
                'ibge_code' => '5215801',
            ],

            492 => [
                'state_id'  => '9',
                'name'      => 'Palminópolis',
                'ibge_code' => '5215900',
            ],

            493 => [
                'state_id'  => '9',
                'name'      => 'Panamá',
                'ibge_code' => '5216007',
            ],

            494 => [
                'state_id'  => '9',
                'name'      => 'Paranaiguara',
                'ibge_code' => '5216304',
            ],

            495 => [
                'state_id'  => '9',
                'name'      => 'Paraúna',
                'ibge_code' => '5216403',
            ],

            496 => [
                'state_id'  => '9',
                'name'      => 'Perolândia',
                'ibge_code' => '5216452',
            ],

            497 => [
                'state_id'  => '9',
                'name'      => 'Petrolina de Goiás',
                'ibge_code' => '5216809',
            ],

            498 => [
                'state_id'  => '9',
                'name'      => 'Pilar de Goiás',
                'ibge_code' => '5216908',
            ],

            499 => [
                'state_id'  => '9',
                'name'      => 'Piracanjuba',
                'ibge_code' => '5217104',
            ],

        ]);
        DB::table('cities')->insert([
            0 => [
                'state_id'  => '9',
                'name'      => 'Piranhas',
                'ibge_code' => '5217203',
            ],

            1 => [
                'state_id'  => '9',
                'name'      => 'Pirenópolis',
                'ibge_code' => '5217302',
            ],

            2 => [
                'state_id'  => '9',
                'name'      => 'Pires do Rio',
                'ibge_code' => '5217401',
            ],

            3 => [
                'state_id'  => '9',
                'name'      => 'Planaltina',
                'ibge_code' => '5217609',
            ],

            4 => [
                'state_id'  => '9',
                'name'      => 'Pontalina',
                'ibge_code' => '5217708',
            ],

            5 => [
                'state_id'  => '9',
                'name'      => 'Porangatu',
                'ibge_code' => '5218003',
            ],

            6 => [
                'state_id'  => '9',
                'name'      => 'Porteirão',
                'ibge_code' => '5218052',
            ],

            7 => [
                'state_id'  => '9',
                'name'      => 'Portelândia',
                'ibge_code' => '5218102',
            ],

            8 => [
                'state_id'  => '9',
                'name'      => 'Posse',
                'ibge_code' => '5218300',
            ],

            9 => [
                'state_id'  => '9',
                'name'      => 'Professor Jamil',
                'ibge_code' => '5218391',
            ],

            10 => [
                'state_id'  => '9',
                'name'      => 'Quirinópolis',
                'ibge_code' => '5218508',
            ],

            11 => [
                'state_id'  => '9',
                'name'      => 'Rialma',
                'ibge_code' => '5218607',
            ],

            12 => [
                'state_id'  => '9',
                'name'      => 'Rianápolis',
                'ibge_code' => '5218706',
            ],

            13 => [
                'state_id'  => '9',
                'name'      => 'Rio Quente',
                'ibge_code' => '5218789',
            ],

            14 => [
                'state_id'  => '9',
                'name'      => 'Rio Verde',
                'ibge_code' => '5218805',
            ],

            15 => [
                'state_id'  => '9',
                'name'      => 'Rubiataba',
                'ibge_code' => '5218904',
            ],

            16 => [
                'state_id'  => '9',
                'name'      => 'Sanclerlândia',
                'ibge_code' => '5219001',
            ],

            17 => [
                'state_id'  => '9',
                'name'      => 'Santa Bárbara de Goiás',
                'ibge_code' => '5219100',
            ],

            18 => [
                'state_id'  => '9',
                'name'      => 'Santa Cruz de Goiás',
                'ibge_code' => '5219209',
            ],

            19 => [
                'state_id'  => '9',
                'name'      => 'Santa Fé de Goiás',
                'ibge_code' => '5219258',
            ],

            20 => [
                'state_id'  => '9',
                'name'      => 'Santa Helena de Goiás',
                'ibge_code' => '5219308',
            ],

            21 => [
                'state_id'  => '9',
                'name'      => 'Santa Isabel',
                'ibge_code' => '5219357',
            ],

            22 => [
                'state_id'  => '9',
                'name'      => 'Santa Rita do Araguaia',
                'ibge_code' => '5219407',
            ],

            23 => [
                'state_id'  => '9',
                'name'      => 'Santa Rita do Novo Destino',
                'ibge_code' => '5219456',
            ],

            24 => [
                'state_id'  => '9',
                'name'      => 'Santa Rosa de Goiás',
                'ibge_code' => '5219506',
            ],

            25 => [
                'state_id'  => '9',
                'name'      => 'Santa Tereza de Goiás',
                'ibge_code' => '5219605',
            ],

            26 => [
                'state_id'  => '9',
                'name'      => 'Santa Terezinha de Goiás',
                'ibge_code' => '5219704',
            ],

            27 => [
                'state_id'  => '9',
                'name'      => 'Santo Antônio da Barra',
                'ibge_code' => '5219712',
            ],

            28 => [
                'state_id'  => '9',
                'name'      => 'Santo Antônio de Goiás',
                'ibge_code' => '5219738',
            ],

            29 => [
                'state_id'  => '9',
                'name'      => 'Santo Antônio do Descoberto',
                'ibge_code' => '5219753',
            ],

            30 => [
                'state_id'  => '9',
                'name'      => 'São Domingos',
                'ibge_code' => '5219803',
            ],

            31 => [
                'state_id'  => '9',
                'name'      => 'São Francisco de Goiás',
                'ibge_code' => '5219902',
            ],

            32 => [
                'state_id'  => '9',
                'name'      => "São João D'aliança",
                'ibge_code' => '5220009',
            ],

            33 => [
                'state_id'  => '9',
                'name'      => 'São João da Paraúna',
                'ibge_code' => '5220058',
            ],

            34 => [
                'state_id'  => '9',
                'name'      => 'São Luís de Montes Belos',
                'ibge_code' => '5220108',
            ],

            35 => [
                'state_id'  => '9',
                'name'      => 'São Luíz do Norte',
                'ibge_code' => '5220157',
            ],

            36 => [
                'state_id'  => '9',
                'name'      => 'São Miguel do Araguaia',
                'ibge_code' => '5220207',
            ],

            37 => [
                'state_id'  => '9',
                'name'      => 'São Miguel do Passa Quatro',
                'ibge_code' => '5220264',
            ],

            38 => [
                'state_id'  => '9',
                'name'      => 'São Patrício',
                'ibge_code' => '5220280',
            ],

            39 => [
                'state_id'  => '9',
                'name'      => 'São Simão',
                'ibge_code' => '5220405',
            ],

            40 => [
                'state_id'  => '9',
                'name'      => 'Senador Canedo',
                'ibge_code' => '5220454',
            ],

            41 => [
                'state_id'  => '9',
                'name'      => 'Serranópolis',
                'ibge_code' => '5220504',
            ],

            42 => [
                'state_id'  => '9',
                'name'      => 'Silvânia',
                'ibge_code' => '5220603',
            ],

            43 => [
                'state_id'  => '9',
                'name'      => 'Simolândia',
                'ibge_code' => '5220686',
            ],

            44 => [
                'state_id'  => '9',
                'name'      => "Sítio D'abadia",
                'ibge_code' => '5220702',
            ],

            45 => [
                'state_id'  => '9',
                'name'      => 'Taquaral de Goiás',
                'ibge_code' => '5221007',
            ],

            46 => [
                'state_id'  => '9',
                'name'      => 'Teresina de Goiás',
                'ibge_code' => '5221080',
            ],

            47 => [
                'state_id'  => '9',
                'name'      => 'Terezópolis de Goiás',
                'ibge_code' => '5221197',
            ],

            48 => [
                'state_id'  => '9',
                'name'      => 'Três Ranchos',
                'ibge_code' => '5221304',
            ],

            49 => [
                'state_id'  => '9',
                'name'      => 'Trindade',
                'ibge_code' => '5221403',
            ],

            50 => [
                'state_id'  => '9',
                'name'      => 'Trombas',
                'ibge_code' => '5221452',
            ],

            51 => [
                'state_id'  => '9',
                'name'      => 'Turvânia',
                'ibge_code' => '5221502',
            ],

            52 => [
                'state_id'  => '9',
                'name'      => 'Turvelândia',
                'ibge_code' => '5221551',
            ],

            53 => [
                'state_id'  => '9',
                'name'      => 'Uirapuru',
                'ibge_code' => '5221577',
            ],

            54 => [
                'state_id'  => '9',
                'name'      => 'Uruaçu',
                'ibge_code' => '5221601',
            ],

            55 => [
                'state_id'  => '9',
                'name'      => 'Uruana',
                'ibge_code' => '5221700',
            ],

            56 => [
                'state_id'  => '9',
                'name'      => 'Urutaí',
                'ibge_code' => '5221809',
            ],

            57 => [
                'state_id'  => '9',
                'name'      => 'Valparaíso de Goiás',
                'ibge_code' => '5221858',
            ],

            58 => [
                'state_id'  => '9',
                'name'      => 'Varjão',
                'ibge_code' => '5221908',
            ],

            59 => [
                'state_id'  => '9',
                'name'      => 'Vianópolis',
                'ibge_code' => '5222005',
            ],

            60 => [
                'state_id'  => '9',
                'name'      => 'Vicentinópolis',
                'ibge_code' => '5222054',
            ],

            61 => [
                'state_id'  => '9',
                'name'      => 'Vila Boa',
                'ibge_code' => '5222203',
            ],

            62 => [
                'state_id'  => '9',
                'name'      => 'Vila Propício',
                'ibge_code' => '5222302',
            ],

            63 => [
                'state_id'  => '7',
                'name'      => 'Brasília',
                'ibge_code' => '5300108',
            ],

            64 => [
                'state_id'  => '14',
                'name'      => 'Mojuí dos Campos',
                'ibge_code' => '1504752',
            ],

            65 => [
                'state_id'  => '17',
                'name'      => 'Nazaria',
                'ibge_code' => '2206720',
            ],

            66 => [
                'state_id'  => '24',
                'name'      => 'Pescaria Brava',
                'ibge_code' => '4212650',
            ],

            67 => [
                'state_id'  => '24',
                'name'      => 'Balneário Rincão',
                'ibge_code' => '4220000',
            ],

            68 => [
                'state_id'  => '23',
                'name'      => 'Pinto Bandeira',
                'ibge_code' => '4314548',
            ],

            69 => [
                'state_id'  => '12',
                'name'      => 'Paraíso das Aguás',
                'ibge_code' => '5006275',
            ],
        ]);

    }
}
