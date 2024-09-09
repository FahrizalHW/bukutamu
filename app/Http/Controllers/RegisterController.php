<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
     public function index()
    {
        return view('register.index', [
            'tittle' => 'register'
        ]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            // 'username' => ['required', 'min:3', 'max:255', 'unique:users'],
            'email' =>  'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255'
        ]);
            $validatedData['password'] = Hash::make($validatedData['password']);

            User::create($validatedData);

            session()->flash('success', 'Registratin sucsessfull, please login');

            return redirect('/login');
    }
}
