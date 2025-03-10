<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ubah Data</title>
</head>
<body>
    <h1>Form Ubah Data User</h1>
    <a href="/user">Kembali</a>

    <form method="post" action="/user/ubah_simpan/{{ $data->user_id }}">
        
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label></label>
        <input type="text" name="username" placeholder="Masukkan Username" value="{{ $data->username }}">
        <br>
        <label>Nama</label>
        <input type="text" name="nama" placeholder="Masukkan Nama" value="{{ $data->username }}">
        <br>
        <label>Password</label>
        <input type="password" name="password" placeholder="Masukkan Password" value="{{ $data->password }}">
        <br>
        <label>Level ID</label>
        <input type="number" name="level_id" placeholder="Masukkan ID Level" value="{{ $data->level_id }}">
        <br><br>
        <input type="submit" class="btn btn-success" value="Ubah">
    </form>
    <form action="/user/hapus/{{ $data->user_id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit">Hapus</button>
    </form>
</body>
</html>