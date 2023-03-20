<?php

use App\Http\Controllers\Api\ProductController;
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

Route::get('products', [ProductController::class, 'index']);
Route::get('product/{id}', [ProductController::class, 'show'])->whereNumber('id');
Route::post('product/create', [ProductController::class, 'create']);
Route::patch('product/edit', [ProductController::class, 'edit']);
Route::delete('product/delete', [ProductController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
