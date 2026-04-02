<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('suppliers', function (Blueprint $table) {
      $table->string('logo_path', 50)->nullable()->after('name');
      $table->string('phone', 10)->nullable()->after('logo_path');
      $table->string('website_url', 150)->nullable()->after('phone');
      $table->text('description')->nullable()->after('website_url');
      $table->string('address', 150)->nullable()->after('description');
      $table->foreignId('municipality_id')->nullable()->after('address')->constrained('municipalities');
      $table->string('zip', 10)->nullable()->after('municipality_id');
      $table->string('fiscal_code', 13)->nullable()->after('zip');
      $table->string('fiscal_name', 150)->nullable()->after('fiscal_code');
      $table->string('fiscal_zip', 10)->nullable()->after('fiscal_name');
      $table->foreignId('fiscal_regime_id')->nullable()->after('fiscal_zip')->constrained('fiscal_regimes');
      $table->foreignId('cfdi_usage_id')->nullable()->after('fiscal_regime_id')->constrained('cfdi_usages');
      $table->string('tax_certificate_path', 50)->nullable()->after('cfdi_usage_id');
      $table->string('positive_opinion_path', 50)->nullable()->after('tax_certificate_path');
    });
  }

  public function down(): void {
    Schema::table('suppliers', function (Blueprint $table) {
      Schema::table('suppliers', function (Blueprint $table) {
        $table->dropForeign(['municipality_id']);
        $table->dropForeign(['fiscal_regime_id']);
        $table->dropForeign(['cfdi_use_id']);

        $table->dropColumn([
          'logo_path',
          'phone',
          'website_url',
          'description',
          'address',
          'municipality_id',
          'zip',
          'fiscal_code',
          'fiscal_name',
          'fiscal_zip',
          'fiscal_regime_id',
          'cfdi_use_id',
          'tax_certificate_path',
          'positive_opinion_path',
        ]);
      });
    });
  }
};
