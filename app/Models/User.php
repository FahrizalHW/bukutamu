<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

  protected $fillable = [
    'full_name',
    'username',
    'password',
    'role',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'password' => 'hashed',
  ];
}
