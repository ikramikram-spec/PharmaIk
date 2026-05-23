<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if(Auth::attempt($cerdentials)){
            return redirect(route('dashboard.index')) -> with('success', 'login succefully') ;
        }
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function logout(Request $request){
        Auth::logout();
        $request -> session() -> invalidate();
        $request -> session() -> regenerateToken();
        return redirect() -> route('auth.login');
    }
    
    public function showregister(){
        return view('auth.register');
    }
    
}
