<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('presentation_dates', function (Blueprint $table) {

      $table->id();

      $table->boolean('is_active')->default(true);

      $table->timestamps();

      $table->foreignId('created_by_id')->nullable()->constrained('users');
      $table->foreignId('updated_by_id')->nullable()->constrained('users');

      $table->foreignId('event_id')->constrained('events');

      $table->date('date');

      $table->time('reception_time');
      $table->time('start_time');
      $table->time('end_time');

    });
  }

  public function down(): void {
    Schema::dropIfExists('presentation_dates');
  }
};