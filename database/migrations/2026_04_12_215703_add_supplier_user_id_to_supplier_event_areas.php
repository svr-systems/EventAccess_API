<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('supplier_event_areas', function (Blueprint $table) {
      $table->foreignId('supplier_user_id')
        ->after('supplier_id')
        ->constrained('supplier_users');
    
      $table->unique(['supplier_id','supplier_user_id', 'event_area_id'],'uq_s_su_ea');
    });
  }

  public function down(): void {
    Schema::table('supplier_event_areas', function (Blueprint $table) {
      $table->dropForeign(['supplier_user_id']);
      $table->dropColumn('supplier_user_id');
    });
  }
};