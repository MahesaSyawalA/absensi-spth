<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KriteriaPenilaianController extends Controller
{

    public function index()
    {
        $data = [
            'title' => 'Kriteria Penilaian',
        ];
        return view('admin.kriteriaPenilaian', $data);
    }
}
