<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Items
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
    Route::get('/my-items', [ItemController::class, 'myItems'])->name('items.my');

    // Claims
    Route::get('/claims/match/{match}', [ClaimController::class, 'create'])->name('claims.create');
    Route::post('/claims/match/{match}', [ClaimController::class, 'store'])->name('claims.store');
    Route::get('/my-claims', [ClaimController::class, 'myClams'])->name('claims.my');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/items', [AdminController::class, 'items'])->name('items');
    Route::get('/claims', [AdminController::class, 'claims'])->name('claims');
    Route::patch('/claims/{claim}/approve', [AdminController::class, 'approveClaim'])->name('claims.approve');
    Route::patch('/claims/{claim}/reject', [AdminController::class, 'rejectClaim'])->name('claims.reject');
    Route::get('/matches', [AdminController::class, 'matches'])->name('matches');

    // Manage Admins
    Route::get('/admins', [AdminUserController::class, 'index'])->name('admins.index');
    Route::post('/admins', [AdminUserController::class, 'store'])->name('admins.store');
});

require __DIR__.'/auth.php';