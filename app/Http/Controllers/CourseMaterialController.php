<?php

namespace App\Http\Controllers;

use App\Jobs\ExtractPdfTextJob;
use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class CourseMaterialController extends Controller
{
    /**
     * Upload a course material PDF.
     * Standard HTTP multipart POST — no Livewire file upload involved.
     */
    public function upload(Request $request, Course $course)
    {
        // Only course owner may upload
        if ($course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized.');
        }

        // Check for PHP upload errors before validation
        if ($request->hasFile('material_file') && !$request->file('material_file')->isValid()) {
            $errorCode = $request->file('material_file')->getError();
            $errorMsg = match ($errorCode) {
                UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'The PDF file size exceeds the server upload limit.',
                UPLOAD_ERR_PARTIAL => 'The file was only partially uploaded. Please try again.',
                UPLOAD_ERR_NO_FILE => 'No file was selected or the upload was cancelled.',
                default => 'File upload error (Code: ' . $errorCode . ').',
            };

            return redirect()
                ->route('courses.show', $course)
                ->withInput()
                ->with('error', $errorMsg);
        }

        $request->validate([
            'title'         => 'required|string|max:255',
            'material_file' => 'required|file|mimes:pdf|max:20480',
        ], [
            'title.required'         => 'Please enter a title for this course material.',
            'material_file.required' => 'Please select a PDF file to upload.',
            'material_file.mimes'    => 'Only PDF documents (.pdf) are allowed.',
            'material_file.max'      => 'The PDF file must not exceed 20 MB.',
        ]);

        try {
            $file     = $request->file('material_file');
            $userId   = auth()->id();
            $courseId = $course->id;

            $safeName       = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $uniqueFilename = Str::uuid() . '_' . ($safeName ?: 'document') . '.pdf';
            $targetFolder   = "course_materials/{$userId}/{$courseId}";

            $storedPath = $file->storeAs($targetFolder, $uniqueFilename, 'public');

            if (!$storedPath) {
                throw new \Exception('Storage write failed.');
            }

            $material = CourseMaterial::create([
                'course_id'         => $courseId,
                'uploaded_by'       => $userId,
                'title'             => $request->input('title'),
                'original_filename' => $file->getClientOriginalName(),
                'file'              => $storedPath,
                'mime_type'         => $file->getMimeType() ?: 'application/pdf',
                'file_size'         => $file->getSize(),
                'status'            => 'processing',
                'embedding_status'  => 'pending',
                'error_message'     => null,
            ]);

            try {
                ExtractPdfTextJob::dispatch($material);
                $message = 'PDF uploaded successfully! AI extraction and summary generation started in background.';
            } catch (Throwable $queueException) {
                Log::error("Failed to dispatch PDF processing for material {$material->id}: " . $queueException->getMessage());

                $material->update([
                    'status' => 'failed',
                    'embedding_status' => 'failed',
                    'error_message' => 'PDF saved, but AI processing could not be queued: ' . $queueException->getMessage(),
                ]);

                $message = 'PDF uploaded successfully, but AI processing could not be queued. You can retry from the material card.';
            }

            return redirect()
                ->route('courses.show', $course)
                ->with('message', $message);

        } catch (Throwable $e) {
            Log::error("CourseMaterial upload failed for Course#{$course->id}: " . $e->getMessage());

            return redirect()
                ->route('courses.show', $course)
                ->withInput()
                ->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    /**
     * Download a course material PDF.
     */
    public function download(CourseMaterial $material)
    {
        if ($material->course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized.');
        }

        $path = $material->file;

        if (Storage::disk('local')->exists($path)) {
            return Storage::disk('local')->download($path, $material->original_filename);
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->download($path, $material->original_filename);
        }

        return redirect()->back()->with('error', 'File not found on storage.');
    }

    /**
     * Delete a course material — removes DB record and PDF file from disk.
     */
    public function destroy(CourseMaterial $material)
    {
        if ($material->course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized.');
        }

        $course = $material->course;

        try {
            if (Storage::disk('local')->exists($material->file)) {
                Storage::disk('local')->delete($material->file);
            } elseif (Storage::disk('public')->exists($material->file)) {
                Storage::disk('public')->delete($material->file);
            }

            $material->delete();

            return redirect()
                ->route('courses.show', $course)
                ->with('message', 'Course material deleted successfully.');

        } catch (Throwable $e) {
            Log::error("CourseMaterial delete failed for Material#{$material->id}: " . $e->getMessage());

            return redirect()
                ->route('courses.show', $course)
                ->with('error', 'Delete failed. Please try again.');
        }
    }
}
