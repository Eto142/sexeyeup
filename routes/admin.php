<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SendEmailController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\FlashSaleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->prefix('admin')->name('admin.')->group(function () {

    // Guest-only routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    });

    // Auth-protected routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

        // Users (commented out — customers don't register)
        // Route::get('/users', [ManageUserController::class, 'ManageUsers'])->name('users');
        // Route::get('/profile/{id}', [ManageUserController::class, 'userProfile'])->name('profile');
        // Route::delete('/delete/{id}', [ManageUserController::class, 'deleteUser'])->name('delete');

        // Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

        Route::get('/send-email', [SendEmailController::class, 'index'])->name('send.email');
        Route::post('/send-email', [SendEmailController::class, 'send'])->name('send.email.post');

        // Products CRUD
        Route::resource('products', ProductController::class)->names('products');

        // Flash Sales CRUD
        Route::resource('flash-sales', FlashSaleController::class)->names('flash-sales');

        // Change Password
        Route::get('/change-password', [AdminProfileController::class, 'showChangePassword'])->name('change.password');
        Route::post('/change-password', [AdminProfileController::class, 'changePassword'])->name('change.password.post');
    });

});



