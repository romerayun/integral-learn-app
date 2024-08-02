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
        Schema::create('final_quiz_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_program_id')->nullable()->constrained('learning_programs')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('final_quiz_id')->nullable()->constrained('final_quizzes')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->json('answers');
            $table->integer('countRightAnswers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_quiz_results');
    }
};
