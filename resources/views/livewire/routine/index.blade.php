<div class="min-h-screen bg-[#F8FAFC] dark:bg-slate-950">
    @include('components.dashboard.sidebar')

    <div class="lg:pl-64 flex flex-col min-h-screen transition-all duration-300">
        @include('components.dashboard.topbar')

        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-8">

            {{-- Flash Alerts --}}
            @if(session('success'))
                <div class="flex items-center gap-2 rounded-2xl bg-emerald-50 border border-emerald-200 dark:bg-emerald-950/50 dark:border-emerald-800 p-4 text-sm font-semibold text-emerald-800 dark:text-emerald-200 shadow-sm">
                    <svg class="size-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-2 rounded-2xl bg-rose-50 border border-rose-200 dark:bg-rose-950/50 dark:border-rose-800 p-4 text-sm font-semibold text-rose-800 dark:text-rose-200 shadow-sm">
                    <svg class="size-5 shrink-0 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Page Header --}}
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Learning Routine</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Build consistent study habits with your personalised schedule.</p>
                </div>
                <button
                    wire:click="openCreate"
                    class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 px-5 py-2.5 text-sm font-bold text-white shadow-lg transition"
                >
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    New Routine
                </button>
            </div>

            {{-- Stats Row --}}
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                @php
                    $totalActive   = $allRoutines->where('status', true)->count();
                    $totalMinutes  = $allRoutines->where('status', true)->sum('study_duration');
                    $todayCount    = $todayRoutines->where('status', true)->count();
                    $upcomingCount = $upcomingRoutines->count();
                @endphp
                @foreach([
                    ['label'=>'Active Routines','value'=>$totalActive,'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'indigo'],
                    ['label'=>'Today\'s Sessions','value'=>$todayCount,'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','color'=>'emerald'],
                    ['label'=>'Weekly Minutes','value'=>number_format($totalMinutes),'icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','color'=>'violet'],
                    ['label'=>'Upcoming (7d)','value'=>$upcomingCount,'icon'=>'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6','color'=>'amber'],
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
                @foreach(['all'=>'All Routines','today'=>"Today ({$todayCount})",'upcoming'=>'Upcoming'] as $key=>$label)
                    <button
                        wire:click="$set('activeTab','{{ $key }}')"
                        class="px-4 py-2.5 text-sm font-semibold border-b-2 transition {{ $activeTab === $key ? 'border-indigo-600 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400' : 'border-transparent text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300' }}"
                    >{{ $label }}</button>
                @endforeach
            </div>

            {{-- TODAY TAB --}}
            @if($activeTab === 'today')
                @if($todayRoutines->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="size-16 rounded-3xl bg-indigo-50 dark:bg-indigo-950/40 flex items-center justify-center mb-4">
                            <svg class="size-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <p class="text-base font-bold text-slate-700 dark:text-slate-300">No sessions today</p>
                        <p class="text-sm text-slate-400 mt-1">Create a routine and schedule it for {{ now()->format('l') }}.</p>
                    </div>
                @else
                    {{-- Timeline --}}
                    <div class="relative space-y-4 pl-8 before:absolute before:left-3.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-indigo-200 dark:before:bg-indigo-900">
                        @foreach($todayRoutines->sortBy('start_time') as $routine)
                            <div class="relative">
                                <span class="absolute -left-8 top-4 size-4 rounded-full border-2 {{ $routine->status ? 'border-indigo-600 bg-white dark:bg-slate-950' : 'border-slate-300 bg-slate-100 dark:bg-slate-800' }}"></span>
                                @include('livewire.routine._card', ['routine' => $routine])
                            </div>
                        @endforeach
                    </div>
                @endif

            {{-- UPCOMING TAB --}}
            @elseif($activeTab === 'upcoming')
                @if($upcomingRoutines->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <p class="text-base font-bold text-slate-700 dark:text-slate-300">No upcoming sessions in next 7 days</p>
                    </div>
                @else
                    @php
                        $grouped = $upcomingRoutines->groupBy(fn($r) => ucfirst($r->study_day));
                    @endphp
                    <div class="space-y-8">
                        @foreach($grouped as $day => $dayRoutines)
                            <div>
                                <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3">{{ $day }}</h3>
                                <div class="space-y-3">
                                    @foreach($dayRoutines->sortBy('start_time') as $routine)
                                        @include('livewire.routine._card', ['routine' => $routine])
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            {{-- ALL ROUTINES TAB --}}
            @else
                @if($allRoutines->isEmpty())
                    <div class="flex flex-col items-center justify-center py-24 text-center">
                        <div class="size-20 rounded-3xl bg-gradient-to-br from-indigo-50 to-violet-50 dark:from-indigo-950/40 dark:to-violet-950/40 flex items-center justify-center mb-6 shadow-inner">
                            <svg class="size-10 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-lg font-extrabold text-slate-800 dark:text-white mb-2">No routines yet</p>
                        <p class="text-sm text-slate-400 mb-6">Start building your study schedule today.</p>
                        <button wire:click="openCreate" class="rounded-2xl bg-indigo-600 hover:bg-indigo-700 px-6 py-2.5 text-sm font-bold text-white shadow transition">Create First Routine</button>
                    </div>
                @else
                    @php
                        $grouped = $allRoutines->groupBy(fn($r) => ucfirst($r->study_day));
                        $dayOrder = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                        $grouped = collect($dayOrder)->filter(fn($d)=>$grouped->has($d))->mapWithKeys(fn($d)=>[$d=>$grouped[$d]]);
                    @endphp
                    <div class="space-y-8">
                        @foreach($grouped as $day => $dayRoutines)
                            <div>
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="size-9 rounded-2xl {{ strtolower($day) === strtolower(now()->format('l')) ? 'bg-indigo-600' : 'bg-slate-100 dark:bg-slate-800' }} flex items-center justify-center">
                                        <span class="text-xs font-bold {{ strtolower($day) === strtolower(now()->format('l')) ? 'text-white' : 'text-slate-600 dark:text-slate-300' }}">{{ strtoupper(substr($day,0,3)) }}</span>
                                    </div>
                                    <h3 class="text-sm font-extrabold text-slate-700 dark:text-slate-300">{{ $day }}</h3>
                                    <span class="rounded-full bg-slate-100 dark:bg-slate-800 px-2 py-0.5 text-xs font-bold text-slate-600 dark:text-slate-400">{{ $dayRoutines->count() }}</span>
                                    @if(strtolower($day) === strtolower(now()->format('l')))
                                        <span class="rounded-full bg-indigo-100 dark:bg-indigo-950 px-2.5 py-0.5 text-xs font-bold text-indigo-700 dark:text-indigo-300">Today</span>
                                    @endif
                                </div>
                                <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                                    @foreach($dayRoutines->sortBy('start_time') as $routine)
                                        @include('livewire.routine._card', ['routine' => $routine])
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif

        </main>
    </div>

    {{-- ================================================================
         CREATE / EDIT MODAL
    ================================================================ --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-data>
            <div class="w-full max-w-2xl rounded-3xl bg-white dark:bg-slate-900 shadow-2xl border border-slate-200 dark:border-slate-800 max-h-[90vh] overflow-y-auto">

                {{-- Modal Header --}}
                <div class="sticky top-0 flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 rounded-t-3xl z-10">
                    <h2 class="text-base font-extrabold text-slate-900 dark:text-white">
                        {{ $editingId ? 'Edit Routine' : 'New Learning Routine' }}
                    </h2>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 text-xl leading-none">✕</button>
                </div>

                {{-- Modal Body --}}
                <form wire:submit="save" class="p-6 space-y-5">

                    {{-- Course --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Course <span class="text-rose-500">*</span></label>
                        <select wire:model="course_id" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                            <option value="0">Select a course...</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_code }} — {{ $course->course_title }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Title --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Routine Title <span class="text-rose-500">*</span></label>
                        <input wire:model="title" type="text" placeholder="e.g. Morning Data Structures Study" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                        @error('title') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Day + Repeat --}}
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Study Day <span class="text-rose-500">*</span></label>
                            <select wire:model="study_day" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                                @foreach($days as $day)
                                    <option value="{{ $day }}">{{ ucfirst($day) }}</option>
                                @endforeach
                            </select>
                            @error('study_day') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Repeat <span class="text-rose-500">*</span></label>
                            <select wire:model="repeat_type" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="custom">Custom</option>
                            </select>
                            @error('repeat_type') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Start Time + End Time --}}
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Start Time <span class="text-rose-500">*</span></label>
                            <input wire:model="start_time" type="time" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                            @error('start_time') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">End Time <span class="text-rose-500">*</span></label>
                            <input wire:model="end_time" type="time" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                            @error('end_time') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Study Duration + Practice Duration --}}
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Study Duration (mins) <span class="text-rose-500">*</span></label>
                            <input wire:model="study_duration" type="number" min="15" max="480" step="15" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                            @error('study_duration') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Practice Duration (mins)</label>
                            <input wire:model="practice_duration" type="number" min="0" max="240" step="15" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                            @error('practice_duration') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Reminder --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase mb-1.5">Reminder Before</label>
                        <select wire:model="reminder_before" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none dark:text-white">
                            @foreach($reminderOptions as $mins => $label)
                                <option value="{{ $mins }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status toggle --}}
                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            wire:click="$set('status', !$status)"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition {{ $status ? 'bg-indigo-600' : 'bg-slate-300 dark:bg-slate-600' }}"
                        >
                            <span class="size-5 rounded-full bg-white shadow transform transition {{ $status ? 'translate-x-5' : 'translate-x-1' }}"></span>
                        </button>
                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $status ? 'Active' : 'Inactive' }}</span>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-800 pt-5">
                        <button type="button" wire:click="$set('showModal', false)" class="rounded-xl px-4 py-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Cancel</button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="save" class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 px-6 py-2.5 text-sm font-bold text-white shadow-lg transition disabled:opacity-60">
                            <svg wire:loading wire:target="save" class="animate-spin size-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            <span wire:loading.remove wire:target="save">{{ $editingId ? 'Update Routine' : 'Create Routine' }}</span>
                            <span wire:loading wire:target="save">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- ================================================================
         DELETE CONFIRM MODAL
    ================================================================ --}}
    @if($showDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="w-full max-w-sm rounded-3xl bg-white dark:bg-slate-900 shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-5">
                <div class="flex items-center gap-3">
                    <div class="size-11 rounded-2xl bg-rose-50 dark:bg-rose-950/50 flex items-center justify-center">
                        <svg class="size-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-extrabold text-slate-900 dark:text-white">Delete Routine?</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">This action cannot be undone.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button wire:click="cancelDelete" class="flex-1 rounded-2xl border border-slate-200 dark:border-slate-700 py-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition">Cancel</button>
                    <button wire:click="delete" class="flex-1 rounded-2xl bg-rose-600 hover:bg-rose-700 py-2 text-sm font-bold text-white shadow transition">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
