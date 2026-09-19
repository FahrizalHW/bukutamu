<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller {
  public function loginForm(): View {
    return view('auth.login');
  }

  public function postLogin(Request $request): RedirectResponse {
    $credentials = $request->validate([
      'username' => ['required', 'string'],
      'password' => ['required', 'string'],
    ]);

    if (! Auth::attempt($credentials)) {
      return back()
        ->withInput($request->only('username'))
        ->with('error', 'Username atau password salah.');
    }

    $request->session()->regenerate();
    $user = $request->user();

    if ($user->role === User::ROLE_GUEST) {
      return redirect()->route('tamu.create');
    }

    if ($user->role === User::ROLE_SUPERADMIN) {
      return redirect()->intended(route('dashboard.index'));
    }

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')
      ->withInput($request->only('username'))
      ->with('error', 'Akun tidak memiliki akses ke aplikasi.');
  }

  public function logout(Request $request): RedirectResponse {
    $role = $request->user()?->role;

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return $role === User::ROLE_GUEST
      ? redirect()->route('home')
      : redirect()->route('login');
  }
}
