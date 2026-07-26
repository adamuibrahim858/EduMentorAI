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
        Schema::create('study_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('topic')->index();
            $table->decimal('mastery_score', 5, 2)->default(0);
            $table->unsignedInteger('attempts')->default(0);
            $table->decimal('average_score', 5, 2)->default(0);
            $table->timestamp('last_practiced')->nullable()->index();
            $table->enum('confidence_level', ['low', 'medium', 'high'])->default('low')->index();
            $table->timestamps();

            $table->unique(['user_id', 'course_id', 'topic']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_topics');
    }
};
