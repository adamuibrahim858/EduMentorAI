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
        Schema::create('study_routines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title')->index();
            $table->string('study_day')->index();
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('study_duration')->comment('Planned study duration in minutes.');
            $table->unsignedInteger('practice_duration')->default(0)->comment('Planned practice duration in minutes.');
            $table->enum('repeat_type', ['daily', 'weekly', 'custom'])->default('weekly')->index();
            $table->boolean('status')->default(true)->index();
            $table->timestamps();

            $table->index(['user_id', 'course_id', 'study_day']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_routines');
    }
};
