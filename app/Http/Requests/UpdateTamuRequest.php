<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTamuRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->role === User::ROLE_SUPERADMIN; }

    public function rules(): array
    {
        return [
            'nama_tamu' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['nullable', Rule::in(['L', 'P'])],
            'nohp' => ['required', 'string', 'max:15'],
            'asal' => ['required', 'string', 'max:255'],
            'tujuan' => ['required', 'string', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ];
    }
}
