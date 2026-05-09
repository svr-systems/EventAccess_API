<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('supplier_certifications', function (Blueprint $table) {
      $table->string('certification_path', 50);
    });
  }

  public function down(): void {
    Schema::table('supplier_certifications', function (Blueprint $table) {
      $table->dropColumn('stand_type_id');
    });
  }
};
