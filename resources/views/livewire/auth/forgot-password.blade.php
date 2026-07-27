<div class="relative flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8 overflow-hidden bg-[#F8FAFC] dark:bg-slate-950">
    <div class="pointer-events-none absolute -top-40 -left-40 size-96 rounded-full bg-indigo-500/10 blur-3xl dark:bg-indigo-600/15"></div>

    <x-auth.card class="w-full max-w-md">
        <div class="text-center space-y-2 mb-6">
            <div class="mx-auto flex size-12 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600 dark:bg-indigo-950 dark:text-indigo-400">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
            <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">Reset Password</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400">Enter your email address and we will send you a password reset link.</p>
        </div>

        @if ($status)
            <div class="mb-6 rounded-2xl bg-emerald-50 p-4 border border-emerald-200 dark:bg-emerald-950/40 dark:border-emerald-800">
                <p class="text-xs font-semibold text-emerald-800 dark:text-emerald-300 text-center">{{ $status }}</p>
            </div>
        @endif

        <form wire:submit="sendPasswordResetLink" class="space-y-5">
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Email Address
                </label>
                <input 
                    wire:model="email" 
                    type="email" 
                    id="email" 
                    required 
                    autofocus 
                    placeholder="student@university.edu"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 dark:border-slate-800 dark:bg-slate-800/50 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-indigo-400 dark:focus:bg-slate-900"
                />
                @error('email')
                    <p class="mt-1.5 text-xs font-semibold text-rose-600 dark:text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <button 
                type="submit" 
                wire:loading.attr="disabled"
                class="relative flex w-full items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-6 py-4 text-base font-semibold text-white shadow-lg shadow-indigo-500/25 transition-all duration-200 hover:-translate-y-0.5 hover:bg-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-500/25 active:translate-y-0 disabled:opacity-60 disabled:cursor-not-allowed"
            >
                <span wire:loading.remove wire:target="sendPasswordResetLink">Send Password Reset Link</span>
                <span wire:loading wire:target="sendPasswordResetLink" class="inline-flex items-center gap-2">
                    <svg class="size-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Sending Link...
                </span>
            </button>
        </form>

        <div class="mt-6 text-center text-xs text-slate-500 dark:text-slate-400">
            Remembered your password? 
            <a 
                href="{{ route('login') }}" 
                wire:navigate 
                class="font-bold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition"
            >
                Back to Login
            </a>
        </div>
    </x-auth.card>
</div>
