<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('event_stand_configs', function (Blueprint $table) {

      $table->id();
      $table->boolean('is_active')->default(true);
      $table->timestamps();

      $table->foreignId('created_by_id')->constrained('users');
      $table->foreignId('updated_by_id')->constrained('users');

      $table->foreignId('stand_type_id')->constrained('stand_types');

      $table->integer('capacity')->default(0);
      $table->integer('reserved')->default(0);

      $table->decimal('price', 11, 2)->default(0);

      $table->decimal('size_length', 5, 2)->nullable();
      $table->decimal('size_width', 5, 2)->nullable();
      $table->decimal('size_height', 5, 2)->nullable();

      $table->boolean('has_electricity')->default(false);
      $table->boolean('has_water')->default(false);
      $table->boolean('has_internet')->default(false);

    });
  }

  public function down(): void {
    Schema::dropIfExists('event_stand_configs');
  }
};