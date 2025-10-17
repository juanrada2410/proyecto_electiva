<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TurnController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Cashier\DashboardController as CashierDashboardController;


Route::get('/', [TurnController::class, 'welcome'])->name('welcome');


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'sendPin']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::get('register', [LoginController::class, 'showLoginForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);


Route::get('verify-pin', [LoginController::class, 'showPinForm'])->name('verify-pin');
Route::post('verify-pin', [LoginController::class, 'verifyPin']);



Route::middleware(['auth'])->group(function () {
    

    Route::get('/dashboard', [TurnController::class, 'dashboard'])->name('dashboard');
    Route::post('/turns', [TurnController::class, 'store'])->name('turns.store');
    Route::delete('/turns/{turn}', [TurnController::class, 'cancel'])->name('turns.cancel');

  
    Route::middleware('role:cashier')->prefix('cashier')->name('cashier.')->group(function () {
        Route::get('/dashboard', [CashierDashboardController::class, 'index'])->name('dashboard');
       
    });

   
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', AdminUserController::class);
      
    });

});