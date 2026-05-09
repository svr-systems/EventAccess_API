<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('buyers', function (Blueprint $table) {
      $table->boolean('is_reviewed')
        ->nullable()
        ->after('zip');

      $table->foreignId('reviewed_by_id')
        ->nullable()
        ->after('is_reviewed')
        ->constrained('users');

      $table->timestamp('reviewed_at')
        ->nullable()
        ->after('reviewed_by_id');
    });
  }

  public function down(): void {
    Schema::table('buyers', function (Blueprint $table) {
      $table->dropForeign(['reviewed_by_id']);

      $table->dropColumn([
        'is_reviewed',
        'reviewed_by_id',
        'reviewed_at',
      ]);
    });
  }
};
