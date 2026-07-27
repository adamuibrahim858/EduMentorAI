<div class="relative flex min-h-screen items-center justify-center p-4 sm:p-6 lg:p-8 overflow-hidden bg-[#F8FAFC] dark:bg-slate-950">
    <!-- Ambient Background Glows -->
    <div class="pointer-events-none absolute -top-40 -right-40 size-96 rounded-full bg-purple-500/15 blur-3xl dark:bg-purple-600/20"></div>
    <div class="pointer-events-none absolute -bottom-40 -left-40 size-96 rounded-full bg-indigo-500/15 blur-3xl dark:bg-indigo-600/20"></div>
    <div class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 size-[600px] rounded-full bg-blue-500/10 blur-3xl dark:bg-blue-600/10"></div>

    <div class="relative w-full max-w-6xl grid gap-8 lg:grid-cols-2 lg:items-center">
        
        <!-- LEFT SIDE: Hero / Value Props Showcase -->
        <aside class="relative flex flex-col justify-between overflow-hidden rounded-[2.5rem] border border-slate-200/80 bg-gradient-to-br from-slate-900 via-purple-950 to-slate-900 p-8 sm:p-12 text-white shadow-2xl shadow-purple-950/20 dark:border-slate-800">
            <!-- Background Glows -->
            <div class="absolute -right-16 -top-16 size-80 rounded-full bg-purple-500/30 blur-3xl"></div>
            <div class="absolute -bottom-16 -left-16 size-80 rounded-full bg-indigo-500/30 blur-3xl"></div>
            <div class="absolute inset-0 bg-[radial-gradient(#a855f7_1px,transparent_1px)] [background-size:24px_24px] opacity-10"></div>

            <!-- Top Header Badge -->
            <div class="relative z-10 flex items-center justify-between">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3.5 py-1.5 backdrop-blur-md">
                    <span class="text-xs font-semibold tracking-wide text-white/90">🚀 Instant Access</span>
                </div>
                <div class="flex items-center gap-1.5 text-xs text-white/70">
                    <span class="font-bold text-emerald-400">Free Tier Included</span>
                </div>
            </div>

            <!-- Showcase Visuals -->
            <div class="relative z-10 my-10 py-4 space-y-4">
                <!-- Feature Box 1 -->
                <div class="animate-float-slow flex items-center gap-4 rounded-2xl border border-white/15 bg-white/10 p-4 shadow-xl backdrop-blur-xl">
                    <div class="flex size-11 items-center justify-center rounded-xl bg-indigo-500/30 text-indigo-300 text-xl font-bold">
                        🧠
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white">Adaptive Learning AI</h4>
                        <p class="text-xs text-white/70">Tailors practice questions to your weak spots.</p>
                    </div>
                </div>

                <!-- Feature Box 2 -->
                <div class="animate-float-delayed flex items-center gap-4 rounded-2xl border border-white/15 bg-white/10 p-4 shadow-xl backdrop-blur-xl">
                    <div class="flex size-11 items-center justify-center rounded-xl bg-purple-500/30 text-purple-300 text-xl font-bold">
                        ⚡
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white">Automated Routine Generator</h4>
                        <p class="text-xs text-white/70">Builds optimized study calendars in seconds.</p>
                    </div>
                </div>

                <!-- Feature Box 3 -->
                <div class="flex items-center gap-4 rounded-2xl border border-white/15 bg-white/10 p-4 shadow-xl backdrop-blur-xl">
                    <div class="flex size-11 items-center justify-center rounded-xl bg-blue-500/30 text-blue-300 text-xl font-bold">
                        📊
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white">Real-Time Performance Analytics</h4>
                        <p class="text-xs text-white/70">Track test scores and mastery growth.</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Tagline -->
            <div class="relative z-10 space-y-3">
                <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    Join 10,000+ AI <span class="bg-gradient-to-r from-purple-300 via-pink-300 to-indigo-300 bg-clip-text text-transparent">Achievers</span>
                </h2>
                <p class="text-sm leading-relaxed text-slate-300">
                    Create your account in 5 seconds with Google and unlock full access to EduMentor AI.
                </p>
            </div>
        </aside>

        <!-- RIGHT SIDE: Signup Card -->
        <div class="flex items-center justify-center">
            <x-auth.card class="w-full">
                <x-auth.logo class="mb-8" />

                <div class="space-y-2">
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Create your EduMentor AI Account</h1>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Start learning smarter today.</p>
                </div>

                <div class="mt-8 space-y-6">
                    <x-auth.google-button
                        wire:click="signUpWithGoogle"
                        loading-target="signUpWithGoogle"
                        default-text="Sign up with Google"
                    />

                    <!-- Security & Terms -->
                    <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-3.5 text-center text-xs text-slate-500 dark:border-slate-800 dark:bg-slate-800/40 dark:text-slate-400">
                        <span class="font-medium text-slate-700 dark:text-slate-300">✨ One-click Instant Access</span>
                        <p class="mt-1">By continuing you agree to Terms and Privacy Policy.</p>
                    </div>
                </div>

                <div class="mt-8 border-t border-slate-200/80 pt-6 text-center text-sm text-slate-600 dark:border-slate-800 dark:text-slate-400">
                    Already have account?
                    <a href="{{ route('login') }}" wire:navigate class="ml-1 font-semibold text-indigo-600 transition hover:text-indigo-500 hover:underline dark:text-indigo-400">
                        Sign In
                    </a>
                </div>
            </x-auth.card>
        </div>

    </div>
</div>

