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
        Schema::create('past_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title')->index();
            $table->unsignedSmallInteger('year')->index();
            $table->string('semester')->index();
            $table->string('file')->comment('Storage path or disk-relative file location.');
            $table->unsignedInteger('pages')->nullable();
            $table->boolean('processed')->default(false)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['course_id', 'year', 'semester']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('past_questions');
    }
};
