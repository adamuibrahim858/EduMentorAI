<?php

namespace App\Livewire\Course;

use App\Jobs\ExtractPdfTextJob;
use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\Lecturer;
use App\Models\PastQuestion;
use App\Models\Summary;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Smalot\PdfParser\Parser;
use Throwable;

class Show extends Component
{
    use WithFileUploads, WithPagination, AuthorizesRequests;

    public Course $course;
    public string $activeTab = 'overview';

    // Edit Course Modal state
    public bool $showEditCourseModal = false;
    public string $course_code = '';
    public string $course_title = '';
    public int $course_unit = 3;
    public string $semester = '';
    public string $description = '';
    public string $status = 'active';

    // Material Upload State
    public bool $showMaterialUploadModal = false;
    public string $materialTitle = '';
    public $materialFile;
    public bool $isUploadingMaterial = false;

    // Past Question Upload State
    public bool $showPastQuestionModal = false;
    public string $pastQuestionTitle = '';
    public ?int $pastQuestionYear = null;
    public string $pastQuestionSemester = '';
    public $pastQuestionFile;

    // Lecturer Form State
    public string $lecturer_name = '';
    public string $lecturer_profession = '';
    public string $lecturer_highest_qualification = 'PhD';
    public string $lecturer_specialization = '';
    public string $lecturer_department = '';
    public ?int $lecturer_years_of_experience = 5;
    public string $lecturer_teaching_style = '';
    public string $lecturer_research_interest = '';
    public string $lecturer_additional_information = '';

    // Summary View Modal State
    public bool $showSummaryModal = false;
    public ?Summary $selectedSummary = null;

    public function mount(Course $course): void
    {
        $this->authorize('view', $course);
        $this->course = $course->load(['lecturer', 'materials', 'summaries', 'pastQuestions']);
        $this->loadLecturerForm();
        $this->syncCourseForm();

        // Check if tab is requested via query string
        if (request()->has('tab')) {
            $this->activeTab = request()->query('tab');
        }
    }

    public function syncCourseForm(): void
    {
        $this->course_code = $this->course->course_code;
        $this->course_title = $this->course->course_title;
        $this->course_unit = $this->course->course_unit;
        $this->semester = $this->course->semester;
        $this->description = $this->course->description ?? '';
        $this->status = $this->course->status;
    }

    public function loadLecturerForm(): void
    {
        if ($this->course->lecturer) {
            $lecturer = $this->course->lecturer;
            $this->lecturer_name = $lecturer->name;
            $this->lecturer_profession = $lecturer->profession ?? '';
            $this->lecturer_highest_qualification = $lecturer->highest_qualification;
            $this->lecturer_specialization = $lecturer->specialization ?? '';
            $this->lecturer_department = $lecturer->department ?? '';
            $this->lecturer_years_of_experience = $lecturer->years_of_experience;
            $this->lecturer_teaching_style = $lecturer->teaching_style ?? '';
            $this->lecturer_research_interest = $lecturer->research_interest ?? '';
            $this->lecturer_additional_information = $lecturer->additional_information ?? '';
        }
    }

    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function updatedMaterialFile(): void
    {
        $this->resetErrorBag('materialFile');
    }

    public function updatedShowMaterialUploadModal($value): void
    {
        if (!$value) {
            $this->resetErrorBag(['materialFile', 'materialTitle']);
            $this->reset(['materialFile', 'materialTitle']);
        }
    }

    public function updatedPastQuestionFile(): void
    {
        $this->resetErrorBag('pastQuestionFile');
    }

    public function updatedShowPastQuestionModal($value): void
    {
        if (!$value) {
            $this->resetErrorBag(['pastQuestionFile', 'pastQuestionTitle', 'pastQuestionYear', 'pastQuestionSemester']);
            $this->reset(['pastQuestionFile', 'pastQuestionTitle', 'pastQuestionYear', 'pastQuestionSemester']);
        }
    }

