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
        Schema::create('db_sims_settings', function (Blueprint $table) {
            $table->double('id')->nullable();
            $table->string('school_name', 450)->nullable();
            $table->string('school_code', 12)->nullable();
            $table->double('c_period')->nullable();
            $table->string('c_curriculum_year', 27)->nullable();
            $table->double('min_student_class')->nullable();
            $table->double('max_student_class')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->double('updated_user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('db_sims_settings');
    }
};
