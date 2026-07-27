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
        Schema::create('course_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title')->index();
            $table->string('original_filename')->nullable();
            $table->string('file')->comment('Storage path or disk-relative file location.');
            $table->string('mime_type')->default('application/pdf');
            $table->unsignedBigInteger('file_size')->nullable()->comment('File size in bytes.');
            $table->unsignedInteger('pages')->nullable();
            $table->unsignedInteger('total_words')->nullable();
            $table->longText('extracted_text')->nullable();
            $table->enum('status', ['uploading', 'processing', 'generating_summary', 'generating_pdf', 'completed', 'failed'])->default('processing')->index();
            $table->enum('embedding_status', ['pending', 'processing', 'completed', 'failed'])->default('pending')->index();
            $table->text('error_message')->nullable();
            $table->timestamp('processed_at')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['course_id', 'status']);
            $table->index(['course_id', 'embedding_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_materials');
    }
};
