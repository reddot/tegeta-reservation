<?php

use Illuminate\Support\Facades\Route;
use Reddot\TegetaReservation\Http\Controllers\ReservationApiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('reservation.')->prefix('reservation')->group(function () {
    Route::name('api.')->prefix('api')->group(function () {
        Route::get('/branches', [ReservationApiController::class, 'branches'])->name('branches');
        Route::get('/services', [ReservationApiController::class, 'services'])->name('services');
        Route::get('/dates', [ReservationApiController::class, 'dates'])->name('dates');
        Route::get('/dates-n-month', [ReservationApiController::class, 'datesNMonth'])->name('dates-n-month');
        Route::get('/times', [ReservationApiController::class, 'times'])->name('times');
        Route::post('/reserve', [ReservationApiController::class, 'reserve'])->name('reserve');
    });
});
