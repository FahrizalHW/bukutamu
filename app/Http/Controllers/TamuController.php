<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTamuRequest;
use App\Services\GuestVisitService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class TamuController extends Controller {
  public function __construct(private readonly GuestVisitService $guestVisitService) {}

  public function create(): View {
    return view('tamu.create', [
      'mode' => 'kiosk',
      'formAction' => route('tamu.store'),
    ]);
  }

  public function store(StoreTamuRequest $request): RedirectResponse {
    try {
      $this->guestVisitService->store($request->validated(), 'kiosk');
    } catch (Throwable $exception) {
      report($exception);

      return back()->withInput($request->except('gambar'))->with('error', 'Data gagal disimpan. Silakan coba lagi.');
    }

    return redirect()->route('tamu.create')->with('success', 'Data kunjungan berhasil disimpan.');
  }
}
