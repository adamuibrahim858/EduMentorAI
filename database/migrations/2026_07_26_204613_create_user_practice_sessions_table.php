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
        Schema::create('user_practice_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('practice_set_id')->constrained()->cascadeOnDelete();
            $table->timestamp('started_at')->nullable()->index();
            $table->timestamp('submitted_at')->nullable()->index();
            $table->decimal('score', 8, 2)->default(0);
            $table->decimal('percentage', 5, 2)->default(0);
            $table->unsignedInteger('time_taken')->nullable()->comment('Total time taken in seconds.');
            $table->enum('status', ['started', 'submitted', 'abandoned'])->default('started')->index();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['practice_set_id', 'submitted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_practice_sessions');
    }
};
