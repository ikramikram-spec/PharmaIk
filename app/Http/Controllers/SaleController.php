<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'note' => 'nullable',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.sales_quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
        ]);

        $total = 0;
        foreach($request -> products as $item){
            $total += $item['sales_quantity'] * $item['unit_price'];
        }

        $sale = Sale::create([
            'date_selling' => $request -> date_selling,
            'total_amount' => $request -> total_amount,
            'client_id' => $request -> client_id,
            'user_id' => Auth::user() -> id,
            'note' => $request -> note,
            'total' => $total,
        ]);

        foreach ($request -> products as $item) {
            SaleDetail::create([
                'sale_id' => $sale -> id,
                'product_id' => $item['product_id'],
                'sales_quantity' => $item['sales_quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['sales_quantity'] * $item['unit_price'],
            ]);

            $stock = Stock::where('product_id', $item['product_id'])->first();
            if($stock){
                $stock -> sales_quantity -= $item['sales_quantity'];
                $stock->save();
            }
        }

        return redirect() -> route('sales.index') -> with('success', 'sale added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale->load('client', 'user', 'saleDetails.product');
        return view('sales.index', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $clients  = Client::all();
        $products = Product::with('stock')->get();
        return view('sales.create', compact('sale', 'clients', 'products'));
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
        foreach ($sale -> saleDetails as $detail) {
            Stock::where('product_id', $detail -> product_id) -> increment('sales_quantity', $detail -> sales_quantity);
        }

        $sale -> delete();
        return redirect() -> route('sales.index') -> with('success', 'Sale deleted successfully');
    }
}
