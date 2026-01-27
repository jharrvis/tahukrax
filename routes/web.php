<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('home');

// Checkout routes - with and without package slug
Route::get('/checkout/{package:slug}', \App\Livewire\Checkout::class)
    ->name('checkout');
Route::get('/checkout', \App\Livewire\Checkout::class)
    ->name('checkout.cart');

Route::get('/order/success/{order}', function (\App\Models\Order $order) {
    return view('order-success', compact('order'));
})->middleware(['auth'])->name('order.success');

Route::post('/webhooks/xendit', [\App\Http\Controllers\XenditController::class, 'handleWebhook'])->name('xendit.webhook');

Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
    Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');
});

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');