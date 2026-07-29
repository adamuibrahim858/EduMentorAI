<?php

namespace App\Livewire\Practice;

use App\Jobs\GeneratePracticeJob;
use App\Models\Course;
use App\Models\PracticeSet;
use App\Models\UserAnswer;
use App\Models\UserPracticeSession;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    // ── Modal state ───────────────────────────────────────────
    public bool   $showGenerateModal = false;
    public int    $selectedCourseId  = 0;
    public string $difficulty        = 'medium';
    public int    $questionCount     = 10;

    // ── Quiz-attempt state ────────────────────────────────────
    public bool   $showQuiz         = false;
    public ?int   $activePracticeId = null;
    public array  $answers          = [];
    public bool   $submitted        = false;
    public array  $results          = [];

    protected function rules(): array
    {
        return [
            'selectedCourseId' => 'required|integer|min:1',
            'difficulty'       => 'required|in:easy,medium,hard',
            'questionCount'    => 'required|integer|min:5|max:15',
        ];
    }

    // ── Open / close generate modal ───────────────────────────
    public function openGenerateModal(): void
    {
        $this->reset(['selectedCourseId', 'difficulty', 'questionCount', 'showQuiz', 'activePracticeId', 'answers', 'submitted', 'results']);
        $this->difficulty     = 'medium';
        $this->questionCount  = 10;
        $this->showGenerateModal = true;
    }

    public function closeModal(): void
    {
        $this->showGenerateModal = false;
    }

    // ── Dispatch AI generation job ────────────────────────────
    public function generateQuiz(): void
    {
        $this->validate();

        $course = Course::where('id', $this->selectedCourseId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Check the course has at least one material with extracted text
        $hasMaterials = $course->materials()
            ->whereNotNull('extracted_text')
            ->where('extracted_text', '!=', '')
            ->exists();

        if (!$hasMaterials) {
            $this->addError('selectedCourseId', 'This course has no processed PDF materials yet. Please upload and process a PDF first.');
            return;
        }

        $practiceSet = PracticeSet::create([
            'user_id'          => auth()->id(),
            'course_id'        => $course->id,
            'title'            => "AI Practice: {$course->course_code} — {$course->course_title}",
            'generated_from'   => 'course_material',
            'question_type'    => 'objective',
            'difficulty'       => $this->difficulty,
            'status'           => 'pending_ai',
            'total_questions'  => 0,
            'ai_request_payload' => [
                'count'      => $this->questionCount,
                'difficulty' => $this->difficulty,
                'source'     => 'course_material',
            ],
        ]);

        GeneratePracticeJob::dispatchSync($practiceSet);

        $this->showGenerateModal = false;
        if ($practiceSet->fresh()->status === 'ready') {
            session()->flash('quiz_generating', "🎉 Quiz generated successfully! Click 'Start Quiz' to test your knowledge.");
        } else {
            session()->flash('quiz_generating', "⚠️ AI generation completed with status: " . $practiceSet->fresh()->statusLabel());
        }
    }

    public ?string $startedAt        = null;

    // ── Start / exit a quiz attempt ───────────────────────────
    public function startQuiz(int $practiceSetId)
    {
        $ps = PracticeSet::where('id', $practiceSetId)
            ->where('user_id', auth()->id())
            ->where('status', 'ready')
            ->firstOrFail();

        return redirect()->route('practices.quiz', $ps->id);
    }

    public function exitQuiz(): void
    {
        $this->showQuiz         = false;
        $this->activePracticeId = null;
        $this->answers          = [];
        $this->submitted        = false;
        $this->results          = [];
        $this->startedAt        = null;
    }

    // ── Submit quiz and score it ──────────────────────────────
    public function submitQuiz(): void
    {
        if (!$this->activePracticeId) return;

        $ps = PracticeSet::with('questions.options')
            ->where('id', $this->activePracticeId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $results    = [];
        $score      = 0;
        $total      = $ps->questions->count();

        foreach ($ps->questions as $question) {
            $userAnswer = strtoupper($this->answers[$question->id] ?? '');
            $correct    = strtoupper($question->correct_answer ?? '');
            $isCorrect  = $userAnswer === $correct && $userAnswer !== '';

            if ($isCorrect) $score++;

            $results[] = [
                'id'          => $question->id,
                'question'    => $question->question,
                'topic'       => $question->topic,
                'user_answer' => $userAnswer,
                'correct'     => $correct,
                'is_correct'  => $isCorrect,
                'explanation' => $question->explanation,
                'options'     => $question->options->mapWithKeys(fn($o) => [$o->option_label => $o->option_text])->toArray(),
            ];
        }

        $this->results   = $results;
        $this->submitted = true;

        $percentage = $total > 0 ? round(($score / $total) * 100, 2) : 0;
        $startTime  = $this->startedAt
            ? \Carbon\Carbon::parse($this->startedAt, config('app.timezone'))
            : now()->subMinutes(1);
        $timeTaken  = abs((int) now()->diffInSeconds($startTime));

        // Save practice session to database
        $session = UserPracticeSession::create([
            'user_id'         => auth()->id(),
            'practice_set_id' => $ps->id,
            'started_at'      => $startTime,
            'submitted_at'    => now(),
            'score'           => $score,
            'percentage'      => $percentage,
            'time_taken'      => $timeTaken,
            'status'          => 'submitted',
        ]);

        // Save detailed user answers to database
        foreach ($results as $item) {
            UserAnswer::create([
                'session_id'      => $session->id,
                'question_id'     => $item['id'],
                'selected_option' => $item['user_answer'],
                'is_correct'      => $item['is_correct'],
                'score'           => $item['is_correct'] ? 1 : 0,
            ]);
        }

        // Store score in session for flash display
        session(['last_quiz_score' => $score, 'last_quiz_total' => $total]);
    }

    // ── Retry a failed set ────────────────────────────────────
    public function retryGeneration(int $practiceSetId): void
    {
        $ps = PracticeSet::where('id', $practiceSetId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $ps->questions()->delete();
        $ps->update(['status' => 'pending_ai', 'error_message' => null, 'total_questions' => 0]);
        GeneratePracticeJob::dispatchSync($ps);
        session()->flash('quiz_generating', 'AI question generation completed!');
    }

    // ── Delete a practice set ─────────────────────────────────
    public function deletePracticeSet(int $practiceSetId): void
    {
        PracticeSet::where('id', $practiceSetId)
            ->where('user_id', auth()->id())
            ->delete();
    }

    // ── Render ────────────────────────────────────────────────
    #[Layout('layouts.dashboard')]
    public function render()
    {
        $practiceSets = PracticeSet::with('course')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $courses = Course::where('user_id', auth()->id())
            ->where('status', 'active')
            ->orderBy('course_title')
            ->get();

        // Quiz questions when quiz is active
        $activeQuestions = collect();
        if ($this->showQuiz && $this->activePracticeId) {
            $ps = PracticeSet::with('questions.options')
                ->find($this->activePracticeId);
            $activeQuestions = $ps?->questions ?? collect();
        }

        return view('livewire.practice.index', [
            'practiceSets'       => $practiceSets,
            'courses'            => $courses,
            'activeQuestions'    => $activeQuestions,
            'showGenerateModal'  => $this->showGenerateModal,
            'selectedCourseId'   => $this->selectedCourseId,
            'difficulty'         => $this->difficulty,
            'questionCount'      => $this->questionCount,
            'showQuiz'           => $this->showQuiz,
            'activePracticeId'   => $this->activePracticeId,
            'answers'            => $this->answers,
            'submitted'          => $this->submitted,
            'results'            => $this->results,
        ]);
    }
}
