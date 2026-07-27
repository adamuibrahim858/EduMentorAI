<div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h3 class="text-base font-bold text-slate-900 dark:text-white">Quick AI Actions</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400">Jump straight into your smart study tools</p>
        </div>
        <span class="rounded-full bg-indigo-50 px-2.5 py-1 text-[11px] font-bold text-indigo-600 dark:bg-indigo-950 dark:text-indigo-300">
            AI Powered
        </span>
    </div>

    <div class="grid grid-cols-2 gap-3.5 sm:grid-cols-4">
        <!-- Action 1: Upload Material -->
        <button 
            @click="currentTab = 'courses'"
            class="group flex flex-col items-center justify-center rounded-2xl border border-slate-200/80 bg-slate-50/80 p-4 text-center transition-all duration-200 hover:-translate-y-1 hover:border-indigo-300 hover:bg-indigo-50/50 hover:shadow-lg hover:shadow-indigo-500/10 dark:border-slate-800 dark:bg-slate-800/40 dark:hover:border-indigo-500/40 dark:hover:bg-slate-800"
        >
            <div class="flex size-11 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-md shadow-indigo-600/20 transition-transform duration-200 group-hover:scale-110">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
            </div>
            <span class="mt-3 text-xs font-bold text-slate-800 dark:text-slate-200">Upload Material</span>
            <span class="mt-0.5 text-[10px] text-slate-500 dark:text-slate-400">PDF, Notes, Slides</span>
        </button>

        <!-- Action 2: Generate Summary -->
        <button 
            @click="currentTab = 'courses'"
            class="group flex flex-col items-center justify-center rounded-2xl border border-slate-200/80 bg-slate-50/80 p-4 text-center transition-all duration-200 hover:-translate-y-1 hover:border-purple-300 hover:bg-purple-50/50 hover:shadow-lg hover:shadow-purple-500/10 dark:border-slate-800 dark:bg-slate-800/40 dark:hover:border-purple-500/40 dark:hover:bg-slate-800"
        >
            <div class="flex size-11 items-center justify-center rounded-xl bg-purple-600 text-white shadow-md shadow-purple-600/20 transition-transform duration-200 group-hover:scale-110">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <span class="mt-3 text-xs font-bold text-slate-800 dark:text-slate-200">Generate Summary</span>
            <span class="mt-0.5 text-[10px] text-slate-500 dark:text-slate-400">Smart AI Notes</span>
        </button>

        <!-- Action 3: Practice Questions -->
        <button 
            @click="currentTab = 'practice'"
            class="group flex flex-col items-center justify-center rounded-2xl border border-slate-200/80 bg-slate-50/80 p-4 text-center transition-all duration-200 hover:-translate-y-1 hover:border-blue-300 hover:bg-blue-50/50 hover:shadow-lg hover:shadow-blue-500/10 dark:border-slate-800 dark:bg-slate-800/40 dark:hover:border-blue-500/40 dark:hover:bg-slate-800"
        >
            <div class="flex size-11 items-center justify-center rounded-xl bg-blue-600 text-white shadow-md shadow-blue-600/20 transition-transform duration-200 group-hover:scale-110">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="mt-3 text-xs font-bold text-slate-800 dark:text-slate-200">Practice Questions</span>
            <span class="mt-0.5 text-[10px] text-slate-500 dark:text-slate-400">Adaptive Quizzes</span>
        </button>

        <!-- Action 4: Study Routine -->
        <button 
            @click="currentTab = 'routine'"
            class="group flex flex-col items-center justify-center rounded-2xl border border-slate-200/80 bg-slate-50/80 p-4 text-center transition-all duration-200 hover:-translate-y-1 hover:border-emerald-300 hover:bg-emerald-50/50 hover:shadow-lg hover:shadow-emerald-500/10 dark:border-slate-800 dark:bg-slate-800/40 dark:hover:border-emerald-500/40 dark:hover:bg-slate-800"
        >
            <div class="flex size-11 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-md shadow-emerald-600/20 transition-transform duration-200 group-hover:scale-110">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <span class="mt-3 text-xs font-bold text-slate-800 dark:text-slate-200">Study Routine</span>
            <span class="mt-0.5 text-[10px] text-slate-500 dark:text-slate-400">Schedule Planner</span>
        </button>
    </div>
</div>
