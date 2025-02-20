<?php

namespace App\Http\Controllers; //Menentukan namespace

//Perintah mengimpor
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     //Menampilkan semua item dalam tabel items
    public function index()
    {
        //Tambahan
        $items = Item::all(); //mengambil semua data dari tabel items
        return view('items.index', compact('items')); //memuat view items/index.blade.php dan mengirimkan data items ke view tersebut
    }

    /**
     * Show the form for creating a new resource.
     */

    //Menampilkan form untuk menambahkan item baru
    public function create()
    {
        //Tambahan
        return view('items.create'); //mengarahkan ke file tsb
    }

    /**
     * Store a newly created resource in storage.
     */

    //Menyimpan item baru ke dalam database setelah memvalidasi data input
    public function store(Request $request)
    //parameter menerima data inputan
    {
        //Tambahan Kode
        //Untuk memastikan kolom name dan description terisi
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        Item::create($request->only(['name', 'description'])); //menyimpan data ke tabel items
        return redirect()->route('items.index')->with('success', 'Item added successfully.'); //untuk menampilkan pesan sukses
    }

    /**
     * Display the specified resource.
     */

    //Menampilkan detail dari satu item berdasarkan ID
    public function show(string $id)
    {
        //Tambahan
        return view('items.show', compact('item')); //Menampilkan halaman detail items/show.blade.php
    }

    /**
     * Show the form for editing the specified resource.
     */

    //Menampilkan form untuk mengedit item yang sudah ada
    public function edit(string $id)
    {
        //Tambahan
        return view('items.edit', compact('item')); //Menampilkan view items/edit.blade.php
    }

    /**
     * Update the specified resource in storage.
     */

    //Memperbarui data item yang sudah ada dengan data baru
    public function update(Request $request, Item $item)
    {
        //Tambahan
        //Memastikan kolom name dan description terisi
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $item->update($request->only(['name', 'description'])); //memperbarui data item
        return redirect()->route('items.index')->with('success', 'Item updated successfully.');  //menghapus item dari tabel items
    }

    /**
     * Remove the specified resource from storage.
     */

    //Menghapus item dari database
    public function destroy(Item $item)
    {
        //Tambahan
        $item->delete(); //menghapus item dari tabel items
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.'); //Menampilkan pesan sukses
    }
}