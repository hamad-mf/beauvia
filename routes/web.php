<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\ShopOwnerController;
use App\Http\Controllers\Dashboard\FreelancerDashController;
use Illuminate\Support\Facades\Route;

// --- PUBLIC ROUTES ---
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
Route::get('/shops/{slug}', [ShopController::class, 'show'])->name('shops.show');

Route::get('/freelancers', [FreelancerController::class, 'index'])->name('freelancers.index');
Route::get('/freelancers/{id}', [FreelancerController::class, 'show'])->name('freelancers.show');

// --- AUTH REQUIRED ROUTES ---
Route::middleware('auth')->group(function () {
    // Booking
    Route::get('/book/shop/{slug}', [BookingController::class, 'createShop'])->name('bookings.create.shop');
    Route::get('/book/freelancer/{id}', [BookingController::class, 'createFreelancer'])->name('bookings.create.freelancer');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/confirmation', [BookingController::class, 'confirmation'])->name('bookings.confirmation');
    Route::post('/api/available-slots', [BookingController::class, 'getAvailableSlots'])->name('api.available-slots');

    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Favorites
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // --- CUSTOMER DASHBOARD ---
    Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
        Route::get('/bookings', [CustomerController::class, 'bookings'])->name('bookings');
        Route::patch('/bookings/{booking}/cancel', [CustomerController::class, 'cancelBooking'])->name('bookings.cancel');
    });

    // --- SHOP OWNER DASHBOARD ---
    Route::middleware('role:shop_owner')->prefix('shop')->name('shop.')->group(function () {
        Route::get('/dashboard', [ShopOwnerController::class, 'index'])->name('dashboard');
        Route::get('/setup', [ShopOwnerController::class, 'setup'])->name('setup');
        Route::post('/setup', [ShopOwnerController::class, 'storeSetup']);
        Route::get('/bookings', [ShopOwnerController::class, 'bookings'])->name('bookings');
        Route::patch('/bookings/{booking}/status', [ShopOwnerController::class, 'updateBookingStatus'])->name('bookings.status');
        Route::get('/services', [ShopOwnerController::class, 'services'])->name('services');
        Route::post('/services', [ShopOwnerController::class, 'storeService'])->name('services.store');
        Route::delete('/services/{service}', [ShopOwnerController::class, 'deleteService'])->name('services.destroy');
    });

    // --- FREELANCER DASHBOARD ---
    Route::middleware('role:freelancer')->prefix('freelancer')->name('freelancer.')->group(function () {
        Route::get('/dashboard', [FreelancerDashController::class, 'index'])->name('dashboard');
        Route::get('/setup', [FreelancerDashController::class, 'setup'])->name('setup');
        Route::post('/setup', [FreelancerDashController::class, 'storeSetup']);
        Route::get('/bookings', [FreelancerDashController::class, 'bookings'])->name('bookings');
        Route::patch('/bookings/{booking}/status', [FreelancerDashController::class, 'updateBookingStatus'])->name('bookings.status');
        Route::get('/services', [FreelancerDashController::class, 'services'])->name('services');
        Route::post('/services', [FreelancerDashController::class, 'storeService'])->name('services.store');
        Route::delete('/services/{service}', [FreelancerDashController::class, 'deleteService'])->name('services.destroy');
    });

    // Profile routes (from Breeze)
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
