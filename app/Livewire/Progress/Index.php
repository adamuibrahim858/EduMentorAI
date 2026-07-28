<?php

namespace App\Livewire\Progress;

use App\Models\UserPracticeSession;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public ?int $selectedSessionId = null;
    public bool $showDetailModal   = false;

    public function viewDetails(int $sessionId): void
    {
        $this->selectedSessionId = $sessionId;
        $this->showDetailModal   = true;
    }

    public function closeDetails(): void
    {
        $this->selectedSessionId = null;
        $this->showDetailModal   = false;
    }

    #[Layout('layouts.dashboard')]
    public function render()
    {
        $user = auth()->user();

        // All submitted practice sessions for user
        $sessions = UserPracticeSession::with(['practiceSet.course', 'answers.question.options'])
            ->where('user_id', $user->id)
            ->where('status', 'submitted')
            ->latest('submitted_at')
            ->get();

        // Overall stats
        $totalQuizzes   = $sessions->count();
        $averageScore   = $totalQuizzes > 0 ? round($sessions->avg('percentage'), 1) : 0;
        $highestScore   = $totalQuizzes > 0 ? round($sessions->max('percentage'), 1) : 0;
        $totalQuestions = $sessions->sum(fn($s) => $s->answers->count());

        $selectedSession = null;
        if ($this->showDetailModal && $this->selectedSessionId) {
            $selectedSession = $sessions->firstWhere('id', $this->selectedSessionId);
        }

        return view('livewire.progress.index', [
            'sessions'        => $sessions,
            'totalQuizzes'    => $totalQuizzes,
            'averageScore'    => $averageScore,
            'highestScore'    => $highestScore,
            'totalQuestions'  => $totalQuestions,
            'selectedSession' => $selectedSession,
            'showDetailModal' => $this->showDetailModal,
        ]);
    }
}
