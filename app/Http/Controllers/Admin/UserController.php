<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function index()
    {
        $data = [
            'title' => 'User Management',
            'users' => User::all(),
        ];
        return view('admin.managementUser', $data);
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nip' => 'required|unique:users,nip|regex:/^[a-zA-Z0-9]+$/',
            'nama' => 'required|string|regex:/^[a-zA-Z\s.,]+$/',
            'jabatan' => 'required|string|regex:/^[a-zA-Z\s]+$/',
            'tanggal_lahir' => 'required|date',
            'status_pegawai' => 'required|string|in:ASN,Non ASN',
            'jenis_kelamin' => 'required|string|in:Laki laki,Perempuan',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'role' => 'required|string|in:superadmin,admin,pegawai',
        ]);

        // Simpan foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('uploads/profile_pictures', 'public');
        }

        // Simpan data ke database
        $user = User::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'tanggal_lahir' => $request->tanggal_lahir,
            'status_pegawai' => $request->status_pegawai,
            'jenis_kelamin' => $request->jenis_kelamin,
            'foto' => $fotoPath,
            'role' => $request->role,
        ]);

        // Response JSON
        return response()->json([
            'success' => true,
            'message' => 'User berhasil disimpan',
            'user' => $user,
        ]);
    }

    public function edit($nip)
    {

        $user = User::where('nip', $nip)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }

    public function update(Request $request, $nip)
    {
        // Validasi data
        $request->validate([
            'nama' => 'required|string|regex:/^[a-zA-Z\s.,]+$/',
            'jabatan' => 'required|string|regex:/^[a-zA-Z\s]+$/',
            'tanggal_lahir' => 'required|date',
            'status_pegawai' => 'required|string|in:ASN,Non ASN',
            'jenis_kelamin' => 'required|string|in:Laki laki,Perempuan',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'role' => 'required|string|in:superadmin,admin,pegawai',
        ]);

        // Cari user berdasarkan NIP
        $user = User::where('nip', $nip)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
            ], 404);
        }

        // Simpan foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('uploads/profile_pictures', 'public');
            $user->foto = $fotoPath;
        }

        // Update data user
        $user->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'tanggal_lahir' => $request->tanggal_lahir,
            'status_pegawai' => $request->status_pegawai,
            'jenis_kelamin' => $request->jenis_kelamin,
            'role' => $request->role,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diperbarui',
            'user' => $user,
        ]);
    }

    public function destroy($nip)
    {
        $user = User::where('nip', $nip)->first();

        if ($user) {
            $user->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
