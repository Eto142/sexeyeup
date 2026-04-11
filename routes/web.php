<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PasscodeController;
use App\Http\Controllers\VisitorController;
use App\Http\Middleware\PasscodeMiddleware;
use Illuminate\Support\Facades\Route;

// Passcode gate (no middleware on these)
Route::get('/passcode', [PasscodeController::class, 'show'])->name('passcode.show');
Route::post('/passcode', [PasscodeController::class, 'verify'])->name('passcode.verify');

// Visitor email capture (after passcode, before site — no PasscodeMiddleware here)
Route::get('/welcome', [VisitorController::class, 'show'])->name('visitor.email.show');
Route::post('/welcome', [VisitorController::class, 'store'])->name('visitor.email.store');

// All public site routes protected by passcode
Route::middleware(PasscodeMiddleware::class)->group(function () {
    Route::get('/', [PageController::class, 'home']);
    Route::get('/shop', [PageController::class, 'shop']);
    Route::get('/deals', [PageController::class, 'deals']);
    Route::get('/how-to-order', [PageController::class, 'howToOrder']);
    Route::get('/about', [PageController::class, 'about']);
    Route::get('/qr-code', [PageController::class, 'qrCode']);

    Route::post('/orders', [OrderController::class, 'store']);
});

