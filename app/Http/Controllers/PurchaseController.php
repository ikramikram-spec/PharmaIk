<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with('supplier', 'user') ->latest() -> paginate(20);
        return view('purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $products  = Product::with('stock')->get();
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
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'note' => 'nullable'
        ]);

        $total = 0;
        foreach($request -> products as $item){
            $total += $item['quantity'] * $item['unit_price'];
        }

        $purchase = Purchase::create([
            'date_ordering' => $request -> date_ordering,
            'date_delivering' => $request -> date_delivering,
            'supplier_id' => $request->supplier_id,
            'user_id' => Auth::user() -> id,
            'total_amount' => $total,
            'statut' => $request -> statut,
            'date_purchase' => now(),
            'note' => $request -> note,
        ]);

        foreach($request -> products as $item){
            $purchase -> purchaseDetails() -> create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
        ]);

        $stock = Stock::where('product_id', $item['product_id']) -> first();
        if($stock){
            $stock -> quantity += $item['quantity'];
            $stock -> save();
        } else {
            Stock::create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);
        }
    }
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
        return view('purchases.create', compact('purchase', 'suppliers', 'products'));
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
        $purchase->purchaseDetails()->delete();
        $purchase -> delete();
        return redirect() -> route('purchases.index') -> with('success', 'Purchase deleted successfully');
    }
}
