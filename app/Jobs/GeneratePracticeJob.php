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

            // --- Parse AI response: try JSON first, then fall back to Markdown bullet-point format ---
            $rawText = trim($result['data']);

            // 1. Try to extract a JSON array between the first '[' and last ']'
            $firstBracket = strpos($rawText, '[');
            $lastBracket  = strrpos($rawText, ']');

            $questionsData = null;
            if ($firstBracket !== false && $lastBracket !== false && ($lastBracket - $firstBracket) > 10) {
                $rawJson = substr($rawText, $firstBracket, ($lastBracket - $firstBracket + 1));
                $decoded = json_decode($rawJson, true);
                if (is_array($decoded) && count($decoded) > 0 && isset($decoded[0]['question'])) {
                    $questionsData = $decoded;
                }
            }

            // 2. Fallback: Parse Gemma's bullet-point Markdown format
            // Pattern: * Question N: ...\n * Options: A) ..., B) ..., C) ..., D) ...\n * Correct: X\n * Topic: ...\n
            if (empty($questionsData)) {
                $questionsData = $this->parseMarkdownQuestions($rawText);
            }

            if (!is_array($questionsData) || empty($questionsData)) {
                throw new \Exception('AI response could not be parsed as valid JSON or Markdown: ' . Str::limit($rawText, 200));
            }

            $questionsData = array_values(array_filter($questionsData, fn($qData) => $this->isValidGeneratedQuestion($qData)));

            if (count($questionsData) < $count) {
                throw new \Exception("AI response only contained " . count($questionsData) . " valid questions out of {$count} requested.");
            }

            $questionsData = array_slice($questionsData, 0, $count);

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

    /**
     * Parse Gemma's Markdown bullet-point response format into structured question objects.
     *
     * Handles output like:
     *  * Question 1: What is a computer?
     *  * Options: A) Electronic device, B) Mechanical device, C) ..., D) ...
     *  * Correct: A
     *  * Topic: Definition
     *  * Explanation: ...
     */
    private function parseMarkdownQuestions(string $rawText): array
    {
        $questions = [];

        // Split into lines and process
        $lines = explode("\n", $rawText);

        $currentQuestion = null;

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            // Strip leading bullet markers: *, -, •, numbers, bold formatting
            $clean = preg_replace('/^[\*\-•\s]+/', '', $line);
            $clean = trim($clean, '* ');
            $clean = preg_replace('/^\d+[\.\)]\s*/', '', $clean);

            // Question line: "Question N: text" or "*Question N (Topic):* text" or "Question: text"
            if (preg_match('/^Question\s*\d*\s*(?:\([^\)]+\))?\s*[:\-]\s*(.+)/i', $clean, $m)) {
                if ($currentQuestion && !empty($currentQuestion['question'])) {
                    $questions[] = $currentQuestion;
                }
                $qText = trim(trim($m[1]), '* ');
                $currentQuestion = [
                    'question'       => $qText,
                    'topic'          => '',
                    'options'        => [],
                    'correct_answer' => 'A',
                    'explanation'    => '',
                ];
                continue;
            }

            if (!$currentQuestion) continue;

            // Options line: "Options: A) text, B) text, C) text, D) text"
            if (preg_match('/^Options?\s*:\s*(.+)/i', $clean, $m)) {
                $optStr = $m[1];
                preg_match_all('/([A-D])\)\s*((?:(?![A-D]\)).)+)/i', $optStr, $optMatches, PREG_SET_ORDER);
                foreach ($optMatches as $om) {
                    $currentQuestion['options'][strtoupper($om[1])] = trim(rtrim(trim($om[2]), '.,'));
                }
                continue;
            }

            // Standalone option lines: "Option A: text" or "A) text" or "A: text"
            if (preg_match('/^(?:Option\s*)?([A-D])[\:\)]\s*(.+)/i', $clean, $m) && empty($currentQuestion['options'][strtoupper($m[1])])) {
                $currentQuestion['options'][strtoupper($m[1])] = trim(rtrim(trim($m[2]), '.,'));
                continue;
            }

            // Correct answer line: "Correct: A" or "Correct Answer: B"
            if (preg_match('/^Correct(?:\s+Answer)?\s*[:\-]\s*([A-D])/i', $clean, $m)) {
                $currentQuestion['correct_answer'] = strtoupper($m[1]);
                continue;
            }

            // Topic line
            if (preg_match('/^Topic\s*:\s*(.+)/i', $clean, $m)) {
                $currentQuestion['topic'] = trim(trim($m[1]), '* ');
                continue;
            }

            // Explanation line
            if (preg_match('/^Explanation\s*:\s*(.+)/i', $clean, $m)) {
                $currentQuestion['explanation'] = trim(trim($m[1]), '* ');
                continue;
            }
        }

        // Flush last question
        if ($currentQuestion && !empty($currentQuestion['question'])) {
            $questions[] = $currentQuestion;
        }

        // Only return questions that have at least 2 options and a question text
        return array_values(array_filter($questions, fn($q) =>
            !empty($q['question']) && count($q['options'] ?? []) >= 2
        ));
    }

    private function isValidGeneratedQuestion(mixed $qData): bool
    {
        if (!is_array($qData)) {
            return false;
        }

        $questionText = trim((string) ($qData['question'] ?? ''));
        $correctKey = strtoupper(trim((string) ($qData['correct_answer'] ?? '')));
        $options = $qData['options'] ?? [];

        if ($this->isPlaceholderText($questionText) || !in_array($correctKey, ['A', 'B', 'C', 'D'], true)) {
            return false;
        }

        if (!is_array($options)) {
            return false;
        }

        foreach (['A', 'B', 'C', 'D'] as $label) {
            if (!array_key_exists($label, $options) || $this->isPlaceholderText((string) $options[$label])) {
                return false;
            }
        }

        return true;
    }

    private function isPlaceholderText(string $value): bool
    {
        $value = trim($value);

        return $value === ''
            || $value === '...'
            || strcasecmp($value, 'question') === 0
            || strcasecmp($value, 'option') === 0
            || strcasecmp($value, 'first option text') === 0
            || strcasecmp($value, 'second option text') === 0
            || strcasecmp($value, 'third option text') === 0
            || strcasecmp($value, 'fourth option text') === 0;
    }
}
