<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CatalogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/catalog', [HomeController::class, 'catalog'])->name('catalog');
Route::get('/catalog/{product:slug}', [HomeController::class, 'productShow'])->name('catalog.show');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');
Route::post('/kontak', [HomeController::class, 'contactSubmit'])->name('contact.submit');

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

    // Contacts
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::post('contacts/{contact}/toggle-read', [ContactController::class, 'toggleRead'])->name('contacts.toggle-read');
    Route::post('contacts/mark-all-read', [ContactController::class, 'markAllRead'])->name('contacts.mark-all-read');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('contacts/bulk-delete', [ContactController::class, 'bulkDelete'])->name('contacts.bulk-delete');
});
