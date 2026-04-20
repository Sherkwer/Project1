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
        Schema::create('db_periods', function (Blueprint $table) {
            $table->double('id')->nullable();
            $table->string('code', 33)->nullable();
            $table->string('name', 450)->nullable();
            $table->string('year', 27)->nullable();
            $table->string('term', 60)->nullable();
            $table->string('id_ay', 12)->nullable();
            $table->double('id_count')->nullable();
            $table->string('is_external', 3)->nullable();
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
        Schema::dropIfExists('db_periods');
    }
};
