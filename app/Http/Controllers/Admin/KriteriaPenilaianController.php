<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class KriteriaPenilaianController extends Controller
{

    public function index()
    {
        $kriteriaAll = Kriteria::all();
        $subKriteriaAll = SubKriteria::with('kriteria')->get();

        $data = [
            'title' => 'Kriteria Penilaian',
            'kriteriaAll' => $kriteriaAll,
            'subKriteriaAll' => $subKriteriaAll
        ];
        return view('admin.kriteriaPenilaian', $data);
    }

    public function store(Request $request)
    {
        // Ubah format sebelum validasi
        $formattedName = strtolower(str_replace(' ', '_', trim($request->name)));
        $totalBobot = Kriteria::sum('bobot');

        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'bobot' => [
                'required',
                'integer',
                'min:1',
                'max:100',
                function ($attribute, $value, $fail) use ($totalBobot) {
                    if ($totalBobot + $value > 100) {
                        $fail('Total bobot tidak boleh melebihi dengan kategori yang telah ada 100%.');
                    }
                }
            ],
        ]);

        // Simpan ke database
        Kriteria::create([
            'name' => $formattedName,
            'bobot' => $request->bobot,
            'type' => $request->type,
        ]);

        return response()->json(['success' => true, 'message' => 'Kriteria berhasil ditambahkan']);
    }

    public function storeSubKriteria(Request $request)
    {
        // Validasi
        $request->validate([
            'kriteria' => 'required|exists:kriteria,uuid', // Pastikan id_kriteria ada di tabel kriteria
            'name' => 'required|string|max:255',
            'nilai' => 'required|integer|min:1|max:50',
        ]);

        // Ubah format sebelum disimpan
        $formattedName = strtolower(str_replace(' ', '_', trim($request->name)));

        // Simpan ke database
        SubKriteria::create([
            'id_kriteria' => $request->kriteria, // Simpan id_kriteria
            'name' => $formattedName,
            'nilai' => $request->nilai,
        ]);

        return response()->json(['success' => true, 'message' => 'Sub Kriteria berhasil ditambahkan']);
    }


    public function destroy($id)
    {
        $kriteria = Kriteria::where('uuid', $id)->first();

        if ($kriteria) {
            $kriteria->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function destroySubKriteria($id)
    {
        $subKriteria = SubKriteria::where('uuid', $id)->first();

        if ($subKriteria) {
            $subKriteria->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
