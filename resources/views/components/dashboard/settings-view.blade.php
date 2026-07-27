@props(['user'])

<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Account & AI Settings</h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Configure your personal profile preferences, AI tutor persona, and notifications.</p>
        </div>
        <button 
            type="button" 
            @click="alert('Settings saved successfully! (UI Preview)')"
            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:bg-indigo-500 active:translate-y-0 shrink-0"
        >
            Save Changes
        </button>
    </div>

    <!-- Settings Sections Stack -->
    <div class="space-y-6">
        
        <!-- Section 1: AI Persona & Study Style -->
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h3 class="text-base font-bold text-slate-900 dark:text-white mb-1">AI Tutor Persona & Adaptive Difficulty</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Customize how EduMentor AI explains concepts and generates practice quizzes.</p>

            <div class="grid gap-4 sm:grid-cols-3">
                <label class="flex flex-col rounded-2xl border-2 border-indigo-600 bg-indigo-50/50 p-4 dark:border-indigo-500 dark:bg-indigo-950/20 cursor-pointer">
                    <span class="text-xs font-bold text-slate-900 dark:text-white">Socratic & Analytical</span>
                    <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Asks guiding questions to stimulate deep critical thinking.</span>
                </label>

                <label class="flex flex-col rounded-2xl border border-slate-200 p-4 dark:border-slate-800 dark:bg-slate-800/40 cursor-pointer hover:border-indigo-300 transition">
                    <span class="text-xs font-bold text-slate-900 dark:text-white">Concise & Direct</span>
                    <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Short bullet-point summaries and quick flashcards.</span>
                </label>

                <label class="flex flex-col rounded-2xl border border-slate-200 p-4 dark:border-slate-800 dark:bg-slate-800/40 cursor-pointer hover:border-indigo-300 transition">
                    <span class="text-xs font-bold text-slate-900 dark:text-white">Visual & Analogical</span>
                    <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Uses real-world metaphors, diagrams, and visual breakdowns.</span>
                </label>
            </div>
        </div>

        <!-- Section 2: Account Security & Google Sync -->
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h3 class="text-base font-bold text-slate-900 dark:text-white mb-1">Account & Connected Services</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Managed by Google OAuth security authentication.</p>

            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/40">
                    <div class="flex items-center gap-3">
                        <svg class="size-6 text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09Z"/>
                        </svg>
                        <div>
                            <p class="text-xs font-bold text-slate-900 dark:text-white">Google SSO Connection</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Linked to {{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">Connected</span>
                </div>
            </div>
        </div>

        <!-- Section 3: Notification Preferences -->
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <h3 class="text-base font-bold text-slate-900 dark:text-white mb-1">Notification Preferences</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Choose how and when EduMentor AI alerts you.</p>

            <div class="space-y-4" x-data="{ emailAlerts: true, streakAlerts: true }">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-900 dark:text-white">Daily Routine Reminders</p>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Receive morning notification of planned study sessions.</p>
                    </div>
                    <button 
                        @click="emailAlerts = !emailAlerts" 
                        type="button" 
                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                        :class="emailAlerts ? 'bg-indigo-600' : 'bg-slate-200 dark:bg-slate-700'"
                    >
                        <span class="pointer-events-none inline-block size-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out" :class="emailAlerts ? 'translate-x-5' : 'translate-x-0'"></span>
                    </button>
                </div>

                <div class="flex items-center justify-between border-t border-slate-100 pt-4 dark:border-slate-800/80">
                    <div>
                        <p class="text-xs font-bold text-slate-900 dark:text-white">Streak Warning Alerts</p>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Alert me before my daily streak resets at midnight.</p>
                    </div>
                    <button 
                        @click="streakAlerts = !streakAlerts" 
                        type="button" 
                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                        :class="streakAlerts ? 'bg-indigo-600' : 'bg-slate-200 dark:bg-slate-700'"
                    >
                        <span class="pointer-events-none inline-block size-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out" :class="streakAlerts ? 'translate-x-5' : 'translate-x-0'"></span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
