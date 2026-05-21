<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('transactions', function (Blueprint $table) {
      $table->id();
      $table->boolean('is_active')->default(true);
      $table->timestamps();
      $table->boolean('status');
      $table->string('card_number', 20);
      $table->foreignId('bank_type_id')->nullable()->default(null)->constrained('bank_types');
      $table->foreignId('payment_form_id')->constrained('payment_forms');
      $table->string('authorization_code', 20);
      $table->string('reading_mode', 5)->nullable();
      $table->string('arqc', 20)->nullable();
      $table->string('aid', 20)->nullable();
      $table->string('financial_reference', 20)->nullable();
      $table->string('terminal_number', 10)->nullable();
      $table->string('transaction_sequence', 20)->nullable();
      $table->string('cardholder_name', 100);
      $table->text('error_message')->nullable();
      $table->string('response_code', 5)->nullable();
      $table->boolean('is_points_used')->default(false);
      $table->decimal('points_redeemed', 11, 2)->nullable()->default(null);
      $table->decimal('amount_redeemed', 11, 2)->nullable()->default(null);
      $table->decimal('previous_balance_amount', 11, 2)->nullable()->default(null);
      $table->decimal('previous_balance_points', 11, 2)->nullable()->default(null);
      $table->decimal('current_balance_amount', 11, 2)->nullable()->default(null);
      $table->decimal('current_balance_points', 11, 2)->nullable()->default(null);
      $table->dateTime('operation_date');
      $table->decimal('charge_amount',11,2);
      $table->string('external_id', 25);
    });
  }

  public function down(): void {
    Schema::dropIfExists('transactions');
  }
};
