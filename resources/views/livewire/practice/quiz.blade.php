<div
    x-data="{
        seconds: 0,
        running: true,
        submitted: @entangle('submitted'),
        format(s) {
            let m = Math.floor(s/60);
            let sec = s % 60;
            return String(m).padStart(2,'0') + ':' + String(sec).padStart(2,'0');
        }
    }"
    x-init="
        let t = setInterval(() => {
            if (running && !submitted) seconds++;
            if (submitted) { clearInterval(t); }
        }, 1000);
    "
    class="min-h-screen flex flex-col"
>

{{-- ══════ TOP BAR ══════ --}}
<header class="sticky top-0 z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-4">

        {{-- Brand + title --}}
        <div class="flex items-center gap-3 min-w-0">
            <a href="{{ route('practices.index') }}"
               class="size-9 rounded-xl border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-300 transition shrink-0">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div class="min-w-0">
                <p class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 truncate">{{ $practiceSet->course->course_code ?? 'Practice' }}</p>
                <h1 class="text-sm font-extrabold text-slate-900 dark:text-white truncate leading-tight">{{ $practiceSet->title }}</h1>
            </div>
        </div>

        {{-- Timer + progress --}}
        <div class="flex items-center gap-4 shrink-0">
            {{-- Answered badge --}}
            <div class="hidden sm:flex items-center gap-1.5 bg-slate-100 dark:bg-slate-800 rounded-xl px-3 py-1.5">
                <span class="text-xs font-bold text-slate-700 dark:text-slate-300">
                    {{ count(array_filter($answers, fn($v) => $v !== '')) }}/{{ $questions->count() }}
                </span>
                <span class="text-xs text-slate-400">answered</span>
            </div>

            {{-- Live timer --}}
            <div class="flex items-center gap-2 bg-indigo-50 dark:bg-indigo-950/50 border border-indigo-200 dark:border-indigo-800 rounded-xl px-3 py-1.5">
                <svg class="size-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-sm font-black tabular-nums text-indigo-700 dark:text-indigo-300" x-text="format(seconds)">00:00</span>
            </div>
        </div>
    </div>

    {{-- Progress bar --}}
    @php $answered = count(array_filter($answers, fn($v) => $v !== '')); @endphp
    <div class="h-1 bg-slate-100 dark:bg-slate-800">
        <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 transition-all duration-500"
             style="width: {{ $questions->count() > 0 ? round($answered / $questions->count() * 100) : 0 }}%"></div>
    </div>
</header>

{{-- ══════ RESULTS OVERLAY (after submission) ══════ --}}
@if($submitted)
@php
    $score = collect($results)->where('is_correct', true)->count();
    $total = count($results);
    $pct   = $total > 0 ? round($score / $total * 100) : 0;
    $passed = $pct >= 70;
@endphp
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm">
    <div class="w-full max-w-md bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden">

        {{-- Colour band --}}
        <div class="h-2 {{ $passed ? 'bg-gradient-to-r from-emerald-400 to-teal-400' : 'bg-gradient-to-r from-amber-400 to-orange-400' }}"></div>

        <div class="p-8 text-center space-y-5">
            {{-- Emoji trophy --}}
            <div class="text-6xl">{{ $passed ? '🏆' : '📚' }}</div>

            {{-- Big score --}}
            <div>
                <p class="text-7xl font-black {{ $passed ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">{{ $pct }}<span class="text-3xl">%</span></p>
                <p class="text-base font-bold text-slate-700 dark:text-slate-300 mt-1">{{ $score }} / {{ $total }} correct</p>
                <p class="text-sm font-semibold {{ $passed ? 'text-emerald-600' : 'text-amber-600' }} mt-0.5">
                    {{ $passed ? '🎉 Excellent work! You passed!' : '💪 Keep practising — you\'ll get there!' }}
                </p>
            </div>

            {{-- Stats row --}}
            <div class="grid grid-cols-3 gap-3">
                <div class="rounded-2xl bg-slate-50 dark:bg-slate-800 p-3">
                    <p class="text-lg font-black text-slate-900 dark:text-white">{{ $score }}</p>
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide">Correct</p>
                </div>
                <div class="rounded-2xl bg-slate-50 dark:bg-slate-800 p-3">
                    <p class="text-lg font-black text-rose-500">{{ $total - $score }}</p>
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide">Wrong</p>
                </div>
                <div class="rounded-2xl bg-slate-50 dark:bg-slate-800 p-3">
                    <p class="text-lg font-black text-indigo-600 dark:text-indigo-400" x-text="format(seconds)">—</p>
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide">Time</p>
                </div>
            </div>

            {{-- Action buttons --}}
            <div class="flex flex-col gap-3 pt-2">
                @if($sessionId)
                <a href="{{ route('practices.explanation', $sessionId) }}"
                   class="flex items-center justify-center gap-2 w-full rounded-2xl bg-indigo-600 hover:bg-indigo-700 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-600/25 transition hover:-translate-y-0.5">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.347.346A3.51 3.51 0 0114.5 18.5H9.5a3.51 3.51 0 01-2.47-1.021l-.347-.346z"/></svg>
                    View Explanations
                </a>
                @endif
                <a href="{{ route('practices.index') }}"
                   class="flex items-center justify-center gap-2 w-full rounded-2xl border border-slate-200 dark:border-slate-700 px-6 py-3 text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                    Back to Practices
                </a>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ══════ MAIN BODY ══════ --}}
