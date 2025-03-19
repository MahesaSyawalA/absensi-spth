<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Absensi',
        ];
        return view('client.absensi',$data);
    }

    public function absen() {
        return view('client.scanqr');
    }

    public function validasiAbsen(Request $request) {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $user = Auth::user();
    }
}
