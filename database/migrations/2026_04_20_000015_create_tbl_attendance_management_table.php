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
        Schema::create('tbl_attendance_management', function (Blueprint $table) {
            $table->id();
            $table->string('area_code', 33)->nullable();
            $table->string('college_id', 33)->nullable();
            $table->string('student_rfid', 50)->nullable();
            $table->string('student_qrcode', 50)->nullable();
            $table->string('student_id', 250)->nullable();
            $table->integer('event_id')->nullable();
            $table->date('attendance_date')->nullable();
            $table->string('am_in', 10)->nullable();
            $table->string('am_out', 10)->nullable();
            $table->string('pm_in', 10)->nullable();
            $table->string('pm_out', 10)->nullable();
            $table->decimal('fees', 10, 0)->nullable();
            $table->timestamp('created_at')->useCurrent()->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('deleted_at')->nullable();
            $table->unique('student_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_attendance_management');
    }
};
