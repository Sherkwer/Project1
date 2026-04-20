<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_students_violations', function (Blueprint $table) {
            $table->double('id')->primary();
            $table->string('sid', 30)->nullable();
            $table->string('vid', 30)->nullable();
            $table->date('date_issued')->nullable();
            $table->decimal('fee', 10, 0)->nullable();
            $table->string('status', 30)->nullable();
            $table->string('area_code', 30)->nullable();
            $table->string('college_id', 30)->nullable();
            $table->string('course_id', 30)->nullable();
            $table->timestamp('created_at')->useCurrent()->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->timestamp('deleted_at')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_students_violations');
    }
};
