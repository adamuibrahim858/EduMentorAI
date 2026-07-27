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
            $table->longText('summary')->comment('Markdown summary content');
            $table->longText('html_content')->nullable();
            $table->longText('plain_text')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('ai_model')->default('Gemma-2-9B-It')->index();
            $table->string('prompt_version')->default('v1.0');
            $table->enum('summary_type', ['short', 'detailed', 'bullet', 'exam_revision', 'flashcards'])->default('detailed')->index();
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium')->index();
            $table->string('generated_by')->default('Gemma-2-9B-It')->index();
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
