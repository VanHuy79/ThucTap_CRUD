<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostAPIController;
use App\Http\Controllers\AuthAPIController;
use App\Http\Controllers\FileAPIController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('post', PostAPIController::class);
Route::resource('file', FileAPIController::class);
// Route::post('login', 'api\UserController@login');
// Route::post('login', [AuthAPIController::class, 'login']);