<div class="flex flex-1 max-w-6xl mx-auto w-full px-4 sm:px-6 py-8 gap-8">

    {{-- ── LEFT: Question panel ── --}}
    <div class="flex-1 min-w-0">

        {{-- Questions loop --}}
        @foreach($questions as $qi => $question)
        @php
            $resultItem = collect($results)->firstWhere('id', $question->id);
            $isActive   = $currentQuestion === $qi;
        @endphp
        <div class="{{ $isActive ? 'block' : 'hidden' }}">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 sm:p-8 space-y-6">

                {{-- Question number + topic --}}
                <div class="flex items-start gap-4">
                    <div class="size-10 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white text-sm font-black flex items-center justify-center shrink-0 shadow-lg shadow-indigo-500/30">
                        {{ $qi + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        @if($question->topic)
                        <span class="inline-block mb-2 rounded-full bg-indigo-50 dark:bg-indigo-950/50 border border-indigo-200 dark:border-indigo-800 px-2.5 py-0.5 text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wide">{{ $question->topic }}</span>
                        @endif
                        <p class="text-base sm:text-lg font-bold text-slate-900 dark:text-white leading-snug">{{ $question->question }}</p>
                    </div>
                </div>

                {{-- Options --}}
                <div class="space-y-3">
                    @foreach($question->options->sortBy('option_label') as $option)
                    @php
                        $isSelected = (($answers[$question->id] ?? '') === $option->option_label);
                        $isCorrect  = $option->is_correct;
                        if ($submitted) {
                            if ($isCorrect) $cls = 'border-emerald-400 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-800 dark:text-emerald-200 shadow-emerald-100 dark:shadow-none';
                            elseif ($isSelected && !$isCorrect) $cls = 'border-rose-400 bg-rose-50 dark:bg-rose-950/30 text-rose-800 dark:text-rose-200';
                            else $cls = 'border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 opacity-60';
                        } else {
                            $cls = $isSelected
                                ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-900 dark:text-indigo-100 shadow-md shadow-indigo-100 dark:shadow-none'
                                : 'border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-indigo-300 hover:bg-indigo-50/50 dark:hover:bg-indigo-950/20 hover:shadow-sm';
                        }
                        if ($submitted) {
                            if ($isCorrect) $dotCls = 'bg-emerald-500 border-emerald-500 text-white';
                            elseif ($isSelected && !$isCorrect) $dotCls = 'bg-rose-400 border-rose-400 text-white';
                            else $dotCls = 'border-slate-300 dark:border-slate-600 text-slate-400';
                        } else {
                            $dotCls = $isSelected ? 'bg-indigo-600 border-indigo-600 text-white' : 'border-slate-300 dark:border-slate-600 text-slate-500';
                        }
                    @endphp
                    <button type="button"
                        @if(!$submitted) wire:click="$set('answers.{{ $question->id }}', '{{ $option->option_label }}')" @endif
                        {{ $submitted ? 'disabled' : '' }}
                        class="group flex items-center gap-4 w-full rounded-2xl border px-5 py-4 text-sm font-semibold text-left transition-all duration-200 {{ $cls }}">
                        <span class="size-8 shrink-0 rounded-xl border-2 text-xs font-black flex items-center justify-center transition-all {{ $dotCls }}">
                            {{ $submitted && $isCorrect ? '✓' : ($submitted && $isSelected && !$isCorrect ? '✗' : $option->option_label) }}
                        </span>
                        <span class="flex-1">{{ $option->option_text }}</span>
                    </button>
                    @endforeach
                </div>

                {{-- Explanation (after submit) --}}
                @if($submitted && $resultItem && $resultItem['explanation'])
                <div class="rounded-2xl bg-gradient-to-br from-slate-50 to-indigo-50/50 dark:from-slate-800 dark:to-indigo-950/20 border border-indigo-100 dark:border-indigo-900/50 p-5">
                    <div class="flex items-start gap-3">
                        <div class="size-8 rounded-xl bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center shrink-0">
                            <svg class="size-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.347.346A3.51 3.51 0 0114.5 18.5H9.5a3.51 3.51 0 01-2.47-1.021l-.347-.346z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-indigo-700 dark:text-indigo-300 uppercase tracking-wide mb-1">Explanation</p>
                            <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed">{{ $resultItem['explanation'] }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Nav buttons --}}
                <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-800">
                    <button wire:click="prevQuestion" @if($currentQuestion === 0) disabled @endif
                        class="flex items-center gap-2 px-5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 disabled:opacity-30 disabled:cursor-not-allowed transition">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Previous
                    </button>

                    @if(!$submitted)
                        @if($currentQuestion === $questions->count() - 1)
                        <button wire:click="submitQuiz"
                            wire:loading.attr="disabled" wire:target="submitQuiz"
                            class="flex items-center gap-2 px-6 py-2.5 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-sm font-bold text-white shadow-lg shadow-indigo-500/30 transition hover:-translate-y-0.5 disabled:opacity-60">
                            <svg wire:loading wire:target="submitQuiz" class="size-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            <svg wire:loading.remove wire:target="submitQuiz" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Submit Quiz
                        </button>
                        @else
                        <button wire:click="nextQuestion"
                            class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-sm font-bold text-white shadow transition hover:-translate-y-0.5">
                            Next
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                        @endif
                    @else
                        <button wire:click="nextQuestion" @if($currentQuestion === $questions->count() - 1) disabled @endif
                            class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-sm font-bold text-white shadow transition hover:-translate-y-0.5 disabled:opacity-30 disabled:cursor-not-allowed">
                            Next
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── RIGHT SIDEBAR: Question Navigation ── --}}
    <div class="hidden lg:block w-80 shrink-0">
        <div class="sticky top-24 space-y-4">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-4">Question Navigation</p>
                <div class="flex flex-wrap gap-2.5">
                    @foreach($questions as $qi => $question)
                    @php
                        $isAnswered = !empty($answers[$question->id] ?? '');
                        $isCurrent  = $currentQuestion === $qi;
                        $resultItem = collect($results)->firstWhere('id', $question->id);
                        if ($submitted) {
                            if ($resultItem && $resultItem['is_correct']) $navCls = 'bg-emerald-500 text-white border-emerald-500';
                            else $navCls = 'bg-rose-400 text-white border-rose-400';
                        } elseif ($isCurrent) {
                            $navCls = 'bg-indigo-600 text-white border-indigo-600 shadow-md shadow-indigo-500/30';
                        } elseif ($isAnswered) {
                            $navCls = 'bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border-indigo-300 dark:border-indigo-700';
                        } else {
                            $navCls = 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-700 hover:border-indigo-300 hover:bg-indigo-50 dark:hover:bg-indigo-950/30';
                        }
                    @endphp
                    <button wire:click="goToQuestion({{ $qi }})"
                        class="size-10 rounded-xl border text-xs font-black transition flex items-center justify-center shrink-0 {{ $navCls }}">
                        {{ $qi + 1 }}
                    </button>
                    @endforeach
                </div>

                {{-- Legend --}}
                <div class="mt-4 space-y-1.5 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="size-3 rounded-sm bg-indigo-600"></span> Current
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="size-3 rounded-sm bg-indigo-100 dark:bg-indigo-900 border border-indigo-300 dark:border-indigo-700"></span> Answered
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="size-3 rounded-sm bg-slate-100 dark:bg-slate-800 border border-slate-300 dark:border-slate-600"></span> Unanswered
                    </div>
                    @if($submitted)
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="size-3 rounded-sm bg-emerald-500"></span> Correct
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="size-3 rounded-sm bg-rose-400"></span> Wrong
                    </div>
                    @endif
                </div>
            </div>

            {{-- Unanswered warning --}}
            @if(!$submitted)
            @php $unanswered = $questions->filter(fn($q) => empty($answers[$q->id] ?? ''))->count(); @endphp
            @if($unanswered > 0)
            <div class="flex items-start gap-2.5 rounded-2xl bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800 p-4">
                <svg class="size-4 text-amber-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-xs font-semibold text-amber-700 dark:text-amber-300">{{ $unanswered }} question{{ $unanswered > 1 ? 's' : '' }} unanswered</p>
            </div>
            @else
            <div class="flex items-start gap-2.5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 p-4">
                <svg class="size-4 text-emerald-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-xs font-semibold text-emerald-700 dark:text-emerald-300">All questions answered! Ready to submit.</p>
            </div>
            @endif
            @endif

            {{-- Submit button in sidebar --}}
            @if(!$submitted)
            <button wire:click="submitQuiz"
                wire:loading.attr="disabled" wire:target="submitQuiz"
                class="w-full flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-500/30 transition hover:-translate-y-0.5 disabled:opacity-60">
                <svg wire:loading wire:target="submitQuiz" class="size-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                <svg wire:loading.remove wire:target="submitQuiz" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                Submit Quiz
            </button>
            @endif
        </div>
    </div>

</div>

{{-- Mobile: bottom submit bar --}}
@if(!$submitted)
<div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl border-t border-slate-200 dark:border-slate-800 p-4">
    <div class="flex items-center gap-3">
        <div class="flex-1 text-xs text-slate-500 dark:text-slate-400 font-semibold">
            <span class="text-slate-900 dark:text-white font-black">{{ count(array_filter($answers, fn($v) => $v !== '')) }}</span>/{{ $questions->count() }} answered
        </div>
        <button wire:click="submitQuiz"
            wire:loading.attr="disabled" wire:target="submitQuiz"
            class="flex items-center gap-2 rounded-2xl bg-indigo-600 hover:bg-indigo-700 px-5 py-2.5 text-sm font-bold text-white shadow disabled:opacity-60 transition">
            Submit Quiz
        </button>
    </div>
</div>
<div class="lg:hidden h-20"></div>
@endif

</div>
