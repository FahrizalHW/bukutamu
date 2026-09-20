<?php

namespace App\Services;

use App\Models\Tamu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Throwable;

class GuestVisitService
{
    public function store(array $validated, string $source): Tamu
    {
        $encodedImage = explode(';base64,', $validated['gambar'], 2)[1];
        $binaryImage = base64_decode($encodedImage, true);
        $fileName = Str::uuid().'.jpg';
        $path = 'visitor-photos/'.$fileName;
        $image = ImageManager::gd()->read($binaryImage)
            ->scaleDown(width: 1280, height: 1280)
            ->toJpeg(quality: 80);

        if (! Storage::disk('local')->put($path, (string) $image)) {
            throw new \RuntimeException('Foto gagal disimpan.');
        }

        unset($validated['gambar']);

        try {
            return Tamu::create([...$validated, 'gambar' => $fileName, 'sumber' => $source]);
        } catch (Throwable $exception) {
            Storage::disk('local')->delete($path);
            throw $exception;
        }
    }
}
