<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Gemma / Gemini AI Key & Service Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for communicating with Google AI / Gemini API platform.
    |
    */

    'api_key' => env('GEMMA_AI_API_KEY'),

    'model' => env('GEMMA_MODEL', 'gemini-2.5-flash'),

    'fallback_model' => env('GEMMA_FALLBACK_MODEL', 'gemini-2.0-flash-lite'),

    'endpoint' => env('GEMMA_API_ENDPOINT', 'https://generativelanguage.googleapis.com/v1beta/models'),

    'timeout' => (int) env('GEMMA_TIMEOUT', 60),

    'max_upload_size_mb' => (int) env('MAX_PDF_UPLOAD_SIZE_MB', 20),
];
