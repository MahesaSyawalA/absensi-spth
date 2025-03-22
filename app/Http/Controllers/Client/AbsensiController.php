<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
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
        return view('client.scanqr', [
            'user' => Auth::user(),
        ]);
    }
}
