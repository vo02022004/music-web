<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AuthenController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SingerController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/user', [AuthenController::class, 'me'])->middleware('auth:sanctum');
Route::post('auth/login', [AuthenController::class, 'login'])->name('login.auth');
Route::post('auth/loginbe', [AuthenController::class, 'loginBe'])->name('loginBe.auth');
Route::post('auth/logout', [AuthenController::class, 'logout'])->middleware('auth:sanctum');
Route::get('home', [HomeController::class, 'getHome']);

Route::resource('users', UserController::class);

Route::resource('singers', SingerController::class)->middleware(['CheckRole']);

Route::resource('categories', CategoryController::class);

Route::resource('albums', AlbumController::class);

Route::resource('songs', SongController::class);

// Route::resource('comments', CommentController::class);
Route::post('comments', [CommentController::class, 'store'])->middleware('auth:sanctum');

Route::get('songs/{slug}', [SongController::class, 'show']);

Route::get('/search/{q?}', [SongController::class, 'search']);
Route::get('/next', [SongController::class, 'getNextSong']);
