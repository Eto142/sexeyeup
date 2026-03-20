<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home']);
Route::get('/shop', [PageController::class, 'shop']);
Route::get('/deals', [PageController::class, 'deals']);
Route::get('/about', [PageController::class, 'about']);

Route::post('/orders', [OrderController::class, 'store']);

