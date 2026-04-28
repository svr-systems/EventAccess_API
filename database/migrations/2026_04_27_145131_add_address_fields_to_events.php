<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('events', function (Blueprint $table) {
      $table->foreignId('municipality_id')->default(1)->after('address')->constrained('municipalities');
      $table->string('address_reference', 150)->nullable()->after('municipality_id');
    });
  }
  public function down(): void {
    Schema::table('events', function (Blueprint $table) {
      $table->dropForeign(['municipality_id']);
      $table->dropColumn([
        'municipality_id',
        'address_reference',
      ]);
    });
  }
};
