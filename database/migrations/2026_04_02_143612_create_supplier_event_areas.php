<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('supplier_event_areas', function (Blueprint $table) {
      $table->id();
      $table->boolean('is_active')->default(true);
      $table->foreignId('supplier_id')->constrained('suppliers');
      $table->foreignId('event_area_id')->constrained('event_areas');

      $table->unique(['supplier_id', 'event_area_id']);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('supplier_event_areas');
  }
};