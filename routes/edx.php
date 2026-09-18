<?php

use App\Http\Controllers\EdxCourseController;
use Illuminate\Support\Facades\Route;

// edX Mirrored Courses Routes
Route::get('/edx/courses', [EdxCourseController::class, 'index'])->name('edx.courses.index');
Route::get('/edx/courses/{edxId}', [EdxCourseController::class, 'show'])->name('edx.courses.show');

Route::middleware('auth')->group(function () {
    Route::post('/edx/courses/sync', [EdxCourseController::class, 'sync'])->name('edx.courses.sync');
});