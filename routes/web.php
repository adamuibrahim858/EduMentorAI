<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Auth\AuthError;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\Signup;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Dashboard\Index as Dashboard;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', Login::class)->name('login');
    Route::get('/signup', Signup::class)->name('signup');
    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
    Route::get('/auth/error', AuthError::class)->name('auth.error');
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/email/verify', VerifyEmail::class)->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/logout', LogoutController::class)->name('logout');
});

use App\Http\Controllers\SummaryController;
use App\Livewire\Course\Index as CourseIndex;
use App\Livewire\Course\Show as CourseShow;

Route::middleware(['auth', 'verified', 'active.account'])->group(function (): void {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    // Course Management Routes
    Route::get('/courses', CourseIndex::class)->name('courses.index');
    Route::get('/courses/{course}', CourseShow::class)->name('courses.show');

    // AI Summary PDF Routes
    Route::get('/summaries/{summary}/download', [SummaryController::class, 'download'])->name('summaries.download');
    Route::get('/summaries/{summary}/preview', [SummaryController::class, 'preview'])->name('summaries.preview');
});
