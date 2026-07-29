<div class="space-y-6">

    {{-- Load Marked JS for client-side Markdown rendering --}}
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    {{-- Page Header --}}
    <div class="relative overflow-hidden rounded-3xl border border-slate-200/80 bg-gradient-to-r from-indigo-900 via-indigo-950 to-slate-900 p-6 sm:p-8 text-white shadow-xl dark:border-slate-800">
        <div class="absolute -right-16 -top-16 size-64 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 size-64 rounded-full bg-purple-500/20 blur-3xl pointer-events-none"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#818cf8_1px,transparent_1px)] [background-size:20px_20px] opacity-10 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-semibold backdrop-blur-md">
                    <span class="size-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>General AI Assistant Active</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight text-white">
                    EduMentor <span class="bg-gradient-to-r from-indigo-200 via-purple-200 to-pink-200 bg-clip-text text-transparent">AI Assistant</span>
                </h1>
                <p class="text-xs text-slate-300 max-w-lg leading-relaxed">
                    Powered by Gemma 4. Ask anything related to education, programming, science, mathematics, research, technology, or general knowledge.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <button
                    wire:click="startNewChat"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 px-4 py-2.5 text-xs font-bold text-white shadow-lg transition active:scale-95"
                    title="Start a new conversation"
                >
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Chat
                </button>
            </div>
        </div>
    </div>

    {{-- Chat Interface --}}
    <div
        x-data="{
            messages: @js($messages),
            input: '',
            loading: false,
            scrollBottom() {
                this.$nextTick(() => {
                    const el = this.$refs.chatBody;
                    if (el) el.scrollTop = el.scrollHeight;
                });
            },
            renderMarkdown(content) {
                if (!content) return '';
                if (typeof marked !== 'undefined' && marked.parse) {
                    try {
                        return marked.parse(content);
                    } catch (e) {
                        return content;
                    }
                }
                return content;
            }
        }"
        x-init="scrollBottom(); $watch('messages', () => scrollBottom())"
        class="flex flex-col rounded-3xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-lg overflow-hidden"
        style="height: min(68vh, 660px);"
    >
        {{-- Chat Header --}}
        <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-200/80 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 shrink-0">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="size-9 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white shadow-md">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <span class="absolute -bottom-0.5 -right-0.5 size-2.5 rounded-full bg-emerald-500 ring-2 ring-white dark:ring-slate-900"></span>
                </div>
                <div>
                    <h2 class="text-sm font-extrabold text-slate-900 dark:text-white flex items-center gap-1.5">
                        EduMentor AI
                        <span class="rounded-full bg-indigo-100 dark:bg-indigo-950/80 px-2 py-0.5 text-[10px] font-bold text-indigo-600 dark:text-indigo-400">Gemma 4</span>
                    </h2>
                    <div class="flex items-center gap-1 text-xs text-emerald-600 dark:text-emerald-400 font-semibold">
                        <span class="size-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Online &amp; Ready
                    </div>
                </div>
            </div>
            <span class="text-[10px] text-slate-400 dark:text-slate-600 font-medium">Powered by Gemma 4</span>
        </div>

        {{-- Messages Body --}}
        <div x-ref="chatBody" class="flex-1 overflow-y-auto p-5 space-y-4 scroll-smooth">
            <template x-for="(msg, i) in messages" :key="i">
                <div
                    class="flex w-full"
                    :class="msg.role === 'user' ? 'justify-end' : 'justify-start'"
                >
                    {{-- Avatar --}}
                    <div :class="msg.role === 'user'
                        ? 'size-7 rounded-lg bg-gradient-to-tr from-slate-500 to-slate-700 flex items-center justify-center text-white text-[10px] font-bold shrink-0 mt-0.5'
                        : 'size-7 rounded-lg bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white text-[10px] font-bold shrink-0 mt-0.5'">
                        <span x-text="msg.role === 'user' ? 'You' : 'AI'"></span>
                    </div>

                    {{-- Bubble --}}
                    <div :class="msg.role === 'user'
                        ? 'max-w-[82%] rounded-2xl rounded-tl-sm bg-indigo-600 text-white px-4 py-2.5 text-sm leading-relaxed shadow-md whitespace-pre-wrap'
                        : 'max-w-[82%] rounded-2xl rounded-tl-sm bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 px-4 py-3 text-sm leading-relaxed overflow-x-auto'">
                        
                        <template x-if="msg.role === 'user'">
                            <p x-text="msg.content"></p>
                        </template>

                        <template x-if="msg.role !== 'user'">
                            <div class="chat-markdown prose dark:prose-invert prose-sm max-w-none space-y-2" x-html="renderMarkdown(msg.content)"></div>
                        </template>
                    </div>
                </div>
            </template>

            {{-- Loading & Typing indicator --}}
            <div x-show="loading" class="flex items-start gap-3" x-cloak>
                <div class="size-7 rounded-lg bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white text-[10px] font-bold shrink-0">AI</div>
                <div class="rounded-2xl rounded-tl-sm bg-slate-100 dark:bg-slate-800 px-4 py-3 flex items-center gap-3">
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-300">EduMentor AI is thinking...</span>
                    <div class="flex items-center gap-1">
                        <span class="size-1.5 rounded-full bg-indigo-500 animate-bounce" style="animation-delay:0ms"></span>
                        <span class="size-1.5 rounded-full bg-indigo-500 animate-bounce" style="animation-delay:150ms"></span>
                        <span class="size-1.5 rounded-full bg-indigo-500 animate-bounce" style="animation-delay:300ms"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Input Form --}}
        <div class="p-3.5 border-t border-slate-200/80 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-950/60 shrink-0">
            <form
                x-ref="chatForm"
                @submit.prevent="
                    if (!input.trim() || loading) return;
                    const userMsg = input.trim();
                    messages.push({ role: 'user', content: userMsg });
                    input = '';
                    loading = true;
                    scrollBottom();

                    $wire.sendMessage(userMsg).then(reply => {
                        messages.push({ role: 'assistant', content: reply });
                        loading = false;
                        scrollBottom();
                    }).catch(err => {
                        messages.push({ role: 'assistant', content: 'An unexpected error occurred. Please try again.' });
                        loading = false;
                        scrollBottom();
                    });
                "
                class="flex items-end gap-2"
            >
                <textarea
                    x-model="input"
                    id="chat-input"
                    rows="1"
                    placeholder="Ask me anything related to education, programming, science, mathematics..."
                    :disabled="loading"
                    @keydown.enter="
                        if (!$event.shiftKey) {
                            $event.preventDefault();
                            if (input.trim() && !loading) {
                                $refs.chatForm.requestSubmit();
                            }
                        }
                    "
                    class="w-full resize-none rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-2.5 text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition disabled:opacity-60 max-h-32 scrollbar-thin"
                ></textarea>

                <button
                    type="submit"
                    :disabled="loading || !input.trim()"
                    class="size-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shrink-0 hover:bg-indigo-700 active:scale-95 transition disabled:opacity-50 disabled:cursor-not-allowed mb-0.5"
                >
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9-7-9-7-9 7 9 7zm0 0v-8"/>
                    </svg>
                </button>
            </form>
            <div class="mt-1.5 flex items-center justify-between px-1 text-[10px] text-slate-400 dark:text-slate-600">
                <span>Press <strong>Enter</strong> to send, <strong>Shift + Enter</strong> for newline</span>
                <span>EduMentor AI powered by Gemma 4</span>
            </div>
        </div>
    </div>

</div>
