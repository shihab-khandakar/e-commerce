<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function loginRegister(){

        return view('front.users.login_register');

    }


}
