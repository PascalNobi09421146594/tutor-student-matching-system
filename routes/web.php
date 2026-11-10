
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\TutorProfileController;
use App\Http\Controllers\MySessionsController;
use App\Http\Controllers\FindTutorController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\TutorReviewController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/register', [RegisterController::class, 'store']);


Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth');

Route::get('/student/dashboard', [DashboardController::class, 'student'])
    ->middleware(['auth', 'role:student'])
    ->name('student.dashboard');

Route::get('/tutor/dashboard', [DashboardController::class, 'tutor'])
    ->middleware(['auth', 'role:tutor'])
    ->name('tutor.dashboard');

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/profile', [StudentProfileController::class, 'edit'])
        ->name('student.profile.edit');

    Route::put('/student/profile', [StudentProfileController::class, 'update'])
        ->name('student.profile.update');
    
    Route::get('/student/find-tutors', [FindTutorController::class, 'index'])
        ->name('student.find-tutors');
    
});

Route::middleware(['auth', 'role:tutor'])->group(function () {
    Route::get('/tutor/profile', [TutorProfileController::class, 'edit'])
        ->name('tutor.profile.edit');

    Route::put('/tutor/profile', [TutorProfileController::class, 'update'])
        ->name('tutor.profile.update');
});

Route::middleware(['auth', 'role:student,tutor'])->group(function () {
    Route::get('/sessions', [MySessionsController::class, 'index'])
        ->name('sessions.index');

    Route::patch('/sessions/{session}/status', [
        MySessionsController::class,
        'updateStatus'
    ])->name('sessions.update-status');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/sessions/create', [MySessionsController::class, 'create'])
        ->name('sessions.create');

    Route::post('/sessions', [MySessionsController::class, 'store'])
        ->name('sessions.store');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->middleware('auth')->name('logout');


Route::post('/student/notifications/read-all', function () {
    auth()->user()->unreadNotifications->markAsRead();

    return back()->with('success', 'Notifications marked as read.');
})->middleware(['auth', 'role:student'])
  ->name('notifications.read-all');


Route::middleware(['auth', 'role:student'])->group(function () {
    Route::post(
        '/sessions/{session}/reviews',
        [TutorReviewController::class, 'store']
    )->name('sessions.reviews.store');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])
        ->name('users');

    Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole'])
        ->name('users.update-role');

});


