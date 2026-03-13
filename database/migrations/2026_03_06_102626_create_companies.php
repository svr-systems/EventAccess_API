<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('companies', function (Blueprint $table) {
      $table->id();
      $table->boolean('is_active')->default(true);
      $table->timestamps();
      $table->foreignId('created_by_id')->nullable()->constrained('users');
      $table->foreignId('updated_by_id')->nullable()->constrained('users');
      $table->string('name', 60);
      $table->string('slug', 30)->unique()->nullable()->default(null);
      $table->string('logo_path', 50)->nullable()->default(null);
      $table->text('description')->nullable()->default(null);
    });
  }

  public function down(): void {
    Schema::dropIfExists('companies');
  }
};
