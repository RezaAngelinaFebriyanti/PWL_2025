<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Dokumen</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>Id Dokumen</th>
            <th>Id Data</th>
            <th>Id Tahap</th>
            <th>Nama Dokumen</th>
            <th>Isi</th>
        </tr>
        @foreach ($dokumen as $d)
        <tr>
            <td>{{ $d->id_dokumen }}</td>
            <td>{{ $d->id_data }}</td>
            <td>{{ $d->id_tahap }}</td>
            <td>{{ $d->nama_dokumen }}</td>
            <td>{{ $d->isi }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>