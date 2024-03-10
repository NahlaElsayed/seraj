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
     
            Schema::create('teachers', function (Blueprint $table) {
                $table->id();
                $table->string('fname');
                $table->string('lname');
                $table->string('email')->unique();
                $table->string('phone')->unique();
                $table->text('image')->nullable();
                $table->integer('age');
                $table->integer('exprience');
                $table->string('password');
                $table->string('about');
                $table->enum('status', ['pending', 'approved','in_progress','rejected'])->default('pending');
                $table->integer('year_graduate');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('country_id');
                $table->unsignedBigInteger('skill_id');
                
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('country_id')->references('id')->on('countrys');
                $table->foreign('skill_id')->references('id')->on('skills');
                $table->timestamps();
            });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
