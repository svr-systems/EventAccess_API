<?php

namespace Database\Seeders;

use App\Models\SaleItemStatus;
use Illuminate\Database\Seeder;

class SaleItemStatusSeeder extends Seeder {
  public function run() {
    $items = [
      [
        'name' => 'COMPRADO'
      ],
      [
        'name' => 'CANCELADO'
      ],
      [
        'name' => 'REEMBOLZADO'
      ],
    ];

    SaleItemStatus::insert($items);
  }
}
