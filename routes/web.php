<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Amenities\Index as AmenitiesIndex;


// ============================================
// ROUTES PUBLIQUES
// ============================================

Route::view('/', 'welcome');

// ============================================
// ROUTES AUTHENTIFIÉES (Breeze)
// ============================================

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard par défaut (Breeze)
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Profile
    Route::view('/profile', 'profile')->name('profile');

});

// Routes d'authentification (Breeze)
require __DIR__.'/auth.php';

// ============================================
// ROUTES ADMIN
// ============================================

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

       // Dans le groupe admin
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');

        // Spaces
        Route::get('/spaces', function () {
            return view('admin.spaces.index');
        })->name('spaces.index');

        // Bookings
        Route::get('/bookings', function () {
            return view('admin.bookings.index');
        })->name('bookings.index');

        // Amenities
        Route::get('/amenities', AmenitiesIndex::class)->name('amenities.index');
                // Users
        Route::get('/users', function () {
            return view('admin.users.index');
        })->name('users.index');

    });
