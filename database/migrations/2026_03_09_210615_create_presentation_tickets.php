<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('presentation_tickets', function (Blueprint $table) {

      $table->id();

      $table->boolean('is_active')->default(true);

      $table->timestamps();

      $table->foreignId('created_by_id')->nullable()->constrained('users');
      $table->foreignId('updated_by_id')->nullable()->constrained('users');

      $table->foreignId('presentation_date_id')->constrained('presentation_dates');
      $table->foreignId('ticket_type_id')->constrained('ticket_types');

      $table->decimal('price', 11, 2);

      $table->integer('capacity')->nullable();
      $table->integer('sold')->default(0);

      $table->unique(['presentation_date_id', 'ticket_type_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('presentation_tickets');
  }
};