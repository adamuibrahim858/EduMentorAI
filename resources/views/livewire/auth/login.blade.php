<div class="relative flex min-h-screen flex-col lg:flex-row overflow-hidden bg-[#F8FAFC] dark:bg-slate-950">
    
    <!-- LEFT SIDE: AI Branding & Hero Visuals -->
    <div class="relative flex flex-col justify-between p-8 lg:w-1/2 lg:p-16 border-b lg:border-b-0 lg:border-r border-slate-200/80 dark:border-slate-800/80 bg-gradient-to-br from-indigo-900 via-slate-900 to-purple-950 text-white overflow-hidden">
        <!-- Ambient Background Glows -->
        <div class="pointer-events-none absolute -top-40 -left-40 size-96 rounded-full bg-indigo-500/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-40 -right-40 size-96 rounded-full bg-purple-500/20 blur-3xl"></div>
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(#818cf8_1px,transparent_1px)] [background-size:24px_24px] opacity-10"></div>

        <!-- Top Header Logo -->
        <div class="relative z-10">
            <x-auth.logo />
        </div>

        <!-- Middle Hero Tagline & Interactive Feature Card -->
        <div class="relative z-10 my-12 space-y-8 max-w-lg">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 rounded-full border border-indigo-400/30 bg-indigo-500/10 px-3 py-1 text-xs font-bold text-indigo-300 backdrop-blur-md">
                    <span class="size-2 rounded-full bg-indigo-400 animate-pulse"></span>
                    <span>Next-Gen AI Learning Companion</span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white leading-tight">
                    Master any subject <span class="bg-gradient-to-r from-indigo-200 via-purple-200 to-pink-200 bg-clip-text text-transparent">with AI precision.</span>
                </h1>
                <p class="text-sm leading-relaxed text-slate-300">
                    Transform lecture slides, textbooks, and notes into instant flashcards, practice quizzes, and interactive AI study routines.
                </p>
            </div>

            <!-- Animated Feature Card Badge -->
            <div class="relative overflow-hidden rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl shadow-2xl space-y-4">
                <div class="flex items-center gap-3">
                    <div class="flex size-10 items-center justify-center rounded-2xl bg-indigo-500/20 text-indigo-300 ring-1 ring-indigo-400/30">
                        ⚡
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white">Automated AI Study Plan</h4>
                        <p class="text-[11px] text-slate-400">7-Day Study Streak Active</p>
                    </div>
                </div>
                <div class="h-2 w-full rounded-full bg-white/10 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-purple-400" style="width: 85%;"></div>
                </div>
            </div>
        </div>

        <!-- Footer Tagline -->
        <div class="relative z-10 text-xs text-slate-400">
            © {{ date('Y') }} EduMentor AI. Powered by Advanced Intelligence.
        </div>
    </div>

    <!-- RIGHT SIDE: Login Card Form -->
    <div class="flex flex-1 items-center justify-center p-6 sm:p-12 lg:w-1/2">
        <div class="w-full max-w-md space-y-8">
            
            <x-auth.card>
                <div class="text-center space-y-2 mb-8">
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Welcome Back</h2>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Sign in to your account to continue your learning journey.</p>
                </div>

                <!-- Email & Password Form -->
                <form wire:submit="login" class="space-y-5">
                    <!-- Email Address Field -->
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Email Address
                        </label>
                        <input 
                            wire:model="email" 
                            type="email" 
                            id="email" 
                            name="email"
                            required 
                            autofocus 
                            autocomplete="username" 
                            placeholder="student@university.edu"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 dark:border-slate-800 dark:bg-slate-800/50 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-indigo-400 dark:focus:bg-slate-900"
                        />
                        @error('email')
                            <p class="mt-1.5 text-xs font-semibold text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                                Password
                            </label>
                            <a 
                                href="{{ route('password.request') }}" 
                                wire:navigate 
                                class="text-xs font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition"
                            >
                                Forgot password?
                            </a>
                        </div>
                        <input 
                            wire:model="password" 
                            type="password" 
                            id="password" 
                            name="password"
                            required 
                            autocomplete="current-password" 
                            placeholder="••••••••"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3.5 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 dark:border-slate-800 dark:bg-slate-800/50 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-indigo-400 dark:focus:bg-slate-900"
                        />
                        @error('password')
                            <p class="mt-1.5 text-xs font-semibold text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input 
                                wire:model="remember" 
                                type="checkbox" 
                                class="size-4 rounded-md border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800"
                            />
                            <span class="text-xs font-medium text-slate-600 dark:text-slate-400">Remember me on this device</span>
                        </label>
                    </div>

                    <!-- Primary Submit Login Button -->
                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="relative flex w-full items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-6 py-4 text-base font-semibold text-white shadow-lg shadow-indigo-500/25 transition-all duration-200 hover:-translate-y-0.5 hover:bg-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-500/25 active:translate-y-0 disabled:opacity-60 disabled:cursor-not-allowed"
                    >
                        <span wire:loading.remove wire:target="login">Sign In with Email</span>
                        <span wire:loading wire:target="login" class="inline-flex items-center gap-2">
                            <svg class="size-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Authenticating...
                        </span>
                    </button>
                </form>

                <!-- Divider "OR" -->
                <div class="relative my-6 flex items-center justify-center">
                    <div class="w-full border-t border-slate-200 dark:border-slate-800"></div>
                    <span class="absolute bg-white px-4 text-xs font-bold text-slate-400 uppercase tracking-wider dark:bg-slate-900">OR</span>
                </div>

                <!-- Google Login Button -->
                <x-auth.google-button wire:click="continueWithGoogle" loading-target="continueWithGoogle" />


                <!-- Bottom Redirect to Signup -->
                <div class="mt-8 text-center text-xs text-slate-500 dark:text-slate-400">
                    Don't have an account? 
                    <a 
                        href="{{ route('signup') }}" 
                        wire:navigate 
                        class="font-bold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition"
                    >
                        Create Account
                    </a>
                </div>
            </x-auth.card>

        </div>
    </div>
</div>
