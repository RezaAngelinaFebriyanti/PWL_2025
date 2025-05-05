<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
</head>
<body>
    <form method="post" action="/user/tambah_simpan">
        {{ csrf_field() }}

        <label>Username</label>
        <input type="text" name="username" placeholder="Masukkan Username">
        <br>
        <label>Nama</label>
        <input type="text" name="nama" placeholder="Masukkan Nama">
        <br>
        <label>Password</label>
        <input type="password" name="password" placeholder="Masukkan Password">
        <br>
        <label>Level ID</label>
        <input type="number" name="level_id" placeholder="Masukkan ID Level">
        <input type="submit" class="btn btn-success" value="Simpan">
        <br>
    </form>
</body>
</html>