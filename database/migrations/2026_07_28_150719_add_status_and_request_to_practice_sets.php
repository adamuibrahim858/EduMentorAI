<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('practice_sets', function (Blueprint $table) {
            // Who requested this practice set
            $table->foreignId('user_id')->after('id')->constrained()->cascadeOnDelete();

            // AI generation status
            $table->enum('status', [
                'pending_ai',        // Created, waiting for AI to populate questions
                'generating',        // AI is currently processing
                'ready',             // Questions generated, ready to attempt
                'failed',            // AI generation failed
            ])->default('pending_ai')->index()->after('estimated_time');

            // JSON blob storing the original generation request settings
            // Future Gemma service reads this to know what to generate
            $table->json('ai_request_payload')->nullable()->after('status')
                ->comment('Stores difficulty, question_type, count, source for future AI generation.');

            // Human-readable question type request
            $table->enum('question_type', ['objective', 'essay', 'mixed'])->default('mixed')->after('generated_from');

            // Error message if AI fails
            $table->text('error_message')->nullable()->after('ai_request_payload');
        });
    }

    public function down(): void
    {
        Schema::table('practice_sets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'status', 'ai_request_payload', 'question_type', 'error_message']);
        });
    }
};
