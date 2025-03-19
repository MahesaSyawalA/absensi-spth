<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class AuthSessionController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Login',
        ];
        return view('auth.login',$data);
    }

}
