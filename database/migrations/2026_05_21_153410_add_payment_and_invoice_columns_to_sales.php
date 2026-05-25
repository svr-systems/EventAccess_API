<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::table('sales', function (Blueprint $table) {
      $table->foreignId('transaction_id')->nullable()->constrained('transactions');
      $table->string('nexora_invoice_id', 25)->nullable();
      $table->string('organization_invoice_id', 25)->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::table('sales', function (Blueprint $table) {
      $table->dropForeign(['transaction_id']);

      $table->dropColumn([
        'transaction_id',
        'nexora_invoice_id',
        'organization_invoice_id',
      ]);
    });
  }
};
