<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('meetings', function (Blueprint $table) {
      $table->id();
      $table->auditFields();

      $table->foreignId('event_id')->constrained('events');
      $table->foreignId('presentation_date_id')->constrained('presentation_dates');
      $table->foreignId('event_area_id')->constrained('event_areas');

      $table->foreignId('buyer_id')->constrained('buyers');
      $table->foreignId('buyer_user_id')->constrained('buyer_users');

      $table->foreignId('supplier_id')->constrained('suppliers');
      $table->foreignId('supplier_user_id')->constrained('supplier_users');

      $table->time('start_time');
      $table->time('end_time');

      $table->boolean('is_confirmed')->nullable();
    });
  }

  public function down(): void {
    Schema::dropIfExists('meetings');
  }
};