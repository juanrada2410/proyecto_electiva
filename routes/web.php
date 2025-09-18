<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TurnController;
use App\Http\Controllers\Auth\RegisterController;

// --- Rutas Públicas ---

// Página de bienvenida con la cola de turnos en tiempo real
Route::get('/', [TurnController::class, 'welcome'])->name('welcome');

// Rutas de Registro de Usuario
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Rutas de Autenticación (Login con PIN)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'sendPin']);
Route::get('verify-pin', [LoginController::class, 'showPinForm'])->name('verify-pin');
Route::post('verify-pin', [LoginController::class, 'verifyPin']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


// --- Rutas Protegidas (Requieren Autenticación) ---
Route::middleware(['auth'])->group(function () {
    // Dashboard del Cliente
    Route::get('/dashboard', [TurnController::class, 'dashboard'])->name('dashboard');
    
    // Acciones de Turnos para el Cliente
    Route::post('/turns', [TurnController::class, 'store'])->name('turns.store');
    
    // RUTA PARA Cancelar un turno
    Route::delete('/turns/{turn}', [TurnController::class, 'cancel'])->name('turns.cancel');
});

// --- (PRÓXIMAMENTE) Rutas para el Cajero ---
// Route::middleware(['auth', 'role:cashier'])->prefix('cashier')->name('cashier.')->group(function () {
//     Route::get('/dashboard', [App\Http\Controllers\Cashier\DashboardController::class, 'index'])->name('dashboard');
//     Route::post('/turns/{turn}/call', [App\Http\Controllers\Cashier\DashboardController::class, 'callTurn'])->name('turns.call');
//     Route::post('/turns/{turn}/finish', [App\Http\Controllers\Cashier\DashboardController::class, 'finishTurn'])->name('turns.finish');
// });

// --- (PRÓXIMAMENTE) Rutas para el Administrador ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('services', App\Http\Controllers\Admin\ServiceController::class);
});