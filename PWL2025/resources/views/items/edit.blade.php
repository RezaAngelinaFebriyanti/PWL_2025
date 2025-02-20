<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title> <!--Judul tab-->
</head>
<body>
    <h1>Edit Item</h1> <!--Judul halaman ditampilan web-->
    <!--Mengirim data ke server -->
    <form action="{{ route('items.update', $item) }}" method="POST">
        @csrf
        @method('PUT') <!--Memperbarui data-->
        <!--Tabel untuk inputan-->
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $item->name }}" required> <!--Mengedit kolom nama-->
        <br>
        <label for="description">Description:</label>
        <textarea name="description" required>{{ $item->description }}</textarea> <!--Mengedit kolom description-->
        <br>
        <button type="submit">Update Item</button> <!--Tombol untuk menyimpan-->
    </form>
    <a href="{{ route('items.index') }}">Back to List</a> <!--Tombol untuk ke halaman items.index-->
</body>
</html>