<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('product_name', 'category', 'supplier', 'stock') -> paginate(20);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers  = Supplier::all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'product_name' => 'required|string',
            'PPV' => 'numeric|required',
            'PPH' => 'numeric|required',
            'description' => 'nullable|string',
            'dosage_form' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id'
        ]);

        Product::create($request -> all());
        return redirect() -> route('products.index') -> with('success', 'Product added successfully');
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
    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers  = Supplier::all();
        return view('products.create', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request -> validate([
            'product_name' => 'required|string',
            'PPV' => 'required|numeric|min:0',
            'PPH' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'dosage_form' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);
        $product -> update($request -> all());

        return redirect() -> route('products.index')
            -> with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product -> delete();
        return redirect() -> route('products.index')
            -> with('success', 'Product deleted successfully');
    }
}
