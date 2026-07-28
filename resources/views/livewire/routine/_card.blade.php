@php
    $colorMap = [
        'monday'    => 'indigo',
        'tuesday'   => 'violet',
        'wednesday' => 'blue',
        'thursday'  => 'emerald',
        'friday'    => 'amber',
        'saturday'  => 'rose',
        'sunday'    => 'purple',
    ];
    $color = $colorMap[strtolower($routine->study_day)] ?? 'indigo';
    $repeatBadge = match($routine->repeat_type) {
        'daily'  => ['label' => 'Daily',  'bg' => 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300'],
        'weekly' => ['label' => 'Weekly', 'bg' => 'bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300'],
        default  => ['label' => 'Custom', 'bg' => 'bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300'],
    };
@endphp

<div class="group rounded-3xl border {{ $routine->status ? 'border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900' : 'border-dashed border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 opacity-60' }} p-5 shadow-sm hover:shadow-md transition-all duration-200 space-y-4">

    {{-- Top row: time + actions --}}
    <div class="flex items-start justify-between gap-3">
        <div class="flex items-center gap-2">
            {{-- Color dot --}}
            <span class="size-2.5 rounded-full bg-{{ $color }}-500 shrink-0"></span>
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">
                    {{ $routine->formattedStart() }} — {{ $routine->formattedEnd() }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
            <button
                wire:click="openEdit({{ $routine->id }})"
                class="size-7 rounded-lg flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 transition"
                title="Edit"
            >
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            </button>
            <button
                wire:click="toggleStatus({{ $routine->id }})"
                class="size-7 rounded-lg flex items-center justify-center text-slate-400 hover:text-{{ $routine->status ? 'amber' : 'emerald' }}-600 hover:bg-{{ $routine->status ? 'amber' : 'emerald' }}-50 transition"
                title="{{ $routine->status ? 'Deactivate' : 'Activate' }}"
            >
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    @if($routine->status)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    @endif
                </svg>
            </button>
            <button
                wire:click="confirmDelete({{ $routine->id }})"
                class="size-7 rounded-lg flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition"
                title="Delete"
            >
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        </div>
    </div>

    {{-- Title + Course --}}
    <div>
        <h4 class="text-sm font-extrabold text-slate-900 dark:text-white leading-tight">{{ $routine->title }}</h4>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $routine->course->course_code ?? '' }} — {{ $routine->course->course_title ?? 'Course' }}</p>
    </div>

    {{-- Duration chips --}}
    <div class="flex flex-wrap items-center gap-2">
        <span class="inline-flex items-center gap-1 rounded-lg bg-slate-100 dark:bg-slate-800 px-2.5 py-1 text-[11px] font-bold text-slate-600 dark:text-slate-300">
            <svg class="size-3 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            Study {{ $routine->study_duration }}m
        </span>
        @if($routine->practice_duration > 0)
            <span class="inline-flex items-center gap-1 rounded-lg bg-violet-50 dark:bg-violet-950/40 px-2.5 py-1 text-[11px] font-bold text-violet-700 dark:text-violet-300">
                <svg class="size-3 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Practice {{ $routine->practice_duration }}m
            </span>
        @endif
        <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-[11px] font-bold {{ $repeatBadge['bg'] }}">
            {{ $repeatBadge['label'] }}
        </span>
        @if(!$routine->status)
            <span class="rounded-lg bg-slate-200 dark:bg-slate-700 px-2.5 py-1 text-[11px] font-bold text-slate-500 dark:text-slate-400">Inactive</span>
        @endif
    </div>

    {{-- Reminder --}}
    <div class="flex items-center gap-1.5 text-[11px] text-slate-400 dark:text-slate-500 font-medium">
        <svg class="size-3.5 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        Reminder {{ $routine->reminder_before >= 60 ? '1 hour' : $routine->reminder_before . ' mins' }} before
    </div>
</div>
