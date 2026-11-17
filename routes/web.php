<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\PaymentController;

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\HomeController;


/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
;

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/{product:slug}', [
    ProductController::class,
    'show'
]);

Route::get(
    '/products/{product}/availability',
    [ProductController::class, 'availability']
);


/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/cart', [
        CartController::class,
        'index'
    ]);

    Route::post('/cart/{product}', [
        CartController::class,
        'store'
    ]);

    Route::delete('/cart/{cartItem}', [
        CartController::class,
        'destroy'
    ]);

});

/*
|--------------------------------------------------------------------------
| Checkout
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/checkout', [
        CheckoutController::class,
        'index'
    ]);

    Route::post('/checkout', [
        CheckoutController::class,
        'store'
    ]);

});

/*
|--------------------------------------------------------------------------
| Orders
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/orders', [
        OrderController::class,
        'index'
    ]);

    Route::get('/orders/{order}', [
        OrderController::class,
        'show'
    ]);

});

/*
|--------------------------------------------------------------------------
| Payment
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/payment/{order}', [
        PaymentController::class,
        'pay'
    ]);

});

/*
|--------------------------------------------------------------------------
| Midtrans Callback
|--------------------------------------------------------------------------
*/

Route::post('/midtrans/callback', [
    MidtransCallbackController::class,
    'receive'
]);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::resource(
            'products',
            AdminProductController::class
        );

        Route::resource(
            'orders',
            AdminOrderController::class
        )->only([
                    'index',
                    'show',
                    'update'
                ]);

        Route::post(
            'orders/{order}/return',
            [AdminOrderController::class, 'returnProcess']
        );
        Route::get(
            '/dashboard',
            [DashboardController::class, 'index']
        )->name('admin.dashboard');

        Route::get(
            'users',
            [UserController::class, 'index']
        )->name('users.index');

        Route::patch(
            'users/{user}',
            [UserController::class, 'update']
        )->name('users.update');

        Route::delete(
            'users/{user}',
            [UserController::class, 'destroy']
        )->name('users.destroy');

        Route::patch(
            'products/{product}/restore',
            [AdminProductController::class, 'restore']
        )->name('products.restore');

        Route::get(
            'reports',
            [ReportController::class, 'index']
        )->name('reports.index');

        Route::post(
            'reports/download',
            [ReportController::class, 'download']
        )->name('reports.download');
        Route::patch(
            '/admin/orders/{order}/deposit',
            [AdminOrderController::class, 'returnDeposit']
        )->name('admin.orders.deposit');


    });

















require __DIR__ . '/auth.php';