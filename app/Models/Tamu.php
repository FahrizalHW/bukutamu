<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
  

    protected $table = 'tamu';
    protected $primaryKey = 'id';
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
        'tanggal' => 'datetime:Y-m-d H:i:s'
    ];
}