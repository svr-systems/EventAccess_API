<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('attendee_users', function (Blueprint $table) {
      $table->id();

      $table->foreignId('user_id')
        ->constrained('users');

      $table->string('fiscal_code', 13)
        ->nullable();

      $table->string('fiscal_name', 150)
        ->nullable();

      $table->string('fiscal_zip', 10)
        ->nullable();

      $table->foreignId('fiscal_regime_id')
        ->nullable()
        ->constrained('fiscal_regimes');

      $table->foreignId('cfdi_usage_id')
        ->nullable()
        ->constrained('cfdi_usages');
    });
  }

  public function down(): void {
    Schema::dropIfExists('attendee_users');
  }
};