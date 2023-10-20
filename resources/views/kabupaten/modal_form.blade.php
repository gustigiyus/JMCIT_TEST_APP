<div id="staticModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Form {{ $title }}
                </h3>
                <button type="button" id="silangModal"
                    class="silangModal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Tutup modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-6">
                <div class="">

                    {{-- CSRF --}}
                    <input type="hidden" id="csrf_token" name="csrf_token" value="{{ csrf_token() }}">


                    {{-- Provinsi --}}
                    <div class="flex flex-col gap-5">
                        <div>
                            <label for="provinsi_id" class="provinsi_id_label block mb-2 text-md font-bold">
                                Provinsi
                            </label>
                            <select id="provinsi_id" name="provinsi_id"
                                class="provinsi_id bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Pilih Provinsi</option>
                                @foreach ($provinsi as $prov)
                                    <option value="{{ $prov->id }}">{{ $prov->nama }}</option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-sm font-medium provinsi_id_msg"></p>
                        </div>

                        {{-- Kabupaten --}}
                        <div>
                            <label for="nama_kabupaten"
                                class="nama_kabupaten_label block mb-2 text-md font-bold">Kabupaten
                            </label>
                            <input type="text" name="nama_kabupaten" id="nama_kabupaten"
                                placeholder="Masukan Nama Kabupaten"
                                class="nama_kabupaten dark:bg-gray-700 block w-full p-2.5 text-sm rounded-lg"
                                placeholder="Error input">
                            <p class="mt-2 text-sm font-medium nama_kabupaten_msg"></p>
                        </div>
                    </div>





                </div>
            </div>

            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="button"
                    class="save-button text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan</button>

                <button type="button"
                    class="update-button text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>

                <button id="closeModal" type="button"
                    class="closeModal text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batalakan</button>
            </div>
        </div>
    </div>
</div>
