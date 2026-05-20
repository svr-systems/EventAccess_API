<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('buyer_offer_areas', function (Blueprint $table) {
      $table->dropForeign(['buyer_id']);
      $table->dropForeign(['buyer_user_id']);
      $table->dropForeign(['event_area_id']);

      $table->dropUnique('uq_b_bu_ea');

      $table->unique([
        'buyer_id',
        'buyer_user_id',
        'event_area_id',
        'is_active',
      ], 'uq_b_bu_ea');

      $table->foreign('buyer_id')->references('id')->on('buyers');
      $table->foreign('buyer_user_id')->references('id')->on('buyer_users');
      $table->foreign('event_area_id')->references('id')->on('event_areas');
    });
  }

  public function down(): void {
    Schema::table('buyer_offer_areas', function (Blueprint $table) {
      $table->dropForeign(['buyer_id']);
      $table->dropForeign(['buyer_user_id']);
      $table->dropForeign(['event_area_id']);

      $table->dropUnique('uq_b_bu_ea');

      $table->unique([
        'buyer_id',
        'buyer_user_id',
        'event_area_id',
      ], 'uq_b_bu_ea');

      $table->foreign('buyer_id')->references('id')->on('buyers');
      $table->foreign('buyer_user_id')->references('id')->on('buyer_users');
      $table->foreign('event_area_id')->references('id')->on('event_areas');
    });
  }
};