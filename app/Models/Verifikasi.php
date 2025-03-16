<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kost_id',
        'status', // Status verifikasi (pending, approved, rejected)
    ];

    // Relasi ke Kost
    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }
}
