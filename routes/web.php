<?php


use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\SingleProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;

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
