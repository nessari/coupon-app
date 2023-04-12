<?php

use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\User;
use App\Http\Controllers\WishlistController;
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

/**
 * HOME
 * @description Home page, pointing to the coupons-index route.
 */
Route::get('/', [CouponController::class, 'index'])->name('home');

/**
 *  COUPONS
 *  @description Listing the coupons, same as the home page.
 */
Route::get('coupons', [CouponController::class, 'index'] )->name('coupons-index');
Route::get('coupons/{coupon:slug}', [CouponController::class, 'show'] )->name('coupons-show');

/**
 *  MAP
 */
Route::get('map', [MapController::class, 'index'] )->name('map-index');

/**
 *  CART
 */
Route::get('cart', [CartController::class, 'index'])->name('cart-index');
Route::post('cart', [CartController::class, 'store'])->name('cart-store');
Route::patch('cart/{coupon}', [CartController::class, 'update'])->name('cart-update');
Route::delete('cart/{coupon}', [CartController::class, 'destroy'])->name('cart-delete');
Route::delete('cart', [CartController::class, 'destroyAll'])->name('cart-delete-all');

 /**
 *  CHECKOUT
 */
Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout-index');
Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout-store');

/**
 *  AUTH GUESTS
 */
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
    Route::get('login', [SessionController::class, 'create'])->name('login');
    Route::post('login', [SessionController::class, 'store']);
});

/**
 *  AUTH USERS
 */
Route::middleware('auth')->group(function () {
    Route::post('logout', [SessionController::class, 'destroy'])->name('logout');
    // ORDERS
    Route::get('orders', [OrderController::class, 'index'])->name('orders-index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders-show');
    // WHISLIST
    Route::get('saved', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('saved/{coupon}', [WishlistController::class, 'create'])->name('saved-create');
    Route::delete('saved/{coupon}', [WishlistController::class, 'destroy'])->name('saved-delete');
    // REVIEWS
    Route::post('coupons/review', [ReviewController::class, 'store'])->name('review-store-new');
    Route::put('coupons/review/{review}', [ReviewController::class, 'update'])->name('review-store-edited');
    Route::delete('coupons/review/{review}', [ReviewController::class, 'destroy'])->name('review-delete');
});
