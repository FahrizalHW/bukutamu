<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller {
  public function edit(): View {
    return view('admin.profile.edit');
  }

  public function update(UpdateProfileRequest $request): RedirectResponse {
    $user = $request->user();
    $validated = $request->validated();

    $user->full_name = $validated['full_name'];
    $user->username = $validated['username'];

    if (! empty($validated['password'])) {
      $user->password = $validated['password'];
      $user->setRememberToken(Str::random(60));
    }

    $user->save();

    return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
  }
}
