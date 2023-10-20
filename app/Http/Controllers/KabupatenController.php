<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Penduduk;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KabupatenController extends Controller
{
    public function index()
    {
        $provinsi = Provinsi::all();

        $itemsPerPage = 5;
        $kabupaten = Kabupaten::with('provinsi:id,nama')->orderBy('updated_at', 'desc')->paginate($itemsPerPage);
        $no = ($kabupaten->currentPage() - 1) * $itemsPerPage + 1;

        $data = [
            'title' => 'Kabupaten',
            'provinsi' => $provinsi,
            'data' => $kabupaten,
            'no' => $no
        ];
        return view('kabupaten.index', $data);
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'provinsi_id' => 'required',
            'nama' => 'required|max:100',
        ], [
            'provinsi_id.required' => 'Provinsi wajib diisi',
            'nama.required' => 'Nama Kabupaten wajib diisi',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'errors' => $validasi->errors(),
                'messages' => "Data masih belum valid!"
            ], 400);
        } else {
            Kabupaten::create($request->all());
            return response()->json(['success' => 'Berhasil menyimpan data'], 200);
        }
    }

    public function show($id)
    {
        $kabupaten = Kabupaten::findOrFail($id);
        return response()->json([
            'messages' => 'Data berhasil di load',
            'data' => $kabupaten
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'provinsi_id' => 'required',
            'nama' => 'required|max:100',
        ], [
            'provinsi_id.required' => 'Provinsi wajib diisi',
            'nama.required' => 'Nama Kabupaten wajib diisi',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'errors' => $validasi->errors(),
                'messages' => "Data masih belum valid!"
            ], 400);
        } else {
            $kabupaten = Kabupaten::find($id);
            if (!$kabupaten) {
                return response()->json(['message' => 'Kabupaten tidak ditemukan'], 404);
            }

            $kabupaten->update($request->all());
            return response()->json(['success' => 'Berhasil update data'], 200);
        }
    }

    public function destroy($id)
    {
        $kabupaten = Kabupaten::find($id);

        if (!$kabupaten) {
            return response()->json(['message' => 'Kabupaten tidak ditemukan'], 404);
        }

        $penduduk = Penduduk::where('kabupaten_id', $id)->get();
        if ($penduduk->count() > 0) {
            return response()->json(['error' => 'Data tidak dapat dihapus karena ada beberapa data penduduk yang terakit dengan kabupaten ini!'], 404);
        } else {
            $kabupaten->delete();
            return response()->json(['success' => 'Berhasil delete data'], 200);
        }
    }
}
