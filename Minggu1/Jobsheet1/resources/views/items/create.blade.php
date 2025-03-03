<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title> <!--Judul tab-->
</head>
<body> 
    <h1>Add Item</h1> <!--Judul hal dibody-->
    <form action="{{ route('items.store') }}" method="POST"> <!--menentukan url tujuan dan mengirim-->
        @csrf <!--menambahkan token Cross-Site Request Forgery (CSRF) untuk melindungi form dari serangan CSRF-->
        <!--Membuat tempat untuk input-->
        <label for="name">Name:</label>
        <input type="text" name="name" required> <!--input wajib diisi-->
        <br>
        <label for="description">Description:</label> <!--input wajib diisi-->
        <textarea name="description" required></textarea>
        <br>
        <button type="submit">Add Item</button> <!--Tombol submit-->
    </form>
    <a href="{{ route('items.index') }}">Back to List</a> <!--Membuat tautan-->
</body>
</html>