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

Route::apiResource('category', CategoriesController::class)->middleware('auth:sanctum');

Route::post('todo/{todo}/done', [TodosController::class, 'markAsDone'])->middleware(['auth:sanctum', 'can:update,todo']);
Route::post('todo/{todo}/share', [TodosController::class, 'share'])->middleware(['auth:sanctum', 'can:update,todo']);
Route::apiResource('todo', TodosController::class)->middleware('auth:sanctum');
