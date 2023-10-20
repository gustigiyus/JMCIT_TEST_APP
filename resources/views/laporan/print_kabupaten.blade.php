<!DOCTYPE html>
<html>

<head>
    <title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h5>Laporan Penduduk</h5>
    </center>

    <br>
    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kabupaten</th>
                <th>Nama Provinsi</th>
                <th>Jumlah Penduduk</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @php $totalPenduduk = 0 @endphp
            @foreach ($penduduk_perkab as $p)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->provinsi->nama }}</td>
                    <td>{{ $p->total_penduduk_kabupaten }}</td>
                    @php $totalPenduduk += $p->total_penduduk_kabupaten @endphp
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th scope="row" colspan="3">Total Penduduk</th>
                <td class="px-6 py-3">{{ $totalPenduduk }}</td>
            </tr>
        </tfoot>
    </table>

</body>

</html>
