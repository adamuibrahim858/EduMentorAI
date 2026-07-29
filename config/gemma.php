<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Gemma AI Key & Service Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for communicating with Google AI Gemma models platform.
    |
    */

    'api_key' => env('GEMMA_AI_API_KEY'),

    'model' => env('GEMMA_MODEL', 'gemma-4-31b-it'),

    'fallback_model' => env('GEMMA_FALLBACK_MODEL', 'gemma-4-26b-a4b-it'),

    'endpoint' => env('GEMMA_API_ENDPOINT', 'https://generativelanguage.googleapis.com/v1beta/models'),

    'timeout' => (int) env('GEMMA_TIMEOUT', 60),

    'max_upload_size_mb' => (int) env('MAX_PDF_UPLOAD_SIZE_MB', 20),
];
