<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Lấy ra trang chủ
// Route::get('/',[PostController::class,'index']);
// Route::resource('posts', App\Http\Controllers\PostController::class);
// Route::get('/create', function () {
//     return view('post.create');
// });
// Route::post('/post', [PostController::class, 'store']);
// Route::get('/edit/{id}',[PostController::class,'edit']);
// Route::put('/update/{id}',[PostController::class,'update']);

// Route::delete('/delete/{id}',[PostController::class,'destroy']);
Route::resource('/blog', PostController::class);
// Route::delete('blog/deleteimage/{id}', [PostController::class, 'deleteImage']);

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
