<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\PublicHelper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileAPIController;
use App\Http\Controllers\PostAPIController;
use App\Http\Controllers\Repository\FileController;
use App\Http\Controllers\Repository\PostController;
use App\Http\Controllers\Repository\LoginController;

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



// Route::resource('post', PostAPIController::class);
// Route::resource('file', FileAPIController::class);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
});
// Auth

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [LoginController::class, 'register']);
Route::post('logout', [LoginController::class, 'logout']);


Route::group(['middleware' => 'jwt'], function () {
    Route::resource('postBlog', PostController::class);
    Route::resource('postFile', FileController::class);
});

Route::get('/test', function (Request $request) {
    return response()->json(['message' => 'Hello, JWT!']);
})->middleware('jwt');
// Route::resource('blog', RepositoryPostAPIController::class);
// Route::post('login', 'api\UserController@login');
// Route::post('login', [AuthAPIController::class, 'login']);
