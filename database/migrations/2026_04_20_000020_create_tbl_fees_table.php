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
        Schema::create('tbl_fees', function (Blueprint $table) {
            $table->id();
            $table->string('fee_name', 150)->nullable();
            $table->integer('fee_type_id')->nullable();
            $table->decimal('amount', 4, 0)->nullable();
            $table->string('description', 765)->nullable();
            $table->string('status', 30)->nullable();
            $table->string('area_code', 33)->nullable();
            $table->string('college_id', 33)->nullable();
            $table->string('organization_id', 33)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_fees');
    }
};
