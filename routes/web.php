<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ExaminationEngineController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () { return view('auth.register'); })->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/verify-otp-view', function () { return view('auth.verify-otp'); });
Route::get('/verify-otp', function () { return redirect('/verify-otp-view'); });
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->middleware('auth');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'getDashboardData']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{user}/edit', [UserController::class, 'edit']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::get('/results', [\App\Http\Controllers\ResultController::class, 'index']);
    Route::delete('/results/{result}', [\App\Http\Controllers\ResultController::class, 'destroy']);
});

Route::middleware(['auth', 'role:lecturer'])->prefix('lecturer')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'getDashboardData']);
    Route::get('/courses', [CourseController::class, 'index']);
    Route::post('/courses', [CourseController::class, 'store']);
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit']);
    Route::put('/courses/{course}', [CourseController::class, 'update']);
    Route::delete('/courses/{course}', [CourseController::class, 'destroy']);
    Route::get('/examinations', [ExaminationController::class, 'index']);
    Route::post('/examinations', [ExaminationController::class, 'store']);
    Route::get('/examinations/{examination}/edit', [ExaminationController::class, 'edit']);
    Route::put('/examinations/{examination}', [ExaminationController::class, 'update']);
    Route::delete('/examinations/{examination}', [ExaminationController::class, 'destroy']);
    Route::get('/sessions', [ExaminationController::class, 'listSessions']);
    Route::delete('/sessions/{session}/reset', [ExaminationController::class, 'resetSession']);
    Route::get('/questions', [QuestionController::class, 'index']);
    Route::post('/questions', [QuestionController::class, 'store']);
    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit']);
    Route::put('/questions/{question}', [QuestionController::class, 'update']);
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy']);
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'getDashboardData']);
    Route::get('/exams/{examinationId}/start', [ExaminationEngineController::class, 'showStartPage']);
    Route::post('/exams/{examinationId}/start', [ExaminationEngineController::class, 'startExam']);
    Route::get('/sessions/{sessionId}/questions-view', function($sessionId) { return view('exams.questions', ['sessionId' => $sessionId]); });
    Route::get('/sessions/{sessionId}/questions', [ExaminationEngineController::class, 'getQuestions']);
    Route::post('/sessions/{sessionId}/submit', [ExaminationEngineController::class, 'submitExam']);
    Route::post('/security/log', [SecurityController::class, 'logSecurityEvent']);
});
