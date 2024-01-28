<?php

use App\Http\Controllers\ListingController;
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

// Login
Route::post('login', [UserController::class, 'login']);

// Sanctum 
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('listing/get/{id}', [ListingController::class, 'index']);
});



