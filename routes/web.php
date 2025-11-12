<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar rutas web para tu aplicación. Estas
| rutas son cargadas por RouteServiceProvider y todas ellas
| serán asignadas al grupo de middleware "web".
|
*/

// --- ¡TODAS ESTAS LÍNEAS ESTÁN CORREGIDAS! ---
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TurnController;
use App\Http\Controllers\DashboardController; // <- Se añadió esta
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Cashier\DashboardController as CashierDashboardController;

// Rutas de Autenticación (Login)
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::get('/verify-pin', [LoginController::class, 'showPinForm'])->name('verify-pin');
Route::post('/verify-pin', [LoginController::class, 'verifyPin']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta de Registro (Register)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rutas del Dashboard de Cliente (Protegidas por auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/turn', [TurnController::class, 'store'])->name('turn.store');
    Route::delete('/turn/{turn}', [TurnController::class, 'cancel'])->name('turn.cancel');
});

// Rutas del Administrador
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::resource('services', AdminServiceController::class);
    // ... otras rutas de admin
});

// Rutas del Cajero
Route::middleware(['auth', 'role:cashier'])->prefix('cashier')->name('cashier.')->group(function () {
    Route::get('/dashboard', [CashierDashboardController::class, 'index'])->name('dashboard');
    // ... otras rutas de cajero
});