<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
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

Route::get('/', function(){

    return response()->json(['api_name' => 'friedshop-back-laravel', 'version' => '1.0', 'author' => 'v1p3r75']);
});

Route::controller(ProductController::class)->prefix('product')->group(function () {

    Route::get('/', 'index');
    Route::get('/{id}','show');
    Route::post('/create', 'create');
    Route::patch('/edit', 'edit');
    Route::delete('/delete', 'destroy');
});

Route::controller(UserController::class)->prefix('user')->group(function () {

    Route::get('/', 'index');
    Route::get('/{id}','show');
    Route::post('/create', 'register');
    Route::patch('/login', 'login');
    Route::delete('/update_token', 'updateToken');
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
