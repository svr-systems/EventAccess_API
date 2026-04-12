<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('buyer_offer_areas', function (Blueprint $table) {
      $table->id();
      $table->auditFields();
      $table->foreignId('buyer_id')->constrained('buyers');
      $table->foreignId('event_area_id')->constrained('event_areas');
      $table->text('description');

      $table->unique(['buyer_id', 'event_area_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('buyer_offer_areas');
  }
};