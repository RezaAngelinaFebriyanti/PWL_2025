<!DOCTYPE html>
<html>
<head>
    <title>Item List</title> <!--Judul tab-->
</head>
<body>
    <h1>Items</h1> <!--Judul halaman-->
    @if(session('success')) <!--Mengecek apakah ada flash message bernama success-->
        <p>{{ session('success') }}</p> <!--Jika ya maka menampilkan pesan sukses-->
    @endif <!---->
    <a href="{{ route('items.create') }}">Add Item</a> <!--Jika tidak diarahkan ke tombol Add Item-->
    <ul>
        <!--Perulangan untuk mengecek variabel items-->
        @foreach ($items as $item)
            <li>
                {{ $item->name }} - 
                <a href="{{ route('items.edit', $item) }}">Edit</a> <!--menampilkan nama dari item-->
                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>