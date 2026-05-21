<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showlogin() {
        return view('auth.login');
    }

    public function login(Request $request) { 
        $request -> validate([
            'email' => 'required|email',
            'password' => 'required',            
        ]) ;

        $cerdentials = $request -> only('email', 'password');

        if(Auth::attempt($cerdentials)) {
            return redirect('dashboard.index')
                ->with()
        }
    }
}
