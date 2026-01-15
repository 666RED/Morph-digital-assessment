<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::middleware('auth')->resource(
    'categories',
    CategoryController::class,
);
