<?php


use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\SingleProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\RegisterController;
use App\Http\Controllers\Frontend\DashboardController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/shop', [ShopController::class, 'show'])->name('shopShow');

Route::get('/shop/product/{id}', [SingleProductController::class, 'show'])->name('singleProductShow');

Route::post('/shop/product/{id}', [SingleProductController::class, 'postComment'])->name('postComment');

Route::get('/category', [CategoryController::class, 'showCategory'])->name('categoryShow');

Route::get('/shop/product/{id}', [CartController::class, 'relatedShow'])->name('product.show');


Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/seller/dashboard', [DashboardController::class, 'index'])->name('seller.dashboard');
    Route::get('/seller/products/create', [DashboardController::class, 'create'])->name('seller.create');
    Route::post('/seller/products', [DashboardController::class, 'store'])->name('seller.store');
    Route::get('/seller/products/{product}/edit', [DashboardController::class, 'edit'])->name('seller.edit');
    Route::put('/seller/products/{product}', [DashboardController::class, 'update'])->name('seller.update');
    Route::delete('/seller/products/{product}', [DashboardController::class, 'destroy'])->name('seller.destroy');
    Route::put('/seller/orders/{order}', [DashboardController::class, 'updateOrder'])->name('seller.update.order');
    Route::get('/seller/orders/{order}', [DashboardController::class, 'showOrder'])->name('seller.show.order');
});


