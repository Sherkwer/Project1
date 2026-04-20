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
        Schema::create('tbl_events', function (Blueprint $table) {
            $table->id();
            $table->string('area_code', 33)->nullable();
            $table->string('college_id', 33)->nullable();
            $table->string('event_name', 100)->nullable();
            $table->string('schedule', 30)->nullable();
            $table->string('sy', 30)->nullable();
            $table->string('term', 36)->nullable();
            $table->string('venue', 50)->nullable();
            $table->string('am_in', 10)->nullable();
            $table->string('am_out', 10)->nullable();
            $table->string('pm_in', 10)->nullable();
            $table->string('pm_out', 10)->nullable();
            $table->string('description', 250)->nullable();
            $table->decimal('fee_perSession', 10, 0)->nullable();
            $table->string('status', 15)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_events');
    }
};
