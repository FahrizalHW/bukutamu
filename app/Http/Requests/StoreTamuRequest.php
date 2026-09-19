<?php

namespace App\Http\Requests;

use App\Rules\ValidBase64Image;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTamuRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nama_tamu' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['nullable', Rule::in(['L', 'P'])],
            'nohp' => ['required', 'string', 'max:15'],
            'asal' => ['required', 'string', 'max:255'],
            'tujuan' => ['required', 'string', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'gambar' => ['required', new ValidBase64Image()],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'max' => ':attribute maksimal :max karakter.',
            'jenis_kelamin.in' => 'Jenis kelamin yang dipilih tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_tamu' => 'Nama',
            'jenis_kelamin' => 'Jenis kelamin',
            'nohp' => 'Nomor HP',
            'asal' => 'Asal instansi',
            'tujuan' => 'Tujuan kunjungan',
            'keterangan' => 'Keterangan',
            'gambar' => 'Foto',
        ];
    }
}
