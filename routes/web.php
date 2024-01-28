<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Guest
Route::middleware('guest')->group(function () {
    // Home
    Route::get('/', function () {return Inertia::render('Home');});
    // Admin login
    Route::get('/admin/login', [AdminController::class, 'getLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminController::class, 'login']);
    // Admin register
    Route::get('/admin/register', [AdminController::class, 'getRegister'])->name('admin.register');
    Route::post('/admin/register', [AdminController::class, 'register']);
});

// Admin feature
Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/listing', [ListingController::class, 'store'])->name('listing.store');
    Route::put('/admin/listing/{listing}', [ListingController::class, 'update'])->name('listing.update');
    Route::delete('/admin/listing/{listing}', [ListingController::class, 'destroy'])->name('listing.destroy');
});


Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {return Inertia::render('Dashboard');})->name('dashboard');
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
