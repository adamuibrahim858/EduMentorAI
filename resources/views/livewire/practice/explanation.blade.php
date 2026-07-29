@php
    $practiceSet = $session->practiceSet;
    $answers     = $session->answers;
    $score       = $answers->where('is_correct', true)->count();
    $total       = $answers->count();
    $pct         = $total > 0 ? round($score / $total * 100) : 0;
    $passed      = $pct >= 70;
    $timeTaken   = $session->time_taken ?? 0;
    $minutes     = floor($timeTaken / 60);
    $seconds     = $timeTaken % 60;
@endphp

<div class="min-h-screen pb-16">

    {{-- ══════ TOP BAR ══════ --}}
    <header class="sticky top-0 z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <a href="{{ route('progress.index') }}"
                   class="size-9 rounded-xl border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-300 dark:hover:border-indigo-600 transition shrink-0">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wide truncate">{{ $practiceSet->course->course_code ?? 'Practice' }}</span>
                        <span class="text-slate-300 dark:text-slate-700">•</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">Quiz Explanations</span>
                    </div>
                    <h1 class="text-sm font-black text-slate-900 dark:text-white truncate">{{ $practiceSet->title }}</h1>
                </div>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                @if($passed)
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 px-3 py-1 text-xs font-extrabold text-emerald-700 dark:text-emerald-300">
                        <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Passed ({{ $pct }}%)
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 px-3 py-1 text-xs font-extrabold text-amber-700 dark:text-amber-300">
                        <span class="size-2 rounded-full bg-amber-500"></span>
                        Score: {{ $pct }}%
                    </span>
                @endif
            </div>
        </div>
    </header>

    {{-- ══════ MAIN TWO COLUMN CONTAINER ══════ --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            {{-- ══════════════════════════════════════════════════════
                 LEFT COLUMN: REVIEW MODE & SCORE SUMMARY (4 Cols)
            ══════════════════════════════════════════════════════ --}}
            <div class="lg:col-span-4 lg:sticky lg:top-24 space-y-6">

                {{-- Hero Score Card --}}
                <div class="relative overflow-hidden rounded-3xl border shadow-xl transition-all duration-300
                    {{ $passed
                        ? 'border-emerald-200 dark:border-emerald-900 bg-gradient-to-br from-slate-900 via-teal-950 to-slate-900 text-white'
                        : 'border-indigo-200 dark:border-indigo-900 bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white' }}">

                    {{-- Ambient Background Glows --}}
                    <div class="absolute -right-12 -top-12 size-48 rounded-full {{ $passed ? 'bg-emerald-500/20' : 'bg-indigo-500/20' }} blur-2xl pointer-events-none"></div>

                    <div class="relative z-10 p-6 space-y-6">

                        <div class="text-center space-y-3">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/10 text-white/90 border border-white/10 backdrop-blur-md">
                                {{ $passed ? '🎉 Review Mode (Passed)' : '💡 Review Mode' }}
                            </div>
                            
                            {{-- Circular Score Badge --}}
                            <div class="mx-auto size-28 flex flex-col items-center justify-center rounded-3xl bg-white/10 backdrop-blur-md border border-white/20 shadow-2xl">
                                <span class="text-4xl font-black {{ $passed ? 'text-emerald-400' : 'text-amber-400' }}">{{ $pct }}<span class="text-xl">%</span></span>
                                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-wider mt-0.5">{{ $score }} / {{ $total }} Correct</span>
                            </div>

                            <p class="text-xs text-slate-300 leading-relaxed">
                                Completed {{ $session->submitted_at ? $session->submitted_at->format('M d, Y @ h:i A') : 'recently' }}
                            </p>
                        </div>

                        {{-- Stats Row --}}
                        <div class="grid grid-cols-3 gap-2.5 pt-2">
                            <div class="rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 p-3 text-center">
                                <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider">Correct</p>
                                <p class="text-xl font-black text-white mt-0.5">{{ $score }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 p-3 text-center">
                                <p class="text-[10px] font-bold text-rose-400 uppercase tracking-wider">Wrong</p>
                                <p class="text-xl font-black text-white mt-0.5">{{ $total - $score }}</p>
                            </div>
                            <div class="rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 p-3 text-center">
                                <p class="text-[10px] font-bold text-indigo-300 uppercase tracking-wider">Time</p>
                                <p class="text-sm font-black text-white mt-1.5">{{ sprintf('%02d:%02d', $minutes, $seconds) }}</p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Question Jump Shortcuts Card --}}
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Question Navigator</p>
                        <span class="text-xs font-semibold text-slate-400">{{ $total }} Total</span>
                    </div>

                    <div class="flex flex-wrap gap-2.5">
                        @foreach($answers as $i => $answer)
                            <a href="#question-{{ $i + 1 }}"
                               class="size-10 rounded-xl border text-xs font-black transition flex items-center justify-center shrink-0 shadow-sm
                               {{ $answer->is_correct
                                   ? 'bg-emerald-500 text-white border-emerald-500 shadow-emerald-500/20 hover:bg-emerald-600'
                                   : 'bg-rose-500 text-white border-rose-500 shadow-rose-500/20 hover:bg-rose-600' }}">
                                {{ $i + 1 }}
                            </a>
                        @endforeach
                    </div>

                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500">
                        <div class="flex items-center gap-2">
                            <span class="size-3 rounded-sm bg-emerald-500"></span> Correct
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="size-3 rounded-sm bg-rose-500"></span> Incorrect
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="flex flex-col gap-3">
                    <a href="{{ route('practices.quiz', $session->practice_set_id) }}"
                       class="flex items-center justify-center gap-2 w-full rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 p-4 text-sm font-bold text-white shadow-lg shadow-indigo-600/30 transition hover:-translate-y-0.5">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Retake Quiz
                    </a>
                    <a href="{{ route('progress.index') }}"
                       class="flex items-center justify-center gap-2 w-full rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-3.5 text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                        Back to Progress History
                    </a>
                </div>

            </div>

            {{-- ══════════════════════════════════════════════════════
                 RIGHT COLUMN: DETAILED QUESTION & ANSWER ANALYSIS (8 Cols)
            ══════════════════════════════════════════════════════ --}}
            <div class="lg:col-span-8 space-y-6">

                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="size-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Detailed Question & Answer Analysis
                    </h2>
                    <span class="text-xs font-bold text-slate-400">{{ $total }} Questions</span>
                </div>

                {{-- Per Question Cards --}}
                <div class="space-y-6">
                    @foreach($answers as $i => $answer)
                    @php
                        $question = $answer->question;
                        if (!$question) continue;
                        $options   = $question->options->sortBy('option_label');
                        $userSel   = strtoupper($answer->selected_option ?? '');
                        $correct   = strtoupper($question->correct_answer ?? '');
                        $isCorrect = $answer->is_correct;
                    @endphp
                    <div id="question-{{ $i + 1 }}"
                         class="scroll-mt-28 group rounded-3xl border transition-all duration-300 shadow-sm hover:shadow-md bg-white dark:bg-slate-900
                        {{ $isCorrect
                            ? 'border-slate-200/80 dark:border-slate-800 hover:border-emerald-300 dark:hover:border-emerald-700'
                            : 'border-slate-200/80 dark:border-slate-800 hover:border-rose-300 dark:hover:border-rose-700' }}">

                        {{-- Question Card Header --}}
                        <div class="flex items-start justify-between gap-4 p-6 border-b border-slate-100 dark:border-slate-800/80">
                            <div class="flex items-start gap-4 min-w-0">
                                {{-- Question Number Indicator --}}
                                <div class="size-9 rounded-2xl flex items-center justify-center text-xs font-black shrink-0 shadow-sm
                                    {{ $isCorrect
                                        ? 'bg-emerald-500 text-white shadow-emerald-500/20'
                                        : 'bg-rose-500 text-white shadow-rose-500/20' }}">
                                    {{ $i + 1 }}
                                </div>

                                <div class="min-w-0 space-y-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Question {{ $i + 1 }}</span>
                                        @if($question->topic)
                                            <span class="rounded-full bg-indigo-50 dark:bg-indigo-950/60 border border-indigo-200/60 dark:border-indigo-800/60 px-2.5 py-0.5 text-[10px] font-extrabold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                                                {{ $question->topic }}
                                            </span>
                                        @endif
                                    </div>
                                    <h4 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white leading-relaxed">
                                        {{ $question->question }}
                                    </h4>
                                </div>
                            </div>

                            {{-- Outcome Pill Badge --}}
                            <div class="shrink-0">
                                @if($isCorrect)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/80 px-3 py-1 text-xs font-extrabold text-emerald-700 dark:text-emerald-300">
                                        <svg class="size-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        Correct
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800/80 px-3 py-1 text-xs font-extrabold text-rose-700 dark:text-rose-300">
                                        <svg class="size-3.5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Incorrect
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Question Card Body --}}
                        <div class="p-6 space-y-5">

                            {{-- Options List --}}
                            <div class="space-y-3">
                                @foreach($options as $option)
                                @php
                                    $optLabel  = strtoupper($option->option_label);
                                    $isOpt     = $option->is_correct;
                                    $wasChosen = $optLabel === $userSel;

                                    if ($isOpt) {
                                        $boxStyle  = 'border-emerald-500 bg-emerald-50/60 dark:bg-emerald-950/40 text-emerald-950 dark:text-emerald-100 shadow-sm shadow-emerald-500/10';
                                        $pillStyle = 'bg-emerald-500 text-white border-emerald-500';
                                    } elseif ($wasChosen && !$isOpt) {
                                        $boxStyle  = 'border-rose-400 bg-rose-50/60 dark:bg-rose-950/40 text-rose-950 dark:text-rose-100 shadow-sm shadow-rose-500/10';
                                        $pillStyle = 'bg-rose-500 text-white border-rose-500';
                                    } else {
                                        $boxStyle  = 'border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 text-slate-600 dark:text-slate-400 opacity-70';
                                        $pillStyle = 'border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-500';
                                    }
                                @endphp

                                <div class="flex items-center justify-between gap-4 rounded-2xl border-2 px-4 py-3.5 text-sm font-semibold transition-all duration-200 {{ $boxStyle }}">
                                    <div class="flex items-center gap-3.5 min-w-0">
                                        <span class="size-8 rounded-xl border text-xs font-black flex items-center justify-center shrink-0 transition-all {{ $pillStyle }}">
                                            @if($isOpt)
                                                ✓
                                            @elseif($wasChosen && !$isOpt)
                                                ✕
                                            @else
                                                {{ $option->option_label }}
                                            @endif
                                        </span>
                                        <span class="leading-relaxed truncate sm:whitespace-normal">{{ $option->option_text }}</span>
                                    </div>

                                    <div class="shrink-0">
                                        @if($isOpt && $wasChosen)
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-600 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 shadow-sm">
                                                Your Choice & Correct
                                            </span>
                                        @elseif($isOpt)
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-500 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 shadow-sm">
                                                Correct Answer
                                            </span>
                                        @elseif($wasChosen)
                                            <span class="inline-flex items-center gap-1 rounded-full bg-rose-500 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 shadow-sm">
                                                Your Choice
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            {{-- AI Explanation Box --}}
                            @if($question->explanation)
                                <div class="rounded-2xl border border-indigo-200/80 dark:border-indigo-900/80 bg-gradient-to-r from-indigo-50/80 via-purple-50/40 to-slate-50/50 dark:from-indigo-950/40 dark:via-purple-950/20 dark:to-slate-900/40 p-5 space-y-2">
                                    <div class="flex items-center gap-2 text-indigo-700 dark:text-indigo-300">
                                        <div class="size-7 rounded-lg bg-indigo-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-indigo-600/30">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.347.346A3.51 3.51 0 0114.5 18.5H9.5a3.51 3.51 0 01-2.47-1.021l-.347-.346z"/>
                                            </svg>
                                        </div>
                                        <span class="text-xs font-black uppercase tracking-wider">AI Concept & Explanation</span>
                                    </div>
                                    <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed font-medium pl-9">
                                        {{ $question->explanation }}
                                    </p>
                                </div>
                            @endif

                        </div>
                    </div>
                    @endforeach
                </div>

            </div>

        </div>
    </div>

</div>
