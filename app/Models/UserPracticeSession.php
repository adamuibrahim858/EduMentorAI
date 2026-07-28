<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserPracticeSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'practice_set_id',
        'started_at',
        'submitted_at',
        'score',
        'percentage',
        'time_taken',
        'status',
    ];

    protected $casts = [
        'started_at'   => 'datetime',
        'submitted_at' => 'datetime',
        'score'        => 'decimal:2',
        'percentage'   => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function practiceSet(): BelongsTo
    {
        return $this->belongsTo(PracticeSet::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(UserAnswer::class, 'session_id');
    }
}
