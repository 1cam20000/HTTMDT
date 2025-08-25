<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\WelcomeController;

// Admin controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

// User controllers
use App\Http\Controllers\User\CategoryController as UserCategoryController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\OrderController;

// =====================
// 🏠 TRANG CHỦ
// =====================
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// =====================
// 🔐 AUTH
// =====================
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================
// 📧 EMAIL VERIFICATION
// =====================

// Hiển thị thông báo cần xác minh
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Xử lý link xác minh trong email
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('welcome');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Gửi lại email xác minh
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link xác thực mới đã được gửi đến email của bạn!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// =====================
// 👑 ADMIN ROUTES
// =====================
Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // CRUD Danh mục
        Route::resource('/categories', AdminCategoryController::class);

        // CRUD Sản phẩm
        Route::resource('/products', AdminProductController::class);
    });

// =====================
// 🙋 USER ROUTES
// =====================
Route::middleware(['auth', 'verified'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // Danh mục (chỉ xem)
        Route::get('/categories', [UserCategoryController::class, 'index'])->name('categories.index');

        // Sản phẩm (chỉ xem + chi tiết)
        Route::get('/products', [UserProductController::class, 'index'])->name('products.index');
        // dùng {product} để hỗ trợ route model binding
        Route::get('/products/{product}', [UserProductController::class, 'show'])->name('products.show');

        // ====== GIỎ HÀNG (Lab04) ======
        // Hiển thị giỏ hàng
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

        // Thêm sản phẩm vào giỏ (POST tới /cart/add/{product})
        Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

        // Cập nhật số lượng (PATCH /cart/{id})
        Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');

        // Xoá 1 sản phẩm (DELETE /cart/remove/{product})
        Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

        // Xoá toàn bộ giỏ (DELETE /cart/clear)
        Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

        // Lịch sử đơn hàng (để dành lab sau)
        // Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    });
