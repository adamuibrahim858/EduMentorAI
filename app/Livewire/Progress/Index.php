<?php

namespace App\Livewire\Progress;

use App\Models\UserPracticeSession;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('layouts.dashboard')]
    public function render()
    {
        $user = auth()->user();

        // All submitted practice sessions for user
        $sessions = UserPracticeSession::with(['practiceSet.course', 'answers'])
            ->where('user_id', $user->id)
            ->where('status', 'submitted')
            ->latest('submitted_at')
            ->get();

        // Overall stats
        $totalQuizzes   = $sessions->count();
        $averageScore   = $totalQuizzes > 0 ? round($sessions->avg('percentage'), 1) : 0;
        $highestScore   = $totalQuizzes > 0 ? round($sessions->max('percentage'), 1) : 0;
        $totalQuestions = $sessions->sum(fn($s) => $s->answers->count());

        return view('livewire.progress.index', [
            'sessions'       => $sessions,
            'totalQuizzes'   => $totalQuizzes,
            'averageScore'   => $averageScore,
            'highestScore'   => $highestScore,
            'totalQuestions' => $totalQuestions,
        ]);
    }
}
