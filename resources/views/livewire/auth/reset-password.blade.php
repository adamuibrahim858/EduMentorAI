<div class="relative flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8 overflow-hidden bg-[#F8FAFC] dark:bg-slate-950">
    <div class="pointer-events-none absolute -top-40 -left-40 size-96 rounded-full bg-indigo-500/10 blur-3xl dark:bg-indigo-600/15"></div>

    <x-auth.card class="w-full max-w-md">
        <div class="text-center space-y-2 mb-6">
            <div class="mx-auto flex size-12 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600 dark:bg-indigo-950 dark:text-indigo-400">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">Create New Password</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400">Your new password must be different from previous passwords.</p>
        </div>

        <form wire:submit="resetPassword" class="space-y-4">
            <input type="hidden" wire:model="token">

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Email Address
                </label>
                <input 
                    wire:model="email" 
                    type="email" 
                    id="email" 
                    required 
                    placeholder="student@university.edu"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 dark:border-slate-800 dark:bg-slate-800/50 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-indigo-400 dark:focus:bg-slate-900"
                />
                @error('email')
                    <p class="mt-1.5 text-xs font-semibold text-rose-600 dark:text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    New Password
                </label>
                <input 
                    wire:model="password" 
                    type="password" 
                    id="password" 
                    required 
                    placeholder="Minimum 8 characters"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 dark:border-slate-800 dark:bg-slate-800/50 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-indigo-400 dark:focus:bg-slate-900"
                />
                @error('password')
                    <p class="mt-1.5 text-xs font-semibold text-rose-600 dark:text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm New Password -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    Confirm New Password
                </label>
                <input 
                    wire:model="password_confirmation" 
                    type="password" 
                    id="password_confirmation" 
                    required 
                    placeholder="Re-enter password"
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 dark:border-slate-800 dark:bg-slate-800/50 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-indigo-400 dark:focus:bg-slate-900"
                />
            </div>

            <button 
                type="submit" 
                wire:loading.attr="disabled"
                class="relative flex w-full items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-6 py-4 text-base font-semibold text-white shadow-lg shadow-indigo-500/25 transition-all duration-200 hover:-translate-y-0.5 hover:bg-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-500/25 active:translate-y-0 disabled:opacity-60 disabled:cursor-not-allowed mt-4"
            >
                <span wire:loading.remove wire:target="resetPassword">Reset Password</span>
                <span wire:loading wire:target="resetPassword" class="inline-flex items-center gap-2">
                    <svg class="size-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Updating Password...
                </span>
            </button>
        </form>
    </x-auth.card>
</div>
