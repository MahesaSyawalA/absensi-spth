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
