<div class="space-y-8">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Dashboard</a>
        <svg class="size-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-slate-900 dark:text-white font-bold">Academic Progress</span>
    </nav>

    {{-- Page Header --}}
    <div class="relative overflow-hidden bg-gradient-to-r from-indigo-900 via-indigo-800 to-slate-900 text-white p-6 sm:p-10 rounded-3xl shadow-xl">
        {{-- Decorative SVG Background graphics --}}
        <div class="absolute -right-12 -top-12 size-64 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -bottom-12 size-64 rounded-full bg-violet-500/20 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/10 text-indigo-200 border border-white/10 backdrop-blur-md">
                    <svg class="size-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Performance & Analytics
                </div>
                <h1 class="text-2xl sm:text-4xl font-black tracking-tight text-white">
                    Academic Progress Tracker
                </h1>
                <p class="text-sm text-indigo-200 max-w-xl leading-relaxed">
                    Review your completed quiz attempts, analyze scores, and click any attempt to access detailed step-by-step explanations.
                </p>
            </div>
            <a href="{{ route('practices.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-500 to-violet-600 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-500/30 transition hover:from-indigo-600 hover:to-violet-700 hover:-translate-y-0.5 shrink-0">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Take New Practice Quiz
            </a>
        </div>
    </div>

    {{-- Overview Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        {{-- Total Quizzes --}}
        <div class="group relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm transition hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Quizzes Completed</p>
                    <p class="text-3xl font-black text-slate-900 dark:text-white mt-1">{{ $totalQuizzes }}</p>
                </div>
                <div class="size-14 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0 group-hover:scale-110 transition">
                    <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center text-xs text-slate-500 font-medium">
                <span>Attempt history recorded</span>
            </div>
        </div>

        {{-- Average Accuracy --}}
        <div class="group relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm transition hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Average Accuracy</p>
                    <p class="text-3xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ $averageScore }}%</p>
                </div>
                <div class="size-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 group-hover:scale-110 transition">
                    <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center text-xs text-slate-500 font-medium">
                <span>Across all practice sets</span>
            </div>
        </div>

        {{-- Highest Score --}}
        <div class="group relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm transition hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Highest Score</p>
                    <p class="text-3xl font-black text-amber-500 dark:text-amber-400 mt-1">{{ $highestScore }}%</p>
                </div>
                <div class="size-14 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-500 flex items-center justify-center shrink-0 group-hover:scale-110 transition">
                    <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center text-xs text-slate-500 font-medium">
                <span>Personal record</span>
            </div>
        </div>

        {{-- Total Questions Solved --}}
        <div class="group relative overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-6 dark:border-slate-800 dark:bg-slate-900 shadow-sm transition hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Questions Answered</p>
                    <p class="text-3xl font-black text-purple-600 dark:text-purple-400 mt-1">{{ $totalQuestions }}</p>
                </div>
                <div class="size-14 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0 group-hover:scale-110 transition">
                    <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center text-xs text-slate-500 font-medium">
                <span>Total question interactions</span>
            </div>
        </div>
    </div>

    {{-- Practice Sessions List --}}
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-extrabold text-slate-900 dark:text-white">Quiz Attempt History</h2>
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Click any attempt to view explanations</span>
        </div>

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
            <div class="grid grid-cols-1 gap-4">
                @foreach($sessions as $session)
                    @php
                        $pct       = (float) $session->percentage;
                        $timeTaken = $session->time_taken ?? 0;
                        $mins      = floor($timeTaken / 60);
                        $secs      = $timeTaken % 60;
                    @endphp

                    <a href="{{ route('practices.explanation', $session->id) }}"
                       class="group relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 rounded-3xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm transition-all duration-300 hover:shadow-xl hover:border-indigo-300 dark:hover:border-indigo-700 hover:-translate-y-0.5">
                        
                        <div class="flex items-start sm:items-center gap-5 min-w-0">
                            {{-- Leading Vibrant Icon Badge --}}
                            @if($pct >= 70)
                                <div class="size-16 shrink-0 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex flex-col items-center justify-center shadow-lg shadow-emerald-500/30 transition-transform group-hover:scale-105">
                                    <svg class="size-5 mb-0.5 text-emerald-100" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="text-xs font-black leading-none">{{ round($pct) }}%</span>
                                </div>
                            @elseif($pct >= 50)
                                <div class="size-16 shrink-0 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex flex-col items-center justify-center shadow-lg shadow-amber-500/30 transition-transform group-hover:scale-105">
                                    <svg class="size-5 mb-0.5 text-amber-100" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="text-xs font-black leading-none">{{ round($pct) }}%</span>
                                </div>
                            @else
                                <div class="size-16 shrink-0 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 text-white flex flex-col items-center justify-center shadow-lg shadow-indigo-600/30 transition-transform group-hover:scale-105">
                                    <svg class="size-5 mb-0.5 text-indigo-100" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.347.346A3.51 3.51 0 0114.5 18.5H9.5a3.51 3.51 0 01-2.47-1.021l-.347-.346z"/></svg>
                                    <span class="text-xs font-black leading-none">{{ round($pct) }}%</span>
                                </div>
                            @endif

                            <div class="min-w-0 space-y-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="rounded-full bg-indigo-50 dark:bg-indigo-950/60 border border-indigo-200 dark:border-indigo-800 px-2.5 py-0.5 text-[10px] font-extrabold text-indigo-600 dark:text-indigo-400 uppercase tracking-wide">
                                        {{ $session->practiceSet->course->course_code ?? 'General' }}
                                    </span>
                                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition truncate">
                                        {{ $session->practiceSet->title ?? 'Practice Quiz' }}
                                    </h3>
                                </div>

                                <div class="flex items-center gap-4 text-xs text-slate-500 dark:text-slate-400 font-medium">
                                    <span>Score: <strong class="text-slate-900 dark:text-white font-bold">{{ round($session->score) }} / {{ $session->answers->count() }}</strong></span>
                                    <span>•</span>
                                    <span>⏱ {{ sprintf('%02d:%02d', $mins, $secs) }}</span>
                                    <span>•</span>
                                    <span>{{ $session->submitted_at ? $session->submitted_at->diffForHumans() : 'Recently' }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Action Button Pill --}}
                        <div class="flex items-center justify-between sm:justify-end gap-3 shrink-0 pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100 dark:border-slate-800">
                            <span class="inline-flex items-center gap-2 rounded-2xl bg-indigo-50 dark:bg-indigo-950/50 group-hover:bg-indigo-600 px-5 py-2.5 text-xs font-bold text-indigo-600 dark:text-indigo-300 group-hover:text-white border border-indigo-200/60 dark:border-indigo-800/60 group-hover:border-indigo-600 transition-all duration-300 shadow-sm">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.347.346A3.51 3.51 0 0114.5 18.5H9.5a3.51 3.51 0 01-2.47-1.021l-.347-.346z"/></svg>
                                View Explanations
                                <svg class="size-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

</div>
