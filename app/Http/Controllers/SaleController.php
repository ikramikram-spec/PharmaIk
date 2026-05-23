<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with('client', 'user') -> latest() -> paginate(20);
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients  = Client::all();
        $products = Product::with('stock')->get();
        return view('sales.create', compact('clients', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'date_selling' => 'required|date',
            'total_amount' => 'numeric',
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
            'note' => 'nullable'
        ]);

        Sale::create($request -> all());
        return redirect() -> route('sales.index') -> with('success', 'sale added successfully');
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
    public function edit(Sale $sale)
    {
        $clients  = Client::all();
        $products = Product::with('stock')->get();
        return view('sales.create', compact('clients', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $request -> validate([
            'date_selling' => 'required|date',
            'total_amount' => 'numeric',
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
            'note' => 'nullable'
        ]);
        $sale -> update($request -> all());
        return redirect() -> route('sales.index') -> with('success', 'Sale updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        $sale -> delete();
        return redirect() -> route('sales.index') -> with('success', 'Sale deleted successfully');
    }
}
