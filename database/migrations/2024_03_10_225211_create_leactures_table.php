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
        Schema::create('leactures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('day');
            $table->time('hour');
            $table->enum('time', ['40', '60'])->default('40');
            $table->enum('price', ['20', '40','60'])->default('20');
            $table->unsignedBigInteger('teacher_id');
            
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leactures');
    }
};
