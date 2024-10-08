<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware(['cors'])->group(function () {
    Route::post('user/register', [UserController::class, 'create']);
 
    Route::post('login', [AuthController::class, 'login']);

    Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('api.auth');

    Route::get('users/{id}', 
    [UserController::class, 'view'])->middleware('api.auth');

    Route::post('user/update', 
    [UserController::class, 'update'])->middleware('api.auth');

    Route::post('article/create', 
    [ArticleController::class, 'create'])->middleware('api.auth');

    Route::get('articles/{id}', 
    [ArticleController::class, 'view'])->middleware('api.auth');

    Route::delete('articles/{id}/{user_id}', 
    [ArticleController::class, 'delete'])->middleware('api.auth');

    Route::get('articles', 
    [ArticleController::class, 'list']);
});