@props(['user'])

@php
    $notifService  = app(\App\Services\NotificationService::class);
    $dashboardNotifs = $notifService->getRecent(limit: 5);
    $unreadCount     = $notifService->getUnreadCount();
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">Notifications & Activity</h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Your latest 5 study reminders, practice alerts, and system notifications.</p>
        </div>
        <a 
            href="{{ route('notifications.index') }}"
            class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 hover:bg-indigo-700 px-4 py-2.5 text-xs font-bold text-white shadow transition w-fit"
        >
            Open Notification Center
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
    </div>

    <!-- Latest 5 Notifications List -->
    <div class="space-y-3">
        @forelse($dashboardNotifs as $notification)
            <div class="group relative flex items-start gap-4 rounded-3xl border {{ !$notification->is_read ? 'border-indigo-200 dark:border-indigo-900 bg-indigo-50/40 dark:bg-indigo-950/20' : 'border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900' }} p-4 sm:p-5 shadow-sm transition">
                @include('livewire.notification._icon', ['type' => $notification->type])
                
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <div class="flex items-center gap-2">
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ $notification->title }}</h4>
                            <span class="rounded-full bg-slate-100 dark:bg-slate-800 px-2 py-0.5 text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wide">
                                {{ $notification->type_label }}
                            </span>
                        </div>
                        <span class="text-[11px] font-medium text-slate-400 shrink-0">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-300">{{ $notification->message }}</p>
                    @if($notification->action_url)
                        <a href="{{ $notification->action_url }}" class="mt-2 inline-flex items-center gap-1 text-xs font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">
                            View Details →
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="rounded-3xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 p-12 text-center">
                <div class="size-16 rounded-2xl bg-indigo-50 dark:bg-indigo-950/40 flex items-center justify-center mx-auto mb-3">
                    <svg class="size-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <p class="text-sm font-extrabold text-slate-800 dark:text-white">No notifications yet</p>
                <p class="text-xs text-slate-400 mt-1">You're all caught up!</p>
            </div>
        @endforelse
    </div>
</div>
