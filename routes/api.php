<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\TodosController;
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

Route::post('register', RegisterController::class)->middleware('guest');
Route::post('login', LoginController::class)->middleware('guest');

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::apiResource('category', CategoriesController::class);
    Route::post('category/{category}/restore', [CategoriesController::class, 'restore']);

    Route::group(['prefix' => 'todo'], function() {
        Route::post('{todo}/markAs', [TodosController::class, 'markAs']);
        Route::post('{todo}/share', [TodosController::class, 'share']);
        Route::post('{post}/restore', [TodosController::class, 'restore']);
    });
    Route::apiResource('todo', TodosController::class);
});
