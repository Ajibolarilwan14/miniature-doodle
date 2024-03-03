<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;

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
Route::prefix('auth')->group(function() {
    Route::post('/login', AuthController::class);
});

Route::prefix('product')->middleware(['auth:sanctum'])->group(function() {
    // Product Category
    Route::post('/category/create', [ProductCategoryController::class, 'create']);
    Route::get('/category/{category}', [ProductCategoryController::class, 'show'])->whereNumber('category');
    Route::patch('/category/{category}', [ProductCategoryController::class, 'update']);
    Route::delete('/category/{category}', [ProductCategoryController::class, 'destroy']);
    Route::get('/category', [ProductCategoryController::class, 'index']);

    // Product
    Route::post('/create', [ProductController::class, 'create']);
    Route::get('/{product}', [ProductController::class, 'show']);
    Route::patch('/{product}', [ProductController::class, 'update']);
    Route::delete('/{product}', [ProductController::class, 'destroy']);
    Route::get('/', [ProductController::class, 'index']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});