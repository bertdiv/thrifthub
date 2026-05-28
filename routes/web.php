<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\AdminDashboardController;

use App\Http\Controllers\ProductController;

use App\Http\Controllers\SellerController;

use App\Http\Controllers\Auth\RegisteredUserController;

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
| FIREBASE VERIFICATION
|--------------------------------------------------------------------------
*/

Route::view(
    '/firebase-verified',
    'auth.firebase-verified'
);

Route::post(
    '/firebase-register',
    [RegisteredUserController::class, 'firebaseRegister']
);

/*
|--------------------------------------------------------------------------
| TEST EMAIL
|--------------------------------------------------------------------------
*/

Route::get('/test-email', function () {

    Mail::raw(
        'Test Email From ThriftHub',

        function ($message) {

            $message->to('badugasjohn@gmail.com')
                    ->subject('Test Email');

        }
    );

    return 'Email Sent';

});

/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
->group(function () {

    Route::get('/dashboard', function () {

        if (auth()->user()->role === 'admin') {

            return redirect()
                ->route('admin.dashboard');
        }

        return redirect()
            ->route('seller.dashboard');

    })->name('dashboard');

});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])

    ->prefix('admin')

    ->name('admin.')

    ->group(function () {

        Route::get(
            '/dashboard',
            [AdminDashboardController::class, 'index']
        )->name('dashboard');

        Route::get(
            '/products',
            [AdminDashboardController::class, 'products']
        )->name('products.index');

        Route::post(
            '/products/{product}/approve',
            [ProductController::class, 'approve']
        )->name('products.approve');

        Route::post(
            '/products/{product}/reject',
            [ProductController::class, 'reject']
        )->name('products.reject');

        Route::get(
            '/sellers',
            [AdminDashboardController::class, 'sellers']
        )->name('sellers.index');

        Route::get(
            '/overview',
            [AdminDashboardController::class, 'overview']
        )->name('overview');

        Route::post(
            '/sellers/{user}/toggle-block',
            [AdminDashboardController::class, 'toggleBlock']
        )->name('sellers.toggleBlock');

        Route::delete(
            '/sellers/{user}',
            [AdminDashboardController::class, 'deleteSeller']
        )->name('sellers.delete');

    });

/*
|--------------------------------------------------------------------------
| PROFILE ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')

    ->group(function () {

        Route::get(
            '/profile',
            [ProfileController::class, 'edit']
        )->name('profile.edit');

        Route::patch(
            '/profile',
            [ProfileController::class, 'update']
        )->name('profile.update');

        Route::delete(
            '/profile',
            [ProfileController::class, 'destroy']
        )->name('profile.destroy');

    });

/*
|--------------------------------------------------------------------------
| SELLER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])

    ->prefix('seller')

    ->name('seller.')

    ->group(function () {

        Route::get(
            '/dashboard',
            [SellerController::class, 'dashboard']
        )->name('dashboard');

        Route::get(
            '/products/create',
            [ProductController::class, 'create']
        )->name('products.create');

        Route::post(
            '/products',
            [ProductController::class, 'store']
        )->name('products.store');

        Route::get(
            '/products/{product}/edit',
            [ProductController::class, 'edit']
        )->name('products.edit');

        Route::put(
            '/products/{product}',
            [ProductController::class, 'update']
        )->name('products.update');

        Route::delete(
            '/products/{product}',
            [ProductController::class, 'destroy']
        )->name('products.destroy');

        Route::post(
            '/products/{product}/sold',
            [ProductController::class, 'markAsSold']
        )->name('products.sold');

    });

/*
|--------------------------------------------------------------------------
| PUBLIC PRODUCTS
|--------------------------------------------------------------------------
*/

Route::get(
    '/products',
    [ProductController::class, 'index']
)->name('products.index');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';