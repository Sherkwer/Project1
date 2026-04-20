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
        Schema::create('tbl_expenses', function (Blueprint $table) {
            $table->double('id')->primary();
            $table->string('college_id', 255)->nullable();
            $table->string('area_code', 255)->nullable();
            $table->string('course_id', 255)->nullable();
            $table->string('person_in_charge', 255)->nullable();
            $table->date('disbursement_date')->nullable();
            $table->decimal('amount', 10, 0)->nullable();
            $table->string('description', 255)->nullable();
            $table->timestamp('created_at')->useCurrent()->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->timestamp('deleted_at')->default('0000-00-00 00:00:00');
            $table->timestamp('cancelled_at')->default('0000-00-00 00:00:00');
            $table->integer('created_user_id')->nullable();
            $table->integer('updated_user_id')->nullable();
            $table->integer('deleted_user_id')->nullable();
            $table->integer('cancelled_user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_expenses');
    }
};
