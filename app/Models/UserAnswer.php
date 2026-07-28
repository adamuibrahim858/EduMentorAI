<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'question_id',
        'selected_option',
        'essay_answer',
        'ai_feedback',
        'score',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'score'      => 'decimal:2',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(UserPracticeSession::class, 'session_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
