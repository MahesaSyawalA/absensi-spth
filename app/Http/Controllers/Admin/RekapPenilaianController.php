<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RekapPenilaianController extends Controller
{

    public function index()
    {
        $data = [
            'title' => 'Rekap Penilaian',
        ];
        return view('admin.rekapPenilaian', $data);
    }
}
