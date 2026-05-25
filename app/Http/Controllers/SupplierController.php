<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::withCount('products') -> paginate(20);
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user() -> role === 'admin'){
            return view('suppliers.create');
        }
        return redirect() -> route('Dashboard.index') -> with('error', 'Access denied. Admins only');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user() -> role === 'admin'){

            $request ->validate([
                'company_name' => 'required|string', 
                'localisation' => 'nullable|string', 
                'email' => 'email',
                'contact' => 'required'
            ]);

            Supplier::create($request -> all());

            return redirect() -> route('suppliers.index') -> with('success', 'Supplier added successfully');
        }

        return redirect() -> route('Dashboard.index') -> with('error', 'Access denied. Admins only');
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
    public function edit(Supplier $supplier)
    {
        if(Auth::user() -> role === 'admin'){
            return view('suppliers.create', compact('supplier'));
        }
        
        return redirect() -> route('suppliers.index') -> with('error', 'Access denied. Admins only');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        if(Auth::user() -> role === 'admin'){

            $request ->validate([
                'company_name' => 'required|string', 
                'localisation' => 'nullable|string', 
                'email' => 'email',
                'contact' => 'required'
            ]);
            $supplier -> update($request -> all());

            return redirect() -> route('suppliers.index') -> with('success', 'Supplier updated successfully');
        }
        
        return redirect() -> route('Suppliers.index') -> with('error', 'Access denied. Admins only');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        if(Auth::user() -> role === 'admin'){

            $supplier -> delete();
            return redirect() -> route('suppliers.index') -> with('success', 'Supplier deleted successfully');
        }

        return redirect() -> route('Suppliers.index') -> with('error', 'Access denied. Admins only');

    }
}
