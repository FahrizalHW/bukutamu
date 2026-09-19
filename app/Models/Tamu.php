<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model {
  use HasFactory;

  protected $table = 'tamu';

  protected $fillable = [
    'nama_tamu', 'jenis_kelamin', 'asal',
    'nohp', 'gambar', 'tujuan', 'keterangan',
  ];

  public $timestamps = false;

  protected $casts = [
    'tanggal' => 'datetime:Y-m-d H:i:s',
  ];

  public function scopeFiltered($query, array $filters) {
    return $query
      ->when($filters['search'] ?? null, function ($query, $search) {
        $query->where(function ($query) use ($search) {
          $query
            ->where('nama_tamu', 'like', "%{$search}%")
            ->orWhere('asal', 'like', "%{$search}%")
            ->orWhere('tujuan', 'like', "%{$search}%");
        });
      })
      ->when($filters['bulan'] ?? null, function ($query, $month) {
        [$year, $monthNumber] = array_pad(explode('-', $month, 2), 2, null);
        $query->whereYear('tanggal', $year)->whereMonth('tanggal', $monthNumber);
      })
      ->when(
        ! ($filters['bulan'] ?? null) && ($filters['tanggal_mulai'] ?? null),
        fn ($query) => $query->whereDate('tanggal', '>=', $filters['tanggal_mulai'])
      )
      ->when(
        ! ($filters['bulan'] ?? null) && ($filters['tanggal_selesai'] ?? null),
        fn ($query) => $query->whereDate('tanggal', '<=', $filters['tanggal_selesai'])
      );
  }
}
