<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// API Routes
Route::prefix('v1')->group(function () {
    Route::get('/members', [MemberController::class, 'index']);
    Route::get('/members/{discord_id}', [MemberController::class, 'show']);
    Route::put('/members/{discord_id}', [MemberController::class, 'update']);
});

// Public Web Routes
Route::get('/members', [App\Http\Controllers\MemberController::class, 'index'])->name('members.index');
Route::get('/events', [HomeController::class, 'events'])->name('events.index');
Route::get('/events/{id}', [HomeController::class, 'eventShow'])->name('events.show');
Route::get('/leaderboard', [HomeController::class, 'leaderboard'])->name('leaderboard');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/join', [HomeController::class, 'join'])->name('join');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [AuthController::class, 'dashboard'])->name('profile.dashboard');
        Route::get('/edit', [AuthController::class, 'editProfile'])->name('profile.edit');
        Route::put('/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    });
});

