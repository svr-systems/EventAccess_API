<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('event_stand_configs', function (Blueprint $table) {
      $table->dropForeign(['stand_type_id']);

      $table->foreignId('event_id')
        ->after('updated_by_id')
        ->constrained('events');

      $table->string('name', 60)
        ->after('event_id');

      $table->dropColumn('stand_type_id');
    });
  }

  public function down(): void {
    Schema::table('event_stand_configs', function (Blueprint $table) {
      $table->foreignId('stand_type_id')
        ->after('updated_by_id')
        ->constrained('stand_types');

      $table->dropForeign(['event_id']);

      $table->dropColumn([
        'event_id',
        'name',
      ]);
    });
  }
};