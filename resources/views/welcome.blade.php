@extends('layout.base')

@section('content')
    <div class="w-full h-fit py-3 flex flex-row justify-between">
        <button class="bg-green-500 py-1 px-5 rounded-lg text-[16px] font-semibold">Tambah</button>

        <div class="flex flex-row gap-3">
            <button class="bg-slate-400 py-1 px-5 rounded-lg text-[16px] font-semibold">Pilih Provinsi</button>
            <button class="bg-slate-400 py-1 px-5 rounded-lg text-[16px] font-semibold">Pilih Kabupaten</button>
            <button class="bg-green-500 py-1 px-5 rounded-lg text-[16px] font-semibold">Seacrhing</button>
        </div>
    </div>

    <div class="overflow-x-auto shadow w-full">
        <table class="table table-sm table-zebra">
            <!-- head -->
            <thead class="bg-slate-600 text-white font-extrabold text-lg text-center">
                <tr>
                    <th>No</th>
                    <th>Aksi</th>
                    <th>Name</th>
                    <th>Nik</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Jenis Kelamin</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                <tr>
                    <th class="text-center font-bold text-[17px]">1</th>
                    <th class="flex flex-row gap-2 items-center justify-center">
                        <div>
                            <button class="btn btn-outline btn-sm btn-warning">Edit</button>
                        </div>
                        <div>
                            <button class="btn btn-outline btn-sm btn-error">Hapus</button>
                        </div>
                    </th>
                    <td>Cy Ganderton</td>
                    <td>AJKDGF8Q34</td>
                    <td>25 April 2000</td>
                    <td>Sumedang</td>
                    <td>Lakilaki</td>
                    <td>25 April 2000</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
