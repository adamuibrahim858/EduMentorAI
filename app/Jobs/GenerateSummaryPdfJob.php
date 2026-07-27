<?php

namespace App\Jobs;

use App\Models\Summary;
use App\Notifications\SummaryFailedNotification;
use App\Notifications\SummaryReadyNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class GenerateSummaryPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 300;

    public function __construct(public Summary $summary)
    {
    }

    public function handle(): void
    {
        try {
            $material = $this->summary->material;
            $course = $this->summary->course;

            if ($material) {
                $material->update([
                    'status' => 'generating_pdf',
                ]);
            }

            // Ensure public storage dir exists
            if (!Storage::disk('public')->exists('summaries')) {
                Storage::disk('public')->makeDirectory('summaries');
            }

            $fileName = 'summaries/summary_' . $this->summary->id . '_' . time() . '.pdf';

            // Generate DomPDF document
            $pdf = Pdf::loadView('pdf.summary', [
                'summary' => $this->summary,
                'course' => $course,
                'material' => $material,
            ])
            ->setPaper('a4', 'portrait')
            ->setWarnings(false);

            Storage::disk('public')->put($fileName, $pdf->output());

            $this->summary->update([
                'pdf_path' => $fileName,
            ]);

            if ($material) {
                $material->update([
                    'status' => 'completed',
                    'embedding_status' => 'completed',
                    'processed_at' => now(),
                ]);

                if ($material->uploader) {
                    $material->uploader->notify(new SummaryReadyNotification($this->summary));
                }
            }

            Log::info("GenerateSummaryPdfJob completed successfully for Summary ID: {$this->summary->id}, PDF: {$fileName}");

        } catch (Throwable $e) {
            Log::error("GenerateSummaryPdfJob Failed for Summary ID {$this->summary->id}: " . $e->getMessage());

            if ($this->summary->material) {
                $this->summary->material->update([
                    'status' => 'failed',
                    'error_message' => 'PDF generation error: ' . $e->getMessage(),
                ]);

                if ($this->summary->material->uploader) {
                    $this->summary->material->uploader->notify(
                        new SummaryFailedNotification($this->summary->material, $e->getMessage())
                    );
                }
            }
        }
    }
}
