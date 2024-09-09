<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class akun_tujuan extends Model
{
    protected $table = 'akun_tujuan';
    protected $fillable = [
        'id_akun',
        'email',
        'password',
        'nama',
        'jabatan',
        'no_hp',
        'photo',

    ];
}
