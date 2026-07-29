<?php

namespace App\Livewire\Practice;

use App\Models\PracticeSet;
use App\Models\UserAnswer;
use App\Models\UserPracticeSession;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Quiz extends Component
{
    public PracticeSet $practiceSet;

    // ── Answer tracking ───────────────────────────────────────
    public array  $answers          = [];
    public bool   $submitted        = false;
    public array  $results          = [];
    public ?int   $sessionId        = null;

    // ── Timer (client-side driven, we just record start) ─────
    public string $startedAt        = '';
    public int    $currentQuestion  = 0;  // index of active question (for nav)

    public function mount(PracticeSet $practiceSet): void
    {
        // Ensure the quiz belongs to the authenticated user and is ready
        abort_unless(
            $practiceSet->user_id === auth()->id() && $practiceSet->status === 'ready',
            403
        );

        $this->practiceSet   = $practiceSet;
        $this->startedAt     = now()->toDateTimeString();
        $this->currentQuestion = 0;
    }

    // ── Navigate between questions ────────────────────────────
    public function goToQuestion(int $index): void
    {
        $this->currentQuestion = $index;
    }

    public function nextQuestion(): void
    {
        $max = $this->practiceSet->questions->count() - 1;
        if ($this->currentQuestion < $max) {
            $this->currentQuestion++;
        }
    }

    public function prevQuestion(): void
    {
        if ($this->currentQuestion > 0) {
            $this->currentQuestion--;
        }
    }

    // ── Submit quiz ───────────────────────────────────────────
    public function submitQuiz(): void
    {
        if ($this->submitted) return;

        $ps = PracticeSet::with('questions.options')
            ->where('id', $this->practiceSet->id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $results = [];
        $score   = 0;
        $total   = $ps->questions->count();

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
                'options'     => $question->options
                    ->mapWithKeys(fn($o) => [$o->option_label => $o->option_text])
                    ->toArray(),
            ];
        }

        $this->results   = $results;
        $this->submitted = true;

        $percentage = $total > 0 ? round(($score / $total) * 100, 2) : 0;
        $startTime  = Carbon::parse($this->startedAt, config('app.timezone'));
        $timeTaken  = abs((int) now()->diffInSeconds($startTime));

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

        foreach ($results as $item) {
            UserAnswer::create([
                'session_id'      => $session->id,
                'question_id'     => $item['id'],
                'selected_option' => $item['user_answer'],
                'is_correct'      => $item['is_correct'],
                'score'           => $item['is_correct'] ? 1 : 0,
            ]);
        }

        $this->sessionId = $session->id;
    }

    // ── Render ────────────────────────────────────────────────
    #[Layout('layouts.quiz')]
    public function render()
    {
        $questions = $this->practiceSet->questions()->with('options')->get();

        $score = $this->submitted
            ? collect($this->results)->where('is_correct', true)->count()
            : 0;
        $total = $questions->count();
        $pct   = $total > 0 ? round($score / $total * 100) : 0;

        return view('livewire.practice.quiz', [
            'questions'       => $questions,
            'score'           => $score,
            'total'           => $total,
            'pct'             => $pct,
        ])->title($this->practiceSet->title . ' — Quiz');
    }
}
