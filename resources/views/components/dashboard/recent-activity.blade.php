@props(['user'])

<div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-base font-bold text-slate-900 dark:text-white">Recent Activity</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400">Your latest AI study interactions</p>
        </div>
        <button 
            @click="currentTab = 'notifications'"
            class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300"
        >
            View All
        </button>
    </div>

    <!-- Timeline Wrapper -->
    <div class="relative pl-6 space-y-6 before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200 dark:before:bg-slate-800">
        
        <!-- Activity 1: Recent Login -->
        <div class="relative flex items-start gap-4 group">
            <span class="absolute -left-6 top-1 flex size-5 items-center justify-center rounded-full bg-blue-500 text-white ring-4 ring-white dark:ring-slate-900 text-[10px]">
                <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14" />
                </svg>
            </span>
            <div class="flex-1 rounded-2xl border border-slate-100 bg-slate-50/60 p-3.5 transition group-hover:bg-slate-100/80 dark:border-slate-800/80 dark:bg-slate-800/40 dark:group-hover:bg-slate-800/80">
                <div class="flex items-center justify-between">
                    <h4 class="text-xs font-bold text-slate-900 dark:text-white">Authenticated via {{ ucfirst($user->provider ?? 'google') }}</h4>
                    <span class="text-[10px] text-slate-400 font-medium">{{ $user->last_login_at?->diffForHumans() ?? 'Just now' }}</span>
                </div>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Successful login session recorded from active browser session.</p>
            </div>
        </div>

        <!-- Activity 2: Recent Practice -->
        <div class="relative flex items-start gap-4 group">
            <span class="absolute -left-6 top-1 flex size-5 items-center justify-center rounded-full bg-emerald-500 text-white ring-4 ring-white dark:ring-slate-900 text-[10px]">
                <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </span>
            <div class="flex-1 rounded-2xl border border-slate-100 bg-slate-50/60 p-3.5 transition group-hover:bg-slate-100/80 dark:border-slate-800/80 dark:bg-slate-800/40 dark:group-hover:bg-slate-800/80">
                <div class="flex items-center justify-between">
                    <h4 class="text-xs font-bold text-slate-900 dark:text-white">Completed Practice Quiz: Machine Learning Basics</h4>
                    <span class="text-[10px] text-slate-400 font-medium">2 hours ago</span>
                </div>
                <div class="mt-1 flex items-center gap-2">
                    <span class="rounded-md bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">Score: 95%</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400">19/20 questions correct</span>
                </div>
            </div>
        </div>

        <!-- Activity 3: Recent Summary -->
        <div class="relative flex items-start gap-4 group">
            <span class="absolute -left-6 top-1 flex size-5 items-center justify-center rounded-full bg-purple-500 text-white ring-4 ring-white dark:ring-slate-900 text-[10px]">
                <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </span>
            <div class="flex-1 rounded-2xl border border-slate-100 bg-slate-50/60 p-3.5 transition group-hover:bg-slate-100/80 dark:border-slate-800/80 dark:bg-slate-800/40 dark:group-hover:bg-slate-800/80">
                <div class="flex items-center justify-between">
                    <h4 class="text-xs font-bold text-slate-900 dark:text-white">Generated Smart Summary: Neural Networks & Backprop</h4>
                    <span class="text-[10px] text-slate-400 font-medium">5 hours ago</span>
                </div>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">AI generated 5 key takeaways and 12 flashcards from chapter notes.</p>
            </div>
        </div>

        <!-- Activity 4: Recent Upload -->
        <div class="relative flex items-start gap-4 group">
            <span class="absolute -left-6 top-1 flex size-5 items-center justify-center rounded-full bg-indigo-500 text-white ring-4 ring-white dark:ring-slate-900 text-[10px]">
                <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
            </span>
            <div class="flex-1 rounded-2xl border border-slate-100 bg-slate-50/60 p-3.5 transition group-hover:bg-slate-100/80 dark:border-slate-800/80 dark:bg-slate-800/40 dark:group-hover:bg-slate-800/80">
                <div class="flex items-center justify-between">
                    <h4 class="text-xs font-bold text-slate-900 dark:text-white">Uploaded Course Document: Deep Learning Syllabus.pdf</h4>
                    <span class="text-[10px] text-slate-400 font-medium">Yesterday</span>
                </div>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Parsed 42 pages. Ready for quiz and routine generation.</p>
            </div>
        </div>

    </div>
</div>
