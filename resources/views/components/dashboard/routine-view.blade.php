<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">AI Learning Routine</h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Smart calendar and automated study schedule optimized for peak focus.</p>
        </div>
        <div class="flex items-center gap-2">
            <button 
                type="button" 
                class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-800 dark:text-slate-200 transition"
            >
                📅 Sync to Google Calendar
            </button>
        </div>
    </div>

    <!-- Main Routine Grid Layout -->
    <div class="grid gap-8 lg:grid-cols-3">
        
        <!-- Left 2 Cols: Today's Schedule & Interactive Calendar -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Calendar Ribbon Header -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Weekly Calendar View</h3>
                    <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400">July 2026</span>
                </div>

                <!-- 7 Day Ribbon -->
                <div class="grid grid-cols-7 gap-2 text-center">
                    <div class="rounded-2xl p-2.5 bg-slate-50 dark:bg-slate-800/40">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase">Mon</span>
                        <span class="block text-sm font-extrabold text-slate-700 dark:text-slate-300 mt-1">21</span>
                    </div>
                    <div class="rounded-2xl p-2.5 bg-slate-50 dark:bg-slate-800/40">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase">Tue</span>
                        <span class="block text-sm font-extrabold text-slate-700 dark:text-slate-300 mt-1">22</span>
                    </div>
                    <div class="rounded-2xl p-2.5 bg-slate-50 dark:bg-slate-800/40">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase">Wed</span>
                        <span class="block text-sm font-extrabold text-slate-700 dark:text-slate-300 mt-1">23</span>
                    </div>
                    <div class="rounded-2xl p-2.5 bg-slate-50 dark:bg-slate-800/40">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase">Thu</span>
                        <span class="block text-sm font-extrabold text-slate-700 dark:text-slate-300 mt-1">24</span>
                    </div>
                    <div class="rounded-2xl p-2.5 bg-slate-50 dark:bg-slate-800/40">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase">Fri</span>
                        <span class="block text-sm font-extrabold text-slate-700 dark:text-slate-300 mt-1">25</span>
                    </div>
                    <div class="rounded-2xl p-2.5 bg-slate-50 dark:bg-slate-800/40">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase">Sat</span>
                        <span class="block text-sm font-extrabold text-slate-700 dark:text-slate-300 mt-1">26</span>
                    </div>
                    <!-- Today -->
                    <div class="rounded-2xl p-2.5 bg-indigo-600 text-white shadow-md shadow-indigo-600/25">
                        <span class="block text-[10px] font-bold text-indigo-200 uppercase">Sun</span>
                        <span class="block text-sm font-extrabold text-white mt-1">27</span>
                    </div>
                </div>
            </div>

            <!-- Today's Schedule Timeline -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Today's Schedule</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">3 AI Sessions Planned for Today</p>
                    </div>
                    <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-extrabold text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
                        2/3 Completed
                    </span>
                </div>

                <div class="space-y-4">
                    <!-- Session 1 -->
                    <div class="flex items-center gap-4 rounded-2xl border border-slate-100 bg-slate-50/80 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <div class="text-center w-16 shrink-0">
                            <span class="block text-xs font-extrabold text-indigo-600 dark:text-indigo-400">09:00 AM</span>
                            <span class="block text-[10px] text-slate-400">45 Mins</span>
                        </div>
                        <div class="h-10 w-1 rounded-full bg-emerald-500"></div>
                        <div class="flex-1">
                            <h4 class="text-xs font-bold text-slate-900 dark:text-white">Deep Learning: Optimization Algorithms</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">AI Quiz + Smart Summary Review</p>
                        </div>
                        <span class="rounded-lg bg-emerald-500/10 px-2.5 py-1 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">Done ✓</span>
                    </div>

                    <!-- Session 2 -->
                    <div class="flex items-center gap-4 rounded-2xl border border-slate-100 bg-slate-50/80 p-4 dark:border-slate-800 dark:bg-slate-800/40">
                        <div class="text-center w-16 shrink-0">
                            <span class="block text-xs font-extrabold text-indigo-600 dark:text-indigo-400">02:30 PM</span>
                            <span class="block text-[10px] text-slate-400">30 Mins</span>
                        </div>
                        <div class="h-10 w-1 rounded-full bg-emerald-500"></div>
                        <div class="flex-1">
                            <h4 class="text-xs font-bold text-slate-900 dark:text-white">Linear Algebra: Vector Subspaces</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Flashcard Review Session</p>
                        </div>
                        <span class="rounded-lg bg-emerald-500/10 px-2.5 py-1 text-[10px] font-bold text-emerald-600 dark:text-emerald-400">Done ✓</span>
                    </div>

                    <!-- Session 3 (Upcoming) -->
                    <div class="flex items-center gap-4 rounded-2xl border border-indigo-200 bg-indigo-50/50 p-4 dark:border-indigo-500/30 dark:bg-indigo-950/20">
                        <div class="text-center w-16 shrink-0">
                            <span class="block text-xs font-extrabold text-indigo-600 dark:text-indigo-400">06:00 PM</span>
                            <span class="block text-[10px] text-slate-400">60 Mins</span>
                        </div>
                        <div class="h-10 w-1 rounded-full bg-indigo-500"></div>
                        <div class="flex-1">
                            <h4 class="text-xs font-bold text-slate-900 dark:text-white">Quantum Physics: Wave Collapse</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Problem Solving & Practice</p>
                        </div>
                        <button class="rounded-xl bg-indigo-600 px-3 py-1.5 text-xs font-bold text-white shadow hover:bg-indigo-500 transition">
                            Start Now →
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Col: Upcoming Tasks & Weekly Progress Widget -->
        <div class="space-y-6">
            
            <!-- Weekly Progress Widget -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="text-base font-bold text-slate-900 dark:text-white mb-4">Weekly Goal Progress</h3>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-600 dark:text-slate-300">Study Hours Target (14/15 hrs)</span>
                            <span class="text-indigo-600 dark:text-indigo-400">93%</span>
                        </div>
                        <div class="h-2.5 w-full rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                            <div class="h-full rounded-full bg-indigo-600" style="width: 93%;"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-600 dark:text-slate-300">Practice Quizzes (8/10)</span>
                            <span class="text-purple-600 dark:text-purple-400">80%</span>
                        </div>
                        <div class="h-2.5 w-full rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                            <div class="h-full rounded-full bg-purple-600" style="width: 80%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Tasks Card -->
            <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="text-base font-bold text-slate-900 dark:text-white mb-4">Upcoming Tasks</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/40">
                        <div class="size-2 rounded-full bg-amber-500"></div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-slate-900 dark:text-white">Submit AI Midterm Quiz</p>
                            <p class="text-[10px] text-slate-400">Tomorrow • 11:59 PM</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/40">
                        <div class="size-2 rounded-full bg-indigo-500"></div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-slate-900 dark:text-white">Review Vector Calculus Summary</p>
                            <p class="text-[10px] text-slate-400">Jul 29 • 10:00 AM</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
