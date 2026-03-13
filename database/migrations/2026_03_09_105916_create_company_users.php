<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up(): void {

    Schema::create('company_users', function (Blueprint $table) {
      $table->id();
      $table->boolean('is_active')->default(true);
      $table->foreignId('company_id')->constrained('companies');
      $table->foreignId('user_id')->constrained('users');

    });
  }

  public function down(): void {
    Schema::dropIfExists('company_users');
  }
};