<div class="relative grid min-h-screen place-items-center px-6 py-10 sm:px-8">
    <div class="absolute inset-0 -z-10 bg-[linear-gradient(135deg,#f8fafc_0%,#eef2ff_38%,#eff6ff_70%,#faf5ff_100%)] dark:bg-[linear-gradient(135deg,#020617_0%,#111827_45%,#172554_100%)]"></div>

    <div class="grid w-full max-w-6xl items-center gap-12 lg:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)]">
        <x-auth.card>
            <x-auth.logo class="mb-10" />

            <div class="space-y-3">
                <h1 class="text-4xl font-bold tracking-tight text-slate-950 dark:text-white">Welcome Back</h1>
                <p class="text-base leading-7 text-slate-600 dark:text-slate-300">Continue learning with your AI study companion.</p>
            </div>

            <div class="mt-8 space-y-5">
                <x-auth.flash-message :message="session('status')" />

                <x-auth.google-button
                    wire:click="continueWithGoogle"
                    loading-target="continueWithGoogle"
                    default-text="Continue with Google"
                />

                <p class="text-center text-xs leading-6 text-slate-500 dark:text-slate-400">
                    By continuing you agree to Terms and Privacy.
                </p>
            </div>

            <div class="mt-8 border-t border-slate-200 pt-6 text-center text-sm text-slate-600 dark:border-white/10 dark:text-slate-300">
                New to EduMentor AI?
                <a href="{{ route('signup') }}" wire:navigate class="font-semibold text-indigo-600 transition hover:text-purple-600 dark:text-indigo-300">Create an account</a>
            </div>
        </x-auth.card>

        <aside class="hidden min-h-[620px] rounded-[2.5rem] border border-white/70 bg-white/50 p-8 shadow-2xl shadow-blue-950/10 backdrop-blur-xl dark:border-white/10 dark:bg-white/10 lg:block">
            <div class="flex h-full flex-col justify-between overflow-hidden rounded-[2rem] bg-slate-950 p-8 text-white shadow-inner">
                <div class="flex items-center justify-between">
                    <div class="h-2 w-28 rounded-full bg-white/25"></div>
                    <div class="grid size-12 place-items-center rounded-2xl bg-white/10 text-sm font-bold">AI</div>
                </div>

                <div class="grid gap-4">
                    <div class="ml-auto h-24 w-4/5 rounded-3xl bg-gradient-to-r from-indigo-400 via-blue-400 to-purple-400 p-px">
                        <div class="h-full rounded-3xl bg-slate-950/80 p-5">
                            <div class="h-3 w-32 rounded-full bg-white/70"></div>
                            <div class="mt-5 grid grid-cols-3 gap-3">
                                <div class="h-10 rounded-2xl bg-white/10"></div>
                                <div class="h-10 rounded-2xl bg-white/20"></div>
                                <div class="h-10 rounded-2xl bg-white/10"></div>
                            </div>
                        </div>
                    </div>

                    <div class="h-36 rounded-3xl border border-white/10 bg-white/10 p-5">
                        <div class="grid grid-cols-[1fr_auto] items-center gap-6">
                            <div>
                                <div class="h-3 w-36 rounded-full bg-white/70"></div>
                                <div class="mt-4 h-3 w-56 rounded-full bg-white/20"></div>
                                <div class="mt-3 h-3 w-44 rounded-full bg-white/20"></div>
                            </div>
                            <div class="grid size-20 place-items-center rounded-full bg-gradient-to-br from-indigo-400 to-purple-400 text-2xl font-black">92</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="h-28 rounded-3xl bg-white/10 p-5">
                            <div class="h-3 w-20 rounded-full bg-white/60"></div>
                            <div class="mt-8 h-8 w-24 rounded-2xl bg-blue-400/70"></div>
                        </div>
                        <div class="h-28 rounded-3xl bg-white/10 p-5">
                            <div class="h-3 w-24 rounded-full bg-white/60"></div>
                            <div class="mt-8 h-8 w-20 rounded-2xl bg-purple-400/70"></div>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/10 p-6">
                    <div class="h-4 w-48 rounded-full bg-white/80"></div>
                    <div class="mt-4 h-3 w-full rounded-full bg-white/20"></div>
                    <div class="mt-3 h-3 w-2/3 rounded-full bg-white/20"></div>
                </div>
            </div>
        </aside>
    </div>
</div>
