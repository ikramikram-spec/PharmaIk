<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Models\Stock;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $TotalClient = Client::count();
        $TotalProduct = Product::count();
        $TotalsalesToday = Sale::whereDate('date_selling', today()) -> sum('total_amount');
        $TodaySales = Sale::with('client', 'user', 'saleDetails.product')
            -> whereDate('date_selling', today())
            -> latest()
            -> get();
    
        $lowStock = Stock::with('product')
        ->where('quantity', '<', 10)
        ->get();

        return view('dashboard.index', compact(
            'TotalClient', 'TotalProduct', 'TotalsalesToday', 'TodaySales','lowStock' 
        ));
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
