<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PracticeSet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'course_id',
        'title',
        'generated_from',
        'question_type',
        'difficulty',
        'total_questions',
        'objective_questions',
        'essay_questions',
        'estimated_time',
        'status',
        'ai_request_payload',
        'error_message',
    ];

    protected $casts = [
        'ai_request_payload' => 'array',
    ];

    /**
     * Statuses that indicate AI still needs to run.
     */
    public function isPending(): bool
    {
        return in_array($this->status, ['pending_ai', 'generating']);
    }

    public function isReady(): bool
    {
        return $this->status === 'ready';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending_ai'  => 'Pending AI Generation',
            'generating'  => 'Generating...',
            'ready'       => 'Ready',
            'failed'      => 'Failed',
            default       => ucfirst($this->status),
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'pending_ai'  => 'amber',
            'generating'  => 'blue',
            'ready'       => 'emerald',
            'failed'      => 'rose',
            default       => 'slate',
        };
    }

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(UserPracticeSession::class);
    }

    /**
     * Count how many times this user attempted this set.
     */
    public function userAttemptCount(int $userId): int
    {
        return $this->sessions()->where('user_id', $userId)->count();
    }
}
