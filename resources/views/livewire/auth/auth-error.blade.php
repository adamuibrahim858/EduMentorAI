<div class="relative flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8 overflow-hidden bg-[#F8FAFC] dark:bg-slate-950">
    <div class="pointer-events-none absolute -top-40 -left-40 size-96 rounded-full bg-rose-500/10 blur-3xl dark:bg-rose-600/15"></div>

    <x-auth.card class="text-center w-full max-w-md">
        <div class="mx-auto flex size-16 items-center justify-center rounded-2xl bg-rose-500/10 text-rose-600 shadow-inner dark:bg-rose-500/20 dark:text-rose-400">
            <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>

        <div class="mt-6 space-y-2">
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Authentication Failed</h1>
            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ $message }}</p>
        </div>

        <a
            href="{{ route('login') }}"
            wire:navigate
            class="mt-8 inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-6 py-4 text-base font-semibold text-white shadow-lg shadow-indigo-500/25 transition-all duration-200 hover:-translate-y-0.5 hover:bg-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-500/25 active:translate-y-0"
        >
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
            Retry Login
        </a>
    </x-auth.card>
</div>

