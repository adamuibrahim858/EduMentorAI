<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'practice_set_id',
        'course_id',
        'question',
        'question_type',
        'difficulty',
        'topic',
        'marks',
        'explanation',
        'correct_answer',
    ];

    public function practiceSet(): BelongsTo
    {
        return $this->belongsTo(PracticeSet::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }
}
