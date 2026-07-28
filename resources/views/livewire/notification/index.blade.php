<div class="min-h-screen bg-[#F8FAFC] dark:bg-slate-950">
    @include('components.dashboard.sidebar')

    <div class="lg:pl-64 flex flex-col min-h-screen transition-all duration-300">
        @include('components.dashboard.topbar')

        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-5xl w-full mx-auto space-y-6">

            {{-- Flash Alerts --}}
            @if(session('success'))
                <div class="flex items-center gap-2 rounded-2xl bg-emerald-50 border border-emerald-200 dark:bg-emerald-950/50 dark:border-emerald-800 p-4 text-sm font-semibold text-emerald-800 dark:text-emerald-200 shadow-sm">
                    <svg class="size-5 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Header --}}
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Notification Center</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Stay updated with study reminders, practice alerts, and summary notifications.</p>
                </div>

                <div class="flex items-center gap-3">
                    @if($unreadCount > 0)
                        <button
                            wire:click="markAllAsRead"
                            class="inline-flex items-center gap-2 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 hover:bg-indigo-100 dark:hover:bg-indigo-900/60 px-4 py-2.5 text-xs font-bold text-indigo-700 dark:text-indigo-300 transition"
                        >
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Mark All Read ({{ $unreadCount }})
                        </button>
                    @endif

                    @if($readCount > 0)
                        <button
                            wire:click="clearReadNotifications"
                            wire:confirm="Clear all read notifications?"
                            class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 dark:border-slate-800 hover:bg-slate-100 dark:hover:bg-slate-900 px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 transition"
                        >
                            Clear Read
                        </button>
                    @endif
                </div>
            </div>

            {{-- Filter Tabs --}}
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-3">
                <div class="flex items-center gap-2">
                    <button
                        wire:click="setFilter('all')"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $filter === 'all' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800' }}"
                    >
                        All ({{ $totalCount }})
                    </button>
                    <button
                        wire:click="setFilter('unread')"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $filter === 'unread' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800' }}"
                    >
                        Unread
                        @if($unreadCount > 0)
                            <span class="rounded-full {{ $filter === 'unread' ? 'bg-white/20 text-white' : 'bg-emerald-500 text-white' }} px-1.5 py-0.5 text-[10px] font-extrabold">{{ $unreadCount }}</span>
                        @endif
                    </button>
                    <button
                        wire:click="setFilter('read')"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $filter === 'read' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800' }}"
                    >
                        Read ({{ $readCount }})
                    </button>
                </div>

                {{-- Type Dropdown Filter --}}
                <div class="w-full sm:w-auto">
                    <select wire:model.live="typeFilter" class="w-full sm:w-auto rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-3 py-1.5 text-xs font-semibold text-slate-700 dark:text-slate-300 focus:outline-none">
                        <option value="">All Types</option>
                        <option value="study_reminder">Study Reminders</option>
                        <option value="practice_reminder">Practice Reminders</option>
                        <option value="summary_ready">Summary Alerts</option>
                        <option value="routine_reminder">Routine Reminders</option>
                        <option value="system_notification">System Alerts</option>
                        <option value="weekly_progress">Weekly Progress</option>
                    </select>
                </div>
            </div>

            {{-- Notifications List --}}
            @if($notifications->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 text-center">
                    <div class="size-20 rounded-3xl bg-indigo-50 dark:bg-indigo-950/40 flex items-center justify-center mb-4">
                        <svg class="size-10 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <p class="text-base font-extrabold text-slate-800 dark:text-white">All caught up!</p>
                    <p class="text-sm text-slate-400 mt-1">No {{ $filter !== 'all' ? $filter : '' }} notifications found.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($notifications as $notification)
                        <div class="group relative flex items-start gap-4 rounded-3xl border {{ $notification->is_read ? 'border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 opacity-80 hover:opacity-100' : 'border-indigo-200 dark:border-indigo-900 bg-indigo-50/40 dark:bg-indigo-950/20 shadow-sm' }} p-4 sm:p-5 transition duration-200">

                            {{-- Type Icon --}}
                            @include('livewire.notification._icon', ['type' => $notification->type])

                            {{-- Content --}}
                            <div class="flex-1 min-w-0 pr-12">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <h3 class="text-sm font-extrabold text-slate-900 dark:text-white truncate">{{ $notification->title }}</h3>
                                    <span class="rounded-full bg-slate-100 dark:bg-slate-800 px-2.5 py-0.5 text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wide">
                                        {{ $notification->type_label }}
                                    </span>
                                    @if(!$notification->is_read)
                                        <span class="size-2 rounded-full bg-emerald-500"></span>
                                    @endif
                                </div>

                                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">{{ $notification->message }}</p>

                                <div class="flex items-center gap-4 mt-3">
                                    <span class="text-[11px] text-slate-400 dark:text-slate-500 font-medium">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>

                                    @if($notification->action_url)
                                        <a href="{{ $notification->action_url }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 inline-flex items-center gap-1">
                                            View Details
                                            <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            {{-- Action Menu --}}
                            <div class="absolute right-4 top-4 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                                @if(!$notification->is_read)
                                    <button
                                        wire:click="markAsRead({{ $notification->id }})"
                                        class="size-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-slate-100 dark:hover:bg-slate-800 transition"
                                        title="Mark as Read"
                                    >
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                @endif
                                <button
                                    wire:click="deleteNotification({{ $notification->id }})"
                                    class="size-8 rounded-xl flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition"
                                    title="Delete"
                                >
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-4">
                    {{ $notifications->links() }}
                </div>
            @endif

        </main>
    </div>
</div>
