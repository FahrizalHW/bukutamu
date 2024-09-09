<?php


namespace App\Http\Controllers;

use App\Models\akun_tujuan;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class TamuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tamus = Tamu::all();
        return view('form.index', compact('tamus'));

    }
    public function index2()
    {
        
        $akunTujuans = akun_tujuan::all();

        // Pass data to the view
        return view('form.form', compact('akunTujuans'));
    }

    public function create()
    {
        return view('form.form');
    }

    public function store(Request $request)
{
    // Validasi data input dari form
    $validatedData = $request->validate([
        'nama_tamu' => 'required|string',
        'jenis_kelamin' => 'required|in:male,female',
        'nohp' => 'required|string',
        'asal' => 'required|string',
        'tujuan' => 'required|string',
        'keterangan' => 'required|string',
        'gambar' => 'required|string', // Mengasumsikan 'gambar' adalah input Base64 dari webcam
    ]);

    // Proses gambar dari Base64
    $img = $request->gambar;
    $folderPath = "uploads/";

    // Pisahkan base64 dengan tipe gambar
    $image_parts = explode(";base64,", $img);

    // Periksa apakah elemen yang diperlukan ada dalam array
    if (count($image_parts) == 2) {
        // Ambil tipe gambar (misal: png, jpg, dll.)
        $image_type_aux = explode("image/", $image_parts[0]);

        // Pastikan tipe gambar ditemukan, jika tidak beri nilai default
        $image_type = isset($image_type_aux[1]) ? $image_type_aux[1] : 'png';

        // Decode data Base64
        $image_base64 = base64_decode($image_parts[1]);

        // Buat nama file unik untuk gambar
        $fileName = uniqid() . '.' . $image_type;

        // Simpan gambar menggunakan Storage Laravel di folder "uploads"
        $filePath = $folderPath . $fileName;
        Storage::disk('public')->put($filePath, $image_base64);

        // Buat record tamu dengan data validasi dan path gambar
        Tamu::create(array_merge($validatedData, ['gambar' => $fileName]));

        // Redirect dengan pesan sukses
        return redirect()->route('tamu.index')->with('success', 'Record created successfully');
    } else {
        // Jika data Base64 tidak sesuai format, kembalikan error
        return redirect()->back()->with('error', 'Invalid image format.');
    }
}


    public function show($id)
    {
        $tamu = Tamu::find($id);
        return view('tamus.show', compact('tamu'));
    }

    public function edit($id)
    {
        $tamu = Tamu::find($id);
        return view('tamus.edit', compact('tamu'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            // Tambahkan validasi sesuai kebutuhan
        ]);

        Tamu::find($id)->update($request->all());

        return redirect()->route('tamu.index')->with('success', 'Tamu berhasil diperbarui');
    }

    public function destroy($id)
    {
        $tamu = Tamu::findOrFail($id);

        // Delete the Tamu record
        $tamu->delete();

        // Redirect back with a success message
        return redirect()->route('dasboard.ondex')->with('success', 'Tamu deleted successfully');
    }
    }



