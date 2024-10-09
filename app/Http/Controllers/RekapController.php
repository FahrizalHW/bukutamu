<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tamu;

class RekapController extends Controller {
  
  public function index(Request $request) {
    $bulan = $request->query('bulan');
    if ($bulan) {
      // Mengambil data pengunjung berdasarkan bulan
      $visitor = Tamu::whereMonth('tanggal', $bulan)->get();
    } else {
      // Mengambil semua data jika tidak ada filter
      $visitor = Tamu::all();
    }
    return view('admin.index', compact('visitor'));
  }

  public function destroy(string $id) {
    //
  }
}
