<?php


use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\SingleProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/shop', [ShopController::class, 'show'])->name('shopShow');

Route::get('/shop/product/{id}', [SingleProductController::class, 'show'])->name('singleProductShow');

Route::post('/shop/product/{id}', [SingleProductController::class, 'postComment'])->name('postComment');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkoutShow');

Route::get('/category', [CategoryController::class, 'showCategory'])->name('categoryShow');

Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/cart', [App\Http\Controllers\Frontend\CartController::class, 'show'])->name('cart.show');
    Route::post('/cart/add', [App\Http\Controllers\Frontend\CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [App\Http\Controllers\Frontend\CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/update/{id}', [App\Http\Controllers\Frontend\CartController::class, 'update'])->name('cart.update');
});





// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
