<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Announcements - accessible by all authenticated users
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');

    // Schedules - accessible by all authenticated users
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');

    // Grades - students and teachers
    Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');

    // Payments - students only
    Route::middleware('role:student')->group(function () {
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    });

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('announcements', AnnouncementController::class)->except(['index', 'show']);
        Route::resource('schedules', ScheduleController::class)->except(['index']);
        Route::resource('payments', PaymentController::class)->except(['index']);
    });

    // Teacher routes
    Route::middleware('role:teacher')->prefix('teacher')->name('teacher.')->group(function () {
        Route::resource('grades', GradeController::class)->except(['index']);
        Route::get('/schedules', [ScheduleController::class, 'teacherSchedules'])->name('schedules');
    });
});

require __DIR__.'/auth.php';
