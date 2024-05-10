<?php

use App\Http\Controllers\Superadmin\ChangePasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login.form');
});

Route::get('/redirect', function () {
    if (\App\Helpers\TypeHelper::check() === "vendor") {
        return redirect()->route('vendor.home');
    } else {
        return redirect()->route('superadmin.home');
    }
})->name('redirect');

Auth::routes(['register' => false]);

Route::get("login-user", [\App\Http\Controllers\Auth\LoginController::class, 'loginForm'])->name('login.form');
Route::post("login-user", [\App\Http\Controllers\Auth\LoginController::class, 'userLogin'])->name('user.login');

Route::group(['middleware' => 'auth'], function() {
    Route::group(['prefix' => 'superadmin', 'as' => 'superadmin.'], function() {
        Route::get('/home', [App\Http\Controllers\Superadmin\HomeController::class, 'home'])->name('home');
        Route::resource('vendors', \App\Http\Controllers\Superadmin\VendorController::class);
        Route::resource('categories', \App\Http\Controllers\Superadmin\CategoryController::class);
        Route::resource('profile', \App\Http\Controllers\Superadmin\ProfileController::class)->only('index');

        Route::get('/change-password', [ChangePasswordController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password/save', [ChangePasswordController::class, 'changePasswordSave'])->name('password-store');
    });
    Route::group(['prefix' => 'vendor', 'as' => 'vendor.'], function() {
        Route::get('/home', [App\Http\Controllers\Vendor\HomeController::class, 'home'])->name('home');
        Route::resource('venues', App\Http\Controllers\Vendor\VenueController::class);
        Route::resource('orders', App\Http\Controllers\Vendor\OrderController::class)->only('index', 'show');
        Route::resource('customers', App\Http\Controllers\Vendor\CustomerController::class)->only('index', 'show', 'destroy');
        Route::get('/change-password', [\App\Http\Controllers\Vendor\ChangePasswordController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password/save', [\App\Http\Controllers\Vendor\ChangePasswordController::class, 'changePasswordSave'])->name('password-store');

        Route::resource('profile', App\Http\Controllers\Vendor\ProfileController::class)->only('index', 'edit', 'update');
    });
});
