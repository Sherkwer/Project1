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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fname', 150)->nullable();
            $table->string('mname', 150)->nullable();
            $table->string('lname', 150)->nullable();
            $table->string('fullname', 200)->nullable();
            $table->string('email', 300)->nullable();
            $table->string('password', 150)->nullable();
            $table->string('user_role', 60)->nullable();
            $table->string('area_code', 60)->nullable();
            $table->string('department_id', 60)->nullable();
            $table->string('organization_id', 60)->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->string('is_approved', 20)->nullable();
            $table->integer('is_admin')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('is_requested_vrc', 33)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_code', 50)->nullable();
            $table->timestamp('verification_created_at')->nullable();
            $table->timestamp('password_reset_at')->nullable();
            $table->double('created_user_id')->nullable();
            $table->double('deleted_user_id')->nullable();
            $table->double('activated_user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
