<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('stand_requests', function (Blueprint $table) {
      $table->id();

      $table->auditFields();

      $table->foreignId('event_id')->constrained('events');
      $table->foreignId('event_stand_config_id')->constrained('event_stand_configs');
      $table->foreignId('offer_id')->constrained('offers');
      $table->foreignId('supplier_id')->constrained('suppliers');

      $table->text('notes')->nullable();

      $table->boolean('is_approved')->nullable();

      $table->index(['event_id', 'event_stand_config_id']);
      $table->index(['supplier_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('stand_requests');
  }
};