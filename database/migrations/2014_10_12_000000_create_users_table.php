<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('users', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('fullname');
    //         $table->string('phonenumber')->unique();
    //         $table->string('email')->unique();
    //         $table->date('dob')->nullable();
    //         $table->string('adress')->nullable();
    //         $table->string('avatar')->nullable();
    //         $table->enum('role', ['admin', 'user'])->default('user');
    //         $table->enum('gender', ['male', 'female', 'other'])->nullable();
    //         $table->timestamp('email_verified_at')->nullable();
    //         $table->string('password');
    //         $table->rememberToken();
    //         $table->timestamps();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::dropIfExists('users');
    // }
};
