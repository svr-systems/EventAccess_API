<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('bank_types', function (Blueprint $table) {
      $table->id();
      $table->boolean('is_active')->default(true);
      $table->string('name', 40)->unique();
      $table->string('code', 5)->unique();
    });
  }

  public function down(): void {
    Schema::dropIfExists('bank_types');
  }
};
