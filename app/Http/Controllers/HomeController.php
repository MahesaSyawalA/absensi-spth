<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $staffs = User::select('nip', 'nama', 'jabatan', 'foto')->get();
        $data = [
            'staffs' => $staffs,
        ];
        return view('home',$data);
    }

    public function indexPenilaian(){
        $kriteriaWithSub = Kriteria::with('subKriteria')->get();
        $data = [
            'kriteriaWithSub' => $kriteriaWithSub,
        ];
        return view('penilaian',$data);
    }
}
