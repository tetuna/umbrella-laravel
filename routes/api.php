<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/hello', function () {
    return "Hellooooou!!!";
});

Route::get('products', [ProductController::class, 'index']);
Route::post('products/search', [ProductController::class, 'search']);
Route::post('products', [ProductController::class, 'store']);
Route::post('products/destroySeveral', [ProductController::class, 'destroySeveral']);

Route::get('categories', [CategoryController::class, 'index']);
Route::post('categories/search', [CategoryController::class, 'search']);
Route::post('categories', [CategoryController::class, 'store']);

Route::group(['prefix' => 'admin'], function () {
    Route::get('hello', function () {
        return "Hellooooou Admin!!!";
    });
});
