<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('offers', function (Blueprint $table) {
      // $table->dropForeign(['stand_type_id']);
      // $table->dropForeign(['offers_event_id']);
      // $table->dropForeign(['supplier_id']);

      // $table->dropUnique('offers_event_id_supplier_id_stand_type_id_unique');

      $table->foreignId('event_stand_config_id')
        ->after('updated_by_id')
        ->constrained('event_stand_configs');

      $table->dropColumn('stand_type_id');
    });
  }

  public function down(): void {
    Schema::table('offers', function (Blueprint $table) {
      $table->foreignId('stand_type_id')
        ->after('updated_by_id')
        ->constrained('stand_types');

      $table->dropForeign(['event_stand_config_id']);
      $table->dropColumn('event_stand_config_id');
    });
  }
};