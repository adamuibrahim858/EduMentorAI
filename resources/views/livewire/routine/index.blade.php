<div class="space-y-6">
    {{-- Breadcrumb Navigation --}}
    <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Dashboard</a>
        <svg class="size-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-slate-900 dark:text-white font-bold">Learning Routines</span>
    </nav>

    {{-- Flash Alerts --}}
    @if(session('success'))
        <div class="flex items-center justify-between rounded-2xl bg-emerald-50 border border-emerald-200 dark:bg-emerald-950/50 dark:border-emerald-800 p-4 text-sm font-semibold text-emerald-800 dark:text-emerald-200 shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="size-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="$el.parentElement.remove()" class="text-emerald-600 dark:text-emerald-400 hover:opacity-75">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center justify-between rounded-2xl bg-rose-50 border border-rose-200 dark:bg-rose-950/50 dark:border-rose-800 p-4 text-sm font-semibold text-rose-800 dark:text-rose-200 shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="size-5 shrink-0 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
            <button @click="$el.parentElement.remove()" class="text-rose-600 dark:text-rose-400 hover:opacity-75">&times;</button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-600 dark:bg-indigo-950/60 dark:text-indigo-400 mb-2">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Study Schedule Planner
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Learning Routine</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Build consistent study habits with your personalised daily schedule.</p>
        </div>
        <button
            type="button"
            wire:click="openCreate"
            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-600/25 transition hover:-translate-y-0.5 shrink-0 cursor-pointer"
        >
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            New Routine
        </button>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
        @php
            $totalActive  = $allRoutines->where('status', true)->count();
            $totalMinutes = $allRoutines->where('status', true)->sum(fn($r) => $r->study_duration + $r->practice_duration);
            $todayCount   = $todayRoutines->where('status', true)->count();
        @endphp
        @foreach([
            ['label'=>'Active Routines','value'=>$totalActive,'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'indigo'],
            ['label'=>'Today\'s Sessions','value'=>$todayCount,'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','color'=>'emerald'],
            ['label'=>'Weekly Planned Mins','value'=>number_format($totalMinutes),'icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'violet'],
            ['label'=>'Upcoming (7d)','value'=>$totalUpcomingCount,'icon'=>'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6','color'=>'amber'],
        ] as $stat)
            <div class="rounded-3xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <div class="size-9 rounded-xl bg-{{ $stat['color'] }}-50 dark:bg-{{ $stat['color'] }}-950/50 flex items-center justify-center">
                        <svg class="size-5 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $stat['value'] }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Tabs --}}
    <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-800">
        <button
            type="button"
            wire:click="setTab('all')"
            class="px-4 py-2.5 text-sm font-semibold border-b-2 transition cursor-pointer {{ $activeTab === 'all' ? 'border-indigo-600 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300' }}"
        >
            All Routines ({{ $allRoutines->count() }})
        </button>

        <button
            type="button"
            wire:click="setTab('today')"
            class="px-4 py-2.5 text-sm font-semibold border-b-2 transition cursor-pointer {{ $activeTab === 'today' ? 'border-indigo-600 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300' }}"
        >
            Today ({{ $todayRoutines->count() }})
        </button>

        <button
            type="button"
            wire:click="setTab('upcoming')"
            class="px-4 py-2.5 text-sm font-semibold border-b-2 transition cursor-pointer {{ $activeTab === 'upcoming' ? 'border-indigo-600 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300' }}"
        >
            Upcoming ({{ $totalUpcomingCount }})
        </button>
    </div>

    {{-- TODAY TAB CONTENT --}}
    @if($activeTab === 'today')
        @if($todayRoutines->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 p-8 shadow-sm">
                <div class="size-16 rounded-3xl bg-indigo-50 dark:bg-indigo-950/40 flex items-center justify-center mb-4">
                    <svg class="size-8 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <p class="text-base font-bold text-slate-800 dark:text-white">No sessions scheduled for today ({{ now()->format('l') }})</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-md">Create a routine and schedule it for today or set repeat to daily to stay on track.</p>
                <button
                    type="button"
                    wire:click="openCreate"
                    class="mt-6 inline-flex items-center gap-2 rounded-2xl bg-indigo-600 hover:bg-indigo-700 px-5 py-2.5 text-xs font-bold text-white shadow-md transition"
                >
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Create Routine for Today
                </button>
            </div>
        @else
            <div class="flex items-center gap-2 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-3">
                <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Today's Schedule — {{ now()->format('l, F j, Y') }}
            </div>
            @include('livewire.routine._table', ['routines' => $todayRoutines, 'showDay' => false])
        @endif

    {{-- UPCOMING TAB CONTENT --}}
    @elseif($activeTab === 'upcoming')
        @if($upcomingRoutinesGrouped->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 p-8 shadow-sm">
                <div class="size-16 rounded-3xl bg-amber-50 dark:bg-amber-950/40 flex items-center justify-center mb-4">
                    <svg class="size-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-base font-bold text-slate-800 dark:text-white">No upcoming sessions in the next 7 days</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-md">Schedule active study routines across the week to build a consistent habit.</p>
                <button
                    type="button"
                    wire:click="openCreate"
                    class="mt-6 inline-flex items-center gap-2 rounded-2xl bg-indigo-600 hover:bg-indigo-700 px-5 py-2.5 text-xs font-bold text-white shadow-md transition"
                >
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Add Upcoming Routine
                </button>
            </div>
        @else
            <div class="space-y-6">
                @foreach($upcomingRoutinesGrouped as $dayLabel => $dayRoutines)
                    <div>
                        <div class="flex items-center gap-2.5 mb-2">
                            <span class="size-2 rounded-full bg-indigo-500"></span>
                            <h3 class="text-xs font-extrabold text-slate-700 dark:text-slate-300 uppercase tracking-wider">{{ $dayLabel }}</h3>
                            <span class="rounded-full bg-slate-100 dark:bg-slate-800 px-2 py-0.5 text-[11px] font-bold text-slate-600 dark:text-slate-400">{{ $dayRoutines->count() }}</span>
                        </div>
                        @include('livewire.routine._table', ['routines' => $dayRoutines, 'showDay' => false])
                    </div>
                @endforeach
            </div>
        @endif

    {{-- ALL ROUTINES TAB CONTENT --}}
    @else
        @if($allRoutines->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center rounded-3xl bg-white dark:bg-slate-900 border border-dashed border-slate-300 dark:border-slate-800 p-8 shadow-sm">
                <div class="size-20 rounded-3xl bg-gradient-to-br from-indigo-50 to-violet-50 dark:from-indigo-950/40 dark:to-violet-950/40 flex items-center justify-center mb-6 shadow-inner">
                    <svg class="size-10 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-lg font-extrabold text-slate-800 dark:text-white mb-1">No routines created yet</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-6 max-w-sm">Start building your personalized study schedule today to achieve your academic goals.</p>
                <button
                    type="button"
                    wire:click="openCreate"
                    class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 hover:bg-indigo-700 px-6 py-3 text-xs font-bold text-white shadow-lg transition"
                >
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Create First Routine
                </button>
            </div>
        @else
            @php
                $sortedAll = $allRoutines->sortBy(function($r) {
                    $order = ['monday'=>1,'tuesday'=>2,'wednesday'=>3,'thursday'=>4,'friday'=>5,'saturday'=>6,'sunday'=>7];
                    return ($order[strtolower($r->study_day)] ?? 8) . $r->start_time;
                });
            @endphp
            @include('livewire.routine._table', ['routines' => $sortedAll, 'showDay' => true])
        @endif
    @endif

    {{-- CREATE / EDIT MODAL --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm p-4 sm:p-6 flex min-h-full items-center justify-center">
            <div class="relative w-full max-w-lg sm:max-w-xl rounded-3xl bg-white dark:bg-slate-900 shadow-2xl border border-slate-200 dark:border-slate-800 my-auto flex flex-col max-h-[85vh] overflow-hidden">

                {{-- Fixed Modal Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 shrink-0">
                    <div class="flex items-center gap-2.5">
                        <div class="size-9 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-slate-900 dark:text-white">
                                {{ $editingId ? 'Edit Learning Routine' : 'Create New Routine' }}
                            </h2>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Schedule your study and practice sessions</p>
                        </div>
                    </div>
                    <button wire:click="closeModal" type="button" class="size-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:text-slate-200 dark:hover:bg-slate-800 transition text-lg leading-none">&times;</button>
                </div>

                {{-- Scrollable Modal Form Body --}}
                <form wire:submit.prevent="save" id="routine-form" class="flex-1 overflow-y-auto p-6 space-y-4">

                    {{-- Course Select --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Associated Course <span class="text-rose-500">*</span></label>
                        @if($courses->isEmpty())
                            <div class="rounded-xl border border-amber-200 bg-amber-50 dark:bg-amber-950/40 p-3 text-xs text-amber-800 dark:text-amber-300 flex items-center justify-between">
                                <span>⚠️ You don't have active courses.</span>
                                <a href="{{ route('courses.index') }}" class="font-bold underline hover:text-amber-900">Create a course &rarr;</a>
                            </div>
                        @else
                            <select wire:model="course_id" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-3.5 py-2 text-sm focus:border-indigo-500 focus:outline-none dark:text-white font-medium">
                                <option value="0">Select a course...</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_code }} — {{ $course->course_title }}</option>
                                @endforeach
                            </select>
                        @endif
                        @error('course_id') <p class="mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Routine Title --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Routine Title <span class="text-rose-500">*</span></label>
                        <input wire:model="title" type="text" placeholder="e.g. Morning Data Structures Study" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-3.5 py-2 text-sm focus:border-indigo-500 focus:outline-none dark:text-white font-medium">
                        @error('title') <p class="mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Day + Repeat --}}
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Study Day <span class="text-rose-500">*</span></label>
                            <select wire:model="study_day" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-3.5 py-2 text-sm focus:border-indigo-500 focus:outline-none dark:text-white font-medium">
                                @foreach($days as $day)
                                    <option value="{{ $day }}">{{ ucfirst($day) }}</option>
                                @endforeach
                            </select>
                            @error('study_day') <p class="mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Repeat Frequency <span class="text-rose-500">*</span></label>
                            <select wire:model="repeat_type" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-3.5 py-2 text-sm focus:border-indigo-500 focus:outline-none dark:text-white font-medium">
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="custom">Custom</option>
                            </select>
                            @error('repeat_type') <p class="mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Start Time + End Time --}}
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Start Time <span class="text-rose-500">*</span></label>
                            <input wire:model="start_time" type="time" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-3.5 py-2 text-sm focus:border-indigo-500 focus:outline-none dark:text-white font-medium">
                            @error('start_time') <p class="mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">End Time <span class="text-rose-500">*</span></label>
                            <input wire:model="end_time" type="time" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-3.5 py-2 text-sm focus:border-indigo-500 focus:outline-none dark:text-white font-medium">
                            @error('end_time') <p class="mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Study Duration + Practice Duration --}}
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Study Duration (mins) <span class="text-rose-500">*</span></label>
                            <input wire:model="study_duration" type="number" min="15" max="480" step="15" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-3.5 py-2 text-sm focus:border-indigo-500 focus:outline-none dark:text-white font-medium">
                            @error('study_duration') <p class="mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Practice Duration (mins)</label>
                            <input wire:model="practice_duration" type="number" min="0" max="240" step="15" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-3.5 py-2 text-sm focus:border-indigo-500 focus:outline-none dark:text-white font-medium">
                            @error('practice_duration') <p class="mt-1 text-xs text-rose-500 font-semibold">{{ $message }}</p> @enderror
                        </div>
                    </div>


                </form>

                {{-- Fixed Modal Footer --}}
                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/80 dark:bg-slate-950/50 shrink-0">
                    <button type="button" wire:click="closeModal" class="rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-200/60 dark:hover:bg-slate-800 transition">Cancel</button>
                    <button type="submit" form="routine-form" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 hover:bg-indigo-700 px-6 py-2.5 text-xs font-bold text-white shadow-lg shadow-indigo-600/25 transition disabled:opacity-60 cursor-pointer">
                        <svg wire:loading wire:target="save" class="animate-spin size-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        <span wire:loading.remove wire:target="save">{{ $editingId ? 'Update Routine' : 'Create Routine' }}</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- DELETE CONFIRM MODAL --}}
    @if($showDelete)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm p-4 flex min-h-full items-center justify-center">
            <div class="relative w-full max-w-sm rounded-3xl bg-white dark:bg-slate-900 shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-5 my-auto">
                <div class="flex items-center gap-3">
                    <div class="size-11 rounded-2xl bg-rose-50 dark:bg-rose-950/50 flex items-center justify-center shrink-0">
                        <svg class="size-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-extrabold text-slate-900 dark:text-white">Delete Routine?</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">This action cannot be undone.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button wire:click="cancelDelete" type="button" class="flex-1 rounded-2xl border border-slate-200 dark:border-slate-700 py-2.5 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition">Cancel</button>
                    <button wire:click="delete" type="button" class="flex-1 rounded-2xl bg-rose-600 hover:bg-rose-700 py-2.5 text-xs font-bold text-white shadow transition">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
