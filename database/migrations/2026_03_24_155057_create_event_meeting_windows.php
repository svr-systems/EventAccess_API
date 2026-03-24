<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('event_meeting_windows', function (Blueprint $table) {
      $table->id();

      $table->auditFields();

      $table->foreignId('event_id')->constrained('events');
      $table->foreignId('presentation_date_id')->constrained('presentation_dates');

      $table->time('start_time');
      $table->time('end_time');

      // 🔥 Índices útiles
      $table->index(['event_id', 'presentation_date_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('event_meeting_windows');
  }
};