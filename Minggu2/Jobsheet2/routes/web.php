<?php

use Illuminate\Support\Facades\Route; //Mengimpor class Route
use App\Http\Controllers\ItemController; //Tambahan: Mengimpor class ItemController

//BASIC ROUTING
//Route /hello
Route::get('/hello', function() {
    return 'Hello World';
});

//Route /world
Route::get('/world', function () {
    return 'World';
});

//Route /
/*
Route::get('/', function () {
    return 'Selamat Datang';
});
*/
//URL diganti SelamatDatang
Route::get('/SelamatDatang', function () {
    return 'Selamat Datang';
});

//Route /about
Route::get('/about', function () {
    return 'NIM: 2341760015 <br> Nama: Reza Angelina Febriyanti';
});

//ROUTE PARAMETERS
//Route /user/{name}
Route::get('/user/{name}', function ($name) {
    return 'Nama saya '.$name;
});

//Route /posts/{post}/comments/{comment}
Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
});

//Route /articles/{id}
Route::get('/article/{id}', function ($postId) {
    return 'Halaman Artikel dengan ID '.$postId;
});


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

//Tambahan: menentukan rute ke halaman utama
Route::get('/', function () {
    return view('welcome'); //mengarahkan ke view welcome
});

//Membuat semua rute standar RESTful untuk resource items, yang ditangani oleh ItemController
Route::resource('items', ItemController::class);