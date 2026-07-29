<?php

namespace App\Livewire\Dashboard;

use App\Models\UserPracticeSession;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        $user = Auth::user();

        $coursesCount = $user ? $user->courses()->count() : 0;
        $practicesCount = 0;
        $thisWeekCount = 0;
        $streak = 0;
        $avgScore = 0;

        if ($user) {
            $completedSessions = UserPracticeSession::where('user_id', $user->id)
                ->where('status', 'submitted');

            $practicesCount = (clone $completedSessions)->count();
            $thisWeekCount = (clone $completedSessions)
                ->where('submitted_at', '>=', now()->startOfWeek())
                ->count();

            // Calculate consecutive active study days from completed sessions
            $activityDates = (clone $completedSessions)
                ->whereNotNull('submitted_at')
                ->pluck('submitted_at')
                ->map(fn($date) => $date->format('Y-m-d'))
                ->unique()
                ->sortDesc()
                ->values();

            $checkDate = now()->startOfDay();
            if ($activityDates->contains($checkDate->format('Y-m-d'))) {
                while ($activityDates->contains($checkDate->format('Y-m-d'))) {
                    $streak++;
                    $checkDate->subDay();
                }
            } else {
                $checkDate->subDay();
                while ($activityDates->contains($checkDate->format('Y-m-d'))) {
                    $streak++;
                    $checkDate->subDay();
                }
            }

            if ($practicesCount > 0) {
                $avgScore = round((clone $completedSessions)->avg('percentage') ?? 0, 1);
            }
        }

        return view('livewire.dashboard.index', [
            'user' => $user,
            'coursesCount' => $coursesCount,
            'practicesCount' => $practicesCount,
            'thisWeekCount' => $thisWeekCount,
            'streak' => $streak,
            'avgScore' => $avgScore,
        ])->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
