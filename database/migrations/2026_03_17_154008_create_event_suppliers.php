<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('event_suppliers', function (Blueprint $table) {
      $table->id();

      $table->auditFields();

      $table->foreignId('event_id')->constrained('events');
      $table->foreignId('supplier_id')->constrained('suppliers');

      $table->unique(['event_id', 'supplier_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('event_suppliers');
  }
};