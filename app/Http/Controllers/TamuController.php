<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTamuRequest;
use App\Models\Tamu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Throwable;

class TamuController extends Controller
{
    public function create(): View
    {
        return view('tamu.create');
    }

    public function store(StoreTamuRequest $request): RedirectResponse
    {
        $validated = $request->safe()->except('gambar');
        [, $encodedImage] = explode(';base64,', $request->validated('gambar'), 2);
        $binaryImage = base64_decode($encodedImage, true);
        $fileName = Str::uuid() . '.jpg';
        $path = 'visitor-photos/' . $fileName;

        $image = ImageManager::gd()
            ->read($binaryImage)
            ->scaleDown(width: 1280, height: 1280)
            ->toJpeg(quality: 80);

        if (! Storage::disk('local')->put($path, (string) $image)) {
            return back()->withInput()->with('error', 'Foto gagal disimpan. Silakan ambil foto kembali.');
        }

        try {
            Tamu::create([...$validated, 'gambar' => $fileName]);
        } catch (Throwable $exception) {
            Storage::disk('local')->delete($path);
            report($exception);

            return back()->withInput()->with('error', 'Data gagal disimpan. Silakan coba lagi.');
        }

        return redirect()->route('tamu.create')->with('success', 'Data kunjungan berhasil disimpan.');
    }
}
