@extends('layout.base')

@section('title-page', 'Halaman ' . $title)
@section('content')
    <div class="max-w-3xl mx-auto flex flex-col gap-4">

        <h1 class="w-full  text-center font-black text-3xl">Data Provinsi</h1>

        <button id="tombolAdd"
            class="tombolAdd w-fit text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
            type="button">
            Tambah Provinsi
        </button>

        <div class="overflow-x-auto shadow w-full">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg px-6 py-6">

                {{-- TABLE --}}
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Provinsi
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
                                <td class="px-6 py-4 flex items-center justify-center">
                                    <a href="#" data-id="{{ $dt->id }}"
                                        class="tombol-update text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 shadow-lg shadow-teal-500/50 dark:shadow-lg dark:shadow-teal-800/80 font-medium rounded-lg text-xs px-5 py-2.5 text-center mr-2 mb-2">
                                        Edit
                                    </a>
                                    <a href="#" data-id="{{ $dt->id }}"
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

    @include('provinsi.modal_form')

    <script>
        $(document).ready(function() {

            // Flowbite Modal
            const modalForm = document.getElementById('staticModal');

            // options Modal
            const options = {
                placement: 'center',
                backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
            };
            const modal = new Modal(modalForm, options);

            // (CLOSE, SILANG) Modal Flowbite
            document.getElementById('silangModal').addEventListener('click', function() {
                clearValidator()
                modal.hide();
            })
            document.getElementById('closeModal').addEventListener('click', function() {
                clearValidator()
                modal.hide();
            })

            // FORM EDIT, DELETE, ADD
            const buttonSave = $('.save-button');
            const buttonUpdate = $('.update-button');
            let csrf_token = $('#csrf_token').val();

            function showSpinner() {
                // Save Button Validation
                buttonSave.html(
                    `<svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin"
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="#E5E7EB" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentColor" />
                    </svg>
                    Loading...`
                );

                buttonSave.prop('disabled', true);
                buttonSave.addClass('cursor-not-allowed')

                // Update Button Validation
                buttonUpdate.html(
                    `<svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin"
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="#E5E7EB" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentColor" />
                    </svg>
                    Loading...`
                );
                buttonUpdate.prop('disabled', true);
                buttonUpdate.addClass('cursor-not-allowed')
            }

            async function hideSpinner() {
                // Save Button Spinner
                await buttonSave.html('');
                await buttonSave.html('Simpan');
                await buttonSave.prop('disabled', false);
                await buttonSave.removeClass('cursor-not-allowed')
                // Update Button Spinner
                await buttonUpdate.html('');
                await buttonUpdate.html('Simpan');
                await buttonUpdate.prop('disabled', false);
                await buttonUpdate.removeClass('cursor-not-allowed')
            }

            // Function Clear Validator
            function clearValidator() {
                $('.nama_provinsi_label').removeClass(
                    'text-red-700 dark:text-red-500 text-green-700 dark:text-green-500');
                $('.nama_provinsi').removeClass(
                    'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500 is-invalid bg-green-50 border border-green-500 text-green-900 placeholder-green-700 focus:ring-green-500 focus:border-green-500 dark:text-green-500 dark:placeholder-green-500 dark:border-green-500'
                );
                $('.nama_provinsi_msg').removeClass(
                    'text-red-600 dark:text-red-500 text-green-600 dark:text-green-500');
                $('.nama_provinsi_msg').html('');
            }

            // ADD FORM
            $('body').on('click', '.tombolAdd', function(e) {
                e.preventDefault();
                clearValidator()
                $('#nama_provinsi').val('')
                $('.save-button').prop('hidden', false);
                $('.update-button').prop('hidden', true);

                modal.show();

                // Save FORM
                buttonSave.click(function(e) {
                    e.preventDefault()
                    let id = ''
                    confirmAlert('simpan', id)
                })

            })


            // EDIT FORM
            $('body').on('click', '.tombol-update', function(e) {
                e.preventDefault()
                let id = $(this).data('id')
                clearValidator()
                $('.form-data-provinsi :input').val('')
                $('.save-button').prop('hidden', true);
                $('.update-button').prop('hidden', false);

                $.ajax({
                    type: "GET",
                    url: "provinsi/" + id,
                    headers: {
                        'X-CSRF-TOKEN': csrf_token,
                    },
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response.messages)
                        $('#nama_provinsi').val(response.data.nama)

                        modal.show();
                    }
                });

                buttonUpdate.click(function(e) {
                    e.preventDefault();
                    confirmAlert('update', id)
                })
            });

            // DEL FORM
            $('body').on('click', '.tombol-del', function(e) {
                e.preventDefault();
                let id = $(this).data('id')

                e.preventDefault();
                confirmAlert('hapus', id)
            });

            // Function Alert Confirm
            function confirmAlert(action, id) {
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Kamu tidak dapat mengembalikan data ini!",
                    icon: 'question',
                    showDenyButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, proses data!',
                    denyButtonText: `Tidak, jangan proses!`,
                }).then((result) => {

                    if (result.isConfirmed) {
                        if (action == 'simpan' && id == '' || action == 'simpan' && id == null) {
                            save(action)
                        } else if (action == 'update' && id != '' || action == 'update' && id != null) {
                            save(action, id)
                        } else {
                            $.ajax({
                                type: "DELETE",
                                url: "provinsi/" + id,
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
                                        location.reload()
                                    })
                                }
                            });

                        }
                    }
                })
            }

            // SAVE DATA (INSERT & UPDATE)
            function save(action, id) {
                const formData = new FormData()

                let url_data = '';
                let nama_provinsi = $('.nama_provinsi').val()

                // Menambahkan data ke dalam objek FormData
                formData.append('nama', nama_provinsi);

                if (action == 'simpan') {
                    url_data = 'provinsi'
                } else if (action == 'update') {
                    url_data = 'provinsi/' + id
                } else {
                    return false
                }

                $.ajax({
                    type: "POST",
                    url: url_data,
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrf_token,
                    },
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 60000,
                    beforeSend: showSpinner,
                    success: function(response) {

                        let res = response.success
                        if (res) {
                            clearValidator()
                            $('#nama_provinsi').addClass('is-valid');
                            $('.nama_provinsi_msg').addClass('valid-feedback');

                            if (action == 'simpan' || action == 'update') {
                                async function afterSave() {
                                    await hideSpinner()
                                    location.reload()
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Data berhasil ' + action,
                                    showConfirmButton: false,
                                    timer: 2000,
                                }).then(() => {
                                    afterSave()
                                })
                            }

                        }

                    },
                    error: function(response) {
                        let res = response.responseJSON.errors
                        let msg = response.responseJSON.messages

                        if (res) {

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: msg
                            }).then(() => {
                                hideSpinner()

                                if (res.nama) {
                                    $('.nama_provinsi_label').addClass(
                                        'text-red-700 dark:text-red-500'
                                    )
                                    $('.nama_provinsi').addClass(
                                        'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500'
                                    )
                                    $('.nama_provinsi_msg').addClass(
                                        'text-red-600 dark:text-red-500')
                                    $('.nama_provinsi_msg').html(res.nama)
                                } else {
                                    $('.nama_provinsi_label').removeClass(
                                        'text-red-700 dark:text-red-500').addClass(
                                        'text-green-700 dark:text-green-500'
                                    )
                                    $('.nama_provinsi').removeClass(
                                        "bg-red-50 border border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500"
                                    ).addClass(
                                        "bg-green-50 border border-green-500 text-green-900 placeholder-green-700 focus:ring-green-500 focus:border-green-500 dark:text-green-500 dark:placeholder-green-500 dark:border-green-500"
                                    )
                                    $('.nama_provinsi_msg').removeClass(
                                            "text-red-600 dark:text-red-500")
                                        .addClass(
                                            "text-green-600 dark:text-green-500")
                                    $('.nama_provinsi_msg').html('')
                                }
                            })
                        }
                    }
                });

            }
        });
    </script>
@endsection
