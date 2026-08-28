<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PerformanceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EmailVerificationCodeController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\Instructor\CertificateController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Guest / Public Authentication Endpoints
Route::get('/auth/{provider}', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('socialite.callback');

Route::post('/paystack/webhook', [PaystackController::class, 'handleWebhook'])
    ->name('paystack.webhook');

// Authenticated Routes (All Roles)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match (true) {
            $user->hasRole('admin') => redirect()->route('admin.dashboard'),
            $user->hasRole('instructor') => redirect()->route('instructor.dashboard'),
            default => redirect()->route('student.dashboard'),
        };
    })->name('dashboard');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    })->name('logout');

    Route::resource('courses', CourseController::class);
    Route::resource('courses.lessons', LessonController::class);

    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');
    Route::post('/courses/{course}/pay', [PaystackController::class, 'pay'])->name('paystack.pay');
    Route::get('/paystack/callback', [PaystackController::class, 'handleGatewayCallback'])->name('paystack.callback');

    Route::post('/email/verify-code', [EmailVerificationCodeController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.code.verify');
});

// Student Protected Routes
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', function () {
        $user = auth()->user();
        $enrolledCourses = $user->enrolledCourses()->with('instructor')->latest()->get();
        $completedCourses = $user->enrolledCourses()->wherePivot('completed', true)->with('instructor')->latest()->get();
        $inProgressCourses = $user->enrolledCourses()->wherePivot('completed', false)->with('instructor')->latest()->get();

        return view('dashboard', compact('enrolledCourses', 'completedCourses', 'inProgressCourses'));
    })->name('student.dashboard');
});

// Instructor Protected Routes
Route::middleware(['auth', 'role:instructor'])->group(function () {
    Route::get('/instructor/dashboard', function () {
        $courses = auth()
            ->user()
            ->courses()
            ->withCount(['students', 'materials'])
            ->get();

        $totalStudents = $courses->sum('students_count');
        $totalMaterials = $courses->sum('materials_count');

        return view('instructor.dashboard', compact('courses', 'totalStudents', 'totalMaterials'));
    })->name('instructor.dashboard');

    Route::get('/instructor/certificates', [CertificateController::class, 'index'])
        ->name('instructor.certificates.index');

    Route::post('/instructor/certificates/{certificate}/issue', [CertificateController::class, 'issue'])
        ->name('instructor.certificates.issue');
});

// Admin Protected Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->middleware('can:view-analytics')->name('admin.analytics');
    Route::get('/payments', [PaymentController::class, 'index'])->name('admin.payments');
    Route::get('/student-performance', [PerformanceController::class, 'index'])->name('admin.performance');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->middleware('can:manage-users')->name('admin.users.update-role');
});

// Additional Settings Routes
require __DIR__.'/settings.php';