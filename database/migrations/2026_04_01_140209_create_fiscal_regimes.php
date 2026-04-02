<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('fiscal_regimes', function (Blueprint $table) {
      $table->id();
      $table->boolean('is_active')->default(true);
      $table->string('name', 90);
      $table->string('code', 3)->unique();
      $table->boolean('is_individual')->nullable();
    });
  }

  public function down(): void {
    Schema::dropIfExists('fiscal_regimes');
  }
};
