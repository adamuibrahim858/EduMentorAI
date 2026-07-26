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
        Schema::create('learning_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->decimal('average_score', 5, 2)->default(0);
            $table->unsignedInteger('practice_completed')->default(0);
            $table->unsignedInteger('questions_answered')->default(0);
            $table->unsignedInteger('correct_answers')->default(0);
            $table->unsignedInteger('wrong_answers')->default(0);
            $table->decimal('study_hours', 8, 2)->default(0);
            $table->decimal('predicted_exam_score', 5, 2)->nullable();
            $table->longText('ai_report')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_analytics');
    }
};
