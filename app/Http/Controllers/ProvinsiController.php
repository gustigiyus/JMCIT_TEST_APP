<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProvinsiController extends Controller
{

    public function index()
    {
        $itemsPerPage = 5;
        $provinsi = Provinsi::orderBy('updated_at', 'desc')->paginate($itemsPerPage);
        // GET DATA NUMBER (LOOPING)
        $no = ($provinsi->currentPage() - 1) * $itemsPerPage + 1;

        $data = [
            'title' => 'Provinsi',
            'data' => $provinsi,
            'no' => $no
        ];
        return view('provinsi.index', $data);
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nama' => 'required|max:100',
        ], [
            'nama.required' => 'Nama Provinsi wajib diisi',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'errors' => $validasi->errors(),
                'messages' => "Data masih belum valid!"
            ], 400);
        } else {
            Provinsi::create($request->all());
            return response()->json(['success' => 'Berhasil menyimpan data'], 200);
        }
    }

    public function show($id)
    {
        $provinsi = Provinsi::findOrFail($id);
        return response()->json([
            'messages' => 'Data berhasil di load',
            'data' => $provinsi
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'nama' => 'required|max:100',
        ], [
            'nama.required' => 'Nama Provinsi wajib diisi',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'errors' => $validasi->errors(),
                'messages' => "Data masih belum valid!"
            ], 400);
        } else {
            $provinsi = Provinsi::find($id);
            if (!$provinsi) {
                return response()->json(['message' => 'Provinsi not found'], 404);
            }

            $provinsi->update($request->all());
            return response()->json(['success' => 'Berhasil update data'], 200);
        }
    }

    public function destroy($id)
    {
        $provinsi = Provinsi::find($id);

        if (!$provinsi) {
            return response()->json(['message' => 'Provinsi tidak ditemukan'], 404);
        }

        $penduduk = Penduduk::where('provinsi_id', $id)->get();
        if ($penduduk->count() > 0) {
            return response()->json(['error' => 'Data tidak dapat dihapus karena ada beberapa data penduduk yang terakit dengan provinsi ini!'], 404);
        } else {
            $provinsi->delete();
            return response()->json(['success' => 'Berhasil delete data'], 200);
        }
    }
}
