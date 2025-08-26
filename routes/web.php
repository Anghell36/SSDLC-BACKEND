<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);


use App\Http\Controllers\UserController;

Route::post('/register', [UserController::class, 'register']);
Route::get('/users', [UserController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});
