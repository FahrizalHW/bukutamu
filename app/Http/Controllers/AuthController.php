<?php

namespace App\Http\Controllers;

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

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();

      return redirect()->intended(route('dashboard.index'));
    }

    return back()
      ->withInput($request->only('username'))
      ->with('error', 'Username atau password salah.');
  }

  public function logout(Request $request): RedirectResponse {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
  }
}
