<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('event_areas', function (Blueprint $table) {
      $table->id();
      $table->auditFields();
      $table->foreignId('event_id')->constrained('events');
      $table->string('name', 100);

      $table->unique(['event_id', 'name']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('event_areas');
  }
};