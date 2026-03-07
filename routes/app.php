<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('menu');
});

// Menu and cart Routes
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/cart', [MenuController::class, 'cart'])->name('cart');
Route::post('cart/add', [MenuController::class, 'addToCart'])->name('cart.add');
Route::post('cart/update', [MenuController::class, 'updateCart'])->name('cart.update');
Route::post('cart/remove', [MenuController::class, 'removeFromCart'])->name('cart.remove');
Route::get('cart/clear', [MenuController::class, 'clearCart'])->name('cart.clear');

// checkout and orders routes would go here
Route::get('/checkout', [MenuController::class, 'checkout'])->name('checkout');
Route::post('/checkout/store', [MenuController::class, 'storeOrder'])->name('checkout.store');
Route::get('/checkout/success/{orderId}', [MenuController::class, 'checkoutSuccess'])->name('checkout.success');

// Admin Routes
// Route::get('/dashboard', DashboardController::class)->name('admin.dashboard');
// Route::get('/dashboard', function () {
//     return view('admin.dashboard');
// })->name('dashboard');
Route::middleware('role:Administrator')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::middleware('role:Administrator|cashier|chef')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/items/{id}/update-status', [ItemController::class, 'updateStatus'])->name('items.updateStatus');
    Route::resource('orders', OrderController::class);
    Route::resource('items', ItemController::class);
    Route::post('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});