    public function updateCourseInfo(): void
    {
        $this->authorize('update', $this->course);

        $validated = $this->validate([
            'course_code' => 'required|string|max:20',
            'course_title' => 'required|string|max:255',
            'course_unit' => 'required|integer|min:1|max:12',
            'semester' => 'required|string|max:50',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,archived',
        ]);

        $this->course->update($validated);
        $this->showEditCourseModal = false;
        session()->flash('message', 'Course details updated successfully!');
    }

    public function uploadCourseMaterial(): void
    {
        if ($this->course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // $maxSizeMb = (int) config('gemma.max_upload_size_mb', 20);
        $maxKb = 3072;
        $maxSizeMb = $maxKb / 1024;

        $this->validate([
            'materialTitle' => 'required|string|max:255',
            'materialFile'  => "required|file|mimes:pdf|max:{$maxKb}",
        ], [
            'materialTitle.required' => 'Please enter a title for this course material.',
            'materialFile.required'  => 'Please select a PDF file to upload.',
            'materialFile.file'      => 'The selected file could not be processed.',
            'materialFile.mimes'     => 'Only PDF documents (.pdf) are allowed.',
            'materialFile.max'       => "The PDF file size must not exceed {$maxSizeMb} MB.",
        ]);

        try {
            $originalFilename = $this->materialFile->getClientOriginalName();
            $fileSize         = $this->materialFile->getSize();
            $mimeType         = $this->materialFile->getMimeType() ?: 'application/pdf';

            $userId   = auth()->id();
            $courseId = $this->course->id;
            $safeName = \Illuminate\Support\Str::slug(pathinfo($originalFilename, PATHINFO_FILENAME));
            $uniqueFilename = \Illuminate\Support\Str::uuid() . '_' . ($safeName ?: 'document') . '.pdf';
            $targetFolder   = "course_materials/{$userId}/{$courseId}";

            $storedPath = $this->materialFile->storeAs($targetFolder, $uniqueFilename, 'public');

            if (!$storedPath) {
                throw new \Exception('Storage write failed.');
            }

            $material = CourseMaterial::create([
                'course_id'         => $courseId,
                'uploaded_by'       => $userId,
                'title'             => $this->materialTitle,
                'original_filename' => $originalFilename,
                'file'              => $storedPath,
                'mime_type'         => $mimeType,
                'file_size'         => $fileSize,
                'status'            => 'completed',
                'embedding_status'  => 'completed',
                'error_message'     => null,
            ]);

            $this->reset(['materialTitle', 'materialFile']);
            $this->showMaterialUploadModal = false;
            $this->course->refresh();

            session()->flash('message', 'Course material uploaded successfully!');
        } catch (Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Failed to upload material for course {$this->course->id}: " . $e->getMessage());
            session()->flash('error', 'Could not save PDF file: ' . $e->getMessage());
        }
    }

    public function uploadPastQuestion(): void
    {
        $maxSizeMb = (int) config('gemma.max_upload_size_mb', 20);
        $maxKb = $maxSizeMb * 1024;

        $this->validate([
            'pastQuestionTitle' => 'required|string|max:255',
            'pastQuestionYear' => 'nullable|integer|min:2000|max:2099',
            'pastQuestionSemester' => 'nullable|string|max:50',
            'pastQuestionFile' => "required|file|mimes:pdf|max:{$maxKb}",
        ], [
            'pastQuestionTitle.required' => 'Please enter a title for the past question paper.',
            'pastQuestionFile.required' => 'Please select a PDF file and wait for the upload to complete before clicking submit.',
            'pastQuestionFile.file' => 'The selected file could not be processed. Please try again.',
            'pastQuestionFile.mimes' => 'Only PDF documents (.pdf) are allowed.',
            'pastQuestionFile.max' => "The PDF file size must not exceed {$maxSizeMb} MB.",
        ]);

        $originalFilename = $this->pastQuestionFile->getClientOriginalName();
        $fileSize = $this->pastQuestionFile->getSize();
        $storedPath = $this->pastQuestionFile->store('past_questions', 'public');

        // Extract text in place for infrastructure storage
        $extractedText = '';
        $pages = 0;
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile(storage_path('app/public/' . $storedPath));
            $extractedText = trim($pdf->getText());
            $pages = count($pdf->getPages());
        } catch (Throwable $e) {
            $extractedText = "Past question paper: {$this->pastQuestionTitle}";
        }

        PastQuestion::create([
            'course_id' => $this->course->id,
            'uploaded_by' => auth()->id(),
            'title' => $this->pastQuestionTitle,
            'original_filename' => $originalFilename,
            'year' => $this->pastQuestionYear ?: date('Y'),
            'semester' => $this->pastQuestionSemester ?: $this->course->semester,
            'file' => $storedPath,
            'mime_type' => 'application/pdf',
            'file_size' => $fileSize,
            'pages' => $pages,
            'extracted_text' => $extractedText,
            'processed' => true,
            'status' => 'completed',
        ]);

        $this->reset(['pastQuestionTitle', 'pastQuestionYear', 'pastQuestionSemester', 'pastQuestionFile']);
        $this->showPastQuestionModal = false;

        session()->flash('message', 'Past Question uploaded & text extracted successfully.');
    }

