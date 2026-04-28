<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::dropIfExists('stand_types');
  }

  public function down(): void {
    Schema::create('stand_types', function (Blueprint $table) {
      $table->id();
      $table->boolean('is_active')->default(true);
      $table->timestamps();

      $table->foreignId('created_by_id')
        ->nullable()
        ->constrained('users');

      $table->foreignId('updated_by_id')
        ->nullable()
        ->constrained('users');

      $table->foreignId('event_id')
        ->constrained('events');

      $table->string('name', 60);
    });
  }
};