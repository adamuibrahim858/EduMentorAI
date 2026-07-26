<div class="relative grid min-h-screen place-items-center px-6 py-10 sm:px-8">
    <div class="absolute inset-0 -z-10 bg-[linear-gradient(135deg,#f8fafc_0%,#eef2ff_38%,#eff6ff_70%,#faf5ff_100%)] dark:bg-[linear-gradient(135deg,#020617_0%,#111827_45%,#172554_100%)]"></div>

    <div class="grid w-full max-w-6xl items-center gap-12 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)]">
        <aside class="hidden min-h-[620px] rounded-[2.5rem] border border-white/70 bg-white/50 p-8 shadow-2xl shadow-purple-950/10 backdrop-blur-xl dark:border-white/10 dark:bg-white/10 lg:block">
            <div class="flex h-full flex-col justify-between overflow-hidden rounded-[2rem] bg-slate-950 p-8 text-white shadow-inner">
                <div class="flex items-center justify-between">
                    <div class="grid grid-cols-4 gap-2">
                        <div class="size-3 rounded-full bg-indigo-300"></div>
                        <div class="size-3 rounded-full bg-blue-300"></div>
                        <div class="size-3 rounded-full bg-purple-300"></div>
                        <div class="size-3 rounded-full bg-white/40"></div>
                    </div>
                    <div class="h-2 w-24 rounded-full bg-white/25"></div>
                </div>

                <div class="space-y-4">
                    <div class="h-48 rounded-[2rem] border border-white/10 bg-white/10 p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="h-3 w-32 rounded-full bg-white/70"></div>
                                <div class="mt-4 h-3 w-52 rounded-full bg-white/20"></div>
                            </div>
                            <div class="grid size-16 place-items-center rounded-2xl bg-gradient-to-br from-indigo-400 to-blue-400 text-xl font-black">01</div>
                        </div>
                        <div class="mt-10 grid grid-cols-5 items-end gap-3">
                            <div class="h-10 rounded-2xl bg-white/10"></div>
                            <div class="h-16 rounded-2xl bg-blue-400/60"></div>
                            <div class="h-24 rounded-2xl bg-indigo-400/70"></div>
                            <div class="h-14 rounded-2xl bg-white/10"></div>
                            <div class="h-28 rounded-2xl bg-purple-400/70"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-3xl bg-gradient-to-br from-indigo-500 to-blue-500 p-5">
                            <div class="h-3 w-20 rounded-full bg-white/80"></div>
                            <div class="mt-12 h-4 w-28 rounded-full bg-white/40"></div>
                        </div>
                        <div class="rounded-3xl border border-white/10 bg-white/10 p-5">
                            <div class="h-3 w-24 rounded-full bg-white/70"></div>
                            <div class="mt-12 h-4 w-20 rounded-full bg-white/25"></div>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/10 p-6">
                    <div class="h-4 w-44 rounded-full bg-white/80"></div>
                    <div class="mt-4 h-3 w-full rounded-full bg-white/20"></div>
                    <div class="mt-3 h-3 w-3/4 rounded-full bg-white/20"></div>
                </div>
            </div>
        </aside>

        <x-auth.card>
            <x-auth.logo class="mb-10" />

            <div class="space-y-3">
                <h1 class="text-4xl font-bold tracking-tight text-slate-950 dark:text-white">Create your account</h1>
                <p class="text-base leading-7 text-slate-600 dark:text-slate-300">Start learning smarter with AI.</p>
            </div>

            <div class="mt-8 space-y-5">
                <x-auth.google-button
                    wire:click="signUpWithGoogle"
                    loading-target="signUpWithGoogle"
                    default-text="Sign up with Google"
                />

                <p class="text-center text-xs leading-6 text-slate-500 dark:text-slate-400">
                    By continuing you agree to Terms and Privacy.
                </p>
            </div>

            <div class="mt-8 border-t border-slate-200 pt-6 text-center text-sm text-slate-600 dark:border-white/10 dark:text-slate-300">
                Already have account?
                <a href="{{ route('login') }}" wire:navigate class="font-semibold text-indigo-600 transition hover:text-purple-600 dark:text-indigo-300">Login</a>
            </div>
        </x-auth.card>
    </div>
</div>
