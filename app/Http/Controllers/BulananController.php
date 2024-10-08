<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use Illuminate\Http\Request;

class BulananController extends Controller {
  public function index(Request $request) {
    $query = Tamu::query();
    // Cek apakah ada filter bulan
    if ($request->has('bulan') && $request->bulan) {
      $bulan = $request->bulan;
      $query->whereMonth('tanggal', $bulan);
    }
    $tamu = $query->get();
    return view("dasboard.index", compact("tamu"));
  }

  public function filter(Request $request) {
    // Meneruskan ke fungsi index untuk menampilkan filter
    return $this->index($request);
  }
  
  public function show($id) {
    // Temukan data tamu berdasarkan ID
    $tamu = Tamu::findOrFail($id);
    // Tampilkan view dengan data tamu
    return view('dasboard.show', compact('tamu'));
  }
  
  public function destroy($id) {
    $tamu = Tamu::findOrFail($id);
    $tamu->delete();
    return redirect()->route('bulanan.index')->with('success', 'Tamu deleted successfully');
  }
}

