<div class="relative flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8 overflow-hidden bg-[#F8FAFC] dark:bg-slate-950">
    <div class="pointer-events-none absolute -top-40 -left-40 size-96 rounded-full bg-indigo-500/10 blur-3xl dark:bg-indigo-600/15"></div>

    <x-auth.card class="w-full max-w-md text-center">
        <div class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600 dark:bg-indigo-950 dark:text-indigo-400">
            <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>

        <div class="mt-6 space-y-2">
            <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">Verify Your Email Address</h2>
            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you.
            </p>
        </div>

        @if ($verificationSent)
            <div class="mt-6 rounded-2xl bg-emerald-50 p-4 border border-emerald-200 dark:bg-emerald-950/40 dark:border-emerald-800">
                <p class="text-xs font-semibold text-emerald-800 dark:text-emerald-300">
                    A new verification link has been sent to the email address you provided during registration.
                </p>
            </div>
        @endif

        <div class="mt-8 space-y-3">
            <button 
                wire:click="sendVerificationNotification" 
                wire:loading.attr="disabled"
                class="relative flex w-full items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-6 py-4 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition-all duration-200 hover:-translate-y-0.5 hover:bg-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-500/25 active:translate-y-0 disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="sendVerificationNotification">Resend Verification Email</span>
                <span wire:loading wire:target="sendVerificationNotification" class="inline-flex items-center gap-2">
                    <svg class="size-4 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Sending Email...
                </span>
            </button>

            <button 
                wire:click="logout" 
                class="w-full text-xs font-semibold text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 py-2 transition"
            >
                Log Out
            </button>
        </div>
    </x-auth.card>
</div>
