<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
}
