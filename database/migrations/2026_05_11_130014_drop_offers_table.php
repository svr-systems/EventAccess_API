<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::dropIfExists('offers');
  }

  public function down(): void {
    Schema::create('offers', function (Blueprint $table) {
      $table->id();

      $table->boolean('is_active')->default(true);

      $table->timestamps();

      $table->foreignId('created_by_id')
        ->constrained('users');

      $table->foreignId('updated_by_id')
        ->constrained('users');

      $table->foreignId('event_stand_config_id')
        ->constrained('event_stand_configs');

      $table->foreignId('supplier_id')
        ->constrained('suppliers');

      $table->foreignId('event_id')
        ->constrained('events');

      $table->text('description');

      $table->unique(
        ['event_id', 'supplier_id', 'event_stand_config_id'],
        'offers_event_supplier_stand_config_unique'
      );
    });
  }
};