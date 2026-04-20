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
        Schema::create('tbl_violations', function (Blueprint $table) {
            $table->id();
            $table->string('vname', 100)->nullable();
            $table->date('date_implemented')->nullable();
            $table->double('fee')->nullable();
            $table->string('description', 250)->nullable();
            $table->string('status', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_violations');
    }
};
