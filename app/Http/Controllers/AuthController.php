<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login()
    {
        return view('login');
    }

    public function proses(Request $request)
    {
        $username = $request->username;
        $password = $request->password;


        if ($username == 'admin' && $password == '123') {
            return redirect('/admin/dashboard');
        } else {
            return back()->with('error', 'Login gagal');
        }
    }
}