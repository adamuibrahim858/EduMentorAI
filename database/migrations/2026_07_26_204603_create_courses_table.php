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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('course_code')->index();
            $table->string('course_title')->index();
            $table->unsignedTinyInteger('course_unit')->comment('Course credit unit value.');
            $table->string('semester')->index();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'archived'])->default('active')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'course_code', 'semester']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
