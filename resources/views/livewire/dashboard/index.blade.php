<div 
    x-data="{ 
        currentTab: 'dashboard', 
        sidebarCollapsed: false, 
        mobileSidebarOpen: false,
        darkMode: (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches))
    }" 
    class="min-h-screen bg-[#F8FAFC] text-slate-900 transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100"
>
    <!-- Collapsible Responsive Sidebar Component -->
    <x-dashboard.sidebar :active-tab="'dashboard'" />

    <!-- Main Content Area Wrapper -->
    <div 
        :class="{
            'lg:pl-64': !sidebarCollapsed,
            'lg:pl-20': sidebarCollapsed
        }"
        class="flex flex-col min-h-screen transition-all duration-300"
    >
        <!-- Sticky Topbar Navigation Component -->
        <x-dashboard.topbar :user="$user" />

        <!-- Main Scrollable Dashboard Canvas -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-8">
            
            <!-- TAB 1: DASHBOARD HOME -->
            <div x-show="currentTab === 'dashboard'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8">
                
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
                                ✨ <span class="font-bold text-white">AI Daily Tip:</span> You're 85% on track to beat your weekly goal! You have 2 practice quizzes waiting to strengthen weak topics.
                            </p>
                        </div>

                        <!-- Action Badge / Primary Call -->
                        <button 
                            @click="currentTab = 'practice'" 
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-5 py-3 text-xs font-bold text-slate-900 shadow-lg transition hover:bg-indigo-50 hover:-translate-y-0.5 active:translate-y-0 shrink-0"
                        >
                            <svg class="size-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Start Practice Quiz
                        </button>
                    </div>
                </div>

                <!-- 4 Summary Stats Cards Grid -->
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <x-dashboard.stats-card
                        title="Enrolled Courses"
                        value="8"
                        change="+2 new"
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

            <!-- TAB 2: PROFILE VIEW -->
            <div x-show="currentTab === 'profile'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <x-dashboard.profile-view :user="$user" />
            </div>

            <!-- TAB 3: COURSES VIEW -->
            <div x-show="currentTab === 'courses'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <x-dashboard.courses-view />
            </div>

            <!-- TAB 4: PRACTICE VIEW -->
            <div x-show="currentTab === 'practice'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <x-dashboard.practice-view />
            </div>

            <!-- TAB 5: LEARNING ROUTINE VIEW -->
            <div x-show="currentTab === 'routine'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <x-dashboard.routine-view />
            </div>

            <!-- TAB 6: NOTIFICATIONS VIEW -->
            <div x-show="currentTab === 'notifications'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <x-dashboard.notifications-view />
            </div>

            <!-- TAB 7: SETTINGS VIEW -->
            <div x-show="currentTab === 'settings'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <x-dashboard.settings-view :user="$user" />
            </div>

        </main>
    </div>
</div>

