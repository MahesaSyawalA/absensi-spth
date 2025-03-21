<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(){
        $user = Auth::user();
        $data = [
            'title' => 'Profile',
            'user' => $user,
        ];
        return view('client.profile',$data);
    }

}
