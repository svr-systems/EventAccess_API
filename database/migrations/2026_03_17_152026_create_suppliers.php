<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('suppliers', function (Blueprint $table) {
      $table->id();
      $table->auditFields();
      $table->string('name', 60);
    });
  }

  public function down(): void {
    Schema::dropIfExists('suppliers');
  }
};
