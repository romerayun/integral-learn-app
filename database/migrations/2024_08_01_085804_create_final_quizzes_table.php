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
        Schema::create('final_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_program_id')->nullable()->constrained('learning_programs')->cascadeOnUpdate()->nullOnDelete();
            $table->string('key', 6)->nullable();
            $table->boolean('isActive')->default(1);
            $table->integer('countQuestions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_quizzes');
    }
};