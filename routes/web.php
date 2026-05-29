<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;

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
| FIREBASE VERIFICATION PAGE
|--------------------------------------------------------------------------
*/

Route::view(
    '/firebase-verified',
    'auth.firebase-verified'
);

/*
|--------------------------------------------------------------------------
| FIREBASE REGISTER
|--------------------------------------------------------------------------
*/

Route::post(
    '/firebase-register',
    [RegisteredUserController::class, 'firebaseRegister']
);

/*
|--------------------------------------------------------------------------
| SAVE FIREBASE USER TO DATABASE
|--------------------------------------------------------------------------
*/

Route::post('/save-user', function (Request $request) {

    $existingUser = User::where(
        'email',
        $request->email
    )->first();

    if (!$existingUser) {

        User::create([

            'name' => $request->name,

            'email' => $request->email,

            'contact_number' =>
                $request->contact_number,

            'address' =>
                $request->address,

            'facebook_link' =>
                $request->facebook_link,

            'firebase_uid' =>
                $request->firebase_uid,

            'role' =>
                $request->role,

            // Optional only for Laravel compatibility
            'password' =>
                bcrypt($request->password)

        ]);

    }

    return response()->json([

        'success' => true

    ]);

});

/*
|--------------------------------------------------------------------------
| FIREBASE LOGIN
|--------------------------------------------------------------------------
*/

Route::post('/firebase-login', function (Request $request) {

    $user = User::where(
        'email',
        $request->email
    )->first();

    if (!$user) {

        return response()->json([

            'success' => false,

            'message' => 'User not found.'

        ]);

    }

    // LOGIN TO LARAVEL SESSION
    Auth::login($user);

    $request->session()->regenerate();

    return response()->json([

        'success' => true

    ]);

});

/*
|--------------------------------------------------------------------------
| TEST EMAIL
|--------------------------------------------------------------------------
*/

Route::get('/test-email', function () {

    Mail::raw(

        'Test Email From ThriftHub',

        function ($message) {

            $message->to(
                'badugasjohn@gmail.com'
            )->subject('Test Email');

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

Route::middleware(['auth'])

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