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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practice_set_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->longText('question');
            $table->enum('question_type', ['objective', 'essay'])->index();
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium')->index();
            $table->string('topic')->nullable()->index();
            $table->decimal('marks', 5, 2)->nullable();
            $table->longText('explanation')->nullable();
            $table->longText('correct_answer')->nullable();
            $table->timestamps();

            $table->index(['practice_set_id', 'question_type']);
            $table->index(['course_id', 'topic', 'difficulty']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
