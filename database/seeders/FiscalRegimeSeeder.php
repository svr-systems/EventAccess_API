<?php

namespace Database\Seeders;

use App\Models\FiscalRegime;
use Illuminate\Database\Seeder;

class FiscalRegimeSeeder extends Seeder {
  public function run() {
    $items = [
      [
        'name' => 'GENERAL DE LEY PERSONAS MORALES',
        'code' => '601',
        'is_individual' => 0,
      ],
      [
        'name' => 'PERSONAS MORALES CON FINES NO LUCRATIVOS',
        'code' => '603',
        'is_individual' => 0,
      ],
      [
        'name' => 'SUELDOS Y SALARIOS E INGRESOS ASIMILADOS A SALARIOS',
        'code' => '605',
        'is_individual' => 1,
      ],
      [
        'name' => 'ARRENDAMIENTO',
        'code' => '606',
        'is_individual' => 1,
      ],
      [
        'name' => 'RÉGIMEN DE ENAJENACIÓN O ADQUISICIÓN DE BIENES',
        'code' => '607',
        'is_individual' => 1,
      ],
      [
        'name' => 'DEMÁS INGRESOS',
        'code' => '608',
        'is_individual' => 1,
      ],
      [
        'name' => 'CONSOLIDACIÓN',
        'code' => '609',
        'is_individual' => 0,
      ],
      [
        'name' => 'RESIDENTES EN EL EXTRANJERO SIN ESTABLECIMIENTO PERMANENTE EN MÉXICO',
        'code' => '610',
        'is_individual' => 1,
      ],
      [
        'name' => 'INGRESOS POR DIVIDENDOS (SOCIOS Y ACCIONISTAS)',
        'code' => '611',
        'is_individual' => 1,
      ],
      [
        'name' => 'PERSONAS FÍSICAS CON ACTIVIDADES EMPRESARIALES Y PROFESIONALES',
        'code' => '612',
        'is_individual' => 1,
      ],
      [
        'name' => 'INGRESOS POR INTERESES',
        'code' => '614',
        'is_individual' => 1,
      ],
      [
        'name' => 'RÉGIMEN DE LOS INGRESOS POR OBTENCIÓN DE PREMIOS',
        'code' => '615',
        'is_individual' => 1,
      ],
      [
        'name' => 'SIN OBLIGACIONES FISCALES',
        'code' => '616',
        'is_individual' => 1,
      ],
      [
        'name' => 'SOCIEDADES COOPERATIVAS DE PRODUCCIÓN QUE OPTAN POR DIFERIR SUS INGRESOS',
        'code' => '620',
        'is_individual' => 0,
      ],
      [
        'name' => 'INCORPORACIÓN FISCAL',
        'code' => '621',
        'is_individual' => 1,
      ],
      [
        'name' => 'ACTIVIDADES AGRÍCOLAS, GANADERAS, SILVÍCOLAS Y PESQUERAS',
        'code' => '622',
        'is_individual' => 1,
      ],
      [
        'name' => 'OPCIONAL PARA GRUPOS DE SOCIEDADES',
        'code' => '623',
        'is_individual' => 0,
      ],
      [
        'name' => 'COORDINADOS',
        'code' => '624',
        'is_individual' => 0,
      ],
      [
        'name' => 'RÉGIMEN DE LAS ACTIVIDADES EMPRESARIALES CON INGRESOS A TRAVÉS DE PLATAFORMAS TECNOLÓGICAS',
        'code' => '625',
        'is_individual' => 1,
      ],
      [
        'name' => 'RÉGIMEN SIMPLIFICADO DE CONFIANZA',
        'code' => '626',
        'is_individual' => null,
      ],
      [
        'name' => 'HIDROCARBUROS',
        'code' => '628',
        'is_individual' => 0,
      ],
      [
        'name' => 'DE LOS REGÍMENES FISCALES PREFERENTES Y DE LAS EMPRESAS MULTINACIONALES',
        'code' => '629',
        'is_individual' => 1,
      ],
      [
        'name' => 'ENAJENACIÓN DE ACCIONES EN BOLSA DE VALORES',
        'code' => '630',
        'is_individual' => 1,
      ],
    ];

    FiscalRegime::insert($items);
  }
}
