<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('supplier_users', function (Blueprint $table) {
      $table->id();
      $table->foreignId('supplier_id')->constrained('suppliers');
      $table->foreignId('user_id')->constrained('users');
      
      $table->unique(['supplier_id', 'user_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('supplier_users');
  }
};