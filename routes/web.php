<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CatalogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Admin Auth Routes (Guest)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    });

    Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});

// Admin Protected Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', CategoryController::class);
    Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::post('categories/update-order', [CategoryController::class, 'updateOrder'])->name('categories.update-order');

    // Catalog (Products)
    Route::resource('catalog', CatalogController::class);
    Route::post('catalog/{product}/toggle-status', [CatalogController::class, 'toggleStatus'])->name('catalog.toggle-status');
    Route::post('catalog/{product}/toggle-featured', [CatalogController::class, 'toggleFeatured'])->name('catalog.toggle-featured');
    Route::post('catalog/{product}/duplicate', [CatalogController::class, 'duplicate'])->name('catalog.duplicate');
    Route::delete('catalog/image/{image}', [CatalogController::class, 'deleteImage'])->name('catalog.delete-image');
    Route::post('catalog/image/{image}/primary', [CatalogController::class, 'setPrimaryImage'])->name('catalog.set-primary-image');
});
