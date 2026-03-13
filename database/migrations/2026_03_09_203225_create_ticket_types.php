<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('ticket_types', function (Blueprint $table) {
      $table->id();

      $table->boolean('is_active')->default(true);

      $table->timestamps();

      $table->foreignId('created_by_id')->nullable()->constrained('users');
      $table->foreignId('updated_by_id')->nullable()->constrained('users');

      $table->foreignId('event_id')->constrained('events');

      $table->string('name', 30);
      $table->text('description')->nullable();

      $table->unique(['event_id', 'name']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('ticket_types');
  }
};