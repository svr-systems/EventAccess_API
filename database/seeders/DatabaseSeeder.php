<?php

namespace Database\Seeders;

use App\Models\ExpirationDat;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
  public function run(): void {
    // $this->call(RoleSeeder::class);
    // $this->call(UserSeeder::class);
    $this->call(SaleItemStatusSeeder::class);
  }
}
