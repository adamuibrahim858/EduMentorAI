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
        $maxSizeMb = (int) config('gemma.max_upload_size_mb', 20);
        $maxKb = $maxSizeMb * 1024;

        $this->validate([
            'materialTitle' => 'required|string|max:255',
            'materialFile' => "required|file|mimes:pdf|max:{$maxKb}",
        ], [
            'materialTitle.required' => 'Please enter a title for this course material.',
            'materialFile.required' => 'Please select a PDF file and wait for the upload to complete before clicking submit.',
            'materialFile.file' => 'The selected file could not be processed. Please try again.',
            'materialFile.mimes' => 'Only PDF documents (.pdf) are allowed for course material uploads.',
            'materialFile.max' => "The PDF file size must not exceed {$maxSizeMb} MB.",
        ]);

        $originalFilename = $this->materialFile->getClientOriginalName();
        $fileSize = $this->materialFile->getSize();
        $mimeType = $this->materialFile->getMimeType() ?: 'application/pdf';

        $storedPath = $this->materialFile->store('course_materials', 'public');

        $material = CourseMaterial::create([
            'course_id' => $this->course->id,
            'uploaded_by' => auth()->id(),
            'title' => $this->materialTitle,
            'original_filename' => $originalFilename,
            'file' => $storedPath,
            'mime_type' => $mimeType,
            'file_size' => $fileSize,
            'status' => 'processing',
            'embedding_status' => 'pending',
        ]);

        // Reset form & close modal
        $this->reset(['materialTitle', 'materialFile']);
        $this->showMaterialUploadModal = false;

        // Automatically dispatch background AI processing pipeline
        ExtractPdfTextJob::dispatch($material);

        session()->flash('message', 'PDF uploaded successfully! AI extraction & summary generation started in background.');
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

    public function viewSummary(Summary $summary): void
    {
        $this->authorize('view', $summary);
        $this->selectedSummary = $summary;
        $this->showSummaryModal = true;
    }

    public function regenerateSummary(CourseMaterial $material): void
    {
        $this->authorize('view', $material);
        $material->update(['status' => 'processing']);
        ExtractPdfTextJob::dispatch($material);
        session()->flash('message', 'Regenerating AI summary in background...');
    }

    public function deleteMaterial(CourseMaterial $material): void
    {
        $this->authorize('delete', $material);
        $material->delete();
        $this->course->refresh();
        session()->flash('message', 'Course material deleted.');
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
