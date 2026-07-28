<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Dashboard</a>
        <svg class="size-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-slate-900 dark:text-white font-bold">Academic Progress</span>
    </nav>

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-600 dark:bg-indigo-950/60 dark:text-indigo-400 mb-2">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Performance Tracking
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                Academic Progress & Performance
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Track all your AI practice quiz attempts, view scores, accuracy rates, and review answer breakdowns.
            </p>
        </div>
        <a href="{{ route('practices.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/25 transition hover:bg-indigo-700 shrink-0">
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Take New Practice Quiz
        </a>
    </div>

    {{-- Overview Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        {{-- Total Quizzes --}}
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm flex items-center gap-4">
            <div class="size-14 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Quizzes Taken</p>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-0.5">{{ $totalQuizzes }}</p>
            </div>
        </div>

        {{-- Average Accuracy --}}
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm flex items-center gap-4">
            <div class="size-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Average Accuracy</p>
                <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-0.5">{{ $averageScore }}%</p>
            </div>
        </div>

        {{-- Highest Score --}}
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm flex items-center gap-4">
            <div class="size-14 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-500 flex items-center justify-center shrink-0">
                <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Highest Score</p>
                <p class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-0.5">{{ $highestScore }}%</p>
            </div>
        </div>

        {{-- Total Questions Solved --}}
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm flex items-center gap-4">
            <div class="size-14 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
                <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Questions Solved</p>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-0.5">{{ $totalQuestions }}</p>
            </div>
        </div>
    </div>

    {{-- Practice Sessions List --}}
    <div class="space-y-4">
        <h2 class="text-lg font-extrabold text-slate-900 dark:text-white">Quiz Attempt History</h2>

        @if($sessions->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center rounded-3xl border border-dashed border-slate-300 dark:border-slate-800 bg-white dark:bg-slate-900">
                <div class="size-16 rounded-3xl bg-indigo-50 dark:bg-indigo-950/40 flex items-center justify-center mb-3">
                    <svg class="size-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <p class="text-base font-extrabold text-slate-800 dark:text-white mb-1">No quiz history recorded yet</p>
                <p class="text-xs text-slate-400 mb-5 max-w-xs">Take your first practice quiz to track scores, view performance analytics, and review answers.</p>
                <a href="{{ route('practices.index') }}" class="rounded-2xl bg-indigo-600 hover:bg-indigo-700 px-5 py-2.5 text-xs font-bold text-white shadow transition">Take a Practice Quiz →</a>
            </div>
        @else
            <div class="space-y-3">
                @foreach($sessions as $session)
                    @php
                        $pct   = (float) $session->percentage;
                        $badge = $pct >= 70
                            ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800'
                            : ($pct >= 50
                                ? 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300 border-amber-200 dark:border-amber-800'
                                : 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300 border-rose-200 dark:border-rose-800');
                    @endphp

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 rounded-3xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-sm transition hover:shadow-md">
                        
                        <div class="flex items-start gap-4">
                            {{-- Percentage Circle Badge --}}
                            <div class="size-12 shrink-0 rounded-2xl border flex flex-col items-center justify-center {{ $badge }}">
                                <span class="text-sm font-black leading-tight">{{ round($pct) }}%</span>
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm font-extrabold text-slate-900 dark:text-white truncate">
                                    {{ $session->practiceSet->title ?? 'Practice Quiz' }}
                                </p>
                                <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400 mt-1">
                                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $session->practiceSet->course->course_code ?? 'General' }}</span>
                                    <span>•</span>
                                    <span>Score: <strong>{{ round($session->score) }} / {{ $session->answers->count() }}</strong></span>
                                    <span>•</span>
                                    <span>{{ $session->submitted_at ? $session->submitted_at->diffForHumans() : 'Recently' }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Action --}}
                        <div class="flex items-center gap-3 shrink-0">
                            @if($session->time_taken)
                                <span class="text-xs text-slate-400 font-medium">⏱ {{ floor($session->time_taken / 60) }}m {{ $session->time_taken % 60 }}s</span>
                            @endif
                            <button wire:click="viewDetails({{ $session->id }})"
                                class="rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-950 dark:hover:text-indigo-400 px-4 py-2 text-xs font-bold text-slate-700 dark:text-slate-300 transition">
                                Review Breakdown →
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ══════════════════════════════════════════════════════
         DETAILED REVIEW MODAL
    ══════════════════════════════════════════════════════ --}}
    @if($showDetailModal && $selectedSession)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm overflow-y-auto">
        <div class="w-full max-w-3xl my-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden">
            
            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/50">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white">
                        {{ $selectedSession->practiceSet->title ?? 'Quiz Review' }}
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        Completed {{ $selectedSession->submitted_at ? $selectedSession->submitted_at->format('M d, Y @ h:i A') : '' }}
                    </p>
                </div>
                <button wire:click="closeDetails" class="text-slate-400 hover:text-slate-600 text-xl leading-none">✕</button>
            </div>

            {{-- Summary Banner --}}
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 bg-indigo-50/40 dark:bg-indigo-950/20 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Quiz Score</p>
                    <p class="text-2xl font-black text-slate-900 dark:text-white mt-0.5">
                        {{ round($selectedSession->score) }} / {{ $selectedSession->answers->count() }} correct ({{ round($selectedSession->percentage) }}%)
                    </p>
                </div>
                <div class="px-4 py-2 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-300">
                    Difficulty: {{ ucfirst($selectedSession->practiceSet->difficulty ?? 'medium') }}
                </div>
            </div>

            {{-- Questions & Answers Breakdown --}}
            <div class="p-6 max-h-[60vh] overflow-y-auto space-y-5">
                @foreach($selectedSession->answers as $idx => $userAnswer)
                    @php
                        $question  = $userAnswer->question;
                        $isCorrect = $userAnswer->is_correct;
                    @endphp
                    @if($question)
                    <div class="rounded-2xl border {{ $isCorrect ? 'border-emerald-200 dark:border-emerald-900 bg-emerald-50/20 dark:bg-emerald-950/10' : 'border-rose-200 dark:border-rose-900 bg-rose-50/20 dark:bg-rose-950/10' }} p-4 space-y-3">
                        
                        <div class="flex items-start gap-3">
                            <span class="size-6 shrink-0 rounded-lg {{ $isCorrect ? 'bg-emerald-500' : 'bg-rose-500' }} text-white text-xs font-extrabold flex items-center justify-center">
                                {{ $idx + 1 }}
                            </span>
                            <p class="text-xs font-bold text-slate-900 dark:text-white leading-relaxed">
                                {{ $question->question }}
                            </p>
                        </div>

                        {{-- Options List --}}
                        <div class="space-y-1.5 pl-9">
                            @foreach($question->options->sortBy('option_label') as $option)
                                @php
                                    $isSelected = strtoupper($userAnswer->selected_option) === strtoupper($option->option_label);
                                    $isOptionCorrect = $option->is_correct;
                                    
                                    if ($isOptionCorrect) {
                                        $optClass = 'border-emerald-500 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-200 font-bold';
                                    } elseif ($isSelected && !$isOptionCorrect) {
                                        $optClass = 'border-rose-400 bg-rose-50 dark:bg-rose-950/40 text-rose-800 dark:text-rose-200 font-bold';
                                    } else {
                                        $optClass = 'border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400';
                                    }
                                @endphp
                                <div class="flex items-center gap-2.5 rounded-xl border px-3 py-2 text-xs {{ $optClass }}">
                                    <span class="size-5 shrink-0 rounded-md border text-[10px] font-black flex items-center justify-center {{ $isOptionCorrect ? 'border-emerald-500 bg-emerald-500 text-white' : ($isSelected && !$isOptionCorrect ? 'border-rose-400 bg-rose-400 text-white' : 'border-slate-300 text-slate-400') }}">
                                        {{ $option->option_label }}
                                    </span>
                                    <span>{{ $option->option_text }}</span>
                                    @if($isSelected)
                                        <span class="ml-auto text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300">Your Choice</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- Explanation --}}
                        @if($question->explanation)
                            <div class="ml-9 rounded-xl bg-white dark:bg-slate-800 p-3 text-[11px] text-slate-600 dark:text-slate-300 border border-slate-100 dark:border-slate-700">
                                <span class="font-bold text-slate-900 dark:text-white">Explanation:</span> {{ $question->explanation }}
                            </div>
                        @endif

                    </div>
                    @endif
                @endforeach
            </div>

            {{-- Footer --}}
            <div class="flex justify-end px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/50">
                <button wire:click="closeDetails" class="px-5 py-2 rounded-xl bg-slate-200 dark:bg-slate-800 text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-300 transition">
                    Close Review
                </button>
            </div>
        </div>
    </div>
    @endif

</div>
