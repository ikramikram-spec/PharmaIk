<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with('supplier', 'user') ->latest() -> paginate(20);
        return view('purchases.index', compact($purchases));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $products  = Product::all();
        return view('purchases.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'date_ordering' => 'required|date',
            'date_delivering' => 'nullable|date|after:date_ordering',
            'total_amount' => 'numeric',
            'supplier_id' => 'required|exists:suppliers,id',
            'user_id' => 'required|exists:users,id',
            'statut' => 'required|in:pending,delivered,cancelled',
            'note' => 'nullable'
        ]);
        Purchase::create($request -> all());
        return redirect() -> route('purchases.index') -> with('success', 'purchase added successfully');
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
    public function edit(Purchase $purchase)
    {
        $suppliers  = Supplier::all();
        $products = Product::with('stock')->get();
        return view('sales.create', compact('clients', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $request -> validate([
            'date_ordering' => 'required|date',
            'date_delivering' => 'date',
            'total_amount' => 'numeric',
            'supplier_id' => 'required|exists:suppliers,id',
            'user_id' => 'required|exists:users,id',
            'statut' => 'in:pending,delivered,cancelled',
            'note' => 'nullable'
        ]);
        $purchase -> update($request -> all());
        return redirect() -> route('purchases.index') -> with('success', 'Purchase updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        $purchase -> delete();
        return redirect() -> route('purchases.index') -> with('success', 'Purchase deleted successfully');
    }
}
