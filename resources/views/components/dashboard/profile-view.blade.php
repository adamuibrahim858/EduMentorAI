@props(['user'])

<div class="space-y-8">
    <!-- Header / Cover Banner -->
    <div class="relative overflow-hidden rounded-3xl border border-slate-200/80 bg-gradient-to-r from-indigo-900 via-slate-900 to-purple-950 p-6 sm:p-10 text-white shadow-xl dark:border-slate-800">
        <!-- Background Ambient Glow -->
        <div class="absolute -right-20 -top-20 size-80 rounded-full bg-indigo-500/20 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 size-80 rounded-full bg-purple-500/20 blur-3xl"></div>

        <div class="relative z-10 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                <!-- Large Avatar with Gradient Ring -->
                <div class="relative size-28 shrink-0 rounded-3xl p-1 bg-gradient-to-tr from-indigo-500 via-purple-500 to-blue-400 shadow-2xl">
                    <img 
                        src="{{ $user->avatar ?: 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=4f46e5&color=fff' }}" 
                        alt="{{ $user->name }}" 
                        class="size-full rounded-[1.3rem] object-cover"
                    >
                    <div class="absolute -bottom-1 -right-1 flex size-7 items-center justify-center rounded-xl bg-emerald-500 text-white ring-4 ring-slate-900 shadow-md">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <div class="flex items-center gap-2">
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">{{ $user->name }}</h1>
                        <span class="rounded-full bg-indigo-500/30 px-3 py-1 text-xs font-bold text-indigo-200 border border-indigo-400/30">Verified</span>
                    </div>
                    <p class="text-sm text-slate-300">{{ $user->email }}</p>
                    <p class="text-xs text-indigo-300 font-medium">EduMentor AI Premium Student • Joined {{ $user->created_at?->format('M Y') ?? 'Recently' }}</p>
                </div>
            </div>

            <!-- Edit Profile Button (UI only) -->
            <button 
                type="button" 
                @click="alert('Edit profile modal (UI Preview)')"
                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow-lg transition hover:bg-slate-100 hover:-translate-y-0.5 active:translate-y-0"
            >
                <svg class="size-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Edit Profile
            </button>
        </div>
    </div>

    <!-- User Information Grid -->
    <div>
        <h3 class="text-base font-bold text-slate-900 dark:text-white mb-4">Account Metadata & Information</h3>
        
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Information Card 1: Google Account -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between text-slate-400 mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Google Account</span>
                    <svg class="size-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ $user->email }}</p>
                <span class="mt-2 inline-block rounded-md bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">OAuth 2.0 Connected</span>
            </div>

            <!-- Information Card 2: Email -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between text-slate-400 mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Email Address</span>
                    <svg class="size-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ $user->email }}</p>
                <span class="mt-2 inline-block rounded-md bg-indigo-100 px-2 py-0.5 text-[10px] font-bold text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">Verified Primary</span>
            </div>

            <!-- Information Card 3: Member Since -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between text-slate-400 mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Member Since</span>
                    <svg class="size-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $user->created_at?->format('M j, Y') ?? 'N/A' }}</p>
                <span class="mt-2 inline-block text-[11px] text-slate-500 dark:text-slate-400">Standard Tier</span>
            </div>

            <!-- Information Card 4: Provider -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between text-slate-400 mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Auth Provider</span>
                    <svg class="size-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-900 dark:text-white capitalize">{{ $user->provider ?? 'Google' }}</p>
                <span class="mt-2 inline-block text-[11px] text-slate-500 dark:text-slate-400">SSO Active</span>
            </div>

            <!-- Information Card 5: Last Login -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between text-slate-400 mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Last Login</span>
                    <svg class="size-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ $user->last_login_at?->format('M j, Y g:i A') ?? 'Just Now' }}</p>
                <span class="mt-2 inline-block text-[11px] text-slate-500 dark:text-slate-400">Active Session</span>
            </div>

            <!-- Information Card 6: Account Status -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between text-slate-400 mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Account Status</span>
                    <svg class="size-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400 capitalize">{{ $user->status ?? 'Active' }}</p>
                <span class="mt-2 inline-block text-[11px] text-slate-500 dark:text-slate-400">No Restrictions</span>
            </div>

            <!-- Information Card 7: Google ID -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:col-span-2">
                <div class="flex items-center justify-between text-slate-400 mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Provider ID / Google ID</span>
                    <svg class="size-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </div>
                <p class="text-xs font-mono font-semibold text-slate-700 dark:text-slate-300 truncate">{{ $user->google_id ?? $user->provider_id ?? 'Recorded in database' }}</p>
                <span class="mt-2 inline-block text-[11px] text-slate-500 dark:text-slate-400">Encrypted Unique Key</span>
            </div>
        </div>
    </div>
</div>
