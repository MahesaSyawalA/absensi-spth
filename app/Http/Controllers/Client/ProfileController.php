<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Profile',
        ];
        return view('client.profile',$data);
    }

}
