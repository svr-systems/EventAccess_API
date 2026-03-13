<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('sales', function (Blueprint $table) {

      $table->id();

      $table->boolean('is_active')->default(true);

      $table->timestamps();

      $table->foreignId('created_by_id')->nullable()->constrained('users');
      $table->foreignId('updated_by_id')->nullable()->constrained('users');

      $table->foreignId('user_id')->constrained('users');

      $table->decimal('amount', 11, 2)->nullable();
    });
  }

  public function down(): void {
    Schema::dropIfExists('sales');
  }
};