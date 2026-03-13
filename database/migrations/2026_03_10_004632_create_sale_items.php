<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('sale_items', function (Blueprint $table) {

      $table->id();

      $table->boolean('is_active')->default(true);

      $table->timestamps();

      $table->foreignId('created_by_id')->nullable()->constrained('users');
      $table->foreignId('updated_by_id')->nullable()->constrained('users');

      $table->foreignId('sale_id')->constrained('sales');

      $table->foreignId('presentation_ticket_id')->constrained('presentation_tickets');

      $table->foreignId('sale_item_status_id')->constrained('sale_item_statuses');

      $table->decimal('purchase_price', 11, 2);

      $table->string('ticket_code', 12)->unique()->nullable();
    });
  }

  public function down(): void {
    Schema::dropIfExists('sale_items');
  }
};
