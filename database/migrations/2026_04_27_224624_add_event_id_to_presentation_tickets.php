<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('presentation_tickets', function (Blueprint $table) {
      $table->foreignId('event_id')->default(1)->after('updated_by_id')->constrained('events');
    });
  }

  public function down(): void {
    Schema::table('presentation_tickets', function (Blueprint $table) {
      $table->dropForeign(['event_id']);
      $table->dropColumn([
        'event_id',
      ]);
    });
  }
};
