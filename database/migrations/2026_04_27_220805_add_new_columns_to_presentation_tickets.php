<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('presentation_tickets', function (Blueprint $table) {
      $table->dropForeign(['presentation_date_id']);
      $table->dropForeign(['ticket_type_id']);

      $table->dropUnique('presentation_tickets_presentation_date_id_ticket_type_id_unique');

      $table->dropColumn('ticket_type_id');
      
      $table->string('name', 30)->after('presentation_date_id');
      $table->text('description')->nullable()->after('name');

      $table->integer('max_sale')->after('price');

      $table->dateTime('start_sale')->after('sold');
      $table->dateTime('end_sale')->after('start_sale');

      $table->foreign('presentation_date_id')
        ->references('id')
        ->on('presentation_dates');

    });
  }

  public function down(): void {
    Schema::table('presentation_tickets', function (Blueprint $table) {
      $table->foreignId('ticket_type_id')
        ->after('presentation_date_id')
        ->constrained('ticket_types');

      $table->dropColumn([
        'name',
        'description',
        'max_sale',
        'start_sale',
        'end_sale',
      ]);
    });
  }
};