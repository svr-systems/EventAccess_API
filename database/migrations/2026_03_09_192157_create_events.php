<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('events', function (Blueprint $table) {

      $table->id();

      $table->boolean('is_active')->default(true);

      $table->timestamps();

      $table->foreignId('created_by_id')->nullable()->constrained('users');
      $table->foreignId('updated_by_id')->nullable()->constrained('users');

      $table->foreignId('company_id')->constrained('companies');

      $table->string('name', 255);
      $table->text('description')->nullable();

      $table->string('place_name', 60);
      $table->string('address', 60);

      $table->decimal('latitude', 10, 8)->nullable()->default(null);
      $table->decimal('longitude', 10, 8)->nullable()->default(null);

      $table->string('logo_path', 50)->nullable();
      $table->string('flyer_path', 50)->nullable();

      $table->boolean('is_public');

      $table->dateTime('sale_start_at');
      $table->dateTime('sale_end_at');

    });
  }

  public function down(): void {
    Schema::dropIfExists('events');
  }
};
