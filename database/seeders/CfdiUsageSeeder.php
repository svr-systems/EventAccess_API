<?php

namespace Database\Seeders;

use App\Models\CfdiUsage;
use Illuminate\Database\Seeder;

class CfdiUsageSeeder extends Seeder {
  public function run() {
    $items = [
      [
        'name' => "Adquisición de mercancías.",
        'code' => 'G01'
      ],
      [
        'name' => "Devoluciones, descuentos o bonificaciones.",
        'code' => 'G02'
      ],
      [
        'name' => "Gastos en general.",
        'code' => 'G03'
      ],
      [
        'name' => "Construcciones.",
        'code' => 'I01'
      ],
      [
        'name' => "Mobiliario y equipo de oficina por inversiones.",
        'code' => 'I02'
      ],
      [
        'name' => "Equipo de transporte.",
        'code' => 'I03'
      ],
      [
        'name' => "Equipo de computo y accesorios.",
        'code' => 'I04'
      ],
      [
        'name' => "Dados, troqueles, moldes, matrices y herramental.",
        'code' => 'I05'
      ],
      [
        'name' => "Comunicaciones telefónicas.",
        'code' => 'I06'
      ],
      [
        'name' => "Comunicaciones satelitales.",
        'code' => 'I07'
      ],
      [
        'name' => "Otra maquinaria y equipo.",
        'code' => 'I08'
      ],
      [
        'name' => "Honorarios médicos, dentales y gastos hospitalarios.",
        'code' => 'D01'
      ],
      [
        'name' => "Gastos médicos por incapacidad o discapacidad.",
        'code' => 'D02'
      ],
      [
        'name' => "Gastos funerales.",
        'code' => 'D03'
      ],
      [
        'name' => "Donativos.",
        'code' => 'D04'
      ],
      [
        'name' => "Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación).",
        'code' => 'D05'
      ],
      [
        'name' => "Aportaciones voluntarias al SAR.",
        'code' => 'D06'
      ],
      [
        'name' => "Primas por seguros de gastos médicos.",
        'code' => 'D07'
      ],
      [
        'name' => "Gastos de transportación escolar obligatoria.",
        'code' => 'D08'
      ],
      [
        'name' => "Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones.",
        'code' => 'D09'
      ],
      [
        'name' => "Pagos por servicios educativos (colegiaturas).",
        'code' => 'D10'
      ],
      [
        'name' => "Sin efectos fiscales.",
        'code' => 'S01'
      ],
      [
        'name' => "Pagos.",
        'code' => 'CP01'
      ],
      [
        'name' => "Nómina.",
        'code' => 'CN01'
      ],
    ];

    CfdiUsage::insert($items);
  }
}
