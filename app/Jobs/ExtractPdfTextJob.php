<?php

namespace App\Jobs;

use App\Models\CourseMaterial;
use App\Models\DocumentChunk;
use App\Notifications\ProcessingStartedNotification;
use App\Notifications\SummaryFailedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use Throwable;

class ExtractPdfTextJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;

    public function __construct(public CourseMaterial $material)
    {
    }

    public function handle(): void
    {
        try {
            $this->material->update([
                'status' => 'processing',
                'embedding_status' => 'processing',
            ]);

            if ($this->material->uploader) {
                $this->material->uploader->notify(new ProcessingStartedNotification($this->material));
            }

            // Determine absolute path to file
            $relativeFile = $this->material->file;
            $fullPath = Storage::disk('public')->exists($relativeFile)
                ? Storage::disk('public')->path($relativeFile)
                : storage_path('app/' . $relativeFile);

            if (!file_exists($fullPath)) {
                throw new \Exception("File not found on storage at path: {$relativeFile}");
            }

            try {
                $parser = new Parser();
                $pdf = $parser->parseFile($fullPath);
                $extractedText = trim($pdf->getText());
                $pagesCount = count($pdf->getPages());
            } catch (Throwable $pe) {
                Log::warning("PdfParser failed for material ID {$this->material->id}: " . $pe->getMessage());
                $extractedText = "";
                $pagesCount = 1;
            }

            if (empty($extractedText)) {
                // Fallback text if scanned/image PDF or parsing exception
                $extractedText = "Course Material Title: {$this->material->title}.\nPlease generate a comprehensive academic study guide and outline for this course material topic based on standard university curriculum.";
            }

            $wordCount = str_word_count($extractedText);

            $this->material->update([
                'extracted_text' => $extractedText,
                'pages' => $pagesCount,
                'total_words' => $wordCount,
                'status' => 'generating_summary',
            ]);

            // Save chunk information (1500 words per chunk)
            $words = explode(' ', $extractedText);
            $chunkSize = 1500;
            $chunks = array_chunk($words, $chunkSize);

            // Delete old chunks if any
            $this->material->chunks()->delete();

            foreach ($chunks as $index => $chunkWords) {
                $chunkContent = implode(' ', $chunkWords);
                DocumentChunk::create([
                    'material_id' => $this->material->id,
                    'chunk_number' => $index + 1,
                    'content' => $chunkContent,
                    'token_count' => count($chunkWords),
                ]);
            }

            Log::info("ExtractPdfTextJob successfully processed material ID: {$this->material->id}");

            // Dispatch Next Job in Workflow
            GenerateSummaryJob::dispatch($this->material);

        } catch (Throwable $e) {
            Log::error("ExtractPdfTextJob Failed for Material ID {$this->material->id}: " . $e->getMessage());

            $this->material->update([
                'status' => 'failed',
                'embedding_status' => 'failed',
                'error_message' => 'Text extraction error: ' . $e->getMessage(),
            ]);

            if ($this->material->uploader) {
                $this->material->uploader->notify(new SummaryFailedNotification($this->material, $e->getMessage()));
            }
        }
    }
}
