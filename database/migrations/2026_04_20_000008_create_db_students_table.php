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
        Schema::create('db_students', function (Blueprint $table) {
            $table->double('id')->primary();
            $table->string('sid', 75)->nullable();
            $table->string('lname', 90)->nullable();
            $table->string('fname', 150)->nullable();
            $table->string('mname', 90)->nullable();
            $table->string('fullname', 300)->nullable();
            $table->string('email', 150)->nullable();
            $table->integer('rid')->nullable();
            $table->string('area_code', 33)->nullable();
            $table->string('college_code', 33)->nullable();
            $table->string('organization_id', 33)->nullable();
            $table->string('course_code', 33)->nullable();
            $table->string('qr_code', 33)->nullable();
            $table->string('rfid', 33)->nullable();
            $table->string('year_level', 36)->nullable();
            $table->string('term', 30)->nullable();
            $table->string('sy', 36)->nullable();
            $table->string('cy', 27)->nullable();
            $table->string('password', 1500)->nullable();
            $table->string('student_status', 20)->nullable();
            $table->string('enroll_status', 20)->nullable();
            $table->string('verification_code', 15)->nullable();
            $table->string('remember_token', 765)->nullable();
            $table->string('area_transfered_to', 33)->nullable();
            $table->string('area_transfered_from', 33)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('transfered_at')->nullable();
            $table->string('verification_code_reset', 18)->nullable();
            $table->timestamp('verification_created_at')->nullable();
            $table->string('is_requested_vrc', 3)->nullable();
            $table->timestamp('password_reset_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('db_students');
    }
};
