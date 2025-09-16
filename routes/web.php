<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TurnController;
use App\Http\Controllers\Auth\RegisterController;

// --- Rutas Públicas ---

// Página de bienvenida
Route::get('/', [TurnController::class, 'welcome'])->name('welcome');

// Rutas de Registro de Usuario
// ESTA LÍNEA ES LA IMPORTANTE, ASEGÚRATE DE QUE TENGA ->name('register')
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Rutas de Autenticación (Login)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'sendPin']);
Route::get('verify-pin', [LoginController::class, 'showPinForm'])->name('verify-pin');
Route::post('verify-pin', [LoginController::class, 'verifyPin']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


// --- Rutas Protegidas (Requieren Autenticación) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [TurnController::class, 'dashboard'])->name('dashboard');
    Route::post('/turns', [TurnController::class, 'store'])->name('turns.store');
});