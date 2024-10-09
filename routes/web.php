<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::prefix('v1')->group(function () {
    Route::get('/members', [MemberController::class, 'index']);
    Route::get('/members/{discord_id}', [MemberController::class, 'show']);
    Route::put('/members/{discord_id}', [MemberController::class, 'update']);
});

Route::get('/members', [App\Http\Controllers\MemberController::class, 'index'])->name('members.index');

