@extends('layout.base')

@section('title-page', 'Halaman ' . $title)
@section('content')

    <div>
        <h1 class="w-full text-center font-black text-5xl mt-10">Laporan Penduduk</h1>

        <div class="flex flex-row items-center h-[580px] ">
            <div class="max-w-8xl mx-auto flex flex-col gap-4">
                <div class="flex flex-row">
                    <a href="{{ route('excel-export') }}"
                        class="w-fit hover:cursor-pointer text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-xl px-5 py-2.5 text-center mr-2 mb-2"
                        type="button">
                        Generete Excel Data Penduduk
                    </a>
                    <a href="{{ route('print-pend-provinsi') }}"
                        class="w-fit hover:cursor-pointer text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-xl px-5 py-2.5 text-center mr-2 mb-2"
                        type="button">
                        Print Penduduk Per Provinsi
                    </a>
                </div>
            </div>

            <div class="flex flex-row items-center justify-center w-[700px] gap-5 ">
                <div>
                    <label for="provinsi" class="text-2xl font-bold">Pilih Provinsi: </label>
                    <select name="provinsi_id" id="provinsi_id" class="text-lg rounded-xl px-3 py-3">
                        <option value="">Semua Provinsi</option>
                        @foreach ($provinsi as $prov)
                            <option value="{{ $prov->id }}">{{ $prov->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button id="print-pend-kabupaten"
                        class="w-fit hover:cursor-pointer text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-xl px-5 py-2.5 text-center"
                        type="button">
                        Print Penduduk Per kabupaten
                    </button>
                </div>

            </div>
        </div>

    </div>


    <script>
        $(document).ready(function() {

            let btnPrintKabupaten = $("#print-pend-kabupaten");
            btnPrintKabupaten.on("click", function() {
                let provinsiIdSelected = $('#provinsi_id').val();
                if (provinsiIdSelected == "") {
                    provinsiIdSelected = 0;
                }

                let url = "/laporan/print/kabupaten/" + provinsiIdSelected + '/';
                window.open(url, "_blank");
            });

        });
    </script>
@endsection
