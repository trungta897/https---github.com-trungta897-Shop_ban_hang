<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\SingleProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.index');
});

Route::get('/shop', [ShopController::class, 'show'])->name('shopShow');

Route::get('/shop/product/{id}', [SingleProductController::class, 'show'])->name('singleProductShow');

Route::post('/shop/product/{id}',[SingleProductController::class, 'postComment'] )->name('postComment');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
