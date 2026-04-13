<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('buyer_offer_areas', function (Blueprint $table) {
      $table->foreignId('buyer_user_id')
        ->nullable()
        ->default(1)
        ->after('buyer_id')
        ->constrained('buyer_users');
    });
  }

  public function down(): void {
    Schema::table('buyer_offer_areas', function (Blueprint $table) {
      $table->dropForeign(['buyer_user_id']);
      $table->dropColumn('buyer_user_id');
    });
  }
};