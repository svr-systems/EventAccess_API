<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('buyer_users', function (Blueprint $table) {
      $table->id();
      $table->foreignId('buyer_id')->constrained('buyers');
      $table->foreignId('user_id')->constrained('users');

      // 🔥 Evita duplicados
      $table->unique(['buyer_id', 'user_id']);

      // 🔥 Índices útiles
      $table->index(['buyer_id']);
      $table->index(['user_id']);
    });
  }

  public function down(): void {
    Schema::dropIfExists('buyer_users');
  }
};