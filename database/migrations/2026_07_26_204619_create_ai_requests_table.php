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
        Schema::create('ai_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('request_type', ['summary', 'practice_questions', 'essay_marking', 'recommendation', 'translation', 'chatbot'])->index();
            $table->longText('prompt');
            $table->longText('response')->nullable();
            $table->unsignedInteger('tokens_used')->default(0);
            $table->unsignedInteger('latency')->nullable()->comment('AI response latency in milliseconds.');
            $table->string('model')->default('Gemma-4')->index();
            $table->enum('status', ['success', 'failed'])->index();
            $table->timestamps();

            $table->index(['user_id', 'request_type']);
            $table->index(['course_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_requests');
    }
};
