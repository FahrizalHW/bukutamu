<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidBase64Image implements ValidationRule
{
    private const MAX_BYTES = 2 * 1024 * 1024;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value)
            || ! preg_match('/^data:image\/(jpeg|png);base64,(.+)$/s', $value, $matches)) {
            $fail('Foto wajib diambil dari kamera dalam format JPEG atau PNG.');
            return;
        }

        $binary = base64_decode($matches[2], true);

        if ($binary === false || strlen($binary) > self::MAX_BYTES) {
            $fail('Foto tidak valid atau ukurannya melebihi 2 MB.');
            return;
        }

        $imageInfo = @getimagesizefromstring($binary);
        $declaredMime = $matches[1] === 'jpeg' ? 'image/jpeg' : 'image/png';

        if ($imageInfo === false
            || ! in_array($imageInfo['mime'], ['image/jpeg', 'image/png'], true)
            || $imageInfo['mime'] !== $declaredMime) {
            $fail('Isi foto tidak sesuai dengan format gambar yang diizinkan.');
        }
    }
}
