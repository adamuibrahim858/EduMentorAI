<?php

namespace App\Http\Controllers;

use App\Models\Summary;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class SummaryController extends Controller
{
    use AuthorizesRequests;

    public function download(Summary $summary)
    {
        $this->authorize('view', $summary);

        if (!$summary->pdf_path || !Storage::disk('public')->exists($summary->pdf_path)) {
            abort(404, 'Summary PDF file not found.');
        }

        $filePath = Storage::disk('public')->path($summary->pdf_path);
        $fileName = \Illuminate\Support\Str::slug($summary->title) . '.pdf';

        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function preview(Summary $summary)
    {
        $this->authorize('view', $summary);

        if (!$summary->pdf_path || !Storage::disk('public')->exists($summary->pdf_path)) {
            abort(404, 'Summary PDF file not found.');
        }

        $filePath = Storage::disk('public')->path($summary->pdf_path);

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . \Illuminate\Support\Str::slug($summary->title) . '.pdf"',
        ]);
    }
}
