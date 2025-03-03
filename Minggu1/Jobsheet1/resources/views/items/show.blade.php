<!DOCTYPE html>
<html>
<head>
    <title>Item List</title> <!--Judul tab-->
</head>
<body>
    <h1>Items</h1> <!--Judul Halaman-->
    <!--Mengecek kondisi apakah session succes-->
    @if(session('success'))
        <p>{{ session('success') }}</p> <!--Jika ya maka ditampilkan-->
    @endif
    <a href="{{ route('items.create') }}">Add Item</a> <!--Jika tidak maka diarahkan ke tombol add item-->
    <ul>

        <!--engulang setiap item dalam koleksi $items-->
        @foreach ($items as $item)
            <li>
                {{ $item->name }} - <!--Menampilkan nama item-->
                <a href="{{ route('items.edit', $item) }}">Edit</a> <!--Membuat tombol edit yang terlink-->
                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button> <!--Tombol untuk menghapus-->
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>