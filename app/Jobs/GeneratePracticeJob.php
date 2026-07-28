<?php

namespace App\Jobs;

use App\Models\Course;
use App\Models\Option;
use App\Models\PracticeSet;
use App\Models\Question;
use App\Services\GemmaAIService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class GeneratePracticeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;
    public int $tries   = 2;

    public function __construct(public PracticeSet $practiceSet)
    {
    }

    public function handle(GemmaAIService $gemmaAIService): void
    {
        try {
            $this->practiceSet->update(['status' => 'generating']);

            $course = Course::with('materials')->findOrFail($this->practiceSet->course_id);

            // Gather extracted text from all materials in this course with text
            $materials = $course->materials()
                ->whereNotNull('extracted_text')
                ->where('extracted_text', '!=', '')
                ->get();

            if ($materials->isEmpty()) {
                throw new \Exception('No processed course materials found. Please upload and process PDF materials first.');
            }

            // Concatenate material text, limit to 25k chars to avoid token overflow
            $combinedText = $materials->map(fn($m) => "=== {$m->title} ===\n{$m->extracted_text}")->implode("\n\n");
            $textForAI    = Str::limit($combinedText, 25000);

            $payload   = $this->practiceSet->ai_request_payload ?? [];
            $count     = (int) ($payload['count'] ?? 10);
            $difficulty = $payload['difficulty'] ?? 'medium';

            $result = $gemmaAIService->generatePracticeQuestions($textForAI, $count, $difficulty);

            if (!$result['success'] || empty($result['data'])) {
                throw new \Exception($result['error'] ?? 'Gemma AI returned an empty response.');
            }

            // Strip any markdown code fences the model may have wrapped around JSON
            $rawJson = trim($result['data']);
            $rawJson = preg_replace('/^```(?:json)?\s*/i', '', $rawJson);
            $rawJson = preg_replace('/\s*```$/', '', $rawJson);

            $questionsData = json_decode($rawJson, true);

            if (!is_array($questionsData) || empty($questionsData)) {
                throw new \Exception('AI response could not be parsed as valid JSON: ' . Str::limit($rawJson, 200));
            }

            // Persist questions + options
            $objectiveCount = 0;
            foreach ($questionsData as $qData) {
                $questionText = $qData['question'] ?? null;
                $options      = $qData['options'] ?? [];
                $correctKey   = strtoupper(trim($qData['correct_answer'] ?? 'A'));
                $explanation  = $qData['explanation'] ?? null;
                $topic        = $qData['topic'] ?? null;

                if (empty($questionText) || empty($options)) {
                    continue;
                }

                $question = Question::create([
                    'practice_set_id' => $this->practiceSet->id,
                    'course_id'       => $this->practiceSet->course_id,
                    'question'        => $questionText,
                    'question_type'   => 'objective',
                    'difficulty'      => $difficulty,
                    'topic'           => $topic,
                    'marks'           => 1,
                    'explanation'     => $explanation,
                    'correct_answer'  => $correctKey,
                ]);

                foreach ($options as $label => $text) {
                    Option::create([
                        'question_id'  => $question->id,
                        'option_label' => strtoupper($label),
                        'option_text'  => $text,
                        'is_correct'   => strtoupper($label) === $correctKey,
                    ]);
                }

                $objectiveCount++;
            }

            $this->practiceSet->update([
                'status'             => 'ready',
                'total_questions'    => $objectiveCount,
                'objective_questions'=> $objectiveCount,
                'estimated_time'     => intval(ceil($objectiveCount * 1.5)),
                'error_message'      => null,
            ]);

            Log::info("GeneratePracticeJob: completed for PracticeSet ID {$this->practiceSet->id} — {$objectiveCount} questions created.");

        } catch (Throwable $e) {
            Log::error("GeneratePracticeJob failed for PracticeSet ID {$this->practiceSet->id}: " . $e->getMessage());

            $this->practiceSet->update([
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
