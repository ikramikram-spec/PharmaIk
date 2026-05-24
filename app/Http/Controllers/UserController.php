<?php

namespace App\Http\Controllers;

use App\Models\User as ModelsUser;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user() -> role === 'admin'){
            return view('users.create');
        }

        return redirect()->route('Dashboard.index') -> with('error', 'Access denied. Admins only');   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'name' => 'required|string|max:90',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'contact' => 'nullable|string|max:14',
            'role' => 'required|in:admin,employee',
            'address' => 'nullable|string',
            'proj_name' => 'nullable|string',
            'proj_localisation' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        User::create([
            'name' => $request -> name,
            'email' => $request -> email,
            'password' => Hash::make($request -> password),
            'contact' => $request->contact,
            'role' => $request -> role,
            'address' => $request -> address,
            'proj_name' => $request -> proj_name,
            'proj_localisation' => $request -> proj_localisation,
            'is_active' => $request -> is_active ?? true,
        ]);

        return redirect() -> route('user.index') -> with('success', 'Employee account created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(Auth::user() -> role === 'admin'){
            return view('users.create');
        }

        return redirect()->route('Dashboard.index') -> with('error', 'Access denied. Admins only'); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModelsUser $user)
    {
        if(Auth::user() -> role === 'admin'){
            $request -> validate([
                'name' => 'required|string|max:90',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'contact' => 'nullable|string|max:14',
                'role' => 'required|in:admin,employee',
                'address' => 'nullable|string',
                'proj_name' => 'nullable|string',
                'proj_localisation' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            User::create([
                'name' => $request -> name,
                'email' => $request -> email,
                'password' => Hash::make($request -> password),
                'contact' => $request->contact,
                'role' => $request -> role,
                'address' => $request -> address,
                'proj_name' => $request -> proj_name,
                'proj_localisation' => $request -> proj_localisation,
                'is_active' => $request -> is_active ?? true,
            ]);

            return redirect() -> route('Dashboard.index') -> with('error', 'Access denied. Admins only');
        } 
        
        return redirect() -> route('Dashboard.index') -> with('error', 'Access denied. Admins only'); 

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if(Auth::user() -> role === 'admin'){
            $user -> delete();
            return redirect() -> route('Users.index') -> with('success', 'User deleted successfully');
        }

        return redirect() -> route('Dashboard.index') -> with('error', 'Access denied. Admins only'); 
    }
}
