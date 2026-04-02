<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('municipalities', function (Blueprint $table) {
      $table->id();
      $table->boolean('is_active')->default(1);
      $table->string('name', 80);
      $table->foreignId('state_id')->constrained('states');
    });
  }
  
  public function down(): void {
    Schema::dropIfExists('municipalities');
  }
};
