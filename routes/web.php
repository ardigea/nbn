<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormBook;
use App\Http\Controllers\HomeController;

// Home and Main Navigation Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::get('/orders', [HomeController::class, 'orders'])->name('orders');
Route::get('/profile', [HomeController::class, 'profile'])->name('profile');

// Reservation Routes
Route::get('/reservation', [FormBook::class, "index"])->name('reservation');
Route::post('/reservation', [FormBook::class, "store"])->name('reservation.store');

// Additional Routes (can be implemented later)
Route::get('/restaurant/{id}', function($id) {
    return redirect('/reservation');
})->name('restaurant.show');

Route::get('/orders/{id}', function($id) {
    return redirect('/orders');
})->name('orders.show');

Route::post('/orders/{id}/cancel', function($id) {
    return redirect('/orders');
})->name('orders.cancel');

Route::get('/profile/edit', function() {
    return redirect('/profile');
})->name('profile.edit');

Route::get('/help', function() {
    return redirect('/profile');
})->name('help');

Route::get('/contact', function() {
    return redirect('/profile');
})->name('contact');
