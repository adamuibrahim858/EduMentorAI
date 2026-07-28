<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudyRoutine extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'title',
        'study_day',
        'start_time',
        'end_time',
        'study_duration',
        'practice_duration',
        'repeat_type',
        'reminder_before',
        'status',
    ];

    protected $casts = [
        'status'            => 'boolean',
        'study_duration'    => 'integer',
        'practice_duration' => 'integer',
        'reminder_before'   => 'integer',
    ];

    // ----------------------------------------------------------------
    // Day name helpers
    // ----------------------------------------------------------------

    public static array $DAYS = [
        'monday', 'tuesday', 'wednesday', 'thursday',
        'friday', 'saturday', 'sunday',
    ];

    public static array $REMINDER_OPTIONS = [
        5  => '5 minutes before',
        10 => '10 minutes before',
        15 => '15 minutes before',
        30 => '30 minutes before',
        60 => '1 hour before',
    ];

    /** Display day as capitalised string */
    public function dayLabel(): string
    {
        return ucfirst($this->study_day);
    }

    /** Formatted start time e.g. "09:30 AM" */
    public function formattedStart(): string
    {
        return Carbon::createFromTimeString($this->start_time)->format('g:i A');
    }

    /** Formatted end time e.g. "11:00 AM" */
    public function formattedEnd(): string
    {
        return Carbon::createFromTimeString($this->end_time)->format('g:i A');
    }

    /** Total duration of the session (study + practice) in minutes */
    public function totalDuration(): int
    {
        return $this->study_duration + $this->practice_duration;
    }

    /** Is this routine scheduled for today? */
    public function isToday(): bool
    {
        if ($this->repeat_type === 'daily') {
            return true;
        }
        return strtolower($this->study_day) === strtolower(now()->format('l'));
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

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeToday($query)
    {
        $today = strtolower(now()->format('l'));
        return $query->where(function ($q) use ($today) {
            $q->where('repeat_type', 'daily')
              ->orWhere(function ($q2) use ($today) {
                  $q2->whereIn('repeat_type', ['weekly', 'custom'])
                     ->where('study_day', $today);
              });
        });
    }

    public function scopeUpcoming($query)
    {
        // Next 7 days of days-of-week
        $days = [];
        for ($i = 1; $i <= 7; $i++) {
            $days[] = strtolower(now()->addDays($i)->format('l'));
        }
        return $query->where(function ($q) use ($days) {
            $q->where('repeat_type', 'daily')
              ->orWhere(function ($q2) use ($days) {
                  $q2->whereIn('repeat_type', ['weekly', 'custom'])
                     ->whereIn('study_day', $days);
              });
        });
    }
}
