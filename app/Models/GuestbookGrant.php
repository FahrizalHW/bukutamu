<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestbookGrant extends Model
{
    protected $fillable = ['token_hash', 'session_hash', 'expires_at', 'used_at'];

    protected $hidden = ['token_hash', 'session_hash'];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function isAvailable(): bool
    {
        return $this->used_at === null && $this->expires_at->isFuture();
    }
}
