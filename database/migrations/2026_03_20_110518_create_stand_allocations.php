<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('stand_allocations', function (Blueprint $table) {
      $table->id();

      $table->auditFields();

      $table->foreignId('stand_request_id')->constrained('stand_requests');

      $table->foreignId('event_id')->constrained('events');
      $table->foreignId('supplier_id')->constrained('suppliers');
      $table->foreignId('event_stand_config_id')->constrained('event_stand_configs');

      $table->boolean('is_paid')->default(false);

      // 🔥 Evita duplicar asignación por request
      $table->unique(['stand_request_id']);

      // 🔥 Índices útiles
      $table->index(['event_id', 'event_stand_config_id']);
      $table->index(['supplier_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('stand_allocations');
  }
};