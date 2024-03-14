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
        Schema::table('complete_activities', function (Blueprint $table) {
            $table->foreignId('theme_id')->constrained('themes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->primary(['learning_program_id', 'user_id', 'activity_id', 'theme_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complete_activities', function (Blueprint $table) {
            $table->dropForeign(['theme_id']);
            $table->dropColumn(['theme_id']);
            $table->dropPrimary(['learning_program_id', 'user_id', 'activity_id', 'theme_id']);
        });
    }
};
