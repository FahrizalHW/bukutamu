<?php

namespace App\Http\Controllers;

use App\Models\akun_tujuan;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TamuController extends Controller {
  
  public function index() {
    $visitor = Tamu::all();
    return view('tamu.index', compact('visitor'));
  }

  public function create() {
    return view('tamu.create');
  }
  
  public function store(Request $request) {
    // 1. Validasi data yang masuk dari permintaan
    $validatedData = $request->validate([
      'nama_tamu'      => 'required|string|max:255',
      'jenis_kelamin'  => 'nullable|string',
      'nohp'           => 'required|string|max:15', // Sesuaikan panjang maksimum sesuai kebutuhan
      'asal'           => 'required|string|max:255',
      'gambar'         => 'required|string', // Mengasumsikan 'gambar' adalah input Base64 dari webcam
    ]);
    // 2. Proses gambar Base64
    $img = $request->gambar;
    $folderPath = "uploads/"; // Tentukan folder untuk menyimpan gambar
    // 3. Pisahkan string Base64 untuk mendapatkan data gambar
    $image_parts = explode(";base64,", $img);
    // 4. Periksa apakah format valid
    if (count($image_parts) === 2) {
      // 4.1 Ambil tipe gambar (misal: png, jpg, dll.)
      $image_type_aux = explode("image/", $image_parts[0]);
      $image_type = isset($image_type_aux[1]) ? $image_type_aux[1] : 'png'; // Default ke png jika tidak ditemukan
      // 4.2 Decode string Base64 ke data biner
      $image_base64 = base64_decode($image_parts[1]);
      // 4.3 Buat nama file unik untuk gambar
      $fileName = uniqid() . '.' . $image_type;
      // 4.4 Simpan gambar di penyimpanan publik
      Storage::disk('public')->put($folderPath . $fileName, $image_base64);
      // 5. Buat record tamu baru di database
      Tamu::create(array_merge($validatedData, ['gambar' => $fileName]));
      // 6. Redirect kembali ke route index dengan pesan sukses
      return redirect()->route('tamu.create')->with('success', 'Data berhasil disimpan.');
    } else {
      // 7. Tangani format Base64 yang tidak valid
      return redirect()->back()->with('error', 'Format gambar tidak valid.');
    }
  }
}