<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
  // Menampilkan halaman login
  public function loginForm() {
    return view('auth.login');
  }

  // Menghandle postLogin
  public function postLogin(Request $request) {
    $request->validate([
      'username' => 'required|string',
      'password' => 'required|string',
    ]);
    $credentials = $request->only('username', 'password');
    if (Auth::attempt($credentials)) {
      // Login berhasil
      return redirect()->route('rekap.index');
    }
    // Login gagal, set session dengan error message
    return back()->with('error', 'Username atau password salah.');
  }

  // Menampilkan halaman registrasi
  public function registrationForm() {
    // Periksa apakah pengguna dengan peran 'superadmin' ada
    $superadminExists = User::where('role', 'superadmin')->exists();
    if ($superadminExists) {
      // Alihkan ke halaman login atau halaman lain dengan pesan
      return redirect()->route('login')->with('error', 'Registrasi tidak diizinkan. Akun superadmin sudah ada.');
    }
    return view('auth.register');
  }

  // Menghandle proses registrasi
  public function postRegister(Request $request) {
    $request->validate([
      'username' => 'required|string|unique:users,username|max:255',
      'password' => 'required|string|confirmed|min:8', // Memastikan password sesuai konfirmasi
    ]);
    // Membuat pengguna baru
    User::create([
      'username' => $request->username,
      'password' => Hash::make($request->password), // Hash password
    ]);
   // Mengalihkan ke halaman login setelah registrasi berhasil
    return redirect()->route('login');
  }

  // Menghandle logout
  public function logout(Request $request) {
    Auth::logout();
    return redirect()->route('login');
  }
}
