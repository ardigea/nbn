<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormBook;

Route::get('/', [FormBook::class, "index"]);
