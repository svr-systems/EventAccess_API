<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('event_buyers', function (Blueprint $table) {
      $table->id();

      $table->auditFields();

      $table->foreignId('event_id')->constrained('events');
      $table->foreignId('buyer_id')->constrained('buyers');

      // 🔥 Evita duplicados
      $table->unique(['event_id', 'buyer_id']);

      // 🔥 Índices útiles
      $table->index(['event_id']);
      $table->index(['buyer_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('event_buyers');
  }
};