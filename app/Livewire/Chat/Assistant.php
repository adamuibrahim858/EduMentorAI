<?php

namespace App\Livewire\Chat;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Services\GemmaAIService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Assistant extends Component
{
    public string $message = '';
    public array $messages = [];
    public ?int $chatSessionId = null;

    protected string $systemPrompt = <<<PROMPT
You are EduMentor AI.

You are a friendly, knowledgeable, and professional educational assistant powered by Gemma 4.

Provide accurate, detailed, and easy-to-understand answers.

Explain concepts step by step.

Use Markdown formatting.

When appropriate include:

• Bullet points
• Tables
• Examples
• Code blocks
• Mathematical formulas
• Revision tips

Never claim to know things you are uncertain about.
PROMPT;

    public function mount(): void
    {
        $userId = Auth::id();
        if (!$userId) {
            return;
        }

        // Get the latest chat session for this user or create a new one
        $session = ChatSession::where('user_id', $userId)
            ->latest('updated_at')
            ->first();

        if (!$session) {
            $session = ChatSession::create([
                'user_id' => $userId,
                'title' => 'General AI Conversation',
            ]);
        }

        $this->chatSessionId = $session->id;
        $this->loadMessages();
    }

    /**
     * Load existing chat session messages or populate initial welcome greeting.
     */
    protected function loadMessages(): void
    {
        $userId = Auth::id();
        if (!$this->chatSessionId || !$userId) {
            return;
        }

        $storedMessages = ChatMessage::where('chat_session_id', $this->chatSessionId)
            ->where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($storedMessages->isEmpty()) {
            $userName = Auth::user()?->name ?? 'Student';
            $greeting = "Hello {$userName} 👋\n\nWelcome to EduMentor AI.\n\nI'm your AI learning assistant powered by Gemma 4.\n\nAsk me anything related to education, programming, science, mathematics, research, technology, or general knowledge.\n\nI'll do my best to help you.";

            // Save welcome message to database
            $welcomeMsg = ChatMessage::create([
                'chat_session_id' => $this->chatSessionId,
                'user_id' => $userId,
                'role' => 'assistant',
                'content' => $greeting,
            ]);

            $this->messages = [
                [
                    'role' => 'assistant',
                    'content' => $greeting,
                ]
            ];
        } else {
            $this->messages = $storedMessages->map(fn($msg) => [
                'role' => $msg->role,
                'content' => $msg->content,
            ])->toArray();
        }
    }

    /**
     * Clear current conversation and start a new chat session.
     */
    public function startNewChat(): void
    {
        $userId = Auth::id();
        if (!$userId) return;

        $session = ChatSession::create([
            'user_id' => $userId,
            'title' => 'General AI Conversation - ' . now()->format('M d, H:i'),
        ]);

        $this->chatSessionId = $session->id;
        $this->messages = [];
        $this->loadMessages();
    }

    /**
     * Process message sent from Alpine front-end.
     */
    public function sendMessage(string $userMessage, GemmaAIService $gemmaService): string
    {
        $userId = Auth::id();
        $userMessage = trim($userMessage);

        if (empty($userMessage) || !$userId) {
            return 'Please enter a message.';
        }

        // Ensure active chat session
        if (!$this->chatSessionId) {
            $session = ChatSession::create([
                'user_id' => $userId,
                'title' => substr($userMessage, 0, 40),
            ]);
            $this->chatSessionId = $session->id;
        }

        // Save User Message to Database
        ChatMessage::create([
            'chat_session_id' => $this->chatSessionId,
            'user_id' => $userId,
            'role' => 'user',
            'content' => $userMessage,
        ]);

        // Build history array for API context
        $history = [];
        foreach ($this->messages as $msg) {
            $history[] = [
                'role' => $msg['role'],
                'content' => $msg['content'],
            ];
        }
        $history[] = [
            'role' => 'user',
            'content' => $userMessage,
        ];

        try {
            // Call Gemma 4 AI service
            $result = $gemmaService->generateGeneralChatResponse($history, $this->systemPrompt);

            if ($result['success']) {
                $aiResponse = $result['data'];

                // Save AI Assistant response to Database
                ChatMessage::create([
                    'chat_session_id' => $this->chatSessionId,
                    'user_id' => $userId,
                    'role' => 'assistant',
                    'content' => $aiResponse,
                ]);

                // Update session title if first user message
                $session = ChatSession::find($this->chatSessionId);
                if ($session && ($session->title === 'General AI Conversation' || empty($session->title))) {
                    $session->update(['title' => substr($userMessage, 0, 50)]);
                }

                return $aiResponse;
            }

            // Handle quota or general errors
            if (!empty($result['quota_exceeded'])) {
                $errorResponse = "Your AI request couldn't be completed because the daily Gemma 4 quota has been reached. Please try again later when the quota resets.";
            } else {
                $errorResponse = "An error occurred while connecting to EduMentor AI. " . ($result['error'] ?? 'Please try again later.');
            }

            // Log error
            Log::error('EduMentor AI Chat Failure', [
                'user_id' => $userId,
                'chat_session_id' => $this->chatSessionId,
                'error' => $result['error'] ?? 'Unknown error',
                'quota_exceeded' => $result['quota_exceeded'] ?? false,
            ]);

            // Save error notice to chat session so history remains consistent
            ChatMessage::create([
                'chat_session_id' => $this->chatSessionId,
                'user_id' => $userId,
                'role' => 'assistant',
                'content' => $errorResponse,
            ]);

            return $errorResponse;

        } catch (\Throwable $e) {
            Log::error('EduMentor AI Unhandled Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $fallbackMessage = "Sorry, EduMentor AI encountered an issue processing your request. Please try again in a moment.";

            ChatMessage::create([
                'chat_session_id' => $this->chatSessionId,
                'user_id' => $userId,
                'role' => 'assistant',
                'content' => $fallbackMessage,
            ]);

            return $fallbackMessage;
        }
    }

    public function render()
    {
        return view('livewire.chat.assistant')
            ->layout('layouts.dashboard', ['title' => 'EduMentor AI Assistant']);
    }
}