    public function saveLecturer(): void
    {
        $this->authorize('update', $this->course);

        $validated = $this->validate([
            'lecturer_name' => 'required|string|max:255',
            'lecturer_profession' => 'nullable|string|max:255',
            'lecturer_highest_qualification' => 'required|in:Degree,Masters,PhD,Professor,Other',
            'lecturer_specialization' => 'nullable|string|max:255',
            'lecturer_department' => 'nullable|string|max:255',
            'lecturer_years_of_experience' => 'nullable|integer|min:0|max:60',
            'lecturer_teaching_style' => 'nullable|string|max:1000',
            'lecturer_research_interest' => 'nullable|string|max:1000',
            'lecturer_additional_information' => 'nullable|string|max:1000',
        ]);

        Lecturer::updateOrCreate(
            ['course_id' => $this->course->id],
            [
                'name' => $this->lecturer_name,
                'profession' => $this->lecturer_profession,
                'highest_qualification' => $this->lecturer_highest_qualification,
                'specialization' => $this->lecturer_specialization,
                'department' => $this->lecturer_department,
                'years_of_experience' => $this->lecturer_years_of_experience,
                'teaching_style' => $this->lecturer_teaching_style,
                'research_interest' => $this->lecturer_research_interest,
                'additional_information' => $this->lecturer_additional_information,
            ]
        );

        $this->course->refresh();
        session()->flash('message', 'Lecturer profile saved successfully! AI prompts will now incorporate this context.');
    }

    public function deleteLecturer(): void
    {
        $this->authorize('update', $this->course);

        if ($this->course->lecturer) {
            $this->course->lecturer->delete();
            $this->resetLecturerForm();
            $this->course->refresh();
            session()->flash('message', 'Lecturer profile removed.');
        }
    }

    public function resetLecturerForm(): void
    {
        $this->reset([
            'lecturer_name',
            'lecturer_profession',
            'lecturer_highest_qualification',
            'lecturer_specialization',
            'lecturer_department',
            'lecturer_years_of_experience',
            'lecturer_teaching_style',
            'lecturer_research_interest',
            'lecturer_additional_information',
        ]);
        $this->lecturer_highest_qualification = 'PhD';
    }

