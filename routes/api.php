<?php

use App\Http\Controllers\Api\CommandController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SlideController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UtilsController;
use App\Models\Product;
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

    return response()->json(['name' => 'friedshop-back-laravel', 'version' => '1.0', 'author' => 'v1p3r75', 'docs' => 'elfriedv16@gmail.com']);
});

Route::controller(ProductController::class)->prefix('product')->group(function () {

    Route::get('/', 'index');
    Route::get('/{id}','show')->whereNumber('id');
    Route::get('/search/{query}','search');
    Route::get('/types/{type}','types');
    Route::post('/create', 'create')->can('create', Product::class);
    Route::patch('/edit', 'edit')->can('update', Product::class);
    Route::delete('/delete', 'destroy')->can('delete', Product::class);
});

Route::controller(SlideController::class)->prefix('slide')->group(function () {

    Route::get('/', 'index');
    Route::get('/{id}','show')->whereNumber('id');
    Route::post('/create', 'create');
    Route::patch('/edit', 'edit');
    Route::delete('/delete', 'destroy');
});

Route::controller(CategoryController::class)->prefix('category')->group(function () {

    Route::get('/', 'index');
    Route::get('/{id}','show')->whereNumber('id');
    Route::post('/create', 'create');
    Route::patch('/edit', 'edit');
    Route::delete('/delete', 'destroy');
});

Route::controller(CommandController::class)->prefix('command')->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}','show')->whereNumber('id');
    Route::post('/create', 'create');
    Route::patch('/edit', 'edit');
    Route::delete('/delete', 'destroy');
});

Route::controller(UserController::class)->prefix('user')->group(function () {

    Route::get('/', 'index');
    Route::get('/{id}','show');
    Route::post('/create', 'register');
    Route::patch('edit', 'edit');
    Route::post('/login', 'login');
    Route::post('/update_token', 'updateToken');
    Route::delete('/delete', 'destroy');
});

Route::controller(UtilsController::class)->group(function() {
    Route::get('/statistics', 'index');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
