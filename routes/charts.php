<?php

use App\Http\Controllers\ChartController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('charts', ChartController::class);

    Route::get('charts/category/{id}', [ChartController::class, 'displayRecordsInCategory'])->name('charts.category-records');
});
