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
        Schema::create('tbl_student_soa', function (Blueprint $table) {
            $table->double('id')->primary();
            $table->string('soa_type', 255)->nullable();
            $table->string('area_code', 255)->nullable();
            $table->string('college_id', 255)->nullable();
            $table->integer('student_id');
            $table->integer('receipt_id');
            $table->integer('fee_id');
            $table->decimal('debit', 10, 0)->nullable();
            $table->decimal('credit', 10, 0)->nullable();
            $table->timestamp('created_at')->useCurrent()->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
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
        Schema::dropIfExists('tbl_student_soa');
    }
};
