<?php

namespace App\Jobs;

use App\Models\CourseMaterial;
use App\Models\Summary;
use App\Services\GemmaAIService;
use App\Notifications\SummaryFailedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class GenerateSummaryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;

    public function __construct(public CourseMaterial $material)
    {
    }

    public function handle(GemmaAIService $gemmaAIService): void
    {
        try {
            $this->material->update([
                'status' => 'generating_summary',
            ]);

            $course = $this->material->course;
            $lecturer = $course ? $course->lecturer : null;

            $lecturerInfo = null;
            if ($lecturer) {
                $lecturerInfo = [
                    'name' => $lecturer->name,
                    'profession' => $lecturer->profession,
                    'highest_qualification' => $lecturer->highest_qualification,
                    'specialization' => $lecturer->specialization,
                    'department' => $lecturer->department,
                    'years_of_experience' => $lecturer->years_of_experience,
                    'teaching_style' => $lecturer->teaching_style,
                    'research_interest' => $lecturer->research_interest,
                    'additional_information' => $lecturer->additional_information,
                ];
            }

            $extractedText = $this->material->extracted_text ?: $this->material->title;

            // Limit text sent to API if massive, or pass full text
            $textForAi = Str::limit($extractedText, 25000);

            $result = $gemmaAIService->summarizeDocument($textForAi, $lecturerInfo);

            if (!$result['success'] || empty($result['data'])) {
                throw new \Exception($result['error'] ?? 'Gemma AI returned invalid response.');
            }

            $markdownContent = $result['data'];
            $htmlContent = Str::markdown($markdownContent);
            $plainText = strip_tags($htmlContent);

            $summary = Summary::updateOrCreate(
                [
                    'material_id' => $this->material->id,
                ],
                [
                    'course_id' => $this->material->course_id,
                    'title' => "Academic Summary: " . $this->material->title,
                    'summary' => $markdownContent,
                    'html_content' => $htmlContent,
                    'plain_text' => $plainText,
                    'summary_type' => 'detailed',
                    'difficulty' => 'medium',
                    'generated_by' => 'Gemma-4-AI',
                    'ai_model' => 'gemma-4-31b-it',
                    'prompt_version' => 'v1.0',
                ]
            );

            $this->material->update([
                'status' => 'generating_pdf',
            ]);

            Log::info("GenerateSummaryJob completed for material ID: {$this->material->id}, Summary ID: {$summary->id}");

            // Dispatch Next Job in Workflow
            GenerateSummaryPdfJob::dispatch($summary);

        } catch (Throwable $e) {
            Log::error("GenerateSummaryJob Failed for Material ID {$this->material->id}: " . $e->getMessage());

            $this->material->update([
                'status' => 'failed',
                'error_message' => 'AI Summary generation error: ' . $e->getMessage(),
            ]);

            if ($this->material->uploader) {
                $this->material->uploader->notify(new SummaryFailedNotification($this->material, $e->getMessage()));
            }
        }
    }
}
