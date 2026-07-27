<div class="space-y-8" x-data="{ allRead: false }">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Notifications & Activity Feed</h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Stay updated with AI summary completions, streak alerts, and system insights.</p>
        </div>
        <button 
            type="button" 
            @click="allRead = true"
            class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-800 dark:text-slate-200 transition"
        >
            Mark All as Read
        </button>
    </div>

    <!-- Notification Cards List -->
    <div class="space-y-3.5">
        
        <!-- Notification 1 (Unread) -->
        <div class="group relative flex items-start gap-4 rounded-3xl border border-indigo-100 bg-indigo-50/40 p-5 shadow-sm transition hover:border-indigo-200 dark:border-indigo-900/40 dark:bg-indigo-950/20">
            <div class="flex size-11 shrink-0 items-center justify-center rounded-2xl bg-indigo-600 text-white shadow-md shadow-indigo-600/20">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white">AI Summary Generated</h4>
                        <span x-show="!allRead" class="size-2 rounded-full bg-indigo-600"></span>
                    </div>
                    <span class="text-[11px] font-medium text-slate-400">10 mins ago</span>
                </div>
                <p class="mt-1 text-xs text-slate-600 dark:text-slate-300">Your uploaded document "Neural Networks & Backpropagation.pdf" has been processed. 14 smart flashcards and 5 key takeaways are ready.</p>
            </div>
        </div>

        <!-- Notification 2 (Unread) -->
        <div class="group relative flex items-start gap-4 rounded-3xl border border-amber-100 bg-amber-50/40 p-5 shadow-sm transition hover:border-amber-200 dark:border-amber-900/40 dark:bg-amber-950/20">
            <div class="flex size-11 shrink-0 items-center justify-center rounded-2xl bg-amber-500 text-white shadow-md shadow-amber-500/20">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white">7-Day Study Streak Milestone! 🔥</h4>
                        <span x-show="!allRead" class="size-2 rounded-full bg-amber-500"></span>
                    </div>
                    <span class="text-[11px] font-medium text-slate-400">2 hours ago</span>
                </div>
                <p class="mt-1 text-xs text-slate-600 dark:text-slate-300">Congratulations! You've maintained a 7-day study streak. Keep up the amazing momentum to unlock the AI Master badge.</p>
            </div>
        </div>

        <!-- Notification 3 (Read) -->
        <div class="group relative flex items-start gap-4 rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm transition dark:border-slate-800 dark:bg-slate-900">
            <div class="flex size-11 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-md shadow-emerald-600/20">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Quiz Completed: 95% High Score</h4>
                    <span class="text-[11px] font-medium text-slate-400">Yesterday</span>
                </div>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">You scored 95% on Machine Learning Basics Quiz. 19/20 questions answered correctly.</p>
            </div>
        </div>

        <!-- Notification 4 (Read) -->
        <div class="group relative flex items-start gap-4 rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm transition dark:border-slate-800 dark:bg-slate-900">
            <div class="flex size-11 shrink-0 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-md shadow-blue-600/20">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Routine Updated for Tomorrow</h4>
                    <span class="text-[11px] font-medium text-slate-400">2 days ago</span>
                </div>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">EduMentor AI adjusted your study calendar based on your latest quiz performance.</p>
            </div>
        </div>

    </div>
</div>
