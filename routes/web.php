<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\MainStockController;

// Welcome Page Route
Route::get('/', function () {
    return view('welcome');
});

// Admin Login Routes
Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// User Login Routes
Route::get('/userlogin', [AuthController::class, 'userLoginPage'])->name('userlogin');
Route::post('/userlogin', [AuthController::class, 'userLogin'])->name('userlogin.post');

// Middleware Protected Routes (Dashboard & User Management)
Route::middleware(['web'])->group(function () {
    // Admin Dashboard Route
    Route::get('/dashboard', function () {
        if (!session('user')) {
            return redirect()->route('login'); // Eğer kullanıcı oturumu yoksa login sayfasına yönlendir
        }
        return view('dashboard'); // Eğer oturum varsa dashboard sayfasını göster
    })->name('dashboard');

    // User Dashboard Route
    Route::get('/user-dashboard', [UserController::class, 'showStocks'])->name('userdashboard');

    // User Management Routes
    Route::resource('/users', UserController::class);

    // Stocks Routes
    Route::resource('/stocks', StockController::class);

    // Main Stocks Routes
    Route::get('/mainstocks', [MainStockController::class, 'index'])->name('mainstocks.index');
    Route::get('/mainstocks/create', [MainStockController::class, 'create'])->name('mainstocks.create');
    Route::post('/mainstocks/{id}/add', [MainStockController::class, 'add'])->name('mainstocks.add');

    Route::get('/mainstocks/requests', [MainStockController::class, 'requests'])->name('mainstocks.requests');
    Route::post('/mainstocks/requests/{id}/approve', [MainStockController::class, 'approveRequest'])->name('mainstocks.approveRequest');
    Route::post('/mainstocks/requests/{id}/reject', [MainStockController::class, 'rejectRequest'])->name('mainstocks.rejectRequest');

    Route::get('/dashboard', [MainStockController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/mainstocks/requests', [MainStockController::class, 'requests'])->name('mainstocks.requests');

    Route::get('/mainstocks', [MainStockController::class, 'index'])->name('mainstocks.index');


});
