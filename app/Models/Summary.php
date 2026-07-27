<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Summary extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'material_id',
        'title',
        'summary',
        'html_content',
        'plain_text',
        'pdf_path',
        'summary_type',
        'difficulty',
        'generated_by',
        'ai_model',
        'prompt_version',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(CourseMaterial::class, 'material_id');
    }
}
