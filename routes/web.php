<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormBook;

Route::get('/', [FormBook::class, "index"]);
Route::post('/reservation', [FormBook::class, "store"])->name('reservation.store');
