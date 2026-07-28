<x-layouts.dashboard title="Settings">
    <div class="space-y-6">
        {{-- Breadcrumb Navigation --}}
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Dashboard</a>
            <svg class="size-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-slate-900 dark:text-white font-bold">Settings</span>
        </nav>

        {{-- Page Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-600 dark:bg-indigo-950/60 dark:text-indigo-400 mb-2">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Settings & Preferences
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    Application & Account Settings
                </h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Manage AI tutor persona, theme settings, notifications, account security, and system preferences.
                </p>
            </div>
        </div>

        {{-- Settings Content View Component --}}
        <x-dashboard.settings-view :user="$user" />

        {{-- Danger Zone Section --}}
        <div class="rounded-3xl border border-rose-200/80 bg-rose-50/30 p-6 dark:border-rose-900/50 dark:bg-rose-950/10 space-y-4">
            <h3 class="text-base font-extrabold text-rose-700 dark:text-rose-400">Danger Zone</h3>
            <p class="text-xs text-rose-600/80 dark:text-rose-300/80">Irreversible account actions. Please proceed with caution.</p>
            
            <div class="flex items-center justify-between pt-2">
                <div>
                    <p class="text-xs font-bold text-slate-900 dark:text-white">Delete Account Data</p>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Permanently erase your study progress, AI summaries, and enrolled courses.</p>
                </div>
                <button 
                    type="button" 
                    @click="alert('Account deletion requires explicit security confirmation. (Protected Action)')"
                    class="rounded-xl bg-rose-600 hover:bg-rose-700 px-4 py-2 text-xs font-bold text-white shadow-sm transition"
                >
                    Delete Account
                </button>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
