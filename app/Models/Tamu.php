<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;

    protected $table = 'tamu';

    protected $fillable = [
        'nama_tamu',
        'jenis_kelamin',
        'asal',
        'nohp',
        'gambar',
        'tujuan',
        'keterangan',
    ];

    public $timestamps = false;

    protected $casts = [
        'tanggal' => 'datetime:Y-m-d H:i:s',
    ];

    public function scopeFiltered($query, array $filters)
    {
        return $query
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('nama_tamu', 'like', "%{$search}%")
                        ->orWhere('asal', 'like', "%{$search}%")
                        ->orWhere('nohp', 'like', "%{$search}%");
                });
            })
            ->when($filters['tanggal_mulai'] ?? null, fn ($query, $date) => $query->whereDate('tanggal', '>=', $date))
            ->when($filters['tanggal_selesai'] ?? null, fn ($query, $date) => $query->whereDate('tanggal', '<=', $date))
            ->when($filters['bulan'] ?? null, function ($query, $month) {
                [$year, $monthNumber] = array_pad(explode('-', $month, 2), 2, null);
                $query->whereYear('tanggal', $year)->whereMonth('tanggal', $monthNumber);
            })
            ->when(
                $filters['jenis_kelamin'] ?? null,
                fn ($query, $gender) => $query->where('jenis_kelamin', $gender)
            );
    }
}
