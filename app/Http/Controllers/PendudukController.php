<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Penduduk;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PendudukController extends Controller
{
    public function index()
    {
        $provinsi = Provinsi::all();
        $kabupaten = Kabupaten::all();
        $itemsPerPage = 5;
        $penduduk = Penduduk::with('kabupaten:id,nama', 'provinsi:id,nama')->orderBy('updated_at', 'desc')->paginate($itemsPerPage);
        // GET DATA NUMBER (LOOPING)
        $no = ($penduduk->currentPage() - 1) * $itemsPerPage + 1;

        $data = [
            'title' => 'Penduduk',
            'data' => $penduduk,
            'provinsi' => $provinsi,
            'kabupaten' => $kabupaten,
            'no' => $no
        ];
        return view('penduduk.index', $data);
    }

    public function create()
    {
        $provinsi = Provinsi::all();
        $kabupaten = Kabupaten::all();

        $data = [
            'title' => 'Form Tambah Penduduk',
            'provinsi' => $provinsi,
            'kabupaten' => $kabupaten,
        ];
        return view('penduduk.add', $data);
    }

    public function store(Request $request)
    {
        // SESSION FLASH VALUE DEFAULT
        Session::flash('nama', $request->nama);
        Session::flash('nik', $request->nik);
        Session::flash('tgl_lahir', $request->tgl_lahir);
        Session::flash('jns_kelamin', $request->jns_kelamin);
        Session::flash('alamat', $request->alamat);
        Session::flash('provinsi_id', $request->provinsi_id);
        Session::flash('kabupaten_id', $request->kabupaten_id);

        $request->validate([
            'nama' => 'required|max:50',
            'nik' => 'required|max:50',
            'tgl_lahir' => 'required',
            'jns_kelamin' => 'required',
            'alamat' => 'required|max:255',
            'provinsi_id' => 'required',
            'kabupaten_id' => 'required',
        ], [
            'nama.required' => 'Nama Penduduk wajib diisi',
            'nik.required' => 'NIK Penduduk wajib diisi',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
            'jns_kelamin.required' => 'Jenis Kelamin wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'provinsi_id.required' => 'Provinsi wajib diisi',
            'kabupaten_id.required' => 'Kabupaten wajib diisi',
        ]);

        $data = [
            'nama' => $request->input('nama'),
            'nik' => $request->input('nik'),
            'tgl_lahir' => $request->input('tgl_lahir'),
            'jns_kelamin' => $request->input('jns_kelamin'),
            'provinsi_id' => $request->input('provinsi_id'),
            'kabupaten_id' => $request->input('kabupaten_id'),
            'alamat' => $request->input('alamat'),
        ];

        Penduduk::create($data);
        return redirect('penduduk')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $provinsi = Provinsi::all();
        $kabupaten = Kabupaten::all();
        $penduduk = Penduduk::where('id', $id)->first();
        $data = [
            'title' => 'Form Edit Penduduk',
            'penduduk' => $penduduk,
            'provinsi' => $provinsi,
            'kabupaten' => $kabupaten,
        ];

        return view('penduduk.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'nik' => 'required|max:50',
            'tgl_lahir' => 'required',
            'jns_kelamin' => 'required',
            'alamat' => 'required|max:255',
            'provinsi_id' => 'required',
            'kabupaten_id' => 'required',
        ], [
            'nama.required' => 'Nama Penduduk wajib diisi',
            'nik.required' => 'NIK Penduduk wajib diisi',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
            'jns_kelamin.required' => 'Jenis Kelamin wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'provinsi_id.required' => 'Provinsi wajib diisi',
            'kabupaten_id.required' => 'Kabupaten wajib diisi',
        ]);

        $data = [
            'nama' => $request->input('nama'),
            'nik' => $request->input('nik'),
            'tgl_lahir' => $request->input('tgl_lahir'),
            'jns_kelamin' => $request->input('jns_kelamin'),
            'provinsi_id' => $request->input('provinsi_id'),
            'kabupaten_id' => $request->input('kabupaten_id'),
            'alamat' => $request->input('alamat'),
        ];

        Penduduk::where('id', $id)->update($data);
        return redirect('penduduk')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $penduduk = Penduduk::find($id);

        if (!$penduduk) {
            return response()->json(['message' => 'Penduduk tidak ditemukan'], 404);
        }
        $penduduk->delete();
        return response()->json(['success' => 'Berhasil delete data'], 200);
    }

    // OTHER FUNCTION 
    public function getKabupaten($id)
    {
        $kabupaten = Kabupaten::where('provinsi_id', $id)->get();

        if (!$kabupaten) {
            return response()->json(['message' => 'Kabupaten tidak ditemukan'], 404);
        }

        return response()->json(['data' => $kabupaten], 200);
    }

    public function filter(Request $request)
    {
        $provinsiId = $request->input('provinsi_id');
        $kabupatenId = $request->input('kabupaten_id');
        $searchParams = $request->input('search_params');

        $provinsi = Provinsi::all();
        $kabupaten = Kabupaten::all();
        $itemsPerPage = 5;

        $query = Penduduk::with('kabupaten:id,nama', 'provinsi:id,nama')
            ->orderBy('updated_at', 'desc');

        if (!empty($provinsiId)) {
            $query->where('provinsi_id', 'like', "%{$provinsiId}%");
        }

        if (!empty($kabupatenId)) {
            $query->where('kabupaten_id', 'like', "%{$kabupatenId}%");
        }

        if (!empty($searchParams)) {
            $query->where(function ($q) use ($searchParams) {
                $q->where('nama', 'like', "%{$searchParams}%")
                    ->orWhere('nik', 'like', "%{$searchParams}%");
            });
        }

        $penduduk = $query->paginate($itemsPerPage);

        $no = ($penduduk->currentPage() - 1) * $itemsPerPage + 1;

        $data = [
            'title' => 'Penduduk',
            'data' => $penduduk,
            'provinsi' => $provinsi,
            'kabupaten' => $kabupaten,
            'no' => $no
        ];



        return view('penduduk.index', $data);
    }
}
