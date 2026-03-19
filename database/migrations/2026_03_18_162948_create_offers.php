<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('offers', function (Blueprint $table) {
      $table->id();

      $table->auditFields();

      $table->foreignId('stand_type_id')->constrained('stand_types');
      $table->foreignId('supplier_id')->constrained('suppliers');

      $table->foreignId('event_id')->constrained('events');
      $table->text('description');

      $table->unique(['event_id', 'supplier_id', 'stand_type_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('offers');
  }
};