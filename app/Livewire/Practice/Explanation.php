<?php

namespace App\Livewire\Practice;

use App\Models\UserPracticeSession;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Explanation extends Component
{
    public UserPracticeSession $session;

    public function mount(UserPracticeSession $session): void
    {
        // Ensure only the owner can view
        abort_unless($session->user_id === auth()->id(), 403);

        // Eager-load relationships
        $this->session = $session->load([
            'practiceSet.course',
            'answers.question.options',
        ]);
    }

    #[Layout('layouts.quiz')]
    public function render()
    {
        return view('livewire.practice.explanation', [
            'session' => $this->session,
        ])->title('Quiz Explanation — ' . ($this->session->practiceSet->title ?? 'Practice'));
    }
}
