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
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminShopController;
use App\Http\Controllers\Admin\AdminFreelancerController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminAnnouncementController;
use App\Http\Controllers\Admin\AdminActivityController;
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

    // --- ADMIN PANEL --- 
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // User Management
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('users.suspend');
        Route::patch('/users/{user}/reactivate', [AdminUserController::class, 'reactivate'])->name('users.reactivate');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/bulk-action', [AdminUserController::class, 'bulkAction'])->name('users.bulk');
        
        // Shop Management
        Route::get('/shops', [AdminShopController::class, 'index'])->name('shops.index');
        Route::get('/shops/{shop}', [AdminShopController::class, 'show'])->name('shops.show');
        Route::patch('/shops/{shop}/approve', [AdminShopController::class, 'approve'])->name('shops.approve');
        Route::patch('/shops/{shop}/reject', [AdminShopController::class, 'reject'])->name('shops.reject');
        Route::patch('/shops/{shop}/suspend', [AdminShopController::class, 'suspend'])->name('shops.suspend');
        Route::patch('/shops/{shop}/reactivate', [AdminShopController::class, 'reactivate'])->name('shops.reactivate');
        Route::post('/shops/bulk-action', [AdminShopController::class, 'bulkAction'])->name('shops.bulk');
        
        // Freelancer Management
        Route::get('/freelancers', [AdminFreelancerController::class, 'index'])->name('freelancers.index');
        Route::get('/freelancers/{freelancer}', [AdminFreelancerController::class, 'show'])->name('freelancers.show');
        Route::patch('/freelancers/{freelancer}/approve', [AdminFreelancerController::class, 'approve'])->name('freelancers.approve');
        Route::patch('/freelancers/{freelancer}/reject', [AdminFreelancerController::class, 'reject'])->name('freelancers.reject');
        Route::patch('/freelancers/{freelancer}/suspend', [AdminFreelancerController::class, 'suspend'])->name('freelancers.suspend');
        Route::patch('/freelancers/{freelancer}/reactivate', [AdminFreelancerController::class, 'reactivate'])->name('freelancers.reactivate');
        Route::post('/freelancers/bulk-action', [AdminFreelancerController::class, 'bulkAction'])->name('freelancers.bulk');
        
        // Booking Management
        Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
        Route::patch('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
        Route::get('/bookings/export', [AdminBookingController::class, 'export'])->name('bookings.export');
        
        // Category Management
        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::post('/categories/reorder', [AdminCategoryController::class, 'reorder'])->name('categories.reorder');
        
        // Review Management
        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::patch('/reviews/{review}/flag', [AdminReviewController::class, 'flag'])->name('reviews.flag');
        Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::post('/reviews/bulk-action', [AdminReviewController::class, 'bulkAction'])->name('reviews.bulk');
        
        // Settings
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::patch('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
        
        // Announcements
        Route::resource('announcements', AdminAnnouncementController::class);
        
        // Activity Log
        Route::get('/activity', [AdminActivityController::class, 'index'])->name('activity.index');
    });
});

require __DIR__.'/auth.php';
