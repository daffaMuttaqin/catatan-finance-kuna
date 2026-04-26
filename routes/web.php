<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityLogController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/admin-management', [AdminController::class, 'index']);
    Route::post('/admins', [AdminController::class, 'store']);
});

// Income routes - untuk semua role
Route::middleware(['auth'])->group(function () {
    Route::get('/incomes', [IncomeController::class, 'index']);
    Route::post('/incomes', [IncomeController::class, 'store']);
    Route::put('/incomes/{id}', [IncomeController::class, 'update']);
    Route::delete('/incomes/{id}', [IncomeController::class, 'destroy']);
});

// Expense routes - hanya untuk admin dan superadmin
Route::middleware(['auth'])->group(function () {
    Route::get('/expenses', [ExpenseController::class, 'index']);
    Route::post('/expenses', [ExpenseController::class, 'store']);
    Route::put('/expenses/{id}', [ExpenseController::class, 'update']);
    Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy']);
});

// Activity Logs - hanya untuk superadmin
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/activity-logs', [ActivityLogController::class, 'index']);
});

// Dashboard - untuk semua role
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index']);

require __DIR__ . '/auth.php';
