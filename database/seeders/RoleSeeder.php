<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {
  public function run() {
    $items = [
      [
        'name' => 'ADMINISTRADOR'
      ],
      [
        'name' => 'USUARIO'
      ],
      [
        'name' => 'COMPAÑIA'
      ],
      [
        'name' => 'STAFF'
      ],
      [
        'name' => 'ASISTENTE'
      ],
      [
        'name' => 'PROVEEDOR'
      ],
      [
        'name' => 'PROVEEDOR STAFF'
      ],
      [
        'name' => 'STCOMPRADORAFF'
      ],
    ];

    Role::insert($items);
  }
}
