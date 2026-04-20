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
        Schema::create('db_courses', function (Blueprint $table) {
            $table->double('id')->nullable();
            $table->string('area_code', 45)->nullable();
            $table->string('category', 45)->nullable();
            $table->double('class_id')->nullable();
            $table->string('course_program', 75)->nullable();
            $table->string('status', 45)->nullable();
            $table->string('code', 33)->nullable();
            $table->string('name', 765)->nullable();
            $table->double('major_id')->nullable();
            $table->string('is_parent', 3)->nullable();
            $table->double('parent_id')->nullable();
            $table->string('aop', 765)->nullable();
            $table->string('calendar', 45)->nullable();
            $table->double('no_years')->nullable();
            $table->double('no_of_terms')->nullable();
            $table->string('year_offered', 12)->nullable();
            $table->double('max_unit')->nullable();
            $table->decimal('lab_units', 20, 0)->nullable();
            $table->decimal('lec_units', 20, 0)->nullable();
            $table->decimal('tot_units', 20, 0)->nullable();
            $table->decimal('tution_per_unit', 20, 0)->nullable();
            $table->decimal('fee_amount', 20, 0)->nullable();
            $table->double('level_id')->nullable();
            $table->double('college_id')->nullable();
            $table->string('is_ched_priority', 3)->nullable();
            $table->string('is_thesis_dissertation_required', 45)->nullable();
            $table->string('is_degree', 3)->nullable();
            $table->string('is_undergrad', 3)->nullable();
            $table->string('is_advanced_educ', 3)->nullable();
            $table->string('is_sdg', 3)->nullable();
            $table->string('remarks', 765)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->double('created_user_id')->nullable();
            $table->double('updated_user_id')->nullable();
            $table->double('deleted_user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('db_courses');
    }
};
