<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PastQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'uploaded_by',
        'title',
        'original_filename',
        'year',
        'semester',
        'file',
        'mime_type',
        'file_size',
        'pages',
        'extracted_text',
        'processed',
        'status',
    ];

    protected $casts = [
        'processed' => 'boolean',
        'year' => 'integer',
        'pages' => 'integer',
        'file_size' => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
