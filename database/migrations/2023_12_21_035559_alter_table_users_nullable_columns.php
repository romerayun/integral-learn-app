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
        Schema::table('users', function (Blueprint $table) {
            $table->string('series_passport')->nullable()->change();
            $table->string('number_passport')->nullable()->change();
            $table->date('date_of_birth')->nullable()->change();
            $table->string('sex')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('series_passport')->change();
            $table->string('number_passport')->change();
            $table->date('date_of_birth')->change();
            $table->string('sex')->change();
        });
    }
};
