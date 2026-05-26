<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up(): void {
    Schema::table('meetings', function (Blueprint $table) {
      $table->boolean('is_checked_in')
        ->default(false)
        ->after('is_confirmed');
    });
  }

  public function down(): void {
    Schema::table('meetings', function (Blueprint $table) {
      $table->dropColumn('is_checked_in');
    });
  }
};