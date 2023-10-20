@extends('layout.base')

@section('title-page', 'Halaman ' . $title)
@section('content')
    <div class="max-w-8xl mx-auto flex flex-col gap-4">

        <div class="p-0 m-0">
            @include('layout.component.pesan')
        </div>

        <h1 class="w-full text-center font-black text-4xl mb-7">Data Penduduk</h1>

        <div class="flex flex-row justify-between items-center">
            <a href="{{ route('penduduk_tambah') }}"
                class="tombolAdd w-fit text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                type="button">
                Tambah Penduduk
            </a>
            <form action="/penduduk/filter" method="post" class="flex flex-row gap-5 items-end">
                @csrf
                <div class="flex flex-col">
                    <label for="provinsi">Pilih Provinsi:</label>
                    <select name="provinsi_id" id="provinsi" class="provinsi_id">
                        <option value="">Semua Provinsi</option>
                        @foreach ($provinsi as $prov)
                            <option value="{{ $prov->id }}" @if ($prov->id == $search_prov) selected @endif>
                                {{ $prov->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col">
                    <label for="kabupaten">Pilih Kabupaten:</label>
                    <select name="kabupaten_id" id="kabupaten" class="kabupaten_id cursor-not-allowed bg-gray-300" disabled>
                        <option value="">Semua Kabupaten</option>
                        @foreach ($kabupaten as $kab)
                            <option value="{{ $kab->id }}" @if ($kab->id == $search_kab) selected @endif>
                                {{ $kab->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col">
                    <label for="kabupaten">Search:</label>
                    <input type="text" name="search_params" placeholder="Pencarian Nama/Nik"
                        value="<?= $searchParams ? $searchParams : '' ?>">
                </div>

                <button type="submit"
                    class="w-fit hover:cursor-pointer text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Cari Data
                </button>

                <a href="{{ route('penduduk') }}"
                    class="w-fit hover:cursor-pointer text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    type="button">
                    Hapus Filter
                </a>
            </form>
        </div>

        <input type="hidden" id="csrf_token" name="csrf_token" value="{{ csrf_token() }}">

        <div class="overflow-x-auto shadow w-full">
            <div class="relative overflow-x-auto shadow-xl sm:rounded-lg px-6 py-6">

                {{-- TABLE --}}
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center w-[5%]">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3 w-[13%]">
                                Nama
                            </th>
                            <th scope="col" class="px-6 py-3">
                                NIK
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tanggal Lahir
                            </th>
                            <th scope="col" class="px-6 py-3 w-[28%]">
                                Alamat
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jenis Kelamin
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Timestamp
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $dt)
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                    {{ $no++ }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $dt->nama }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $dt->nik }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $dt->tgl_lahir }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $dt->alamat }}
                                    <span class="font-bold">
                                        Kab {{ $dt->kabupaten->nama }}, Prov
                                        {{ $dt->provinsi->nama }}
                                    </span>

                                </td>
                                <td class="px-6 py-4">
                                    {{ $dt->jns_kelamin }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $dt->created_at }}
                                </td>
                                <td class="px-6 py-4 flex items-center justify-center">
                                    <a href="{{ route('penduduk_edit', ['id' => $dt->id]) }}"
                                        class="text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-xs px-5 py-2.5 text-center mr-2 mb-2">
                                        Edit
                                    </a>
                                    <a href="#" data-id="{{ $dt->id }}" id="tombol-del"
                                        class="tombol-del text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-xs px-5 py-2.5 text-center mr-2 mb-2">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- FOOTER (NAVIGATE, TOTAL DATA, DAN LAINNYA) --}}
                <br />
                <div class="flex flex-col gap-5">
                    <div class="flex flex-row justify-between border-b-2 py-2">
                        <div>
                            <h4>
                                <span class="text-slate-700 font-bold">Halaman :</span>
                                {{ $data->currentPage() }}
                            </h4>
                            <h4>
                                <span class="text-slate-700 font-bold">Jumlah Data :</span>
                                {{ $data->total() }}
                            </h4>
                        </div>

                        <h4>
                            <span class="text-slate-700 font-bold">Data Per Halaman :</span>
                            {{ $data->perPage() }}
                        </h4>
                    </div>
                    <div>
                        {{ $data->links() }}
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let csrf_token = $('#csrf_token').val();
            var baseUrl = window.location.origin;

            $('body').on('click', '.tombol-del', function(e) {
                e.preventDefault();
                let id = $(this).data('id')

                e.preventDefault();
                confirmAlert('hapus', id)
            });

            // Function Alert Confirm
            function confirmAlert(action, id) {
                Swal.fire({
                    title: 'Apakah anda yakin ingin menghapus data ini?',
                    icon: 'question',
                    showDenyButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus data',
                    denyButtonText: `Tidak, jangan dihapus`,
                }).then((result) => {

                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: baseUrl + '/penduduk/' + id,
                            headers: {
                                'X-CSRF-TOKEN': csrf_token,
                            },
                            async: true,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Dihapus!',
                                    text: 'Data telah berhasil di' + action,
                                    showConfirmButton: false,
                                    timer: 2000,
                                }).then(() => {
                                    window.location.href = '/penduduk';
                                })
                            },
                        });
                    }
                })
            }

            // ON EXIST
            let id_exist_prov = $('.provinsi_id').val()
            let id_exist_kab = $('.kabupaten_id').val()

            if (id_exist_prov) {
                $('.kabupaten_id').removeClass('cursor-not-allowed bg-gray-300');
                $('.kabupaten_id').attr('disabled', false);

                $.ajax({
                    type: "get",
                    url: baseUrl + '/penduduk/getKabupaten/' + id_exist_prov,
                    headers: {
                        'X-CSRF-TOKEN': csrf_token,
                    },
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        let dataKabupaten = response.data;
                        console.log(dataKabupaten);
                        setTimeout(function() {
                            $('.kabupaten_id').empty();
                            $('.kabupaten_id').append(new Option('Pilih Kabupaten',
                                ''));
                            $.each(dataKabupaten, function(index, kabupaten) {
                                $('.kabupaten_id').append(new Option(
                                    kabupaten
                                    .nama,
                                    kabupaten.id));
                            });
                            $('.kabupaten_id').val(id_exist_kab);
                        }, 300);
                    }
                });
            } else {
                $('.kabupaten_id').addClass('cursor-not-allowed bg-gray-300');
                $('.kabupaten_id').attr('disabled', true);
                $('.kabupaten_id').val('');
            }

            // ON CAHNGE
            $('.provinsi_id').change(function(e) {
                e.preventDefault();
                let id = $('.provinsi_id').val()

                if (id) {
                    $('.kabupaten_id').removeClass('cursor-not-allowed bg-gray-300');
                    $('.kabupaten_id').attr('disabled', false);

                    $.ajax({
                        type: "get",
                        url: baseUrl + '/penduduk/getKabupaten/' + id,
                        headers: {
                            'X-CSRF-TOKEN': csrf_token,
                        },
                        async: true,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            let dataKabupaten = response.data;
                            console.log(dataKabupaten);
                            setTimeout(function() {
                                $('.kabupaten_id').empty();
                                $('.kabupaten_id').append(new Option('Pilih Kabupaten',
                                    ''));
                                $.each(dataKabupaten, function(index, kabupaten) {
                                    $('.kabupaten_id').append(new Option(
                                        kabupaten
                                        .nama,
                                        kabupaten.id));
                                });
                            }, 300);
                        }
                    });
                } else {
                    $('.kabupaten_id').addClass('cursor-not-allowed bg-gray-300');
                    $('.kabupaten_id').attr('disabled', true);
                    $('.kabupaten_id').val('');
                }

            });


        });
    </script>
@endsection
