<?php

use Illuminate\Support\Facades\Route; //Mengimpor class Route
use App\Http\Controllers\ItemController; //Tambahan: Mengimpor class ItemController

//BASIC ROUTING
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