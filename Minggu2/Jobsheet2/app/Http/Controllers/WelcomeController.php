<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function hello() {
        return 'Hello World';
    }

    //Fungsi untuk menampilkan view dari controller
    /*
    public function greeting() {
        return view('blog.hello', ['name' => 'Reza Angelina']);
    }
    */

    //Fungsi untuk Meneruskan data ke view
    public function greeting() {
        return view('blog.hello')
        ->with('name','Andi')
        ->with('occupation', 'Astronaut');
    }
}