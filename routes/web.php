<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Inventory Routes
    Route::resource('inventory', App\Http\Controllers\InventoryController::class);

    // Reports Routes
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/transactions', [App\Http\Controllers\ReportController::class, 'transactions'])->name('reports.transactions');
    Route::get('/reports/inventory', [App\Http\Controllers\ReportController::class, 'inventory'])->name('reports.inventory');

    // Settings Routes
    Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para Administrador
    Route::middleware(['check.role:Administrador'])->group(function () {
        Route::resource('users', UserController::class);
    });

    // Rutas para Administrador y Contador
    Route::middleware(['check.role:Administrador,Contador'])->group(function () {
        Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
        Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::get('transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
        Route::put('transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
        Route::delete('transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

        Route::post('inventories', [InventoryController::class, 'store'])->name('inventories.store');
        Route::get('inventories/create', [InventoryController::class, 'create'])->name('inventories.create');
        Route::get('inventories/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventories.edit');
        Route::put('inventories/{inventory}', [InventoryController::class, 'update'])->name('inventories.update');
        Route::delete('inventories/{inventory}', [InventoryController::class, 'destroy'])->name('inventories.destroy');
    });

    // Rutas de solo lectura para todos los usuarios autenticados
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('inventories', [InventoryController::class, 'index'])->name('inventories.index');
    Route::get('inventories/{inventory}', [InventoryController::class, 'show'])->name('inventories.show');

    // Rutas para Auditor
    Route::middleware(['check.role:Auditor'])->group(function () {
        Route::get('/audit', [AuditController::class, 'index'])->name('audit.index');
    });

    // Role Management Routes
    Route::middleware(['auth', 'role:Administrador'])->group(function () {
        Route::resource('roles', RoleController::class);
    });
});

require __DIR__.'/auth.php';
