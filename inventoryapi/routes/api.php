<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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



Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


//public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::resource('getUser', AuthController::class);
Route::post('/addProduct/{id}',[ ProductController::class, 'addProduct']);
Route::post('/updateImage/{id}',[ ProductController::class, 'updateImage']);
Route::get('/products/search/categories_id/{int}',[ ProductController::class, 'searchCategory']);
Route::get('/category/search/product/{int}',[ CategoryController::class, 'searchProduct']);

//Väg till produkter
Route::resource('products', ProductController::class);


//Väg till kategori
Route::resource('category', CategoryController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
