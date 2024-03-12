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
        Schema::create('exames', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('ans1');
            $table->string('ans2');
            $table->string('ans3');
            $table->string('ans4');
            $table->string('correct');
            $table->integer('time');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('leacture_id');
            
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->foreign('leacture_id')->references('id')->on('leactures');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exames');
    }
};
