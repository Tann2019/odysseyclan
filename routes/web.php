<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('v1')->group(function () {
    Route::get('/members', [MemberController::class, 'index']);
    Route::get('/members/{discord_id}', [MemberController::class, 'show']);
    Route::put('/members/{discord_id}', [MemberController::class, 'update']);
});

// Web routes
Route::get('/members', [App\Http\Controllers\MemberController::class, 'index'])->name('members.index');
Route::get('/events', [HomeController::class, 'events'])->name('events.index');
Route::get('/events/{id}', [HomeController::class, 'eventShow'])->name('events.show');
Route::get('/leaderboard', [HomeController::class, 'leaderboard'])->name('leaderboard');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/join', [HomeController::class, 'join'])->name('join');
Route::get('/about', [HomeController::class, 'about'])->name('about');

