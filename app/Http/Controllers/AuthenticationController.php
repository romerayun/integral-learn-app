<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function login() {
        return view('auth.login');
    }

    public function registration() {
        return view('auth.register');
    }

    public function storeUser(Request $request) {

    }
}
