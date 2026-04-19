<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('db_colleges', function (Blueprint $table) {
            if (!Schema::hasColumn('db_colleges', 'campus_id')) {
                $table->unsignedBigInteger('campus_id')->nullable()->after('area_code');
                $table->foreign('campus_id')->references('id')->on('areas')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('db_colleges', function (Blueprint $table) {
            if (Schema::hasColumn('db_colleges', 'campus_id')) {
                $table->dropForeign(['campus_id']);
                $table->dropColumn('campus_id');
            }
        });
    }
};
