<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('events', function (Blueprint $table) {
      $table->boolean('has_buyers')->default(false)->after('has_stands');
    });
  }

  public function down(): void {
    Schema::table('events', function (Blueprint $table) {
      $table->dropColumn('has_buyers');
    });
  }
};