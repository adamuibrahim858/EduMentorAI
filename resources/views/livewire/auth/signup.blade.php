<div class="relative flex min-h-screen flex-col lg:flex-row overflow-hidden bg-[#F8FAFC] dark:bg-slate-950">
    
    <!-- LEFT SIDE: AI Value Propositions & Hero Branding -->
    <div class="relative flex flex-col justify-between p-8 lg:w-1/2 lg:p-16 border-b lg:border-b-0 lg:border-r border-slate-200/80 dark:border-slate-800/80 bg-gradient-to-br from-indigo-950 via-slate-900 to-purple-900 text-white overflow-hidden">
        <div class="pointer-events-none absolute -top-40 -left-40 size-96 rounded-full bg-indigo-500/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-40 -right-40 size-96 rounded-full bg-purple-500/20 blur-3xl"></div>
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(#818cf8_1px,transparent_1px)] [background-size:24px_24px] opacity-10"></div>

        <!-- Brand Header -->
        <div class="relative z-10">
            <x-auth.logo />
        </div>

        <!-- Core Feature Cards Stack -->
        <div class="relative z-10 my-12 space-y-6 max-w-lg">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 rounded-full border border-purple-400/30 bg-purple-500/10 px-3 py-1 text-xs font-bold text-purple-300 backdrop-blur-md">
                    <span>✨ Start Learning 10x Faster</span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white leading-tight">
                    Join thousands of <span class="bg-gradient-to-r from-purple-200 via-pink-200 to-indigo-200 bg-clip-text text-transparent">top AI students.</span>
                </h1>
                <p class="text-sm leading-relaxed text-slate-300">
                    Create your EduMentor AI account today and get instant access to automated note summaries, AI flashcard generation, and adaptive exam practice.
                </p>
            </div>

            <!-- Value Prop Cards -->
            <div class="space-y-3">
                <div class="flex items-center gap-3.5 rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur-xl">
                    <div class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-indigo-500/20 text-indigo-300">
                        📚
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white">Smart Document Parser</h4>
                        <p class="text-[11px] text-slate-400">Convert PDFs, Slides, and Docs into interactive quizzes.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3.5 rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur-xl">
                    <div class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-purple-500/20 text-purple-300">
                        🎯
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white">Adaptive Learning Analytics</h4>
                        <p class="text-[11px] text-slate-400">Track knowledge gaps with precision AI scoring.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Notice -->
        <div class="relative z-10 text-xs text-slate-400">
            © {{ date('Y') }} EduMentor AI. Modern AI-Powered Platform.
        </div>
    </div>

    <!-- RIGHT SIDE: Register Card Form -->
    <div class="flex flex-1 items-center justify-center p-6 sm:p-12 lg:w-1/2">
        <div class="w-full max-w-md space-y-8">
            
            <x-auth.card>
                <div class="text-center space-y-2 mb-8">
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Create Account</h2>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Sign up in seconds to unlock your AI study assistant.</p>
                </div>

                <!-- Registration Form -->
                <form wire:submit="signup" class="space-y-4">
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Full Name
                        </label>
                        <input 
                            wire:model="name" 
                            type="text" 
                            id="name" 
                            name="name"
                            required 
                            autofocus 
                            autocomplete="name" 
                            placeholder="Alex Morgan"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 dark:border-slate-800 dark:bg-slate-800/50 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-indigo-400 dark:focus:bg-slate-900"
                        />
                        @error('name')
                            <p class="mt-1 text-xs font-semibold text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
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
                            autocomplete="username" 
                            placeholder="alex@university.edu"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 dark:border-slate-800 dark:bg-slate-800/50 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-indigo-400 dark:focus:bg-slate-900"
                        />
                        @error('email')
                            <p class="mt-1 text-xs font-semibold text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Password
                        </label>
                        <input 
                            wire:model="password" 
                            type="password" 
                            id="password" 
                            name="password"
                            required 
                            autocomplete="new-password" 
                            placeholder="At least 8 characters"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 dark:border-slate-800 dark:bg-slate-800/50 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-indigo-400 dark:focus:bg-slate-900"
                        />
                        @error('password')
                            <p class="mt-1 text-xs font-semibold text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Confirm Password
                        </label>
                        <input 
                            wire:model="password_confirmation" 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation"
                            required 
                            autocomplete="new-password" 
                            placeholder="Re-enter password"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 dark:border-slate-800 dark:bg-slate-800/50 dark:text-white dark:placeholder:text-slate-500 dark:focus:border-indigo-400 dark:focus:bg-slate-900"
                        />
                    </div>

                    <!-- Terms & Privacy Policy Checkbox -->
                    <div class="pt-1">
                        <label class="flex items-start gap-2.5 cursor-pointer">
                            <input 
                                wire:model="terms" 
                                type="checkbox" 
                                class="mt-0.5 size-4 rounded-md border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800"
                            />
                            <span class="text-xs text-slate-600 dark:text-slate-400 leading-normal">
                                I agree to the <a href="#" class="font-bold text-indigo-600 dark:text-indigo-400 underline">Terms of Service</a> and <a href="#" class="font-bold text-indigo-600 dark:text-indigo-400 underline">Privacy Policy</a>.
                            </span>
                        </label>
                        @error('terms')
                            <p class="mt-1 text-xs font-semibold text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Register Button -->
                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="relative flex w-full items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-6 py-4 text-base font-semibold text-white shadow-lg shadow-indigo-500/25 transition-all duration-200 hover:-translate-y-0.5 hover:bg-indigo-500 focus:outline-none focus:ring-4 focus:ring-indigo-500/25 active:translate-y-0 disabled:opacity-60 disabled:cursor-not-allowed mt-2"
                    >
                        <span wire:loading.remove wire:target="signup">Create Free Account</span>
                        <span wire:loading wire:target="signup" class="inline-flex items-center gap-2">
                            <svg class="size-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Creating Account...
                        </span>
                    </button>
                </form>

                <!-- Divider "OR" -->
                <div class="relative my-6 flex items-center justify-center">
                    <div class="w-full border-t border-slate-200 dark:border-slate-800"></div>
                    <span class="absolute bg-white px-4 text-xs font-bold text-slate-400 uppercase tracking-wider dark:bg-slate-900">OR</span>
                </div>

                <!-- Google Signup Button -->
                <x-auth.google-button wire:click="signUpWithGoogle" loading-target="signUpWithGoogle" />


                <!-- Bottom Redirect to Login -->
                <div class="mt-8 text-center text-xs text-slate-500 dark:text-slate-400">
                    Already have an account? 
                    <a 
                        href="{{ route('login') }}" 
                        wire:navigate 
                        class="font-bold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition"
                    >
                        Login
                    </a>
                </div>
            </x-auth.card>

        </div>
    </div>
</div>
