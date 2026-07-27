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
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title')->index();
            $table->string('original_filename')->nullable();
            $table->unsignedSmallInteger('year')->nullable()->index();
            $table->string('semester')->nullable()->index();
            $table->string('file')->comment('Storage path or disk-relative file location.');
            $table->string('mime_type')->default('application/pdf');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->unsignedInteger('pages')->nullable();
            $table->longText('extracted_text')->nullable();
            $table->boolean('processed')->default(false)->index();
            $table->enum('status', ['uploading', 'processing', 'completed', 'failed'])->default('completed')->index();
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
