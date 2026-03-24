<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('buyer_user_schedules', function (Blueprint $table) {
      $table->id();

      $table->auditFields();

      $table->foreignId('buyer_id')->constrained('buyers');
      $table->foreignId('event_id')->constrained('events');
      $table->foreignId('buyer_user_id')->constrained('buyer_users');
      $table->foreignId('presentation_date_id')->constrained('presentation_dates');

      $table->time('start_time');
      $table->time('end_time');

      // 🔥 Índices para validaciones
      $table->index(['buyer_user_id', 'presentation_date_id']);
      $table->index(['event_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('buyer_user_schedules');
  }
};