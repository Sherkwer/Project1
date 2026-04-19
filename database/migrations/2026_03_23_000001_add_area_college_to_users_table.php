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
        Schema::table('users', function (Blueprint $table) {
            // Add missing foreign key columns for area and college if they don't exist
            if (!Schema::hasColumn('users', 'area_id')) {
                $table->unsignedBigInteger('area_id')->nullable()->after('organization_id');
                $table->foreign('area_id')->references('id')->on('areas')->onDelete('set null');
            }

            if (!Schema::hasColumn('users', 'college_id')) {
                $table->unsignedBigInteger('college_id')->nullable()->after('area_id');
                $table->foreign('college_id')->references('id')->on('db_colleges')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign keys and columns
            if (Schema::hasColumn('users', 'area_id')) {
                $table->dropForeign(['area_id']);
                $table->dropColumn('area_id');
            }

            if (Schema::hasColumn('users', 'college_id')) {
                $table->dropForeign(['college_id']);
                $table->dropColumn('college_id');
            }
        });
    }
};
