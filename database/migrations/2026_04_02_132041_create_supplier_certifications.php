<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('supplier_certifications', function (Blueprint $table) {
      $table->id();

      $table->boolean('is_active')->default(true);

      $table->foreignId('supplier_id')->constrained('suppliers');
      $table->foreignId('certification_id')->constrained('certifications');

      $table->unique(['supplier_id', 'certification_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('supplier_certifications');
  }
};