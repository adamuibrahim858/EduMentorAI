<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lecturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'name',
        'profession',
        'highest_qualification',
        'specialization',
        'department',
        'years_of_experience',
        'teaching_style',
        'research_interest',
        'additional_information',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
