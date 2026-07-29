<div class="space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Dashboard</a>
        <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-900 dark:text-white font-bold">Practices</span>
    </nav>

    {{-- Flash --}}
    @if(session('quiz_generating'))
        <div class="flex items-center gap-3 rounded-2xl bg-indigo-50 dark:bg-indigo-950/50 border border-indigo-200 dark:border-indigo-800 p-4 text-sm font-semibold text-indigo-800 dark:text-indigo-200">
            <svg class="size-5 shrink-0 animate-spin text-indigo-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
            {{ session('quiz_generating') }}
        </div>
    @endif

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-600 dark:bg-indigo-950/60 dark:text-indigo-400 mb-2">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                AI Practice & Quizzes
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Practice & Assessment</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Generate AI-powered quizzes from your course materials and test your mastery.</p>
        </div>
        <button wire:click="openGenerateModal"
            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/25 transition hover:bg-indigo-700 hover:-translate-y-0.5 shrink-0">
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Generate Practice Quiz
        </button>
    </div>

    {{-- Practice Sets List --}}
    @if($practiceSets->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 text-center rounded-3xl border border-dashed border-slate-300 dark:border-slate-800 bg-white dark:bg-slate-900">
            <div class="size-20 rounded-3xl bg-indigo-50 dark:bg-indigo-950/40 flex items-center justify-center mb-4">
                <svg class="size-10 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <p class="text-base font-extrabold text-slate-800 dark:text-white mb-1">No practice quizzes yet</p>
            <p class="text-sm text-slate-400 mb-6 max-w-xs">Click "Generate Practice Quiz" to create your first AI-powered quiz from your course materials.</p>
            <button wire:click="openGenerateModal" class="rounded-2xl bg-indigo-600 hover:bg-indigo-700 px-5 py-2.5 text-sm font-bold text-white shadow transition">Generate Your First Quiz</button>
        </div>
    @else
        <div class="space-y-4">
            @foreach($practiceSets as $set)
            <div class="group flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 rounded-3xl border
                {{ $set->status === 'ready' ? 'border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900' : ($set->status === 'failed' ? 'border-rose-200 dark:border-rose-900 bg-rose-50/30 dark:bg-rose-950/10' : 'border-indigo-200 dark:border-indigo-900 bg-indigo-50/20 dark:bg-indigo-950/10') }}
                p-5 shadow-sm transition hover:shadow-md">

                <div class="flex items-start gap-4">
                    {{-- Status icon --}}
                    <div class="size-11 shrink-0 rounded-2xl flex items-center justify-center
                        {{ $set->status === 'ready' ? 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400' : ($set->status === 'failed' ? 'bg-rose-100 dark:bg-rose-950/60 text-rose-500' : 'bg-indigo-100 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400') }}">
                        @if($set->status === 'ready')
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif($set->status === 'failed')
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg class="size-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        @endif
                    </div>

                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <p class="text-sm font-extrabold text-slate-900 dark:text-white truncate">{{ $set->title }}</p>
                            <span class="rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wide
                                {{ $set->status === 'ready' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300' : ($set->status === 'failed' ? 'bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300' : 'bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300') }}">
                                {{ $set->statusLabel() }}
                            </span>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                            <span>{{ $set->course->course_code ?? '—' }}</span>
                            <span>•</span>
                            <span>{{ ucfirst($set->difficulty) }} difficulty</span>
                            @if($set->status === 'ready')
                                <span>•</span>
                                <span>{{ $set->total_questions }} questions</span>
                                @if($set->estimated_time)
                                    <span>•</span>
                                    <span>~{{ $set->estimated_time }} min</span>
                                @endif
                            @endif
                        </div>
                        @if($set->status === 'failed' && $set->error_message)
                            <p class="text-xs text-rose-600 dark:text-rose-400 mt-1 line-clamp-1">{{ $set->error_message }}</p>
                        @endif
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2 shrink-0">
                    @if($set->status === 'ready')
                        <button wire:click="startQuiz({{ $set->id }})"
                            class="rounded-xl bg-indigo-600 hover:bg-indigo-700 px-4 py-2 text-xs font-bold text-white shadow transition">
                            Start Quiz →
                        </button>
                    @elseif($set->status === 'failed')
                        <button wire:click="retryGeneration({{ $set->id }})"
                            class="rounded-xl bg-amber-500 hover:bg-amber-600 px-4 py-2 text-xs font-bold text-white shadow transition">
                            Retry AI
                        </button>
                    @else
                        <button disabled class="rounded-xl bg-slate-100 dark:bg-slate-800 px-4 py-2 text-xs font-semibold text-slate-400 cursor-not-allowed">
                            Generating…
                        </button>
                    @endif
                    <button wire:click="deletePracticeSet({{ $set->id }})"
                        wire:confirm="Delete this practice set and all its questions?"
                        class="size-9 rounded-xl border border-slate-200 dark:border-slate-800 flex items-center justify-center text-slate-400 hover:text-rose-500 hover:border-rose-200 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    {{-- ══════════════════════════════════════════════════════
         GENERATE QUIZ MODAL
    ══════════════════════════════════════════════════════ --}}
    @if($showGenerateModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="w-full max-w-lg rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-2xl">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Generate AI Practice Quiz</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Gemma AI will read your course PDFs and create questions.</p>
                </div>
                <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 text-xl leading-none">✕</button>
            </div>

            <form wire:submit.prevent="generateQuiz" class="p-6 space-y-5">

                {{-- Course selector --}}
                <div>
                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Select Course <span class="text-rose-500">*</span></label>
                    @if($courses->isEmpty())
                        <div class="rounded-xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 p-3 text-xs text-amber-800 dark:text-amber-300 font-semibold">
                            You have no active courses. <a href="{{ route('courses.index') }}" class="underline">Create a course first →</a>
                        </div>
                    @else
                        <select wire:model="selectedCourseId"
                            class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:border-indigo-500 focus:outline-none">
                            <option value="0">— Select a course —</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_code }} — {{ $course->course_title }}</option>
                            @endforeach
                        </select>
                        @error('selectedCourseId') <p class="mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                    @endif
                </div>

                {{-- Question count --}}
                <div>
                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Number of Questions</label>
                    <div class="flex items-center gap-3">
                        @foreach([5, 10, 15] as $n)
                            <button type="button" wire:click="$set('questionCount', {{ $n }})"
                                class="flex-1 py-2.5 rounded-xl border text-xs font-bold transition
                                    {{ $questionCount === $n ? 'border-indigo-600 bg-indigo-600 text-white' : 'border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-indigo-400' }}">
                                {{ $n }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Difficulty --}}
                <div>
                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Difficulty Level</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['easy' => '😊 Easy', 'medium' => '🧠 Medium', 'hard' => '🔥 Hard'] as $val => $label)
                            <button type="button" wire:click="$set('difficulty', '{{ $val }}')"
                                class="py-2.5 rounded-xl border text-xs font-bold transition
                                    {{ $difficulty === $val ? 'border-indigo-600 bg-indigo-600 text-white' : 'border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-indigo-400' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- AI info banner --}}
                <div class="flex items-start gap-3 rounded-2xl bg-indigo-50 dark:bg-indigo-950/40 border border-indigo-200 dark:border-indigo-800 p-3.5">
                    <svg class="size-5 shrink-0 text-indigo-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                    <p class="text-xs text-indigo-800 dark:text-indigo-300 font-medium leading-relaxed">
                        Gemma AI will read all processed PDF materials in the selected course and generate <strong>{{ $questionCount }} {{ $difficulty }}</strong> multiple-choice questions. This may take 30–60 seconds.
                    </p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Cancel</button>
                    <button type="submit"
                        wire:loading.attr="disabled" wire:target="generateQuiz"
                        class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 px-6 py-2.5 text-sm font-bold text-white shadow-lg transition">
                        <svg wire:loading wire:target="generateQuiz" class="animate-spin size-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        <svg wire:loading.remove wire:target="generateQuiz" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span wire:loading.remove wire:target="generateQuiz">Generate with Gemma AI</span>
                        <span wire:loading wire:target="generateQuiz">Submitting…</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

</div>
