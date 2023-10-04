<?php

use App\Http\Controllers\Api\V1\Front\AddressController;
use App\Http\Controllers\Api\V1\Front\AuthController;
use App\Http\Controllers\Api\V1\Front\CartItemController;
use App\Http\Controllers\Api\V1\Front\OrderController;
use App\Http\Controllers\Api\V1\Front\ProductController;
use App\Http\Controllers\Api\V1\Front\WishListItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\UserController;

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

Route::post('signup', [AuthController::class, 'signUp']);
Route::post('login', [AuthController::class, 'login']);

Route::post('forget-password', [AuthController::class, 'forgetPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('change-password', [AuthController::class, 'changePassword']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [UserController::class, 'me']);
    Route::put('profile-update', [UserController::class, 'update']);
    Route::resource('products', ProductController::class)->only(['index', 'show']);
    Route::resource('cart-items', CartItemController::class);
    Route::resource('wish-list-items', WishListItemController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('addresses', AddressController::class);
});
