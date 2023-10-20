@extends('layout.base')

@section('title-page', 'Halaman ' . $title)
@section('content')


    <div class="flex flex-row mx-auto justify-center !mt-20">
        <div class="max-w-3xl flex flex-col gap-4 bg-slate-300 shadow w-full items-center p-0">
            <h1 class="w-full text-center font-black text-3xl bg-slate-400 py-3">Form Edit Penduduk</h1>

            <div class="px-6 py-6 w-full ">
                <form action="{{ route('penduduk_store') }}" method="POST" class="flex flex-col gap-5">
                    {{-- CSRF --}}
                    @csrf
                    <input type="hidden" id="csrf_token" name="csrf_token" value="{{ csrf_token() }}">

                    <div class="flex flex-row gap-5">
                        {{-- Provinsi --}}
                        <div class="w-1/2">
                            <label for="provinsi_id" class="provinsi_id_label block mb-2 text-md font-bold">
                                Provinsi
                            </label>
                            <select id="provinsi_id" name="provinsi_id"
                                class="provinsi_id bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Pilih Provinsi</option>
                                @foreach ($provinsi as $prov)
                                    <option value="{{ $prov->id }}" @if ($prov->id == $penduduk->provinsi_id) selected @endif>
                                        {{ $prov->nama }}</option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-sm font-medium provinsi_id_msg"></p>
                        </div>

                        {{-- Kabupaten --}}
                        <div class="w-1/2">
                            <label for="kabupaten_id" class="kabupaten_id_label block mb-2 text-md font-bold">
                                Kabupaten
                            </label>
                            <select id="kabupaten_id" name="kabupaten_id"
                                class="kabupaten_id bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Pilih Kabupaten</option>
                            </select>
                            <p class="mt-2 text-sm font-medium kabupaten_id_msg"></p>
                        </div>

                        {{-- EDIT DATA --}}
                        <input type="hidden" id="data_kabupaten_id_edited" value="{{ $penduduk->kabupaten_id }}">
                    </div>

                    <div class="flex flex-row gap-5">
                        {{-- Nama --}}
                        <div class="w-1/2">
                            <label for="nama" class="nama_label block mb-2 text-md font-bold">Nama
                            </label>
                            <input type="text" name="nama" id="nama" placeholder="Masukan nama lengkap"
                                class="nama dark:bg-gray-700 block w-full p-2.5 text-sm rounded-lg"
                                value="{{ $penduduk->nama }}">
                            <p class="mt-2 text-sm font-medium nama_msg"></p>
                        </div>

                        {{-- Nik --}}
                        <div class="w-1/2">
                            <label for="nik" class="nik_label block mb-2 text-md font-bold">NIK
                            </label>
                            <input type="text" name="nik" id="nik" placeholder="Masukan nomer NIK"
                                class="nik dark:bg-gray-700 block w-full p-2.5 text-sm rounded-lg"
                                value="{{ $penduduk->nik }}">
                            <p class="mt-2 text-sm font-medium nik_msg"></p>
                        </div>

                    </div>

                    <div class="flex flex-row gap-5">
                        {{-- Tanggal Lahir --}}
                        <div class="w-1/2">
                            <label for="tgl_lahir" class="tgl_lahir_label block mb-2 text-md font-bold">
                                Tanggal Lahir
                            </label>
                            <input type="date" name="tgl_lahir" id="tgl_lahir" placeholder="Masukan Tanggal Lahir"
                                class="tgl_lahir dark:bg-gray-700 block w-full p-2.5 text-sm rounded-lg"
                                value="{{ $penduduk->tgl_lahir }}">
                            <p class="mt-2 text-sm font-medium tgl_lahir_msg"></p>
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="w-1/2">
                            <label for="jns_kelamin" class="jns_kelamin_label block mb-2 text-md font-bold">
                                Jenis Kelamin
                            </label>
                            <select id="jns_kelamin" name="jns_kelamin"
                                class="jns_kelamin bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            <p class="mt-2 text-sm font-medium jns_kelamin_msg"></p>
                        </div>

                        <input type="hidden" id="default_value_jns_kelamin_error" value="{{ $penduduk->jns_kelamin }}">
                    </div>

                    {{-- Alamat --}}
                    <div class="w-full">
                        <label for="alamat" class="alamat_label block mb-2 text-md font-bold">Alamat
                        </label>
                        <textarea id="alamat" rows="4" name="alamat"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Masukan data alamat...">{{ $penduduk->alamat }}</textarea>
                        <p class="mt-2 text-sm font-medium alamat_msg"></p>
                    </div>

                    <div class="flex flex-row items-center justify-center">
                        <button type="submit"
                            class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Simpan</button>

                        <a href="{{ route('penduduk') }}" type="button"
                            class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Kembali</a>
                    </div>
                </form>

            </div>
        </div>
        @if ($errors->any())
            <div class="p-0 m-0">
                @include('layout.component.pesan')
            </div>
        @endif
    </div>





    <script>
        $(document).ready(function() {

            let deafult_jenis_kelamin = $('#default_value_jns_kelamin_error').val();
            let deafult_kabupaten_id = $('#default_value_kabupaten_id_error').val();
            let deafult_provinsi_id = $('#default_value_provinsi_id_error').val();
            let edit_provinsi_id = $('#provinsi_id').val();

            if (deafult_jenis_kelamin) {
                $('#jns_kelamin').val(deafult_jenis_kelamin)
            } else {
                $('#jns_kelamin').val('')
            }

            // DATA LOAD DARI EDIT
            if (edit_provinsi_id) {
                $.ajax({
                    type: "get",
                    url: "getKabupaten/" + edit_provinsi_id,
                    headers: {
                        'X-CSRF-TOKEN': csrf_token,
                    },
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        let dataKabupaten = response.data;
                        let dataEditKabupaten = $('#data_kabupaten_id_edited').val();
                        setTimeout(function() {
                            $('#kabupaten_id').empty();
                            $('#kabupaten_id').append(new Option('Pilih Kabupaten',
                                ''));
                            $.each(dataKabupaten, function(index, kabupaten) {
                                $('#kabupaten_id').append(new Option(kabupaten
                                    .nama,
                                    kabupaten.id));
                            });
                            $('#kabupaten_id').val(dataEditKabupaten)
                        }, 300);
                    }
                });
            }

            $('#provinsi_id').change(function(e) {
                e.preventDefault();

                let id = $('#provinsi_id').val()

                $.ajax({
                    type: "get",
                    url: "getKabupaten/" + id,
                    headers: {
                        'X-CSRF-TOKEN': csrf_token,
                    },
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        let dataKabupaten = response.data;

                        setTimeout(function() {
                            $('#kabupaten_id').empty();
                            $('#kabupaten_id').append(new Option('Pilih Kabupaten',
                                ''));
                            $.each(dataKabupaten, function(index, kabupaten) {
                                $('#kabupaten_id').append(new Option(kabupaten
                                    .nama,
                                    kabupaten.id));
                            });
                        }, 300);
                    }
                });
            });

        });
    </script>


@endsection
