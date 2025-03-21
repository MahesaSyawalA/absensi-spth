<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AuthSessionController extends Controller
{
    public function checkLoginStatus()
    {
        if (Auth::check()) {
            return response()->json([
                'logged_in' => true,
                'user' => Auth::user(),
            ], 200);
        }

        return response()->json([
            'logged_in' => false,
            'message' => 'User belum login',
        ], 401);
    }

    // Menampilkan halaman login
    public function index()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = \App\Models\User::where('username', $credentials['username'])->first();

        if ($user) {
            if (!Hash::needsRehash($user->password) && $user->password === $credentials['password']) {
                $user->update(['password' => Hash::make($credentials['password'])]);
                Auth::login($user);
                $request->session()->regenerate();

                return response()->json([
                    'message' => 'Login berhasil dan password diperbarui',
                    'redirect' => route('management-user'), // <-- Tambahkan redirect di sini
                ], 200);
            }

            if (Hash::check($credentials['password'], $user->password)) {
                Auth::login($user);
                $request->session()->regenerate();

                $redirectRoute = match ($user->role) {
                    'admin' => route('management-user'),
                    'pegawai' => route('staff.index'),
                    default => route('/'),
                };

                return response()->json([
                    'message' => 'Login berhasil',
                    'redirect' => $redirectRoute,
                ], 200);
            }
        }

        return response()->json(['message' => 'Username atau password salah'], 401);
    }


    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
