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
        Schema::create('tbl_collection', function (Blueprint $table) {
            $table->id();
            $table->string('collection_type', 255)->nullable();
            $table->integer('user_id')->nullable();
            $table->decimal('amount_collected', 10, 0)->nullable();
            $table->date('date_subminted')->nullable();
            $table->string('description', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_user_id')->nullable();
            $table->integer('updated_user_id')->nullable();
            $table->integer('deleted_user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_collection');
    }
};
