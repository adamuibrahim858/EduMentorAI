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
        Schema::create('document_chunks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained('course_materials')->cascadeOnDelete();
            $table->unsignedInteger('chunk_number');
            $table->longText('content');
            $table->json('embedding')->nullable()->comment('Vector embedding payload stored as JSON for MySQL 8 compatibility.');
            $table->unsignedInteger('token_count')->default(0);
            $table->unsignedInteger('page_start')->nullable();
            $table->unsignedInteger('page_end')->nullable();
            $table->timestamps();

            $table->unique(['material_id', 'chunk_number']);
            $table->index(['material_id', 'page_start', 'page_end']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_chunks');
    }
};
