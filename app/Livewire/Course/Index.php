<?php

namespace App\Livewire\Course;

use App\Models\Course;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, AuthorizesRequests;

    public string $search = '';
    public string $semesterFilter = '';
    public string $statusFilter = '';

    // Create / Edit modal state
    public bool $showModal = false;
    public ?int $editingCourseId = null;

    public string $course_code = '';
    public string $course_title = '';
    public int $course_unit = 3;
    public string $semester = 'First Semester';
    public string $description = '';
    public string $status = 'active';

    protected function rules(): array
    {
        return [
            'course_code' => 'required|string|max:20',
            'course_title' => 'required|string|max:255',
            'course_unit' => 'required|integer|min:1|max:12',
            'semester' => 'required|string|max:50',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,archived',
        ];
    }

    public function openCreateModal(): void
    {
        $this->reset(['editingCourseId', 'course_code', 'course_title', 'course_unit', 'semester', 'description', 'status']);
        $this->course_unit = 3;
        $this->semester = 'First Semester';
        $this->status = 'active';
        $this->showModal = true;
    }

    public function openEditModal(Course $course): void
    {
        $this->authorize('update', $course);

        $this->editingCourseId = $course->id;
        $this->course_code = $course->course_code;
        $this->course_title = $course->course_title;
        $this->course_unit = $course->course_unit;
        $this->semester = $course->semester;
        $this->description = $course->description ?? '';
        $this->status = $course->status;
        $this->showModal = true;
    }

    public function saveCourse()
    {
        $validated = $this->validate();

        if ($this->editingCourseId) {
            $course = Course::findOrFail($this->editingCourseId);
            $this->authorize('update', $course);
            $course->update($validated);
            session()->flash('message', 'Course updated successfully!');
            $this->showModal = false;
        } else {
            $validated['user_id'] = auth()->id();
            $course = Course::create($validated);
            session()->flash('message', 'Course created successfully!');
            $this->showModal = false;

            // Immediately redirect to Course Detail Page
            return redirect()->route('courses.show', $course->id);
        }
    }

    public function deleteCourse(Course $course): void
    {
        $this->authorize('delete', $course);
        $course->delete();
        session()->flash('message', 'Course deleted successfully.');
    }

    public function render()
    {
        $query = auth()->user()->courses()
            ->withCount(['materials', 'summaries', 'pastQuestions']);

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('course_code', 'like', '%' . $this->search . '%')
                  ->orWhere('course_title', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->semesterFilter)) {
            $query->where('semester', $this->semesterFilter);
        }

        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        $courses = $query->orderBy('created_at', 'desc')->paginate(9);

        return view('livewire.course.index', [
            'courses' => $courses,
        ])->layout('layouts.app', ['title' => 'My Courses']);
    }
}
