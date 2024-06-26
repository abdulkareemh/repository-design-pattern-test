<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/register', [RegisterController::class, 'register'])->withoutMiddleware('auth:sanctum');
    Route::post('/login', [LoginController::class, 'login'])->withoutMiddleware('auth:sanctum');

    Route::post('/logout', [LogoutController::class, 'logout']);

    Route::resource('products', ProductController::class)->except(['create', 'edit']);
    Route::resource('users', UserController::class)->except(['create', 'edit']);

    Route::post('user-update-avatar/{id}',[UserController::class,'updateAvatar']); // for update user avatar
    Route::post('product-update-image/{id}',[ProductController::class,'updateImage']); // for update product images
});