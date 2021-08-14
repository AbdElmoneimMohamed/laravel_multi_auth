<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAPIController;
use App\Http\Controllers\CustomerAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user/register',  [UserAPIController::class, 'register'])->name('userRegister');
Route::post('user/login',  [UserAPIController::class, 'login'])->name('userLogin');
Route::post('user/logout',  [UserAPIController::class, 'logout'])->name('userLogout');

Route::post('customer/register',  [CustomerAPIController::class, 'register'])->name('customerRegister');
Route::post('customer/login',  [CustomerAPIController::class, 'login'])->name('customerLogin');
Route::post('customer/logout',  [CustomerAPIController::class, 'logout'])->name('customerLogout');
