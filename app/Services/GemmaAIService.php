<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class GemmaAIService
{
    protected string $apiKey;
    protected string $model;
    protected string $fallbackModel;
    protected string $endpoint;
    protected int $timeout;

    public function __construct()
    {
        $this->apiKey = config('gemma.api_key', env('GEMMA_AI_API_KEY', ''));
        $this->model = config('gemma.model', 'gemma-4-31b-it');
        $this->fallbackModel = config('gemma.fallback_model', 'gemma-4-26b-a4b-it');
        $this->endpoint = rtrim(config('gemma.endpoint', 'https://generativelanguage.googleapis.com/v1beta/models'), '/');
        $this->timeout = (int) config('gemma.timeout', 60);
    }

    /**
     * Summarize academic course material document using Gemma AI.
     */
    public function summarizeDocument(string $extractedText, ?array $lecturerInfo = null): array
    {
        $lecturerContext = '';
        if (!empty($lecturerInfo)) {
            $lecturerContext = "LECTURER PROFILE CONTEXT:\n";
            if (!empty($lecturerInfo['name'])) $lecturerContext .= "- Lecturer Name: {$lecturerInfo['name']}\n";
            if (!empty($lecturerInfo['profession'])) $lecturerContext .= "- Profession: {$lecturerInfo['profession']}\n";
            if (!empty($lecturerInfo['highest_qualification'])) $lecturerContext .= "- Highest Qualification: {$lecturerInfo['highest_qualification']}\n";
            if (!empty($lecturerInfo['specialization'])) $lecturerContext .= "- Discipline/Specialization: {$lecturerInfo['specialization']}\n";
            if (!empty($lecturerInfo['department'])) $lecturerContext .= "- Department: {$lecturerInfo['department']}\n";
            if (!empty($lecturerInfo['years_of_experience'])) $lecturerContext .= "- Years of Experience: {$lecturerInfo['years_of_experience']} years\n";
            if (!empty($lecturerInfo['teaching_style'])) $lecturerContext .= "- Teaching Style: {$lecturerInfo['teaching_style']}\n";
            if (!empty($lecturerInfo['research_interest'])) $lecturerContext .= "- Research Interest: {$lecturerInfo['research_interest']}\n";
            if (!empty($lecturerInfo['additional_information'])) $lecturerContext .= "- Additional Notes: {$lecturerInfo['additional_information']}\n";
            $lecturerContext .= "Please tailor the focus, tone, and emphasis of the summary to align with this lecturer's background and teaching style.\n\n";
        }

        $prompt = <<<PROMPT
You are an expert university lecturer and academic AI assistant.

{$lecturerContext}Read the following course material content carefully and generate a comprehensive, highly structured academic summary.

The summary MUST strictly include the following 8 sections with clear Markdown headers (##):

1. Overview
2. Important Concepts
3. Key Definitions
4. Important Formulae
5. Examples
6. Important Points
7. Possible Examination Areas
8. Revision Tips

Return ONLY clean, structured Markdown format without meta-talk or introductory conversational filler.

--- COURSE MATERIAL TEXT ---
{$extractedText}
PROMPT;

        return $this->generateContent($prompt);
    }

    /**
     * Generate practice multiple-choice questions from content.
     */
    public function generatePracticeQuestions(string $content, int $count = 5): array
    {
        $prompt = "You are an expert examiner. Generate {$count} multiple-choice questions (with options A, B, C, D and explanation for correct answer) based on this material:\n\n{$content}\n\nReturn structured Markdown format.";
        return $this->generateContent($prompt);
    }

    /**
     * Generate essay questions from content.
     */
    public function generateEssayQuestions(string $content, int $count = 3): array
    {
        $prompt = "You are an expert examiner. Generate {$count} university-level essay/structural questions with model solutions based on this material:\n\n{$content}\n\nReturn structured Markdown format.";
        return $this->generateContent($prompt);
    }

    /**
     * Interactive study chat assistant.
     */
    public function chat(array $messages, ?string $context = null): array
    {
        $systemContext = $context ? "System Context / Course Material:\n{$context}\n\n" : "";
        
        $prompt = "{$systemContext}Conversation history:\n";
        foreach ($messages as $msg) {
            $role = ucfirst($msg['role'] ?? 'user');
            $text = $msg['content'] ?? '';
            $prompt .= "{$role}: {$text}\n";
        }
        $prompt .= "\nAssistant:";

        return $this->generateContent($prompt);
    }

    /**
     * Analyze past examination questions.
     */
    public function analyzePastQuestions(string $extractedText): array
    {
        $prompt = "Analyze these university past examination questions. Identify key themes, topic frequency, common question types, and recurring exam concepts:\n\n{$extractedText}\n\nReturn clean structured Markdown analysis.";
        return $this->generateContent($prompt);
    }

    /**
     * Extract key topics and curriculum outline.
     */
    public function extractTopics(string $extractedText): array
    {
        $prompt = "Extract a clean list of core topics, subtopics, and key learning modules from this course material:\n\n{$extractedText}\n\nReturn clean bulleted Markdown format.";
        return $this->generateContent($prompt);
    }

    /**
     * Generic API caller for Gemma / Gemini API.
     */
    protected function generateContent(string $prompt, ?string $targetModel = null): array
    {
        if (empty($this->apiKey)) {
            Log::warning('GemmaAIService: GEMMA_AI_API_KEY is not configured in .env file.');
            return [
                'success' => false,
                'data' => null,
                'error' => 'Gemma AI API key is missing. Please set GEMMA_AI_API_KEY in .env file.'
            ];
        }

        $activeModel = $targetModel ?: $this->model;
        $url = "{$this->endpoint}/{$activeModel}:generateContent?key={$this->apiKey}";

        try {
            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.4,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 8192,
                ]
            ];

            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($url, $payload);

            if ($response->successful()) {
                $responseData = $response->json();
                $generatedText = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? null;

                if (empty($generatedText)) {
                    Log::warning('GemmaAIService: Received empty response from API.', ['response' => $responseData]);
                    return [
                        'success' => false,
                        'data' => null,
                        'error' => 'AI Service returned an empty response.'
                    ];
                }

                return [
                    'success' => true,
                    'data' => trim($generatedText),
                    'model' => $activeModel,
                    'error' => null
                ];
            }

            // If rate limited (429), handle gracefully without endless retries
            if ($response->status() === 429) {
                Log::warning("GemmaAIService: Rate limit exceeded (429) on model {$activeModel}.");
                return [
                    'success' => false,
                    'data' => null,
                    'error' => 'Google Gemini API rate limit reached (HTTP 429). Please wait a few seconds and try again.'
                ];
            }

            // If primary model failed (e.g., 404 or unsupported model name), retry with fallback model if available
            if ($activeModel !== $this->fallbackModel && ($response->status() === 404 || $response->status() === 400)) {
                Log::info("GemmaAIService: Primary model {$activeModel} returned status {$response->status()}. Retrying with fallback {$this->fallbackModel}.");
                return $this->generateContent($prompt, $this->fallbackModel);
            }

            $errorMessage = $response->json('error.message') ?? "HTTP {$response->status()}: " . $response->body();
            Log::error('GemmaAIService API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [
                'success' => false,
                'data' => null,
                'error' => "Gemma AI API Error ({$response->status()}): {$errorMessage}"
            ];

        } catch (Throwable $e) {
            Log::error('GemmaAIService Exception', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'data' => null,
                'error' => 'AI Service Connection Exception: ' . $e->getMessage()
            ];
        }
    }
}
