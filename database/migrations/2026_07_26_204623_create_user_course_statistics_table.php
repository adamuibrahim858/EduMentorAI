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
        Schema::create('user_course_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('materials_uploaded')->default(0);
            $table->unsignedInteger('summaries_generated')->default(0);
            $table->unsignedInteger('practice_taken')->default(0);
            $table->decimal('average_score', 5, 2)->default(0);
            $table->decimal('highest_score', 5, 2)->default(0);
            $table->decimal('study_hours', 8, 2)->default(0);
            $table->unsignedInteger('current_streak')->default(0)->comment('Current consecutive study streak in days.');
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_course_statistics');
    }
};
