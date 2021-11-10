<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\OrderController;
Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders/store', [OrderController::class, 'store']);
Route::get('/orders/find/{id}', [OrderController::class, 'getOrder']);
Route::put('/orders/update/{id}', [OrderController::class, 'update']);
Route::delete('/orders/delete/{id}', [OrderController::class, 'delete']);

use App\Http\Controllers\CategoryController;
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories/store', [CategoryController::class, 'store']);
Route::get('/categories/find/{id}', [CategoryController::class, 'getCategory']);
Route::put('/categories/update/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/delete/{id}', [CategoryController::class, 'delete']);

use App\Http\Controllers\StatuseController;
Route::get('/statuses', [StatuseController::class, 'index']);
Route::post('/statuses/store', [StatuseController::class, 'store']);
Route::get('/statuses/find/{id}', [StatuseController::class, 'getStatuse']);
Route::put('/statuses/update/{id}', [StatuseController::class, 'update']);
Route::delete('/statuses/delete/{id}', [StatuseController::class, 'delete']);

use App\Http\Controllers\TrackingController;
Route::get('/tracking/{id}', [TrackingController::class, 'get']);

use App\Http\Controllers\OrderDetailsController;
Route::put('/order_details/update/{id}', [OrderDetailsController::class, 'update']);

use App\Http\Controllers\AdminController;
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/register', [AdminController::class, 'register']);
Route::get('/admin/find/{token}', [AdminController::class, 'getUser']);