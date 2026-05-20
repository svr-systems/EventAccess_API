<?php

namespace Database\Seeders;

use App\Models\PaymentForm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentFormsSeeder extends Seeder
{
    public function run(): void
    {
    $items = [
      [
        'name' => 'Efectivo',
        'code' => '01'
      ],
      [
        'name' => 'Cheque nominativo',
        'code' => '02'
      ],
      [
        'name' => 'Transferencia electrónica de fondos',
        'code' => '03'
      ],
      [
        'name' => 'Tarjeta de crédito',
        'code' => '04'
      ],
      [
        'name' => 'Monedero electrónico',
        'code' => '05'
      ],
      [
        'name' => 'Dinero electrónico',
        'code' => '06'
      ],
      [
        'name' => 'Vales de despensa',
        'code' => '08'
      ],
      [
        'name' => 'Dación en pago',
        'code' => '12'
      ],
      [
        'name' => 'Pago por subrogación',
        'code' => '13'
      ],
      [
        'name' => 'Pago por consignación',
        'code' => '14'
      ],
      [
        'name' => 'Condonación',
        'code' => '15'
      ],
      [
        'name' => 'Compensación',
        'code' => '17'
      ],
      [
        'name' => 'Novación',
        'code' => '23'
      ],
      [
        'name' => 'Confusión',
        'code' => '24'
      ],
      [
        'name' => 'Remisión de deuda',
        'code' => '25'
      ],
      [
        'name' => 'Prescripción o caducidad',
        'code' => '26'
      ],
      [
        'name' => 'A satisfacción del acreedor',
        'code' => '27'
      ],
      [
        'name' => 'Tarjeta de débito',
        'code' => '28'
      ],
      [
        'name' => 'Tarjeta de servicios',
        'code' => '29'
      ],
      [
        'name' => 'Aplicación de anticipos',
        'code' => '30'
      ],
      [
        'name' => 'Intermediario pagos',
        'code' => '31'
      ],
      [
        'name' => 'Por definir',
        'code' => '99'
      ]
    ];

    PaymentForm::insert($items);
    }
}
