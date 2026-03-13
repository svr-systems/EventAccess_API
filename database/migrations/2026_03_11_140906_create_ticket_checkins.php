<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('ticket_checkins', function (Blueprint $table) {
      $table->id();

      $table->boolean('is_active')->default(true);

      $table->timestamps();

      $table->foreignId('created_by_id')->constrained('users');
      $table->foreignId('updated_by_id')->constrained('users');

      $table->foreignId('sale_item_id')->constrained('sale_items');

      $table->index('sale_item_id');
    });
  }

  public function down(): void {
    Schema::dropIfExists('ticket_checkins');
  }
};