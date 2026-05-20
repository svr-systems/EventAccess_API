<?php

namespace Database\Seeders;

use App\Models\BankType;
use Illuminate\Database\Seeder;

class BankTypeSeeder extends Seeder {
  public function run() {
    $items = [
      [
        'name' => 'BBVA MÉXICO',
        'code' => '40012'
      ],
      [
        'name' => 'ABC CAPITAL',
        'code' => '40138'
      ],
      [
        'name' => 'AMERICAN EXPRESS BANK (MÉXICO)',
        'code' => "null1"
      ],
      [
        'name' => 'BANCA AFIRME',
        'code' => '40062'
      ],
      [
        'name' => 'BANCA MIFEL',
        'code' => '40042'
      ],
      [
        'name' => 'BANCO ACTINVER',
        'code' => '40133'
      ],
      [
        'name' => 'BANCO AUTOFIN MÉXICO',
        'code' => '40128'
      ],
      [
        'name' => 'BANCO AZTECA',
        'code' => '40127'
      ],
      [
        'name' => 'BANCO BANCREA',
        'code' => '40152'
      ],
      [
        'name' => 'BANCO BASE',
        'code' => '40145'
      ],
      [
        'name' => 'BANCO COVALTO',
        'code' => '40154'
      ],
      [
        'name' => 'BANCO COMPARTAMOS',
        'code' => '40130'
      ],
      [
        'name' => 'BANCO CREDIT SUISSE (MÉXICO)',
        'code' => '40126'
      ],
      [
        'name' => 'BANCO DE INVERSIÓN AFIRME',
        'code' => "null2"
      ],
      [
        'name' => 'BANCO DEL BAJÍO',
        'code' => '40030'
      ],
      [
        'name' => 'BANCO FORJADORES',
        'code' => "null3"
      ],
      [
        'name' => 'BANCO INBURSA',
        'code' => '40036'
      ],
      [
        'name' => 'BANCO INMOBILIARIO MEXICANO',
        'code' => '40150'
      ],
      [
        'name' => 'BANCO INVEX',
        'code' => '40059'
      ],
      [
        'name' => 'BANCO JP MORGAN',
        'code' => '40110'
      ],
      [
        'name' => 'BANCO KEB HANA MÉXICO',
        'code' => "null4"
      ],
      [
        'name' => 'BANCO MONEX',
        'code' => '40112'
      ],
      [
        'name' => 'BANCO MULTIVA',
        'code' => '40132'
      ],
      [
        'name' => 'BANCO PAGATODO',
        'code' => '40148'
      ],
      [
        'name' => 'BANCO REGIONAL DE MONTERREY',
        'code' => "null5"
      ],
      [
        'name' => 'BANCO S3 CACEIS MÉXICO',
        'code' => "null6"
      ],
      [
        'name' => 'BANCO SABADELL',
        'code' => '40156'
      ],
      [
        'name' => 'BANCO SANTANDER',
        'code' => '40014'
      ],
      [
        'name' => 'BANCO SHINHAN DE MÉXICO',
        'code' => '40157'
      ],
      [
        'name' => 'BANCO VE POR MÁS',
        'code' => '40113'
      ],
      [
        'name' => 'BANCOPPEL',
        'code' => '40137'
      ],
      [
        'name' => 'BANK OF AMERICA MEXICO',
        'code' => '40106'
      ],
      [
        'name' => 'BANK OF CHINA MEXICO',
        'code' => '40159'
      ],
      [
        'name' => 'BANKAOOL',
        'code' => '40147'
      ],
      [
        'name' => 'BANORTE',
        'code' => '40072'
      ],
      [
        'name' => 'BANSÍ',
        'code' => '40060'
      ],
      [
        'name' => 'BARCLAYS BANK MÉXICO',
        'code' => '40129'
      ],
      [
        'name' => 'BNP PARIBAS',
        'code' => "null"
      ],
      [
        'name' => 'CITIBANAMEX',
        'code' => '40002'
      ],
      [
        'name' => 'CIBANCO',
        'code' => '40143'
      ],
      [
        'name' => 'CONSUBANCO',
        'code' => '40140'
      ],
      [
        'name' => 'DEUTSCHE BANK MÉXICO',
        'code' => "null7"
      ],
      [
        'name' => 'FUNDACIÓN DONDÉ BANCO',
        'code' => '40151'
      ],
      [
        'name' => 'HSBC MÉXICO',
        'code' => '40021'
      ],
      [
        'name' => 'INDUSTRIAL AND COMMERCIAL BANK OF CHINA',
        'code' => "null8"
      ],
      [
        'name' => 'INTERCAM BANCO',
        'code' => '40136'
      ],
      [
        'name' => 'MIZUHO BANK',
        'code' => '40158'
      ],
      [
        'name' => 'MUFG BANK MEXICO',
        'code' => '40108'
      ],
      [
        'name' => 'SCOTIABANK',
        'code' => '40044'
      ],
      [
        'name' => 'BANREGIO',
        'code' => '40058'
      ],
      [
        'name' => 'BANJERCITO',
        'code' => '37019'
      ]
    ];

    BankType::insert($items);
  }
}
