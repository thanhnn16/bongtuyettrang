<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [RegisteredUserController::class, 'store'])->name('register');
Route::post('login', [UserController::class, 'login'])->name('login');
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::post('check-phone-number', [RegisteredUserController::class, 'checkPhoneNumber'])->name('check-phone-number');

Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('products/category/{type}', [ProductController::class, 'showByType'])->name('products.showByType');
Route::get('products', [ProductController::class, 'index'])->name('products.index');

Route::get('product-types', [ProductTypeController::class, 'index'])->name('product-types');
Route::get('product-types/{productType}', [ProductTypeController::class, 'show'])->name('product-types.show');

Route::get('services', [ServiceController::class, 'index'])->name('services.index');
Route::get('services/{service}', [ServiceController::class, 'show'])->name('services.show');

// Authorization = Bearer [API token]
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show')->middleware('checkUser');
    Route::put('/user/update', [UserController::class, 'update'])->name('user.update')->middleware('checkUser');
    // routes/api.php
    Route::post('/user/upload-avatar', [UserController::class, 'uploadAvatar'])->name('user.uploadAvatar')->middleware('auth:sanctum');
});
