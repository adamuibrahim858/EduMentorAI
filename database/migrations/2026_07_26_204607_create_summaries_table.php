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
        Schema::create('summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('material_id')->constrained('course_materials')->cascadeOnDelete();
            $table->string('title')->index();
            $table->longText('summary');
            $table->enum('summary_type', ['short', 'detailed', 'bullet', 'exam_revision', 'flashcards'])->index();
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium')->index();
            $table->string('generated_by')->default('Gemma-4')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['course_id', 'material_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('summaries');
    }
};
