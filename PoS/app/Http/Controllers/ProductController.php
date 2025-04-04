<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Method untuk menampilkan halaman kategori Food & Beverage
    public function foodBeverage()
    {
        return view('category.food-beverage'); // Mengembalikan tampilan food-beverage.blade.php
    }

    // Method untuk menampilkan halaman kategori Beauty & Health
    public function beautyHealth()
    {
        return view('category.beauty-health'); // Mengembalikan tampilan beauty-health.blade.php
    }

    // Method untuk menampilkan halaman kategori Home Care
    public function homeCare()
    {
        return view('category.home-care'); // Mengembalikan tampilan home-care.blade.php
    }

    // Method untuk menampilkan halaman kategori Baby & Kid
    public function babyKid()
    {
        return view('category.baby-kid'); // Mengembalikan tampilan baby-kid.blade.php
    }
}
