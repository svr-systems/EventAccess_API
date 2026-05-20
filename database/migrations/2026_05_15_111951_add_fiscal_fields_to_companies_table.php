<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('companies', function (Blueprint $table) {

      $table->decimal('commission_percentage', 5, 2)
        ->default(0)
        ->after('description');

      $table->string('fiscal_code', 13)
        ->nullable()
        ->after('commission_percentage');

      $table->string('fiscal_name', 75)
        ->nullable()
        ->after('fiscal_code');

      $table->string('fiscal_zip', 5)
        ->nullable()
        ->after('fiscal_name');

      $table->foreignId('fiscal_regime_id')
        ->nullable()
        ->after('fiscal_zip')
        ->constrained('fiscal_regimes');

      $table->foreignId('cfdi_usage_id')
        ->nullable()
        ->after('fiscal_regime_id')
        ->constrained('cfdi_usages');

      $table->string('fiscal_organization_id', 25)
        ->nullable()
        ->after('cfdi_usage_id');

      $table->dateTime('fiscal_certificate_updated_at')
        ->nullable()
        ->after('fiscal_organization_id');

      $table->dateTime('fiscal_certificate_expires_at')
        ->nullable()
        ->after('fiscal_certificate_updated_at');

      $table->string('fiscal_certificate_serial_number', 50)
        ->nullable()
        ->after('fiscal_certificate_expires_at');
    });
  }

  public function down(): void {
    Schema::table('companies', function (Blueprint $table) {

      $table->dropForeign(['fiscal_regime_id']);
      $table->dropForeign(['cfdi_usage_id']);

      $table->dropColumn([
        'commission_percentage',
        'fiscal_code',
        'fiscal_name',
        'fiscal_zip',
        'fiscal_regime_id',
        'cfdi_usage_id',
        'fiscal_organization_id',
        'fiscal_certificate_updated_at',
        'fiscal_certificate_expires_at',
        'fiscal_certificate_serial_number',
      ]);
    });
  }
};