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
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->enum('reference_type', ['summary', 'question', 'flashcard', 'practice_set', 'material'])->index();
            $table->unsignedBigInteger('reference_id')->comment('ID of the bookmarked record for the selected reference_type.');
            $table->timestamps();

            $table->unique(['user_id', 'reference_type', 'reference_id']);
            $table->index(['course_id', 'reference_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
