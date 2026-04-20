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
        Schema::create('db_colleges', function (Blueprint $table) {
            $table->double('id')->nullable();
            $table->string('area_code', 30)->nullable();
            $table->string('name', 765)->nullable();
            $table->string('prefix', 15)->nullable();
            $table->string('head_officer', 765)->nullable();
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
        Schema::dropIfExists('db_colleges');
    }
};
