<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop subdomain redirect
Route::domain('shop.odysseyclan.com')->group(function () {
    Route::get('/', [App\Http\Controllers\ShopController::class, 'redirect']);
    Route::get('/{any}', [App\Http\Controllers\ShopController::class, 'redirect'])->where('any', '.*');
});

// Alternative route for shop path on main domain
Route::get('/shop', [App\Http\Controllers\ShopController::class, 'redirect'])->name('shop.redirect');

// API Routes
Route::prefix('api/v1')->group(function () {
    // Public routes
    Route::get('/members', [MemberController::class, 'index']);
    Route::get('/members/{discord_id}', [MemberController::class, 'show']);
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::put('/members/{discord_id}', [MemberController::class, 'update']);
        Route::post('/members/{discord_id}/achievements', [MemberController::class, 'addAchievement']);
        Route::delete('/members/{discord_id}/achievements/{achievement_id}', [MemberController::class, 'removeAchievement']);
    });
});

// Public Web Routes - accessible to everyone
Route::get('/join', [HomeController::class, 'join'])->name('join');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Public routes for news
Route::get('/news', [HomeController::class, 'news'])->name('news.index');
Route::get('/news/{id}', [HomeController::class, 'newsShow'])->name('news.show');

// Clan member-only routes - verification handled in controllers
Route::get('/members', [App\Http\Controllers\MemberController::class, 'index'])->name('members.index');
Route::get('/events', [HomeController::class, 'events'])->name('events.index');
Route::get('/events/{id}', [HomeController::class, 'eventShow'])->name('events.show');
Route::get('/leaderboard', [HomeController::class, 'leaderboard'])->name('leaderboard');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');

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
    
    // Verification Routes - accessible to all authenticated users
    Route::get('/verification/pending', [App\Http\Controllers\VerificationController::class, 'showPending'])->name('verification.pending');
    Route::get('/verification/rejected', [App\Http\Controllers\VerificationController::class, 'showRejected'])->name('verification.rejected');
    
    // Profile Routes - basic profile management regardless of verification status
    Route::prefix('profile')->group(function () {
        Route::get('/edit', [AuthController::class, 'editProfile'])->name('profile.edit');
        Route::put('/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    });
    
    // Routes that require verified member status
    Route::get('/profile', [AuthController::class, 'dashboard'])->name('profile.dashboard');
    
    // Admin Routes - Protected by middleware
    Route::prefix('admin')->middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        // Admin dashboard
        Route::get('/', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Admin management
        Route::get('/admins/create', [App\Http\Controllers\AdminController::class, 'showCreateAdmin'])->name('admin.admins.create');
        Route::post('/admins', [App\Http\Controllers\AdminController::class, 'storeAdmin'])->name('admin.admins.store');
        
        // Member management
        Route::get('/members', [App\Http\Controllers\MemberController::class, 'adminIndex'])->name('admin.members.index');
        Route::get('/members/{id}/edit', [App\Http\Controllers\MemberController::class, 'edit'])->name('admin.members.edit');
        Route::put('/members/{id}', [App\Http\Controllers\MemberController::class, 'update'])->name('admin.members.update');
        Route::delete('/members/{id}', [App\Http\Controllers\MemberController::class, 'destroy'])->name('admin.members.destroy');
        
        // Verification management
        Route::get('/verification', [App\Http\Controllers\VerificationController::class, 'adminIndex'])->name('admin.verification.index');
        Route::get('/verification/{id}', [App\Http\Controllers\VerificationController::class, 'adminShow'])->name('admin.verification.show');
        Route::post('/verification/{id}/approve', [App\Http\Controllers\VerificationController::class, 'approve'])->name('admin.verification.approve');
        Route::post('/verification/{id}/reject', [App\Http\Controllers\VerificationController::class, 'reject'])->name('admin.verification.reject');
        Route::post('/verification/{id}/reset', [App\Http\Controllers\VerificationController::class, 'resetToPending'])->name('admin.verification.reset');
        
        // News management
        Route::resource('news', App\Http\Controllers\NewsController::class)->names([
            'index' => 'admin.news.index',
            'create' => 'admin.news.create',
            'store' => 'admin.news.store',
            'show' => 'admin.news.show',
            'edit' => 'admin.news.edit',
            'update' => 'admin.news.update',
            'destroy' => 'admin.news.destroy',
        ]);
        
        // Events management
        Route::resource('events', App\Http\Controllers\EventController::class)->names([
            'index' => 'admin.events.index',
            'create' => 'admin.events.create',
            'store' => 'admin.events.store',
            'show' => 'admin.events.show',
            'edit' => 'admin.events.edit',
            'update' => 'admin.events.update',
            'destroy' => 'admin.events.destroy',
        ]);
        
        // Gallery management
        Route::resource('gallery', App\Http\Controllers\GalleryController::class)->parameters([
            'gallery' => 'image'
        ])->names([
            'index' => 'admin.gallery.index',
            'create' => 'admin.gallery.create',
            'store' => 'admin.gallery.store',
            'show' => 'admin.gallery.show',
            'edit' => 'admin.gallery.edit',
            'update' => 'admin.gallery.update',
            'destroy' => 'admin.gallery.destroy',
        ]);
        
        // Streamer management
        Route::resource('streamers', App\Http\Controllers\StreamerController::class)->names([
            'index' => 'admin.streamers.index',
            'create' => 'admin.streamers.create',
            'store' => 'admin.streamers.store',
            'edit' => 'admin.streamers.edit',
            'update' => 'admin.streamers.update',
            'destroy' => 'admin.streamers.destroy',
        ]);
        Route::post('/streamers/{streamer}/refresh', [App\Http\Controllers\StreamerController::class, 'refreshStatus'])->name('admin.streamers.refresh');
        Route::post('/streamers/refresh-all', [App\Http\Controllers\StreamerController::class, 'refreshAll'])->name('admin.streamers.refresh-all');
    });
});

