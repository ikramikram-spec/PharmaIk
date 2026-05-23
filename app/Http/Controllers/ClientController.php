<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::paginate(20);
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'client_name' => 'required|string',
            'email' => 'nullable|email',
            'contact' => 'nullable|string|max:14',
            'credit' => 'nullable|numeric',
            'address' => 'nullable|string'
        ]);

        Client::create($request -> all());
        return redirect() -> route('clients.index') ->with('success', 'Client added successfully') ;
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
    public function edit(Client $client)
    {
        return view('clients.create', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email',
            'contact' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'credit'  => 'nullable|numeric|min:0',
        ]);

        $client -> update($request -> all());

        return redirect()->route('clients.index')
            -> with('success', 'Client updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect() -> route('clients.index')
            -> with('success', 'Client deleted successfully');
    }
}
