<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('buyers', function (Blueprint $table) {
      $table->string('logo_path', 50)->nullable()->after('name');
      $table->string('phone', 10)->nullable()->after('logo_path');
      $table->string('website_url', 150)->nullable()->after('phone');
      $table->text('description')->nullable()->after('website_url');
      $table->string('address', 150)->nullable()->after('description');
      $table->foreignId('municipality_id')->nullable()->after('address')->constrained('municipalities');
      $table->string('zip', 10)->nullable()->after('municipality_id');
    });
  }

  public function down(): void {
    Schema::table('buyers', function (Blueprint $table) {
      $table->dropForeign(['municipality_id']);

      $table->dropColumn([
        'logo_path',
        'phone',
        'website_url',
        'description',
        'address',
        'municipality_id',
        'zip',
      ]);
    });
  }
};
