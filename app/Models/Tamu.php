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
}