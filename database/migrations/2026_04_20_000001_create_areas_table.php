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
        Schema::create('areas', function (Blueprint $table) {
            $table->double('id')->nullable();
            $table->string('area_code', 300)->nullable();
            $table->string('area_name', 150)->nullable();
            $table->string('area_address', 450)->nullable();
            $table->string('area_report_header_path', 1500)->nullable();
            $table->string('receipt_template', 3)->nullable();
            $table->string('receipt_print_option', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
