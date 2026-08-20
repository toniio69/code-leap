<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\StudentPerformanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EmailVerificationCodeController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\FreeCodeCampController;
use App\Http\Controllers\Instructor\CertificateController;
use App\Http\Controllers\PaystackController;
use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// All actions require active logins.
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'instructor' => redirect()->route('instructor.dashboard'),
            default => redirect()->route('student.dashboard'),
        };
    })->name('dashboard');

    Route::resource(
        'courses',
        CourseController::class
    );

    Route::post(
        '/courses/{course}/enroll',
        [EnrollmentController::class, 'store']
    )->name('courses.enroll');

    Route::post(
        '/courses/{course}/pay',
        [PaystackController::class, 'pay']
    )->name('paystack.pay');

    Route::get(
        '/paystack/callback',
        [PaystackController::class, 'handleGatewayCallback']
    )->name('paystack.callback');

});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', function () {
        $user = auth()->user();
        $enrolledCourses = $user->enrolledCourses()->with('instructor')->latest()->get();
        $completedCourses = $user->enrolledCourses()->wherePivot('completed', true)->with('instructor')->latest()->get();
        $inProgressCourses = $user->enrolledCourses()->wherePivot('completed', false)->with('instructor')->latest()->get();

        return view('dashboard', compact('enrolledCourses', 'completedCourses', 'inProgressCourses'));
    })->name('student.dashboard');
});

Route::post('/email/verify-code', [EmailVerificationCodeController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.code.verify');

Route::middleware(['auth', 'role:instructor'])->group(function () {
    Route::get('/instructor/dashboard', function () {
        $courses = Course::where('user_id', auth()->id())->get();
        $totalStudents = Enrollment::whereIn('course_id', $courses->pluck('id'))->count();
        $totalMaterials = CourseMaterial::whereIn('course_id', $courses->pluck('id'))->count();

        return view('Instructor.Dashboard', compact('courses', 'totalStudents', 'totalMaterials'));
    })->name('instructor.dashboard');

    Route::get('/instructor/certificates', [CertificateController::class, 'index'])
        ->name('instructor.certificates.index');

    Route::post('/instructor/certificates/{certificate}/issue', [CertificateController::class, 'issue'])
        ->name('instructor.certificates.issue');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::get('/admin/users', [AdminController::class, 'index'])
        ->name('admin.users');

    Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])
        ->name('admin.users.role');

    Route::get('/admin/analytics', AnalyticsController::class)
        ->name('admin.analytics');

    Route::get('/admin/student-performance', StudentPerformanceController::class)
        ->name('admin.student-performance');

    Route::get('/admin/payments', PaymentController::class)
        ->name('admin.payments');
});

Route::get('/auth/{provider}/callback', function ($provider) {
    $socialUser = Socialite::driver($provider)->user();

    $user = User::firstOrCreate(
        ['email' => $socialUser->getEmail()],
        [
            'name' => $socialUser->getName() ?? $socialUser->getNickname(),
            'password' => bcrypt(Str::random(24)),
            'role' => 'student',
        ]
    );

    Auth::login($user);

    return redirect('/dashboard');
});

Route::get('/auth/{provider}', function ($provider) {
    return Socialite::driver($provider)->redirect();
});

Route::post('/paystack/webhook', [PaystackController::class, 'handleWebhook'])
    ->name('paystack.webhook');

Route::middleware('auth')->group(function () {

    Route::get(
        '/online-courses',
        [FreeCodeCampController::class, 'index']
    )->name('freecodecamp.index');

    Route::get(
        '/online-courses/chapter/{chapter}',
        [FreeCodeCampController::class, 'chapter']
    )->name('freecodecamp.chapter');

    Route::get(
        '/online-courses/{superblock}',
        [FreeCodeCampController::class, 'show']
    )->name('freecodecamp.show');

});

require __DIR__.'/settings.php';
