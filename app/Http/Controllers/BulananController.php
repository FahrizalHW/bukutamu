<?php

namespace App\Http\Controllers;

use App\Models\Bulanan;
use Illuminate\Http\Request;
use App\Models\Tamu;

class BulananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $tamu = Tamu::all();
    return view("dasboard.ondex", compact("tamu"));
}
public function filter(){
    $tamu = Tamu::all();
    return view("dasboard.filter", compact("tamu"));
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
    public function show(Bulanan $bulanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bulanan $bulanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bulanan $bulanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    // Find the Tamu record by ID
    $tamu = Tamu::findOrFail($id);

    // Delete the Tamu record
    $tamu->delete();

    // Redirect back with a success message
    return redirect()->route('dashboard.ondex')->with('success', 'Tamu deleted successfully');
}

}
