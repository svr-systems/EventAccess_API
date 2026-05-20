<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('sales', function (Blueprint $table) {
      $table->decimal('commission_percentage', 5, 2)
        ->default(0);
    });
  }

  public function down(): void {
    Schema::table('sales', function (Blueprint $table) {
      $table->dropColumn([
        'commission_percentage'
      ]);
    });
  }
};
