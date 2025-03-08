<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']); // ✅ Fix CSRF route

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); 
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
});
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Token Refresh
Route::post('/refresh-token', [AuthController::class, 'refreshToken']);

// Google OAuth
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// Hotel Routes
Route::get('/hotels', [HotelController::class, 'index']);
Route::post('/hotels', [HotelController::class, 'store']);
Route::put('/hotels/{id}', [HotelController::class, 'update']);
Route::get('/hotels/{id}', [HotelController::class, 'show']);
Route::delete('/hotels/{id}', [HotelController::class, 'destroy']);



