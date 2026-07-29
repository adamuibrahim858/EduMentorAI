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
@endphp

<div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/50">
                    <th class="px-4 py-3 text-left text-[11px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">Routine</th>
                    @if($showDay)
                        <th class="px-4 py-3 text-left text-[11px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">Day</th>
                    @endif
                    <th class="px-4 py-3 text-left text-[11px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">Time</th>
                    <th class="px-4 py-3 text-left text-[11px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">Duration</th>
                    <th class="px-4 py-3 text-left text-[11px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">Repeat</th>
                    <th class="px-4 py-3 text-left text-[11px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                    <th class="px-4 py-3 text-right text-[11px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($routines as $routine)
                    @php
                        $color = $colorMap[strtolower($routine->study_day)] ?? 'indigo';
                        $repeatBadge = match($routine->repeat_type) {
                            'daily'  => ['label' => 'Daily',  'cls' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300'],
                            'weekly' => ['label' => 'Weekly', 'cls' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/50 dark:text-indigo-300'],
                            default  => ['label' => 'Custom', 'cls' => 'bg-amber-50 text-amber-700 dark:bg-amber-950/50 dark:text-amber-300'],
                        };
                        $totalMins = $routine->study_duration + $routine->practice_duration;
                    @endphp
                    <tr class="group hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">

                        {{-- Routine Title + Course --}}
                        <td class="px-4 py-3.5">
                            <div class="flex items-center gap-3">
                                <span class="size-2.5 rounded-full bg-{{ $color }}-500 shrink-0"></span>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ $routine->title }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                                        {{ $routine->course->course_code ?? '' }}
                                        @if($routine->course?->course_title) — {{ $routine->course->course_title }} @endif
                                    </p>
                                </div>
                            </div>
                        </td>

                        {{-- Day (conditional) --}}
                        @if($showDay)
                            <td class="px-4 py-3.5">
                                <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-[11px] font-bold bg-{{ $color }}-50 text-{{ $color }}-700 dark:bg-{{ $color }}-950/50 dark:text-{{ $color }}-300">
                                    {{ ucfirst($routine->study_day) }}
                                </span>
                            </td>
                        @endif

                        {{-- Time --}}
                        <td class="px-4 py-3.5">
                            <span class="text-xs font-semibold text-slate-700 dark:text-slate-300 whitespace-nowrap">
                                {{ $routine->formattedStart() }} – {{ $routine->formattedEnd() }}
                            </span>
                        </td>

                        {{-- Duration --}}
                        <td class="px-4 py-3.5">
                            <div class="flex flex-wrap gap-1.5">
                                <span class="inline-flex items-center gap-1 rounded-md bg-slate-100 dark:bg-slate-800 px-2 py-0.5 text-[11px] font-bold text-slate-600 dark:text-slate-300">
                                    📖 {{ $routine->study_duration }}m
                                </span>
                                @if($routine->practice_duration > 0)
                                    <span class="inline-flex items-center gap-1 rounded-md bg-violet-50 dark:bg-violet-950/40 px-2 py-0.5 text-[11px] font-bold text-violet-700 dark:text-violet-300">
                                        ✏️ {{ $routine->practice_duration }}m
                                    </span>
                                @endif
                            </div>
                        </td>

                        {{-- Repeat --}}
                        <td class="px-4 py-3.5">
                            <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-[11px] font-bold {{ $repeatBadge['cls'] }}">
                                {{ $repeatBadge['label'] }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td class="px-4 py-3.5">
                            @if($routine->status)
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-950/50 px-2.5 py-1 text-[11px] font-bold text-emerald-700 dark:text-emerald-300">
                                    <span class="size-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 px-2.5 py-1 text-[11px] font-bold text-slate-500 dark:text-slate-400">
                                    <span class="size-1.5 rounded-full bg-slate-400"></span>
                                    Inactive
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-4 py-3.5 text-right">
                            <div class="inline-flex items-center gap-1">
                                <button
                                    wire:click="openEdit({{ $routine->id }})"
                                    class="size-7 rounded-lg flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 transition"
                                    title="Edit"
                                >
                                    <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                                <button
                                    wire:click="toggleStatus({{ $routine->id }})"
                                    class="size-7 rounded-lg flex items-center justify-center text-slate-400 hover:text-{{ $routine->status ? 'amber' : 'emerald' }}-600 hover:bg-{{ $routine->status ? 'amber' : 'emerald' }}-50 dark:hover:bg-{{ $routine->status ? 'amber' : 'emerald' }}-950/30 transition"
                                    title="{{ $routine->status ? 'Deactivate' : 'Activate' }}"
                                >
                                    <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                    <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
