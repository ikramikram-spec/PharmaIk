<?php

namespace App\Http\Controllers;

use App\Models\ProductReturn;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
    public function index() {
        $returns = ProductReturn::with('user', 'supplier', 'sale') -> paginate(20);
        return view('returns.index', compact('returns'));
    }

    public function create() {
        $suppliers = Supplier::all();
        $sales = Sale::with('client') -> get();
        return view('returns.create', compact('suppliers', 'sales'));
    }

    public function store(Request $request) {
        $request->validate([
            'type' => 'required|in:supplier,client',
            'reason' => 'nullable|string',
            'note' => 'nullable|string',
            'date_return' => 'required|date',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'sale_id' => 'nullable|exists:sales,id',
        ]);

        ProductReturn::create([
            'type' => $request -> type,
            'reason' => $request -> reason,
            'note' => $request -> note,
            'date_return' => $request -> date_return,
            'user_id' => Auth::user() -> id,
            'supplier_id' => $request -> type === 'supplier' ? $request -> supplier_id : null,
            'sale_id' => $request -> type === 'client' ? $request -> sale_id : null,
        ]);

        return redirect() -> route('Returns.index') -> with('success', 'Return recorded successfully');
    }
}
