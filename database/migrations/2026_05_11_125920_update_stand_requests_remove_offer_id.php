<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('stand_requests', function (Blueprint $table) {

      // Foreign
      $table->dropForeign('stand_requests_offer_id_foreign');

      // Columna
      $table->dropColumn('offer_id');

      // Nueva columna
      $table->text('justification')
        ->after('event_stand_config_id');
    });
  }

  public function down(): void {
    Schema::table('stand_requests', function (Blueprint $table) {

      $table->foreignId('offer_id')
        ->after('event_stand_config_id')
        ->constrained('offers');

      $table->text('justification')->nullable()->change();
      $table->dropColumn('justification');
    });
  }
};
