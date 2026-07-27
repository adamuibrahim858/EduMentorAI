<div class="relative flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8 overflow-hidden bg-[#F8FAFC] dark:bg-slate-950">
    <!-- Ambient Background Glows -->
    <div class="pointer-events-none absolute -top-40 -left-40 size-96 rounded-full bg-indigo-500/15 blur-3xl dark:bg-indigo-600/20"></div>
    <div class="pointer-events-none absolute -bottom-40 -right-40 size-96 rounded-full bg-purple-500/15 blur-3xl dark:bg-purple-600/20"></div>
    <div class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 size-[600px] rounded-full bg-blue-500/10 blur-3xl dark:bg-blue-600/10"></div>

    <div class="relative w-full max-w-6xl grid gap-8 lg:grid-cols-2 lg:items-center">
        
        <!-- LEFT SIDE: AI Illustration & Hero Showcase -->
        <aside class="relative flex flex-col justify-between overflow-hidden rounded-[2.5rem] border border-slate-200/80 bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-8 sm:p-12 text-white shadow-2xl shadow-indigo-950/20 dark:border-slate-800">
            <!-- Floating Decorative Background Glow -->
            <div class="absolute -right-16 -top-16 size-80 rounded-full bg-indigo-500/30 blur-3xl"></div>
            <div class="absolute -bottom-16 -left-16 size-80 rounded-full bg-purple-500/30 blur-3xl"></div>
            <div class="absolute inset-0 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:24px_24px] opacity-10"></div>

            <!-- Top Header Badge -->
            <div class="relative z-10 flex items-center justify-between">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3.5 py-1.5 backdrop-blur-md">
                    <span class="relative flex size-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-emerald-500"></span>
                    </span>
                    <span class="text-xs font-semibold tracking-wide text-white/90">EduMentor Engine 3.0</span>
                </div>
                <div class="flex items-center gap-1.5 text-xs text-white/70">
                    <svg class="size-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="font-bold text-white">4.9/5</span> from 10k+ students
                </div>
            </div>

            <!-- Interactive AI Floating Shapes Illustration -->
            <div class="relative z-10 my-10 py-4">
                <!-- Floating Card 1: AI Prompt Generator Mock -->
                <div class="animate-float-slow rounded-2xl border border-white/15 bg-white/10 p-5 shadow-2xl backdrop-blur-xl transition hover:border-white/30">
                    <div class="flex items-center gap-3">
                        <div class="flex size-9 items-center justify-center rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-500 text-white font-bold text-sm shadow-md">
                            ⚡
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-white/90">Instant AI Summary</p>
                            <p class="text-[11px] text-white/60">Quantum Physics — Chapter 4</p>
                        </div>
                        <span class="ml-auto rounded-md bg-emerald-500/20 px-2 py-0.5 text-[10px] font-semibold text-emerald-300">Ready</span>
                    </div>
                    <div class="mt-4 space-y-2">
                        <div class="h-2 w-full rounded-full bg-white/20"></div>
                        <div class="h-2 w-4/5 rounded-full bg-white/15"></div>
                    </div>
                </div>

                <!-- Floating Card 2: Streak & Score Card -->
                <div class="animate-float-delayed mt-4 ml-auto w-11/12 rounded-2xl border border-white/15 bg-gradient-to-r from-indigo-600/40 via-purple-600/40 to-blue-600/40 p-5 shadow-2xl backdrop-blur-xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex size-10 items-center justify-center rounded-full bg-amber-500/20 text-amber-300 text-lg font-bold">
                                🔥
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-white">7 Day Study Streak!</p>
                                <p class="text-[11px] text-white/70">Top 5% active learner</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xl font-extrabold text-white">96%</span>
                            <p class="text-[10px] uppercase tracking-wider text-indigo-200">Accuracy</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Tagline & Description -->
            <div class="relative z-10 space-y-3">
                <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    Study Smarter with <span class="bg-gradient-to-r from-indigo-300 via-purple-300 to-pink-300 bg-clip-text text-transparent">AI</span>
                </h2>
                <p class="text-sm leading-relaxed text-slate-300">
                    Elevate your learning journey with personalized AI study sessions, instant smart summaries, practice quizzes, and automated routines.
                </p>
            </div>
        </aside>

        <!-- RIGHT SIDE: Auth Card -->
        <div class="flex items-center justify-center">
            <x-auth.card class="w-full">
                <x-auth.logo class="mb-8" />

                <div class="space-y-2">
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Welcome Back</h1>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Continue your personalized AI learning journey.</p>
                </div>

                <div class="mt-8 space-y-6">
                    <x-auth.flash-message :message="session('status')" />

                    <x-auth.google-button
                        wire:click="continueWithGoogle"
                        loading-target="continueWithGoogle"
                        default-text="Continue with Google"
                    />

                    <!-- Security & Privacy note -->
                    <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-3.5 text-center text-xs text-slate-500 dark:border-slate-800 dark:bg-slate-800/40 dark:text-slate-400">
                        <span class="font-medium text-slate-700 dark:text-slate-300">🔒 Secure OAuth 2.0 Auth</span>
                        <p class="mt-1">By continuing, you agree to EduMentor AI's <a href="#" class="underline hover:text-indigo-600">Terms of Service</a> and <a href="#" class="underline hover:text-indigo-600">Privacy Policy</a>.</p>
                    </div>
                </div>

                <div class="mt-8 border-t border-slate-200/80 pt-6 text-center text-sm text-slate-600 dark:border-slate-800 dark:text-slate-400">
                    New to EduMentor AI?
                    <a href="{{ route('signup') }}" wire:navigate class="ml-1 font-semibold text-indigo-600 transition hover:text-indigo-500 hover:underline dark:text-indigo-400">
                        Create an account
                    </a>
                </div>
            </x-auth.card>
        </div>

    </div>
</div>

