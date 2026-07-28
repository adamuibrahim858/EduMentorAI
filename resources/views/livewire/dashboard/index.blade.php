<x-layouts.dashboard title="Dashboard">
    <div class="space-y-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
            <span class="text-slate-900 dark:text-white font-bold">Dashboard</span>
        </nav>

        <!-- Hero Greeting Header Banner -->
        <div class="relative overflow-hidden rounded-3xl border border-slate-200/80 bg-gradient-to-r from-indigo-900 via-indigo-950 to-slate-900 p-6 sm:p-10 text-white shadow-xl dark:border-slate-800">
            <div class="absolute -right-20 -top-20 size-80 rounded-full bg-indigo-500/25 blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 size-80 rounded-full bg-purple-500/25 blur-3xl"></div>
            <div class="absolute inset-0 bg-[radial-gradient(#818cf8_1px,transparent_1px)] [background-size:20px_20px] opacity-10"></div>

            <div class="relative z-10 flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-semibold backdrop-blur-md">
                        <span class="size-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>AI Study Companion Active</span>
                    </div>
                    <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-white">
                        Good Morning, <span class="bg-gradient-to-r from-indigo-200 via-purple-200 to-pink-200 bg-clip-text text-transparent">{{ $user->name }}</span> 👋
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-xl leading-relaxed">
                        ✨ <span class="font-bold text-white">AI Daily Tip:</span> You're 85% on track to beat your weekly goal! You have practice quizzes waiting to strengthen weak topics.
                    </p>
                </div>

                <!-- Action Badge / Primary Call -->
                <a 
                    href="{{ route('practices.index') }}" 
                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-5 py-3 text-xs font-bold text-slate-900 shadow-lg transition hover:bg-indigo-50 hover:-translate-y-0.5 active:translate-y-0 shrink-0"
                >
                    <svg class="size-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Start Practice Quiz
                </a>
            </div>
        </div>

        <!-- 4 Summary Stats Cards Grid -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-dashboard.stats-card
                title="Enrolled Courses"
                value="{{ $user->courses()->count() }}"
                change="Active courses"
                changeType="positive"
                gradient="from-indigo-600 to-blue-600"
                icon="courses"
            />
            <x-dashboard.stats-card
                title="Practices Completed"
                value="42"
                change="+12 this week"
                changeType="positive"
                gradient="from-purple-600 to-indigo-600"
                icon="practice"
            />
            <x-dashboard.stats-card
                title="Study Streak"
                value="7 Days 🔥"
                change="Top 5% learner"
                changeType="positive"
                gradient="from-amber-500 to-orange-600"
                icon="streak"
            />
            <x-dashboard.stats-card
                title="Average Score"
                value="94.8%"
                change="+4.2% overall"
                changeType="positive"
                gradient="from-emerald-500 to-teal-600"
                icon="score"
            />
        </div>

        <!-- Quick Actions Grid -->
        <x-dashboard.quick-actions />

        <!-- Recent Activity Timeline -->
        <x-dashboard.recent-activity :user="$user" />
    </div>
</x-layouts.dashboard>
