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
        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('user_practice_sessions')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->string('selected_option', 10)->nullable();
            $table->longText('essay_answer')->nullable();
            $table->longText('ai_feedback')->nullable();
            $table->decimal('score', 8, 2)->nullable();
            $table->boolean('is_correct')->nullable()->index();
            $table->timestamps();

            $table->unique(['session_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_answers');
    }
};
