<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->boolean('is_active')->default(true);
      $table->timestamps();
      $table->foreignId('created_by_id')->nullable()->constrained('users');
      $table->foreignId('updated_by_id')->nullable()->constrained('users');
      $table->timestamp('email_verified_at')->nullable();
      $table->foreignId('role_id')->constrained('roles');
      $table->string('name', 50);
      $table->string('paternal_surname', 25);
      $table->string('maternal_surname', 25)->nullable();
      $table->string('email', 65)->unique();
      $table->string('phone', 10)->unique()->nullable();
      $table->string('password', 72)->nullable();
      $table->string('password_recover_at')->nullable();
      $table->rememberToken();
      $table->string('avatar_path', 50)->nullable();
    });

    Schema::create('password_reset_tokens', function (Blueprint $table) {
      $table->string('email')->primary();
      $table->string('token');
      $table->timestamp('created_at')->nullable();
    });

    Schema::create('sessions', function (Blueprint $table) {
      $table->string('id')->primary();
      $table->foreignId('user_id')->nullable()->index();
      $table->string('ip_address', 45)->nullable();
      $table->text('user_agent')->nullable();
      $table->longText('payload');
      $table->integer('last_activity')->index();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('users');
    Schema::dropIfExists('password_reset_tokens');
    Schema::dropIfExists('sessions');
  }
};
