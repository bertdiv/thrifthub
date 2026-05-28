<?php

use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| OTP VERIFICATION
|--------------------------------------------------------------------------

/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/
use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {

    Mail::raw('Test Email From ThriftHub', function ($message) {

        $message->to('badugasjohn@gmail.com')
                ->subject('Test Email');

    });

    return 'Email Sent';

});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    });

});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {

        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('seller.dashboard');

    })->name('dashboard');
});

/*
/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/products', [AdminDashboardController::class, 'products'])
            ->name('products.index');

        // ✅ APPROVE PRODUCT
        Route::post('/products/{product}/approve', [ProductController::class, 'approve'])
            ->name('products.approve');

        // REJECT (WITH REASON)
        Route::post('/products/{product}/reject', [ProductController::class, 'reject'])
            ->name('products.reject');

        Route::get('/sellers', [AdminDashboardController::class, 'sellers'])
            ->name('sellers.index');

        Route::get('/overview', [AdminDashboardController::class, 'overview'])
            ->name('overview');

        // SELLER ACTIONS
        Route::post('/sellers/{user}/toggle-block', [AdminDashboardController::class, 'toggleBlock'])
            ->name('sellers.toggleBlock');

        Route::delete('/sellers/{user}', [AdminDashboardController::class, 'deleteSeller'])
            ->name('sellers.delete');
    });
/*
|--------------------------------------------------------------------------
| PROFILE ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| SELLER ROUTES (FIXED & CLEAN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('seller')
    ->name('seller.')
    ->group(function () {

        Route::get('/dashboard', [SellerController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/products/create', [ProductController::class, 'create'])
            ->name('products.create');

        Route::post('/products', [ProductController::class, 'store'])
            ->name('products.store');

        // ✅ EDIT
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
            ->name('products.edit');

        // ✅ UPDATE
        Route::put('/products/{product}', [ProductController::class, 'update'])
            ->name('products.update');

        // ✅ DELETE
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])
            ->name('products.destroy');

        // ✅ MARK AS SOLD
        Route::post('/products/{product}/sold', [ProductController::class, 'markAsSold'])
            ->name('products.sold');
    });
/*
|--------------------------------------------------------------------------
| PUBLIC PRODUCTS
|--------------------------------------------------------------------------
*/
Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';