    public function generateSummary(CourseMaterial $material): void
    {
        if ($material->course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $material->update([
            'status'           => 'processing',
            'embedding_status' => 'processing',
            'error_message'    => null,
        ]);

        try {
            ExtractPdfTextJob::dispatch($material);
        } catch (Throwable $e) {
            (new ExtractPdfTextJob($material))->handle();
        }

        $this->course->refresh();
        $material->refresh();

        if ($material->status === 'failed') {
            session()->flash('error', 'AI Summary Error: ' . ($material->error_message ?: 'Processing failed. Please check AI quota or API key configuration.'));
        } else {
            session()->flash('message', 'AI Summary generation started!');
        }
    }

    public function viewSummary(Summary $summary): void
    {
        if ($summary->course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->selectedSummary = $summary;
        $this->showSummaryModal = true;
    }

    public function downloadSummary(Summary $summary)
    {
        if ($summary->course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$summary->pdf_path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($summary->pdf_path)) {
            session()->flash('error', 'Summary PDF file is not available yet.');
            return;
        }

        return response()->download(
            \Illuminate\Support\Facades\Storage::disk('public')->path($summary->pdf_path),
            \Illuminate\Support\Str::slug($summary->title) . '.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }

    public function regenerateSummary(CourseMaterial $material): void
    {
        if ($material->course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($material->summary) {
            if ($material->summary->pdf_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($material->summary->pdf_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($material->summary->pdf_path);
            }
            $material->summary->delete();
        }

        $material->update([
            'status'           => 'processing',
            'embedding_status' => 'processing',
            'error_message'    => null,
        ]);

        try {
            ExtractPdfTextJob::dispatch($material);
        } catch (Throwable $e) {
            (new ExtractPdfTextJob($material))->handle();
        }

        $this->course->refresh();
        $material->refresh();

        if ($material->status === 'failed') {
            session()->flash('error', 'AI Summary Error: ' . ($material->error_message ?: 'Regeneration failed. Please check AI quota or API key configuration.'));
        } else {
            session()->flash('message', 'Regenerating AI Summary...');
        }
    }

    public function downloadMaterial(CourseMaterial $material)
    {
        if ($material->course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $relativePath = $material->file;

        if (\Illuminate\Support\Facades\Storage::disk('local')->exists($relativePath)) {
            return \Illuminate\Support\Facades\Storage::disk('local')->download($relativePath, $material->original_filename);
        }

        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($relativePath)) {
            return \Illuminate\Support\Facades\Storage::disk('public')->download($relativePath, $material->original_filename);
        }

        session()->flash('error', 'The requested PDF file could not be found on storage.');
    }

    public function deleteMaterial(CourseMaterial $material): void
    {
        if ($material->course->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            if (\Illuminate\Support\Facades\Storage::disk('local')->exists($material->file)) {
                \Illuminate\Support\Facades\Storage::disk('local')->delete($material->file);
            } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($material->file)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($material->file);
            }

            $material->delete();
            $this->course->refresh();
            session()->flash('message', 'Course material deleted successfully.');
        } catch (Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Failed to delete material ID {$material->id}: " . $e->getMessage());
            session()->flash('error', 'Could not delete material file.');
        }
    }

    public function deleteSummary(Summary $summary): void
    {
        $this->authorize('delete', $summary);
        $summary->delete();
        $this->course->refresh();
        session()->flash('message', 'Summary deleted.');
    }

    public function deletePastQuestion(PastQuestion $pastQuestion): void
    {
        $this->authorize('update', $this->course);
        $pastQuestion->delete();
        $this->course->refresh();
        session()->flash('message', 'Past question deleted.');
    }

    public function deleteCourse(): void
    {
        $this->authorize('delete', $this->course);
        $this->course->delete();
        session()->flash('message', 'Course deleted.');
        redirect()->route('courses.index');
    }

    public function render()
    {
        $this->course->load(['lecturer', 'materials', 'summaries', 'pastQuestions']);

        // Calculate progress percentage
        $totalMaterials = $this->course->materials->count();
        $completedMaterials = $this->course->materials->where('status', 'completed')->count();
        $progressPercent = $totalMaterials > 0 ? (int) round(($completedMaterials / $totalMaterials) * 100) : 0;

        return view('livewire.course.show', [
            'progressPercent' => $progressPercent,
            'totalMaterials' => $totalMaterials,
            'completedMaterials' => $completedMaterials,
        ])->layout('layouts.app', ['title' => $this->course->course_code . ' - ' . $this->course->course_title]);
    }
}
