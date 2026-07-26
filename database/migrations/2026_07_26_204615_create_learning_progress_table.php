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
        Schema::create('learning_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->decimal('overall_score', 5, 2)->default(0);
            $table->enum('understanding_level', ['beginner', 'intermediate', 'advanced', 'expert'])->default('beginner')->index();
            $table->decimal('mastery_percentage', 5, 2)->default(0);
            $table->longText('strengths')->nullable();
            $table->longText('weaknesses')->nullable();
            $table->longText('recommendation')->nullable();
            $table->timestamp('last_analysis_at')->nullable()->index();
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_progress');
    }
};
