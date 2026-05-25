<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stock::with('product') -> paginate(20);
        $lowStock = Stock::with('product') -> where('quantity', '<', 10) -> get();

        return view('stocks.index', compact('stocks', 'lowStock'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'quantity' => 'required|integer|min:0',
            'PPH_edited' => 'nullable|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'product_id' => 'required|exists:products,id',
        ]);
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
    public function edit(Stock $stock)
    {
        return view('stocks.edit', compact('stock'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        $request -> validate([
            'quantity' => 'required|integer',
        ]);

        $stock -> update([
            'quantity' => $request -> quantity,
        ]);

        return redirect() -> route('Stocks.index') -> with('success', 'Stock updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
