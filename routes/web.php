<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\CourseMaterialController;
use App\Http\Controllers\SummaryController;
use App\Livewire\Auth\AuthError;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\Signup;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Course\Index as CourseIndex;
use App\Livewire\Course\Show as CourseShow;
use App\Livewire\Dashboard\Index as Dashboard;
use App\Livewire\Notification\Index as NotificationIndex;
use App\Livewire\Practice\Explanation as PracticeExplanation;
use App\Livewire\Practice\Index as PracticeIndex;
use App\Livewire\Practice\Quiz as PracticeQuiz;
use App\Livewire\Profile\Show as ProfileShow;
use App\Livewire\Progress\Index as ProgressIndex;
use App\Livewire\Routine\Index as RoutineIndex;
use App\Livewire\Setting\Index as SettingIndex;
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

Route::middleware(['auth', 'verified', 'active.account'])->group(function (): void {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', ProfileShow::class)->name('profile');
    Route::get('/practices', PracticeIndex::class)->name('practices.index');
    Route::get('/practices/{practiceSet}/quiz', PracticeQuiz::class)->name('practices.quiz');
    Route::get('/practices/session/{session}/explanation', PracticeExplanation::class)->name('practices.explanation');
    Route::get('/progress', ProgressIndex::class)->name('progress.index');
    Route::get('/academic-progress', ProgressIndex::class)->name('progress');
    Route::get('/routine', RoutineIndex::class)->name('routine');
    Route::get('/routines', RoutineIndex::class)->name('routines.index');
    Route::get('/notifications', NotificationIndex::class)->name('notifications.index');
    Route::get('/notifications-center', NotificationIndex::class)->name('notifications');
    Route::get('/settings', SettingIndex::class)->name('settings.index');

    // Course Management
    Route::get('/courses', CourseIndex::class)->name('courses.index');
    Route::get('/courses/{course}', CourseShow::class)->name('courses.show');

    // Course Material — standard HTTP (no Livewire file upload)
    Route::post('/courses/{course}/materials', [CourseMaterialController::class, 'upload'])->name('materials.upload');
    Route::get('/materials/{material}/download', [CourseMaterialController::class, 'download'])->name('materials.download');
    Route::delete('/materials/{material}', [CourseMaterialController::class, 'destroy'])->name('materials.destroy');

    // AI Summary PDF
    Route::get('/summaries/{summary}/download', [SummaryController::class, 'download'])->name('summaries.download');
    Route::get('/summaries/{summary}/preview', [SummaryController::class, 'preview'])->name('summaries.preview');
});
