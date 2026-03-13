<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
  public function run() {
    $now = Carbon::now()->format('Y-m-d H:i:s');

    $items = [
      [
        'created_at' => $now,
        'updated_at' => $now,
        'created_by_id' => null,
        'updated_by_id' => null,
        'email_verified_at' => $now,
        'role_id' => 1,
        'name' => 'ADMIN',
        'paternal_surname' => 'SISTEMA',
        'email' => 'admin@svr.com',
        'password' => bcrypt('Svr_1029*'),
      ],
    ];

    User::insert($items);
  }
}
