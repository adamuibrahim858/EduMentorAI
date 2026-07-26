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
        Schema::create('practice_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title')->index();
            $table->enum('generated_from', ['course_material', 'past_questions', 'summaries', 'mixed'])->index();
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium')->index();
            $table->unsignedInteger('total_questions')->default(0);
            $table->unsignedInteger('objective_questions')->default(0);
            $table->unsignedInteger('essay_questions')->default(0);
            $table->unsignedInteger('estimated_time')->nullable()->comment('Estimated completion time in minutes.');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['course_id', 'difficulty']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_sets');
    }
};
