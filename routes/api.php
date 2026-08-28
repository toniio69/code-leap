<?php

use App\Http\Controllers\Api\CourseProviderController;
use App\Http\Controllers\Api\EdxCourseController;
use App\Http\Controllers\Api\OpenEdXController;
use Illuminate\Support\Facades\Route;

Route::get('/courses/edx/search', [EdxCourseController::class, 'searchCourses']);

Route::middleware('auth:sanctum,web')->group(function () {
    Route::get('/courses/youtube', [CourseProviderController::class, 'getYouTubeCourse']);
    Route::get('/courses/openedx', [OpenEdXController::class, 'getCourses']);
    Route::get('/courses/openedx/{courseId}/integrity', [OpenEdXController::class, 'getIntegritySignature']);
});