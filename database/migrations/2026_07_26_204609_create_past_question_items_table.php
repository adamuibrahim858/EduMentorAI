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
        Schema::create('past_question_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('past_question_id')->constrained()->cascadeOnDelete();
            $table->string('question_number')->index();
            $table->longText('question');
            $table->longText('answer')->nullable();
            $table->enum('type', ['objective', 'essay'])->index();
            $table->decimal('marks', 5, 2)->nullable();
            $table->string('topic')->nullable()->index();
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium')->index();
            $table->timestamps();

            $table->index(['past_question_id', 'type', 'difficulty']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('past_question_items');
    }
};
