<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('certifications', function (Blueprint $table) {
      $table->id();
      $table->auditFields();
      $table->string('name', 100);
    });
  }

  public function down(): void {
    Schema::dropIfExists('certifications');
  }
};