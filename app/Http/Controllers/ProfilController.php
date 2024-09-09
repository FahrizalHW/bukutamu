<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profil = User::all();
        return view("dasboard.edit", compact("profil"));
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
    public function show(User $profil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $profil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $profil)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Use the User model directly to update the password
        User::where('id', $user->id)->update(['password' => Hash::make($request->password)]);

        return redirect()->route('dashboard')->with('success', 'Password updated successfully!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $profil)
    {
        //
    }
}
