<?php

use Illuminate\Support\Facades\Route; //Mengimpor class Route
use App\Http\Controllers\ItemController; //Tambahan: Mengimpor class ItemController

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