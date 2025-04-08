<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\fileExists;

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
        // inisialisasi variable untuk bikin slug dan QR
        $last3digitnim = substr($request->nip, -3);
        $slug_pegawai = str_replace(" ", "-", strtolower($request->nama)) . "-" . $last3digitnim;
        $qr_address = "https://sidikspth.com/penilaian-staff/$slug_pegawai";

        // Create a PNG renderer for QR
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);

        // bikin QR pegawai, lalu simpen
        $qr_pegawai = $writer->writeString($qr_address);
        $path = public_path("images/qr/$slug_pegawai.png");
        if (!file_exists(public_path('images/qr'))) {
            mkdir(public_path('images/qr'), 0777, true);
        }
        file_put_contents($path, $qr_pegawai);

        $qr_path = 'images/qr/' . $slug_pegawai . '.png';

        // Validasi data
        $request->validate([
            'nip' => 'required|unique:users,nip|regex:/^[a-zA-Z0-9]+$/',
            'nama' => 'required|string|regex:/^[a-zA-Z\s.,]+$/',
            'jabatan' => 'required|string|regex:/^[a-zA-Z\s]+$/',
            'tanggal_lahir' => 'required|date',
            'status_pegawai' => 'required|string|in:ASN,Non ASN',
            'jenis_kelamin' => 'required|string|in:Laki laki,Perempuan',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'barcode' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'role' => 'required|string|in:superadmin,admin,pegawai',

            'username' => 'required|string|unique:users,username|regex:/^[a-zA-Z0-9]+$/|min:4',

            'password' => [
                'required',
                'string',
                'min:8', // Minimal 8 karakter
                'regex:/[a-z]/', // Harus ada huruf kecil
                'regex:/[A-Z]/', // Harus ada huruf besar
                'regex:/[0-9]/', // Harus ada angka
                'regex:/[\W]/', // Harus ada simbol (karakter khusus)
            ],
        ], [
            // Pesan error dalam Bahasa Indonesia
            'password.required' => 'Kata sandi wajib diisi.',
            'password.string' => 'Kata sandi harus berupa teks.',
            'password.min' => 'Kata sandi minimal harus memiliki 8 karakter.',
            'password.regex' => 'Kata sandi harus mengandung huruf besar, huruf kecil, angka, dan simbol.',

            'username.required' => 'Username wajib diisi.',
            'username.string' => 'Username harus berupa teks.',
            'username.unique' => 'Username sudah digunakan, silakan pilih yang lain.',
            'username.regex' => 'Username hanya boleh mengandung huruf dan angka.',
            'username.min' => 'Username minimal harus memiliki 4 karakter.',
        ]);

        // inisialisasi variabel fotoPath biar nggak error kalau gaada foto pegawai
        $foto_path = '';

        // Simpan foto jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/profile_pictures'), $filename);
            $foto_path = 'images/profile_pictures/' . $filename;
        }
        // Simpan data ke database
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'tanggal_lahir' => $request->tanggal_lahir,
            'status_pegawai' => $request->status_pegawai,
            'jenis_kelamin' => $request->jenis_kelamin,
            'foto' => $foto_path,
            'barcode' => $qr_path,
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
            'barcode' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'role' => 'required|string|in:superadmin,admin,pegawai',
            'username' => 'nullable|string|unique:users,username|regex:/^[a-zA-Z0-9]+$/|min:4', // Bisa null jika tidak diisi
            'password' => [
                'nullable', // Bisa null jika tidak diisi
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[\W]/',
            ],
        ], [
            'password.min' => 'Kata sandi minimal harus memiliki 8 karakter.',
            'password.regex' => 'Kata sandi harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
            'username.unique' => 'Username sudah digunakan, silakan pilih yang lain.',
            'username.regex' => 'Username hanya boleh mengandung huruf dan angka.',
            'username.min' => 'Username minimal harus memiliki 4 karakter.',
        ]);

        
        // Cari user berdasarkan NIP
        $user = User::where('nip', $nip)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
            ], 404);
        }

        // Jika ada file foto baru, simpan dan hapus yang lama
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && file_exists(public_path($user->foto))) {
                unlink(public_path($user->foto));
            }

            // Simpan foto baru di folder public
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/profile_pictures'), $filename);
            $user->foto = 'images/profile_pictures/' . $filename;
        }

        // Update data user (hanya yang diisi)
        $updateData = [
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'tanggal_lahir' => $request->tanggal_lahir,
            'status_pegawai' => $request->status_pegawai,
            'jenis_kelamin' => $request->jenis_kelamin,
            'role' => $request->role,
        ];

        // Create a PNG renderer for QR
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);

        // inisialisasi variable
        $slug = $user->slug;
        $qr_pegawai = '';

        // kalau update nama, buat slug dan qr code baru, hapus qr yang lama
        if ($request->nama != $user->nama) {
            $slug = User::generateSlug($request->nama, $nip);

            // delete old qr
            $filePath = public_path($user->barcode);
            if ($user->barcode && fileExists($filePath)) {
                unlink($filePath);
            }

            $qr_address = "https://sidikspth.com/penilaian-staff/$slug";

            $qr_pegawai = $writer->writeString($qr_address);
            $path = public_path("images/qr/$slug.png");
            if (!file_exists(public_path('images/qr'))) {
                mkdir(public_path('images/qr'), 0777, true);
            }
            file_put_contents($path, $qr_pegawai);

            $qr_pegawai = 'images/qr/' . $slug . '.png';

            // simpan ke dalam array 'updateData' biar disimpan ke dalam database
            $updateData['barcode'] = $qr_pegawai;
            $updateData['slug'] = $slug;
        }

        // Update username hanya jika diisi
        if ($request->filled('username')) {
            $updateData['username'] = $request->username;
        }

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        // Simpan perubahan ke database
        $user->update($updateData);

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
            // delete qr user
            $filePath = public_path($user->barcode);
            if ($user->barcode && fileExists($filePath)) {
                unlink($filePath);
            }

            $user->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
