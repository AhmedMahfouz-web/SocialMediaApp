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
            $table->string('nickname');
            $table->string('imei')->unique();
            $table->string('password');
            $table->string('gender');
            $table->smallInteger('age');
            $table->integer('karizma')->nullable();
            $table->integer('money')->nullable();
            $table->string('country');
            $table->integer('rockets')->nullable();
            $table->smallInteger('ban')->default(0);
            $table->string('ban_end')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
