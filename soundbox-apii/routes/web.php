<?php

use App\Http\Controllers\SongController;
use App\Http\Resources\SongResourceEedit;
use App\Http\Controllers\AuthenController;
use App\Models\Category;
use App\Models\Singer;
use App\Models\Song;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/info', function () {
    return phpinfo();
});
// Route::get('/login', function () {
//     return view('auth.login')->name('login');
Route::get('auth/logout', [AuthenController::class, 'logout2'])->name('logout.auth')->middleware('auth:sanctum');
// });
Route::get('login', [AuthenController::class, 'create'])->name('login');


Route::get('songs/create', function () {
    $categories = Category::all();
    $singers = Singer::all();
    return view('songs.create', compact('categories', 'singers'));
})->middleware(['CheckRole'])->name('songs.add');
Route::get('songs/{slug}/edit', function ($slug) {
    $song = new SongResourceEedit(Song::where('slug', $slug)->firstOrFail());
    $categories = Category::all();
    $singers = Singer::all();
    return view('songs.edit', compact('song', 'categories', 'singers'));
})->middleware(['CheckRole'])->name('songs.edit');

// Route::resource('song', SongController::class);

Route::get('users/create', function () {
    return view('users.create');
});
Route::get('users/{id}/edit', function ($id) {
    $user = User::find($id);
    return view('users.edit', compact('user'));
});
Route::get('/download/{fileName}', [SongController::class, 'streamSong']);
Route::get('/find/{key}', function ($key) {
    $song = Song::get()->where('name', '=', $key);
    return $song;
});
Route::get(('getname'), function () {
    $song = Song::find(1);
    return $song->get(['name']);
})->name('getname');
Route::get('getSong/{id}', function ($id) {
    $song = Song::find($id);
    return $song;
});
Route::get('songs', [SongController::class, 'getAll']);
