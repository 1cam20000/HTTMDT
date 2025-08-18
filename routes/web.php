<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\WelcomeController;

// Trang chủ
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// ========== AUTH ==========
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// ========== ADMIN ==========
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // CRUD Sản phẩm
    Route::resource('/admin/products', AdminProductController::class, [
        'as' => 'admin' // tên route => admin.products.index, admin.products.show, ...
    ]);

    // CRUD Danh mục
    Route::resource('/admin/categories', AdminCategoryController::class, [
        'as' => 'admin' // tên route => admin.categories.index, ...
    ]);
});

// ========== USER ==========
Route::middleware(['auth'])->group(function () {
    // Xem danh sách sản phẩm
    Route::get('/products', [UserProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [UserProductController::class, 'show'])->name('products.show');
});
