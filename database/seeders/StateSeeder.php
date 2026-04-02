<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder {
  public function run() {
    $items = [
      [
        'name' => 'AGUASCALIENTES',
      ],
      [
        'name' => 'BAJA CALIFORNIA',
      ],
      [
        'name' => 'BAJA CALIFORNIA SUR',
      ],
      [
        'name' => 'CAMPECHE',
      ],
      [
        'name' => 'COAHUILA DE ZARAGOZA',
      ],
      [
        'name' => 'COLIMA',
      ],
      [
        'name' => 'CHIAPAS',
      ],
      [
        'name' => 'CHIHUAHUA',
      ],
      [
        'name' => 'CIUDAD DE MEXICO',
      ],
      [
        'name' => 'DURANGO',
      ],
      [
        'name' => 'GUANAJUATO',
      ],
      [
        'name' => 'GUERRERO',
      ],
      [
        'name' => 'HIDALGO',
      ],
      [
        'name' => 'JALISCO',
      ],
      [
        'name' => 'MEXICO',
      ],
      [
        'name' => 'MICHOACAN DE OCAMPO',
      ],
      [
        'name' => 'MORELOS',
      ],
      [
        'name' => 'NAYARIT',
      ],
      [
        'name' => 'NUEVO LEON',
      ],
      [
        'name' => 'OAXACA',
      ],
      [
        'name' => 'PUEBLA',
      ],
      [
        'name' => 'QUERETARO',
      ],
      [
        'name' => 'QUINTANA ROO',
      ],
      [
        'name' => 'SAN LUIS POTOSI',
      ],
      [
        'name' => 'SINALOA',
      ],
      [
        'name' => 'SONORA',
      ],
      [
        'name' => 'TABASCO',
      ],
      [
        'name' => 'TAMAULIPAS',
      ],
      [
        'name' => 'TLAXCALA',
      ],
      [
        'name' => 'VERACRUZ DE IGNACIO DE LA LLAVE',
      ],
      [
        'name' => 'YUCATAN',
      ],
      [
        'name' => 'ZACATECAS',
      ],
      [
        'name' => 'EXTRANJERO',
      ]
    ];

    State::insert($items);
  }
}
