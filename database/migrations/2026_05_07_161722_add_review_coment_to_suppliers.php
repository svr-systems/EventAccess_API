<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->text('reviewed_comment')->nullable()->default(null)->after('reviewed_at');
        });
    }

    public function down(): void {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn('reviewed_comment');
        });
    }
};
