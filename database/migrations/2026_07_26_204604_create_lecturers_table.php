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
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('name')->index();
            $table->string('profession')->nullable();
            $table->enum('highest_qualification', ['Degree', 'Masters', 'PhD', 'Professor', 'Other'])->default('Other')->index();
            $table->string('specialization')->nullable()->index();
            $table->string('department')->nullable()->index();
            $table->unsignedTinyInteger('years_of_experience')->nullable();
            $table->text('teaching_style')->nullable();
            $table->text('research_interest')->nullable();
            $table->text('additional_information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};
