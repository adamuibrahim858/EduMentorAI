<?php

namespace App\Livewire\Routine;

use App\Models\Course;
use App\Models\StudyRoutine;
use Livewire\Attributes\Title;
use Livewire\Component;
use Throwable;

#[Title('Learning Routine')]
class Index extends Component
{
    // ----------------------------------------------------------------
    // Form fields
    // ----------------------------------------------------------------
    public ?int    $editingId         = null;
    public int     $course_id         = 0;
    public string  $title             = '';
    public string  $study_day         = 'monday';
    public string  $start_time        = '08:00';
    public string  $end_time          = '10:00';
    public int     $study_duration    = 90;
    public int     $practice_duration = 30;
    public string  $repeat_type       = 'weekly';
    public int     $reminder_before   = 15;
    public bool    $status            = true;

    // ----------------------------------------------------------------
    // UI state
    // ----------------------------------------------------------------
    public bool   $showModal  = false;
    public bool   $showDelete = false;
    public ?int   $deleteId   = null;
    public string $activeTab  = 'all'; // all | today | upcoming

    public function setTab(string $tab): void
    {
        if (in_array($tab, ['all', 'today', 'upcoming'])) {
            $this->activeTab = $tab;
        }
    }

    // ----------------------------------------------------------------
    // Validation rules
    // ----------------------------------------------------------------
    protected function rules(): array
    {
        return [
            'course_id'         => ['required', 'integer', 'exists:courses,id'],
            'title'             => ['required', 'string', 'min:3', 'max:150'],
            'study_day'         => ['required', 'string', 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'],
            'start_time'        => ['required', 'date_format:H:i'],
            'end_time'          => ['required', 'date_format:H:i', 'after:start_time'],
            'study_duration'    => ['required', 'integer', 'min:15', 'max:480'],
            'practice_duration' => ['required', 'integer', 'min:0', 'max:240'],
            'repeat_type'       => ['required', 'in:daily,weekly,custom'],
            'reminder_before'   => ['nullable', 'integer'],
            'status'            => ['boolean'],
        ];
    }

    protected $messages = [
        'end_time.after'       => 'End time must be after start time.',
        'course_id.exists'     => 'Please select a valid course.',
        'study_duration.min'   => 'Study duration must be at least 15 minutes.',
    ];

    // ----------------------------------------------------------------
    // Open create modal
    // ----------------------------------------------------------------
    public function openCreate(): void
    {
        $this->resetForm();

        $firstCourse = Course::where('user_id', auth()->id())
            ->where('status', 'active')
            ->first();

        if ($firstCourse) {
            $this->course_id = $firstCourse->id;
        }

        $this->editingId = null;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    // ----------------------------------------------------------------
    // Open edit modal
    // ----------------------------------------------------------------
    public function openEdit(int $id): void
    {
        $routine = StudyRoutine::where('user_id', auth()->id())->findOrFail($id);

        $this->editingId         = $routine->id;
        $this->course_id         = $routine->course_id;
        $this->title             = $routine->title;
        $this->study_day         = $routine->study_day;
        $this->start_time        = substr($routine->start_time, 0, 5);
        $this->end_time          = substr($routine->end_time, 0, 5);
        $this->study_duration    = $routine->study_duration;
        $this->practice_duration = $routine->practice_duration;
        $this->repeat_type       = $routine->repeat_type;
        $this->reminder_before   = $routine->reminder_before;
        $this->status            = (bool) $routine->status;

        $this->showModal = true;
    }

    // ----------------------------------------------------------------
    // Save (create or update)
    // ----------------------------------------------------------------
    public function save(): void
    {
        $this->validate();

        if ($this->status && $this->checkOverlap()) {
            $this->addError('start_time', 'This time slot overlaps with an existing routine on the same day.');
            return;
        }

        try {
            $data = [
                'user_id'           => auth()->id(),
                'course_id'         => $this->course_id,
                'title'             => $this->title,
                'study_day'         => $this->study_day,
                'start_time'        => $this->start_time,
                'end_time'          => $this->end_time,
                'study_duration'    => $this->study_duration,
                'practice_duration' => $this->practice_duration,
                'repeat_type'       => $this->repeat_type,
                'reminder_before'   => $this->reminder_before ?: 15,
                'status'            => true,
            ];

            if ($this->editingId) {
                StudyRoutine::where('user_id', auth()->id())
                    ->findOrFail($this->editingId)
                    ->update($data);
                session()->flash('success', 'Routine updated successfully!');
            } else {
                StudyRoutine::create($data);
                session()->flash('success', 'Routine created successfully!');
            }

            $this->closeModal();

        } catch (Throwable $e) {
            session()->flash('error', 'Failed to save routine: ' . $e->getMessage());
        }
    }

    // ----------------------------------------------------------------
    // Overlap check helper
    // ----------------------------------------------------------------
    private function checkOverlap(): bool
    {
        $query = StudyRoutine::where('user_id', auth()->id())
            ->where('status', true)
            ->where(function ($q) {
                $q->where('study_day', $this->study_day)
                  ->orWhere('repeat_type', 'daily');
            })
            ->where(function ($q) {
                $q->where('start_time', '<', $this->end_time)
                  ->where('end_time', '>', $this->start_time);
            });

        if ($this->editingId) {
            $query->where('id', '!=', $this->editingId);
        }

        return $query->exists();
    }

    // ----------------------------------------------------------------
    // Toggle status
    // ----------------------------------------------------------------
    public function toggleStatus(int $id): void
    {
        $routine = StudyRoutine::where('user_id', auth()->id())->findOrFail($id);
        $routine->update(['status' => !$routine->status]);
    }

    // ----------------------------------------------------------------
    // Confirm delete
    // ----------------------------------------------------------------
    public function confirmDelete(int $id): void
    {
        $this->deleteId   = $id;
        $this->showDelete = true;
    }

    public function cancelDelete(): void
    {
        $this->deleteId   = null;
        $this->showDelete = false;
    }

    public function delete(): void
    {
        if (!$this->deleteId) return;

        try {
            StudyRoutine::where('user_id', auth()->id())
                ->findOrFail($this->deleteId)
                ->delete();

            session()->flash('success', 'Routine deleted.');
        } catch (Throwable $e) {
            session()->flash('error', 'Could not delete routine.');
        }

        $this->cancelDelete();
    }

    // ----------------------------------------------------------------
    // Reset form fields
    // ----------------------------------------------------------------
    private function resetForm(): void
    {
        $this->editingId         = null;
        $this->course_id         = 0;
        $this->title             = '';
        $this->study_day         = 'monday';
        $this->start_time        = '08:00';
        $this->end_time          = '10:00';
        $this->study_duration    = 90;
        $this->practice_duration = 30;
        $this->repeat_type       = 'weekly';
        $this->reminder_before   = 15;
        $this->status            = true;
        $this->resetErrorBag();
    }

    // ----------------------------------------------------------------
    // Render
    // ----------------------------------------------------------------
    public function render()
    {
        $userId = auth()->id();

        $allRoutines = StudyRoutine::with('course')
            ->forUser($userId)
            ->orderByRaw("FIELD(study_day,'monday','tuesday','wednesday','thursday','friday','saturday','sunday')")
            ->orderBy('start_time')
            ->get();

        $todayName = strtolower(now()->format('l'));
        $todayRoutines = $allRoutines->filter(function ($routine) use ($todayName) {
            return $routine->repeat_type === 'daily' || strtolower($routine->study_day) === $todayName;
        })->sortBy('start_time');

        // Chronological upcoming days starting from Tomorrow
        $upcomingDays = [];
        for ($i = 1; $i <= 7; $i++) {
            $date = now()->addDays($i);
            $dayName = strtolower($date->format('l'));
            $dayLabel = $i === 1 ? 'Tomorrow (' . $date->format('l, M j') . ')' : $date->format('l, M j');

            $upcomingDays[] = [
                'day'      => $dayName,
                'dayLabel' => $dayLabel,
            ];
        }

        $upcomingRoutinesGrouped = collect();
        $totalUpcomingCount = 0;

        foreach ($upcomingDays as $item) {
            $dayName = $item['day'];
            $dayRoutines = $allRoutines->filter(function ($routine) use ($dayName) {
                return $routine->status && ($routine->repeat_type === 'daily' || strtolower($routine->study_day) === $dayName);
            })->sortBy('start_time');

            if ($dayRoutines->isNotEmpty()) {
                $upcomingRoutinesGrouped->put($item['dayLabel'], $dayRoutines);
                $totalUpcomingCount += $dayRoutines->count();
            }
        }

        $courses = Course::where('user_id', $userId)
            ->where('status', 'active')
            ->orderBy('course_title')
            ->get();

        return view('livewire.routine.index', [
            'allRoutines'             => $allRoutines,
            'todayRoutines'           => $todayRoutines,
            'upcomingRoutinesGrouped' => $upcomingRoutinesGrouped,
            'totalUpcomingCount'      => $totalUpcomingCount,
            'courses'                 => $courses,
            'days'                    => StudyRoutine::$DAYS,
            'reminderOptions'         => StudyRoutine::$REMINDER_OPTIONS,
        ])->layout('layouts.dashboard', ['title' => 'Learning Routines']);
    }
}
