<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('cfdi_usages', function (Blueprint $table) {
      $table->id();
      $table->boolean('is_active')->default(true);
      $table->string('name', 85);
      $table->string('code', 4)->unique();
    });
  }

  public function down(): void {
    Schema::dropIfExists('cfdi_usages');
  }
};
