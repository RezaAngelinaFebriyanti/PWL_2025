<?php

use Illuminate\Support\Facades\Route; //Mengimpor class Route
use App\Http\Controllers\ItemController; //Tambahan: Mengimpor class ItemController
use App\Http\Controllers\WelcomeController; //Mengimpor class WelcomeController
use App\Http\Controllers\PageController; //Mengimpor class PageController
use App\Http\Controllers\HomeController; ///Mengimpor class HomeController
use App\Http\Controllers\AboutController; //Mengimpor class AboutController
use App\Http\Controllers\ArticleController; //Mengimpor class ArticleController

//BASIC ROUTING
/*
// 1.
Route::get('/hello', function() {
    return 'Hello World';
});

// 2.
Route::get('/world', function () {
    return 'World';
});

// 3.
Route::get('/SelamatDatang', function () {
    return 'Selamat Datang';
});

// 4.
Route::get('/about', function () {
    return 'NIM: 2341760015 <br> Nama: Reza Angelina Febriyanti';
});
*/

// ROUTER PARAMETERS
/*
Route::get('/user/{name}', function ($name) {
    return 'Nama saya '.$name;
});

Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
});

Route::get('/article/{id}', function ($postId) {
    return 'Halaman Artikel dengan ID '.$postId;
});
*/

// OPTIONAL PARAMETERS
/*
Route::get('/user/{name?}', function ($name=null) {
    return 'Nama saya '.$name;
});

Route::get('/user/{name?}', function ($name='John') {
    return 'Nama saya '.$name;
});
*/

// ROUTE NAME
/*
Route::get('/user/profile', function () {
    //
})->name('profile');

Route::get('/user/profile',[UserProfileController::class, 'show'])->name('profile');

// Generating URLs...
$url = route('profile');

// Generating Redirects...
return redirect()->route('profile');
*/

// ROUTE GROUP dan ROUTE PREFIXES
/*
Route::middleware(['first', 'second'])->group(function () {
    Route::get('/', function () {
    // Uses first & second middleware...
    });

    Route::get('/user/profile', function () {
    // Uses first & second middleware...
    });
});

Route::domain('{account}.example.com')->group(function () {
    Route::get('user/{id}', function ($account, $id) {
    //
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/post', [PostController::class, 'index']);
    Route::get('/event', [EventController::class, 'index']);
});
*/

// ROUTE PREFIXES
/*
Route::prefix('admin')->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/post', [PostController::class, 'index']);
    Route::get('/event', [EventController::class, 'index']);
});
*/

// REDIRECT ROUTES
//Route::redirect('/here', '/there');

// VIEW ROUTES
/*
Route::view('/welcome', 'welcome');
Route::view('/welcome', 'welcome', ['name' => 'Taylor']);
*/

// CONTROLLER
Route::get('/hello', [WelcomeController::class,'hello']);
Route::get('/index', [PageController::class,'index']);
Route::get('/about', [PageController::class,'about']);
Route::get('/article/{id}', [PageController::class,'article']);

Route::get('/index', [HomeController::class,'home']);
Route::get('/about', [AboutController::class,'about']);
Route::get('/article/{id}', [ArticleController::class,'article']);