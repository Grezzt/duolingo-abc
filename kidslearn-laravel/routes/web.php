<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\QuizController;

// Guest routes (redirect to dashboard if authenticated)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Learning routes
    Route::get('/learning', [LearningController::class, 'index'])->name('learning.index');
    Route::get('/learning/{category}', [LearningController::class, 'category'])->name('learning.category');
    Route::get('/api/animals/{category}', [LearningController::class, 'getAnimals'])->name('api.animals');

    // Quiz routes
    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
    Route::post('/quiz/check', [QuizController::class, 'checkAnswer'])->name('quiz.check');
});
