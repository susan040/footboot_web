<?php

use App\Http\Controllers\Api\AuthApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/forget-password', [AuthApiController::class, 'forgetPassword']);
Route::post('/resetPassword', [AuthApiController::class, 'resetPassword']);
Route::group(['prefix' => '', 'middleware' => 'auth:api'], function () {
    Route::get('/category', [App\Http\Controllers\Api\CategoryApiController::class, "allCategory"]);
    Route::get('/vendors', [App\Http\Controllers\Api\VendorApiController::class, "allVendors"]);
    Route::get('/vendor/{id}', [App\Http\Controllers\Api\VendorApiController::class, "vendorDetails"]);
    Route::get('/venues', [App\Http\Controllers\Api\BookingApiController::class, "allVenues"]);
    Route::post('/booking', [App\Http\Controllers\Api\BookingApiController::class, "addBooking"]);
    Route::post('/verify-payment', [App\Http\Controllers\Api\BookingApiController::class, "verifyPayment"]);
    Route::get('/booking-list', [App\Http\Controllers\Api\BookingApiController::class, "getAllBookings"]);
    Route::post('/search-booking', [App\Http\Controllers\Api\BookingApiController::class, "searchBookings"]);
    Route::get('/booking/{id}', [App\Http\Controllers\Api\BookingApiController::class, "bookingDetails"]);
    Route::get('/bookingHistory', [App\Http\Controllers\Api\BookingApiController::class, "bookingHistory"]);
    Route::get('/viewOrder', [App\Http\Controllers\Api\BookingApiController::class, "viewOrder"]);

    Route::post('/change-password',  [App\Http\Controllers\Api\AuthApiController::class, "changePassword"]);
    Route::post('/update-profile',  [App\Http\Controllers\Api\AuthApiController::class, "updateProfile"]);
    Route::get('/profile',  [App\Http\Controllers\Api\AuthApiController::class, "profile"]);
});
