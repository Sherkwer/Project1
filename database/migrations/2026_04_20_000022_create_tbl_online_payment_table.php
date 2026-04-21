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
        Schema::create('tbl_online_payment', function (Blueprint $table) {
            $table->double('id')->primary();
            $table->double('user_id')->nullable();
            $table->double('student_id')->nullable();
            $table->string('payment_type', 255)->nullable();
            $table->string('payement_date', 255)->nullable();
            $table->decimal('total_amount', 10, 0)->nullable();
            $table->string('message', 250)->nullable();
            $table->string('proof_location', 255)->nullable();
            $table->string('reference_id', 255)->nullable();
            $table->string('status', 255)->nullable();
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
        Schema::dropIfExists('tbl_online_payment');
    }
};
