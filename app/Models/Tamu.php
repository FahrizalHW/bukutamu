<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model {

  protected $table = 'tamu';
  protected $fillable = [
    'nama_tamu',
    'jenis_kelamin',
    'asal',
    'nohp',
    'gambar',
  ];
  public $timestamps = false;
  protected $casts = [
    'tanggal' => 'datetime:Y-m-d H:i:s'
  ];
  
  // Scope untuk filter berdasarkan bulan menggunakan kolom 'tanggal'
  public function scopeFilterByMonth($query, $bulan) {
    if ($bulan) {
      return $query->whereMonth('tanggal', $bulan);
    }
    return $query;
  }
}