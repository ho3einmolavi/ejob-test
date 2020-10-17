<?php

use App\Http\Controllers\UserController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('/users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/register', [UserController::class, 'register']);
    Route::get('/me', [UserController::class, 'me'])->middleware('auth:api');
    Route::post('/login', [UserController::class, 'login']);
});

Route::prefix('/todos')->group(function () {
    Route::get('/', [\App\Http\Controllers\TodoController::class, 'index']);
    Route::get('/search', [\App\Http\Controllers\TodoController::class, 'search']);
    Route::middleware('auth:api')->group(function () {
        Route::post('/', [\App\Http\Controllers\TodoController::class, 'create']);
        Route::delete('/{todo}', [\App\Http\Controllers\TodoController::class, 'delete']);
        Route::post('/{todo}', [\App\Http\Controllers\TodoController::class, 'update']);
    });

});
