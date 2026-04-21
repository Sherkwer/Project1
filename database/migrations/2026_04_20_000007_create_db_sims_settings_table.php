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
            $table->double('id');
            $table->string('school_name', 450);
            $table->string('school_code', 12);
            $table->double('c_period');
            $table->string('c_curriculum_year', 27);
            $table->double('min_student_class');
            $table->double('max_student_class');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
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
