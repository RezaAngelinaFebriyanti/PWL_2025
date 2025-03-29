<?php

use App\Http\Controllers\dokumenController; //db facades
use App\Http\Controllers\validasiController; //query builder
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;

//DB FACADES insert tabel dokumen
Route::get('/dokumen', [dokumenController::class, 'insert']);
//QUERY BUILDER insert tabel validasi
Route::get('/validasi', [validasiController::class, 'insert']);
//Eloquant menampilkan tabel dokumen
Route::get('/dokumen', [dokumenController::class, 'view']);

//ROUTE VIEW 
//Halaman Awal Web
Route::get('/home', [HomeController::class, 'index']);

//ROUTE PREFIX
//Menampilkan produk
Route::prefix('/category')->group(function () {
    Route::get('/food-beverage', [ProductController::class, 'foodBeverage']);
    Route::get('/beauty-health', [ProductController::class, 'beautyHealth']);
    Route::get('/home-care', [ProductController::class, 'homeCare']);
    Route::get('/baby-kid', [ProductController::class, 'babyKid']);
});

//ROUTE PARAMETER
//Halaman User
Route::get('/user/{id}/name/{name}', function($id, $name) {
    return 'Id Pelanggan Anda: ' . $id . ' Nama Anda: ' . $name;
});

//ROUTE VIEW
// Halaman Penjualan
Route::get('/sales', [SalesController::class, 'index']);

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