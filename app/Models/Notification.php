<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'course_id',
        'title',
        'message',
        'type',
        'action_url',
        'data',
        'scheduled_at',
        'sent_at',
        'is_read',
    ];

    protected $casts = [
        'is_read'      => 'boolean',
        'scheduled_at' => 'datetime',
        'sent_at'      => 'datetime',
        'data'         => 'array',
    ];

    // Supported Types Constants
    public const TYPE_STUDY_REMINDER    = 'study_reminder';
    public const TYPE_PRACTICE_REMINDER = 'practice_reminder';
    public const TYPE_SUMMARY_READY     = 'summary_ready';
    public const TYPE_ROUTINE_REMINDER  = 'routine_reminder';
    public const TYPE_SYSTEM            = 'system_notification';
    public const TYPE_WEEKLY_PROGRESS   = 'weekly_progress';

    /**
     * Get label for notification type
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_STUDY_REMINDER    => 'Study Reminder',
            self::TYPE_PRACTICE_REMINDER => 'Practice Reminder',
            self::TYPE_SUMMARY_READY     => 'Summary Ready',
            self::TYPE_ROUTINE_REMINDER  => 'Routine Reminder',
            self::TYPE_SYSTEM            => 'System Notification',
            self::TYPE_WEEKLY_PROGRESS   => 'Weekly Progress',
            default                      => ucwords(str_replace('_', ' ', $this->type)),
        };
    }

    /**
     * Get badge color theme for notification type
     */
    public function getTypeBadgeColorAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_STUDY_REMINDER    => 'blue',
            self::TYPE_PRACTICE_REMINDER => 'violet',
            self::TYPE_SUMMARY_READY     => 'emerald',
            self::TYPE_ROUTINE_REMINDER  => 'amber',
            self::TYPE_SYSTEM            => 'indigo',
            self::TYPE_WEEKLY_PROGRESS   => 'rose',
            default                      => 'slate',
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

    // ----------------------------------------------------------------
    // Scopes
    // ----------------------------------------------------------------

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }
}
