<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer('admin.layout.section.navbar', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $data = [
                    'foto' => $user->foto,
                    'nama' => $user->nama,
                    'role' => $user->role, // Ambil hanya role dan name
                ];
            } else {
                $data = null; // Jika belum login, kirim null
            }

            $view->with('userData', $data);
        });
        
        View::composer('admin.layout.section.sidebar', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $data = [
                    'role' => $user->role, // Ambil hanya role dan name
                ];
            } else {
                $data = null; // Jika belum login, kirim null
            }

            $view->with('userData', $data);
        });
        View::composer('client.layout.section.navbar', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $data = [
                    'foto' => $user->foto,
                    'nama' => $user->nama,
                    'role' => $user->role, // Ambil hanya role dan name
                ];
            } else {
                $data = null; // Jika belum login, kirim null
            }

            $view->with('userData', $data);
        });
    }
}
